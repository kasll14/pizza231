<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once 'models/User.php';

class AuthController {
    private $user;

    public function __construct() {
        $database = new Database();
        $this->user = new User($database->getConnection());
    }

    // Регистрация
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $login = trim($_POST['login']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            
            // Валидация
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Неверный формат email";
            } elseif (strlen($login) < 3) {
                $error = "Логин должен быть не менее 3 символов";
            } elseif (strlen($password) < 6) {
                $error = "Пароль должен быть не менее 6 символов";
            } elseif ($password !== $confirm_password) {
                $error = "Пароли не совпадают";
            } else {
                // Проверка существования
                if ($this->user->getByEmail($email)) {
                    $error = "Email уже зарегистрирован";
                } elseif ($this->user->getByLogin($login)) {
                    $error = "Логин уже занят";
                } else {
                    // Создаем пользователя
                    $this->user->email = $email;
                    $this->user->login = $login;
                    $this->user->password = password_hash($password, PASSWORD_DEFAULT);
                    $this->user->created_at = date('Y-m-d H:i:s');
                    
                    if ($this->user->create()) {
                        // Отправляем код подтверждения
                        $verification_code = $this->user->verification_code;
                        $this->sendVerificationCode($email, $verification_code);
                        
                        $_SESSION['pending_email'] = $email;
                        $_SESSION['pending_login'] = $login;
                        
                        header('Location: ' . SITE_URL . '/verify-registration');
                        exit;
                    } else {
                        $error = "Ошибка регистрации";
                    }
                }
            }
        }
        require_once dirname(__DIR__) . '/views/auth/register.php';
    }

    // Подтверждение регистрации
    public function verifyRegistration() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'];
            $email = $_SESSION['pending_email'] ?? null;
            
            if (!$email) {
                header('Location: ' . SITE_URL . '/register');
                exit;
            }
            
            $user = $this->user->getByEmail($email);
            
            if ($user && $user['verification_code'] == $code) {
                $this->user->id = $user['id'];
                $this->user->verification_code = $code;
                $this->user->verifyEmail();
                
                // Автоматический вход после подтверждения
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_login'] = $user['login'];
                $_SESSION['is_admin'] = $user['is_admin'] == 1;
                
                unset($_SESSION['pending_email']);
                unset($_SESSION['pending_login']);
                
                $this->logActivity("Регистрация завершена: $email");
                header('Location: ' . SITE_URL . '/');
                exit;
            } else {
                $error = "Неверный код подтверждения";
            }
        }
        require_once dirname(__DIR__) . '/views/auth/verify-registration.php';
    }

    // Вход
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = trim($_POST['login']);
            $password = $_POST['password'];
            
            $user = $this->user->getByLogin($login);
            
            if ($user && password_verify($password, $user['password'])) {
                if (!$user['email_verified']) {
                    $error = "Пожалуйста, подтвердите ваш email";
                } else {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_login'] = $user['login'];
                    $_SESSION['is_admin'] = $user['is_admin'] == 1;
                    
                    $this->logActivity("Вход: " . $user['email']);
                    header('Location: ' . SITE_URL . '/');
                    exit;
                }
            } else {
                $error = "Неверный логин или пароль";
            }
        }
        require_once dirname(__DIR__) . '/views/auth/login.php';
    }

    // Выход
    public function logout() {
        session_destroy();
        header('Location: ' . SITE_URL . '/');
        exit;
    }

    private function sendVerificationCode($email, $code) {
        $to = $email;
        $subject = "Подтверждение регистрации - Frutiger Aero Courses";
        $message = "Ваш код подтверждения: " . $code . "\n\nНе сообщайте этот код никому.";
        $headers = "From: noreply@frutiger-courses.ru\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        mail($to, $subject, $message, $headers);
        
        $this->logActivity("Отправлен код подтверждения на $email: $code");
    }

    private function logActivity($message) {
        $logFile = dirname(__DIR__) . '/logs/access.log';
        $timestamp = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $logEntry = "[$timestamp] IP: $ip - $message\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
}
?>
