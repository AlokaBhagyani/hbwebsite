<?php
$servername = "localhost";
$username = "root";
$password = ""; // default in XAMPP is no password
$dbname = "hbwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

