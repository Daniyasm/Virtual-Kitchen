<?php
include('../db.php');  // Connect to the database

// Get the recipe ID from the URL
if (!isset($_GET['rid'])) {
    die("Recipe ID is missing.");
}

$rid = $_GET['rid'];

// Fetch the recipe details from the database
/* $stmt = $pdo->prepare("SELECT * FROM recipes WHERE rid = ?");
$stmt->execute([$rid]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC); */

$stmt = $pdo->prepare("
    SELECT recipes.*, users.username 
    FROM recipes 
    JOIN users ON recipes.uid = users.uid 
    WHERE recipes.rid = ?
");
$stmt->execute([$rid]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$recipe) {
    die("Recipe not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Detail</title>
    <link rel="icon" type="image/x-icon" href="../Letter G.jpg">
    <link rel="stylesheet" type="text/css" href="../stylesheet.css?v=1.1">
</head>
<body>
    <h1><?= htmlspecialchars($recipe['name']) ?></h1> 
    <!-- htmlspecialchars(): converts special characters into HTML entities which ensures safety-->
    <nav>
        <ul class="nav-list">
                <li><a href="recipes.php"> Recipes</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
    <br>
    <div class="recipe-card">
        <?php if (!empty($recipe['image']) && file_exists('../uploads/' . $recipe['image'])): ?>
            <div class="recipe-image">
                <img src="../uploads/<?= htmlspecialchars($recipe['image']) ?>" alt="Recipe Image" style="max-width: 100%; height: auto; border-radius: 12px; margin-bottom: 20px;">
            </div>
        <?php endif; ?>

        <p><strong>Type:</strong> <?= htmlspecialchars($recipe['type']) ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($recipe['description']) ?></p>
        <p><strong>Cooking Time:</strong> <?= htmlspecialchars($recipe['Cookingtime']) ?> minutes</p>
        <h3>Ingredients:</h3>
        <p><?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
        <h3>Instructions:</h3>
        <p><?= nl2br(htmlspecialchars($recipe['instructions'])) ?></p>
        <p><strong>Owner:</strong> <?= htmlspecialchars($recipe['username']) ?></p>
    </div>
    <div class="button-container">
        <a href="recipes.php" class="back-button">← Back to Recipes</a>
    </div>
</body>
</html>
