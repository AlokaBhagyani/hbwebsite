<?php
include '../admin/db_config.php';
include_once 'header.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) die("Invalid room ID.");

// Fetch room details
$stmt = $conn->prepare("SELECT * FROM rooms WHERE room_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$room = $result->fetch_assoc();
if (!$room) die("Room not found.");

// Fetch all facilities for checkboxes
$facility_result = $conn->query("SELECT * FROM facilities ORDER BY facility_name ASC");
$all_facilities = [];
while ($row = $facility_result->fetch_assoc()) $all_facilities[] = $row;

// Fetch currently selected facilities for this room
$room_facilities_result = $conn->prepare("SELECT facility_id FROM room_facility_mapping WHERE room_id=?");
$room_facilities_result->bind_param("i", $id);
$room_facilities_result->execute();
$room_facilities_res = $room_facilities_result->get_result();
$selected_facilities = [];
while ($row = $room_facilities_res->fetch_assoc()) $selected_facilities[] = $row['facility_id'];

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $room_people = $_POST['room_people'];
    $facilities = isset($_POST['room_facilities']) ? $_POST['room_facilities'] : [];
    $room_image = $room['room_image'];

    // Handle image upload
    if (isset($_FILES['room_image']) && $_FILES['room_image']['error'] == 0) {
        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $filename = uniqid() . '_' . basename($_FILES["room_image"]["name"]);
        $target_file = $upload_dir . $filename;
        if (move_uploaded_file($_FILES["room_image"]["tmp_name"], $target_file)) {
            $room_image = $filename;
        }
    }

    // Update rooms table
    $stmt = $conn->prepare("UPDATE rooms SET room_number=?, room_type=?, price=?, status=?, room_people=?, room_image=? WHERE room_id=?");
    $stmt->bind_param("ssdsssi", $room_number, $room_type, $price, $status, $room_people, $room_image, $id);
    $stmt->execute();

    // Update facilities mapping
    $conn->query("DELETE FROM room_facility_mapping WHERE room_id=$id");
    foreach ($facilities as $facility_id) {
        $stmt_fac = $conn->prepare("INSERT INTO room_facility_mapping (room_id, facility_id) VALUES (?, ?)");
        $stmt_fac->bind_param("ii", $id, $facility_id);
        $stmt_fac->execute();
        $stmt_fac->close();
    }

    header("Location: manage_rooms.php");
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Edit Room</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Room Number</label>
            <input type="text" class="form-control" name="room_number" value="<?= htmlspecialchars($room['room_number']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Room Type</label>
            <select class="form-select" name="room_type" required>
                <?php foreach(['Single','Double','Deluxe','Family'] as $type): ?>
                    <option value="<?= $type ?>" <?= $room['room_type']==$type?'selected':'' ?>><?= $type ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" class="form-control" name="price" value="<?= $room['price'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Number of People</label>
            <input type="number" class="form-control" name="room_people" value="<?= $room['room_people'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Facilities</label><br>
            <?php foreach ($all_facilities as $facility): ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="room_facilities[]" value="<?= $facility['facility_id'] ?>"
                           <?= in_array($facility['facility_id'], $selected_facilities) ? 'checked' : '' ?>>
                    <label class="form-check-label"><?= htmlspecialchars($facility['facility_name']) ?></label>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select class="form-select" name="status">
                <?php foreach(['Available','Booked','Maintenance'] as $s): ?>
                    <option value="<?= $s ?>" <?= $room['status']==$s?'selected':'' ?>><?= $s ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Room Image</label>
            <input type="file" class="form-control" name="room_image">
            <small>Current: <?= htmlspecialchars($room['room_image']) ?></small>
        </div>

        <button type="submit" class="btn btn-primary">Update Room</button>
    </form>
</div>
</body>
</html>
