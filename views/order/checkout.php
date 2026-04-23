<?php require_once 'views/layouts/header.php'; ?>

<div class="glass-container" style="padding: 2rem; max-width: 800px; margin: 0 auto;">
    <h2 style="text-align: center; color: var(--primary-blue); margin-bottom: 2rem;">Оформление заказа</h2>
    
    <div style="margin-bottom: 2rem;">
        <h3 style="color: var(--primary-blue); margin-bottom: 1rem;">Ваш заказ</h3>
        
        <?php foreach ($cartItems as $item): ?>
        <div style="background: rgba(255, 255, 255, 0.7); padding: 1rem; border-radius: 10px; margin-bottom: 1rem;">
            <div style="display: flex; justify-content: space-between;">
                <span style="font-weight: 600;"><?php echo htmlspecialchars($item['title']); ?></span>
                <span style="color: var(--primary-green); font-weight: bold;">
                    <?php echo number_format($item['price'], 0, ',', ' '); ?> руб.
                </span>
            </div>
        </div>
        <?php endforeach; ?>
        
        <div style="border-top: 2px solid var(--glass-border); padding-top: 1rem; margin-top: 1rem;">
            <div style="display: flex; justify-content: space-between; font-size: 1.3rem; font-weight: bold;">
                <span>Итого:</span>
                <span style="color: var(--primary-green);"><?php echo number_format($total, 0, ',', ' '); ?> руб.</span>
            </div>
        </div>
    </div>
    
    <form method="POST" action="<?php echo SITE_URL; ?>/order/checkout">
        <div style="background: rgba(0, 120, 215, 0.1); padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
            <p style="color: #666; margin-bottom: 0.5rem;">Заказ будет отправлен на ваш email</p>
            <p style="font-weight: 600; color: var(--primary-blue);"><?php echo $_SESSION['user_email']; ?></p>
        </div>
        
        <button type="submit" class="btn btn-success" style="width: 100%; font-size: 1.2rem;">
            Подтвердить заказ
        </button>
    </form>
    
    <div style="text-align: center; margin-top: 1.5rem;">
        <a href="<?php echo SITE_URL; ?>/cart" style="color: var(--primary-blue);">Вернуться в корзину</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
