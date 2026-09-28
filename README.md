# ict1209_group36_recipe-grid

RecipeGrid - Interactive Database-Driven Culinary Management Platform

Course: ICT 1209 - Web Technologies
Assignment: First Year Second Semester Mini Project
Group: Group 36
Members:- H.M.S. Premakumara | Registration No: ITT/2024/084 | Index: 2769
          M.A.V.R. Perera    | Registration No: ITT/2024/081 | Index: 2766


1. PROJECT THEME & OVERVIEW

RecipeGrid is a database-driven digital recipe book designed to organize 
culinary content, simplify meal discovery, and enable community recipe 
sharing.

The platform aims to solve everyday meal-planning challenges faced by 
university students needing quick/budget recipes, home cooks building a 
personal recipe ledger, and health-conscious users searching for dietary 
options like vegetarian meals.

Main Goals:
- Centralized Database: Store and manage recipes in an accessible catalog.
- Community Uploads: Allow registered users to submit custom recipes.
- Meal Categorization: Filter recipes by dietary tags and meal types.


2. PLANNED & IMPLEMENTED FEATURES

- Dynamic Search & Filter: Real-time search by title and filter buttons 
  for categories (Breakfast, Lunch, Dinner, Dessert).
- Interactive UI Elements: Native JavaScript functionality for bookmarking, 
  favoriting items, and live input character counting.
- Security & Auth System: Tabbed login and sign-up interface with client-side 
  validation and status alerts.
- Contact & Feedback Form: User messaging system with validation.
- Framework-Free JS Logic: Custom lightweight Vanilla JavaScript replacing 
  heavy external script dependencies.


3. TECHNOLOGY STACK

- Frontend Presentation: HTML5, CSS3, Bootstrap 5 (Styling)
- Client-Side Logic: Vanilla JavaScript 
- Backend Operations: PHP 8
- Database: MySQL (managed via XAMPP)
- Version Control: GitHub


4. SETUP

## 4. SETUP

### 4.1 Requirements

- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL/MariaDB + PHP 8)
- A web browser
- Git (optional, only if cloning)

### 4.2 Where to put the project files

The project must run through Apache, so it has to live inside XAMPP's `htdocs` folder. Opening the `.php` files directly in the browser will not work.

1. Open XAMPP's `htdocs` folder:
   - Windows: `C:\xampp\htdocs\`
   - macOS: `/Applications/XAMPP/htdocs/`
2. Clone or copy the project into it:

   ```bash
   cd C:\xampp\htdocs
   git clone https://github.com/itt2024084-Suneth/ict1209_group36_recipe-grid.git
   ```

3. Make sure the files sit directly inside the project folder, not in an extra nested folder:

 
   ```

### 4.3 Database setup

1. Open the XAMPP Control Panel and start **Apache** and **MySQL**.
2. Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3. Click the **Import** tab, choose `recipe_grid.sql` from the project root, and click **Import**.
   - This creates the `recipe_grid` database with the `users` and `recipes` tables, plus a few sample recipes.
   - Command line alternative: `mysql -u root < recipe_grid.sql`

### 4.4 Database connection

The connection settings are in `config/db.php`. The defaults match a fresh XAMPP install, so no changes are needed:

```php
$host = 'localhost';
$db   = 'recipe_grid';
$user = 'root';
$pass = '';   // default XAMPP password is empty
```

If your MySQL uses a different username or password, edit `$user` and `$pass` here.

### 4.5 Run the site

Open your browser and go to:

```
http://localhost/ict1209_group36_recipe-grid/
```

(Use whatever name your project folder has inside `htdocs`.)

To try the upload feature, go to **Log in → Sign Up**, create an account, log in, then use **Upload**.

### 4.6 Troubleshooting

| Problem | Fix |
|---|---|
| "Database connection failed" | Check that MySQL is running in XAMPP and that `recipe_grid` was imported. |
| Page shows raw PHP code or downloads the file | The project is not being served by Apache. Use `http://localhost/...`, not a `file://` path. |
| Uploaded images don't show | Check that the `uploads/` folder exists inside the project and is writable. |
| Sign up or log in shows a blank page or raw JSON | Make sure `js/main.js` is the latest version and loads without errors (browser console, F12). |
| `404 Not Found` | The folder name in the URL must match the folder name inside `htdocs`. |



(c) 2026 RecipeGrid. All Rights Reserved.
