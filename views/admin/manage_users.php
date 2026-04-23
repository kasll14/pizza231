<?php require_once 'views/layouts/header.php'; ?>

<div class="admin-sidebar" style="max-width: 1200px; margin: 0 auto 2rem;">
    <h2 style="color: var(--primary-blue); margin-bottom: 1.5rem;">Управление пользователями</h2>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Дата регистрации</th>
                <th>Роль</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo date('d.m.Y H:i', strtotime($user['created_at'])); ?></td>
                <td>
                    <?php if ($user['is_admin']): ?>
                        <span style="color: var(--primary-green); font-weight: bold;">Администратор</span>
                    <?php else: ?>
                        <span style="color: #666;">Пользователь</span>
                    <?php endif; ?>
                </td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <?php if ($user['is_admin']): ?>
                            <button type="submit" name="toggle_admin" class="btn-admin btn-admin-primary">Снять админа</button>
                        <?php else: ?>
                            <button type="submit" name="toggle_admin" class="btn-admin btn-admin-primary">Сделать админом</button>
                        <?php endif; ?>
                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                            <button type="submit" name="delete_user" class="btn-admin btn-admin-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
