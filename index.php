<?php 
include '../hbwebsite/db_connect.php'; 
include_once '../hbwebsite/header.php'; 

// Fetch only 3 available rooms
$sql = "SELECT * FROM rooms WHERE status = 'Available' LIMIT 3";
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

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AB Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <style>
    body { font-family: 'Trebuchet MS', sans-serif; background-color: #f8f9fa; }
    .swiper { width: 100%; height: 400px; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.3); }
    .swiper-slide img { object-fit: cover; height: 100%; width: 100%; transition: transform 0.5s; }
    .swiper-slide img:hover { transform: scale(1.05); }
    .section-title { font-weight: 700; color: #343a40; margin-bottom: 1rem; text-align: center; }
    .room-card, .facility-card { transition: transform 0.3s, box-shadow 0.3s; border-radius: 15px; overflow: hidden; }
    .room-card:hover, .facility-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
    .facility-card { padding: 2rem; text-align: center; background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
  </style>
</head>
<body>

<!-- Carousel -->
<div class="container my-5">
  <div class="swiper">
    <div class="swiper-wrapper">
      <div class="swiper-slide"><img src="../hbwebsite/images/8.jpg" alt="Welcome to AB Hotel" class="img-fluid"></div>
      <div class="swiper-slide"><img src="../hbwebsite/images/7.jpg" alt="Luxury Rooms" class="img-fluid"></div>
      <div class="swiper-slide"><img src="../hbwebsite/images/pool1.webp" alt="Relaxing Facilities" class="img-fluid"></div>
    </div>
    <div class="swiper-pagination"></div>
  </div>
</div>

<!-- Rooms Section -->
<div class="container my-5">
  <h3 class="section-title">Our Rooms</h3>
  <div class="row g-4">
    <?php if ($rooms): ?>
        <?php foreach ($rooms as $room): ?>
            <div class="col-md-4 col-sm-6">
                <div class="card room-card">
                    <?php if (!empty($room['room_image'])): ?>
                        <img src="uploads/<?= htmlspecialchars($room['room_image']); ?>" class="card-img-top room-image" alt="Room Image">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($room['room_type']) . ' - ' . htmlspecialchars($room['room_number']); ?></h5>
                        <p class="card-text">Price: Rs. <?= htmlspecialchars($room['price']); ?> per night</p>
                        <p class="card-text">People: <?= htmlspecialchars($room['room_people']); ?></p>
                        <p class="card-text">
                            Facilities: <?= isset($facilities_map[$room['room_id']]) ? htmlspecialchars(implode(', ', $facilities_map[$room['room_id']])) : '-' ?>
                        </p>
                        <a href="booking_form.php?room_id=<?= $room['room_id']; ?>" class="btn btn-primary w-100 mt-2">Book Now</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center">No available rooms at the moment.</p>
    <?php endif; ?>
  </div>
</div>

<!-- Facilities Section -->
<div class="container my-5">
  <h3 class="section-title">Our Facilities</h3>
  <div class="row g-4">
    <div class="col-md-3 col-sm-6"><div class="facility-card">Free Wi-Fi</div></div>
    <div class="col-md-3 col-sm-6"><div class="facility-card">Swimming Pool</div></div>
    <div class="col-md-3 col-sm-6"><div class="facility-card">Gym</div></div>
    <div class="col-md-3 col-sm-6"><div class="facility-card">Spa</div></div>
  </div>
</div>

<!-- Google Map -->
<div class="container my-5">
  <h3 class="section-title">Reach Us</h3>
  <div class="ratio ratio-16x9">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3348.482685148979!2d-117.20028328878018!3d32.93826347561792!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80dc07c1cd662435%3A0x70658b25d34245d!2sFairmont%20Grand%20Del%20Mar!5e0!3m2!1sen!2slk!4v1754389066486!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
</div>

<?php include_once '../hbwebsite/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
  const swiper = new Swiper('.swiper', {
    loop: true,
    pagination: { el: '.swiper-pagination', clickable: true },
    autoplay: { delay: 4000, disableOnInteraction: false },
  });
</script>
</body>
</html>
