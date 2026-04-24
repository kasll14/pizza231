<?php require_once 'views/layouts/header.php'; ?>

<div class="success-message">
    <h2 style="margin-bottom: 1rem;">Заказ успешно оформлен!</h2>
    
    <div style="background: rgba(255, 255, 255, 0.8); padding: 2rem; border-radius: 15px; margin: 2rem auto; max-width: 500px;">
        <p style="font-size: 1.1rem; margin-bottom: 1rem;">Ваш номер заказа:</p>
        <div style="font-size: 2rem; font-weight: bold; color: var(--primary-blue); margin-bottom: 1.5rem;">
            <?php echo htmlspecialchars($order['order_number']); ?>
        </div>
        
        <div style="border-top: 1px solid rgba(0, 0, 0, 0.1); padding-top: 1rem;">
            <p style="margin-bottom: 0.5rem; color: #666;">Сумма заказа:</p>
            <p style="font-size: 1.5rem; font-weight: bold; color: var(--primary-green);">
                <?php echo number_format($order['total_amount'], 0, ',', ' '); ?> руб.
            </p>
        </div>
        
        <div style="border-top: 1px solid rgba(0, 0, 0, 0.1); padding-top: 1rem; margin-top: 1rem;">
            <p style="color: #666; font-size: 0.95rem;">
                Подтверждение заказа отправлено на email: <br>
                <strong><?php echo htmlspecialchars($order['email']); ?></strong>
            </p>
        </div>
    </div>
    
    <div style="margin-top: 2rem;">
        <a href="<?php echo SITE_URL; ?>/courses" class="btn btn-primary">Продолжить покупки</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
