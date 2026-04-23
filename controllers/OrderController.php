<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once 'models/Order.php';

class OrderController {
    private $order;

    public function __construct() {
        $database = new Database();
        $this->order = new Order($database->getConnection());
    }

    public function checkout() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . SITE_URL . '/login');
            exit;
        }
        
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            header('Location: ' . SITE_URL . '/cart');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderNumber = 'ORD-' . date('Ymd') . '-' . rand(1000, 9999);
            $total = $this->calculateTotal();
            
            $this->order->user_id = $_SESSION['user_id'];
            $this->order->order_number = $orderNumber;
            $this->order->total_amount = $total;
            $this->order->status = 'pending';
            $this->order->created_at = date('Y-m-d H:i:s');
            
            if ($this->order->create()) {
                $this->saveOrderItems($orderNumber);
                $this->sendOrderEmail($orderNumber, $total);
                $this->logActivity("Создан заказ: $orderNumber");
                
                unset($_SESSION['cart']);
                header('Location: ' . SITE_URL . '/order/success/' . $orderNumber);
                exit;
            }
        }
        
        $cartItems = $this->getCartItems();
        $total = $this->calculateTotal();
        require_once dirname(__DIR__) . '/views/order/checkout.php';
    }

    public function success($orderNumber) {
        $order = $this->order->getByNumber($orderNumber);
        require_once dirname(__DIR__) . '/views/order/success.php';
    }

    private function getCartItems() {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            return [];
        }
        
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare("SELECT * FROM courses WHERE id IN (" . implode(',', array_map('intval', $_SESSION['cart'])) . ")");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function calculateTotal() {
        $items = $this->getCartItems();
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'];
        }
        return $total;
    }

    private function saveOrderItems($orderNumber) {
        $database = new Database();
        $conn = $database->getConnection();
        
        foreach ($_SESSION['cart'] as $courseId) {
            $stmt = $conn->prepare("INSERT INTO order_items (order_number, course_id, price) 
                                    SELECT ?, id, price FROM courses WHERE id = ?");
            $stmt->execute([$orderNumber, $courseId]);
        }
    }

    private function sendOrderEmail($orderNumber, $total) {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $to = $user['email'];
            $subject = "Подтверждение заказа №" . $orderNumber;
            $message = "Спасибо за ваш заказ!\n\n";
            $message .= "Номер заказа: " . $orderNumber . "\n";
            $message .= "Сумма: " . $total . " руб.\n\n";
            $message .= "Мы получили ваш заказ и скоро с вами свяжемся.";
            $headers = "From: noreply@frutiger-courses.ru\r\n";
            
            mail($to, $subject, $message, $headers);
        }
    }

    private function logActivity($message) {
        $logFile = dirname(__DIR__) . '/logs/access.log';
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[$timestamp] ORDER - $message\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
}
?>
