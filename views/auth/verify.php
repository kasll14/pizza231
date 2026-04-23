<?php require_once 'views/layouts/header.php'; ?>

<div class="form-container glass-container">
    <h2 style="text-align: center; color: var(--primary-blue); margin-bottom: 2rem;">Подтверждение</h2>
    
    <?php if (isset($error)): ?>
    <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <p style="text-align: center; margin-bottom: 2rem; color: #666;">
        Введите код подтверждения, отправленный на ваш email
    </p>
    
    <form method="POST" action="<?php echo SITE_URL; ?>/verify">
        <div class="form-group">
            <label for="code">Код подтверждения</label>
            <input type="text" id="code" name="code" required placeholder="Введите 6-значный код" maxlength="6">
        </div>
        
        <button type="submit" class="btn btn-primary" style="width: 100%;">Подтвердить</button>
    </form>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
