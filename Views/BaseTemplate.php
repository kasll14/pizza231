<?php
namespace Views;
// 🌐 LANG: Добавлен импорт Language
use Lib\Language;

class BaseTemplate
{
    public static function getTemplate(): string
    {
        // 🌐 LANG: Инициализация языка
        Language::init();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $cartCount = count($_SESSION['cart'] ?? []);
        $cartBadge = $cartCount > 0 ? '<span class="cart-count">' . $cartCount . '</span>' : '';
        
        // 🌐 LANG: Получение текущего языка
        $currentLang = Language::getCurrentLang();
        
        // 🌐 LANG: Генерация переключателя языков
        $langSwitcher = self::getLanguageSwitcher($currentLang);
        
        // 🌐 LANG: Получение переводов
        $toastAdded = Language::get('toast_added');
        $toastError = Language::get('toast_error');
        $toastNetwork = Language::get('toast_network');
        $navHome = Language::get('nav_home');
        $navCourses = Language::get('nav_courses');
        $navAbout = Language::get('nav_about');
        $navCart = Language::get('nav_cart');
        $siteBrand = Language::get('site_brand');
        $footerSiteName = Language::get('site_name');
        $footerDescription = Language::get('site_description');
        $footerContactTitle = Language::get('contact_title');
        $footerScheduleTitle = Language::get('contact_schedule');
        $footerScheduleValue = Language::get('contact_schedule_value');
        $footerCopyright = Language::get('copyright');
        
        return '
<!DOCTYPE html>
<!-- 🌐 LANG: Установлен язык страницы -->
<html lang="' . $currentLang . '">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{TITLE}}</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
--primary: #2c5282;
--primary-dark: #1a365d;
--secondary: #4a5568;
--background: #f7fafc;
--surface: #ffffff;
--text: #2d3748;
--text-muted: #718096;
--border: #e2e8f0;
--success: #38a169;
--danger: #e53e3e;
}
body {
font-family: "Inter", system-ui, -apple-system, sans-serif;
color: var(--text);
background: var(--background);
line-height: 1.6;
}
.navbar {
background: var(--surface) !important;
border-bottom: 1px solid var(--border);
padding: 1rem 0;
}
.navbar-brand {
font-weight: 700;
color: var(--text) !important;
font-size: 1.25rem;
}
.nav-link {
color: var(--text) !important;
font-weight: 500;
margin: 0 0.5rem;
transition: color 0.2s;
}
.nav-link:hover, .nav-link.active {
color: var(--primary) !important;
}
.cart-count {
background: var(--danger);
color: white;
border-radius: 50%;
padding: 0.15rem 0.45rem;
font-size: 0.7rem;
font-weight: 600;
position: absolute;
top: -4px;
right: -8px;
min-width: 18px;
text-align: center;
}
/* 🌐 LANG: Стили для переключателя языков */
.lang-switcher {
display: flex;
align-items: center;
gap: 0.5rem;
margin-left: 1rem;
}
.lang-switcher a {
padding: 0.25rem 0.5rem;
border-radius: 4px;
text-decoration: none;
font-size: 0.85rem;
font-weight: 500;
color: var(--text-muted);
transition: all 0.2s;
}
.lang-switcher a:hover {
color: var(--primary);
background: var(--background);
}
.lang-switcher a.active {
color: var(--primary);
background: #ebf4ff;
font-weight: 600;
}
.lang-divider {
color: var(--border);
}
.toast-container {
position: fixed;
top: 20px;
right: 20px;
z-index: 9999;
}
.toast-notification {
background: var(--success);
color: white;
border-radius: 8px;
padding: 1rem 1.25rem;
box-shadow: 0 4px 12px rgba(0,0,0,0.15);
display: none;
animation: slideIn 0.3s ease;
font-weight: 500;
}
.toast-notification.show {
display: flex;
align-items: center;
gap: 0.75rem;
}
.toast-close {
background: none;
border: none;
color: white;
font-size: 1.25rem;
cursor: pointer;
opacity: 0.9;
margin-left: 0.5rem;
}
.toast-close:hover { opacity: 1; }
@keyframes slideIn {
from { transform: translateX(100%); opacity: 0; }
to { transform: translateX(0); opacity: 1; }
}
footer {
background: var(--primary-dark);
color: rgba(255,255,255,0.85);
padding: 2.5rem 0 1.5rem;
margin-top: 4rem;
}
footer a { color: rgba(255,255,255,0.9); text-decoration: none; }
footer a:hover { color: white; }
.btn-primary {
background: var(--primary);
border-color: var(--primary);
font-weight: 500;
padding: 0.625rem 1.5rem;
border-radius: 6px;
}
.btn-primary:hover {
background: var(--primary-dark);
border-color: var(--primary-dark);
}
.container { max-width: 1200px; }
</style>
</head>
<body>
<div class="toast-container">
<div class="toast-notification" id="cartToast">
<span id="toastMessage">' . $toastAdded . '</span>
<button class="toast-close" onclick="hideToast()">×</button>
</div>
</div>
<nav class="navbar navbar-expand-lg">
<div class="container">
<a class="navbar-brand" href="/">
' . $siteBrand . '
</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav ms-auto">
<li class="nav-item"><a class="nav-link" href="/home">' . $navHome . '</a></li>
<li class="nav-item"><a class="nav-link" href="/courses">' . $navCourses . '</a></li>
<li class="nav-item"><a class="nav-link" href="/about">' . $navAbout . '</a></li>
<li class="nav-item">
<a class="nav-link" href="/cart" style="position: relative;">
' . $navCart . '
' . $cartBadge . '
</a>
</li>
<!-- 🌐 LANG: Переключатель языков -->
<li class="nav-item">
<div class="lang-switcher">
' . $langSwitcher . '
</div>
</li>
</ul>
</div>
</div>
</nav>
<main>{{CONTENT}}</main>
<footer>
<div class="container">
<div class="row g-4">
<div class="col-lg-4">
<h5 class="fw-bold text-white mb-3">' . $footerSiteName . '</h5>
<p class="small mb-0">' . $footerDescription . '</p>
</div>
<div class="col-lg-4">
<h6 class="fw-bold text-white mb-3">' . $footerContactTitle . '</h6>
<p class="small mb-1">650066, г. Кемерово, ул. Тухачевского, 32а</p>
<p class="small mb-1">
<a href="tel:+73842396000">+7 (3842) 39-60-00</a>
</p>
<p class="small mb-0">
<a href="mailto:info@kemt.ru">info@kemt.ru</a>
</p>
</div>
<div class="col-lg-4">
<h6 class="fw-bold text-white mb-3">' . $footerScheduleTitle . '</h6>
<p class="small mb-0">' . $footerScheduleValue . '</p>
</div>
</div>
<hr class="my-4" style="border-color: rgba(255,255,255,0.15);">
<p class="small text-center mb-0">
&copy; ' . date('Y') . ' ' . $footerSiteName . '. ' . $footerCopyright . '
</p>
</div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function showToast(message, duration) {
duration = duration || 3000;
var toast = document.getElementById("cartToast");
var toastMessage = document.getElementById("toastMessage");
toastMessage.textContent = message;
toast.classList.add("show");
setTimeout(function() { hideToast(); }, duration);
}
function hideToast() {
document.getElementById("cartToast").classList.remove("show");
}
function updateCartCount(count) {
var badge = document.querySelector(".cart-count");
var cartLink = document.querySelector("a[href=\"/cart\"]");
if (count > 0) {
if (!badge) {
var newBadge = document.createElement("span");
newBadge.className = "cart-count";
newBadge.textContent = count;
cartLink.appendChild(newBadge);
} else {
badge.textContent = count;
}
} else if (badge) {
badge.remove();
}
}
document.addEventListener("DOMContentLoaded", function() {
var forms = document.querySelectorAll("form[action=\"/cart/add\"]");
forms.forEach(function(form) {
form.addEventListener("submit", function(e) {
e.preventDefault();
var formData = new FormData(this);
fetch("/cart/add", {
method: "POST",
body: formData,
headers: {
"X-Requested-With": "XMLHttpRequest"
}
})
.then(function(response) {
if (response.ok) {
showToast("' . $toastAdded . '");
fetch("/cart/count").then(function(r) { return r.json(); }).then(function(data) {
updateCartCount(data.count);
});
} else {
showToast("' . $toastError . '");
}
}).catch(function() { showToast("' . $toastNetwork . '"); });
});
});
});
</script>
</body>
</html>';
    }
    
    // 🌐 LANG: Новый метод для генерации переключателя языков
    private static function getLanguageSwitcher(string $currentLang): string
    {
        $langs = ['ru', 'en'];
        $html = '';
        
        foreach ($langs as $lang) {
            $activeClass = ($lang === $currentLang) ? 'active' : '';
            $langName = Language::getLangName($lang);
            $html .= '<a href="?lang=' . $lang . '" class="' . $activeClass . '">' . $langName . '</a>';
            
            if ($lang !== end($langs)) {
                $html .= '<span class="lang-divider">|</span>';
            }
        }
        
        return $html;
    }
}