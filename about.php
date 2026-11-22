<!doctype html>
<html lang="en">
<?php include_once '../hbwebsite/header.php'; ?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About Us - AB Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }

    body > .container {
      flex: 1;
    }

    .h-font {
      font-family: 'Trebuchet MS';
      font-style: italic;
    }

    .about-image {
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 10px;
    }

    .highlight {
      color: #0d6efd;
      font-weight: bold;
    }
  </style>
</head>
<body>

<!-- About Us Section -->
<div class="container my-5">
  <h2 class="text-center mb-4">About <span class="highlight">AB Hotel</span></h2>
  <div class="row align-items-center">
    <div class="col-md-6">
      <img src="../hbwebsite/images/istockphoto-1418701619-612x612.jpg" alt="About AB Hotel" class="about-image img-fluid">
    </div>
    <div class="col-md-6">
      <p>
        Welcome to <span class="highlight">AB Hotel</span>, your ideal destination for luxury, comfort, and unforgettable hospitality. 
        Nestled in the heart of Sri Lanka, AB Hotel offers a perfect blend of modern amenities and traditional charm.
      </p>
      <p>
        Whether you're here for a relaxing getaway, a family vacation, or a business trip, we provide top-notch 
        facilities including a scenic swimming pool, free Wi-Fi, a fully-equipped gym, and a rejuvenating spa experience.
      </p>
      <p>
        Our dedicated staff is here to ensure your stay is memorable and personalized. At <span class="highlight">AB Hotel</span>, 
        we don’t just offer a room — we offer an experience.
      </p>
    </div>
  </div>
</div>

</body>
<?php include_once '../hbwebsite/footer.php'; ?>
</html>
