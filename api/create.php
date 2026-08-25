<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

$name = trim((string)($_POST['name'] ?? ''));
$age  = filter_var($_POST['age'] ?? null, FILTER_VALIDATE_INT);

if ($name === '' || mb_strlen($name) > 100) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Please enter a valid name (1–100 characters).']);
    exit;
}

if ($age === false || $age < 1 || $age > 120) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Please enter an age between 1 and 120.']);
    exit;
}

$stmt = $pdo->prepare('INSERT INTO users (name, age, status) VALUES (:name, :age, 0)');
$stmt->execute([
    ':name' => $name,
    ':age'  => $age,
]);

$id = (int)$pdo->lastInsertId();

$stmt = $pdo->prepare('SELECT id, name, age, status FROM users WHERE id = :id');
$stmt->execute([':id' => $id]);
$user = $stmt->fetch();

echo json_encode(['success' => true, 'user' => $user]);
