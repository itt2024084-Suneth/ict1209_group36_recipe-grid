-- Recipe Grid database setup (MySQL / MariaDB, XAMPP)
-- Matches config/db.php: host=localhost, db=recipe_grid, user=root, empty password
-- Import via phpMyAdmin (Import tab) or: mysql -u root < recipe_grid.sql

CREATE DATABASE IF NOT EXISTS recipe_grid
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE recipe_grid;

-- ---------------------------------------------------------------
-- users: written by actions/register.php, read by actions/login.php
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    full_name  VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL,
    password   VARCHAR(255) NOT NULL,            -- password_hash() output
    created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------
-- recipes: written by actions/upload_recipe.php,
-- read by index.php, categories.php, recipe.php
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS recipes (
    id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id      INT UNSIGNED NULL,               -- NULL for seed/orphaned recipes
    title        VARCHAR(150) NOT NULL,
    category     VARCHAR(50)  NOT NULL,           -- Breakfast, Lunch, Dinner, Vegetarian, Desserts
    prep_time    SMALLINT UNSIGNED NOT NULL,      -- minutes
    description  TEXT         NOT NULL,
    image        VARCHAR(255) NOT NULL,           -- filename inside /uploads
    ingredients  TEXT         NOT NULL,           -- one ingredient per line
    instructions TEXT         NOT NULL,
    created_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_recipes_category (category),
    KEY idx_recipes_created (created_at),
    CONSTRAINT fk_recipes_user
        FOREIGN KEY (user_id) REFERENCES users (id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------
-- Sample recipes (optional; delete this block if not wanted).
-- Images don't exist in /uploads, so pages fall back to
-- images/recipe_01.jpg via the onerror handler.
-- ---------------------------------------------------------------
INSERT INTO recipes (user_id, title, category, prep_time, description, image, ingredients, instructions) VALUES
(NULL, 'Fluffy Pancakes', 'Breakfast', 20,
 'Soft, golden pancakes perfect for a slow morning.',
 'sample_pancakes.jpg',
 '1 cup all-purpose flour\n1 tbsp sugar\n2 tsp baking powder\n1 cup milk\n1 egg\n2 tbsp melted butter',
 '1. Whisk the dry ingredients together.\n2. Mix in milk, egg and melted butter until just combined.\n3. Pour batter onto a hot greased pan.\n4. Cook until bubbles form, flip, and cook until golden.'),
(NULL, 'Chicken Fried Rice', 'Lunch', 25,
 'A quick one-pan lunch using leftover rice.',
 'sample_fried_rice.jpg',
 '2 cups cooked rice\n1 chicken breast, diced\n1 egg\n1/2 cup mixed vegetables\n2 tbsp soy sauce\n1 tbsp oil',
 '1. Heat oil and cook the chicken until done.\n2. Push chicken aside, scramble the egg.\n3. Add vegetables and rice, stir-fry for 3 minutes.\n4. Season with soy sauce and serve hot.'),
(NULL, 'Creamy Garlic Pasta', 'Dinner', 30,
 'Silky garlic cream sauce over al dente pasta.',
 'sample_pasta.jpg',
 '200g pasta\n2 cloves garlic\n1 cup heavy cream\n1/2 cup grated parmesan\n1 tbsp butter\nSalt and pepper',
 '1. Boil pasta until al dente and drain.\n2. Saute garlic in butter for 1 minute.\n3. Add cream and simmer until slightly thick.\n4. Stir in parmesan, toss with pasta, season and serve.'),
(NULL, 'Vegetable Curry', 'Vegetarian', 35,
 'A warming coconut curry packed with vegetables.',
 'sample_curry.jpg',
 '1 potato, cubed\n1 carrot, sliced\n1 cup cauliflower florets\n1 cup coconut milk\n2 tbsp curry powder\n1 onion, chopped',
 '1. Saute the onion until soft.\n2. Add curry powder and stir for 30 seconds.\n3. Add vegetables and coconut milk.\n4. Simmer 20 minutes until tender.'),
(NULL, 'Chocolate Mug Cake', 'Desserts', 10,
 'A single-serve chocolate cake ready in minutes.',
 'sample_mug_cake.jpg',
 '4 tbsp flour\n3 tbsp sugar\n2 tbsp cocoa powder\n3 tbsp milk\n2 tbsp oil\n1/4 tsp baking powder',
 '1. Mix all ingredients in a large mug.\n2. Microwave for 90 seconds.\n3. Let cool for a minute before eating.');
