<?php
session_start();
require('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin_cred WHERE admin_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['admin_pass'])) {
            $_SESSION['admin'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Admin not found'); window.location.href='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Admin Login</h4>
                </div>
                <div class="card-body">
                    <form action="index.php" method="POST">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Login</button>
                    </form>
                    <hr>
                    <p class="text-center mb-0">
                        Don’t have an account? 
                        <a href="register.php">Register here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
