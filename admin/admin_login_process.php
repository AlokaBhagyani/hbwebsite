<?php
session_start();
require('db_config.php'); // MySQL connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM admin_cred WHERE admin_name = ?";
  $stmt = $conn->prepare($sql);

  if (!$stmt) {
    die("Prepare failed: " . $conn->error); // Show DB error
  }

  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

  } else {
    echo "<script>alert('Admin not found'); window.location.href='index.php';</script>";
  }
}
?>
