<?php
include '../db_connect.php';

include_once'header.php';

try {
    $sql = "
        SELECT 
            b.booking_id, b.guest_name, b.guest_email, b.status, b.check_in, b.check_out,
            r.room_number, r.room_type
        FROM bookings b
        JOIN rooms r ON b.room_id = r.room_id
        ORDER BY b.check_in DESC
    ";
    $stmt = $pdo->query($sql);
    $bookings = $stmt->fetchAll();
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin - Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container my-4">
    <h1>All Bookings</h1>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Room</th>
                <th>Guest Name</th>
                <th>Email</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($bookings): ?>
                <?php foreach ($bookings as $row): ?>
                    <tr>
                        <td><?= (int)$row['booking_id'] ?></td>
                        <td><?= htmlspecialchars($row['room_type'] . ' - ' . $row['room_number']) ?></td>
                        <td><?= htmlspecialchars($row['guest_name']) ?></td>
                        <td><?= htmlspecialchars($row['guest_email']) ?></td>
                        <td><?= htmlspecialchars($row['check_in']) ?></td>
                        <td><?= htmlspecialchars($row['check_out']) ?></td>
                        <td>
                            <?php
                            $status = $row['status'];
                            if ($status === 'confirmed') {
                                echo '<span class="badge bg-success">Confirmed</span>';
                            } elseif ($status === 'cancelled') {
                                echo '<span class="badge bg-danger">Cancelled</span>';
                            } else {
                                echo '<span class="badge bg-secondary">' . htmlspecialchars($status) . '</span>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center">No bookings found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
