<?php
require_once __DIR__ . '/vendor/autoload.php';

use Controllers\{HomeController, AboutController, CoursesController, CourseController};

$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);
$resource = trim($path, '/');
$resource = preg_replace('/[^a-zA-Z0-9\-_\/]/', '', $resource);

if (preg_match('/^course\/(\d+)$/', $resource, $matches)) {
    $courseId = (int)$matches[1];
    if ($courseId >= 1 && $courseId <= 6) {
        $controller = new CourseController($courseId);
        echo $controller->get();
    } else {
        http_response_code(404);
        echo '<h1>Курс не найден</h1>';
    }
    exit;
}

switch ($resource) {
    case '':
    case 'home':
        $controller = new HomeController();
        echo $controller->get();
        break;
    case 'courses':
        $controller = new CoursesController();
        echo $controller->get();
        break;
    case 'about':
        $controller = new AboutController();
        echo $controller->get();
        break;
    default:
        http_response_code(404);
        echo '<h1>Страница не найдена</h1>';
        break;
}