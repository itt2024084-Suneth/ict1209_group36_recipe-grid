<?php
session_start();
header('Content-Type: application/json');
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$name  = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$pass  = $_POST['password'] ?? '';   // not trimmed, so it matches what login.php verifies

if ($name === '' || mb_strlen($name) > 100) {
    echo json_encode(['status' => 'error', 'message' => 'Please enter your full name (max 100 characters).']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
    echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
    exit;
}

if (strlen($pass) < 6) {
    echo json_encode(['status' => 'error', 'message' => 'Password must be at least 6 characters.']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'Email already registered.']);
        exit;
    }

    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $hash]);

    echo json_encode(['status' => 'success', 'message' => 'Account created! You can log in now.']);
} catch (PDOException $e) {
    // 23000 = duplicate key (two sign-ups racing on the same email)
    if ($e->getCode() === '23000') {
        echo json_encode(['status' => 'error', 'message' => 'Email already registered.']);
    } else {
        error_log('Register error: ' . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Registration failed.']);
    }
}
