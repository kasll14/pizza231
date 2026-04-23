<?php require_once 'views/layouts/header.php'; ?>

<div class="hero">
    <h1>Наши курсы</h1>
    <p>Выберите подходящий курс для развития ваших навыков</p>
</div>

<div class="courses-grid">
    <?php foreach ($courses as $course): ?>
    <div class="course-card">
        <div class="course-image">
            <?php echo strtoupper(substr($course['title'], 0, 2)); ?>
        </div>
        <h3 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h3>
        <p class="course-description"><?php echo htmlspecialchars($course['description']); ?></p>
        <div class="course-price"><?php echo number_format($course['price'], 0, ',', ' '); ?> руб.</div>
        <a href="<?php echo SITE_URL; ?>/course?id=<?php echo $course['id']; ?>" class="btn btn-primary">Подробнее</a>
    </div>
    <?php endforeach; ?>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
