-- Создание базы данных
CREATE DATABASE IF NOT EXISTS frutiger_courses CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE frutiger_courses;

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    login VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email_verified TINYINT(1) DEFAULT 0,
    verification_code VARCHAR(10),
    created_at DATETIME NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    INDEX idx_email (email),
    INDEX idx_login (login)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Таблица курсов
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) DEFAULT 'default.jpg',
    created_at DATETIME NOT NULL,
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Таблица заказов
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    created_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_order_number (order_number),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Таблица элементов заказа
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(50) NOT NULL,
    course_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_number) REFERENCES orders(order_number) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Вставка тестовых данных
-- Администратор (email: admin@example.com, логин: admin, пароль: admin123)
INSERT INTO users (email, login, password, email_verified, created_at, is_admin) VALUES 
('admin@example.com', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NOW(), 1),
('user1@example.com', 'user1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NOW(), 0),
('user2@example.com', 'user2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NOW(), 0);

-- Примеры курсов
INSERT INTO courses (title, description, price, image, created_at) VALUES 
('Основы веб-разработки', 'Полный курс по созданию современных веб-сайтов. Изучите HTML, CSS, JavaScript и PHP с нуля.', 5990.00, 'web-dev.jpg', NOW()),
('Python для начинающих', 'Вводный курс по программированию на Python. Научитесь писать код и создавать собственные программы.', 4990.00, 'python.jpg', NOW()),
('Графический дизайн', 'Курс по созданию графического дизайна в стиле Frutiger Aero. Изучите Photoshop, Illustrator и основы композиции.', 6990.00, 'design.jpg', NOW()),
('Базы данных MySQL', 'Полное руководство по работе с базами данных. От основ SQL до оптимизации запросов.', 5490.00, 'mysql.jpg', NOW()),
('Мобильная разработка', 'Создание мобильных приложений для iOS и Android. Flutter и React Native.', 7990.00, 'mobile.jpg', NOW()),
('Цифровой маркетинг', 'Эффективные стратегии продвижения в интернете. SEO, SMM, контекстная реклама.', 4490.00, 'marketing.jpg', NOW());
