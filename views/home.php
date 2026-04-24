<?php require_once 'views/layouts/header.php'; ?>

<div class="hero">
    <h1>Добро пожаловать в мир онлайн-образования</h1>
    <p>Откройте для себя современные курсы в стиле Frutiger Aero</p>
    <a href="<?php echo SITE_URL; ?>/courses" class="btn btn-primary">Смотреть курсы</a>
</div>

<h2 style="text-align: center; color: var(--primary-blue); margin-bottom: 2rem;">Наши популярные курсы</h2>

<div class="courses-grid">
    <?php foreach (array_slice($courses, 0, 3) as $course): ?>
    <div class="course-card">
        <div class="course-image">
            <?php echo strtoupper(substr($course['title'], 0, 2)); ?>
        </div>
        <h3 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h3>
        <p class="course-description"><?php echo htmlspecialchars(substr($course['description'], 0, 100)) . '...'; ?></p>
        <div class="course-price"><?php echo number_format($course['price'], 0, ',', ' '); ?> руб.</div>
        <a href="<?php echo SITE_URL; ?>/course?id=<?php echo $course['id']; ?>" class="btn btn-primary">Подробнее</a>
    </div>
    <?php endforeach; ?>
</div>

<div style="text-align: center; margin-top: 3rem;">
    <a href="<?php echo SITE_URL; ?>/courses" class="btn btn-success">Все курсы</a>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
