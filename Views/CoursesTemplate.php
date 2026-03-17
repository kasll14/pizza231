<?php
namespace Views;

class CoursesTemplate extends BaseTemplate
{
    public static function getTemplate(): string
    {
        $template = parent::getTemplate();
        $title = 'Курсы - CodeStart Academy | Обучение программированию';
        
        $customStyles = '
        <style>
        .course-card {
            border: none;
            border-radius: 20px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: #ffffff;
            overflow: hidden;
            position: relative;
            z-index: 1;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .course-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(99,102,241,0.15) !important;
        }
        .course-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, #6366f1, #06b6d4);
            z-index: 2;
        }
        .icon-box {
            width: 90px;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 3rem;
            margin: 0 auto 1.5rem auto;
            background: linear-gradient(135deg, #e0e7ff, #f0f4ff);
            color: #6366f1;
            transition: transform 0.3s ease;
        }
        .course-card:hover .icon-box {
            transform: scale(1.1) rotate(5deg);
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
        }
        .btn-custom {
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid #6366f1;
            color: #6366f1;
            background: transparent;
        }
        .btn-custom:hover {
            background: #6366f1;
            color: #fff;
        }
        .calculator-card {
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(99,102,241,0.15);
            overflow: hidden;
        }
        .calculator-header {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            padding: 1.5rem 2rem;
            text-align: center;
        }
        .calculator-body { padding: 2rem; }
        .form-control-lg, .form-select-lg {
            border-radius: 15px;
            border: 2px solid #e2e8f0;
            padding: 0.75rem 1.25rem;
        }
        .btn-calculate {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            width: 100%;
        }
        .result-box {
            background: linear-gradient(135deg, #e0f2fe, #f0f9ff);
            border: 2px solid #06b6d4;
            border-radius: 20px;
            padding: 1.5rem;
            margin-top: 2rem;
            display: none;
        }
        .result-value {
            font-size: 2rem;
            font-weight: 800;
            color: #6366f1;
        }
        </style>';

        $content = $customStyles . '
        <section class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">💻 Все курсы CodeStart</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">
                    Выберите направление и начните путь в IT уже сегодня
                </p>
                <div style="width: 80px; height: 5px; background: linear-gradient(90deg, #6366f1, #06b6d4); margin: 25px auto; border-radius: 10px;"></div>
            </div>
            
            <div class="row g-4 justify-content-center">
                <a href="/course/1" class="col-md-6 col-lg-4">
                    <div class="card course-card h-100 shadow-sm p-4">
                        <div class="card-body text-center">
                            <div class="icon-box">🐍</div>
                            <h4 class="fw-bold">Python-разработчик</h4>
                            <p class="text-muted small">От основ до создания веб-приложений</p>
                            <span class="btn btn-custom">Подробнее →</span>
                        </div>
                    </div>
                </a>
                <a href="/course/2" class="col-md-6 col-lg-4">
                    <div class="card course-card h-100 shadow-sm p-4">
                        <div class="card-body text-center">
                            <div class="icon-box">⚛️</div>
                            <h4 class="fw-bold">Frontend: React</h4>
                            <p class="text-muted small">Современные интерфейсы с нуля</p>
                            <span class="btn btn-custom">Подробнее →</span>
                        </div>
                    </div>
                </a>
                <a href="/course/3" class="col-md-6 col-lg-4">
                    <div class="card course-card h-100 shadow-sm p-4">
                        <div class="card-body text-center">
                            <div class="icon-box">🗄️</div>
                            <h4 class="fw-bold">SQL и базы данных</h4>
                            <p class="text-muted small">Проектирование, оптимизация</p>
                            <span class="btn btn-custom">Подробнее →</span>
                        </div>
                    </div>
                </a>
                <a href="/course/4" class="col-md-6 col-lg-4">
                    <div class="card course-card h-100 shadow-sm p-4">
                        <div class="card-body text-center">
                            <div class="icon-box">🤖</div>
                            <h4 class="fw-bold">Machine Learning</h4>
                            <p class="text-muted small">Нейросети, компьютерное зрение</p>
                            <span class="btn btn-custom">Подробнее →</span>
                        </div>
                    </div>
                </a>
                <a href="/course/5" class="col-md-6 col-lg-4">
                    <div class="card course-card h-100 shadow-sm p-4">
                        <div class="card-body text-center">
                            <div class="icon-box">🌐</div>
                            <h4 class="fw-bold">Web3 & Blockchain</h4>
                            <p class="text-muted small">Смарт-контракты, Solidity</p>
                            <span class="btn btn-custom">Подробнее →</span>
                        </div>
                    </div>
                </a>
                <a href="/course/6" class="col-md-6 col-lg-4">
                    <div class="card course-card h-100 shadow-sm p-4">
                        <div class="card-body text-center">
                            <div class="icon-box">📱</div>
                            <h4 class="fw-bold">Mobile Dev (Flutter)</h4>
                            <p class="text-muted small">Приложения для iOS и Android</p>
                            <span class="btn btn-custom">Подробнее →</span>
                        </div>
                    </div>
                </a>
            </div>
        </section>';

        $calculatorContent = '
        <section class="container my-5" id="calculator">
            <div class="text-center mb-4">
                <h2 class="display-5 fw-bold mb-3">🧮 Калькулятор стоимости обучения</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">
                    Рассчитайте стоимость курса за 30 секунд — прозрачно, без скрытых платежей
                </p>
            </div>
            <div class="calculator-card">
                <div class="calculator-header">
                    <h3>✨ Моментальный расчёт</h3>
                </div>
                <div class="calculator-body">
                    <form id="courseCalculator" class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">📋 Выберите курс</label>
                            <select id="courseType" class="form-select form-select-lg" required>
                                <option value="" disabled selected>Выберите направление...</option>
                                <option value="1" data-rate="4500">🐍 Python-разработчик (4500₽/нед)</option>
                                <option value="2" data-rate="5000">⚛️ Frontend: React (5000₽/нед)</option>
                                <option value="3" data-rate="4000">🗄️ SQL и базы данных (4000₽/нед)</option>
                                <option value="4" data-rate="7000">🤖 Machine Learning (7000₽/нед)</option>
                                <option value="5" data-rate="6500">🌐 Web3 & Blockchain (6500₽/нед)</option>
                                <option value="6" data-rate="5500">📱 Mobile Dev (5500₽/нед)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">📅 Формат обучения</label>
                            <select id="formatType" class="form-select form-select-lg">
                                <option value="1">Онлайн (базовая цена)</option>
                                <option value="0.9">Онлайн + ментор (−10%)</option>
                                <option value="1.2">Офис в СПб (+20%)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">💳 Способ оплаты</label>
                            <select id="paymentType" class="form-select form-select-lg">
                                <option value="1">Помесячно</option>
                                <option value="0.85">Вся сумма сразу (−15%)</option>
                                <option value="0.9">Рассрочка 6 мес (−10%)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">🎁 Дополнительные опции</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="optPortfolio" value="5000">
                                <label class="form-check-label">Помощь с портфолио (+5000₽)</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="optJob" value="10000">
                                <label class="form-check-label">Гарантия трудоустройства (+10000₽)</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-calculate">✨ Рассчитать стоимость</button>
                        </div>
                    </form>
                    <div id="calcResult" class="result-box text-center">
                        <span class="badge bg-primary mb-2" id="resCourse">Курс</span>
                        <h5 class="text-muted mb-3">Итоговая стоимость обучения</h5>
                        <div class="result-value mb-3" id="finalPrice">0 ₽</div>
                        <p class="text-muted small mb-4">* Возможна рассрочка до 12 месяцев</p>
                        <a href="mailto:contact@codestart.academy" class="btn btn-success btn-lg rounded-pill px-4">📩 Записаться</a>
                    </div>
                </div>
            </div>
        </section>
        <script>
        document.getElementById("courseCalculator").addEventListener("submit", function(e) {
            e.preventDefault();
            const courseSelect = document.getElementById("courseType");
            const courseName = courseSelect.options[courseSelect.selectedIndex].text.replace(/\(.*\)/, "").trim();
            const baseRate = parseFloat(courseSelect.options[courseSelect.selectedIndex].dataset.rate);
            const weeks = {1:12, 2:10, 3:8, 4:16, 5:14, 6:12}[courseSelect.value] || 12;
            const formatMultiplier = parseFloat(document.getElementById("formatType").value);
            const paymentMultiplier = parseFloat(document.getElementById("paymentType").value);
            let optionsTotal = 0;
            if(document.getElementById("optPortfolio").checked) optionsTotal += 5000;
            if(document.getElementById("optJob").checked) optionsTotal += 10000;
            let total = (baseRate * weeks) * formatMultiplier * paymentMultiplier + optionsTotal;
            const formatRub = (num) => new Intl.NumberFormat("ru-RU", {style: "currency", currency: "RUB", maximumFractionDigits: 0}).format(num);
            document.getElementById("resCourse").textContent = courseName;
            document.getElementById("finalPrice").textContent = formatRub(total);
            const resultBox = document.getElementById("calcResult");
            resultBox.style.display = "block";
            resultBox.scrollIntoView({behavior: "smooth", block: "center"});
        });
        </script>';

        // 🔧 ИСПОЛЬЗУЕМ str_replace ВМЕСТО sprintf
        return str_replace(['{{TITLE}}', '{{CONTENT}}'], [$title, $content . $calculatorContent], $template);
    }
}