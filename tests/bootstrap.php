<?php
// tests/bootstrap.php

// Инициализация тестовой сессии
if (session_status() === PHP_SESSION_NONE) {
    session_name('TEST_SESSION');
    session_start();
    $_SESSION = [];
}

// Автозагрузка классов
spl_autoload_register(function ($class) {
    $class = ltrim($class, '\\');
    
    if (strpos($class, 'Tests\\') === 0) {
        $fileName = __DIR__ . '/' . str_replace('\\', '/', substr($class, 6)) . '.php';
        if (file_exists($fileName)) {
            require $fileName;
            return;
        }
    }
    
    if (strpos($class, 'Controllers\\') === 0) {
        $fileName = __DIR__ . '/../Controllers/' . substr($class, 12) . '.php';
        if (file_exists($fileName)) {
            require $fileName;
            return;
        }
    }
    
    if (strpos($class, 'Lib\\') === 0) {
        $fileName = __DIR__ . '/../Lib/' . substr($class, 4) . '.php';
        if (file_exists($fileName)) {
            require $fileName;
            return;
        }
    }
    
    if (strpos($class, 'Views\\') === 0) {
        $fileName = __DIR__ . '/../Views/' . substr($class, 6) . '.php';
        if (file_exists($fileName)) {
            require $fileName;
            return;
        }
    }
});

// Подключение основных файлов
require_once __DIR__ . '/../Lib/Logger.php';
require_once __DIR__ . '/../Lib/User.php';
require_once __DIR__ . '/../Lib/Auth.php';
require_once __DIR__ . '/../Lib/Language.php';
require_once __DIR__ . '/../Lib/DataLoader.php';

// Очистка тестовых данных после завершения
function cleanupTestData(): void {
    // Восстанавливаем оригинальные данные если были изменены
    $testFiles = [
        __DIR__ . '/../data/users_test.php',
        __DIR__ . '/../data/orders_test.json',
    ];
    foreach ($testFiles as $file) {
        if (file_exists($file)) {
            @unlink($file);
        }
    }
}

register_shutdown_function('cleanupTestData');

// Глобальная функция для сброса сессии между тестами
function resetSession(): void {
    $_SESSION = [];
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
        session_name('TEST_SESSION');
        session_start();
    }
}