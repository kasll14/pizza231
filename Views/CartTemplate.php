<?php
namespace Views;
class CartTemplate extends BaseTemplate
{
public static function getTemplate(): string
{
$template = parent::getTemplate();
$title = 'Корзина - CodeStart Academy';
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
$cartItems = $_SESSION['cart'] ?? [];
$cartCount = count($cartItems);
$successMessage = '';
$errorMessage = '';
if (isset($_GET['success'])) {
switch ($_GET['success']) {
case 'added':
$successMessage = '✅ Курс успешно добавлен в корзину';
break;
case 'removed':
$successMessage = '✅ Курс удалён из корзины';
break;
case 'cleared':
$successMessage = '✅ Корзина очищена';
break;
}
}
if (isset($_GET['error'])) {
switch ($_GET['error']) {
case 'not_found':
$errorMessage = '❌ Курс не найден в корзине';
break;
case 'invalid_course':
$errorMessage = '❌ Неверный ID курса';
break;
}
}
$customStyles = '
<style>
.cart-container {
background: #fff;
border-radius: 20px;
padding: 2rem;
box-shadow: 0 10px 40px rgba(99,102,241,0.1);
}
.cart-item {
display: flex;
align-items: center;
padding: 1.5rem;
border: 1px solid #eef2f7;
border-radius: 15px;
margin-bottom: 1rem;
background: #f8fafc;
}
.cart-item-icon {
font-size: 3rem;
width: 80px;
height: 80px;
display: flex;
align-items: center;
justify-content: center;
background: linear-gradient(135deg, #e0e7ff, #f0f4ff);
border-radius: 50%;
margin-right: 1.5rem;
}
.cart-item-info {
flex: 1;
}
.cart-item-title {
font-size: 1.2rem;
font-weight: 700;
color: #1e293b;
margin-bottom: 0.5rem;
}
.cart-item-duration {
color: #64748b;
font-size: 0.9rem;
}
.cart-item-price {
font-size: 1.5rem;
font-weight: 800;
color: #6366f1;
margin-right: 2rem;
}
.cart-item-remove {
background: #ef4444;
color: white;
border: none;
padding: 0.5rem 1rem;
border-radius: 10px;
cursor: pointer;
transition: all 0.3s ease;
}
.cart-item-remove:hover {
background: #dc2626;
}
.cart-summary {
background: linear-gradient(135deg, #6366f1, #8b5cf6);
border-radius: 20px;
padding: 2rem;
color: white;
margin-top: 2rem;
}
.cart-total {
font-size: 2.5rem;
font-weight: 800;
margin: 1rem 0;
}
.btn-checkout {
background: #fff;
color: #6366f1;
border: none;
padding: 1rem 3rem;
font-size: 1.2rem;
font-weight: 700;
border-radius: 50px;
cursor: pointer;
transition: all 0.3s ease;
text-decoration: none;
display: inline-block;
}
.btn-checkout:hover {
transform: translateY(-3px);
box-shadow: 0 10px 30px rgba(255,255,255,0.3);
color: #6366f1;
text-decoration: none;
}
.cart-empty {
text-align: center;
padding: 4rem 2rem;
}
.cart-empty-icon {
font-size: 5rem;
margin-bottom: 1rem;
opacity: 0.5;
}
.alert-success {
background: #d1fae5;
color: #065f46;
padding: 1rem;
border-radius: 10px;
margin-bottom: 1.5rem;
border: 1px solid #a7f3d0;
}
.alert-error {
background: #fee2e2;
color: #991b1b;
padding: 1rem;
border-radius: 10px;
margin-bottom: 1.5rem;
border: 1px solid #fecaca;
}
.cart-count {
background: #ef4444;
color: white;
border-radius: 50%;
padding: 0.2rem 0.5rem;
font-size: 0.75rem;
margin-left: 0.5rem;
}
</style>';
$cartItemsHtml = '';
$totalPrice = 0;
if ($cartCount > 0) {
foreach ($cartItems as $item) {
$priceNum = (int)preg_replace('/[^0-9]/', '', $item['price']);
$totalPrice += $priceNum;
$cartItemsHtml .= '
<div class="cart-item">
<div class="cart-item-icon">' . $item['icon'] . '</div>
<div class="cart-item-info">
<div class="cart-item-title">' . htmlspecialchars($item['title']) . '</div>
<div class="cart-item-duration">📅 ' . htmlspecialchars($item['duration']) . '</div>
</div>
<div class="cart-item-price">' . htmlspecialchars($item['price']) . '</div>
<form method="POST" action="/cart/remove" style="display:inline;">
<input type="hidden" name="courseId" value="' . $item['id'] . '">
<button type="submit" class="cart-item-remove">🗑️ Удалить</button>
</form>
</div>';
}
$cartItemsHtml .= '
<div class="cart-summary">
<h3 class="mb-3">📊 Итого</h3>
<div class="d-flex justify-content-between align-items-center">
<span>Курсов в корзине:</span>
<span class="fw-bold">' . $cartCount . ' шт.</span>
</div>
<div class="cart-total">' . number_format($totalPrice, 0, '.', ' ') . ' ₽</div>
<div class="text-center mt-4">
<a href="/cart/checkout" class="btn-checkout">
✅ Оформить заказ
</a>
<p class="small mt-3 opacity-75">Менеджер свяжется с вами в течение 15 минут</p>
</div>
</div>
<div class="text-center mt-4">
<form method="POST" action="/cart/clear" style="display:inline;">
<button type="submit" class="btn btn-outline-danger" onclick="return confirm(\'Вы уверены, что хотите очистить корзину?\');">
🗑️ Очистить корзину
</button>
</form>
</div>';
} else {
$cartItemsHtml = '
<div class="cart-empty">
<div class="cart-empty-icon">🛒</div>
<h3 class="fw-bold mb-3">Ваша корзина пуста</h3>
<p class="text-muted mb-4">Добавьте курсы для начала обучения</p>
<a href="/courses" class="btn btn-primary btn-lg rounded-pill px-5">
📚 Перейти к курсам
</a>
</div>';
}
$alertHtml = '';
if ($successMessage) {
$alertHtml = '<div class="alert-success">' . $successMessage . '</div>';
}
if ($errorMessage) {
$alertHtml = '<div class="alert-error">' . $errorMessage . '</div>';
}
$content = $customStyles . '
<section class="container py-5">
<h1 class="display-5 fw-bold text-center mb-4">🛒 Ваша корзина</h1>
' . $alertHtml . '
<div class="cart-container">
' . $cartItemsHtml . '
</div>
</section>';
return str_replace(['{{TITLE}}', '{{CONTENT}}'], [$title, $content], $template);
}
}