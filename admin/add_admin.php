<?php
require('db_config.php'); // MySQL connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_name = $_POST['admin_name'];
    $admin_pass = $_POST['admin_pass'];

    // ✅ Hash the password before inserting into DB
    $hashed_pass = password_hash($admin_pass, PASSWORD_BCRYPT);

    $sql = "INSERT INTO admin_cred (admin_name, admin_pass) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $admin_name, $hashed_pass);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Admin added successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('❌ Error adding admin: " . $stmt->error . "'); window.location.href='dashboard.php';</script>";
    }
}
?>
