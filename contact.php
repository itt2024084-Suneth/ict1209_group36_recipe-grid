<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Grid - Contact Us</title>
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
                    <li class="nav-item"><a class="nav-link active" href="contact.php">Contact us</a></li>
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

    <!-- Header Banner -->
    <header class="py-5 bg-light border-bottom text-center">
        <div class="container">
            <h1 class="fw-bold">Contact Us</h1>
            <p class="lead text-muted max-w-2xl mx-auto mb-0">We'd love to hear from you. Whether you have a question, suggestion, or just want to say hello, feel free to reach out to us.</p>
        </div>
    </header>

    <!-- Main Content Section -->
    <section id="contact" class="py-5 my-auto">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                
                <!-- About Us / Info Column -->
                <div class="col-12 col-lg-6">
                    <div class="card h-100 border-0 shadow-sm rounded-3">
                        <div class="card-body p-4">
                            <h2 class="fw-bold mb-3">About Us</h2>
                            <p class="text-secondary">At Recipe Grid, we believe that great food does far more than just nourish—it brings people together and turns ordinary moments into celebrations. Cooking should be an inviting, joyful experience from the moment you look for inspiration to the very last bite. Our mission is to empower your culinary journey with easy-to-follow, reliable recipes crafted for every skill level, dietary need, and occasion.</p>                        
                            <p class="text-secondary mb-4">Whether you need quick weeknight dinners, wholesome everyday meals, or decadent desserts, Recipe Grid is designed to help you find the perfect dish in seconds. Our visual layout allows you to effortlessly browse vibrant photos and organized categories, eliminating guesswork with clear step-by-step instructions. Recipe Grid is here to make your time in the kitchen simple, fun, and delicious every day.</p>

                            <h3 class="h4 fw-bold mb-3">Get in Touch</h3>
                            <div class="mb-3">
                                <h5 class="fw-semibold text-dark mb-0">📞 +94 70 333 336</h5>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Email:</h6>
                                <h5 class="fw-semibold text-dark mb-0">✉ recipegrid77@gmail.com</h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form Column -->
                <div class="col-12 col-lg-6">
                    <div class="card h-100 border-0 shadow-sm rounded-3">
                        <div class="card-body p-4">
                            <h2 class="fw-bold mb-3">Send a Message</h2>
                            <div id="formAlert" class="alert alert-success d-none mb-3" role="alert">
                                Thank you! Your message has been sent successfully.
                            </div>

                            <form id="contactForm" novalidate>
                                <div class="mb-3">
                                    <label for="userName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="userName" name="userName" placeholder="Your Name" required>
                                    <div class="invalid-feedback">Please enter your name.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="userPhone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="userPhone" name="userPhone" placeholder="+94 XX XXX XX" required>
                                    <div class="invalid-feedback">Please enter a valid phone number.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="userEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="name@example.com" required>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="userSubject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="userSubject" name="userSubject" placeholder="Inquiry subject" required>
                                    <div class="invalid-feedback">Please provide a subject.</div>
                                </div>
                                <div class="mb-4">
                                    <label for="userMessage" class="form-label">Message</label>
                                    <textarea class="form-control" id="userMessage" name="userMessage" rows="4" placeholder="Write your message here..." required maxlength="300"></textarea>
                                    <div class="d-flex justify-content-between">
                                        <div class="invalid-feedback">Message field cannot be left blank.</div>
                                        <small id="charCounter" class="text-muted ms-auto mt-1">0 / 300 characters</small>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-dark w-100 py-2">Send Message</button>
                            </form>
                        </div>
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