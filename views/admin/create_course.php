<?php require_once 'views/layouts/header.php'; ?>

<div class="form-container glass-container">
    <h2 style="text-align: center; color: var(--primary-blue); margin-bottom: 2rem;">Добавить новый курс</h2>
    
    <form method="POST" action="<?php echo SITE_URL; ?>/admin/create-course">
        <div class="form-group">
            <label for="title">Название курса</label>
            <input type="text" id="title" name="title" required placeholder="Введите название курса">
        </div>
        
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea id="description" name="description" rows="6" required placeholder="Подробное описание курса"></textarea>
        </div>
        
        <div class="form-group">
            <label for="price">Цена (руб.)</label>
            <input type="number" id="price" name="price" required min="0" step="0.01" placeholder="0.00">
        </div>
        
        <div class="form-group">
            <label for="image">Изображение (название файла)</label>
            <input type="text" id="image" name="image" placeholder="default.jpg">
        </div>
        
        <button type="submit" class="btn-admin btn-admin-success" style="width: 100%;">Создать курс</button>
    </form>
    
    <div style="text-align: center; margin-top: 1.5rem;">
        <a href="<?php echo SITE_URL; ?>/admin/courses" style="color: var(--primary-blue);">Назад к списку курсов</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
