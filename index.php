<?php
session_start();

use Lib\Language;

spl_autoload_register(function ($class) {
    $class = ltrim($class, '\\');
    if (strpos($class, 'Lib\\') === 0) {
        $fileName = __DIR__ . '/Lib/' . substr($class, 4) . '.php';
        if (file_exists($fileName)) { require $fileName; return; }
    }
    if (strpos($class, 'Controllers\\') === 0) {
        $fileName = __DIR__ . '/Controllers/' . substr($class, 12) . '.php';
        if (file_exists($fileName)) { require $fileName; return; }
    }
    if (strpos($class, 'Views\\') === 0) {
        $fileName = __DIR__ . '/Views/' . substr($class, 6) . '.php';
        if (file_exists($fileName)) { require $fileName; return; }
    }
});

Language::init();

if (isset($_GET['lang']) && in_array($_GET['lang'], ['ru', 'en'])) {
    $_SESSION['lang'] = $_GET['lang'];
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    header('Location: ' . $uri);
    exit;
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    // 🔐 ДОБАВЛЕНО: Маршруты для подтверждения кодом
    case '/auth/verify-code':
        $controller = new Controllers\AuthController();
        echo $controller->verifyCode();
        break;
    case '/auth/resend-code':
        $controller = new Controllers\AuthController();
        $controller->resendCode();
        break;
    
    // === СУЩЕСТВУЮЩИЕ МАРШРУТЫ ===
    case '/auth/register':
        $controller = new Controllers\AuthController();
        echo $controller->register();
        break;
    case '/auth/login':
        $controller = new Controllers\AuthController();
        echo $controller->login();
        break;
    case '/auth/logout':
        $controller = new Controllers\AuthController();
        $controller->logout();
        break;
    case '/auth/forgot-password':
        $controller = new Controllers\AuthController();
        echo $controller->forgotPassword();
        break;
    case '/auth/reset-password':
        $controller = new Controllers\AuthController();
        echo $controller->resetPassword();
        break;
    case '/profile':
        $controller = new Controllers\ProfileController();
        echo $controller->index();
        break;
    case '/profile/edit':
        $controller = new Controllers\ProfileController();
        echo $controller->edit();
        break;
    case '/profile/orders':
        $controller = new Controllers\ProfileController();
        echo $controller->orders();
        break;
    case '/admin':
        $controller = new Controllers\AdminController();
        echo $controller->index();
        break;
    case '/admin/orders':
        $controller = new Controllers\AdminController();
        echo $controller->orders();
        break;
    case '/admin/order':
        $controller = new Controllers\AdminController();
        echo $controller->orderDetail();
        break;
    case '/admin/order/update':
        $controller = new Controllers\AdminController();
        $controller->updateOrderStatus();
        break;
    case '/admin/users':
        $controller = new Controllers\AdminController();
        echo $controller->users();
        break;
    case '/admin/user/delete':
        $controller = new Controllers\AdminController();
        $controller->deleteUser();
        break;
    case '/':
    case '/home':
        $controller = new Controllers\HomeController();
        echo $controller->get();
        break;
    case '/courses':
        $controller = new Controllers\CoursesController();
        echo $controller->get();
        break;
    case '/about':
        $controller = new Controllers\AboutController();
        echo $controller->get();
        break;
    case '/cart':
        $controller = new Controllers\CartController();
        echo $controller->view();
        break;
    case '/cart/add':
        $controller = new Controllers\CartController();
        $controller->add();
        break;
    case '/cart/remove':
        $controller = new Controllers\CartController();
        $controller->remove();
        break;
    case '/cart/clear':
        $controller = new Controllers\CartController();
        $controller->clear();
        break;
    case '/cart/count':
        $controller = new Controllers\CartController();
        $controller->getCountJson();
        break;
    case '/cart/checkout':
        $controller = new Controllers\CartController();
        $controller->checkout();
        break;
    case '/cart/order':
        $controller = new Controllers\CartController();
        $controller->order();
        break;
    case '/cart/success':
        $controller = new Controllers\CartController();
        $controller->success();
        break;
    default:
        if (preg_match('#^/course/(\d+)$#', $uri, $matches)) {
            $controller = new Controllers\CourseController((int)$matches[1]);
            echo $controller->get();
        } else {
            $controller = new Controllers\ErrorController();
            http_response_code(404);
            echo $controller->get();
        }
        break;
}