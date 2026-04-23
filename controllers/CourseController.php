<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once 'models/Course.php';

class CourseController {
    private $course;

    public function __construct() {
        $database = new Database();
        $this->course = new Course($database->getConnection());
    }

    public function home() {
        $courses = $this->course->getAll();
        $cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
        require_once dirname(__DIR__) . '/views/home.php';
    }

    public function index() {
        $courses = $this->course->getAll();
        require_once dirname(__DIR__) . '/views/courses/index.php';
    }

    public function show($id) {
        $course = $this->course->getById($id);
        require_once dirname(__DIR__) . '/views/courses/show.php';
    }
        
    public function create() {
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            header('Location: ' . SITE_URL . '/');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->course->title = $_POST['title'];
            $this->course->description = $_POST['description'];
            $this->course->price = $_POST['price'];
            $this->course->image = $_POST['image'] ?? 'default.jpg';
            $this->course->created_at = date('Y-m-d H:i:s');
            
            if ($this->course->create()) {
                $this->logActivity("Создан новый курс: " . $_POST['title']);
                header('Location: ' . SITE_URL . '/admin/courses');
                exit;
            }
        }
        require_once dirname(__DIR__) . '/views/admin/create_course.php';
    }

    public function update($id) {
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            header('Location: ' . SITE_URL . '/');
            exit;
        }
        
        $course = $this->course->getById($id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->course->id = $id;
            $this->course->title = $_POST['title'];
            $this->course->description = $_POST['description'];
            $this->course->price = $_POST['price'];
            $this->course->image = $_POST['image'] ?? $course['image'];
            
            if ($this->course->update()) {
                $this->logActivity("Обновлен курс ID: $id");
                header('Location: ' . SITE_URL . '/admin/courses');
                exit;
            }
        }
        require_once dirname(__DIR__) . '/views/admin/edit_course.php';
    }

    public function delete($id) {
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            header('Location: ' . SITE_URL . '/');
            exit;
        }
        
        $course = $this->course->getById($id);
        if ($this->course->delete($id)) {
            $this->logActivity("Удален курс: " . $course['title']);
        }
        header('Location: ' . SITE_URL . '/admin/courses');
        exit;
    }

    private function logActivity($message) {
        $logFile = dirname(__DIR__) . '/logs/access.log';
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[$timestamp] ADMIN - $message\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
}
?>
