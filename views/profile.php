<?php require_once 'views/layouts/header.php'; ?>

<div class="hero">
    <h1>Личный кабинет</h1>
    <p>Управление профилем и историей заказов</p>
</div>

<?php if (isset($success)): ?>
    <div class="success-message">
        <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="error-message">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<div class="profile-container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 3rem;">
    <!-- Информация о пользователе -->
    <div class="glass-container" style="padding: 2rem;">
        <h2 style="color: var(--primary-blue); margin-bottom: 1.5rem;">Информация о профиле</h2>
        
        <form method="POST" action="<?php echo SITE_URL; ?>/profile/update" style="margin-bottom: 2rem;">
            <div class="form-group">
                <label for="login">Логин</label>
                <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($userData['login'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Дата регистрации</label>
                <input type="text" value="<?php echo date('d.m.Y H:i', strtotime($userData['created_at'] ?? 'now')); ?>" disabled style="background: rgba(0,0,0,0.05);">
            </div>
            
            <div class="form-group">
                <label>Статус</label>
                <input type="text" value="<?php echo $userData['email_verified'] ? 'Подтверждён' : 'Не подтверждён'; ?>" disabled style="background: rgba(0,0,0,0.05);">
            </div>
            
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
        
        <hr style="border: none; border-top: 1px solid rgba(0,0,0,0.1); margin: 2rem 0;">
        
        <h3 style="color: var(--primary-blue); margin-bottom: 1rem;">Сменить пароль</h3>
        <form method="POST" action="<?php echo SITE_URL; ?>/profile/change-password">
            <div class="form-group">
                <label for="current_password">Текущий пароль</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            
            <div class="form-group">
                <label for="new_password">Новый пароль</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Подтверждение пароля</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-success">Изменить пароль</button>
        </form>
    </div>
    
    <!-- Статистика -->
    <div class="glass-container" style="padding: 2rem;">
        <h2 style="color: var(--primary-blue); margin-bottom: 1.5rem;">Статистика</h2>
        
        <div class="admin-stats" style="grid-template-columns: 1fr;">
            <div class="stat-card">
                <div class="stat-number" style="color: var(--primary-green);"><?php echo count($orderDetails); ?></div>
                <div class="stat-label">Всего заказов</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-number" style="color: var(--primary-blue);">
                    <?php 
                    $totalSpent = 0;
                    foreach ($orderDetails as $order) {
                        $totalSpent += $order['total_amount'];
                    }
                    echo number_format($totalSpent, 0, '.', ' ');
                    ?>
                </div>
                <div class="stat-label">Общая сумма (руб.)</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-number" style="color: var(--aero-green);">
                    <?php 
                    $completedOrders = 0;
                    foreach ($orderDetails as $order) {
                        if ($order['status'] === 'completed') {
                            $completedOrders++;
                        }
                    }
                    echo $completedOrders;
                    ?>
                </div>
                <div class="stat-label">Выполненных заказов</div>
            </div>
        </div>
        
        <div style="margin-top: 2rem; padding: 1.5rem; background: rgba(124, 179, 66, 0.1); border-radius: 15px;">
            <h4 style="color: var(--primary-green); margin-bottom: 0.5rem;">🎓 Доступно курсов</h4>
            <p style="color: #666; margin-bottom: 1rem;">
                После оплаты заказанных курсов они появятся в вашем личном кабинете для изучения.
            </p>
            <a href="<?php echo SITE_URL; ?>/courses" class="btn btn-primary" style="font-size: 0.9rem;">Смотреть каталог</a>
        </div>
    </div>
</div>

<!-- История заказов -->
<div class="glass-container" style="padding: 2rem; margin-bottom: 2rem;">
    <h2 style="color: var(--primary-blue); margin-bottom: 1.5rem;">История заказов</h2>
    
    <?php if (empty($orderDetails)): ?>
        <div style="text-align: center; padding: 3rem; color: #666;">
            <p style="font-size: 1.2rem; margin-bottom: 1rem;">У вас пока нет заказов</p>
            <a href="<?php echo SITE_URL; ?>/courses" class="btn btn-primary">Перейти к курсам</a>
        </div>
    <?php else: ?>
        <div class="table-container" style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>№ заказа</th>
                        <th>Дата</th>
                        <th>Курсы</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderDetails as $order): ?>
                        <tr>
                            <td style="font-weight: 600; color: var(--primary-blue);">
                                <?php echo htmlspecialchars($order['order_number']); ?>
                            </td>
                            <td><?php echo date('d.m.Y H:i', strtotime($order['created_at'])); ?></td>
                            <td>
                                <ul style="list-style: none; padding: 0; margin: 0;">
                                    <?php foreach ($order['items'] as $item): ?>
                                        <li style="padding: 0.3rem 0; color: #666;">
                                            • <?php echo htmlspecialchars($item['title'] ?? 'Курс удалён'); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td style="font-weight: 600; color: var(--primary-green);">
                                <?php echo number_format($order['total_amount'], 0, '.', ' '); ?> ₽
                            </td>
                            <td>
                                <?php
                                $statusColors = [
                                    'pending' => '#ff9800',
                                    'paid' => '#2196f3',
                                    'completed' => '#4caf50',
                                    'cancelled' => '#f44336'
                                ];
                                $statusLabels = [
                                    'pending' => 'В обработке',
                                    'paid' => 'Оплачен',
                                    'completed' => 'Выполнен',
                                    'cancelled' => 'Отменён'
                                ];
                                $status = $order['status'] ?? 'pending';
                                ?>
                                <span style="display: inline-block; padding: 0.3rem 0.8rem; border-radius: 15px; background: <?php echo $statusColors[$status] ?? '#999'; ?>; color: white; font-size: 0.85rem; font-weight: 600;">
                                    <?php echo $statusLabels[$status] ?? $status; ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-admin btn-admin-primary" style="padding: 0.4rem 1rem; font-size: 0.85rem;" onclick="showOrderDetails('<?php echo $order['order_number']; ?>')">
                                    Подробнее
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Модальное окно с деталями заказа -->
<div id="orderModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; align-items: center; justify-content: center;">
    <div class="glass-container" style="max-width: 600px; width: 90%; padding: 2rem; position: relative; max-height: 80vh; overflow-y: auto;">
        <button onclick="closeOrderModal()" style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #666;">&times;</button>
        
        <h3 style="color: var(--primary-blue); margin-bottom: 1rem;">Детали заказа <span id="modalOrderNumber" style="color: var(--primary-green);"></span></h3>
        
        <div id="modalOrderContent">
            <!-- Контент заполняется через JS -->
        </div>
    </div>
</div>

<script>
<?php
// Передаём данные заказов в JavaScript
$orderData = [];
foreach ($orderDetails as $order) {
    $orderData[$order['order_number']] = [
        'number' => $order['order_number'],
        'date' => date('d.m.Y H:i', strtotime($order['created_at'])),
        'status' => $order['status'] ?? 'pending',
        'total' => number_format($order['total_amount'], 0, '.', ' '),
        'items' => $order['items']
    ];
}
?>
const ordersData = <?php echo json_encode($orderData, JSON_UNESCAPED_UNICODE); ?>;

function showOrderDetails(orderNumber) {
    const order = ordersData[orderNumber];
    if (!order) return;
    
    document.getElementById('modalOrderNumber').textContent = order.number;
    
    let itemsHtml = '';
    order.items.forEach(item => {
        itemsHtml += `
            <div style="padding: 1rem; margin: 0.5rem 0; background: rgba(0, 120, 215, 0.05); border-radius: 10px;">
                <h4 style="color: var(--primary-blue); margin-bottom: 0.3rem;">${item.title || 'Курс удалён'}</h4>
                <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">${item.description ? item.description.substring(0, 100) + '...' : ''}</p>
                <div style="font-weight: 600; color: var(--primary-green);">${item.price} ₽</div>
            </div>
        `;
    });
    
    const statusLabels = {
        'pending': 'В обработке',
        'paid': 'Оплачен',
        'completed': 'Выполнен',
        'cancelled': 'Отменён'
    };
    
    document.getElementById('modalOrderContent').innerHTML = `
        <div style="margin-bottom: 1.5rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <div style="color: #666; font-size: 0.9rem;">Дата заказа</div>
                    <div style="font-weight: 600;">${order.date}</div>
                </div>
                <div>
                    <div style="color: #666; font-size: 0.9rem;">Статус</div>
                    <div style="font-weight: 600; color: ${getStatusColor(order.status)}">${statusLabels[order.status] || order.status}</div>
                </div>
            </div>
            <div>
                <div style="color: #666; font-size: 0.9rem;">Общая сумма</div>
                <div style="font-size: 1.5rem; font-weight: bold; color: var(--primary-green);">${order.total} ₽</div>
            </div>
        </div>
        
        <h4 style="color: var(--primary-blue); margin: 1.5rem 0 1rem;">Товары в заказе</h4>
        ${itemsHtml}
    `;
    
    document.getElementById('orderModal').style.display = 'flex';
}

function closeOrderModal() {
    document.getElementById('orderModal').style.display = 'none';
}

function getStatusColor(status) {
    const colors = {
        'pending': '#ff9800',
        'paid': '#2196f3',
        'completed': '#4caf50',
        'cancelled': '#f44336'
    };
    return colors[status] || '#999';
}

// Закрытие модального окна по клику вне его
document.getElementById('orderModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeOrderModal();
    }
});
</script>

<?php require_once 'views/layouts/footer.php'; ?>
