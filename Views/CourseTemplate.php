<?php
namespace Views;
class CourseTemplate extends BaseTemplate
{
public static array $courses = [
1 => [
'id' => 1,
'title' => 'Python-разработчик',
'icon' => '🐍',
'description' => 'От основ программирования до создания полноценных веб-приложений и Telegram-ботов.',
'features' => [
'✅ Синтаксис Python с нуля',
'✅ Работа с базами данных',
'✅ Создание REST API',
'✅ Дипломный проект в портфолио'
],
'price_from' => 'от 54 000 ₽',
'duration' => '12 недель • 3-5 часов в неделю'
],
2 => [
'id' => 2,
'title' => 'Frontend: React',
'icon' => '⚛️',
'description' => 'Создавай современные интерактивные интерфейсы для веб-приложений.',
'features' => [
'✅ HTML5, CSS3, JavaScript ES6+',
'✅ React + Redux',
'✅ Работа с API',
'✅ 3 проекта в портфолио'
],
'price_from' => 'от 50 000 ₽',
'duration' => '10 недель • 4-6 часов в неделю'
],
3 => [
'id' => 3,
'title' => 'SQL и базы данных',
'icon' => '🗄️',
'description' => 'Проектирование, оптимизация и работа с большими данными.',
'features' => [
'✅ PostgreSQL, MySQL',
'✅ Сложные запросы',
'✅ Оптимизация производительности',
'✅ Работа с Big Data'
],
'price_from' => 'от 32 000 ₽',
'duration' => '8 недель • 3-4 часа в неделю'
],
4 => [
'id' => 4,
'title' => 'Machine Learning',
'icon' => '🤖',
'description' => 'Нейросети, компьютерное зрение, обработка естественного языка.',
'features' => [
'✅ Python для ML',
'✅ TensorFlow, PyTorch',
'✅ Computer Vision, NLP',
'✅ Деплой моделей'
],
'price_from' => 'от 112 000 ₽',
'duration' => '16 недель • 5-7 часов в неделю'
],
5 => [
'id' => 5,
'title' => 'Web3 & Blockchain',
'icon' => '🌐',
'description' => 'Смарт-контракты, dApps, разработка на Solidity.',
'features' => [
'✅ Основы блокчейна',
'✅ Solidity программирование',
'✅ Создание dApps',
'✅ Аудит смарт-контрактов'
],
'price_from' => 'от 91 000 ₽',
'duration' => '14 недель • 4-6 часов в неделю'
],
6 => [
'id' => 6,
'title' => 'Mobile Dev (Flutter)',
'icon' => '📱',
'description' => 'Кроссплатформенные приложения для iOS и Android.',
'features' => [
'✅ Dart с нуля',
'✅ Flutter фреймворк',
'✅ Публикация в Store',
'✅ 2 приложения в портфолио'
],
'price_from' => 'от 66 000 ₽',
'duration' => '12 недель • 4-5 часов в неделю'
]
];
public static function renderCourse(int $courseId): string
{
$template = parent::getTemplate();
$course = self::$courses[$courseId] ?? null;
if (!$course) {
http_response_code(404);
return '<h1>Курс не найден</h1>';
}
$title = $course['title'] . ' - CodeStart Academy';
$customStyles = '
<style>
.course-hero {
background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
border-radius: 25px;
padding: 3rem 2rem;
color: white;
margin-bottom: 2.5rem;
position: relative;
overflow: hidden;
}
.course-hero::before {
content: "' . $course['icon'] . '";
position: absolute;
right: -20px;
bottom: -40px;
font-size: 12rem;
opacity: 0.15;
transform: rotate(-15deg);
}
.course-icon-lg {
font-size: 4rem;
background: rgba(255,255,255,0.2);
width: 100px;
height: 100px;
line-height: 100px;
border-radius: 50%;
backdrop-filter: blur(10px);
display: inline-block;
margin-bottom: 1rem;
}
.feature-list {
list-style: none;
padding: 0;
}
.feature-list li {
padding: 0.75rem 0;
border-bottom: 1px solid #eef2f7;
font-size: 1.05rem;
}
.cta-section {
background: linear-gradient(135deg, #f8fafc, #e0e7ff);
border-radius: 20px;
padding: 2.5rem;
text-align: center;
border: 2px dashed #6366f1;
}
.btn-enroll {
background: linear-gradient(135deg, #6366f1, #8b5cf6);
border: none;
padding: 15px 40px;
font-size: 1.1rem;
font-weight: 600;
border-radius: 50px;
color: white;
text-decoration: none;
display: inline-block;
transition: all 0.3s ease;
}
.btn-enroll:hover {
transform: translateY(-3px);
box-shadow: 0 15px 35px rgba(99,102,241,0.4);
color: white;
text-decoration: none;
}
.back-link {
color: #64748b;
text-decoration: none;
font-weight: 500;
margin-bottom: 1.5rem;
display: inline-block;
}
.back-link:hover {
color: #6366f1;
text-decoration: none;
}
</style>';
$featuresHtml = '';
foreach ($course['features'] as $feature) {
$featuresHtml .= '<li>' . $feature . '</li>';
}
$content = $customStyles . '
<section class="container py-5">
<a href="/courses" class="back-link">← Назад к курсам</a>
<div class="course-hero">
<div class="course-icon-lg">' . $course['icon'] . '</div>
<h1 class="display-5 fw-bold mb-3">' . $course['title'] . '</h1>
<p class="lead mb-4 opacity-90">' . $course['description'] . '</p>
<div class="fs-3 fw-bold">' . $course['price_from'] . '</div>
<span class="badge bg-white text-primary">' . $course['duration'] . '</span>
</div>
<div class="row g-4">
<div class="col-lg-8">
<div class="card border-0 shadow-sm rounded-4 p-4">
<h3 class="fw-bold mb-4">✨ Программа курса</h3>
<ul class="feature-list">' . $featuresHtml . '</ul>
</div>
</div>
<div class="col-lg-4">
<div class="cta-section">
<h4 class="fw-bold mb-3">🎯 Готовы начать?</h4>
<p class="text-muted mb-4">Забронируйте место в следующей группе</p>
<a href="/courses#calculator" class="btn btn-enroll w-100 mb-2">Записаться на курс</a>
<form method="POST" action="/cart/add">
<input type="hidden" name="courseId" value="' . $course['id'] . '">
<button type="submit" class="btn btn-enroll w-100" style="background: linear-gradient(135deg, #10b981, #059669);">
🛒 Добавить в корзину
</button>
</form>
<p class="small text-muted mt-3 mb-0">📩 contact@codestart.academy</p>
</div>
</div>
</div>
</section>';
return str_replace(['{{TITLE}}', '{{CONTENT}}'], [$title, $content], $template);
}
public static function getTemplate(): string
{
return parent::getTemplate();
}
}