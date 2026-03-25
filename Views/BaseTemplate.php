<?php
namespace Views;
class BaseTemplate
{
public static function getTemplate(): string
{
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
$cartCount = count($_SESSION['cart'] ?? []);
$cartBadge = $cartCount > 0 ? '<span class="cart-count">' . $cartCount . '</span>' : '';
return '
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{TITLE}}</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
.cart-count {
background: #ef4444;
color: white;
border-radius: 50%;
padding: 0.2rem 0.5rem;
font-size: 0.75rem;
margin-left: 0.5rem;
position: absolute;
top: 0;
right: 0;
}
/* Toast уведомление */
.toast-container {
position: fixed;
top: 20px;
right: 20px;
z-index: 9999;
}
.toast-notification {
background: linear-gradient(135deg, #10b981, #059669);
color: white;
border-radius: 15px;
padding: 1rem 1.5rem;
box-shadow: 0 10px 40px rgba(16,185,129,0.3);
display: none;
animation: slideIn 0.3s ease;
}
.toast-notification.show {
display: flex;
align-items: center;
gap: 1rem;
}
.toast-notification .toast-icon {
font-size: 1.5rem;
}
.toast-notification .toast-message {
flex: 1;
font-weight: 600;
}
.toast-notification .toast-close {
background: none;
border: none;
color: white;
font-size: 1.2rem;
cursor: pointer;
opacity: 0.8;
}
.toast-notification .toast-close:hover {
opacity: 1;
}
@keyframes slideIn {
from {
transform: translateX(100%);
opacity: 0;
}
to {
transform: translateX(0);
opacity: 1;
}
}
@keyframes slideOut {
from {
transform: translateX(0);
opacity: 1;
}
to {
transform: translateX(100%);
opacity: 0;
}
}
</style>
</head>
<body>
<!-- Toast контейнер -->
<div class="toast-container">
<div class="toast-notification" id="cartToast">
<span class="toast-icon">✅</span>
<span class="toast-message" id="toastMessage">Товар добавлен в корзину</span>
<button class="toast-close" onclick="hideToast()">×</button>
</div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
<div class="container">
<a class="navbar-brand fw-bold" href="/">
<span style="font-size: 1.5rem;">💻</span> CodeStart Academy
</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav ms-auto">
<li class="nav-item"><a class="nav-link" href="/home">Главная</a></li>
<li class="nav-item"><a class="nav-link" href="/courses">Курсы</a></li>
<li class="nav-item"><a class="nav-link" href="/about">О школе</a></li>
<li class="nav-item">
<a class="nav-link" href="/cart" style="position: relative;">
🛒 Корзина
' . $cartBadge . '
</a>
</li>
</ul>
</div>
</div>
</nav>
<div class="container mt-4">{{CONTENT}}</div>
<footer class="text-center py-4 mt-5" style="background: #1e293b; color: #fff;">
<div class="container">
<p class="mb-1">© 2024 CodeStart Academy — Онлайн-школа программирования</p>
<p class="small text-muted mb-0">📧 contact@codestart.academy | 🌍 Онлайн + Санкт-Петербург</p>
</div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Функция показа уведомления
function showToast(message, duration = 3000) {
const toast = document.getElementById("cartToast");
const toastMessage = document.getElementById("toastMessage");
toastMessage.textContent = message;
toast.classList.add("show");
setTimeout(() => {
hideToast();
}, duration);
}
// Функция скрытия уведомления
function hideToast() {
const toast = document.getElementById("cartToast");
toast.classList.remove("show");
}
// Обновление счётчика корзины
function updateCartCount(count) {
const badge = document.querySelector(".cart-count");
const cartLink = document.querySelector(\'a[href="/cart"]\');
if (count > 0) {
if (!badge) {
const newBadge = document.createElement("span");
newBadge.className = "cart-count";
newBadge.textContent = count;
cartLink.appendChild(newBadge);
} else {
badge.textContent = count;
}
} else {
if (badge) {
badge.remove();
}
}
}
// Обработка форм добавления в корзину
document.addEventListener("DOMContentLoaded", function() {
document.querySelectorAll(\'form[action="/cart/add"]\').forEach(form => {
form.addEventListener("submit", function(e) {
e.preventDefault();
const formData = new FormData(this);
fetch("/cart/add", {
method: "POST",
body: formData
})
.then(response => {
if (response.ok) {
showToast("✅ Курс успешно добавлен в корзину!");
// Обновляем счётчик
fetch("/cart/count")
.then(r => r.json())
.then(data => updateCartCount(data.count))
.catch(() => {});
} else {
showToast("❌ Ошибка при добавлении в корзину");
}
})
.catch(error => {
showToast("❌ Ошибка сети");
});
});
});
});
</script>
</body>
</html>';
}
}