<?php require_once 'views/layouts/header.php'; ?>

<div class="form-container glass-container">
    <h2 style="text-align: center; color: var(--primary-blue); margin-bottom: 2rem;">Регистрация</h2>
    
    <?php if (isset($error)): ?>
    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo SITE_URL; ?>/register">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="example@email.com">
        </div>
        
        <div class="form-group">
            <label for="login">Логин</label>
            <input type="text" id="login" name="login" required minlength="3" placeholder="Придумайте логин">
        </div>
        
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" required minlength="6" placeholder="Придумайте пароль">
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Повторите пароль</label>
            <input type="password" id="confirm_password" name="confirm_password" required minlength="6" placeholder="Повторите пароль">
        </div>
        
        <button type="submit" class="btn btn-success" style="width: 100%;">Зарегистрироваться</button>
    </form>
    
    <p style="text-align: center; margin-top: 1.5rem; color: #666;">
        Уже есть аккаунт? <a href="<?php echo SITE_URL; ?>/login" style="color: var(--primary-blue);">Войти</a>
    </p>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
