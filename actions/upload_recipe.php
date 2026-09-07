<?php
session_start();
header('Content-Type: application/json');
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access. Please log in.']);
    exit;
}

$title       = trim($_POST['title'] ?? '');
$category    = trim($_POST['category'] ?? '');
$prep_time   = (int)($_POST['prep_time'] ?? 0);
$description = trim($_POST['description'] ?? '');
$ingredients = trim($_POST['ingredients'] ?? '');
$instructions = trim($_POST['instructions'] ?? '');
$user_id     = $_SESSION['user_id'];

if (!$title || !$category || $prep_time < 1 || !$description || !$ingredients || !$instructions || !isset($_FILES['image'])) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields properly.']);
    exit;
}

// Handle Image Upload
$file = $_FILES['image'];
$allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

if (!in_array($file['type'], $allowedTypes) || $file['size'] > 5 * 1024 * 1024) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid file format or file size exceeds 5MB.']);
    exit;
}

$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid('recipe_', true) . '.' . $ext;
$uploadDir = '../uploads/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
    $stmt = $pdo->prepare("INSERT INTO recipes (user_id, title, category, prep_time, description, image, ingredients, instructions) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$user_id, $title, $category, $prep_time, $description, $filename, $ingredients, $instructions])) {
        echo json_encode(['status' => 'success', 'message' => 'Recipe published successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save recipe to database.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to upload image.']);
}