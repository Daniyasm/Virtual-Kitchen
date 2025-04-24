<?php
session_start();
require_once('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['uid'] = $user['uid'];
        $_SESSION['username'] = $user['username'];
        header("Location: ../users/dashboard.php");
        exit;
    } else {
        echo "Invalid login credentials.";
    }
}
?>
