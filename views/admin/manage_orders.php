<?php require_once 'views/layouts/header.php'; ?>

<div class="admin-sidebar" style="max-width: 1200px; margin: 0 auto 2rem;">
    <h2 style="color: var(--primary-blue); margin-bottom: 1.5rem;">Управление заказами</h2>
    
    <table class="table">
        <thead>
            <tr>
                <th>№ Заказа</th>
                <th>Пользователь</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Дата</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo htmlspecialchars($order['order_number']); ?></td>
                <td><?php echo htmlspecialchars($order['email']); ?></td>
                <td><?php echo number_format($order['total_amount'], 0, ',', ' '); ?> руб.</td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                        <select name="status" onchange="this.form.submit()" style="padding: 0.5rem; border-radius: 5px; border: 1px solid var(--primary-blue);">
                            <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Ожидает</option>
                            <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>В обработке</option>
                            <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>Завершен</option>
                            <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Отменен</option>
                        </select>
                        <input type="hidden" name="update_status" value="1">
                    </form>
                </td>
                <td><?php echo date('d.m.Y H:i', strtotime($order['created_at'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
