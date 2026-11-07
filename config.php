<?php
declare(strict_types=1);
session_start();

const DB_HOST = 'localhost';
const DB_NAME = 'food_fast';
const DB_USER = 'root';
const DB_PASS = '';

try {
    $pdo = new PDO(
        'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database connection failed. Import database.sql and check config.php.');
}

function e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function redirect(string $url): never { header("Location: $url"); exit; }
function logged_in(): bool { return isset($_SESSION['user']); }
function current_user(): array { return $_SESSION['user'] ?? []; }
function require_login(): void { if (!logged_in()) redirect('login.php'); }
function require_role(string $role): void {
    require_login();
    if (($_SESSION['user']['role'] ?? '') !== $role) { http_response_code(403); exit('Access denied'); }
}
function flash(string $message, string $type='success'): void { $_SESSION['flash']=['message'=>$message,'type'=>$type]; }
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function verify_csrf(): void {
    if ($_SERVER['REQUEST_METHOD']==='POST' && !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419); exit('Invalid request token. Please go back and retry.');
    }
}
function cart_count(): int {
    return array_sum(array_map('intval', $_SESSION['cart'] ?? []));
}
