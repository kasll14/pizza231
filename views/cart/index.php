<?php require_once 'views/layouts/header.php'; ?>

<h1 style="text-align: center; color: var(--primary-blue); margin-bottom: 2rem;">Корзина</h1>

<?php if (empty($cartItems)): ?>
    <div style="text-align: center; padding: 3rem;">
        <p style="font-size: 1.3rem; color: #666; margin-bottom: 2rem;">Ваша корзина пуста</p>
        <a href="<?php echo SITE_URL; ?>/courses" class="btn btn-primary">Перейти к курсам</a>
    </div>
<?php else: ?>
    <div class="glass-container" style="padding: 2rem; max-width: 900px; margin: 0 auto;">
        <?php foreach ($cartItems as $item): ?>
        <div class="cart-item">
            <div>
                <h3 style="color: var(--primary-blue); margin-bottom: 0.5rem;">
                    <?php echo htmlspecialchars($item['title']); ?>
                </h3>
                <p style="color: #666;"><?php echo htmlspecialchars(substr($item['description'], 0, 80)) . '...'; ?></p>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 1.5rem; color: var(--primary-green); font-weight: bold; margin-bottom: 0.5rem;">
                    <?php echo number_format($item['price'], 0, ',', ' '); ?> руб.
                </div>
                <form method="POST" action="<?php echo SITE_URL; ?>/cart-action" style="display: inline;">
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="course_id" value="<?php echo $item['id']; ?>">
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
        
        <div class="cart-total">
            Итого: <?php echo number_format($total, 0, ',', ' '); ?> руб.
        </div>
        
        <div style="text-align: center; margin-top: 2rem; display: flex; gap: 1rem; justify-content: center; align-items: center;">
            <a href="<?php echo SITE_URL; ?>/order/checkout" class="btn btn-success" style="margin: 0;">Оформить заказ</a>
            <form method="POST" action="<?php echo SITE_URL; ?>/cart-action" style="display: inline; margin: 0;">
                <input type="hidden" name="action" value="clear">
                <button type="submit" class="btn btn-danger" style="margin: 0;">Очистить корзину</button>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php require_once 'views/layouts/footer.php'; ?>
