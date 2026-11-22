<?php
// Enable error reporting (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include PDO connection
include '../db_connect.php';
include_once 'header.php';

try {
    // Fetch all rooms
    $stmt = $pdo->query("SELECT * FROM rooms ORDER BY room_id ASC");
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch all facilities
    $stmt_fac = $pdo->query("
        SELECT rfm.room_id, f.facility_name
        FROM room_facility_mapping rfm
        JOIN facilities f ON rfm.facility_id = f.facility_id
    ");
    $facilities = $stmt_fac->fetchAll(PDO::FETCH_ASSOC);

    // Map facilities by room_id
    $room_facilities_map = [];
    foreach ($facilities as $fac) {
        $room_facilities_map[$fac['room_id']][] = $fac['facility_name'];
    }

} catch (Exception $e) {
    die("Error fetching rooms: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Rooms - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4">Manage Rooms</h2>

    <a href="add_room.php" class="btn btn-success mb-3">Add New Room</a>

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Room Number</th>
          <th>Room Type</th>
          <th>Price</th>
          <th>People</th>
          <th>Facilities</th>
          <th>Status</th>
          <th>Image</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($rooms): ?>
          <?php foreach ($rooms as $room): ?>
            <tr>
              <td><?= htmlspecialchars($room['room_id']) ?></td>
              <td><?= htmlspecialchars($room['room_number']) ?></td>
              <td><?= htmlspecialchars($room['room_type']) ?></td>
              <td>Rs. <?= htmlspecialchars($room['price']) ?></td>
              <td><?= htmlspecialchars($room['room_people']) ?></td>
              <td>
                <?= isset($room_facilities_map[$room['room_id']]) 
                    ? htmlspecialchars(implode(', ', $room_facilities_map[$room['room_id']])) 
                    : '-' ?>
              </td>
              <td><?= htmlspecialchars($room['status']) ?></td>
              <td>
                <?php if (!empty($room['room_image'])): ?>
                  <img src="../uploads/<?= htmlspecialchars($room['room_image']) ?>" width="100" alt="Room Image" />
                <?php endif; ?>
              </td>
              <td>
                <a href="edit_room.php?id=<?= urlencode($room['room_id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete_room.php?id=<?= urlencode($room['room_id']) ?>" 
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Are you sure you want to delete this room?');">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="9" class="text-center">No rooms found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
