<?php
// Включить отображение ошибок для отладки
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Определение базового пути
define('BASE_PATH', __DIR__);

// Подключение конфигов
require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/config/database.php';

// Простой роутер
$request = $_SERVER['REQUEST_URI'];
$baseUri = '/';

if (strpos($request, $baseUri) === 0) {
    $request = substr($request, strlen($baseUri));
}

$request = parse_url($request, PHP_URL_PATH);

// Очистка запроса
$request = '/' . ltrim($request, '/');
$request = rtrim($request, '/');
if (empty($request) || $request === '/') {
    $request = '/';
}

// Особые маршруты с дефисами (проверяем до общей обработки)
$specialRoutes = ['/verify-registration', '/cart-action', '/order/checkout', '/order/success'];
$matchedSpecial = false;
foreach ($specialRoutes as $special) {
    if (strpos($request, $special) === 0) {
        $request = $special;
        $matchedSpecial = true;
        break;
    }
}
        
// Подсчитываем корзину для меню
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

// Маршрутизация
try {
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
        
    case '/register':
        require_once BASE_PATH . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;
        
    case '/verify-registration':
        require_once BASE_PATH . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->verifyRegistration();
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
        
    case '/admin/courses':
        require_once BASE_PATH . '/controllers/AdminController.php';
        $controller = new AdminController();
        $_GET['section'] = 'courses';
        $controller->index();
        break;
        
    case '/admin/users':
        require_once BASE_PATH . '/controllers/AdminController.php';
        $controller = new AdminController();
        $_GET['section'] = 'users';
        $controller->index();
        break;
        
    case '/admin/orders':
        require_once BASE_PATH . '/controllers/AdminController.php';
        $controller = new AdminController();
        $_GET['section'] = 'orders';
        $controller->index();
        break;
        
    case '/admin/logs':
        require_once BASE_PATH . '/controllers/AdminController.php';
        $controller = new AdminController();
        $_GET['section'] = 'logs';
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
            header('Location: ' . SITE_URL . '/admin/courses');
        }
        break;
        
    case '/admin/delete-course':
        $id = $_GET['id'] ?? null;
        if ($id) {
            require_once BASE_PATH . '/controllers/CourseController.php';
            $controller = new CourseController();
            $controller->delete($id);
        } else {
            header('Location: ' . SITE_URL . '/admin/courses');
        }
        break;
        
    default:
        http_response_code(404);
        echo '<h1>404 - Страница не найдена</h1>';
        echo '<p><a href="' . SITE_URL . '/">На главную</a></p>';
    }
} catch (Exception $e) {
    echo '<h1>Ошибка</h1>';
    echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
}
?>
