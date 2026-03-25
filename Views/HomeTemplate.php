<?php
namespace Views;
use Lib\DataLoader;

class HomeTemplate extends BaseTemplate
{
    public static function getTemplate(): string
    {
        $template = parent::getTemplate();
        $title = 'Главная — Кемеровский кооперативный техникум';
        $servicesUrl = '/courses';
        $courses = DataLoader::loadCourses();

        $customStyles = '
        <style>
            .hero-carousel .carousel-item {
                height: 550px;
                background-color: #1a365d;
            }
            .hero-carousel img {
                height: 100%;
                object-fit: cover;
                opacity: 0.5;
            }
            .hero-caption {
                bottom: 20%;
                text-shadow: 0 2px 10px rgba(0,0,0,0.5);
            }
            .hero-caption h5 {
                font-size: 3rem;
                font-weight: 700;
                color: #fff;
                margin-bottom: 1rem;
            }
            .feature-card {
                border: none;
                border-radius: 12px;
                background: #fff;
                padding: 2rem 1.5rem;
                text-align: center;
                height: 100%;
                transition: all 0.3s ease;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                border: 1px solid #e2e8f0;
            }
            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 20px rgba(0,0,0,0.12);
                border-color: #2c5282;
            }
            .feature-icon-lg {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 1.5rem;
                display: inline-block;
                background: #ebf4ff;
                width: 80px;
                height: 80px;
                line-height: 80px;
                border-radius: 8px;
                color: #2c5282;
            }
            .feature-card:hover .feature-icon-lg {
                background: #2c5282;
                color: #fff;
            }
            .promo-banner {
                background: #2c5282;
                border-radius: 12px;
                padding: 3rem;
                color: white;
                text-align: center;
                margin: 4rem 0;
            }
            .btn-hero {
                padding: 15px 40px;
                font-size: 1.1rem;
                border-radius: 8px;
                font-weight: 600;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-block;
            }
            .btn-hero-outline {
                background: transparent;
                border: 2px solid #fff;
                color: #fff;
            }
            .btn-hero-outline:hover {
                background: #fff;
                color: #2c5282;
                text-decoration: none;
            }
            .btn-custom {
                border-radius: 8px;
                padding: 10px 25px;
                font-weight: 600;
                border: 2px solid #2c5282;
                color: #2c5282;
                background: transparent;
            }
            .btn-custom:hover {
                background: #2c5282;
                color: #fff;
                text-decoration: none;
            }
            .education-badge {
                background: #f7fafc;
                border-left: 4px solid #2c5282;
                padding: 1.5rem;
                border-radius: 0 8px 8px 0;
                font-size: 0.9rem;
                color: #4a5568;
                margin-top: 3rem;
            }
        </style>';

        // Берём первые 6 курсов для главной страницы
        $featuredCourses = array_slice($courses, 0, 6, true);

        $coursesHtml = '';
        foreach ($featuredCourses as $course) {
            $coursesHtml .= '
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon-lg">' . htmlspecialchars($course['icon']) . '</div>
                    <h4 class="fw-bold">' . htmlspecialchars($course['title']) . '</h4>
                    <p class="text-muted small">' . htmlspecialchars($course['description']) . '</p>
                    <form method="POST" action="/cart/add" class="mt-3">
                        <input type="hidden" name="courseId" value="' . $course['id'] . '">
                        <button type="submit" class="btn btn-custom">В корзину</button>
                    </form>
                </div>
            </div>';
        }

        $content = $customStyles . '
        <section class="container-fluid p-0 mb-5">
            <div id="mainCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://placehold.co/1920x1080/2c5282/ffffff?text=IT+Education" class="d-block w-100" alt="IT Education">
                        <div class="carousel-caption d-none d-md-block hero-caption">
                            <h5>Информационные технологии</h5>
                            <p>Освойте востребованную профессию</p>
                            <a href="' . $servicesUrl . '" class="btn btn-hero btn-hero-outline mt-3">Начать обучение</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://placehold.co/1920x1080/1a365d/ffffff?text=Professional+Skills" class="d-block w-100" alt="Skills">
                        <div class="carousel-caption d-none d-md-block hero-caption">
                            <h5>Профессиональные навыки</h5>
                            <p>Практико-ориентированное обучение</p>
                            <a href="' . $servicesUrl . '" class="btn btn-hero btn-hero-outline mt-3">Выбрать курс</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://placehold.co/1920x1080/2b6cb0/ffffff?text=Career+Growth" class="d-block w-100" alt="Career">
                        <div class="carousel-caption d-none d-md-block hero-caption">
                            <h5>Карьерный рост</h5>
                            <p>Поддержка в трудоустройстве</p>
                            <a href="' . $servicesUrl . '" class="btn btn-hero btn-hero-outline mt-3">Узнать больше</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <main class="container py-4">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-9">
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill">Основан в 1958 году</span>
                    <h2 class="display-5 fw-bold text-dark mb-4">Geek Legend</h2>
                    <p class="lead text-muted">
                        Легендарная онлайн школа с множеством курсов и руководителей.
                    </p>
                </div>
            </div>

            <div class="row g-4 mb-5">
                ' . $coursesHtml . '
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="promo-banner">
                        <h3 class="display-6 fw-bold mb-3">Скидка 20% при оплате до конца месяца</h3>
                        <p class="lead mb-4 opacity-75">
                            Запишитесь на курс и получите специальную цену.
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
                            Сайт разработан в рамках обучения в <strong>Кемеровском кооперативном техникуме</strong><br>
                            по специальности <em>Информационные системы и программирование</em>.
                        </p>
                    </div>
                </div>
            </div>
        </main>';

        return str_replace(['{{TITLE}}', '{{CONTENT}}'], [$title, $content], $template);
    }
}