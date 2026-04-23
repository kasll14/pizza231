# Frutiger Aero - Online Courses Platform

Сайт онлайн-курсов в стиле Frutiger Aero с использованием MVC архитектуры.

## Требования

- XAMPP (Apache + MySQL + PHP 7.4+)
- Браузер с поддержкой CSS3 и JavaScript

## Установка

### 1. Скопируйте проект в папку XAMPP

Разместите файлы в `C:\xampp\htdocs\online-courses`

### 2. Создайте базу данных

1. Откройте phpMyAdmin: `http://localhost/phpmyadmin`
2. Импортируйте файл `database.sql`
3. Или выполните SQL-скрипт вручную

### 3. Настройте sendmail для отправки писем

1. Откройте `C:\xampp\sendmail\sendmail.ini`
2. Настройте параметры SMTP:
```ini
smtp_server=smtp.gmail.com
smtp_port=587
email_from=noreply@frutiger-courses.ru
```

3. В `php.ini` (в папке XAMPP) убедитесь, что функция mail() включена

### 4. Создайте папку для логов

Убедитесь, что папка `logs` существует и имеет права на запись.

## Структура проекта

```
online-courses/
├── public/              # Точка входа (доступ из браузера)
│   └── index.php        # Единый роутер
├── config/              # Конфигурационные файлы
│   ├── config.php       # Основные настройки
│   └── database.php     # Подключение к БД
├── controllers/         # Контроллеры MVC
│   ├── AuthController.php
│   ├── CourseController.php
│   ├── CartController.php
│   ├── OrderController.php
│   └── AdminController.php
├── models/              # Модели данных
│   ├── User.php
│   ├── Course.php
│   └── Order.php
├── views/               # Представления
│   ├── layouts/         # Общие макеты
│   ├── auth/            # Страницы авторизации
│   ├── courses/         # Страницы курсов
│   ├── cart/            # Корзина
│   ├── order/           # Оформление заказа
│   └── admin/           # Админ-панель
├── assets/              # Статические файлы
│   └── css/
│       └── style.css    # Стили Frutiger Aero
├── database/            # Файлы БД
│   └── database.sql     # SQL скрипт
├── scripts/             # Скрипты установки
│   ├── setup.bat        # Инструкция по установке
│   └── import_db.bat    # Импорт БД
├── logs/                # Логи системы
└── docs/                # Документация
    ├── README.md        # Основной README
    ├── START_HERE.md    # Быстрый старт
    ├── INSTRUCTIONS.md  # Подробные инструкции
    └── FRUTIGER_AERO_STYLE.md
```
online-courses/
├── config/              # Конфигурационные файлы
│   ├── config.php       # Основные настройки
│   └── database.php     # Подключение к БД
├── controllers/         # Контроллеры MVC
│   ├── AuthController.php
│   ├── CourseController.php
│   ├── CartController.php
│   ├── OrderController.php
│   └── AdminController.php
├── models/              # Модели данных
│   ├── User.php
│   ├── Course.php
│   └── Order.php
├── views/               # Представления
│   ├── layouts/         # Общие макеты
│   ├── auth/            # Страницы авторизации
│   ├── courses/         # Страницы курсов
│   ├── cart/            # Корзина
│   ├── order/           # Оформление заказа
│   └── admin/           # Админ-панель
├── assets/              # Статические файлы
│   └── css/
│       └── style.css    # Стили Frutiger Aero
├── logs/                # Логи системы
├── database.sql         # SQL скрипт БД
└── *.php               # Основные файлы роутинга
```

## Страницы

1. **Главная** (`/`) - Анимированный фон в стиле Frutiger Aero
2. **Авторизация** (`/login.php`) - Вход по email с кодом подтверждения
3. **Корзина** (`/cart.php`) - Управление заказами
4. **Оформление заказа** (`/order_checkout.php`) - Подтверждение заказа
5. **О нас** (`/about.php`) - Интерактивная Яндекс.Карта
6. **Курсы** (`/courses.php`) - Список всех курсов
7. **Админ-панель** (`/admin.php`) - Управление курсами, пользователями, заказами, логами

## Функционал

### Для пользователей:
- Авторизация по email с подтверждением кодом
- Просмотр курсов
- Добавление курсов в корзину
- Оформление заказа с отправкой на email
- Просмотр истории заказов

### Для администраторов:
- Управление курсами (CRUD)
- Управление пользователями (права доступа)
- Управление заказами (смена статуса)
- Просмотр системных логов

## Администратор по умолчанию

- Email: `admin@example.com`
- Для активации админ-прав используйте SQL:
```sql
UPDATE users SET is_admin = 1 WHERE email = 'admin@example.com';
```

## Стиль Frutiger Aero

- Градиенты: небо, трава, вода
- Глянцевые эффекты
- Стеклянные панели (glass morphism)
- Анимированный фон с облаками
- Природные цветовые схемы

## Безопасность

- Сессии защищены
- SQL-инъекции предотвращены через PDO prepared statements
- XSS защита через htmlspecialchars()
- Логи всех действий

## Разработка

При создании новых страниц следуйте структуре MVC:
1. Создайте модель в `models/`
2. Создайте контроллер в `controllers/`
3. Создайте представление в `views/`
4. Добавьте роутинг в корневой `.php` файл

## Лицензия

2024 Frutiger Aero Courses. Все права защищены.
