<?php
require_once __DIR__ . '/vendor/autoload.php';

// Автозагрузка для Lib
spl_autoload_register(function ($class) {
    if (strpos($class, 'Lib\\') === 0) {
        $file = __DIR__ . '/lib/' . str_replace('\\', '/', substr($class, 4)) . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});

use Controllers\{HomeController, AboutController, CoursesController, CourseController, CartController};

$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);
$resource = trim($path, '/');
$resource = preg_replace('/[^a-zA-Z0-9\-_\/]/', '', $resource);

// Маршруты корзины
if ($resource === 'cart/add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new CartController();
    $controller->add();
    exit;
}
if ($resource === 'cart/remove' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new CartController();
    $controller->remove();
    exit;
}
if ($resource === 'cart/clear' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new CartController();
    $controller->clear();
    exit;
}
if ($resource === 'cart/count' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new CartController();
    $controller->getCountJson();
    exit;
}
if ($resource === 'cart/checkout' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new CartController();
    $controller->checkout();
    exit;
}
if ($resource === 'cart/order' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new CartController();
    $controller->order();
    exit;
}
if ($resource === 'cart/success' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new CartController();
    $controller->success();
    exit;
}

// Маршрут курса
if (preg_match('/^course\/(\d+)$/', $resource, $matches)) {
    $courseId = (int)$matches[1];
    if ($courseId >= 1 && $courseId <= 100) {
        $controller = new CourseController($courseId);
        echo $controller->get();
    } else {
        http_response_code(404);
        echo '<h1>Курс не найден</h1>';
    }
    exit;
}

// Основные маршруты
switch ($resource) {
    case '':
    case 'home':
        $controller = new HomeController();
        echo $controller->get();
        break;
    case 'courses':
    case 'course':
        $controller = new CoursesController();
        echo $controller->get();
        break;
    case 'about':
        $controller = new AboutController();
        echo $controller->get();
        break;
    case 'cart':
        $controller = new CartController();
        echo $controller->view();
        break;
    default:
        http_response_code(404);
        $controller = new \Controllers\ErrorController();
        echo $controller->get();
        break;
}