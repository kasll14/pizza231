<?php
// 🔐 ОБНОВЛЕНО: Контроллер теперь работает с кодами
namespace Controllers;
use Lib\User;
use Lib\Auth;
use Lib\Language;
use Lib\Logger; // 📝 LOGGER: Добавлен импорт
use Views\AuthTemplate;

class AuthController
{
    public function register(): string
    {
        if (User::isLoggedIn()) {
            header('Location: /profile');
            exit;
        }
        
        $errors = [];
        $data = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'password_confirm' => $_POST['password_confirm'] ?? ''
            ];
            
            if (empty($data['name'])) $errors[] = 'name_required';
            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'email_invalid';
            if (empty($data['phone'])) $errors[] = 'phone_required';
            if (strlen($data['password']) < 6) $errors[] = 'password_short';
            if ($data['password'] !== $data['password_confirm']) $errors[] = 'password_mismatch';
            if (empty($errors) && User::getUserByEmail($data['email'])) $errors[] = 'email_exists';
            
            if (empty($errors)) {
                $userId = User::createUser($data);
                $user = User::getUserById($userId);
                
                // 🔐 ИЗМЕНЕНО: Отправляем код вместо ссылки
                Auth::sendVerificationEmail($user['email'], $user['verification_code'], $user['name']);
                
                // 🔐 ДОБАВЛЕНО: Сохраняем email в сессии для страницы подтверждения
                $_SESSION['verify_email'] = $user['email'];
                $_SESSION['verify_name'] = $user['name'];
                
                // 📝 LOGGER: Логирование регистрации
                Logger::info("Новая регистрация пользователя", [
                    'user_id' => $userId,
                    'email' => $data['email']
                ]);
                
                header('Location: /auth/verify-code');
                exit;
            } else {
                // 📝 LOGGER: Логирование ошибок регистрации
                Logger::warning("Ошибка регистрации", [
                    'email' => $data['email'] ?? 'unknown',
                    'errors' => $errors
                ]);
            }
        }
        
        return AuthTemplate::getRegisterTemplate($errors, $data);
    }
    
    public function login(): string
    {
        if (User::isLoggedIn()) {
            header('Location: /profile');
            exit;
        }
        
        $errors = [];
        $registered = isset($_GET['registered']);
        $verified = isset($_GET['verified']);
        $resetSuccess = isset($_GET['reset_success']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                $errors[] = 'fields_required';
            } else {
                $result = User::validateLogin($email, $password);
                
                if ($result && !isset($result['error'])) {
                    User::login($result['id']);
                    
                    // 📝 LOGGER: Логирование успешного входа
                    Logger::info("Успешный вход пользователя", [
                        'user_id' => $result['id'],
                        'email' => $email
                    ]);
                    
                    if ($result['role'] === 'admin') {
                        header('Location: /admin');
                        exit;
                    }
                    header('Location: /profile');
                    exit;
                } elseif ($result && isset($result['error']) && $result['error'] === 'email_not_verified') {
                    // 🔐 ДОБАВЛЕНО: Перенаправляем на страницу ввода кода
                    $_SESSION['verify_email'] = $email;
                    $user = User::getUserByEmail($email);
                    $_SESSION['verify_name'] = $user['name'];
                    header('Location: /auth/verify-code?login_attempt=1');
                    exit;
                } else {
                    $errors[] = 'invalid_credentials';
                    
                    // 📝 LOGGER: Логирование неудачной попытки входа
                    Logger::warning("Неудачная попытка входа", [
                        'email' => $email,
                        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
                    ]);
                }
            }
        }
        
        return AuthTemplate::getLoginTemplate($errors, $registered, $verified, $resetSuccess);
    }
    
    public function logout(): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        User::logout();
        
        // 📝 LOGGER: Логирование выхода
        if ($userId) {
            Logger::info("Выход пользователя", ['user_id' => $userId]);
        }
        
        header('Location: /');
        exit;
    }
    
    // 🔐 ДОБАВЛЕНО: Страница ввода кода подтверждения
    public function verifyCode(): string
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $email = $_SESSION['verify_email'] ?? '';
        $name = $_SESSION['verify_name'] ?? '';
        $errors = [];
        $success = false;
        
        // 🔐 Проверка попытки входа без подтверждения
        $loginAttempt = isset($_GET['login_attempt']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = trim($_POST['code'] ?? '');
            $email = trim($_POST['email'] ?? $email);
            
            if (empty($code) || strlen($code) !== 6) {
                $errors[] = 'code_invalid';
            } elseif (User::verifyUserByCode($email, $code)) {
                // 🔐 Успешное подтверждение
                unset($_SESSION['verify_email']);
                unset($_SESSION['verify_name']);
                
                // 📝 LOGGER: Логирование подтверждения email
                Logger::info("Email подтверждён", ['email' => $email]);
                
                header('Location: /auth/login?verified=1');
                exit;
            } else {
                $errors[] = 'code_wrong';
                
                // 📝 LOGGER: Логирование неверного кода
                Logger::warning("Неверный код подтверждения", ['email' => $email]);
            }
        }
        
        return AuthTemplate::getVerifyCodeTemplate($email, $name, $errors, $loginAttempt);
    }
    
    // 🔐 ДОБАВЛЕНО: Повторная отправка кода
    public function resendCode(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $email = $_SESSION['verify_email'] ?? $_POST['email'] ?? '';
        
        if (empty($email)) {
            header('Location: /auth/verify-code?error=no_email');
            exit;
        }
        
        $user = User::getUserByEmail($email);
        
        if (!$user || $user['verified']) {
            header('Location: /auth/verify-code?error=already_verified');
            exit;
        }
        
        // 🔐 Генерация нового кода
        $newCode = User::resendVerificationCode($email);
        
        if ($newCode) {
            Auth::resendVerificationCode($email, $newCode, $user['name']);
            
            // 📝 LOGGER: Логирование повторной отправки кода
            Logger::info("Код подтверждения отправлен повторно", ['email' => $email]);
            
            header('Location: /auth/verify-code?resent=1');
        } else {
            // 📝 LOGGER: Логирование ошибки отправки
            Logger::error("Ошибка отправки кода подтверждения", ['email' => $email]);
            header('Location: /auth/verify-code?error=resend_failed');
        }
        exit;
    }
    
    public function forgotPassword(): string
    {
        $errors = [];
        $success = false;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'email_invalid';
            } else {
                $user = User::getUserByEmail($email);
                
                if ($user) {
                    $token = User::generateResetToken($user['id']);
                    if ($token) {
                        Auth::sendPasswordResetEmail($user['email'], $token, $user['name']);
                        
                        // 📝 LOGGER: Логирование запроса сброса пароля
                        Logger::info("Запрос сброса пароля", ['email' => $email]);
                    }
                }
                $success = true;
            }
        }
        
        return AuthTemplate::getForgotPasswordTemplate($errors, $success);
    }
    
    public function resetPassword(): string
    {
        $token = $_GET['token'] ?? '';
        $errors = [];
        $validToken = false;
        $userId = null;
        
        if (!empty($token)) {
            $userId = User::validateResetToken($token);
            $validToken = ($userId !== null);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $validToken) {
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';
            
            if (strlen($password) < 6) $errors[] = 'password_short';
            elseif ($password !== $password_confirm) $errors[] = 'password_mismatch';
            else {
                User::updatePassword($userId, $password);
                User::updateUser($userId, [
                    'verification_token' => null,
                    'token_expires' => null,
                    'verified' => true
                ]);
                
                // 📝 LOGGER: Логирование смены пароля
                Logger::info("Пароль изменён через сброс", ['user_id' => $userId]);
                
                header('Location: /auth/login?reset_success=1');
                exit;
            }
        }
        
        return AuthTemplate::getResetPasswordTemplate($errors, $validToken, $token);
    }
}