<?php
define('SITE_URL', 'http://localhost');
define('SITE_NAME', 'Frutiger Aero Courses');
define('SENDMAIL_PATH', 'C:\\xampp\\sendmail\\sendmail.exe');

// Настройки фонового изображения
define('BG_IMAGE_PATH', '/assets/images/background.png');
define('BG_IMAGE_BLUR', 4);           // Размытие в пикселях (0-20)
define('BG_IMAGE_OVERLAY_COLOR', '255, 255, 255'); // RGB цвет оверлея
define('BG_IMAGE_OVERLAY_OPACITY', 0.42); // Прозрачность оверлея (0-1)
define('BG_IMAGE_SCALE', 1.0);        // Масштаб изображения (для компенсации размытия)

// Настройки стеклянных панелей (Glassmorphism)
define('GLASS_ENABLED', true);         // Включить стеклянный эффект
define('GLASS_STYLE', 'full');      // 'full' - полная панель, 'contour' - контур
define('GLASS_CONTOUR_WIDTH', 0);      // Ширина стеклянного контура в px (8px)
define('GLASS_CONTOUR_BLUR', 0);      // Размытие контура (0-20px)
define('GLASS_BORDER_COLOR', '200, 200, 200'); // RGB цвет контура
define('GLASS_BORDEROpacity', 0.0);    // Прозрачность контура (0-1)
define('GLASS_INNER_BG', '255, 255, 255'); // RGB цвет внутреннего фона
define('GLASS_INNER_OPACITY',0.0);   // Прозрачность внутреннего фона (0-1)
define('GLASS_SHADOW_COLOR', '0, 150, 150'); // RGB цвет тени
define('GLASS_SHADOW_OPACITY', 0.50);  // Прозрачность тени (0-1)
define('GLASS_RADIUS', 30);            // Радиус скругления (px)
?>
