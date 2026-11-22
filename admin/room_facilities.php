<?php
// Include your database connection
include '../admin/db_config.php';

// Query to get all rooms with their facilities
$sql = "
SELECT r.room_id, r.room_number, r.room_type, r.price, r.status, r.room_people,
       GROUP_CONCAT(f.facility_name SEPARATOR ', ') AS facilities
FROM rooms r
LEFT JOIN room_facility_mapping rm ON r.room_id = rm.room_id
LEFT JOIN facilities f ON f.facility_id = rm.facility_id
GROUP BY r.room_id
ORDER BY r.room_number ASC
";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>Room Number</th>
            <th>Room Type</th>
            <th>Price</th>
            <th>Status</th>
            <th>People</th>
            <th>Facilities</th>
          </tr>";
    
    while($row = mysqli_fetch_assoc($result)){
        echo "<tr>
                <td>".$row['room_number']."</td>
                <td>".$row['room_type']."</td>
                <td>".$row['price']."</td>
                <td>".$row['status']."</td>
                <td>".$row['room_people']."</td>
                <td>".$row['facilities']."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No rooms found.";
}

?>
