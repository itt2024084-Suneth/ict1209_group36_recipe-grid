<?php
session_start();
require_once 'config/db.php';

// Get selected category from URL query string if present
$selectedCategory = isset($_GET['cat']) ? strtolower(trim($_GET['cat'])) : 'all';

// Fetch all recipes dynamically from the database
try {
    $stmt = $pdo->query("SELECT id, title, category, prep_time, image FROM recipes ORDER BY created_at DESC");
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $recipes = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Grid - Categories</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a href="index.php" class="navbar-brand d-flex align-items-center gap-2">
                <img src="images/logo.png" alt="Recipe Grid Logo" height="40">
                <span>Recipe Grid</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto text-center my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="categories.php">Categories</a></li>
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

    <!-- Category Header & Filter -->
    <section id="categories-header" class="py-4">
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <div class="input-group search-box" style="max-width: 350px;">
                    <input type="text" id="recipeSearchInput" class="form-control" placeholder="Search recipes..." aria-label="Search">
                    <button class="btn btn-dark" type="button" id="searchBtn">Search</button>
                </div>
            </div>

            <h2>Categories</h2>
            <div class="d-flex flex-wrap gap-2" id="categoryFilterGroup">
                <button type="button" class="btn category-btn <?= $selectedCategory === 'all' ? 'active' : '' ?>" data-category="all">All</button>
                <button type="button" class="btn category-btn <?= $selectedCategory === 'breakfast' ? 'active' : '' ?>" data-category="breakfast">Breakfast</button>
                <button type="button" class="btn category-btn <?= $selectedCategory === 'lunch' ? 'active' : '' ?>" data-category="lunch">Lunch</button>
                <button type="button" class="btn category-btn <?= $selectedCategory === 'dinner' ? 'active' : '' ?>" data-category="dinner">Dinner</button>
                <button type="button" class="btn category-btn <?= $selectedCategory === 'vegetarian' ? 'active' : '' ?>" data-category="vegetarian">Vegetarian</button>
                <button type="button" class="btn category-btn <?= in_array($selectedCategory, ['dessert', 'desserts']) ? 'active' : '' ?>" data-category="dessert">Dessert</button>
            </div>
        </div>
    </section>

    <!-- Recipes Grid -->
    <section id="recipes" class="py-4">
        <div class="container">
            <h2>Recipes</h2>
            
            <div class="row" id="recipeContainer">
                <?php if (!empty($recipes)): ?>
                    <?php foreach ($recipes as $recipe): 
                        $recipeCat = strtolower(htmlspecialchars($recipe['category']));
                        // Handle initial category filtering based on GET parameter
                        $hideClass = ($selectedCategory !== 'all' && strtolower($selectedCategory) !== $recipeCat && !(in_array($selectedCategory, ['dessert', 'desserts']) && in_array($recipeCat, ['dessert', 'desserts']))) ? 'd-none' : '';
                    ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 recipe-item mb-4 <?= $hideClass ?>" 
                             data-category="<?= $recipeCat ?>" 
                             data-title="<?= strtolower(htmlspecialchars($recipe['title'])) ?>">
                            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                                <a href="recipe.php?id=<?= $recipe['id'] ?>" class="text-decoration-none text-dark">
                                    <img src="uploads/<?= htmlspecialchars($recipe['image']) ?>" 
                                         class="card-img-top recipe-card-img" 
                                         alt="<?= htmlspecialchars($recipe['title']) ?>"
                                         onerror="this.src='images/recipe_01.jpg';">
                                    <div class="card-body pb-0">
                                        <h5 class="card-title text-truncate"><?= htmlspecialchars($recipe['title']) ?></h5>
                                    </div>
                                </a>
                                <div class="card-body d-flex justify-content-between align-items-center pt-2">
                                    <div>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($recipe['category']) ?></span>
                                        <small class="text-muted d-block mt-1">🕒 <?= (int)$recipe['prep_time'] ?> mins</small>
                                    </div>
                                    <button class="btn fav-btn" title="Favorite">♡</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No recipes found in the database.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="text-center mt-5">
                <p class="text-muted">👨‍🍳 More recipes coming soon...</p>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-3">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-12 col-md-4">
                    <a href="index.php" class="footer-brand text-decoration-none text-white d-block mb-2">
                        <img src="images/logo.png" alt="Recipe Grid Logo" height="40">
                        <h4 class="d-inline-block align-middle ms-2">Recipe Grid</h4>
                    </a>
                    <p class="text-secondary">Discover delicious recipes, cooking tips, and meal ideas for every occasion.</p>
                </div>
                <div class="col-12 col-md-4">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-1"><a href="index.php" class="text-secondary text-decoration-none">Home</a></li> 
                        <li class="mb-1"><a href="categories.php" class="text-secondary text-decoration-none">Categories</a></li>
                        <li class="mb-1"><a href="contact.php" class="text-secondary text-decoration-none">Contact Us</a></li>
                        <li class="mb-1"><a href="login.php" class="text-secondary text-decoration-none">Log in</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-4">
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