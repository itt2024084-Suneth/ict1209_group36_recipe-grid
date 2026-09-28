document.addEventListener("DOMContentLoaded", function () {

    // ---------------------------------------------------------------
    // Shared helper: show a Bootstrap-style alert inside a container
    // ---------------------------------------------------------------
    function showAlert(el, type, message) {
        if (!el) return;
        el.className = `alert alert-${type} mb-3`;
        el.textContent = message;
    }

    // ---------------------------------------------------------------
    // Filtering & Category Initialization
    // ---------------------------------------------------------------
    const categoryButtons = document.querySelectorAll(".category-btn");
    const recipeItems = document.querySelectorAll(".recipe-item");
    const searchInput = document.getElementById("recipeSearchInput");
    const searchBtn = document.getElementById("searchBtn");

    // Extract initial category/search from URL (e.g., categories.php?cat=breakfast&search=rice)
    const urlParams = new URLSearchParams(window.location.search);
    let activeCategory = (urlParams.get("cat") || "all").toLowerCase();
    if (activeCategory === "desserts") activeCategory = "dessert";

    // Pre-fill the search box when arriving from the home page search form
    const initialSearch = urlParams.get("search");
    if (searchInput && initialSearch) {
        searchInput.value = initialSearch;
    }

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

    // ---------------------------------------------------------------
    // Auth Tab Switchers (for unified login/register UI)
    // ---------------------------------------------------------------
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

    // ---------------------------------------------------------------
    // Login & Register (asynchronous, JSON responses from actions/*.php)
    // ---------------------------------------------------------------
    const pageAuthAlert = document.getElementById("pageAuthAlert");
    const pageLoginForm = document.getElementById("pageLoginForm");
    const pageRegisterForm = document.getElementById("pageRegisterForm");

    function submitAuthForm(form, onSuccess) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            if (!form.checkValidity()) {
                e.stopPropagation();
                form.classList.add("was-validated");
                return;
            }

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalLabel = submitBtn ? submitBtn.textContent : "";
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = "Please wait...";
            }

            fetch(form.getAttribute("action"), {
                method: "POST",
                body: new FormData(form)
            })
            .then(res => res.json())
            .then(data => {
                showAlert(pageAuthAlert, data.status === "success" ? "success" : "danger", data.message);
                if (data.status === "success") {
                    onSuccess(form);
                }
            })
            .catch(() => {
                showAlert(pageAuthAlert, "danger", "Something went wrong. Please try again.");
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalLabel;
                }
            });
        });
    }

    if (pageLoginForm) {
        submitAuthForm(pageLoginForm, function () {
            setTimeout(() => { window.location.href = "index.php"; }, 700);
        });
    }

    if (pageRegisterForm) {
        submitAuthForm(pageRegisterForm, function (form) {
            const registeredEmail = form.querySelector('[name="email"]').value;
            form.reset();
            form.classList.remove("was-validated");

            // Move the user to the Log In tab with their email pre-filled
            const loginEmail = document.getElementById("pageLoginEmail");
            if (loginEmail) loginEmail.value = registeredEmail;

            setTimeout(() => {
                const loginTab = document.getElementById("login-tab");
                if (loginTab) loginTab.click();
            }, 1200);
        });
    }

    // ---------------------------------------------------------------
    // Navbar Toggle Behavior
    // ---------------------------------------------------------------
    const toggler = document.querySelector(".navbar-toggler");
    const navCollapse = document.getElementById("navbarNav");

    if (toggler && navCollapse) {
        toggler.addEventListener("click", function () {
            navCollapse.classList.toggle("show");
            const isExpanded = navCollapse.classList.contains("show");
            toggler.setAttribute("aria-expanded", isExpanded);
        });
    }

    // ---------------------------------------------------------------
    // Bookmark & Favorite Toggles
    // ---------------------------------------------------------------
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

    // ---------------------------------------------------------------
    // Contact Form Counter & Validation (client-side only)
    // ---------------------------------------------------------------
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

    // ---------------------------------------------------------------
    // Recipe Upload Form Handler (Asynchronous PHP Upload)
    // ---------------------------------------------------------------
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

            const submitBtn = recipeUploadForm.querySelector('button[type="submit"]');
            if (submitBtn) submitBtn.disabled = true;

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
                } else if (submitBtn) {
                    submitBtn.disabled = false;
                }
            })
            .catch(() => {
                if (recipeUploadAlert) {
                    recipeUploadAlert.className = "alert alert-danger mb-3";
                    recipeUploadAlert.textContent = "An error occurred while uploading. Please try again.";
                    recipeUploadAlert.classList.remove("d-none");
                }
                if (submitBtn) submitBtn.disabled = false;
            });
        });
    }

});
