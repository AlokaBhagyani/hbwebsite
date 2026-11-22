<?php
include_once 'header.php';
include '../admin/db_config.php';

$message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_number = $_POST['room_number'];
    $room_type   = $_POST['room_type'];
    $price       = $_POST['price'];
    $status      = $_POST['status'];
    $room_people = $_POST['room_people'];
    $facilities  = isset($_POST['room_facilities']) ? $_POST['room_facilities'] : [];

    // Handle image upload
    $room_image = '';
    if (isset($_FILES['room_image']) && $_FILES['room_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $filename = uniqid() . '_' . basename($_FILES["room_image"]["name"]);
        $target_file = $upload_dir . $filename;

        if (move_uploaded_file($_FILES["room_image"]["tmp_name"], $target_file)) {
            $room_image = $filename;
        }
    }

    // Insert room
    $stmt = $conn->prepare("
        INSERT INTO rooms (room_number, room_type, price, status, room_people, room_image) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssdiss", $room_number, $room_type, $price, $status, $room_people, $room_image);

    if ($stmt->execute()) {
        $room_id = $stmt->insert_id;

        // Insert room facilities
        if (!empty($facilities)) {
            foreach ($facilities as $facility_id) {
                $stmt_fac = $conn->prepare("INSERT INTO room_facility_mapping (room_id, facility_id) VALUES (?, ?)");
                $stmt_fac->bind_param("ii", $room_id, $facility_id);
                $stmt_fac->execute();
                $stmt_fac->close();
            }
        }

        $message = "✅ Room added successfully!";
    } else {
        $message = "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch facilities
$facility_result = $conn->query("SELECT * FROM facilities ORDER BY facility_name ASC");
$all_facilities = [];
if ($facility_result->num_rows > 0) {
    while ($row = $facility_result->fetch_assoc()) {
        $all_facilities[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Room</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Add New Room</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Room Number</label>
            <input type="text" class="form-control" name="room_number" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Room Type</label>
            <select class="form-select" name="room_type" required>
                <option value="">Select Type</option>
                <option value="Single">Single</option>
                <option value="Double">Double</option>
                <option value="Deluxe">Deluxe</option>
                <option value="Family">Family</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Price (LKR)</label>
            <input type="number" step="0.01" class="form-control" name="price" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Number of People</label>
            <input type="number" class="form-control" name="room_people" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Facilities</label><br>
            <?php foreach ($all_facilities as $facility): ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="room_facilities[]" value="<?= $facility['facility_id'] ?>">
                    <label class="form-check-label"><?= htmlspecialchars($facility['facility_name']) ?></label>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="status" required>
                <option value="Available">Available</option>
                <option value="Booked">Booked</option>
                <option value="Maintenance">Maintenance</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Room Image</label>
            <input type="file" class="form-control" name="room_image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Add Room</button>
    </form>
</div>
</body>
</html>
