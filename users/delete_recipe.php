<?php
session_start();
include('../db.php');

//Check if user is logged in
if (!isset($_SESSION['uid'])) {
    header("Location: ../public/login.php");
    exit;
}

// Check if the recipe ID is provided
if (isset($_GET['rid'])) {
    $rid = $_GET['rid'];

    // Get the UID of the recipe to verify ownership
    $stmt = $pdo->prepare("SELECT uid FROM recipes WHERE rid = ?");
    $stmt->execute([$rid]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($recipe) {
        // Check if the logged-in user is the owner of the recipe
        if ($recipe['uid'] == $_SESSION['uid']) {
            // Delete the recipe
            $deleteStmt = $pdo->prepare("DELETE FROM recipes WHERE rid = ?");
            $deleteStmt->execute([$rid]);

            // Redirect to dashboard with a success message
            header("Location: dashboard.php?message=Recipe+deleted+successfully");
            exit;
        } else {
            // If the user is not the owner : Authorization
            header("Location: dashboard.php?message=You+do+not+have+permission+to+delete+this+recipe");
            exit;
        }
    } else {
        // If the recipe doesn't exist
        header("Location: dashboard.php?message=Recipe+not+found");
        exit;
    }
} else {
    // If no recipe ID is provided
    header("Location: dashboard.php?message=Invalid+recipe+ID");
    exit;
}
?>
