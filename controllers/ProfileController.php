<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once 'models/User.php';
require_once 'models/Order.php';

class ProfileController {
    private $user;
    private $order;

    public function __construct() {
        $database = new Database();
        $this->user = new User($database->getConnection());
        $this->order = new Order($database->getConnection());
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . SITE_URL . '/login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $userData = $this->user->getById($userId);
        $orders = $this->order->getByUserId($userId);

        // Получаем детали заказов с курсами
        $orderDetails = [];
        foreach ($orders as $order) {
            $details = $this->getOrderItems($order['order_number']);
            $order['items'] = $details;
            $orderDetails[] = $order;
        }

        require_once dirname(__DIR__) . '/views/profile.php';
    }

    private function getOrderItems($orderNumber) {
        $database = new Database();
        $conn = $database->getConnection();
        
        $stmt = $conn->prepare("SELECT oi.*, c.title, c.description 
                                FROM order_items oi 
                                LEFT JOIN courses c ON oi.course_id = c.id 
                                WHERE oi.order_number = ?");
        $stmt->execute([$orderNumber]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . SITE_URL . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $login = trim($_POST['login']);
            
            $error = null;
            $success = null;

            // Валидация
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Неверный формат email";
            } elseif (strlen($login) < 3) {
                $error = "Логин должен быть не менее 3 символов";
            } else {
                // Проверка, не занят ли email/логин другим пользователем
                $existingUser = $this->user->getByEmail($email);
                if ($existingUser && $existingUser['id'] != $userId) {
                    $error = "Email уже используется";
                } else {
                    $existingUser = $this->user->getByLogin($login);
                    if ($existingUser && $existingUser['id'] != $userId) {
                        $error = "Логин уже занят";
                    } else {
                        // Обновление данных
                        $query = "UPDATE users SET email = ?, login = ? WHERE id = ?";
                        $database = new Database();
                        $conn = $database->getConnection();
                        $stmt = $conn->prepare($query);
                        
                        if ($stmt->execute([$email, $login, $userId])) {
                            $success = "Профиль успешно обновлён";
                            $_SESSION['user_email'] = $email;
                            $_SESSION['user_login'] = $login;
                        } else {
                            $error = "Ошибка обновления профиля";
                        }
                    }
                }
            }

            // Перезагружаем данные
            $userData = $this->user->getById($userId);
            $orders = $this->order->getByUserId($userId);
            
            $orderDetails = [];
            foreach ($orders as $order) {
                $details = $this->getOrderItems($order['order_number']);
                $order['items'] = $details;
                $orderDetails[] = $order;
            }

            require_once dirname(__DIR__) . '/views/profile.php';
        }
    }

    public function changePassword() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . SITE_URL . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            $error = null;
            $success = null;

            // Проверка текущего пароля
            $user = $this->user->getById($userId);
            if (!password_verify($currentPassword, $user['password'])) {
                $error = "Неверный текущий пароль";
            } elseif (strlen($newPassword) < 6) {
                $error = "Новый пароль должен быть не менее 6 символов";
            } elseif ($newPassword !== $confirmPassword) {
                $error = "Пароли не совпадают";
            } else {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $query = "UPDATE users SET password = ? WHERE id = ?";
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare($query);
                
                if ($stmt->execute([$hashedPassword, $userId])) {
                    $success = "Пароль успешно изменён";
                    $this->logActivity("Смена пароля для пользователя: " . $user['email']);
                } else {
                    $error = "Ошибка смены пароля";
                }
            }

            // Перезагружаем данные
            $userData = $this->user->getById($userId);
            $orders = $this->order->getByUserId($userId);
            
            $orderDetails = [];
            foreach ($orders as $order) {
                $details = $this->getOrderItems($order['order_number']);
                $order['items'] = $details;
                $orderDetails[] = $order;
            }

            require_once dirname(__DIR__) . '/views/profile.php';
        }
    }

    private function logActivity($message) {
        $logFile = dirname(__DIR__) . '/logs/access.log';
        $timestamp = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $logEntry = "[$timestamp] IP: $ip - $message\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
}
?>
