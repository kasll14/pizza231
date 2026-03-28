<?php
namespace Controllers;
use Views\OrderTemplate;
use Lib\User;
use Lib\DataLoader;
use Lib\Logger;
use Lib\Language;

class OrderController
{
    private array $orders = [];
    
    // Конфигурация email
    private const ADMIN_EMAIL = 'toni.maslennikov.08@inbox.ru';
    private const FROM_EMAIL = 'noreply@kemt.local';
    private const FROM_NAME = 'Geek LegendS';
    private const REPLY_TO = 'info@kemt.ru';
    
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $ordersFile = __DIR__ . '/../data/orders.json';
        if (file_exists($ordersFile)) {
            $this->orders = json_decode(file_get_contents($ordersFile), true) ?? [];
        }
    }
    
    public function checkout(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $cartItems = $_SESSION['cart'] ?? [];
        if (empty($cartItems)) {
            header('Location: /cart?error=empty_cart');
            exit;
        }
        return OrderTemplate::getCheckoutTemplate($cartItems);
    }
    
    public function process(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $cartItems = $_SESSION['cart'] ?? [];
        if (empty($cartItems)) {
            header('Location: /cart?error=empty_cart');
            exit;
        }
        
        // Получаем данные из формы
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $paymentMethod = $_POST['payment_method'] ?? 'card';
        $comment = trim($_POST['comment'] ?? '');
        
        // Валидация
        $errors = [];
        if (empty($name)) $errors[] = 'name';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'email';
        if (empty($phone)) $errors[] = 'phone';
        
        if (!empty($errors)) {
            $_SESSION['order_errors'] = $errors;
            $_SESSION['order_data'] = $_POST;
            header('Location: /cart/checkout');
            exit;
        }
        
        // Создаем заказ
        $orderId = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        $totalPrice = 0;
        
        if (\Lib\User::isLoggedIn()) {
            \Lib\User::linkOrderToUser($_SESSION['user_id'], $orderId);
        }
        
        foreach ($cartItems as $item) {
            $priceNum = (int)preg_replace('/[^0-9]/', '', $item['price']);
            $totalPrice += $priceNum;
        }
        
        $order = [
            'id' => $orderId,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'payment_method' => $paymentMethod,
            'comment' => $comment,
            'items' => $cartItems,
            'total' => $totalPrice,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_id' => null,
            'user_email' => null
        ];
        
        // 🔐 Привязка заказа к пользователю если авторизован
        if (User::isLoggedIn()) {
            $currentUser = User::getCurrentUser();
            $order['user_id'] = $currentUser['id'];
            $order['user_email'] = $currentUser['email'];
            
            // Обновляем данные пользователя если email изменился
            if ($currentUser['email'] !== $email) {
                User::updateUser($currentUser['id'], ['email' => $email]);
            }
        }
        
        // Сохраняем заказ
        $this->orders[] = $order;
        $ordersFile = __DIR__ . '/../data/orders.json';
        if (!is_dir(dirname($ordersFile))) {
            mkdir(dirname($ordersFile), 0755, true);
        }
        
        try {
            file_put_contents($ordersFile, json_encode($this->orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            
            // 📝 LOGGER: Логирование создания заказа
            Logger::info("Заказ успешно создан", [
                'order_id' => $orderId,
                'total' => $totalPrice,
                'user_id' => $order['user_id'] ?? 'guest',
                'email' => $email
            ]);
        } catch (\Exception $e) {
            // 📝 LOGGER: Логирование ошибки сохранения заказа
            Logger::error("Ошибка сохранения заказа", [
                'order_id' => $orderId,
                'exception' => $e->getMessage()
            ]);
            throw $e;
        }
        
        // Очищаем корзину
        $_SESSION['cart'] = [];
        unset($_SESSION['order_errors']);
        unset($_SESSION['order_data']);
        
        // 📧 ОТПРАВКА EMAIL
        $emailSent = $this->sendOrderEmail($order);
        $this->sendAdminNotification($order);
        
        // 📝 LOGGER: Логируем результат отправки email
        if (!$emailSent) {
            Logger::warning("Не удалось отправить email покупателю", [
                'order_id' => $orderId,
                'email' => $email
            ]);
        }
        
        header('Location: /cart/success?order=' . $orderId);
        exit;
    }
    
    public function success(): string
    {
        $orderId = $_GET['order'] ?? '';
        return OrderTemplate::getSuccessTemplate($orderId);
    }
    
    public function getOrders(): array
    {
        return $this->orders;
    }
    
    // ============================================================
    // 📧 МЕТОД 1: Отправка письма покупателю
    // ============================================================
    private function sendOrderEmail(array $order): bool
    {
        $to = $order['email'];
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            // 📝 LOGGER: Логирование невалидного email
            Logger::error("Невалидный email для отправки", ['email' => $to]);
            return false;
        }
        
        $subject = 'Заказ №' . $order['id'] . ' подтверждён - ' . self::FROM_NAME;
        $message = $this->buildCustomerEmailBody($order);
        $headers = $this->getEmailHeaders();
        
        $result = @mail($to, $subject, $message, $headers);
        return $result;
    }
    
    // ============================================================
    // 📧 МЕТОД 2: Отправка уведомления администратору
    // ============================================================
    private function sendAdminNotification(array $order): bool
    {
        $to = self::ADMIN_EMAIL;
        $subject = '🔔 НОВЫЙ ЗАКАЗ №' . $order['id'] . ' на сумму ' . number_format($order['total'], 0, '.', ' ') . ' ₽';
        $message = $this->buildAdminEmailBody($order);
        $headers = $this->getEmailHeaders();
        
        $result = @mail($to, $subject, $message, $headers);
        
        // 📝 LOGGER: Логирование отправки уведомления админу
        Logger::debug("Уведомление администратору", [
            'order_id' => $order['id'],
            'sent' => $result
        ]);
        
        return $result;
    }
    
    // ============================================================
    // 📧 МЕТОД 3: Заголовки для всех писем
    // ============================================================
    private function getEmailHeaders(): string
    {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: " . self::FROM_NAME . " <" . self::FROM_EMAIL . ">" . "\r\n";
        $headers .= "Reply-To: " . self::REPLY_TO . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "X-Priority: 3" . "\r\n";
        return $headers;
    }
    
    // ============================================================
    // 📧 МЕТОД 4: HTML-шаблон письма для покупателя
    // ============================================================
    private function buildCustomerEmailBody(array $order): string
    {
        // 🌐 LANG: Получаем текущий язык пользователя
        $lang = Language::getCurrentLang();
        
        // 🌐 LANG: Вспомогательная функция для получения текста на нужном языке
        $getText = function($field, $default = '') use ($lang) {
            if (is_array($field)) {
                return $field[$lang] ?? $field['ru'] ?? $default;
            }
            return $field;
        };
        
        $itemsHtml = '';
        foreach ($order['items'] as $item) {
            // 🌐 LANG: Получаем название и длительность курса на нужном языке
            $courseTitle = $getText($item['title'], $item['title']);
            $courseDuration = $getText($item['duration'], $item['duration']);
            
            $itemsHtml .= '
<tr>
    <td style="padding: 12px 8px; border-bottom: 1px solid #e2e8f0;">
        <strong>' . htmlspecialchars($courseTitle) . '</strong>
    </td>
    <td style="padding: 12px 8px; border-bottom: 1px solid #e2e8f0; color: #718096;">
        ' . htmlspecialchars($courseDuration) . '
    </td>
    <td style="padding: 12px 8px; border-bottom: 1px solid #e2e8f0; text-align: right;">
        <strong>' . htmlspecialchars($item['price']) . '</strong>
    </td>
</tr>';
        }
        
        $paymentMethods = [
            'card' => 'Банковской картой онлайн',
            'sbp' => 'СБП (Система быстрых платежей)',
            'invoice' => 'Счёт для юридического лица'
        ];
        $paymentText = $paymentMethods[$order['payment_method']] ?? $order['payment_method'];
        
        return '
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ №' . $order['id'] . '</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f7fafc;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; width: 100%; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background: linear-gradient(135deg, #2c5282 0%, #1a365d 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">✓ Заказ подтверждён</h1>
                            <p style="margin: 10px 0 0 0; color: rgba(255,255,255,0.9); font-size: 16px;">
                                Спасибо за покупку, ' . htmlspecialchars($order['name']) . '!
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px;">
                            <table role="presentation" style="width: 100%; background: #ebf4ff; border-radius: 8px; padding: 20px;">
                                <tr>
                                    <td>
                                        <p style="margin: 0 0 10px 0; color: #2c5282; font-size: 14px; font-weight: 600;">📋 ИНФОРМАЦИЯ О ЗАКАЗЕ</p>
                                        <p style="margin: 5px 0; color: #2d3748; font-size: 15px;">
                                            <strong>№ заказа:</strong> ' . $order['id'] . '
                                        </p>
                                        <p style="margin: 5px 0; color: #2d3748; font-size: 15px;">
                                            <strong>Дата:</strong> ' . date('d.m.Y H:i', strtotime($order['created_at'])) . '
                                        </p>
                                        <p style="margin: 5px 0; color: #2d3748; font-size: 15px;">
                                            <strong>Оплата:</strong> ' . $paymentText . '
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0 30px 30px 30px;">
                            <h3 style="margin: 0 0 15px 0; color: #2d3748; font-size: 18px; font-weight: 600;">📚 Ваши курсы:</h3>
                            <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="background: #f7fafc;">
                                        <th style="padding: 12px 8px; text-align: left; color: #2c5282; font-size: 14px; border-bottom: 2px solid #2c5282;">Курс</th>
                                        <th style="padding: 12px 8px; text-align: left; color: #2c5282; font-size: 14px; border-bottom: 2px solid #2c5282;">Длительность</th>
                                        <th style="padding: 12px 8px; text-align: right; color: #2c5282; font-size: 14px; border-bottom: 2px solid #2c5282;">Цена</th>
                                    </tr>
                                </thead>
                                <tbody>' . $itemsHtml . '</tbody>
                            </table>
                            <table role="presentation" style="width: 100%; margin-top: 20px;">
                                <tr>
                                    <td style="text-align: right; padding: 15px; background: #2c5282; border-radius: 8px; color: #ffffff;">
                                        <span style="font-size: 16px; margin-right: 10px;">Итого к оплате:</span>
                                        <span style="font-size: 24px; font-weight: 700;">' . number_format($order['total'], 0, '.', ' ') . ' ₽</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0 30px 30px 30px;">
                            <h3 style="margin: 0 0 15px 0; color: #2d3748; font-size: 18px; font-weight: 600;">📞 Контакты для связи:</h3>
                            <table role="presentation" style="width: 100%;">
                                <tr>
                                    <td style="padding: 8px 0; color: #4a5568;">
                                        <strong>Телефон:</strong>
                                        <a href="tel:+73842396000" style="color: #2c5282; text-decoration: none;">+7 (3842) 39-60-00</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #4a5568;">
                                        <strong>Email:</strong>
                                        <a href="mailto:info@kemt.ru" style="color: #2c5282; text-decoration: none;">info@kemt.ru</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #4a5568;">
                                        <strong>Адрес:</strong> г. Кемерово, ул. Тухачевского, 32а
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0 30px 40px 30px; text-align: center;">
                            <a href="https://kemt.local/cart/success?order=' . $order['id'] . '"
                                style="display: inline-block; background: #2c5282; color: #ffffff; padding: 14px 40px; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">
                                Открыть заказ на сайте
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #1a365d; padding: 25px 30px; text-align: center;">
                            <p style="margin: 0; color: rgba(255,255,255,0.8); font-size: 14px;">
                                © ' . date('Y') . ' ' . self::FROM_NAME . '. Все права защищены.
                            </p>
                            <p style="margin: 10px 0 0 0; color: rgba(255,255,255,0.6); font-size: 12px;">
                                Это письмо отправлено автоматически, пожалуйста, не отвечайте на него.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
    }
    
    // ============================================================
    // 📧 МЕТОД 5: HTML-шаблон письма для админа
    // ============================================================
    private function buildAdminEmailBody(array $order): string
    {
        // 🌐 LANG: Получаем текущий язык
        $lang = Language::getCurrentLang();
        
        // 🌐 LANG: Вспомогательная функция для получения текста на нужном языке
        $getText = function($field, $default = '') use ($lang) {
            if (is_array($field)) {
                return $field[$lang] ?? $field['ru'] ?? $default;
            }
            return $field;
        };
        
        $itemsHtml = '';
        foreach ($order['items'] as $item) {
            // 🌐 LANG: Получаем название курса на нужном языке
            $courseTitle = $getText($item['title'], $item['title']);
            
            $itemsHtml .= '<li style="padding: 5px 0; color: #2d3748;">
                ' . htmlspecialchars($courseTitle) . ' — <strong>' . htmlspecialchars($item['price']) . '</strong>
            </li>';
        }
        
        $userInfo = '';
        if (!empty($order['user_id'])) {
            $userInfo = '<p style="background: #ebf4ff; padding: 15px; border-radius: 6px; margin-top: 15px;">
                <strong>Зарегистрированный пользователь</strong><br>
                ID: ' . $order['user_id'] . '
            </p>';
        }
        
        return '
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background: #f7fafc;">
    <table role="presentation" style="width: 100%;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; width: 100%; background: #ffffff; border-radius: 8px; overflow: hidden;">
                    <tr>
                        <td style="background: #e53e3e; padding: 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px;">🔔 Новый заказ</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px;">
                            <table role="presentation" style="width: 100%;">
                                <tr>
                                    <td style="padding: 8px 0;">
                                        <strong>№ заказа:</strong> ' . $order['id'] . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0;">
                                        <strong>Клиент:</strong> ' . htmlspecialchars($order['name']) . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0;">
                                        <strong>Email:</strong> <a href="mailto:' . htmlspecialchars($order['email']) . '">' . htmlspecialchars($order['email']) . '</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0;">
                                        <strong>Телефон:</strong> <a href="tel:' . htmlspecialchars($order['phone']) . '">' . htmlspecialchars($order['phone']) . '</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0;">
                                        <strong>Сумма:</strong> ' . number_format($order['total'], 0, '.', ' ') . ' ₽
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0;">
                                        <strong>Оплата:</strong> ' . $order['payment_method'] . '
                                    </td>
                                </tr>
                            </table>
                            ' . $userInfo . '
                            <h3 style="color: #2d3748; margin-top: 20px;">Курсы:</h3>
                            <ul style="padding-left: 20px; margin: 10px 0;">' . $itemsHtml . '</ul>
                            ' . (!empty($order['comment']) ? '
                            <p style="background: #f7fafc; padding: 15px; border-radius: 6px; margin-top: 15px;">
                                <strong>Комментарий:</strong><br>
                                ' . htmlspecialchars($order['comment']) . '
                            </p>' : '') . '
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
    }
}