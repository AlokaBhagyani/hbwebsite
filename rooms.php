<?php 
include_once '../hbwebsite/header.php'; 
include '../hbwebsite/db_connect.php'; 

// Fetch available rooms
$sql = "SELECT * FROM rooms WHERE status = 'Available'";
$stmt = $pdo->query($sql);
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch facilities for these rooms
$room_ids = array_column($rooms, 'room_id');
$facilities_map = [];

if (!empty($room_ids)) {
    $placeholders = rtrim(str_repeat('?,', count($room_ids)), ',');
    $stmt_fac = $pdo->prepare("
        SELECT rfm.room_id, f.facility_name
        FROM room_facility_mapping rfm
        JOIN facilities f ON rfm.facility_id = f.facility_id
        WHERE rfm.room_id IN ($placeholders)
    ");
    $stmt_fac->execute($room_ids);
    $facilities = $stmt_fac->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($facilities as $fac) {
        $facilities_map[$fac['room_id']][] = $fac['facility_name'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Rooms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .room-card {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .room-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .book-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            z-index: 2;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Available Rooms</h2>
    <div class="row">
        <?php if ($rooms): ?>
            <?php foreach ($rooms as $room): ?>
                <div class="col-md-4">
                    <div class="card room-card">
                        <a href="booking_form.php?room_id=<?= $room['room_id']; ?>" class="btn btn-primary book-btn">Book Now</a>
                        <?php if (!empty($room['room_image'])): ?>
                            <img src="uploads/<?= htmlspecialchars($room['room_image']); ?>" class="card-img-top room-image" alt="Room Image">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($room['room_type']) . ' - ' . htmlspecialchars($room['room_number']); ?></h5>
                            <p class="card-text">Price: Rs. <?= htmlspecialchars($room['price']); ?> per night</p>
                            <p class="card-text">People: <?= htmlspecialchars($room['room_people']); ?></p>
                            <p class="card-text">
                                Facilities: 
                                <?= isset($facilities_map[$room['room_id']]) ? htmlspecialchars(implode(', ', $facilities_map[$room['room_id']])) : '-' ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No available rooms at the moment.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
