# Frutiger Aero - Онлайн Курсы

Сайт онлайн-курсов в стиле Frutiger Aero с MVC архитектурой.

## Быстрый старт

### 1. Убедитесь, что XAMPP установлен и запущен

- Откройте XAMPP Control Panel
- Запустите Apache и MySQL

### 2. Создайте базу данных

**Вариант A - Через phpMyAdmin:**
1. Откройте `http://localhost/phpmyadmin`
2. Нажмите "Импорт"
3. Выберите файл `database/database.sql`
4. Нажмите "Вперед"

**Вариант B - Через командную строку:**
```cmd
cd C:\xampp\htdocs\online-courses
C:\xampp\mysql\bin\mysql.exe -u root < database\database.sql
```

### 3. Активируйте администратора

1. Откройте phpMyAdmin: `http://localhost/phpmyadmin`
2. Выберите базу данных `frutiger_courses`
3. Перейдите в таблицу `users`
4. Найдите `admin@example.com` и измените `is_admin` на `1`

Или выполните SQL-запрос:
```sql
UPDATE users SET is_admin = 1 WHERE email = 'admin@example.com';
```

### 4. Откройте сайт

Перейдите по адресу: **`http://localhost/online-courses/`**

## Настройка отправки email (опционально)

Для работы авторизации по email необходимо настроить sendmail:

1. Откройте `C:\xampp\sendmail\sendmail.ini`
2. Добавьте/измените настройки:
```ini
smtp_server=smtp.gmail.com
smtp_port=587
auth_username=ВАШ_GMAIL
auth_password=ВАШ_ПАРОЛЬ_ПРИЛОЖЕНИЯ
from_email=noreply@frutiger-courses.ru
```

3. Откройте `C:\xampp\php\php.ini`
4. Раскомментируйте строку: `extension=openssl`
5. Перезапустите Apache

**Без настройки email:** Код подтверждения будет показан в логах Apache.

## Доступы

### Администратор
- Email: `admin@example.com`
- Пароль: код подтверждения (приходит на email или в логах)

### Тестовые пользователи
- `user1@example.com`
- `user2@example.com`

## Структура проекта

```
online-courses/
├── config/              # Конфигурация
├── controllers/         # Контроллеры MVC
├── models/              # Модели данных
├── views/               # Представления
├── assets/css/          # Стили Frutiger Aero
├── logs/                # Логи системы
├── database.sql         # Схема БД
└── *.php               # Файлы роутинга
```

## Страницы

1. **Главная** (`/`) - Анимированный фон, популярные курсы
2. **Курсы** (`/courses`) - Все доступные курсы
3. **Карточка курса** (`/course?id=X`) - Детали курса
4. **Корзина** (`/cart`) - Управление заказами
5. **Оформление** (`/order/checkout`) - Подтверждение заказа
6. **О нас** (`/about`) - Яндекс.Карта, информация
7. **Вход** (`/login`) - Авторизация по email
8. **Админ-панель** (`/admin`) - Управление всем

## Функционал администратора

- Управление курсами (добавить, изменить, удалить)
- Управление пользователями (права доступа)
- Управление заказами (смена статуса)
- Просмотр системных логов

## Особенности стиля Frutiger Aero

- Градиенты: небо → трава
- Glass morphism (эффект стекла)
- Анимированные облака
- Глянцевые кнопки
- Природные цвета

## Логи

Все действия записываются в `logs/access.log`

При проблемах проверьте:
- `C:\xampp\apache\logs\error.log`
- `C:\xampp\mysql\data\*.err`

## Поддержка

При возникновении проблем:
1. Проверьте, что Apache и MySQL запущены
2. Убедитесь, что база данных импортирована
3. Проверьте права доступа к папке `logs/`
4. Очистите кэш браузера

Успешного использования!
