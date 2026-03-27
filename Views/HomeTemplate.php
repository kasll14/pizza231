<?php
namespace Views;
// 🌐 LANG: Добавлен импорт Language
use Lib\Language;

class HomeTemplate extends BaseTemplate
{
    public static function getTemplate(): string
    {
        $template = parent::getTemplate();
        // 🌐 LANG: Заголовок с переводом
        $title = Language::get('home_hero_title') . ' - ' . Language::get('site_name');
        
        // 🌐 LANG: Получение всех переводов для главной страницы
        $heroTitle = Language::get('home_hero_title');
        $heroSubtitle = Language::get('home_hero_subtitle');
        $featuresTitle = Language::get('home_features_title');
        $ctaButton = Language::get('home_cta');
        $siteName = Language::get('site_name');
        
        $feature1Title = Language::get('home_feature_1_title');
        $feature1Desc = Language::get('home_feature_1_desc');
        $feature2Title = Language::get('home_feature_2_title');
        $feature2Desc = Language::get('home_feature_2_desc');
        $feature3Title = Language::get('home_feature_3_title');
        $feature3Desc = Language::get('home_feature_3_desc');
        
        $statsStudents = Language::get('home_stats_students');
        $statsCourses = Language::get('home_stats_courses');
        $statsEmployment = Language::get('home_stats_employment');
        
        $customStyles = '
<style>
.hero-section {
background: linear-gradient(135deg, #2c5282 0%, #1a365d 100%);
color: white;
padding: 5rem 0;
margin-bottom: 3rem;
border-radius: 0 0 20px 20px;
}
.hero-title {
font-size: 3rem;
font-weight: 700;
margin-bottom: 1.5rem;
}
.hero-subtitle {
font-size: 1.25rem;
opacity: 0.95;
max-width: 700px;
margin: 0 auto 2rem auto;
}
.hero-cta {
background: #fff;
color: #2c5282;
padding: 1rem 2.5rem;
font-size: 1.1rem;
font-weight: 600;
border-radius: 8px;
text-decoration: none;
display: inline-block;
transition: all 0.3s ease;
}
.hero-cta:hover {
background: #ebf4ff;
color: #2c5282;
text-decoration: none;
transform: translateY(-2px);
}
.feature-box {
background: #f7fafc;
border-radius: 12px;
padding: 2rem;
text-align: center;
height: 100%;
transition: transform 0.3s ease, box-shadow 0.3s ease;
border: 1px solid #e2e8f0;
}
.feature-box:hover {
transform: translateY(-5px);
background: #fff;
box-shadow: 0 8px 20px rgba(0,0,0,0.08);
border-color: #2c5282;
}
.feature-icon {
font-size: 2.5rem;
font-weight: 700;
margin-bottom: 1.5rem;
display: inline-block;
background: #ebf4ff;
width: 80px;
height: 80px;
line-height: 80px;
border-radius: 12px;
color: #2c5282;
}
.stats-grid {
display: grid;
grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
gap: 2rem;
margin: 3rem 0;
}
.stat-item {
text-align: center;
padding: 2rem;
background: #fff;
border-radius: 12px;
border: 1px solid #e2e8f0;
}
.stat-number {
font-size: 3rem;
font-weight: 700;
color: #2c5282;
display: block;
}
.stat-label {
color: #718096;
font-size: 1rem;
}
</style>';
        
        $content = $customStyles . '
<section class="hero-section text-center">
<div class="container">
<!-- 🌐 LANG: Тексты главной страницы с переводом -->
<h1 class="hero-title">' . $heroTitle . '</h1>
<p class="hero-subtitle">' . $heroSubtitle . '</p>
<a href="/courses" class="hero-cta">' . $ctaButton . '</a>
</div>
</section>
<section class="container py-5">
<div class="text-center mb-5">
<h2 class="fw-bold">' . $featuresTitle . '</h2>
<div style="width: 60px; height: 4px; background: #2c5282; margin: 15px auto;"></div>
</div>
<div class="row g-4">
<div class="col-md-4">
<div class="feature-box">
<div class="feature-icon">ПР</div>
<h5 class="fw-bold mb-3">' . $feature1Title . '</h5>
<p class="text-muted mb-0">' . $feature1Desc . '</p>
</div>
</div>
<div class="col-md-4">
<div class="feature-box">
<div class="feature-icon">ОП</div>
<h5 class="fw-bold mb-3">' . $feature2Title . '</h5>
<p class="text-muted mb-0">' . $feature2Desc . '</p>
</div>
</div>
<div class="col-md-4">
<div class="feature-box">
<div class="feature-icon">ТР</div>
<h5 class="fw-bold mb-3">' . $feature3Title . '</h5>
<p class="text-muted mb-0">' . $feature3Desc . '</p>
</div>
</div>
</div>
<div class="stats-grid">
<div class="stat-item">
<span class="stat-number">2000+</span>
<span class="stat-label">' . $statsStudents . '</span>
</div>
<div class="stat-item">
<span class="stat-number">12</span>
<span class="stat-label">' . $statsCourses . '</span>
</div>
<div class="stat-item">
<span class="stat-number">94%</span>
<span class="stat-label">' . $statsEmployment . '</span>
</div>
</div>
</section>';
        
        return str_replace(['{{TITLE}}', '{{CONTENT}}'], [$title, $content], $template);
    }
}