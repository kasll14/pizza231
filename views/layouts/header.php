<?php 
// Подключение к корневого уровня
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(dirname(__DIR__)));
    require_once BASE_PATH . '/config/config.php';
}
if (!defined('SITE_URL')) {
    define('SITE_URL', 'http://localhost');
}
// Подсчитываем корзину для меню
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
</head>
<body>
    <div class="animated-background"></div>
    <div class="cursor-glow" id="cursorGlow"></div>
    <div class="arc-glare-container" id="arcGlareContainer"></div>
    
    <header class="header">
        <div class="header-content">
            <div class="logo"><?php echo SITE_NAME; ?></div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="<?php echo SITE_URL; ?>/">Главная</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/courses">Курсы</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/about">О нас</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="<?php echo SITE_URL; ?>/cart">Корзина</a><span class="cart-badge"><?php echo $cartCount ?? 0; ?></span></li>
                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                            <li><a href="<?php echo SITE_URL; ?>/admin">Админ-панель</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo SITE_URL; ?>/logout">Выход</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo SITE_URL; ?>/login">Вход</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/register">Регистрация</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    
    <main class="main-content">
