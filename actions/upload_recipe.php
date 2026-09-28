<?php
session_start();
header('Content-Type: application/json');
require_once '../config/db.php';

function respond(string $status, string $message): void {
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    respond('error', 'Invalid request method.');
}

if (!isset($_SESSION['user_id'])) {
    respond('error', 'Unauthorized access. Please log in.');
}

$title        = trim($_POST['title'] ?? '');
$category     = trim($_POST['category'] ?? '');
$prep_time    = (int)($_POST['prep_time'] ?? 0);
$description  = trim($_POST['description'] ?? '');
$ingredients  = trim($_POST['ingredients'] ?? '');
$instructions = trim($_POST['instructions'] ?? '');
$user_id      = (int)$_SESSION['user_id'];

$allowedCategories = ['Breakfast', 'Lunch', 'Dinner', 'Vegetarian', 'Desserts'];

if ($title === '' || $description === '' || $ingredients === '' || $instructions === '' || $prep_time < 1) {
    respond('error', 'Please fill in all required fields properly.');
}

if (mb_strlen($title) > 150) {
    respond('error', 'Title must be 150 characters or fewer.');
}

if (!in_array($category, $allowedCategories, true)) {
    respond('error', 'Please select a valid category.');
}

if ($prep_time > 10000) {
    respond('error', 'Cooking time is too large.');
}

// ---------------------------------------------------------------
// Image upload validation
// ---------------------------------------------------------------
if (!isset($_FILES['image'])) {
    respond('error', 'Please upload a cover image.');
}

$file = $_FILES['image'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    $msg = ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE)
        ? 'Image is too large.'
        : 'Image upload failed. Please try again.';
    respond('error', $msg);
}

if ($file['size'] > 5 * 1024 * 1024) {
    respond('error', 'Image size exceeds 5MB.');
}

// Detect the real MIME type from file contents (not the client-supplied one)
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime  = $finfo->file($file['tmp_name']);

$allowedTypes = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
];

if (!isset($allowedTypes[$mime])) {
    respond('error', 'Invalid file format. Only JPG, PNG and WEBP are allowed.');
}

// Extension comes from the detected type, never from the uploaded filename
$filename  = 'recipe_' . bin2hex(random_bytes(8)) . '.' . $allowedTypes[$mime];
$uploadDir = __DIR__ . '/../uploads/';

if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
    respond('error', 'Failed to prepare upload folder.');
}

if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
    respond('error', 'Failed to upload image.');
}

// ---------------------------------------------------------------
// Save to database
// ---------------------------------------------------------------
try {
    $stmt = $pdo->prepare(
        "INSERT INTO recipes (user_id, title, category, prep_time, description, image, ingredients, instructions)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->execute([$user_id, $title, $category, $prep_time, $description, $filename, $ingredients, $instructions]);

    respond('success', 'Recipe published successfully!');
} catch (PDOException $e) {
    // Don't leave an orphaned image behind if the insert fails
    @unlink($uploadDir . $filename);
    error_log('Upload error: ' . $e->getMessage());
    respond('error', 'Failed to save recipe to database.');
}
