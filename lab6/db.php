<?php
$host = 'postgres';
$port = '5432';
$db   = 'laravel-getting-started';
$user = 'laravel-getting-started-user';
$pass = 'laravel-getting-started-password';

$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Error connecting to PostgreSQL: " . $e->getMessage());
}
