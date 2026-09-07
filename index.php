<<<<<<< Updated upstream
<?php
session_start();
require_once 'config/db.php';

// Fetch latest 8 recipes from the database
try {
    $stmt = $pdo->query("SELECT id, title, category, prep_time, image FROM recipes ORDER BY created_at DESC LIMIT 8");
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
    <title>Recipe Grid - Home</title>
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
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
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

    <!-- Hero Section -->
    <header class="hero-section">
        <div class="container">
            <h1>Discover, Cook,<br>Share, Enjoy...</h1>
            <div class="search-box mx-auto" style="max-width: 600px;">
                <div class="input-group input-group-lg">
                    <input type="text" id="recipeSearchInput" class="form-control" placeholder="Search recipes..." aria-label="Search recipes">
                    <button class="btn" type="button" id="searchBtn">Search</button>
                </div>
            </div>
        </div>
    </header>

    <!-- Categories Section -->
    <section id="categories">
        <div class="container">
            <h2>Categories</h2>
            
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="category-card">
                        <a href="categories.php?cat=Breakfast">
                            <img src="images/cat_breakfast.jpg" alt="Breakfast" class="img-fluid category-img">
                            <h6>Breakfast</h6>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="category-card">
                        <a href="categories.php?cat=Lunch">
                            <img src="images/cat_lunch.jpg" alt="Lunch" class="img-fluid category-img">
                            <h6>Lunch</h6>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="category-card">
                        <a href="categories.php?cat=Dinner">
                            <img src="images/cat_dinner.jpg" alt="Dinner" class="img-fluid category-img">
                            <h6>Dinner</h6>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="category-card">
                        <a href="categories.php?cat=Desserts">
                            <img src="images/cat_dessert.jpg" alt="Dessert" class="img-fluid category-img">
                            <h6>Desserts</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recipes Section -->
    <section id="recipes">
        <div class="container">
            <h2>Suggested Recipes</h2>
            
            <div class="row" id="recipeContainer">
                <?php if (!empty($recipes)): ?>
                    <?php foreach ($recipes as $recipe): ?>
                        <div class="col-12 col-sm-6 col-lg-3 recipe-item mb-4" 
                             data-category="<?= strtolower(htmlspecialchars($recipe['category'])) ?>" 
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
                        <p class="text-muted">No recipes found. Be the first to share one!</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="more-recipes-btn text-center mt-4">
                <a href="categories.php" class="btn btn-dark px-4 py-2">More Recipes &rarr;</a>
            </div>
        </div>
    </section>

    <!-- Upload CTA Banner -->
    <section class="upload-banner py-5 bg-light my-5">
        <div class="container">
            <div class="upload-box p-4 rounded-4 shadow-sm bg-white">
                <div class="row align-items-center text-center text-md-start">
                    <div class="col-12 col-md-2 mb-3 mb-md-0">
                        <div class="upload-icon mx-auto fs-1">⬆</div>
                    </div>
                    <div class="col-12 col-md-7 mb-3 mb-md-0">
                        <h4 class="fw-bold">Share Your Recipe with The World</h4>
                        <p class="text-muted mb-0">Have a favorite recipe? Upload it and inspire others with your delicious creation.</p>
                    </div>
                    <div class="col-12 col-md-3 text-md-end">
                        <a href="upload.php" class="btn btn-dark w-100 py-2">Upload Recipe</a>
                    </div>
                </div>
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
=======
<?php
session_start();
require_once 'config/db.php';

// Fetch latest 8 recipes from the database
try {
    $stmt = $pdo->query("SELECT id, title, category, prep_time, image FROM recipes ORDER BY created_at DESC LIMIT 8");
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
    <title>Recipe Grid - Home</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

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
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
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

    <!-- Hero Section -->
    <header class="hero-section py-5 text-center text-white bg-dark position-relative" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('images/home_bg.png') center/cover no-repeat;">
        <div class="container py-5">
            <h1 class="display-4 fw-bold mb-4">Discover, Cook,<br>Share, Enjoy...</h1>
            <form action="categories.php" method="GET" class="search-box mx-auto" style="max-width: 600px;">
                <div class="input-group input-group-lg shadow-sm">
                    <input type="text" name="search" id="recipeSearchInput" class="form-control border-0" placeholder="Search recipes..." aria-label="Search recipes">
                    <button class="btn btn-warning fw-bold text-dark px-4" type="submit" id="searchBtn">Search</button>
                </div>
            </form>
        </div>
    </header>

    <!-- Categories Section -->
    <section id="categories" class="py-5">
        <div class="container">
            <h2 class="fw-bold mb-4">Categories</h2>
            
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <div class="category-card text-center">
                        <a href="categories.php?cat=Breakfast" class="text-decoration-none text-dark d-block">
                            <img src="images/cat_breakfast.jpg" alt="Breakfast" class="img-fluid rounded-3 mb-2 category-img" onerror="this.src='images/recipe_01.jpg';">
                            <h6 class="fw-semibold">Breakfast</h6>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="category-card text-center">
                        <a href="categories.php?cat=Lunch" class="text-decoration-none text-dark d-block">
                            <img src="images/cat_lunch.jpg" alt="Lunch" class="img-fluid rounded-3 mb-2 category-img" onerror="this.src='images/recipe_01.jpg';">
                            <h6 class="fw-semibold">Lunch</h6>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="category-card text-center">
                        <a href="categories.php?cat=Dinner" class="text-decoration-none text-dark d-block">
                            <img src="images/cat_dinner.jpg" alt="Dinner" class="img-fluid rounded-3 mb-2 category-img" onerror="this.src='images/recipe_01.jpg';">
                            <h6 class="fw-semibold">Dinner</h6>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="category-card text-center">
                        <a href="categories.php?cat=Desserts" class="text-decoration-none text-dark d-block">
                            <img src="images/cat_dessert.jpg" alt="Desserts" class="img-fluid rounded-3 mb-2 category-img" onerror="this.src='images/recipe_01.jpg';">
                            <h6 class="fw-semibold">Desserts</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recipes Section -->
    <section id="recipes" class="py-5 bg-light">
        <div class="container">
            <h2 class="fw-bold mb-4">Suggested Recipes</h2>
            
            <div class="row g-4" id="recipeContainer">
                <?php if (!empty($recipes)): ?>
                    <?php foreach ($recipes as $recipe): ?>
                        <div class="col-12 col-sm-6 col-lg-3 recipe-item" 
                             data-category="<?= strtolower(htmlspecialchars($recipe['category'])) ?>" 
                             data-title="<?= strtolower(htmlspecialchars($recipe['title'])) ?>">
                            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                                <a href="recipe.php?id=<?= (int)$recipe['id'] ?>" class="text-decoration-none text-dark">
                                    <img src="uploads/<?= htmlspecialchars($recipe['image']) ?>" 
                                         class="card-img-top recipe-card-img object-fit-cover" 
                                         style="height: 200px;"
                                         alt="<?= htmlspecialchars($recipe['title']) ?>"
                                         onerror="this.src='images/recipe_01.jpg';">
                                    <div class="card-body pb-0">
                                        <h5 class="card-title text-truncate fw-semibold"><?= htmlspecialchars($recipe['title']) ?></h5>
                                    </div>
                                </a>
                                <div class="card-body d-flex justify-content-between align-items-center pt-2">
                                    <div>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($recipe['category']) ?></span>
                                        <small class="text-muted d-block mt-1">🕒 <?= (int)$recipe['prep_time'] ?> mins</small>
                                    </div>
                                    <button class="btn fav-btn text-danger border-0 fs-5" title="Favorite">♡</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fs-5">No recipes found. Be the first to share one!</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="more-recipes-btn text-center mt-5">
                <a href="categories.php" class="btn btn-dark px-4 py-2">More Recipes &rarr;</a>
            </div>
        </div>
    </section>

    <!-- Upload CTA Banner -->
    <section class="upload-banner py-5 bg-white">
        <div class="container">
            <div class="upload-box p-4 rounded-4 shadow-sm border">
                <div class="row align-items-center text-center text-md-start">
                    <div class="col-12 col-md-2 mb-3 mb-md-0 text-center">
                        <div class="upload-icon mx-auto fs-1 text-primary">⬆</div>
                    </div>
                    <div class="col-12 col-md-7 mb-3 mb-md-0">
                        <h4 class="fw-bold">Share Your Recipe with The World</h4>
                        <p class="text-muted mb-0">Have a favorite recipe? Upload it and inspire others with your delicious creation.</p>
                    </div>
                    <div class="col-12 col-md-3 text-md-end">
                        <a href="upload.php" class="btn btn-dark w-100 py-2">Upload Recipe</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-3 mt-auto">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-12 col-md-4">
                    <a href="index.php" class="footer-brand text-decoration-none text-white d-block mb-2">
                        <img src="images/logo.png" alt="Recipe Grid Logo" height="40">
                        <h4 class="d-inline-block align-middle ms-2 mb-0">Recipe Grid</h4>
                    </a>
                    <p class="text-secondary">Discover delicious recipes, cooking tips, and meal ideas for every occasion.</p>
                </div>
                <div class="col-12 col-md-4">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-1"><a href="index.php" class="text-secondary text-decoration-none">Home</a></li> 
                        <li class="mb-1"><a href="categories.php" class="text-secondary text-decoration-none">Categories</a></li>
                        <li class="mb-1"><a href="contact.php" class="text-secondary text-decoration-none">Contact Us</a></li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="mb-1"><a href="upload.php" class="text-secondary text-decoration-none">Upload</a></li>
                            <li class="mb-1"><a href="actions/logout.php" class="text-secondary text-decoration-none">Log out</a></li>
                        <?php else: ?>
                            <li class="mb-1"><a href="login.php" class="text-secondary text-decoration-none">Log in</a></li>
                        <?php endif; ?>
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
>>>>>>> Stashed changes
</html>