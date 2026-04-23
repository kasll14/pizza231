<?php require_once 'views/layouts/header.php'; ?>

<div class="hero">
    <h1>О нас</h1>
    <p>Узнайте больше о нашей компании и наших целях</p>
</div>

<div class="about-content">
    <h2 style="color: var(--primary-blue); margin-bottom: 1.5rem;">Кемеровский Кооперативный Техникум</h2>
    
    <div style="margin-bottom: 2rem;">
        <p style="font-size: 1.1rem; line-height: 1.8; margin-bottom: 1rem;">
            Мы — команда энтузиастов, стремящихся сделать качественное образование доступным для каждого. 
            Наши курсы разработаны опытными специалистами и охватывают самые востребованные направления в сфере IT и цифровых технологий.
        </p>
        <p style="font-size: 1.1rem; line-height: 1.8; margin-bottom: 1rem;">
            Используя современные методики обучения и интерактивные платформы, мы помогаем студентам 
            освоить новые навыки и успешно развиваться в цифровой среде.
        </p>
    </div>
    
    <h3 style="color: var(--primary-blue); margin: 2rem 0 1rem;">Наши преимущества</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
        <div style="background: rgba(255, 255, 255, 0.7); padding: 1.5rem; border-radius: 15px;">
            <h4 style="color: var(--primary-green); margin-bottom: 0.5rem;">Современные методики</h4>
            <p style="color: #666;">Практико-ориентированный подход к обучению</p>
        </div>
        <div style="background: rgba(255, 255, 255, 0.7); padding: 1.5rem; border-radius: 15px;">
            <h4 style="color: var(--primary-green); margin-bottom: 0.5rem;">Опытные преподаватели</h4>
            <p style="color: #666;">Специалисты с реальным опытом работы</p>
        </div>
        <div style="background: rgba(255, 255, 255, 0.7); padding: 1.5rem; border-radius: 15px;">
            <h4 style="color: var(--primary-green); margin-bottom: 0.5rem;">Гибкий график</h4>
            <p style="color: #666;">Учитесь в удобное для вас время</p>
        </div>
        <div style="background: rgba(255, 255, 255, 0.7); padding: 1.5rem; border-radius: 15px;">
            <h4 style="color: var(--primary-green); margin-bottom: 0.5rem;">Сертификаты</h4>
            <p style="color: #666;">Официальное подтверждение квалификации</p>
        </div>
    </div>
</div>

<div class="about-content">
    <h2 style="color: var(--primary-blue); margin-bottom: 1.5rem; text-align: center;">Наш адрес</h2>
    <p style="text-align: center; margin-bottom: 2rem; font-size: 1.1rem;">
        Кемеровский Кооперативный Техникум<br>
        г. Кемерово, Россия
    </p>
    
    <div class="map-container">
        <div id="yandex-map" style="width: 100%; height: 100%;"></div>
    </div>
</div>

<script src="https://api-maps.yandex.ru/2.1/?apikey=your_api_key&lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
    ymaps.ready(init);
    
    function init() {
        var myMap = new ymaps.Map("yandex-map", {
            center: [55.333333, 86.083333],
            zoom: 15,
            controls: ['zoomControl', 'fullscreenControl']
        });
        
        var myPlacemark = new ymaps.Placemark([55.333333, 86.083333], {
            hintContent: 'Кемеровский Кооперативный Техникум',
            balloonContent: '<strong>Кемеровский Кооперативный Техникум</strong><br>Наш адрес'
        }, {
            preset: 'islands#blueEducationIcon'
        });
        
        myMap.geoObjects.add(myPlacemark);
    }
</script>

<?php require_once 'views/layouts/footer.php'; ?>
