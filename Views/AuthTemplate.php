<?php
namespace Views;

use Lib\Language;

class AuthTemplate extends BaseTemplate
{
    public static function getRegisterTemplate(array $errors = [], array $data = []): string
    {
        $template = parent::getTemplate();
        $title = Language::get('auth_register') . ' - ' . Language::get('site_name');
        
        $errorMessages = [
            'name_required' => Language::get('auth_name_required'),
            'email_invalid' => Language::get('checkout_error_email'),
            'email_exists' => Language::get('auth_email_exists'),
            'phone_required' => Language::get('auth_phone_required'),
            'password_short' => Language::get('auth_password_short'),
            'password_mismatch' => Language::get('auth_password_mismatch')
        ];
        
        $errorHtml = '';
        foreach ($errors as $error) {
            $errorHtml .= '<div class="alert-error">' . ($errorMessages[$error] ?? $error) . '</div>';
        }
        
        $content = '
<style>
.auth-container{max-width:500px;margin:3rem auto;background:#fff;padding:2.5rem;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,0.08);border:1px solid #e2e8f0}
.auth-title{text-align:center;margin-bottom:2rem;color:#2c5282}
.form-group{margin-bottom:1.25rem}
.form-group label{display:block;margin-bottom:0.5rem;font-weight:500;color:#2d3748}
.form-control{width:100%;padding:0.75rem 1rem;border:1px solid #e2e8f0;border-radius:6px;font-size:1rem}
.form-control:focus{border-color:#2c5282;outline:none;box-shadow:0 0 0 3px rgba(44,82,130,0.1)}
.btn-auth{width:100%;padding:1rem;background:#2c5282;color:#fff;border:none;border-radius:6px;font-size:1rem;font-weight:600;cursor:pointer;transition:background 0.3s}
.btn-auth:hover{background:#1a365d}
.auth-link{text-align:center;margin-top:1.5rem;color:#718096}
.auth-link a{color:#2c5282;text-decoration:none;font-weight:600}
.alert-error{background:#fed7d7;color:#742a2a;padding:0.75rem 1rem;border-radius:6px;margin-bottom:1rem;border:1px solid #feb2b2}
</style>
<section class="container py-5">
<div class="auth-container">
<h1 class="auth-title">'.Language::get('auth_register').'</h1>
'.$errorHtml.'
<form method="POST" action="/auth/register">
<div class="form-group"><label>'.Language::get('checkout_name').' *</label>
<input type="text" name="name" class="form-control" value="'.htmlspecialchars($data['name'] ?? '').'" required></div>
<div class="form-group"><label>Email *</label>
<input type="email" name="email" class="form-control" value="'.htmlspecialchars($data['email'] ?? '').'" required></div>
<div class="form-group"><label>'.Language::get('checkout_phone').' *</label>
<input type="tel" name="phone" class="form-control" value="'.htmlspecialchars($data['phone'] ?? '').'" required placeholder="+7 (___) ___-__-__"></div>
<div class="form-group"><label>'.Language::get('auth_new_password').' *</label>
<input type="password" name="password" class="form-control" required minlength="6"></div>
<div class="form-group"><label>'.Language::get('auth_confirm_password').' *</label>
<input type="password" name="password_confirm" class="form-control" required></div>
<button type="submit" class="btn-auth">'.Language::get('auth_register').'</button>
</form>
<div class="auth-link">'.Language::get('auth_login').'? <a href="/auth/login">'.Language::get('auth_login').'</a></div>
</div>
</section>';
        return str_replace(['{{TITLE}}','{{CONTENT}}'],[$title,$content],$template);
    }
    
    public static function getLoginTemplate(array $errors = [], bool $registered = false, bool $verified = false, bool $resetSuccess = false): string
    {
        $template = parent::getTemplate();
        $title = Language::get('auth_login') . ' - ' . Language::get('site_name');
        
        $errorMessages = [
            'fields_required' => 'Заполните все поля',
            'invalid_credentials' => Language::get('auth_invalid_credentials'),
            'email_not_verified' => Language::get('auth_email_not_verified')
        ];
        
        $errorHtml = '';
        foreach ($errors as $error) {
            $errorHtml .= '<div class="alert-error">' . ($errorMessages[$error] ?? $error) . '</div>';
        }
        
        $successHtml = '';
        if ($registered) $successHtml = '<div class="alert-success">'.Language::get('auth_registration_success').'! Проверьте email.</div>';
        if ($verified) $successHtml = '<div class="alert-success">'.Language::get('auth_email_verified').'! Теперь войдите.</div>';
        if ($resetSuccess) $successHtml = '<div class="alert-success">'.Language::get('auth_password_changed').'! Войдите с новым паролем.</div>';
        
        $content = '
<style>
.auth-container{max-width:450px;margin:3rem auto;background:#fff;padding:2.5rem;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,0.08);border:1px solid #e2e8f0}
.auth-title{text-align:center;margin-bottom:2rem;color:#2c5282}
.form-group{margin-bottom:1.25rem}
.form-group label{display:block;margin-bottom:0.5rem;font-weight:500}
.form-control{width:100%;padding:0.75rem 1rem;border:1px solid #e2e8f0;border-radius:6px}
.form-control:focus{border-color:#2c5282;outline:none;box-shadow:0 0 0 3px rgba(44,82,130,0.1)}
.btn-auth{width:100%;padding:1rem;background:#2c5282;color:#fff;border:none;border-radius:6px;font-weight:600}
.btn-auth:hover{background:#1a365d}
.auth-link{text-align:center;margin-top:1.5rem;color:#718096}
.auth-link a{color:#2c5282;text-decoration:none;font-weight:600}
.alert-error{background:#fed7d7;color:#742a2a;padding:0.75rem;border-radius:6px;margin-bottom:1rem}
.alert-success{background:#c6f6d5;color:#22543d;padding:0.75rem;border-radius:6px;margin-bottom:1rem}
.forgot-password{text-align:right;margin-top:0.5rem}
.forgot-password a{color:#2c5282;font-size:0.9rem;text-decoration:none}
</style>
<section class="container py-5">
<div class="auth-container">
<h1 class="auth-title">'.Language::get('auth_login').'</h1>
'.$successHtml.$errorHtml.'
<form method="POST" action="/auth/login">
<div class="form-group"><label>Email</label>
<input type="email" name="email" class="form-control" required></div>
<div class="form-group"><label>'.Language::get('auth_new_password').'</label>
<input type="password" name="password" class="form-control" required></div>
<div class="forgot-password"><a href="/auth/forgot-password">'.Language::get('auth_forgot_password').'</a></div>
<button type="submit" class="btn-auth">'.Language::get('auth_login').'</button>
</form>
<div class="auth-link">'.Language::get('auth_register').'? <a href="/auth/register">'.Language::get('auth_register').'</a></div>
</div>
</section>';
        return str_replace(['{{TITLE}}','{{CONTENT}}'],[$title,$content],$template);
    }
    
    // 🔐 ДОБАВЛЕНО: Шаблон страницы ввода кода подтверждения
    public static function getVerifyCodeTemplate(string $email = '', string $name = '', array $errors = [], bool $loginAttempt = false): string
    {
        $template = parent::getTemplate();
        $title = Language::get('auth_verify_email') . ' - ' . Language::get('site_name');
        
        $errorMessages = [
            'code_invalid' => 'Введите 6-значный код',
            'code_wrong' => 'Неверный код или истёк срок действия',
            'no_email' => 'Email не найден',
            'already_verified' => 'Email уже подтверждён',
            'resend_failed' => 'Ошибка отправки кода'
        ];
        
        $errorHtml = '';
        foreach ($errors as $error) {
            $errorHtml .= '<div class="alert-error">' . ($errorMessages[$error] ?? $error) . '</div>';
        }
        
        $resentHtml = isset($_GET['resent']) ? '<div class="alert-success">Новый код отправлен на email!</div>' : '';
        $loginAttemptHtml = $loginAttempt ? '<div class="alert-info">Для завершения входа подтвердите email кодом из письма</div>' : '';
        
        $content = '
<style>
.auth-container{max-width:450px;margin:3rem auto;background:#fff;padding:2.5rem;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,0.08);border:1px solid #e2e8f0}
.auth-title{text-align:center;margin-bottom:1rem;color:#2c5282}
.auth-subtitle{text-align:center;color:#718096;margin-bottom:2rem;font-size:0.95rem}
.form-group{margin-bottom:1.25rem}
.form-group label{display:block;margin-bottom:0.5rem;font-weight:500}
.form-control{width:100%;padding:0.75rem 1rem;border:1px solid #e2e8f0;border-radius:6px;text-align:center;font-size:1.5rem;letter-spacing:8px;font-weight:700}
.form-control:focus{border-color:#2c5282;outline:none;box-shadow:0 0 0 3px rgba(44,82,130,0.1)}
.btn-auth{width:100%;padding:1rem;background:#2c5282;color:#fff;border:none;border-radius:6px;font-weight:600}
.btn-auth:hover{background:#1a365d}
.btn-resend{width:100%;padding:0.75rem;background:transparent;color:#2c5282;border:2px solid #2c5282;border-radius:6px;font-weight:600;cursor:pointer;margin-top:1rem}
.btn-resend:hover{background:#ebf4ff}
.alert-error{background:#fed7d7;color:#742a2a;padding:0.75rem;border-radius:6px;margin-bottom:1rem}
.alert-success{background:#c6f6d5;color:#22543d;padding:0.75rem;border-radius:6px;margin-bottom:1rem}
.alert-info{background:#bee3f8;color:#2c5282;padding:0.75rem;border-radius:6px;margin-bottom:1rem}
.email-display{text-align:center;background:#f7fafc;padding:1rem;border-radius:6px;margin-bottom:1.5rem}
.code-info{text-align:center;color:#718096;font-size:0.9rem;margin-top:1rem}
</style>
<section class="container py-5">
<div class="auth-container">
<h1 class="auth-title">Подтверждение email</h1>
<p class="auth-subtitle">Введите 6-значный код из письма</p>
'.$loginAttemptHtml.$resentHtml.$errorHtml.'
<div class="email-display">
<strong>Email:</strong> '.htmlspecialchars($email).'
</div>
<form method="POST" action="/auth/verify-code">
<input type="hidden" name="email" value="'.htmlspecialchars($email).'">
<div class="form-group">
<label>Код подтверждения</label>
<input type="text" name="code" class="form-control" maxlength="6" pattern="[0-9]{6}" 
       placeholder="000000" required autocomplete="off" 
       oninput="this.value = this.value.replace(/[^0-9]/g, \'\'
</div>
<button type="submit" class="btn-auth">Подтвердить</button>
</form>
<form method="POST" action="/auth/resend-code">
<input type="hidden" name="email" value="'.htmlspecialchars($email).'">
<button type="submit" class="btn-resend">📧 Отправить код повторно</button>
</form>
<p class="code-info">Код действителен 15 минут. Проверьте папку Спам.</p>
<div class="auth-link" style="margin-top:1.5rem"><a href="/auth/login">← Назад ко входу</a></div>
</div>
</section>';
        return str_replace(['{{TITLE}}','{{CONTENT}}'],[$title,$content],$template);
    }
    
    public static function getForgotPasswordTemplate(array $errors = [], bool $success = false): string
    {
        $template = parent::getTemplate();
        $title = Language::get('auth_forgot_password') . ' - ' . Language::get('site_name');
        
        $errorHtml = '';
        foreach ($errors as $error) $errorHtml .= '<div class="alert-error">'.$error.'</div>';
        $successHtml = $success ? '<div class="alert-success">'.Language::get('auth_email_sent').'</div>' : '';
        
        $content = '
<style>
.auth-container{max-width:450px;margin:3rem auto;background:#fff;padding:2.5rem;border-radius:12px}
.auth-title{text-align:center;margin-bottom:2rem;color:#2c5282}
.form-group{margin-bottom:1.25rem}
.form-group label{display:block;margin-bottom:0.5rem;font-weight:500}
.form-control{width:100%;padding:0.75rem 1rem;border:1px solid #e2e8f0;border-radius:6px}
.btn-auth{width:100%;padding:1rem;background:#2c5282;color:#fff;border:none;border-radius:6px;font-weight:600}
.alert-error{background:#fed7d7;color:#742a2a;padding:0.75rem;border-radius:6px;margin-bottom:1rem}
.alert-success{background:#c6f6d5;color:#22543d;padding:0.75rem;border-radius:6px;margin-bottom:1rem}
</style>
<section class="container py-5">
<div class="auth-container">
<h1 class="auth-title">'.Language::get('auth_forgot_password').'</h1>
'.$successHtml.$errorHtml.'
<form method="POST" action="/auth/forgot-password">
<div class="form-group"><label>Email</label>
<input type="email" name="email" class="form-control" required></div>
<button type="submit" class="btn-auth">'.Language::get('auth_send').'</button>
</form>
<div class="auth-link" style="text-align:center;margin-top:1.5rem"><a href="/auth/login">← '.Language::get('auth_login').'</a></div>
</div>
</section>';
        return str_replace(['{{TITLE}}','{{CONTENT}}'],[$title,$content],$template);
    }
    
    public static function getResetPasswordTemplate(array $errors = [], bool $validToken = false, string $token = ''): string
    {
        $template = parent::getTemplate();
        $title = Language::get('auth_reset_password') . ' - ' . Language::get('site_name');
        
        if (!$validToken) {
            $content = '<div class="container py-5"><div class="alert-error">Неверная ссылка</div><a href="/auth/forgot-password">Запросить новую</a></div>';
            return str_replace(['{{TITLE}}','{{CONTENT}}'],[$title,$content],$template);
        }
        
        $errorHtml = '';
        foreach ($errors as $error) $errorHtml .= '<div class="alert-error">'.$error.'</div>';
        
        $content = '
<style>
.auth-container{max-width:450px;margin:3rem auto;background:#fff;padding:2.5rem;border-radius:12px}
.auth-title{text-align:center;margin-bottom:2rem;color:#2c5282}
.form-group{margin-bottom:1.25rem}
.form-group label{display:block;margin-bottom:0.5rem;font-weight:500}
.form-control{width:100%;padding:0.75rem 1rem;border:1px solid #e2e8f0;border-radius:6px}
.btn-auth{width:100%;padding:1rem;background:#2c5282;color:#fff;border:none;border-radius:6px;font-weight:600}
.alert-error{background:#fed7d7;color:#742a2a;padding:0.75rem;border-radius:6px;margin-bottom:1rem}
</style>
<section class="container py-5">
<div class="auth-container">
<h1 class="auth-title">'.Language::get('auth_reset_password').'</h1>
'.$errorHtml.'
<form method="POST" action="/auth/reset-password?token='.$token.'">
<div class="form-group"><label>'.Language::get('auth_new_password').'</label>
<input type="password" name="password" class="form-control" required minlength="6"></div>
<div class="form-group"><label>'.Language::get('auth_confirm_password').'</label>
<input type="password" name="password_confirm" class="form-control" required></div>
<button type="submit" class="btn-auth">'.Language::get('auth_save_changes').'</button>
</form>
</div>
</section>';
        return str_replace(['{{TITLE}}','{{CONTENT}}'],[$title,$content],$template);
    }
}