<?php
namespace Views;
class HomeTemplate extends BaseTemplate
{
public static function getTemplate(): string
{
$template = parent::getTemplate();
$title = 'Главная - CodeStart Academy | IT-курсы с нуля до трудоустройства';
$servicesUrl = '/courses';
$customStyles = '
<style>
.hero-carousel .carousel-item {
height: 550px;
background-color: #000;
}
.hero-carousel img {
height: 100%;
object-fit: cover;
opacity: 0.6;
}
.hero-caption {
bottom: 20%;
text-shadow: 0 2px 10px rgba(0,0,0,0.5);
}
.hero-caption h5 {
font-size: 3rem;
font-weight: 800;
color: #fff;
margin-bottom: 1rem;
}
.feature-card {
border: none;
border-radius: 20px;
background: #fff;
padding: 2rem 1.5rem;
text-align: center;
height: 100%;
transition: all 0.3s ease;
box-shadow: 0 5px 15px rgba(0,0,0,0.05);
border: 1px solid #f0f2f5;
}
.feature-card:hover {
transform: translateY(-8px);
box-shadow: 0 15px 30px rgba(99, 110, 253, 0.15);
border-color: #6366f1;
}
.feature-icon-lg {
font-size: 3.5rem;
margin-bottom: 1.5rem;
display: inline-block;
background: linear-gradient(135deg, #e0e7ff 0%, #f0f4ff 100%);
width: 90px;
height: 90px;
line-height: 90px;
border-radius: 50%;
color: #6366f1;
transition: transform 0.3s ease;
}
.feature-card:hover .feature-icon-lg {
transform: scale(1.1) rotate(5deg);
background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
color: #fff;
}
.promo-banner {
background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
border-radius: 25px;
padding: 3rem;
color: white;
text-align: center;
box-shadow: 0 15px 30px rgba(99, 102, 241, 0.3);
margin: 4rem 0;
position: relative;
overflow: hidden;
}
.promo-banner::before {
content: "🎁";
position: absolute;
top: -20px;
right: -20px;
font-size: 10rem;
opacity: 0.1;
transform: rotate(15deg);
}
.btn-hero {
padding: 15px 40px;
font-size: 1.1rem;
border-radius: 50px;
font-weight: 700;
transition: all 0.3s ease;
text-decoration: none;
display: inline-block;
}
.btn-hero-primary {
background: #6366f1;
border: none;
color: white;
box-shadow: 0 5px 15px rgba(99, 102, 241, 0.4);
}
.btn-hero-outline {
background: transparent;
border: 2px solid #fff;
color: #fff;
}
.btn-hero-outline:hover {
background: #fff;
color: #6366f1;
transform: translateY(-3px);
text-decoration: none;
}
.education-badge {
background: #f8f9fa;
border-left: 4px solid #6366f1;
padding: 1.5rem;
border-radius: 0 10px 10px 0;
font-size: 0.9rem;
color: #6c757d;
margin-top: 3rem;
}
</style>';
$content = $customStyles . '
<section class="container-fluid p-0 mb-5">
<div id="mainCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
<div class="carousel-indicators">
<button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
<button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
<button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
</div>
<div class="carousel-inner">
<div class="carousel-item active">
<img src="/assets/images/img1.jpg" onerror="this.src=\'https://placehold.co/1920x1080/6366f1/ffffff?text=Python\'" class="d-block w-100" alt="Python">
<div class="carousel-caption d-none d-md-block hero-caption">
<h5>Python-разработчик</h5>
<p>Освой самый популярный язык программирования</p>
<a href="' . $servicesUrl . '#python" class="btn btn-hero btn-hero-outline mt-3">Начать обучение</a>
</div>
</div>
<div class="carousel-item">
<img src="/assets/images/img2.jpg" onerror="this.src=\'https://placehold.co/1920x1080/8b5cf6/ffffff?text=Frontend\'" class="d-block w-100" alt="Frontend">
<div class="carousel-caption d-none d-md-block hero-caption">
<h5>Frontend: React</h5>
<p>Создавай современные веб-интерфейсы</p>
<a href="' . $servicesUrl . '#react" class="btn btn-hero btn-hero-outline mt-3">Выбрать курс</a>
</div>
</div>
<div class="carousel-item">
<img src="/assets/images/img3.jpg" onerror="this.src=\'https://placehold.co/1920x1080/06b6d4/ffffff?text=Data+Science\'" class="d-block w-100" alt="Data Science">
<div class="carousel-caption d-none d-md-block hero-caption">
<h5>Machine Learning</h5>
<p>Нейросети и искусственный интеллект</p>
<a href="' . $servicesUrl . '#ml" class="btn btn-hero btn-hero-outline mt-3">Узнать больше</a>
</div>
</div>
</div>
<button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
<span class="carousel-control-prev-icon" aria-hidden="true"></span>
<span class="visually-hidden">Предыдущий</span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
<span class="carousel-control-next-icon" aria-hidden="true"></span>
<span class="visually-hidden">Следующий</span>
</button>
</div>
</section>
<main class="container py-4">
<div class="row justify-content-center text-center mb-5">
<div class="col-lg-9">
<span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill">Работаем с 2020 года</span>
<h2 class="display-5 fw-bold text-dark mb-4">💻 CodeStart Academy</h2>
<p class="lead text-muted">
Мы готовим IT-специалистов с нуля до трудоустройства уже более 4 лет.
Надежность, проверенная тысячами выпускников.
</p>
</div>
</div>
<div class="row g-4 mb-5">
<div class="col-md-6 col-lg-4">
<div class="feature-card">
<div class="feature-icon-lg">🐍</div>
<h4 class="fw-bold">Python-разработчик</h4>
<p class="text-muted small">От основ до создания веб-приложений и ботов.</p>
<form method="POST" action="/cart/add" class="mt-3">
<input type="hidden" name="courseId" value="1">
<button type="submit" class="btn btn-custom">🛒 В корзину</button>
</form>
</div>
</div>
<div class="col-md-6 col-lg-4">
<div class="feature-card">
<div class="feature-icon-lg">⚛️</div>
<h4 class="fw-bold">Frontend: React</h4>
<p class="text-muted small">Современные интерфейсы для веб-приложений.</p>
<form method="POST" action="/cart/add" class="mt-3">
<input type="hidden" name="courseId" value="2">
<button type="submit" class="btn btn-custom">🛒 В корзину</button>
</form>
</div>
</div>
<div class="col-md-6 col-lg-4">
<div class="feature-card">
<div class="feature-icon-lg">🗄️</div>
<h4 class="fw-bold">SQL и базы данных</h4>
<p class="text-muted small">Проектирование, оптимизация, Big Data.</p>
<form method="POST" action="/cart/add" class="mt-3">
<input type="hidden" name="courseId" value="3">
<button type="submit" class="btn btn-custom">🛒 В корзину</button>
</form>
</div>
</div>
<div class="col-md-6 col-lg-4">
<div class="feature-card">
<div class="feature-icon-lg">🤖</div>
<h4 class="fw-bold">Machine Learning</h4>
<p class="text-muted small">Нейросети, компьютерное зрение, NLP.</p>
<form method="POST" action="/cart/add" class="mt-3">
<input type="hidden" name="courseId" value="4">
<button type="submit" class="btn btn-custom">🛒 В корзину</button>
</form>
</div>
</div>
<div class="col-md-6 col-lg-4">
<div class="feature-card">
<div class="feature-icon-lg">🌐</div>
<h4 class="fw-bold">Web3 & Blockchain</h4>
<p class="text-muted small">Смарт-контракты, dApps, Solidity.</p>
<form method="POST" action="/cart/add" class="mt-3">
<input type="hidden" name="courseId" value="5">
<button type="submit" class="btn btn-custom">🛒 В корзину</button>
</form>
</div>
</div>
<div class="col-md-6 col-lg-4">
<div class="feature-card" style="background: #f0f4ff; border-color: #6366f1;">
<div class="feature-icon-lg" style="background: #fff; color: #6366f1;">📱</div>
<h4 class="fw-bold">Mobile Dev</h4>
<p class="text-muted small">Кроссплатформенные приложения Flutter.</p>
<form method="POST" action="/cart/add" class="mt-3">
<input type="hidden" name="courseId" value="6">
<button type="submit" class="btn btn-custom">🛒 В корзину</button>
</form>
</div>
</div>
</div>
<div class="row justify-content-center">
<div class="col-lg-10">
<div class="promo-banner">
<h3 class="display-6 fw-bold mb-3">🎁 Скидка 20% при оплате до конца месяца!</h3>
<p class="lead mb-4 opacity-75">
Запишись на курс не выходя из дома и получи специальную цену.
<br>Быстрый старт • Персональный ментор • Помощь с трудоустройством
</p>
<div class="d-flex justify-content-center gap-3 flex-wrap">
<a href="' . $servicesUrl . '" class="btn btn-light btn-hero text-primary fw-bold">Выбрать курс</a>
<a href="' . $servicesUrl . '" class="btn btn-outline-light btn-hero">Бесплатный урок</a>
</div>
</div>
</div>
</div>
<div class="row justify-content-center">
<div class="col-lg-8">
<div class="education-badge">
<p class="mb-1"><strong>Учебный проект</strong></p>
<p class="mb-0">
Сайт разработан в рамках обучения в <strong>"Кузбасском кооперативном техникуме"</strong><br>
по специальности <em>"Специалист по информационным технологиям"</em>.
</p>
</div>
</div>
</div>
</main>';
return str_replace(['{{TITLE}}', '{{CONTENT}}'], [$title, $content], $template);
}
}