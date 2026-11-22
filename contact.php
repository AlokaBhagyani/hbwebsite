<!doctype html>
<html lang="en">
<?php include_once '../hbwebsite/header.php'; ?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Us - AB Hotel</title>
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
    .contact-info {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 8px;
    }
    .contact-form {
      background-color: #ffffff;
      padding: 20px;
      border: 1px solid #dee2e6;
      border-radius: 8px;
    }
    .highlight {
      color: #0d6efd;
      font-weight: bold;
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #0d6efd;
    }
  </style>
</head>
<body>

<?php
// DB connection
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'hbwebsite'; // Change if your DB name is different

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$successMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $subject = $conn->real_escape_string($_POST['subject']);
  $message = $conn->real_escape_string($_POST['message']);

  $sql = "INSERT INTO messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

  if ($conn->query($sql) === TRUE) {
    $successMessage = "Your message has been sent successfully!";
  } else {
    $successMessage = "Error: " . $conn->error;
  }
}
?>

<!-- Contact Us Section -->
<div class="container my-5">
  <h2 class="text-center mb-4">Contact <span class="highlight">AB Hotel</span></h2>

  <?php if ($successMessage): ?>
    <div class="alert alert-success text-center"><?php echo $successMessage; ?></div>
  <?php endif; ?>

  <div class="row g-4">
    <!-- Contact Info -->
    <div class="col-md-5">
      <div class="contact-info">
        <h5>Hotel Information</h5>
        <p><strong>Address:</strong> 123 Paradise Road, Kurunegala, Sri Lanka</p>
        <p><strong>Phone:</strong> +94 77 123 4567</p>
        <p><strong>Email:</strong> info@abhotel.lk</p>
        <p><strong>Check-in:</strong> 2:00 PM | <strong>Check-out:</strong> 11:00 AM</p>
      </div>
    </div>

   <!-- Contact Form -->
    <div class="col-md-7">
      <div class="contact-form">
        <form action="#" method="post">
          <div class="mb-3">
            <label for="name" class="form-label">Your Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Your Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
      </div>
    </div>
  </div>
</div>