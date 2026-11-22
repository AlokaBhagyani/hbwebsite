<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../db_connect.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        // Start transaction
        $pdo->beginTransaction();

        // 1. Delete facilities linked to this room
        $stmt = $pdo->prepare("DELETE FROM room_facility_mapping WHERE room_id = ?");
        $stmt->execute([$id]);

        // 2. Get room image before deleting
        $stmt = $pdo->prepare("SELECT room_image FROM rooms WHERE room_id = ?");
        $stmt->execute([$id]);
        $room = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($room && !empty($room['room_image'])) {
            $imagePath = "../uploads/" . $room['room_image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // 3. Delete room
        $stmt = $pdo->prepare("DELETE FROM rooms WHERE room_id = ?");
        $stmt->execute([$id]);

        // Commit transaction
        $pdo->commit();

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error deleting room: " . $e->getMessage());
    }
}

header("Location: manage_rooms.php");
exit;
?>
