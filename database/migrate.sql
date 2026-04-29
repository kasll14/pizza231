-- Миграция для добавления новых полей в таблицу пользователей
-- Выполнить после создания базы данных

-- Добавить поля если их нет
ALTER TABLE users ADD COLUMN IF NOT EXISTS login VARCHAR(100) UNIQUE;
ALTER TABLE users ADD COLUMN IF NOT EXISTS password VARCHAR(255);
ALTER TABLE users ADD COLUMN IF NOT EXISTS email_verified TINYINT(1) DEFAULT 0;
ALTER TABLE users ADD COLUMN IF NOT EXISTS verification_code VARCHAR(10);

-- Обновить существующих пользователей
UPDATE users SET login = SUBSTRING_INDEX(email, '@', 1) WHERE login IS NULL;
UPDATE users SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' WHERE password IS NULL;
UPDATE users SET email_verified = 1 WHERE email_verified IS NULL;

-- Установить администратора
UPDATE users SET is_admin = 1 WHERE email = 'admin@example.com';
