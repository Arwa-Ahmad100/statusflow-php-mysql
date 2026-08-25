<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

if ($id === false || $id < 1) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Invalid record ID.']);
    exit;
}

$stmt = $pdo->prepare('UPDATE users SET status = 1 - status WHERE id = :id');
$stmt->execute([':id' => $id]);

if ($stmt->rowCount() === 0) {
    $check = $pdo->prepare('SELECT id FROM users WHERE id = :id');
    $check->execute([':id' => $id]);

    if (!$check->fetch()) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Record not found.']);
        exit;
    }
}

$stmt = $pdo->prepare('SELECT id, status FROM users WHERE id = :id');
$stmt->execute([':id' => $id]);
$user = $stmt->fetch();

echo json_encode(['success' => true, 'user' => $user]);
