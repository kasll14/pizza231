<?php 
// Подсчитываем корзину для меню
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
    /* Background from config */
    body::before {
        content: '';
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: url('<?php echo BG_IMAGE_PATH; ?>') no-repeat center center;
        background-size: cover;
        filter: blur(<?php echo BG_IMAGE_BLUR; ?>px);
        -webkit-filter: blur(<?php echo BG_IMAGE_BLUR; ?>px);
        z-index: -2;
        transform: scale(<?php echo BG_IMAGE_SCALE; ?>);
    }
    body::after {
        content: '';
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(<?php echo BG_IMAGE_OVERLAY_COLOR; ?>, <?php echo BG_IMAGE_OVERLAY_OPACITY; ?>);
        z-index: -1;
    }
    /* Glass panels: white inside, glass contour border */
    <?php if (GLASS_ENABLED): ?>
    .glass-container, .course-card, .table-container, .cart-item,
    .about-content, .admin-sidebar, .stat-card, .form-container, .modal-content {
        background: rgba(<?php echo GLASS_INNER_BG; ?>, <?php echo GLASS_INNER_OPACITY; ?>);
        backdrop-filter: blur(<?php echo GLASS_CONTOUR_BLUR; ?>px);
        -webkit-backdrop-filter: blur(<?php echo GLASS_CONTOUR_BLUR; ?>px);
        border: <?php echo GLASS_CONTOUR_WIDTH; ?>px solid rgba(<?php echo GLASS_BORDER_COLOR; ?>, <?php echo GLASS_BORDEROpacity; ?>);
        border-top-color: rgba(<?php echo GLASS_BORDER_COLOR; ?>, <?php echo min(1, GLASS_BORDEROpacity + 0.2); ?>);
        border-left-color: rgba(<?php echo GLASS_BORDER_COLOR; ?>, <?php echo min(1, GLASS_BORDEROpacity + 0.1); ?>);
        border-radius: <?php echo GLASS_RADIUS; ?>px;
        box-shadow: 
            0 8px 32px rgba(<?php echo GLASS_SHADOW_COLOR; ?>, <?php echo GLASS_SHADOW_OPACITY; ?>),
            0 2px 8px rgba(<?php echo GLASS_SHADOW_COLOR; ?>, <?php echo GLASS_SHADOW_OPACITY * 0.5; ?>),
            inset 0 0 0 1px rgba(255,255,255,0.5);
        position: relative;
        overflow: hidden;
    }
    /* Inner glow line for depth */
    .glass-container::after, .course-card::after, .table-container::after,
    .cart-item::after, .about-content::after, .admin-sidebar::after,
    .stat-card::after, .form-container::after, .modal-content::after {
        content: '';
        position: absolute;
        top: <?php echo GLASS_CONTOUR_WIDTH; ?>px;
        left: <?php echo GLASS_CONTOUR_WIDTH; ?>px;
        right: <?php echo GLASS_CONTOUR_WIDTH; ?>px;
        height: 40%;
        background: linear-gradient(180deg, 
            rgba(255,255,255,0.8) 0%, 
            rgba(255,255,255,0.2) 50%, 
            transparent 100%);
        border-radius: <?php echo max(0, GLASS_RADIUS - GLASS_CONTOUR_WIDTH); ?>px <?php echo max(0, GLASS_RADIUS - GLASS_CONTOUR_WIDTH); ?>px 0 0;
        pointer-events: none;
        z-index: 1;
    }
    <?php endif; ?>
    </style>
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
                        <li><a href="<?php echo SITE_URL; ?>/profile">Профиль</a></li>
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
