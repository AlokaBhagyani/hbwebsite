<?php
if (!isset($_GET['room_id'])) {
    die("Room not specified.");
}
$room_id = intval($_GET['room_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Room</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h3>Book This Room</h3>
  <form action="confirm_booking.php" method="POST">
    <input type="hidden" name="room_id" value="<?= $room_id ?>">

    <div class="mb-3">
      <label>Name:</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Email:</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Check-in Date:</label>
      <input type="date" name="checkin_date" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Check-out Date:</label>
      <input type="date" name="checkout_date" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Confirm Booking</button>
  </form>
</div>
</body>
</html>
