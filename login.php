<<<<<<< Updated upstream
<?php
session_start();

// Redirect logged-in users away from the login page
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Grid - Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!--Navbar-->
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
                        <li class="nav-item"><a class="nav-link active" href="login.php">Log in</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!--login and sign up-->
    <main class="container my-auto py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5">
                
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        
                        <ul class="nav nav-pills nav-justified mb-4 bg-light p-1 rounded-3" id="authTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active rounded-3" id="login-tab" data-bs-toggle="pill" data-bs-target="#login-pane" type="button" role="tab">Log In</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-3" id="register-tab" data-bs-toggle="pill" data-bs-target="#register-pane" type="button" role="tab">Sign Up</button>
                            </li>
                        </ul>

                        <div id="pageAuthAlert" class="alert d-none mb-3" role="alert"></div>

                        <div class="tab-content" id="authTabsContent">
                            
                            <!--login -->
                            <div class="tab-pane fade show active" id="login-pane" role="tabpanel">
                                <div class="text-center mb-4">
                                    <h3>Welcome Back</h3>
                                    <p class="text-muted">Enter your details to log into your account.</p>
                                </div>

                                <form id="pageLoginForm" action="actions/login.php" method="POST" novalidate>
                                    <div class="mb-3">
                                        <label for="pageLoginEmail" class="form-label">Email address</label>
                                        <input type="email" name="email" class="form-control py-2" id="pageLoginEmail" placeholder="name@example.com" required>
                                        <div class="invalid-feedback">Please enter a valid email address.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pageLoginPassword" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control py-2" id="pageLoginPassword" placeholder="••••••••" required>
                                        <div class="invalid-feedback">Please enter your password.</div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input type="checkbox" name="remember" class="form-check-input" id="pageRememberMe">
                                            <label class="form-check-label" for="pageRememberMe">Remember me</label>
                                        </div>
                                        <a href="#" class="text-decoration-none">Forgot password?</a>
                                    </div>
                                    <button type="submit" class="btn btn-dark w-100 py-2 rounded-3">Log In</button>
                                </form>
                            </div>

                            <!--signup -->
                            <div class="tab-pane fade" id="register-pane" role="tabpanel">
                                <div class="text-center mb-4">
                                    <h3>Create Account</h3>
                                    <p class="text-muted">Join Recipe Grid to save and share recipes.</p>
                                </div>
                                <form id="pageRegisterForm" action="actions/register.php" method="POST" novalidate>
                                    <div class="mb-3">
                                        <label for="pageRegName" class="form-label">Full Name</label>
                                        <input type="text" name="full_name" class="form-control py-2" id="pageRegName" placeholder="Name" required>
                                        <div class="invalid-feedback">Please enter your full name.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pageRegEmail" class="form-label">Email address</label>
                                        <input type="email" name="email" class="form-control py-2" id="pageRegEmail" placeholder="name@example.com" required>
                                        <div class="invalid-feedback">Please enter a valid email address.</div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="pageRegPassword" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control py-2" id="pageRegPassword" placeholder="••••••••" minlength="6" required>
                                        <div class="invalid-feedback">Password must be at least 6 characters.</div>
                                    </div>
                                    <button type="submit" class="btn btn-dark w-100 py-2 rounded-3">Create Account</button>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <!--Footer-->
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

// Redirect logged-in users away from the login page
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Grid - Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!--Navbar-->
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
                        <li class="nav-item"><a class="nav-link active" href="login.php">Log in</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!--login and sign up-->
    <main class="container my-auto py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5">
                
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        
                        <ul class="nav nav-pills nav-justified mb-4 bg-light p-1 rounded-3" id="authTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active rounded-3" id="login-tab" data-bs-toggle="pill" data-bs-target="#login-pane" type="button" role="tab">Log In</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-3" id="register-tab" data-bs-toggle="pill" data-bs-target="#register-pane" type="button" role="tab">Sign Up</button>
                            </li>
                        </ul>

                        <div id="pageAuthAlert" class="alert d-none mb-3" role="alert"></div>

                        <div class="tab-content" id="authTabsContent">
                            
                            <!--login -->
                            <div class="tab-pane fade show active" id="login-pane" role="tabpanel">
                                <div class="text-center mb-4">
                                    <h3>Welcome Back</h3>
                                    <p class="text-muted">Enter your details to log into your account.</p>
                                </div>

                                <form id="pageLoginForm" action="actions/login.php" method="POST" novalidate>
                                    <div class="mb-3">
                                        <label for="pageLoginEmail" class="form-label">Email address</label>
                                        <input type="email" name="email" class="form-control py-2" id="pageLoginEmail" placeholder="name@example.com" required>
                                        <div class="invalid-feedback">Please enter a valid email address.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pageLoginPassword" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control py-2" id="pageLoginPassword" placeholder="••••••••" required>
                                        <div class="invalid-feedback">Please enter your password.</div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input type="checkbox" name="remember" class="form-check-input" id="pageRememberMe">
                                            <label class="form-check-label" for="pageRememberMe">Remember me</label>
                                        </div>
                                        <a href="#" class="text-decoration-none">Forgot password?</a>
                                    </div>
                                    <button type="submit" class="btn btn-dark w-100 py-2 rounded-3">Log In</button>
                                </form>
                            </div>

                            <!--signup -->
                            <div class="tab-pane fade" id="register-pane" role="tabpanel">
                                <div class="text-center mb-4">
                                    <h3>Create Account</h3>
                                    <p class="text-muted">Join Recipe Grid to save and share recipes.</p>
                                </div>
                                <form id="pageRegisterForm" action="actions/register.php" method="POST" novalidate>
                                    <div class="mb-3">
                                        <label for="pageRegName" class="form-label">Full Name</label>
                                        <input type="text" name="full_name" class="form-control py-2" id="pageRegName" placeholder="Name" required>
                                        <div class="invalid-feedback">Please enter your full name.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pageRegEmail" class="form-label">Email address</label>
                                        <input type="email" name="email" class="form-control py-2" id="pageRegEmail" placeholder="name@example.com" required>
                                        <div class="invalid-feedback">Please enter a valid email address.</div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="pageRegPassword" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control py-2" id="pageRegPassword" placeholder="••••••••" minlength="6" required>
                                        <div class="invalid-feedback">Password must be at least 6 characters.</div>
                                    </div>
                                    <button type="submit" class="btn btn-dark w-100 py-2 rounded-3">Create Account</button>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <!--Footer-->
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