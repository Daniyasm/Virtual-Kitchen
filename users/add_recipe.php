<?php
session_start();
include('../db.php');

// Check if user is logged in
if (!isset($_SESSION['uid'])) {
    header("Location: ../public/login.php");
    exit;
}

$message = ""; // to show success or error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $cookingtime = $_POST['cookingtime'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $uid = $_SESSION['uid'];
    $imageFileName = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $tmpName = $_FILES['image']['tmp_name'];
        $originalName = basename($_FILES['image']['name']); //basename(): to get the file name without path
        $fileType = mime_content_type($tmpName); // Checks the actual type of a file based on its contents, not just its extension.
        $fileSize = $_FILES['image']['size'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (in_array($fileType, $allowedTypes)) {
            if ($fileSize <= 2 * 1024 * 1024) {
                $uniqueName = uniqid() . "_" . $originalName; //Generates a unique string based on the current time, so the file name won’t clash with others.
                $destination = "../uploads/" . $uniqueName;

                if (move_uploaded_file($tmpName, $destination)) {
                    $imageFileName = $uniqueName;
                } else {
                    $message = "Error saving uploaded file.";
                }
            } else {
                $message = "File too large. Max size is 2MB.";
            }
        } else {
            $message = "Invalid file type. Only JPG, PNG, GIF, WEBP allowed.";
        }
    } else {
        $message = "Please upload an image.";
    }

    // Insert into DB only if no image errors
    if (!$message) {
        $stmt = $pdo->prepare("INSERT INTO recipes (name, type, description, Cookingtime, ingredients, instructions, uid, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $type, $description, $cookingtime, $ingredients, $instructions, $uid, $imageFileName]);
        header("Location: dashboard.php?message=Recipe+added+successfully");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Recipe</title>
    <link rel="icon" type="image/x-icon" href="../Letter G.jpg">
    <link rel="stylesheet" href="../stylesheet.css?v=1.3">
</head>
<body>
    <h1>Add New Recipe</h1>
    <nav>
        <ul class="nav-list">
            <li><a href="add_recipe.php">Add Recipes</a></li>
            <li><a href="dashboard.php">Your Dashboard</a></li>
            <li><a href="../action/logout_action.php">Logout</a></li>
        </ul>
    </nav>
    <?php if ($message): ?>
        <p class="error-message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="recipe-card">
            <label for="name">Recipe Name:</label>
            <input type="text" name="name" required><br><br>

            <label for="type">Type:</label>
            <select name="type" required>
                <option value="French">French</option>
                <option value="Italian">Italian</option>
                <option value="Chinese">Chinese</option>
                <option value="Indian">Indian</option>
                <option value="Mexican">Mexican</option>
                <option value="others">Others</option>
            </select><br><br>

            <label for="description">Description:</label>
            <textarea name="description" required></textarea><br><br>

            <label for="cookingtime">Cooking Time (in minutes):</label>
            <input type="number" name="cookingtime" required><br><br>

            <label for="ingredients">Ingredients:</label>
            <textarea name="ingredients" required></textarea><br><br>

            <label for="instructions">Instructions:</label>
            <textarea name="instructions" required></textarea><br><br>

            <label for="image">Upload Image:</label>
            <input type="file" name="image" accept="image/*" required><br><br>
        </div>
        <div class="button-container">
            <button type="submit" class="back-button">Add Recipe</button>
        </div>
    </form>
</body>
</html>
