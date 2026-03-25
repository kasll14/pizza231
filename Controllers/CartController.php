<?php
namespace Controllers;
class CartController
{
public function __construct()
{
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
if (!isset($_SESSION['cart'])) {
$_SESSION['cart'] = [];
}
}
public function view(): string
{
return \Views\CartTemplate::getTemplate();
}
public function add(): void
{
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
if (!isset($_SESSION['cart'])) {
$_SESSION['cart'] = [];
}
$courseId = isset($_POST['courseId']) ? (int)$_POST['courseId'] : 0;
if ($courseId < 1 || $courseId > 6) {
// Для AJAX запросов
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
http_response_code(400);
echo json_encode(['success' => false, 'error' => 'invalid_course']);
exit;
}
header('Location: /courses?error=invalid_course');
exit;
}
$courses = \Views\CourseTemplate::$courses;
if (!isset($courses[$courseId])) {
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
http_response_code(404);
echo json_encode(['success' => false, 'error' => 'course_not_found']);
exit;
}
header('Location: /courses?error=course_not_found');
exit;
}
$course = $courses[$courseId];
$existing = false;
foreach ($_SESSION['cart'] as &$item) {
if ($item['id'] === $courseId) {
$existing = true;
break;
}
}
if (!$existing) {
$_SESSION['cart'][] = [
'id' => $courseId,
'title' => $course['title'],
'price' => $course['price_from'],
'icon' => $course['icon'],
'duration' => $course['duration'],
'added_at' => time()
];
}
// Для AJAX запросов
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
http_response_code(200);
echo json_encode([
'success' => true,
'count' => count($_SESSION['cart'])
]);
exit;
}
header('Location: /cart?success=added');
exit;
}
public function getCount(): int
{
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
return count($_SESSION['cart'] ?? []);
}
// Новый метод для AJAX получения количества
public function getCountJson(): void
{
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
header('Content-Type: application/json');
echo json_encode(['count' => count($_SESSION['cart'] ?? [])]);
}
public function remove(): void
{
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
$courseId = isset($_POST['courseId']) ? (int)$_POST['courseId'] : 0;
foreach ($_SESSION['cart'] as $key => $item) {
if ($item['id'] === $courseId) {
unset($_SESSION['cart'][$key]);
$_SESSION['cart'] = array_values($_SESSION['cart']);
// Для AJAX
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
http_response_code(200);
echo json_encode(['success' => true, 'count' => count($_SESSION['cart'])]);
exit;
}
header('Location: /cart?success=removed');
exit;
}
}
// Для AJAX
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
http_response_code(404);
echo json_encode(['success' => false, 'error' => 'not_found']);
exit;
}
header('Location: /cart?error=not_found');
exit;
}
public function clear(): void
{
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
$_SESSION['cart'] = [];
// Для AJAX
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
http_response_code(200);
echo json_encode(['success' => true, 'count' => 0]);
exit;
}
header('Location: /cart?success=cleared');
exit;
}
}