<?php
namespace Views;
class BaseTemplate
{
    public static function getTemplate(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $cartCount = count($_SESSION['cart'] ?? []);
        $cartBadge = $cartCount > 0 ? '<span class="cart-count">' . $cartCount . '</span>' : '';
        return '
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{TITLE}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2c5282;
            --primary-dark: #1a365d;
            --secondary: #4a5568;
            --background: #f7fafc;
            --surface: #ffffff;
            --text: #2d3748;
            --text-muted: #718096;
            --border: #e2e8f0;
            --success: #38a169;
            --danger: #e53e3e;
        }
        body {
            font-family: "Inter", system-ui, -apple-system, sans-serif;
            color: var(--text);
            background: var(--background);
            line-height: 1.6;
        }
        .navbar {
            background: var(--surface) !important;
            border-bottom: 1px solid var(--border);
            padding: 1rem 0;
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--text) !important;
            font-size: 1.25rem;
        }
        .nav-link {
            color: var(--text) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: color 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
        }
        .cart-count {
            background: var(--danger);
            color: white;
            border-radius: 50%;
            padding: 0.15rem 0.45rem;
            font-size: 0.7rem;
            font-weight: 600;
            position: absolute;
            top: -4px;
            right: -8px;
            min-width: 18px;
            text-align: center;
        }
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .toast-notification {
            background: var(--success);
            color: white;
            border-radius: 8px;
            padding: 1rem 1.25rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: none;
            animation: slideIn 0.3s ease;
            font-weight: 500;
        }
        .toast-notification.show {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .toast-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.25rem;
            cursor: pointer;
            opacity: 0.9;
            margin-left: 0.5rem;
        }
        .toast-close:hover { opacity: 1; }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        footer {
            background: var(--primary-dark);
            color: rgba(255,255,255,0.85);
            padding: 2.5rem 0 1.5rem;
            margin-top: 4rem;
        }
        footer a { color: rgba(255,255,255,0.9); text-decoration: none; }
        footer a:hover { color: white; }
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            font-weight: 500;
            padding: 0.625rem 1.5rem;
            border-radius: 6px;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        .container { max-width: 1200px; }
    </style>
</head>
<body>
    <div class="toast-container">
        <div class="toast-notification" id="cartToast">
            <span id="toastMessage">Товар добавлен в корзину</span>
            <button class="toast-close" onclick="hideToast()">×</button>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                GeeK Legend
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/home">Главная</a></li>
                    <li class="nav-item"><a class="nav-link" href="/courses">Курсы</a></li>
                    <li class="nav-item"><a class="nav-link" href="/about">О техникуме</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cart" style="position: relative;">
                            Корзина
                            ' . $cartBadge . '
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <main>{{CONTENT}}</main>
    
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold text-white mb-3">Кемеровский кооперативный техникум</h5>
                    <p class="small mb-0">Официальный сайт учебного заведения среднего профессионального образования</p>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold text-white mb-3">Контакты</h6>
                    <p class="small mb-1">650066, г. Кемерово, ул. Тухачевского, 32а</p>
                    <p class="small mb-1">
                        <a href="tel:+73842396000">+7 (3842) 39-60-00</a>
                    </p>
                    <p class="small mb-0">
                        <a href="mailto:info@kemt.ru">info@kemt.ru</a>
                    </p>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold text-white mb-3">Режим работы</h6>
                    <p class="small mb-0">Пн-Сб: 8:00–19:45, Вс: выходной</p>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.15);">
            <p class="small text-center mb-0">
                &copy; ' . date('Y') . ' Кемеровский кооперативный техникум. Все права защищены.
            </p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function showToast(message, duration) {
        duration = duration || 3000;
        var toast = document.getElementById("cartToast");
        var toastMessage = document.getElementById("toastMessage");
        toastMessage.textContent = message;
        toast.classList.add("show");
        setTimeout(function() { hideToast(); }, duration);
    }
    function hideToast() {
        document.getElementById("cartToast").classList.remove("show");
    }
    function updateCartCount(count) {
        var badge = document.querySelector(".cart-count");
        var cartLink = document.querySelector("a[href=\"/cart\"]");
        if (count > 0) {
            if (!badge) {
                var newBadge = document.createElement("span");
                newBadge.className = "cart-count";
                newBadge.textContent = count;
                cartLink.appendChild(newBadge);
            } else {
                badge.textContent = count;
            }
        } else if (badge) {
            badge.remove();
        }
    }
    document.addEventListener("DOMContentLoaded", function() {
        var forms = document.querySelectorAll("form[action=\"/cart/add\"]");
        forms.forEach(function(form) {
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                fetch("/cart/add", { 
                    method: "POST", 
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(function(response) { 
                    if (response.ok) {
                        showToast("Курс успешно добавлен в корзину");
                        fetch("/cart/count").then(function(r) { return r.json(); }).then(function(data) { 
                            updateCartCount(data.count);
                        });
                    } else {
                        showToast("Ошибка при добавлении в корзину");
                    }
                }).catch(function() { showToast("Ошибка сети"); });
            });
        });
    });
    </script>
</body>
</html>';
    }
}