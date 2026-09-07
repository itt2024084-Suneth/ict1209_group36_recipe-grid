<?php
session_start();
header('Content-Type: application/json');
require_once '../config/db.php';

$name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$pass = trim($_POST['password'] ?? '');

if (!$name || !$email || strlen($pass) < 6) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid inputs. Password must be 6+ characters.']);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    echo json_encode(['status' => 'error', 'message' => 'Email already registered.']);
    exit;
}

$hash = password_hash($pass, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");

if ($stmt->execute([$name, $email, $hash])) {
    echo json_encode(['status' => 'success', 'message' => 'Account created! You can log in now.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Registration failed.']);
}