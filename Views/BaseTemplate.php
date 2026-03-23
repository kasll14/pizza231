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
}
</style>
</head>
<body>
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
</body>
</html>';
}
}