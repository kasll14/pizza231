<?php require_once 'views/layouts/header.php'; ?>

<div class="course-card" style="max-width: 800px; margin: 0 auto;">
    <div class="course-image" style="height: 300px; font-size: 5rem;">
        <?php echo strtoupper(substr($course['title'], 0, 2)); ?>
    </div>
    
    <h1 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h1>
    
    <div class="course-price" style="font-size: 2.5rem; margin: 1.5rem 0;">
        <?php echo number_format($course['price'], 0, ',', ' '); ?> руб.
    </div>
    
    <div style="margin: 2rem 0;">
        <h3 style="color: var(--primary-blue); margin-bottom: 1rem;">О курсе</h3>
        <p style="font-size: 1.1rem; line-height: 1.8; color: #555;">
            <?php echo nl2br(htmlspecialchars($course['description'])); ?>
        </p>
    </div>
    
    <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: center; align-items: center;">
        <?php if (isset($_SESSION['user_id'])): ?>
        <form method="POST" action="<?php echo SITE_URL; ?>/cart-action" style="display: inline; margin: 0;">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
            <button type="submit" class="btn btn-success" style="margin: 0;">Добавить в корзину</button>
        </form>
        <?php else: ?>
        <a href="<?php echo SITE_URL; ?>/login" class="btn btn-primary">Войдите, чтобы купить курс</a>
        <?php endif; ?>
        
        <a href="<?php echo SITE_URL; ?>/courses" class="btn btn-primary">Назад к курсам</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
