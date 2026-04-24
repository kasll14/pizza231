<?php require_once 'views/layouts/header.php'; ?>

<div style="max-width: 1200px; margin: 0 auto;">
    <h2 style="color: var(--primary-blue); margin-bottom: 2rem;">Панель администратора</h2>
    
    <div class="admin-stats">
        <div class="stat-card">
            <div class="stat-number"><?php echo $totalUsers; ?></div>
            <div class="stat-label">Пользователей</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $totalOrders; ?></div>
            <div class="stat-label">Заказов</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $totalCourses; ?></div>
            <div class="stat-label">Курсов</div>
        </div>
    </div>
    
    <div class="admin-sidebar">
        <h3 style="color: var(--primary-blue); margin-bottom: 1rem;">Последние заказы</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>№ Заказа</th>
                    <th>Пользователь</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentOrders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['order_number']); ?></td>
                    <td><?php echo htmlspecialchars($order['email'] ?? '—'); ?></td>
                    <td><?php echo number_format($order['total_amount'], 0, ',', ' '); ?> руб.</td>
                    <td><?php echo $order['status']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="admin-sidebar">
        <h3 style="color: var(--primary-blue); margin-bottom: 1rem;">Быстрые действия</h3>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="<?php echo SITE_URL; ?>/admin/courses" class="btn-admin btn-admin-primary">Управление курсами</a>
            <a href="<?php echo SITE_URL; ?>/admin/users" class="btn-admin btn-admin-primary">Управление пользователями</a>
            <a href="<?php echo SITE_URL; ?>/admin/orders" class="btn-admin btn-admin-primary">Управление заказами</a>
            <a href="<?php echo SITE_URL; ?>/admin/logs" class="btn-admin btn-admin-primary">Просмотр логов</a>
            <a href="<?php echo SITE_URL; ?>/admin/create-course" class="btn-admin btn-admin-success">Добавить курс</a>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
