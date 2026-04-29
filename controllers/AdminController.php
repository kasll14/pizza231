<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once 'models/User.php';
require_once 'models/Order.php';

class AdminController {
    private $user;
    private $order;

    public function __construct() {
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            header('Location: ' . SITE_URL . '/');
            exit;
        }
        
        $database = new Database();
        $this->user = new User($database->getConnection());
        $this->order = new Order($database->getConnection());
    }

    public function index() {
        $section = $_GET['section'] ?? 'dashboard';
        
        switch ($section) {
            case 'users':
                $this->manageUsers();
                break;
            case 'orders':
                $this->manageOrders();
                break;
            case 'courses':
                $this->manageCourses();
                break;
            case 'logs':
                $this->viewLogs();
                break;
            default:
                $this->dashboard();
        }
    }

    private function dashboard() {
        $totalUsers = $this->user->count();
        $totalOrders = $this->order->count();
        $totalCourses = $this->getTotalCourses();
        $recentOrders = $this->order->getRecent(10);
        
        require_once dirname(__DIR__) . '/views/admin/dashboard.php';
    }

    private function manageUsers() {
        $users = $this->user->getAll();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['toggle_admin'])) {
                $this->user->toggleAdmin($_POST['user_id']);
                $this->logActivity("Изменены права пользователя ID: " . $_POST['user_id']);
            } elseif (isset($_POST['delete_user'])) {
                $this->user->delete($_POST['user_id']);
                $this->logActivity("Удален пользователь ID: " . $_POST['user_id']);
            }
            header('Location: ' . SITE_URL . '/admin/users');
            exit;
        }
        
        require_once dirname(__DIR__) . '/views/admin/manage_users.php';
    }

    private function manageOrders() {
        $orders = $this->order->getAll();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['update_status'])) {
                $this->order->updateStatus($_POST['order_id'], $_POST['status']);
                $this->logActivity("Обновлен статус заказа ID: " . $_POST['order_id']);
            }
            header('Location: ' . SITE_URL . '/admin/orders');
            exit;
        }
        
        require_once dirname(__DIR__) . '/views/admin/manage_orders.php';
    }

    private function manageCourses() {
        $courses = $this->getAllCourses();
        require_once dirname(__DIR__) . '/views/admin/manage_courses.php';
    }

    private function viewLogs() {
        $logFile = dirname(__DIR__) . '/logs/access.log';
        $logs = [];
        
        if (file_exists($logFile)) {
            $content = file_get_contents($logFile);
            $logs = array_reverse(explode("\n", $content));
            $logs = array_filter($logs);
        }
        
        require_once dirname(__DIR__) . '/views/admin/logs.php';
    }

    private function getTotalCourses() {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->query("SELECT COUNT(*) FROM courses");
        return $stmt->fetchColumn();
    }

    private function getAllCourses() {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->query("SELECT * FROM courses ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function logActivity($message) {
        $logFile = dirname(__DIR__) . '/logs/access.log';
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[$timestamp] ADMIN - $message\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
}
?>
