document.addEventListener("DOMContentLoaded", function () {

    // Filtering & Category Initialization
    const categoryButtons = document.querySelectorAll(".category-btn");
    const recipeItems = document.querySelectorAll(".recipe-item");
    const searchInput = document.getElementById("recipeSearchInput");
    const searchBtn = document.getElementById("searchBtn");

    // Extract initial category from URL query parameters (e.g., categories.php?cat=breakfast)
    const urlParams = new URLSearchParams(window.location.search);
    let activeCategory = (urlParams.get("cat") || "all").toLowerCase();
    if (activeCategory === "desserts") activeCategory = "dessert";

    // Set active class on category button matching URL query param
    categoryButtons.forEach(btn => {
        let btnCat = (btn.dataset.category || "all").toLowerCase();
        if (btnCat === "desserts") btnCat = "dessert";

        if (btnCat === activeCategory) {
            btn.classList.add("active");
        } else {
            btn.classList.remove("active");
        }
    });

    function filterRecipes() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : "";

        recipeItems.forEach(item => {
            let itemCategory = (item.dataset.category || "").toLowerCase();
            if (itemCategory === "desserts") itemCategory = "dessert";
            
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

    // Run initial filter on page load
    filterRecipes();

    categoryButtons.forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            categoryButtons.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");

            activeCategory = (this.dataset.category || "all").toLowerCase();
            if (activeCategory === "desserts") activeCategory = "dessert";

            filterRecipes();
        });
    });

    if (searchInput) {
        searchInput.addEventListener("input", filterRecipes);
    }
    if (searchBtn) {
        searchBtn.addEventListener("click", filterRecipes);
    }

    // Auth Tab Switchers (for unified login/register UI)
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

    // Navbar Toggle Behavior
    const toggler = document.querySelector(".navbar-toggler");
    const navCollapse = document.getElementById("navbarNav");

    if (toggler && navCollapse) {
        toggler.addEventListener("click", function () {
            navCollapse.classList.toggle("show");
            const isExpanded = navCollapse.classList.contains("show");
            toggler.setAttribute("aria-expanded", isExpanded);
        });
    }

    // Bookmark & Favorite Toggles
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

    // Contact Form Counter & Validation
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

    // Recipe Upload Form Handler (Asynchronous PHP Upload)
    const recipeUploadForm = document.getElementById("recipeUploadForm");
    const recipeUploadAlert = document.getElementById("recipeUploadAlert");

    if (recipeUploadForm) {
        recipeUploadForm.addEventListener("submit", function (e) {
            e.preventDefault();

            if (!recipeUploadForm.checkValidity()) {
                e.stopPropagation();
                recipeUploadForm.classList.add("was-validated");
                return;
            }

            const formData = new FormData(recipeUploadForm);

            fetch("actions/upload_recipe.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (recipeUploadAlert) {
                    recipeUploadAlert.className = `alert alert-${data.status === 'success' ? 'success' : 'danger'} mb-3`;
                    recipeUploadAlert.textContent = data.message;
                    recipeUploadAlert.classList.remove("d-none");
                }

                if (data.status === "success") {
                    recipeUploadForm.reset();
                    recipeUploadForm.classList.remove("was-validated");
                    setTimeout(() => {
                        window.location.href = "index.php";
                    }, 1500);
                }
            })
            .catch(() => {
                if (recipeUploadAlert) {
                    recipeUploadAlert.className = "alert alert-danger mb-3";
                    recipeUploadAlert.textContent = "An error occurred while uploading. Please try again.";
                    recipeUploadAlert.classList.remove("d-none");
                }
            });
        });
    }

});