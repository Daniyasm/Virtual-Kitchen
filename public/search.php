<?php
include('../db.php');  // Connect to the database

// If the form was submitted
if (isset($_POST['search'])) {
    $search = $_POST['search'];

    // Fetch recipes matching the search term (name or type)
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE name LIKE ? OR type LIKE ?");
    $stmt->execute(["%$search%", "%$search%"]);
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $recipes = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Recipes</title>
    <link rel="icon" type="image/x-icon" href="../Letter G.jpg">
    <link rel="stylesheet" type="text/css" href="../stylesheet.css?v=1.1">
</head>
<body>
    <h1>Search Recipes</h1>
    <nav>
        <ul class="nav-list">
            <li><a href="add_recipe.php"> Recipes</a></li>
            <li><a href="search.php">Search</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
    <br>
    <div id="search-section">
        <form method="POST">
            <input type="text" name="search" id="search-input" placeholder="Search by name or type" required>
            <button type="submit" id="search-button">Search</button>
        </form>
    </div>

    <!-- <form method="POST">
        <input type="text" name="search" placeholder="Search by name or type" required>
        <button type="submit">Search</button>
    </form> -->

    <!-- <div class="recipe-list"> -->
    <?php if (!empty($recipes)): ?>
        <ul id="search-results">
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
    <?php else: ?>
        <p>No recipes found.</p>
    <?php endif; ?>
    </div>
</body>
</html>
