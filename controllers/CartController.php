<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/database.php';

class CartController {
    public function index() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $cartItems = $this->getCartItems();
        $total = $this->calculateTotal($cartItems);
        require_once dirname(__DIR__) . '/views/cart/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseId = $_POST['course_id'];
            
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            
            if (!in_array($courseId, $_SESSION['cart'])) {
                $_SESSION['cart'][] = $courseId;
            }
            
            header('Location: ' . SITE_URL . '/course?id=' . $courseId);
            exit;
        }
    }

    public function remove() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseId = $_POST['course_id'];
            $key = array_search($courseId, $_SESSION['cart']);
            if ($key !== false) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
            }
        }
        header('Location: ' . SITE_URL . '/cart');
        exit;
    }

    public function clear() {
        $_SESSION['cart'] = [];
        header('Location: ' . SITE_URL . '/cart');
        exit;
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

    private function calculateTotal($items) {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'];
        }
        return $total;
    }
}
?>
