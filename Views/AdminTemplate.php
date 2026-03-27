<?php
namespace Views;

use Lib\Language;

class AdminTemplate extends BaseTemplate
{
    public static function getDashboardTemplate(array $stats): string
    {
        $template = parent::getTemplate();
        $title = Language::get('admin_dashboard') . ' - ' . Language::get('site_name');
        
        $content = '
<style>
.admin-container{max-width:1400px;margin:2rem auto}
.admin-header{background:linear-gradient(135deg,#2c5282,#1a365d);color:#fff;padding:2rem;border-radius:12px;margin-bottom:2rem}
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:1.5rem;margin-bottom:2rem}
.stat-card{background:#fff;padding:2rem;border-radius:12px;border:1px solid #e2e8f0;text-align:center}
.stat-number{font-size:2.5rem;font-weight:700;color:#2c5282}
.stat-label{color:#718096;margin-top:0.5rem}
.admin-nav{display:flex;gap:1rem;margin-bottom:2rem;flex-wrap:wrap}
.admin-nav a{padding:0.75rem 1.5rem;background:#fff;border:1px solid #e2e8f0;border-radius:6px;text-decoration:none;color:#2c5282;font-weight:500}
.admin-nav a.active{background:#2c5282;color:#fff}
.recent-orders{background:#fff;border-radius:12px;padding:1.5rem;border:1px solid #e2e8f0}
.order-row{display:grid;grid-template-columns:1fr 2fr 1fr 1fr 1fr;gap:1rem;padding:1rem;border-bottom:1px solid #e2e8f0;align-items:center}
.order-row:last-child{border-bottom:none}
.order-row.header{background:#f7fafc;font-weight:600}
.status-badge{padding:0.25rem 0.75rem;border-radius:4px;color:#fff;font-size:0.85rem}
</style>
<section class="container py-5">
<div class="admin-container">
<div class="admin-header"><h1 class="mb-2">'.Language::get('admin_dashboard').'</h1><p class="mb-0 opacity-75">'.Language::get('admin_orders').'</p></div>
<div class="stats-grid">
<div class="stat-card"><div class="stat-number">'.$stats['totalOrders'].'</div><div class="stat-label">'.Language::get('admin_total_orders').'</div></div>
<div class="stat-card"><div class="stat-number">'.number_format($stats['totalRevenue'],0,'.',' ').' ₽</div><div class="stat-label">'.Language::get('admin_total_revenue').'</div></div>
<div class="stat-card"><div class="stat-number">'.$stats['pendingOrders'].'</div><div class="stat-label">'.Language::get('admin_pending_orders').'</div></div>
<div class="stat-card"><div class="stat-number">'.$stats['totalUsers'].'</div><div class="stat-label">'.Language::get('admin_total_users').'</div></div>
</div>
<div class="admin-nav">
<a href="/admin" class="active">📊 '.Language::get('admin_dashboard').'</a>
<a href="/admin/orders">📦 '.Language::get('admin_orders').'</a>
<a href="/admin/users">👥 '.Language::get('admin_users').'</a>
<a href="/">🏠 '.Language::get('nav_home').'</a>
</div>
<div class="recent-orders">
<h3 style="margin-bottom:1.5rem">'.Language::get('admin_recent_orders').'</h3>
<div class="order-row header"><div>'.Language::get('admin_order_id').'</div><div>'.Language::get('admin_customer').'</div><div>'.Language::get('admin_amount').'</div><div>'.Language::get('admin_status').'</div><div>'.Language::get('admin_date').'</div></div>';
        
        $statusColors = ['pending'=>'#ed8936','paid'=>'#4299e1','shipped'=>'#48bb78','completed'=>'#38a169','cancelled'=>'#e53e3e'];
        $statusNames = ['pending'=>Language::get('admin_order_pending'),'paid'=>Language::get('admin_order_paid'),'shipped'=>Language::get('admin_order_shipped'),'completed'=>Language::get('admin_order_completed'),'cancelled'=>Language::get('admin_order_cancelled')];
        
        foreach ($stats['recentOrders'] as $order) {
            $content .= '<div class="order-row"><div><a href="/admin/order?id='.htmlspecialchars($order['id']).'">'.htmlspecialchars($order['id']).'</a></div><div>'.htmlspecialchars($order['name']).'</div><div>'.number_format($order['total'],0,'.',' ').' ₽</div><div><span class="status-badge" style="background:'.$statusColors[$order['status']].'">'.$statusNames[$order['status']].'</span></div><div>'.date('d.m.Y',strtotime($order['created_at'])).'</div></div>';
        }
        
        $content .= '</div></div></section>';
        return str_replace(['{{TITLE}}','{{CONTENT}}'],[$title,$content],$template);
    }
    
    public static function getOrdersTemplate(array $orders, string $status = 'all', string $search = ''): string
    {
        $template = parent::getTemplate();
        $title = Language::get('admin_orders') . ' - ' . Language::get('site_name');
        
        $content = '
<style>
.admin-container{max-width:1400px;margin:2rem auto}
.admin-header{background:linear-gradient(135deg,#2c5282,#1a365d);color:#fff;padding:2rem;border-radius:12px;margin-bottom:2rem}
.admin-nav{display:flex;gap:1rem;margin-bottom:2rem;flex-wrap:wrap}
.admin-nav a{padding:0.75rem 1.5rem;background:#fff;border:1px solid #e2e8f0;border-radius:6px;text-decoration:none;color:#2c5282;font-weight:500}
.admin-nav a.active{background:#2c5282;color:#fff}
.filters{display:flex;gap:1rem;margin-bottom:2rem;flex-wrap:wrap}
.filters select,.filters input{padding:0.75rem 1rem;border:1px solid #e2e8f0;border-radius:6px}
.filters button{padding:0.75rem 1.5rem;background:#2c5282;color:#fff;border:none;border-radius:6px;cursor:pointer}
.orders-table{background:#fff;border-radius:12px;overflow:hidden;border:1px solid #e2e8f0}
.order-row{display:grid;grid-template-columns:1fr 2fr 1fr 1fr 1fr auto;gap:1rem;padding:1rem;border-bottom:1px solid #e2e8f0;align-items:center}
.order-row:last-child{border-bottom:none}
.order-row.header{background:#f7fafc;font-weight:600}
.status-badge{padding:0.25rem 0.75rem;border-radius:4px;color:#fff;font-size:0.85rem}
.btn-view{padding:0.5rem 1rem;background:#2c5282;color:#fff;border-radius:4px;text-decoration:none;font-size:0.9rem}
</style>
<section class="container py-5">
<div class="admin-container">
<div class="admin-header"><h1>'.Language::get('admin_orders').'</h1></div>
<div class="admin-nav">
<a href="/admin">📊 '.Language::get('admin_dashboard').'</a>
<a href="/admin/orders" class="active">📦 '.Language::get('admin_orders').'</a>
<a href="/admin/users">👥 '.Language::get('admin_users').'</a>
<a href="/">🏠 '.Language::get('nav_home').'</a>
</div>
<form class="filters" method="GET" action="/admin/orders">
<select name="status">
<option value="all" '.($status==='all'?'selected':'').'>'.Language::get('admin_all_statuses').'</option>
<option value="pending" '.($status==='pending'?'selected':'').'>'.Language::get('admin_order_pending').'</option>
<option value="paid" '.($status==='paid'?'selected':'').'>'.Language::get('admin_order_paid').'</option>
<option value="shipped" '.($status==='shipped'?'selected':'').'>'.Language::get('admin_order_shipped').'</option>
<option value="completed" '.($status==='completed'?'selected':'').'>'.Language::get('admin_order_completed').'</option>
<option value="cancelled" '.($status==='cancelled'?'selected':'').'>'.Language::get('admin_order_cancelled').'</option>
</select>
<input type="text" name="search" placeholder="'.Language::get('admin_search').'" value="'.htmlspecialchars($search).'">
<button type="submit">'.Language::get('admin_filter').'</button>
</form>
<div class="orders-table">
<div class="order-row header"><div>'.Language::get('admin_order_id').'</div><div>'.Language::get('admin_customer').'</div><div>'.Language::get('admin_amount').'</div><div>'.Language::get('admin_status').'</div><div>'.Language::get('admin_date').'</div><div>'.Language::get('admin_actions').'</div></div>';
        
        $statusColors = ['pending'=>'#ed8936','paid'=>'#4299e1','shipped'=>'#48bb78','completed'=>'#38a169','cancelled'=>'#e53e3e'];
        $statusNames = ['pending'=>Language::get('admin_order_pending'),'paid'=>Language::get('admin_order_paid'),'shipped'=>Language::get('admin_order_shipped'),'completed'=>Language::get('admin_order_completed'),'cancelled'=>Language::get('admin_order_cancelled')];
        
        foreach ($orders as $order) {
            $content .= '<div class="order-row"><div>'.htmlspecialchars($order['id']).'</div><div>'.htmlspecialchars($order['name']).'<br><small>'.htmlspecialchars($order['email']).'</small></div><div>'.number_format($order['total'],0,'.',' ').' ₽</div><div><span class="status-badge" style="background:'.$statusColors[$order['status']].'">'.$statusNames[$order['status']].'</span></div><div>'.date('d.m.Y',strtotime($order['created_at'])).'</div><div><a href="/admin/order?id='.htmlspecialchars($order['id']).'" class="btn-view">'.Language::get('admin_view').'</a></div></div>';
        }
        
        $content .= '</div></div></section>';
        return str_replace(['{{TITLE}}','{{CONTENT}}'],[$title,$content],$template);
    }
    
    public static function getOrderDetailTemplate(array $order): string
    {
        $template = parent::getTemplate();
        $title = Language::get('admin_order_id') . ' ' . $order['id'] . ' - ' . Language::get('site_name');
        
        $statusOptions = ['pending'=>Language::get('admin_order_pending'),'paid'=>Language::get('admin_order_paid'),'shipped'=>Language::get('admin_order_shipped'),'completed'=>Language::get('admin_order_completed'),'cancelled'=>Language::get('admin_order_cancelled')];
        
        $itemsHtml = '';
        foreach ($order['items'] as $item) {
            $itemsHtml .= '<tr><td>'.htmlspecialchars($item['title']).'</td><td>'.htmlspecialchars($item['duration']).'</td><td>'.htmlspecialchars($item['price']).'</td></tr>';
        }
        
        $content = '
<style>
.admin-container{max-width:1000px;margin:2rem auto}
.admin-header{background:linear-gradient(135deg,#2c5282,#1a365d);color:#fff;padding:2rem;border-radius:12px;margin-bottom:2rem}
.admin-nav{display:flex;gap:1rem;margin-bottom:2rem}
.admin-nav a{padding:0.75rem 1.5rem;background:#fff;border:1px solid #e2e8f0;border-radius:6px;text-decoration:none;color:#2c5282}
.order-detail{background:#fff;border-radius:12px;padding:2rem;border:1px solid #e2e8f0}
.detail-section{margin-bottom:2rem}
.detail-section h3{color:#2c5282;margin-bottom:1rem;padding-bottom:0.5rem;border-bottom:2px solid #e2e8f0}
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.info-item{padding:0.75rem;background:#f7fafc;border-radius:6px}
.info-label{color:#718096;font-size:0.9rem}
.info-value{font-weight:600;color:#2d3748}
.orders-table{width:100%;border-collapse:collapse}
.orders-table th,.orders-table td{padding:1rem;text-align:left;border-bottom:1px solid #e2e8f0}
.orders-table th{background:#f7fafc}
.status-form{margin-top:1rem}
.status-form select{padding:0.75rem 1rem;border:1px solid #e2e8f0;border-radius:6px;margin-right:0.5rem}
.status-form button{padding:0.75rem 1.5rem;background:#2c5282;color:#fff;border:none;border-radius:6px;cursor:pointer}
</style>
<section class="container py-5">
<div class="admin-container">
<div class="admin-header"><h1>'.Language::get('admin_order_id').' '.htmlspecialchars($order['id']).'</h1></div>
<div class="admin-nav">
<a href="/admin">📊 '.Language::get('admin_dashboard').'</a>
<a href="/admin/orders">📦 '.Language::get('admin_orders').'</a>
<a href="/admin/users">👥 '.Language::get('admin_users').'</a>
<a href="/">🏠 '.Language::get('nav_home').'</a>
</div>
<div class="order-detail">
<div class="detail-section"><h3>'.Language::get('checkout_contact_info').'</h3>
<div class="info-grid">
<div class="info-item"><div class="info-label">'.Language::get('checkout_name').'</div><div class="info-value">'.htmlspecialchars($order['name']).'</div></div>
<div class="info-item"><div class="info-label">Email</div><div class="info-value"><a href="mailto:'.htmlspecialchars($order['email']).'">'.htmlspecialchars($order['email']).'</a></div></div>
<div class="info-item"><div class="info-label">'.Language::get('checkout_phone').'</div><div class="info-value"><a href="tel:'.htmlspecialchars($order['phone']).'">'.htmlspecialchars($order['phone']).'</a></div></div>
<div class="info-item"><div class="info-label">IP</div><div class="info-value">'.htmlspecialchars($order['ip']).'</div></div>
</div></div>
<div class="detail-section"><h3>'.Language::get('order_email_courses').'</h3>
<table class="orders-table"><thead><tr><th>'.Language::get('order_email_course').'</th><th>'.Language::get('course_duration').'</th><th>'.Language::get('cart_total').'</th></tr></thead>
<tbody>'.$itemsHtml.'</tbody>
<tfoot><tr><td colspan="2" style="text-align:right;font-weight:600">'.Language::get('cart_total').':</td><td style="font-weight:700;color:#2c5282">'.number_format($order['total'],0,'.',' ').' ₽</td></tr></tfoot>
</table></div>
<div class="detail-section"><h3>'.Language::get('admin_status').'</h3>
<div class="info-grid">
<div class="info-item"><div class="info-label">'.Language::get('admin_status').'</div><div class="info-value">'.htmlspecialchars($order['status']).'</div></div>
<div class="info-item"><div class="info-label">'.Language::get('admin_date').'</div><div class="info-value">'.htmlspecialchars($order['created_at']).'</div></div>
</div>
<form class="status-form" method="POST" action="/admin/order/update">
<input type="hidden" name="order_id" value="'.htmlspecialchars($order['id']).'">
<select name="status">';
        
        foreach ($statusOptions as $value => $label) {
            $selected = $order['status'] === $value ? 'selected' : '';
            $content .= '<option value="'.$value.'" '.$selected.'>'.$label.'</option>';
        }
        
        $content .= '</select><button type="submit">'.Language::get('admin_update_status').'</button></form></div>
'.(!empty($order['comment']) ? '<div class="detail-section"><h3>'.Language::get('checkout_comment').'</h3><div class="info-item"><p style="margin:0">'.htmlspecialchars($order['comment']).'</p></div></div>' : '').'
</div></div></section>';
        return str_replace(['{{TITLE}}','{{CONTENT}}'],[$title,$content],$template);
    }
    
    public static function getUsersTemplate(array $users): string
    {
        $template = parent::getTemplate();
        $title = Language::get('admin_users') . ' - ' . Language::get('site_name');
        
        $content = '
<style>
.admin-container{max-width:1400px;margin:2rem auto}
.admin-header{background:linear-gradient(135deg,#2c5282,#1a365d);color:#fff;padding:2rem;border-radius:12px;margin-bottom:2rem}
.admin-nav{display:flex;gap:1rem;margin-bottom:2rem}
.admin-nav a{padding:0.75rem 1.5rem;background:#fff;border:1px solid #e2e8f0;border-radius:6px;text-decoration:none;color:#2c5282}
.admin-nav a.active{background:#2c5282;color:#fff}
.users-table{background:#fff;border-radius:12px;overflow:hidden;border:1px solid #e2e8f0}
.user-row{display:grid;grid-template-columns:1fr 2fr 1fr 1fr 1fr auto;gap:1rem;padding:1rem;border-bottom:1px solid #e2e8f0;align-items:center}
.user-row:last-child{border-bottom:none}
.user-row.header{background:#f7fafc;font-weight:600}
.role-badge{padding:0.25rem 0.75rem;border-radius:4px;color:#fff;font-size:0.85rem}
.role-admin{background:#e53e3e}
.role-user{background:#2c5282}
.verified-badge{color:#38a169}
.unverified-badge{color:#ed8936}
.btn-delete{padding:0.5rem 1rem;background:#e53e3e;color:#fff;border:none;border-radius:4px;cursor:pointer}
</style>
<section class="container py-5">
<div class="admin-container">
<div class="admin-header"><h1>'.Language::get('admin_users').'</h1></div>
<div class="admin-nav">
<a href="/admin">📊 '.Language::get('admin_dashboard').'</a>
<a href="/admin/orders">📦 '.Language::get('admin_orders').'</a>
<a href="/admin/users" class="active">👥 '.Language::get('admin_users').'</a>
<a href="/">🏠 '.Language::get('nav_home').'</a>
</div>
<div class="users-table">
<div class="user-row header"><div>ID</div><div>'.Language::get('admin_customer').'</div><div>'.Language::get('auth_role').'</div><div>'.Language::get('auth_verify_email').'</div><div>'.Language::get('admin_date').'</div><div>'.Language::get('admin_actions').'</div></div>';
        
        foreach ($users as $user) {
            $roleClass = $user['role'] === 'admin' ? 'role-admin' : 'role-user';
            $roleName = $user['role'] === 'admin' ? Language::get('auth_role_admin') : Language::get('auth_role_user');
            $verifiedBadge = $user['verified'] ? '<span class="verified-badge">✓ '.Language::get('admin_verified').'</span>' : '<span class="unverified-badge">○ '.Language::get('admin_not_verified').'</span>';
            $deleteButton = $user['id'] == 1 ? '' : '<form method="POST" action="/admin/user/delete" style="display:inline;" onsubmit="return confirm(\'Удалить?\')"><input type="hidden" name="user_id" value="'.$user['id'].'"><button type="submit" class="btn-delete">'.Language::get('admin_delete_user').'</button></form>';
            $content .= '<div class="user-row"><div>'.$user['id'].'</div><div>'.htmlspecialchars($user['name']).'<br><small>'.htmlspecialchars($user['email']).'</small></div><div><span class="role-badge '.$roleClass.'">'.$roleName.'</span></div><div>'.$verifiedBadge.'</div><div>'.date('d.m.Y',strtotime($user['created_at'])).'</div><div>'.$deleteButton.'</div></div>';
        }
        
        $content .= '</div></div></section>';
        return str_replace(['{{TITLE}}','{{CONTENT}}'],[$title,$content],$template);
    }
}