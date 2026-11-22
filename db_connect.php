<?php
$host = "localhost";
$user = "root";   // Your username
$pass = "";    // Your password
$dbname = "hbwebsite"; // Your DB

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
