<?php

namespace Views;

use Lib\Language;

class OrderTemplate extends BaseTemplate
{
    public static function getCheckoutTemplate(array $cartItems): string
    {
        $template = parent::getTemplate();
        $title = Language::get('checkout_title') . ' - ' . Language::get('site_name');

        $errors = $_SESSION['order_errors'] ?? [];
        $data = $_SESSION['order_data'] ?? [];
        unset($_SESSION['order_errors']);
        unset($_SESSION['order_data']);

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $priceNum = (int)preg_replace('/[^0-9]/', '', $item['price']);
            $totalPrice += $priceNum;
        }

        $customStyles = '
        <style>
            /* 🌙 ТЁМНАЯ ТЕМА: Стили для оформления заказа */
            .checkout-container {
                background: var(--surface);
                border-radius: 8px;
                padding: 2.5rem;
                box-shadow: var(--shadow);
                border: 1px solid var(--border);
                transition: all 0.3s ease;
            }
            
            .checkout-header {
                text-align: center;
                margin-bottom: 2rem;
            }
            
            .checkout-header h2 {
                color: var(--text) !important;
            }
            
            .checkout-header p {
                color: var(--text-muted) !important;
            }
            
            .order-summary {
                background: var(--surface-hover);
                border-radius: 8px;
                padding: 1.5rem;
                margin-bottom: 2rem;
                border: 1px solid var(--border);
                transition: all 0.3s ease;
            }
            
            .order-item {
                display: flex;
                justify-content: space-between;
                padding: 0.75rem 0;
                border-bottom: 1px solid var(--border);
                transition: border-color 0.3s ease;
                color: var(--text) !important;
            }
            
            .order-item:last-child {
                border-bottom: none;
            }
            
            .form-section {
                background: var(--surface-hover);
                border-radius: 8px;
                padding: 1.5rem;
                margin-bottom: 1.5rem;
                border: 1px solid var(--border);
                transition: all 0.3s ease;
            }
            
            .form-section-title {
                font-size: 1.1rem;
                font-weight: 600;
                color: var(--text) !important;
                margin-bottom: 1rem;
            }
            
            .form-label {
                color: var(--text) !important;
                font-weight: 500;
                margin-bottom: 0.5rem;
                display: block;
            }
            
            .form-control-lg {
                border-radius: 6px;
                border: 1px solid var(--border);
                padding: 0.75rem 1rem;
                background: var(--surface);
                color: var(--text) !important;
                transition: all 0.3s ease;
                width: 100%;
            }
            
            .form-control-lg:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
                background: var(--surface);
                color: var(--text) !important;
                outline: none;
            }
            
            /* 🌙 ТЁМНАЯ ТЕМА: Светлые placeholder\'ы */
            .form-control-lg::placeholder {
                color: #a0aec0;
                opacity: 0.9;
            }
            
            [data-theme="dark"] .form-control-lg {
                background: #2d3748;
                border-color: #4a5568;
                color: #e2e8f0 !important;
            }
            
            [data-theme="dark"] .form-control-lg:focus {
                background: #2d3748;
                border-color: #4299e1;
                color: #e2e8f0 !important;
            }
            
            [data-theme="dark"] .form-control-lg::placeholder {
                color: #a0aec0;
                opacity: 0.9;
            }
            
            .payment-option {
                border: 1px solid var(--border);
                border-radius: 6px;
                padding: 1rem;
                margin-bottom: 0.75rem;
                cursor: pointer;
                transition: all 0.3s ease;
                background: var(--surface);
            }
            
            .payment-option:hover {
                border-color: var(--primary);
                background: var(--badge-bg);
            }
            
            .payment-option.selected {
                border-color: var(--primary);
                background: var(--badge-bg);
            }
            
            .payment-option label {
                color: var(--text) !important;
                font-weight: 500;
                margin: 0;
                cursor: pointer;
                display: block;
            }
            
            .payment-option small {
                color: #a0aec0 !important;
                opacity: 0.9;
            }
            
            [data-theme="dark"] .payment-option {
                background: #2d3748;
                border-color: #4a5568;
            }
            
            [data-theme="dark"] .payment-option:hover,
            [data-theme="dark"] .payment-option.selected {
                background: #2c5282;
                border-color: #4299e1;
            }
            
            .btn-checkout-submit {
                background: var(--primary);
                border: none;
                padding: 1rem 3rem;
                font-size: 1.1rem;
                font-weight: 600;
                border-radius: 6px;
                color: white !important;
                width: 100%;
                transition: background 0.3s ease;
                min-height: 48px;
                cursor: pointer;
            }
            
            .btn-checkout-submit:hover {
                background: var(--primary-dark);
                color: white !important;
            }
            
            .error-message {
                background: rgba(229, 62, 62, 0.15);
                color: var(--danger);
                padding: 0.75rem 1rem;
                border-radius: 6px;
                margin-bottom: 1rem;
                border: 1px solid var(--danger);
            }
            
            .security-badge {
                text-align: center;
                margin-top: 1.5rem;
                padding-top: 1.5rem;
                border-top: 1px solid var(--border);
                color: var(--text-muted);
                font-size: 0.9rem;
                transition: all 0.3s ease;
            }
            
            /* 🌙 ТЁМНАЯ ТЕМА: Специальные стили для тёмной темы */
            [data-theme="dark"] .checkout-container {
                background: #2d3748;
                border-color: #4a5568;
            }
            
            [data-theme="dark"] .order-summary {
                background: #4a5568;
                border-color: #4a5568;
            }
            
            [data-theme="dark"] .form-section {
                background: #4a5568;
                border-color: #4a5568;
            }
            
            [data-theme="dark"] .security-badge {
                color: #a0aec0;
                border-color: #4a5568;
            }
            
            @media (max-width: 768px) {
                .checkout-container {
                    padding: 1.5rem;
                }
            }
            
            @media (max-width: 576px) {
                .checkout-container {
                    padding: 1rem;
                }
            }
        </style>';

        $orderItemsHtml = '';
        foreach ($cartItems as $item) {
            // 🔧 ИСПРАВЛЕНИЕ: Проверка типа данных перед htmlspecialchars
            $title = is_array($item['title']) ? '' : (string)$item['title'];
            $price = is_array($item['price']) ? '' : (string)$item['price'];

            $orderItemsHtml .= '
            <div class="order-item">
                <span>' . htmlspecialchars($title) . '</span>
                <span class="fw-bold">' . htmlspecialchars($price) . '</span>
            </div>';
        }

        $errorHtml = '';
        if (!empty($errors)) {
            $errorMessages = [];
            if (in_array('name', $errors)) {
                $errorMessages[] = Language::get('checkout_error_name');
            }
            if (in_array('email', $errors)) {
                $errorMessages[] = Language::get('checkout_error_email');
            }
            if (in_array('phone', $errors)) {
                $errorMessages[] = Language::get('checkout_error_phone');
            }
            $errorHtml = '<div class="error-message">' . implode(', ', $errorMessages) . '</div>';
        }

        // 🔧 ИСПРАВЛЕНИЕ: Проверка типа данных для полей формы
        $nameValue = isset($data['name']) && !is_array($data['name']) ? htmlspecialchars((string)$data['name']) : '';
        $emailValue = isset($data['email']) && !is_array($data['email']) ? htmlspecialchars((string)$data['email']) : '';
        $phoneValue = isset($data['phone']) && !is_array($data['phone']) ? htmlspecialchars((string)$data['phone']) : '';
        $commentValue = isset($data['comment']) && !is_array($data['comment']) ? htmlspecialchars((string)$data['comment']) : '';

        $content = $customStyles . '
        <section class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="checkout-container">
                        <div class="checkout-header">
                            <h2 class="display-6 fw-bold mb-2">' . Language::get('checkout_title') . '</h2>
                            <p class="mb-0">' . Language::get('checkout_subtitle') . '</p>
                        </div>
                        ' . $errorHtml . '
                        <div class="order-summary">
                            <h4 class="fw-bold mb-3">' . Language::get('checkout_your_order') . '</h4>
                            ' . $orderItemsHtml . '
                            <div class="order-item" style="border-top: 2px solid var(--primary); padding-top: 1rem; margin-top: 0.5rem;">
                                <span class="fw-bold">' . Language::get('cart_total') . ':</span>
                                <span class="fw-bold" style="color: var(--primary); font-size: 1.3rem;">' . number_format($totalPrice, 0, '.', ' ') . ' ₽</span>
                            </div>
                        </div>
                        <form method="POST" action="/cart/order" id="orderForm">
                            <div class="form-section">
                                <div class="form-section-title">' . Language::get('checkout_contact_info') . '</div>
                                <div class="mb-3">
                                    <label class="form-label">' . Language::get('checkout_name') . ' *</label>
                                    <input type="text" name="name" class="form-control form-control-lg" value="' . $nameValue . '" required placeholder="Иванов Иван Иванович">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">' . Language::get('checkout_email') . ' *</label>
                                    <input type="email" name="email" class="form-control form-control-lg" value="' . $emailValue . '" required placeholder="example@mail.ru">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">' . Language::get('checkout_phone') . ' *</label>
                                    <input type="tel" name="phone" class="form-control form-control-lg" value="' . $phoneValue . '" required placeholder="+7 (999) 000-00-00">
                                </div>
                            </div>
                            <div class="form-section">
                                <div class="form-section-title">' . Language::get('checkout_payment_method') . '</div>
                                <div class="payment-option" onclick="selectPayment(this)">
                                    <label>
                                        <input type="radio" name="payment_method" value="card" checked>
                                        <strong>' . Language::get('checkout_payment_card') . '</strong>
                                        <p class="small mb-0" style="color: #a0aec0; opacity: 0.9;">Visa, MasterCard, МИР</p>
                                    </label>
                                </div>
                                <div class="payment-option" onclick="selectPayment(this)">
                                    <label>
                                        <input type="radio" name="payment_method" value="sbp">
                                        <strong>' . Language::get('checkout_payment_sbp') . '</strong>
                                        <p class="small mb-0" style="color: #a0aec0; opacity: 0.9;">' . Language::get('checkout_payment_sbp') . '</p>
                                    </label>
                                </div>
                                <div class="payment-option" onclick="selectPayment(this)">
                                    <label>
                                        <input type="radio" name="payment_method" value="invoice">
                                        <strong>' . Language::get('checkout_payment_invoice') . '</strong>
                                        <p class="small mb-0" style="color: #a0aec0; opacity: 0.9;">' . Language::get('checkout_payment_invoice') . '</p>
                                    </label>
                                </div>
                            </div>
                            <div class="form-section">
                                <div class="form-section-title">' . Language::get('checkout_comment') . '</div>
                                <textarea name="comment" class="form-control form-control-lg" rows="3" placeholder="' . Language::get('checkout_comment_placeholder') . '">' . $commentValue . '</textarea>
                            </div>
                            <button type="submit" class="btn-checkout-submit">' . Language::get('checkout_submit') . '</button>
                            <div class="security-badge">' . Language::get('checkout_security') . '</div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <script>
            function selectPayment(element) {
                document.querySelectorAll(".payment-option").forEach(el => el.classList.remove("selected"));
                element.classList.add("selected");
                element.querySelector("input[type=\'radio\']").checked = true;
            }
            document.querySelector("input[name=\'phone\']").addEventListener("input", function(e) {
                let x = e.target.value.replace(/\D/g, "").match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
                if (!x[2]) {
                    e.target.value = x[1] ? "+7" : "";
                } else {
                    e.target.value = !x[3] ? "+7 (" + x[2] : "+7 (" + x[2] + ") " + x[3] + (x[4] ? "-" + x[4] : "") + (x[5] ? "-" + x[5] : "");
                }
            });
        </script>';

        return str_replace(['{{TITLE}}', '{{CONTENT}}'], [$title, $content], $template);
    }

    public static function getSuccessTemplate(string $orderId): string
    {
        $template = parent::getTemplate();
        $title = Language::get('order_success_title') . ' - ' . Language::get('site_name');

        $customStyles = '
        <style>
            .success-container {
                text-align: center;
                padding: 4rem 2rem;
                background: var(--surface);
                border-radius: 8px;
                box-shadow: var(--shadow);
                border: 1px solid var(--border);
                transition: all 0.3s ease;
            }
            
            .success-icon {
                font-size: 4rem;
                margin-bottom: 1rem;
                color: var(--success);
            }
            
            .order-number {
                background: var(--primary);
                color: white;
                padding: 1rem 2rem;
                border-radius: 6px;
                display: inline-block;
                font-size: 1.3rem;
                font-weight: 600;
                margin: 1.5rem 0;
            }
            
            .success-steps {
                text-align: left;
                background: var(--surface-hover);
                border-radius: 8px;
                padding: 2rem;
                margin: 2rem 0;
                border: 1px solid var(--border);
                transition: all 0.3s ease;
            }
            
            .step {
                display: flex;
                align-items: flex-start;
                margin-bottom: 1rem;
            }
            
            .step-number {
                background: var(--primary);
                color: white;
                width: 30px;
                height: 30px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                margin-right: 1rem;
                flex-shrink: 0;
            }
            
            /* 🌙 ТЁМНАЯ ТЕМА: Улучшенная читаемость текста */
            .step strong {
                color: var(--text) !important;
                display: block;
                margin-bottom: 0.25rem;
            }
            
            .step p {
                color: var(--text-muted) !important;
                opacity: 0.95 !important;
                margin: 0;
            }
            
            /* 🌙 ТЁМНАЯ ТЕМА: Специальные стили для тёмной темы */
            [data-theme="dark"] .success-container {
                background: #2d3748;
                border-color: #4a5568;
            }
            
            [data-theme="dark"] .success-steps {
                background: #4a5568;
                border-color: #4a5568;
            }
            
            [data-theme="dark"] .step p {
                color: #cbd5e0 !important;
                opacity: 1 !important;
            }
            
            [data-theme="dark"] .step strong {
                color: #e2e8f0 !important;
            }
            
            @media (max-width: 576px) {
                .success-container {
                    padding: 2rem 1rem;
                }
            }
        </style>';

        $content = $customStyles . '
        <section class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="success-container">
                        <div class="success-icon">✓</div>
                        <h2 class="display-5 fw-bold mb-3" style="color: var(--text);">' . Language::get('order_success_title') . '</h2>
                        <p class="lead" style="color: var(--text-muted); opacity: 0.95;">' . Language::get('order_success_message') . '</p>
                        <div class="order-number">' . Language::get('order_number') . ' ' . htmlspecialchars($orderId) . '</div>
                        <div class="success-steps">
                            <h4 class="fw-bold mb-3" style="color: var(--text);">' . Language::get('order_next_steps') . '</h4>
                            <div class="step">
                                <div class="step-number">1</div>
                                <div>
                                    <strong>' . Language::get('order_step1_title') . '</strong>
                                    <p>' . Language::get('order_step1_desc') . '</p>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">2</div>
                                <div>
                                    <strong>' . Language::get('order_step2_title') . '</strong>
                                    <p>' . Language::get('order_step2_desc') . '</p>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">3</div>
                                <div>
                                    <strong>' . Language::get('order_step3_title') . '</strong>
                                    <p>' . Language::get('order_step3_desc') . '</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
                            <a href="/courses" class="btn btn-primary btn-lg px-4">' . Language::get('order_continue_shopping') . '</a>
                            <a href="mailto:info@kemt.ru" class="btn btn-outline-primary btn-lg px-4">' . Language::get('order_contact_us') . '</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>';

        return str_replace(['{{TITLE}}', '{{CONTENT}}'], [$title, $content], $template);
    }
}
