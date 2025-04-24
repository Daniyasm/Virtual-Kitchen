<?php
session_start();
include('../db.php');

//Check if user is logged in
if (!isset($_SESSION['uid'])) {
    header("Location: ../public/login.php");
    exit;
}

// Get the recipe ID from the URL
if (!isset($_GET['rid'])) {
    die("Recipe ID is missing.");
}

$rid = $_GET['rid'];

// Fetch the recipe from the database
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE rid = ? AND uid = ?");
$stmt->execute([$rid, $_SESSION['uid']]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    die("Recipe not found or you don't have permission to edit it."); //Authorization
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $cookingtime = $_POST['Cookingtime'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $imagePath = $recipe['image']; // default: keep old image

    // validate and process the uploaded image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['image']['tmp_name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = mime_content_type($tmpName);

        if (str_starts_with($fileType, 'image/') && $fileSize <= 2 * 1024 * 1024) {
            $uniqueName = uniqid() . "_" . basename($_FILES['image']['name']);
            $uploadDir = '../uploads/';
            $destination = $uploadDir . $uniqueName; //making the file path

            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true); // make sure uploads/ exists
            move_uploaded_file($tmpName, $destination);

            // delete old image file
            if (!empty($recipe['image']) && file_exists('../uploads/' . $recipe['image'])) {
                unlink('../uploads/' . $recipe['image']);
            }

            $imagePath = $uniqueName;
        }
    }

    // update everything
    $stmt = $pdo->prepare("UPDATE recipes SET name = ?, type = ?, description = ?, Cookingtime = ?, ingredients = ?, instructions = ?, image = ? WHERE rid = ?");
    $stmt->execute([$name, $type, $description, $cookingtime, $ingredients, $instructions, $imagePath, $rid]);


    // Redirect to the dashboard after successful update
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
    <link rel="icon" type="image/x-icon" href="../Letter G.jpg">
    <link rel="stylesheet" type="text/css" href="../stylesheet.css?v=1.2">
</head>
<body>
    <h1>Edit Recipe</h1>
    <nav>
        <ul class="nav-list">
            <li><a href="add_recipe.php">Add Recipes</a></li>
            <li><a href="dashboard.php">Your Dashboard</a></li>
            <li><a href="../action/logout_action.php">Logout</a></li>
        </ul>
    </nav>
    <br>
    <form method="POST" enctype="multipart/form-data">
    <div class="recipe-card">
        <label for="name">Recipe Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($recipe['name']) ?>" required><br><br>

        <label for="type">Type:</label>
        <select name="type" required>
            <option value="French" <?= $recipe['type'] == 'French' ? 'selected' : '' ?>>French</option>
            <option value="Italian" <?= $recipe['type'] == 'Italian' ? 'selected' : '' ?>>Italian</option>
            <option value="Chinese" <?= $recipe['type'] == 'Chinese' ? 'selected' : '' ?>>Chinese</option>
            <option value="Indian" <?= $recipe['type'] == 'Indian' ? 'selected' : '' ?>>Indian</option>
            <option value="Mexican" <?= $recipe['type'] == 'Mexican' ? 'selected' : '' ?>>Mexican</option>
            <option value="others" <?= $recipe['type'] == 'others' ? 'selected' : '' ?>>Others</option>
        </select><br><br>

        <label for="description">Description:</label>
        <textarea name="description" required><?= htmlspecialchars($recipe['description']) ?></textarea><br><br>

        <label for="Cookingtime">Cooking Time (in minutes):</label>
        <input type="number" name="Cookingtime" value="<?= htmlspecialchars($recipe['Cookingtime']) ?>" required><br><br>

        <label for="ingredients">Ingredients:</label>
        <textarea name="ingredients" required><?= htmlspecialchars($recipe['ingredients']) ?></textarea><br><br>

        <label for="instructions">Instructions:</label>
        <textarea name="instructions" required><?= htmlspecialchars($recipe['instructions']) ?></textarea><br><br>

        <label for="image">Update Image (optional):</label>
        <input type="file" name="image" accept="image/*"><br><br>
        <p>Current Image: <img src="../images/<?= htmlspecialchars($recipe['image']) ?>" alt="Recipe Image" width="100"></p>
    </div>
    <div class="button-container">
        <button type="submit" class="back-button">Update Recipe</button>
    </div>
    </form>
</body>
</html>
