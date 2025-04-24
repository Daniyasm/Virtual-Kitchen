<?php
session_start();
include('../db.php');

// Check if user is logged in
if (!isset($_SESSION['uid'])) {
    header("Location: ../public/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your Dashboard</title>
  <link rel="icon" type="image/x-icon" href="../Letter G.jpg">
  <link rel="stylesheet" type="text/css" href="../stylesheet.css?v=1.2" />
</head>
<body>

  <h1>Welcome to Your Dashboard, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>

  <nav>
    <ul class="nav-list">
      <li><a href="add_recipe.php">Add Recipe</a></li>
      <li><a href="dashboard.php">Your Dashboard</a></li>
      <li><a href="../action/logout_action.php">Logout</a></li>
    </ul>
  </nav>

  <?php if (isset($_GET['message'])): ?>
    <div class="message"><?= htmlspecialchars($_GET['message']) ?></div>
  <?php endif; ?>

  <div class="centered-button">
    <a href="add_recipe.php" class="button">Add New Recipe</a>
  </div>

  <h2>Your Recipes</h2>
  <div class="recipe-list">
    <ul>
      <?php
      $uid = $_SESSION['uid'];
      $stmt = $pdo->prepare("SELECT * FROM recipes WHERE uid = ?");
      $stmt->execute([$uid]);
      $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($recipes as $recipe): ?>
        <li>
          <h3><?= htmlspecialchars($recipe['name']) ?></h3>
          <p>Type: <?= htmlspecialchars($recipe['type']) ?></p>
          <div class="button-group">
            <a href="../public/recipe_detail.php?rid=<?= $recipe['rid'] ?>" class="small-button">View</a>
            <a href="edit_recipe.php?rid=<?= $recipe['rid'] ?>" class="small-button">Edit</a>
            <a href="delete_recipe.php?rid=<?= $recipe['rid'] ?>" class="small-button delete" onclick="return confirm('Are you sure you want to delete this recipe?')">Delete</a>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>

</body>
</html>
