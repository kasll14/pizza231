<?php
namespace Views;
class AboutTemplate extends BaseTemplate
{
    public static function getTemplate(): string
    {
        $template = parent::getTemplate();
        $title = 'О техникуме - Кемеровский кооперативный техникум';
        $customStyles = '
        <style>
            .feature-box {
                background: #f7fafc;
                border-radius: 8px;
                padding: 1.5rem;
                text-align: center;
                height: 100%;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border: 1px solid #e2e8f0;
            }
            .feature-box:hover {
                transform: translateY(-5px);
                background: #fff;
                box-shadow: 0 8px 20px rgba(0,0,0,0.08);
                border-color: #2c5282;
            }
            .feature-icon {
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 1rem;
                display: inline-block;
                background: #ebf4ff;
                width: 70px;
                height: 70px;
                line-height: 70px;
                border-radius: 8px;
                color: #2c5282;
            }
            .hero-section {
                background: #ebf4ff;
                border-radius: 8px;
                padding: 3rem 2rem;
                margin-bottom: 3rem;
                border: 1px solid #e2e8f0;
            }
            .contact-block {
                background: #2c5282;
                color: white;
                border-radius: 8px;
                padding: 2.5rem;
                text-align: center;
                margin: 3rem 0;
            }
            .contact-block h4, .contact-block p {
                color: white;
            }
            .phone-display {
                font-size: 2rem;
                font-weight: 700;
                color: #fff;
                text-decoration: none;
                display: block;
                margin: 1rem 0;
            }
            .phone-display:hover {
                color: #ebf4ff;
            }
            .map-wrapper {
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                border: 3px solid #fff;
            }
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1.5rem;
                margin: 2rem 0;
            }
            .stat-item {
                text-align: center;
                padding: 1.5rem;
                background: #f7fafc;
                border-radius: 8px;
                border: 1px solid #e2e8f0;
            }
            .stat-number {
                font-size: 2.5rem;
                font-weight: 700;
                color: #2c5282;
                display: block;
            }
            .stat-label {
                color: #718096;
                font-size: 0.95rem;
            }
        </style>';
        $content = $customStyles . '
        <section class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="hero-section text-center">
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill">Основан в 1958 году</span>
                        <h2 class="display-5 fw-bold text-dark mb-4">Кемеровский кооперативный техникум</h2>
                        <p class="lead text-muted mx-auto" style="max-width: 800px;">
                            Одно из старейших учебных заведений среднего профессионального образования в Кузбассе.
                            Готовим квалифицированных специалистов для сферы торговли, общественного питания, 
                            экономики и информационных технологий.
                        </p>
                    </div>
                </div>
            </div>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">65+</span>
                    <span class="stat-label">Лет истории</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">15 000+</span>
                    <span class="stat-label">Выпускников</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">12</span>
                    <span class="stat-label">Специальностей</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">94%</span>
                    <span class="stat-label">Трудоустройство</span>
                </div>
            </div>
            <div class="row g-4 mb-5">
                <div class="col-12 text-center mb-3">
                    <h3 class="fw-bold">Почему выбирают наш техникум</h3>
                    <div style="width: 60px; height: 4px; background: #2c5282; margin: 15px auto;"></div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon">ОБ</div>
                        <h5 class="fw-bold">Качественное образование</h5>
                        <p class="text-muted small mb-0">Современные программы и опытные преподаватели.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon">ПР</div>
                        <h5 class="fw-bold">Практика на предприятиях</h5>
                        <p class="text-muted small mb-0">Партнёрство с ведущими компаниями региона.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon">ТР</div>
                        <h5 class="fw-bold">Трудоустройство</h5>
                        <p class="text-muted small mb-0">Помощь в поиске работы после выпуска.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <div class="feature-icon">ДИ</div>
                        <h5 class="fw-bold">Диплом гособразца</h5>
                        <p class="text-muted small mb-0">Признаётся по всей территории РФ.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-block">
                        <h3 class="fw-bold mb-3">Приёмная комиссия</h3>
                        <p class="mb-4 opacity-75">Запишитесь на день открытых дверей или получите консультацию</p>
                        <a href="tel:+73842396000" class="phone-display">+7 (3842) 39-60-00</a>
                        <a href="mailto:info@kemt.ru" class="d-block mb-3 opacity-75">info@kemt.ru</a>
                        <a href="mailto:info@kemt.ru" class="btn btn-light btn-lg px-5 fw-bold mt-2">
                            Написать нам
                        </a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-lg-10">
                    <h4 class="mb-3 text-center fw-bold">Наш адрес</h4>
                    <div class="map-wrapper mb-5">
                        <iframe src="https://yandex.ru/map-widget/v1/?ll=86.066427%2C55.355900&z=15" width="100%" height="450" frameborder="0" allowfullscreen="true"></iframe>
                    </div>
                    <div class="row text-center g-3">
                        <div class="col-md-4">
                            <strong>Адрес:</strong><br>
                            <span class="text-muted">г. Кемерово, ул. Тухачевского, 32а</span>
                        </div>
                        <div class="col-md-4">
                            <strong>Режим работы:</strong><br>
                            <span class="text-muted">Пн-Сб: 8:00–19:45, Вс: выходные</span>
                        </div>
                        <div class="col-md-4">
                            <strong>Транспорт:</strong><br>
                            <span class="text-muted">Остановка «АКБ Надежда»</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>';
        return str_replace(['{{TITLE}}', '{{CONTENT}}'], [$title, $content], $template);
    }
}