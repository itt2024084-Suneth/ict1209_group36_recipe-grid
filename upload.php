<<<<<<< Updated upstream
<?php
session_start();

// Redirect unauthenticated users to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Grid - Upload Recipe</title>
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
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact us</a></li>
                </ul>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="actions/logout.php">Logout (<?= htmlspecialchars($_SESSION['user_name']) ?>)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Upload Recipe Form Section -->
    <main class="container my-5 py-3">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">Share Your Recipe with The World</h2>
                            <p class="text-muted">Fill in the details below to publish your delicious creation onto Recipe Grid.</p>
                        </div>

                        <div id="recipeUploadAlert" class="alert d-none mb-3" role="alert"></div>

                        <form id="recipeUploadForm" action="actions/upload_recipe.php" method="POST" enctype="multipart/form-data" novalidate>
                            
                            <div class="mb-3">
                                <label for="recipeTitle" class="form-label fw-semibold">Recipe Title</label>
                                <input type="text" class="form-control py-2" id="recipeTitle" name="title" placeholder="e.g., Mix fried rice" required>
                                <div class="invalid-feedback">Please enter a recipe title.</div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-12 col-md-6">
                                    <label for="recipeCategory" class="form-label fw-semibold">Category</label>
                                    <select class="form-select py-2" id="recipeCategory" name="category" required>
                                        <option value="" selected disabled>Select Category</option>
                                        <option value="Breakfast">Breakfast</option>
                                        <option value="Lunch">Lunch</option>
                                        <option value="Dinner">Dinner</option>
                                        <option value="Vegetarian">Vegetarian</option>
                                        <option value="Desserts">Desserts</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a category.</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="prepTime" class="form-label fw-semibold">Cooking Time (minutes)</label>
                                    <input type="number" class="form-control py-2" id="prepTime" name="prep_time" min="1" placeholder="e.g., 25" required>
                                    <div class="invalid-feedback">Please enter cooking time in minutes.</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="recipeDescription" class="form-label fw-semibold">Short Description</label>
                                <textarea class="form-control py-2" id="recipeDescription" name="description" rows="2" placeholder="A brief summary of your dish..." required></textarea>
                                <div class="invalid-feedback">Please provide a short description.</div>
                            </div>

                            <div class="mb-3">
                                <label for="recipeImage" class="form-label fw-semibold">Recipe Cover Image</label>
                                <input class="form-control py-2" type="file" id="recipeImage" name="image" accept="image/png, image/jpeg, image/webp" required>
                                <div class="form-text">Accepted formats: JPG, PNG, WEBP (Max size: 5MB).</div>
                                <div class="invalid-feedback">Please upload a cover image for your recipe.</div>
                            </div>

                            <div class="mb-3">
                                <label for="recipeIngredients" class="form-label fw-semibold">Ingredients</label>
                                <textarea class="form-control py-2" id="recipeIngredients" name="ingredients" rows="4" placeholder="List each ingredient on a new line&#10;e.g.,&#10;200g Pasta&#10;2 cloves Garlic&#10;1 cup Heavy Cream" required></textarea>
                                <div class="invalid-feedback">Please list the required ingredients.</div>
                            </div>

                            <div class="mb-4">
                                <label for="recipeInstructions" class="form-label fw-semibold">Step-by-Step Instructions</label>
                                <textarea class="form-control py-2" id="recipeInstructions" name="instructions" rows="5" placeholder="Detail the preparation steps numbered or line-by-line..." required></textarea>
                                <div class="invalid-feedback">Please include step-by-step cooking instructions.</div>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 py-2 rounded-3 fw-semibold">Publish Recipe</button>
                        
                        </form>

                    </div>
                </div>

            </div>
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
                    <p>Discover delicious recipes, cooking tips, and meal ideas for every occasion.</p>
                </div>
                <div class="col-12 col-md-4 text-start text-md-center">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="index.php" class="text-white text-decoration-none">Home</a></li> 
                        <li class="mb-2"><a href="categories.php" class="text-white text-decoration-none">Categories</a></li>
                        <li class="mb-2"><a href="contact.php" class="text-white text-decoration-none">Contact Us</a></li>
                        <li class="mb-2"><a href="login.php" class="text-white text-decoration-none">Log in</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-4 text-start text-md-end">
                    <h6>Contact Information</h6>
                    <p class="mb-1">📍 Anuradhapura, Sri Lanka</p>
                    <p class="mb-1">✉ recipegrid77@gmail.com</p>
                    <p class="mb-0">📞 +94 70 333 336</p>
                </div>
            </div>
            <hr class="border-secondary">
            <p class="text-center mb-0">&copy; 2026 Recipe Grid. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>
=======
<?php
session_start();

// Redirect unauthenticated users to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Grid - Upload Recipe</title>
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
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact us</a></li>
                </ul>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="actions/logout.php">Logout (<?= htmlspecialchars($_SESSION['user_name']) ?>)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Upload Recipe Form Section -->
    <main class="container my-5 py-3">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">Share Your Recipe with The World</h2>
                            <p class="text-muted">Fill in the details below to publish your delicious creation onto Recipe Grid.</p>
                        </div>

                        <div id="recipeUploadAlert" class="alert d-none mb-3" role="alert"></div>

                        <form id="recipeUploadForm" action="actions/upload_recipe.php" method="POST" enctype="multipart/form-data" novalidate>
                            
                            <div class="mb-3">
                                <label for="recipeTitle" class="form-label fw-semibold">Recipe Title</label>
                                <input type="text" class="form-control py-2" id="recipeTitle" name="title" placeholder="e.g., Mix fried rice" required>
                                <div class="invalid-feedback">Please enter a recipe title.</div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-12 col-md-6">
                                    <label for="recipeCategory" class="form-label fw-semibold">Category</label>
                                    <select class="form-select py-2" id="recipeCategory" name="category" required>
                                        <option value="" selected disabled>Select Category</option>
                                        <option value="Breakfast">Breakfast</option>
                                        <option value="Lunch">Lunch</option>
                                        <option value="Dinner">Dinner</option>
                                        <option value="Vegetarian">Vegetarian</option>
                                        <option value="Desserts">Desserts</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a category.</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="prepTime" class="form-label fw-semibold">Cooking Time (minutes)</label>
                                    <input type="number" class="form-control py-2" id="prepTime" name="prep_time" min="1" placeholder="e.g., 25" required>
                                    <div class="invalid-feedback">Please enter cooking time in minutes.</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="recipeDescription" class="form-label fw-semibold">Short Description</label>
                                <textarea class="form-control py-2" id="recipeDescription" name="description" rows="2" placeholder="A brief summary of your dish..." required></textarea>
                                <div class="invalid-feedback">Please provide a short description.</div>
                            </div>

                            <div class="mb-3">
                                <label for="recipeImage" class="form-label fw-semibold">Recipe Cover Image</label>
                                <input class="form-control py-2" type="file" id="recipeImage" name="image" accept="image/png, image/jpeg, image/webp" required>
                                <div class="form-text">Accepted formats: JPG, PNG, WEBP (Max size: 5MB).</div>
                                <div class="invalid-feedback">Please upload a cover image for your recipe.</div>
                            </div>

                            <div class="mb-3">
                                <label for="recipeIngredients" class="form-label fw-semibold">Ingredients</label>
                                <textarea class="form-control py-2" id="recipeIngredients" name="ingredients" rows="4" placeholder="List each ingredient on a new line&#10;e.g.,&#10;200g Pasta&#10;2 cloves Garlic&#10;1 cup Heavy Cream" required></textarea>
                                <div class="invalid-feedback">Please list the required ingredients.</div>
                            </div>

                            <div class="mb-4">
                                <label for="recipeInstructions" class="form-label fw-semibold">Step-by-Step Instructions</label>
                                <textarea class="form-control py-2" id="recipeInstructions" name="instructions" rows="5" placeholder="Detail the preparation steps numbered or line-by-line..." required></textarea>
                                <div class="invalid-feedback">Please include step-by-step cooking instructions.</div>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 py-2 rounded-3 fw-semibold">Publish Recipe</button>
                        
                        </form>

                    </div>
                </div>

            </div>
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
                    <p>Discover delicious recipes, cooking tips, and meal ideas for every occasion.</p>
                </div>
                <div class="col-12 col-md-4 text-start text-md-center">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="index.php" class="text-white text-decoration-none">Home</a></li> 
                        <li class="mb-2"><a href="categories.php" class="text-white text-decoration-none">Categories</a></li>
                        <li class="mb-2"><a href="contact.php" class="text-white text-decoration-none">Contact Us</a></li>
                        <li class="mb-2"><a href="login.php" class="text-white text-decoration-none">Log in</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-4 text-start text-md-end">
                    <h6>Contact Information</h6>
                    <p class="mb-1">📍 Anuradhapura, Sri Lanka</p>
                    <p class="mb-1">✉ recipegrid77@gmail.com</p>
                    <p class="mb-0">📞 +94 70 333 336</p>
                </div>
            </div>
            <hr class="border-secondary">
            <p class="text-center mb-0">&copy; 2026 Recipe Grid. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>
>>>>>>> Stashed changes
</html>