<?php
session_start();
require('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username already exists
    $check = $conn->prepare("SELECT admin_name FROM admin_cred WHERE admin_name = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists'); window.location.href='register.php';</script>";
    } else {
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT); // Secure hash
        $insert = $conn->prepare("INSERT INTO admin_cred (admin_name, admin_pass) VALUES (?, ?)");
        $insert->bind_param("ss", $username, $hashed_pass);
        if ($insert->execute()) {
            echo "<script>alert('Registration successful'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error registering admin'); window.location.href='register.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Admin Registration</h4>
                </div>
                <div class="card-body">
                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Register</button>
                    </form>
                    <hr>
                    <p class="text-center mb-0">
                        Already registered? 
                        <a href="index.php">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
