<?php require_once 'views/layouts/header.php'; ?>

<div class="form-container glass-container">
    <h2 style="text-align: center; color: var(--primary-blue); margin-bottom: 2rem;">Вход в систему</h2>
    
    <?php if (isset($error)): ?>
    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo SITE_URL; ?>/login">
        <div class="form-group">
            <label for="login">Логин или Email</label>
            <input type="text" id="login" name="login" required placeholder="Введите логин или email">
        </div>
        
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" required placeholder="Введите пароль">
        </div>
        
        <button type="submit" class="btn btn-primary" style="width: 100%;">Войти</button>
    </form>
    
    <p style="text-align: center; margin-top: 1.5rem; color: #666;">
        Нет аккаунта? <a href="<?php echo SITE_URL; ?>/register" style="color: var(--primary-blue);">Зарегистрироваться</a>
    </p>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
