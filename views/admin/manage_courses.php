<?php require_once 'views/layouts/header.php'; ?>

<div class="admin-sidebar" style="max-width: 1200px; margin: 0 auto 2rem;">
    <h2 style="color: var(--primary-blue); margin-bottom: 1.5rem;">Управление курсами</h2>
    
    <div style="margin-bottom: 2rem;">
        <a href="<?php echo SITE_URL; ?>/admin/create-course" class="btn-admin btn-admin-success">Добавить новый курс</a>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Дата создания</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): ?>
            <tr>
                <td><?php echo $course['id']; ?></td>
                <td><?php echo htmlspecialchars($course['title']); ?></td>
                <td><?php echo number_format($course['price'], 0, ',', ' '); ?> руб.</td>
                <td><?php echo date('d.m.Y', strtotime($course['created_at'])); ?></td>
                <td>
                    <a href="<?php echo SITE_URL; ?>/admin/update-course?id=<?php echo $course['id']; ?>" class="btn-admin btn-admin-primary">Изменить</a>
                    <a href="<?php echo SITE_URL; ?>/admin/delete-course?id=<?php echo $course['id']; ?>" class="btn-admin btn-admin-danger" onclick="return confirm('Вы уверены, что хотите удалить этот курс?')">Удалить</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
