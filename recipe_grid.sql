

CREATE DATABASE IF NOT EXISTS recipe_grid
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE recipe_grid;


CREATE TABLE IF NOT EXISTS users (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    full_name  VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL,
    password   VARCHAR(255) NOT NULL,            
    created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS recipes (
    id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id      INT UNSIGNED NULL,               
    title        VARCHAR(150) NOT NULL,
    category     VARCHAR(50)  NOT NULL,           
    prep_time    SMALLINT UNSIGNED NOT NULL,      
    description  TEXT         NOT NULL,
    image        VARCHAR(255) NOT NULL,           
    ingredients  TEXT         NOT NULL,           
    instructions TEXT         NOT NULL,
    created_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_recipes_category (category),
    KEY idx_recipes_created (created_at),
    CONSTRAINT fk_recipes_user
        FOREIGN KEY (user_id) REFERENCES users (id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;


INSERT INTO recipes (user_id, title, category, prep_time, description, image, ingredients, instructions) VALUES
(NULL, 'Fluffy Pancakes', 'Breakfast', 20,
 'Soft, golden pancakes perfect for a slow morning.',
 'uploads\sample_pancakes.jpg',
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
 '1. Mix all ingredients in a large mug.\n2. Microwave for 90 seconds.\n3. Let cool for a minute before eating.'),
(NULL, 'Crispy Tofu Rainbow Bowl', 'Lunch', 25,
 'Seasoned tofu cubes over crisp lettuce with corn, edamame, egg and red cabbage.',
 'recipe_01.jpg',
 '200g firm tofu, cubed\n1 tbsp soy sauce\n1 tsp smoked paprika\n1 tbsp oil\n1/2 cup corn kernels\n1/2 cup edamame\n2 boiled quail eggs\n1/2 cup shredded red cabbage\n6 cherry tomatoes, halved\n1/2 cucumber, diced\nLettuce leaves\nSpring onion, sliced',
 '1. Toss the tofu with soy sauce and paprika.\n2. Pan-fry in oil until golden and crisp on all sides.\n3. Line a bowl with lettuce.\n4. Arrange the tofu, corn, edamame, egg, cabbage, tomatoes and cucumber in sections.\n5. Top with spring onion and serve.'),
(NULL, 'Pan-Seared Sliced Steak', 'Dinner', 40,
 'Juicy, charred steak rested and sliced against the grain.',
 'recipe_02.jpg',
 '2 steaks (ribeye or sirloin)\n2 tbsp oil\n2 tbsp butter\n3 cloves garlic, smashed\n2 sprigs thyme\nCoarse salt\nBlack pepper',
 '1. Bring the steaks to room temperature and season generously.\n2. Sear in a very hot oiled pan for 3 minutes per side.\n3. Add butter, garlic and thyme and baste for 1 minute.\n4. Rest the steaks for 8 minutes.\n5. Slice against the grain and serve on a wooden board.'),
(NULL, 'Fresh Fruit Cocktail Trio', 'Drinks', 10,
 'Three bright, refreshing cocktails: pineapple, lime-mint and berry.',
 'recipe_03.jpg',
 '60ml white rum (per glass)\n1/2 cup pineapple chunks\n1 lime\nFresh mint leaves\n1/2 cup mixed berries\n2 tbsp sugar syrup\nSoda water\nCrushed ice\n1 maraschino cherry',
 '1. Muddle pineapple in one glass, lime and mint in another, and berries in a third.\n2. Add rum and sugar syrup to each glass.\n3. Fill with crushed ice and top with soda water.\n4. Garnish with cherry, lime wheel and mint.\n5. Serve with straws.'),
(NULL, 'Rainbow Veggie Power Bowl', 'Vegetarian', 30,
 'A colourful bowl of roasted sweet potato, chickpeas, avocado and fresh vegetables.',
 'recipe_04.jpg',
 '1 sweet potato, cubed\n1 cup cooked chickpeas\n1 avocado, sliced\n1 cup cherry tomatoes\n1/2 cup shredded red cabbage\n1 watermelon radish, sliced\n1 yellow bell pepper, sliced\nLettuce and microgreens\n2 tbsp yogurt dressing',
 '1. Roast the sweet potato cubes at 200C for 20 minutes.\n2. Arrange lettuce in a large bowl.\n3. Add the chickpeas, tomatoes, cabbage, radish, pepper and avocado in sections.\n4. Add the roasted sweet potato and microgreens.\n5. Drizzle with yogurt dressing.'),
(NULL, 'Rosemary Cheese Pizza', 'Dinner', 45,
 'Golden, bubbly mozzarella pizza with a hint of fresh rosemary.',
 'recipe_05.jpg',
 '1 pizza dough ball\n1/2 cup tomato sauce\n200g mozzarella, grated\n50g parmesan\n2 sprigs rosemary\n1 tbsp olive oil\nCherry tomatoes to serve',
 '1. Preheat the oven to 250C.\n2. Stretch the dough and spread with tomato sauce.\n3. Top with mozzarella, parmesan and rosemary leaves.\n4. Drizzle with olive oil.\n5. Bake for 10 to 12 minutes until golden and bubbling.\n6. Slice and serve.'),
(NULL, 'Smoky BBQ Ribs', 'Dinner', 120,
 'Tender slow-baked pork ribs glazed in sticky barbecue sauce, served with fries and pickles.',
 'recipe_06.jpg',
 '1 rack pork ribs\n1 tbsp smoked paprika\n1 tbsp brown sugar\n1 tsp garlic powder\n1 tsp salt\n1/2 cup BBQ sauce\nSliced tomatoes\nPickled gherkins\nFrench fries\nChives',
 '1. Rub the ribs with paprika, sugar, garlic powder and salt.\n2. Wrap in foil and bake at 150C for 90 minutes.\n3. Unwrap, brush with BBQ sauce and grill for 10 minutes until sticky.\n4. Slice and serve with tomatoes, pickles, fries and extra sauce.');
