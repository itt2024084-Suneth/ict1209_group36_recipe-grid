# RecipeGrid

A database-driven recipe website built for the ICT 1209 (Web Technologies) first year, second semester mini project.

**Group 36**

| Name | Registration No | Index |
|---|---|---|
| H.M.S. Premakumara | ITT/2024/084 | 2769 |
| M.A.V.R. Perera | ITT/2024/081 | 2766 |

## About

RecipeGrid is an online recipe book. Recipes are stored in a MySQL database, and anyone can browse and search them. Registered users can also upload their own recipes.

We built it with university students in mind (quick and cheap meals), but it is useful for anyone who wants a place to keep recipes or look for vegetarian options.

## Features

- Browse all recipes in a card grid
- Search recipes by title
- Filter recipes by category (Breakfast, Lunch, Dinner, Vegetarian, Desserts, Drinks)
- Sign up and log in, with form validation
- Upload your own recipes with an image
- Bookmark and favourite recipes
- Live character counter on text inputs
- Contact form with validation

## Built with

- HTML5, CSS3, Bootstrap 5
- Vanilla JavaScript (no frameworks)
- PHP 8
- MySQL (through XAMPP)
- Git and GitHub

## Setup

### Requirements

- [XAMPP](https://www.apachefriends.org/) (Apache, MySQL/MariaDB and PHP 8)
- A web browser
- Git (only if you want to clone the repository)

### 1. Put the project in htdocs

The site has to be served by Apache, so the project must be inside XAMPP's `htdocs` folder. Opening the `.php` files directly in the browser will not work.

- Windows: `C:\xampp\htdocs\`
- macOS: `/Applications/XAMPP/htdocs/`

Clone or copy the project there:

```bash
cd C:\xampp\htdocs
git clone https://github.com/itt2024084-Suneth/ict1209_group36_recipe-grid.git
```

Make sure the project files are directly inside the project folder and not inside an extra nested folder.

### 2. Import the database

1. Open the XAMPP Control Panel and start **Apache** and **MySQL**.
2. Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3. Click the **Import** tab, choose `recipe_grid.sql` from the project root, and click **Import**.

This creates the `recipe_grid` database with the `users` and `recipes` tables and adds some sample recipes.

You can also import it from the command line:

```bash
mysql -u root < recipe_grid.sql
```

### 3. Check the database connection

The connection settings are in `config/db.php`. The defaults work with a fresh XAMPP install:

```php
$host = 'localhost';
$db   = 'recipe_grid';
$user = 'root';
$pass = '';   // XAMPP's default password is empty
```

If your MySQL uses a different username or password, change `$user` and `$pass`.

### 4. Open the site

Go to:

```
http://localhost/ict1209_group36_recipe-grid/
```

Use whatever name your project folder has inside `htdocs`.

To try uploading a recipe, click **Log in**, switch to **Sign Up**, create an account, log in, and then use **Upload**.

## Troubleshooting

| Problem | Fix |
|---|---|
| "Database connection failed" | Make sure MySQL is running in XAMPP and that `recipe_grid.sql` was imported. |
| Page shows raw PHP code or downloads the file | The project is not being served by Apache. Use `http://localhost/...` instead of a `file://` path. |
| Uploaded images don't show | Check that the `uploads/` folder exists in the project and is writable. |
| Sign up or log in shows a blank page or raw JSON | Make sure `js/main.js` is up to date and loads without errors (check the browser console with F12). |
| `404 Not Found` | The folder name in the URL must match the folder name in `htdocs`. |

---

&copy; 2026 RecipeGrid. All rights reserved.
