/* =========================
   MOBILE MENU
========================= */

const menuBtn = document.querySelector(".menu-btn");
const navLinks = document.querySelector(".nav-links");

menuBtn.addEventListener("click", () => {
    navLinks.classList.toggle("show");
});


/* =========================
   SMOOTH SCROLL
========================= */

document.querySelectorAll('a[href^="#"]').forEach(link => {

    link.addEventListener("click", function(e) {

        e.preventDefault();

        const target = document.querySelector(this.getAttribute("href"));

        if (target) {

            target.scrollIntoView({
                behavior: "smooth"
            });

        }

        // Close mobile menu after clicking a link
        navLinks.classList.remove("show");

    });

});


/* =========================
   LIVE SEARCH
========================= */

const searchInput = document.getElementById("searchInput");
const searchBtn = document.getElementById("searchBtn");
const recipes = document.querySelectorAll(".recipe-card");

function searchRecipes() {

    const keyword = searchInput.value.toLowerCase();

    recipes.forEach(recipe => {

        const title = recipe.dataset.name.toLowerCase();

        if (title.includes(keyword)) {

            recipe.style.display = "block";

        } else {

            recipe.style.display = "none";

        }

    });

}

searchInput.addEventListener("keyup", searchRecipes);
searchBtn.addEventListener("click", searchRecipes);


/* =========================
   TAG SEARCH
========================= */

const tags = document.querySelectorAll(".tags span");

tags.forEach(tag => {

    tag.addEventListener("click", () => {

        searchInput.value = tag.textContent;

        searchRecipes();

    });

});


/* =========================
   FAVORITE BUTTON
========================= */

const hearts = document.querySelectorAll(".heart");

hearts.forEach(heart => {

    heart.addEventListener("click", () => {

        heart.classList.toggle("fa-regular");
        heart.classList.toggle("fa-solid");

    });

});


/* =========================
   ACTIVE NAVIGATION
========================= */

const sections = document.querySelectorAll("section");
const navItems = document.querySelectorAll(".nav-links a");

window.addEventListener("scroll", () => {

    let current = "";

    sections.forEach(section => {

        const sectionTop = section.offsetTop - 100;

        if (window.scrollY >= sectionTop) {

            current = section.getAttribute("id");

        }

    });

    navItems.forEach(link => {

        link.classList.remove("active");

        if (link.getAttribute("href") === "#" + current) {

            link.classList.add("active");

        }

    });

});