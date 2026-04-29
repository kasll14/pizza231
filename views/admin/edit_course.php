<?php require_once 'views/layouts/header.php'; ?>

<div class="form-container glass-container">
    <h2 style="text-align: center; color: var(--primary-blue); margin-bottom: 2rem;">Редактировать курс</h2>
    
    <form method="POST" action="<?php echo SITE_URL; ?>/admin/update-course?id=<?php echo $id; ?>">
        <div class="form-group">
            <label for="title">Название курса</label>
            <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($course['title']); ?>">
        </div>
        
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea id="description" name="description" rows="6" required><?php echo htmlspecialchars($course['description']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="price">Цена (руб.)</label>
            <input type="number" id="price" name="price" required min="0" step="0.01" value="<?php echo $course['price']; ?>">
        </div>
        
        <div class="form-group">
            <label for="image">Изображение (название файла)</label>
            <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($course['image']); ?>">
        </div>
        
        <button type="submit" class="btn-admin btn-admin-primary" style="width: 100%;">Сохранить изменения</button>
    </form>
    
    <div style="text-align: center; margin-top: 1.5rem;">
        <a href="<?php echo SITE_URL; ?>/admin/courses" style="color: var(--primary-blue);">Назад к списку курсов</a>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
