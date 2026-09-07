<?php
session_start();
header('Content-Type: application/json');
require_once '../config/db.php';

$email = trim($_POST['email'] ?? '');
$pass = $_POST['password'] ?? '';

if (!$email || !$pass) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($pass, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['full_name'];

    echo json_encode(['status' => 'success', 'message' => 'Logged in successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
}