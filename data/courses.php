<?php
// data/courses.php
// Централизованное хранилище данных о курсах

return [
    1 => [
        'id' => 1,
        'title' => 'Python-разработчик',
        'icon' => 'PY',
        'description' => 'От основ программирования до создания полноценных веб-приложений.',
        'features' => [
            'Синтаксис Python с нуля',
            'Работа с базами данных',
            'Создание REST API',
            'Дипломный проект в портфолио'
        ],
        'price_from' => '54 000 ₽',
        'price_numeric' => 54000,
        'duration' => '12 недель • 3-5 часов в неделю',
        'duration_weeks' => 12,
        'level' => 'Начальный уровень',
        'format' => ['Онлайн', 'Офис'],
        'certificate' => true,
        'job_assistance' => true
    ],
    2 => [
        'id' => 2,
        'title' => 'Frontend: React',
        'icon' => 'RX',
        'description' => 'Создавай современные интерактивные интерфейсы для веб-приложений.',
        'features' => [
            'HTML5, CSS3, JavaScript ES6+',
            'React + Redux',
            'Работа с API',
            '3 проекта в портфолио'
        ],
        'price_from' => '50 000 ₽',
        'price_numeric' => 50000,
        'duration' => '10 недель • 4-6 часов в неделю',
        'duration_weeks' => 10,
        'level' => 'Средний уровень',
        'format' => ['Онлайн', 'Офис'],
        'certificate' => true,
        'job_assistance' => true
    ],
    3 => [
        'id' => 3,
        'title' => 'SQL и базы данных',
        'icon' => 'DB',
        'description' => 'Проектирование, оптимизация и работа с большими данными.',
        'features' => [
            'PostgreSQL, MySQL',
            'Сложные запросы',
            'Оптимизация производительности',
            'Работа с Big Data'
        ],
        'price_from' => '32 000 ₽',
        'price_numeric' => 32000,
        'duration' => '8 недель • 3-4 часа в неделю',
        'duration_weeks' => 8,
        'level' => 'Начальный уровень',
        'format' => ['Онлайн', 'Офис'],
        'certificate' => true,
        'job_assistance' => false
    ],
    4 => [
        'id' => 4,
        'title' => 'Machine Learning',
        'icon' => 'ML',
        'description' => 'Нейросети, компьютерное зрение, обработка естественного языка.',
        'features' => [
            'Python для ML',
            'TensorFlow, PyTorch',
            'Computer Vision, NLP',
            'Деплой моделей'
        ],
        'price_from' => '112 000 ₽',
        'price_numeric' => 112000,
        'duration' => '16 недель • 5-7 часов в неделю',
        'duration_weeks' => 16,
        'level' => 'Продвинутый уровень',
        'format' => ['Онлайн'],
        'certificate' => true,
        'job_assistance' => true
    ],
    5 => [
        'id' => 5,
        'title' => 'Web3 & Blockchain',
        'icon' => 'W3',
        'description' => 'Смарт-контракты, dApps, разработка на Solidity.',
        'features' => [
            'Основы блокчейна',
            'Solidity программирование',
            'Создание dApps',
            'Аудит смарт-контрактов'
        ],
        'price_from' => '91 000 ₽',
        'price_numeric' => 91000,
        'duration' => '14 недель • 4-6 часов в неделю',
        'duration_weeks' => 14,
        'level' => 'Средний уровень',
        'format' => ['Онлайн'],
        'certificate' => true,
        'job_assistance' => true
    ],
    6 => [
        'id' => 6,
        'title' => 'Mobile Dev (Flutter)',
        'icon' => 'MB',
        'description' => 'Кроссплатформенные приложения для iOS и Android.',
        'features' => [
            'Dart с нуля',
            'Flutter фреймворк',
            'Публикация в Store',
            '2 приложения в портфолио'
        ],
        'price_from' => '66 000 ₽',
        'price_numeric' => 66000,
        'duration' => '12 недель • 4-5 часов в неделю',
        'duration_weeks' => 12,
        'level' => 'Начальный уровень',
        'format' => ['Онлайн', 'Офис'],
        'certificate' => true,
        'job_assistance' => true
    ]
    // Чтобы добавить новый курс, просто скопируйте структуру выше и измените данные
];