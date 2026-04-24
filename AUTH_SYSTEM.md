# Система аутентификации

## Регистрация

1. Перейдите на страницу: `http://localhost/register`
2. Заполните форму:
   - **Email** - ваша электронная почта
   - **Логин** - уникальный идентификатор (минимум 3 символа)
   - **Пароль** - минимум 6 символов
   - **Повторите пароль**
3. Нажмите **"Зарегистрироваться"**
4. Введите **код подтверждения**, отправленный на email
5. После подтверждения вы автоматически войдете в систему

## Вход

1. Перейдите на страницу: `http://localhost/login`
2. Введите **логин ИЛИ email**
3. Введите **пароль**
4. Нажмите **"Войти"**

## Администратор

По умолчанию создан администратор:
- **Логин**: `admin`
- **Пароль**: `admin123`
- **Email**: `admin@example.com`

## Важные изменения

### Было:
- Вход только по email с кодом подтверждения
- Без паролей

### Стало:
- **Регистрация**: email + логин + пароль + подтверждение email
- **Вход**: логин/email + пароль (без email подтверждения)
- Пароли хранятся в зашифрованном виде (bcrypt)

## Миграция базы данных

Если у вас уже есть база данных, выполните:

```sql
ALTER TABLE users ADD COLUMN login VARCHAR(100) UNIQUE;
ALTER TABLE users ADD COLUMN password VARCHAR(255);
ALTER TABLE users ADD COLUMN email_verified TINYINT(1) DEFAULT 0;
ALTER TABLE users ADD COLUMN verification_code VARCHAR(10);

UPDATE users SET login = SUBSTRING_INDEX(email, '@', 1) WHERE login IS NULL;
UPDATE users SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' WHERE password IS NULL;
UPDATE users SET email_verified = 1 WHERE email_verified IS NULL;
```

Или импортируйте `database/database.sql` заново.
