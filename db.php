<?php

$db_host = 'localhost';
$db_name = 'u_240139513_vkitchen';
$username = 'u-240139513';
$password = 'w0U83aWrZyIhFm4';

try {
    $pdo = new PDO("mysql:dbname=$db_name;host=$db_host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo("Successfully connected to the database.<br>");
} catch(PDOException $ex) {
    echo("Failed to connect to the database.<br>");
    echo($ex->getMessage());
    exit;
}

?>