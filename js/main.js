document.addEventListener("DOMContentLoaded", function () {

    // filtering
    const categoryButtons = document.querySelectorAll(".category-btn");
    const recipeItems = document.querySelectorAll(".recipe-item");
    const searchInput = document.getElementById("recipeSearchInput");
    const searchBtn = document.getElementById("searchBtn");

    let activeCategory = "all";

    function filterRecipes() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : "";

        recipeItems.forEach(item => {
            const itemCategory = (item.dataset.category || "").toLowerCase();
            const itemTitle = (item.dataset.title || "").toLowerCase();

            const matchesCategory = (activeCategory === "all" || itemCategory === activeCategory);
            const matchesSearch = (query === "" || itemTitle.includes(query));

            if (matchesCategory && matchesSearch) {
                item.classList.remove("d-none");
            } else {
                item.classList.add("d-none");
            }
        });
    }
    //login,signup
    const authTabButtons = document.querySelectorAll('#authTabs [data-bs-toggle="pill"]');

    authTabButtons.forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            authTabButtons.forEach(btn => {
                btn.classList.remove("active");
                btn.setAttribute("aria-selected", "false");
            });

            this.classList.add("active");
            this.setAttribute("aria-selected", "true");

            const targetPaneId = this.getAttribute("data-bs-target");
            const allPanes = document.querySelectorAll(".tab-content .tab-pane");

            allPanes.forEach(pane => {
                pane.classList.remove("show", "active");
            });

            const targetPane = document.querySelector(targetPaneId);
            if (targetPane) {
                targetPane.classList.add("show", "active");
            }
        });
    });

    // navbar button
    const toggler = document.querySelector(".navbar-toggler");
    const navCollapse = document.getElementById("navbarNav");

    if (toggler && navCollapse) {
        toggler.addEventListener("click", function () {
            navCollapse.classList.toggle("show");
            const isExpanded = navCollapse.classList.contains("show");
            toggler.setAttribute("aria-expanded", isExpanded);
        });
    }

    categoryButtons.forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            categoryButtons.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");

            activeCategory = (this.dataset.category || "all").toLowerCase();
            filterRecipes();
        });
    });

    if (searchInput) {
        searchInput.addEventListener("input", filterRecipes);
    }
    if (searchBtn) {
        searchBtn.addEventListener("click", filterRecipes);
    }

    // bookmark and favorite toggles
    document.querySelectorAll(".bookmark-btn").forEach(button => {
        button.addEventListener("click", function () {
            if (this.textContent.trim() === "+") {
                this.textContent = "✓";
                this.classList.replace("btn-outline-secondary", "btn-success");
            } else {
                this.textContent = "+";
                this.classList.replace("btn-success", "btn-outline-secondary");
            }
        });
    });

    document.querySelectorAll(".fav-btn").forEach(button => {
        button.addEventListener("click", function () {
            if (this.textContent.trim() === "♡") {
                this.textContent = "♥";
                this.classList.replace("btn-outline-danger", "btn-danger");
            } else {
                this.textContent = "♡";
                this.classList.replace("btn-danger", "btn-outline-danger");
            }
        });
    });

    // contact form
    const contactForm = document.getElementById("contactForm");
    const formAlert = document.getElementById("formAlert");
    const userMessage = document.getElementById("userMessage");
    const charCounter = document.getElementById("charCounter");

    if (userMessage && charCounter) {
        userMessage.addEventListener("input", function () {
            charCounter.textContent = `${this.value.length} / 300 characters`;
        });
    }

    if (contactForm) {
        contactForm.addEventListener("submit", function (e) {
            e.preventDefault();

            if (!contactForm.checkValidity()) {
                e.stopPropagation();
                contactForm.classList.add("was-validated");
            } else {
                contactForm.classList.remove("was-validated");
                contactForm.reset();
                if (charCounter) charCounter.textContent = "0 / 300 characters";

                if (formAlert) {
                    formAlert.classList.remove("d-none");
                    setTimeout(() => formAlert.classList.add("d-none"), 4000);
                }
            }
        }, false);
    }

    // auth forms
    const pageLoginForm = document.getElementById("pageLoginForm");
    const pageRegisterForm = document.getElementById("pageRegisterForm");
    const pageAuthAlert = document.getElementById("pageAuthAlert");

    if (pageLoginForm) {
        pageLoginForm.addEventListener("submit", function (e) {
            e.preventDefault();

            if (!pageLoginForm.checkValidity()) {
                e.stopPropagation();
                pageLoginForm.classList.add("was-validated");
            } else {
                pageLoginForm.classList.remove("was-validated");

                pageAuthAlert.className = "alert alert-success mb-3";
                pageAuthAlert.textContent = "Logged in successfully! Redirecting...";
                pageAuthAlert.classList.remove("d-none");

                setTimeout(() => {
                    window.location.href = "index.html";
                }, 1500);
            }
        });
    }

    if (pageRegisterForm) {
        pageRegisterForm.addEventListener("submit", function (e) {
            e.preventDefault();

            if (!pageRegisterForm.checkValidity()) {
                e.stopPropagation();
                pageRegisterForm.classList.add("was-validated");
            } else {
                pageRegisterForm.classList.remove("was-validated");

                pageAuthAlert.className = "alert alert-success mb-3";
                pageAuthAlert.textContent = "Account created successfully! You can now log in.";
                pageAuthAlert.classList.remove("d-none");

                setTimeout(() => {
                    const loginTabTrigger = document.getElementById("login-tab");
                    if (loginTabTrigger) {
                        loginTabTrigger.click();
                    }

                    pageRegisterForm.reset();
                    pageAuthAlert.classList.add("d-none");
                }, 1500);
            }
        });
    }

    // recipe details
    const recipeData = {
        "1": { title: "Recipe 1", category: "Dinner", time: "25 mins", servings: "2-4", image: "images/recipe_01.jpg", description: "Recipe description...", ingredients: ["Ingredient 1", "Ingredient 2"], instructions: ["Step 1", "Step 2"] },
        "2": { title: "Recipe 2", category: "Lunch", time: "20 mins", servings: "1-2", image: "images/recipe_02.jpg", description: "Recipe description...", ingredients: ["Ingredient 1", "Ingredient 2"], instructions: ["Step 1", "Step 2"] },
        "3": { title: "Recipe 3", category: "Dessert", time: "30 mins", servings: "4-6", image: "images/recipe_03.jpg", description: "Recipe description...", ingredients: ["Ingredient 1", "Ingredient 2"], instructions: ["Step 1", "Step 2"] },
        "4": { title: "Recipe 4", category: "Breakfast", time: "35 mins", servings: "2", image: "images/recipe_04.jpg", description: "Recipe description...", ingredients: ["Ingredient 1", "Ingredient 2"], instructions: ["Step 1", "Step 2"] },
        "5": { title: "Recipe 5", category: "Dinner", time: "25 mins", servings: "4", image: "images/recipe_05.jpg", description: "Recipe description...", ingredients: ["Ingredient 1", "Ingredient 2"], instructions: ["Step 1", "Step 2"] },
        "6": { title: "Recipe 6", category: "Lunch", time: "60 mins", servings: "6", image: "images/recipe_06.jpg", description: "Recipe description...", ingredients: ["Ingredient 1", "Ingredient 2"], instructions: ["Step 1", "Step 2"] }
    };

    const recipeDetailContainer = document.getElementById("recipeDetailContainer");

    if (recipeDetailContainer) {
        const urlParams = new URLSearchParams(window.location.search);
        const recipeId = urlParams.get("id") || "1";
        const recipe = recipeData[recipeId] || recipeData["1"];

        document.title = `Recipe Grid - ${recipe.title}`;

        recipeDetailContainer.innerHTML = `
            <div class="row g-4 align-items-center mb-5">
                <div class="col-12 col-md-6">
                    <img src="${recipe.image}" class="img-fluid rounded-4 shadow-sm w-100 object-fit-cover" style="max-height: 400px;" alt="${recipe.title}">
                </div>
                <div class="col-12 col-md-6">
                    <span class="badge bg-light rounded-pill px-3 py-2 mb-2">${recipe.category}</span>
                    <h1 class="fw-bold mb-3">${recipe.title}</h1>
                    <p class="text-muted leading-relaxed">${recipe.description}</p>
                    
                    <div class="d-flex gap-4 border-top border-bottom py-3 my-4">
                        <div>
                            <small class="text-muted d-block">PREP TIME</small>
                            <span class="fw-bold">🕒 ${recipe.time}</span>
                        </div>
                        <div>
                            <small class="text-muted d-block">SERVINGS</small>
                            <span class="fw-bold">🍽️ ${recipe.servings}</span>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-danger rounded-pill px-4 fav-btn">♡</button>
                    </div>
                </div>
            </div>

            <div class="row g-5">
                <div class="col-12 col-md-5">
                    <div class="card border-0 bg-light p-4 rounded-4">
                        <h4 class="fw-bold mb-3">Ingredients</h4>
                        <ul class="list-group list-group-flush bg-transparent">
                            ${recipe.ingredients.map(item => `<li class="list-group-item bg-transparent px-0 border-bottom-subtle">✓ ${item}</li>`).join('')}
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-7">
                    <h4 class="fw-bold mb-3">Instructions</h4>
                    <ol class="list-group list-group-numbered list-group-flush">
                        ${recipe.instructions.map(step => `<li class="list-group-item px-0 py-3 border-bottom-subtle leading-relaxed">${step}</li>`).join('')}
                    </ol>
                </div>
            </div>
        `;
    }

    // recipe upload form validation
    const recipeUploadForm = document.getElementById("recipeUploadForm");

    if (recipeUploadForm) {
        recipeUploadForm.addEventListener("submit", function (e) {
            e.preventDefault();

            if (!recipeUploadForm.checkValidity()) {
                e.stopPropagation();
                recipeUploadForm.classList.add("was-validated");
            } else {
                recipeUploadForm.classList.remove("was-validated");
                alert("Recipe uploaded successfully!");
                recipeUploadForm.reset();
            }
        });
    }

});