<?php
include('../db.php');  // Connect to the database

// Fetch all recipes from the database
$stmt = $pdo->prepare("SELECT * FROM recipes");
$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Listing</title>
    <link rel="icon" type="image/x-icon" href="../Letter G.jpg">
    <link rel="stylesheet" type="text/css" href="../stylesheet.css?v=1.1">
</head>
<body>
    <header>
        <h1>All Recipes</h1>

        <nav>
            <ul class="nav-list">
                <li><a href="add_recipe.php"> Recipes</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    <br>
    <div class="recipe-list">
        <ul>
            <?php foreach ($recipes as $recipe): ?>
                <li>
                    <a href="recipe_detail.php?rid=<?= $recipe['rid'] ?>">
                        <h2><?= htmlspecialchars($recipe['name']) ?></h2>
                    </a>
                    <p>Type: <?= htmlspecialchars($recipe['type']) ?></p>
                    <p>Description: <?= htmlspecialchars($recipe['description']) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
