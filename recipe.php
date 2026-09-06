<?php
session_start();
require_once 'config/db.php';

// Get recipe ID from URL parameter
$recipeId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$recipe = null;

if ($recipeId > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
        $stmt->execute([$recipeId]);
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $recipe = null;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle"><?= $recipe ? htmlspecialchars($recipe['title']) . " - Recipe Grid" : "Recipe Not Found - Recipe Grid" ?></title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a href="index.php" class="d-inline-block me-2">
                <img src="images/logo.png" alt="Recipe Grid Logo" class="img-fluid" style="max-height: 60px;">
            </a>
            <a class="navbar-brand" href="index.php">Recipe Grid</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto text-center my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact us</a></li>
                </ul>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <ul class="navbar-nav">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item"><a class="nav-link" href="upload.php">Upload</a></li>
                            <li class="nav-item"><a class="nav-link" href="actions/logout.php">Logout (<?= htmlspecialchars($_SESSION['user_name']) ?>)</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="login.php">Log in</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Recipe Detail -->
    <main class="container my-5">
        <div id="recipeDetailContainer">
            <?php if ($recipe): ?>
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <img src="uploads/<?= htmlspecialchars($recipe['image']) ?>" 
                             class="img-fluid rounded-3 shadow-sm w-100 object-fit-cover" 
                             style="max-height: 400px;" 
                             alt="<?= htmlspecialchars($recipe['title']) ?>"
                             onerror="this.src='images/recipe_01.jpg';">
                    </div>
                    <div class="col-12 col-md-6 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h1 class="display-6 fw-bold mb-0"><?= htmlspecialchars($recipe['title']) ?></h1>
                                <button class="btn fav-btn fs-4 border-0 p-0 text-danger" title="Favorite">♡</button>
                            </div>
                            <div class="mb-3">
                                <span class="badge bg-secondary me-2"><?= htmlspecialchars($recipe['category']) ?></span>
                                <span class="text-muted">🕒 <?= (int)$recipe['prep_time'] ?> mins</span>
                            </div>
                            <hr>
                            <h5 class="fw-bold">Ingredients</h5>
                            <ul class="list-group list-group-flush mb-4">
                                <?php 
                                    $ingredients = explode("\n", $recipe['ingredients']);
                                    foreach ($ingredients as $ingredient):
                                        if (trim($ingredient) !== ''):
                                ?>
                                    <li class="list-group-item bg-transparent px-0">• <?= htmlspecialchars(trim($ingredient)) ?></li>
                                <?php 
                                        endif;
                                    endforeach; 
                                ?>
                            </ul>
                        </div>
                        <a href="categories.php" class="btn btn-outline-dark align-self-start">&larr; Back to Recipes</a>
                    </div>
                    <div class="col-12 mt-4">
                        <h4 class="fw-bold">Instructions</h4>
                        <div class="p-3 bg-light rounded-3">
                            <p style="white-space: pre-line; line-height: 1.7;"><?= htmlspecialchars($recipe['instructions']) ?></p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <h2 class="text-muted">Recipe Not Found</h2>
                    <p class="text-secondary">The recipe you are looking for does not exist or has been removed.</p>
                    <a href="categories.php" class="btn btn-dark mt-3">Browse Categories</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-3 mt-auto">
        <div class="container">
            <div class="row g-4 mb-4 align-items-start">
                <div class="col-12 col-md-4">
                    <a href="index.php" class="d-inline-block mb-2">
                        <img src="images/logo.png" alt="Recipe Grid Logo" class="img-fluid" style="max-height: 60px;">
                    </a>
                    <h4>Recipe Grid</h4>
                    <p class="text-secondary">Discover delicious recipes, cooking tips, and meal ideas for every occasion.</p>
                </div>
                <div class="col-12 col-md-4 text-start text-md-center">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="index.php" class="text-secondary text-decoration-none">Home</a></li> 
                        <li class="mb-2"><a href="categories.php" class="text-secondary text-decoration-none">Categories</a></li>
                        <li class="mb-2"><a href="contact.php" class="text-secondary text-decoration-none">Contact Us</a></li>
                        <li class="mb-2"><a href="login.php" class="text-secondary text-decoration-none">Log in</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-4 text-start text-md-end">
                    <h6>Contact Information</h6>
                    <p class="text-secondary mb-1">📍 Anuradhapura, Sri Lanka</p>
                    <p class="text-secondary mb-1">✉ recipegrid77@gmail.com</p>
                    <p class="text-secondary mb-0">📞 +94 70 333 336</p>
                </div>
            </div>
            <hr class="border-secondary">
            <p class="text-center text-secondary mb-0">&copy; 2026 Recipe Grid. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>
</html>