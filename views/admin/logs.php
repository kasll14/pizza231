<?php require_once 'views/layouts/header.php'; ?>

<div class="admin-sidebar" style="max-width: 1200px; margin: 0 auto 2rem;">
    <h2 style="color: var(--primary-blue); margin-bottom: 1.5rem;">Логи системы</h2>
    
    <div class="logs-container">
        <pre><?php 
        foreach ($logs as $log) {
            echo $log . "\n";
        }
        ?></pre>
    </div>
    
    <div style="margin-top: 1rem;">
        <button onclick="location.reload()" class="btn-admin btn-admin-primary">Обновить</button>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
