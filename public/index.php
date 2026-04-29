<?php
session_start();

// Определение базового пути
define('BASE_PATH', dirname(__DIR__));
define('SITE_URL', 'http://localhost/online-courses');

// Подключение конфигур
require_once BASE_PATH . '/config/config.php';

// Простой роутер
$request = $_SERVER['REQUEST_URI'];
$baseUri = '/online-courses';

if (strpos($request, $baseUri) === 0) {
    $request = substr($request, strlen($baseUri));
}

$request = parse_url($request, PHP_URL_PATH);

// Очистка запроса
$request = rtrim($request, '/');
if (empty($request)) {
    $request = '/';
}

// Подсчитываем корзину для меню
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

// Маршрутизация
switch ($request) {
    case '/':
        require_once BASE_PATH . '/controllers/CourseController.php';
        $controller = new CourseController();
        $controller->home();
        break;
        
    case '/login':
        require_once BASE_PATH . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;
        
    case '/verify':
        require_once BASE_PATH . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->verify();
        break;
        
    case '/logout':
        require_once BASE_PATH . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;
        
    case '/courses':
        require_once BASE_PATH . '/controllers/CourseController.php';
        $controller = new CourseController();
        $controller->index();
        break;
        
    case '/course':
        $id = $_GET['id'] ?? null;
        if ($id) {
            require_once BASE_PATH . '/controllers/CourseController.php';
            $controller = new CourseController();
            $controller->show($id);
        } else {
            header('Location: ' . SITE_URL . '/courses');
        }
        break;
        
    case '/cart':
        require_once BASE_PATH . '/controllers/CartController.php';
        $controller = new CartController();
        $controller->index();
        break;
        
    case '/cart-action':
        require_once BASE_PATH . '/controllers/CartController.php';
        $controller = new CartController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            if ($action === 'add') $controller->add();
            elseif ($action === 'remove') $controller->remove();
            elseif ($action === 'clear') $controller->clear();
        }
        break;
        
    case '/order/checkout':
        require_once BASE_PATH . '/controllers/OrderController.php';
        $controller = new OrderController();
        $controller->checkout();
        break;
        
    case '/order/success':
        $orderNumber = $_GET['order_number'] ?? null;
        if ($orderNumber) {
            require_once BASE_PATH . '/controllers/OrderController.php';
            $controller = new OrderController();
            $controller->success($orderNumber);
        } else {
            header('Location: ' . SITE_URL . '/');
        }
        break;
        
    case '/about':
        require_once BASE_PATH . '/views/about.php';
        break;
        
    case '/admin':
        require_once BASE_PATH . '/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->index();
        break;
        
    case '/admin/create-course':
        require_once BASE_PATH . '/controllers/CourseController.php';
        $controller = new CourseController();
        $controller->create();
        break;
        
    case '/admin/update-course':
        $id = $_GET['id'] ?? null;
        if ($id) {
            require_once BASE_PATH . '/controllers/CourseController.php';
            $controller = new CourseController();
            $controller->update($id);
        } else {
            header('Location: ' . SITE_URL . '/admin?section=courses');
        }
        break;
        
    case '/admin/delete-course':
        $id = $_GET['id'] ?? null;
        if ($id) {
            require_once BASE_PATH . '/controllers/CourseController.php';
            $controller = new CourseController();
            $controller->delete($id);
        } else {
            header('Location: ' . SITE_URL . '/admin?section=courses');
        }
        break;
        
    default:
        http_response_code(404);
        echo '<h1>404 - Страница не найдена</h1>';
        echo '<p><a href="' . SITE_URL . '/">На главную</a></p>';
}
?>
