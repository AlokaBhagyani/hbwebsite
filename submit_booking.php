<?php

include '../admin/db_config.php'; // already used in bookings.php

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$room_id = intval($_POST['room_id']);
$guest_name = $_POST['name'];
$email = $_POST['email'];   // You can store email in another table or ignore if not needed
$check_in = $_POST['checkin'];
$check_out = $_POST['checkout'];

$sql = "INSERT INTO bookings (guest_name, room_id, check_in, check_out) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
  die("SQL error: " . $conn->error);
}
$stmt->bind_param("siss", $guest_name, $room_id, $check_in, $check_out);
$stmt->execute();
$stmt->close();
$conn->close();

echo "<script>alert('Booking successful!'); window.location.href='rooms.php';</script>";
?>
