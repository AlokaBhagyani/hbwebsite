<?php
include '../hbwebsite/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $room_id = filter_var($_POST['room_id'], FILTER_VALIDATE_INT);
    $guest_name = trim($_POST['name'] ?? '');
    $guest_email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $checkin_date = $_POST['checkin_date'] ?? '';
    $checkout_date = $_POST['checkout_date'] ?? '';

    if (!$room_id || !$guest_name || !$guest_email || !$checkin_date || !$checkout_date) {
        die("❌ Please fill in all required fields with valid data.");
    }

    if ($checkin_date >= $checkout_date) {
        die("❌ Check-out date must be after check-in date.");
    }

    try {
        $pdo->beginTransaction();

        // Insert booking into bookings table
        $stmt = $pdo->prepare("
            INSERT INTO bookings (room_id, guest_name, guest_email, check_in, check_out, status)
            VALUES (?, ?, ?, ?, ?, 'confirmed')
        ");
        $stmt->execute([$room_id, $guest_name, $guest_email, $checkin_date, $checkout_date]);

        // Update room status to 'booked'
        $stmt = $pdo->prepare("UPDATE rooms SET status = 'booked' WHERE room_id = ?");
        $stmt->execute([$room_id]);

        $pdo->commit();

        // Success message output (no redirect)
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <title>Booking Success</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        </head>
        <body>
        <div class='container mt-5'>
            <div class='alert alert-success'>
                ✅ Successfully booked your room! Thank you, <strong>" . htmlspecialchars($guest_name) . "</strong>.
            </div>
            <a href='rooms.php' class='btn btn-primary'>Back to Available Rooms</a>
        </div>
        </body>
        </html>";

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Booking failed: " . $e->getMessage());
    }
} else {
    die("Invalid request.");
}
?>
