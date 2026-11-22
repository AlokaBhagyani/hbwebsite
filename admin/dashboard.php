<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}
?>
<?php include_once 'header.php'; ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Dashboard - AB Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }

        .dashboard-header {
            background-color: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .card {
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            transform: scale(1.03);
        }
    </style>
</head>

<body>

    <div class="dashboard-header">
        <h2>Welcome, Admin</h2>
    </div>

    <div class="container mt-4">
        <div class="row g-4">

            <div class="col-md-6 col-lg-4">
                <div class="card text-white bg-primary p-3">
                    <div class="card-body">
                        <h5 class="card-title">Room Management</h5>
                        <p class="card-text">Add, update, or remove hotel rooms.</p>
                        <a href="manage_rooms.php" class="btn btn-light">Manage Rooms</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card text-white bg-success p-3">
                    <div class="card-body">
                        <h5 class="card-title">Bookings Overview</h5>
                        <p class="card-text">View and manage guest bookings.</p>
                        <a href="bookings.php" class="btn btn-light">View Bookings</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card text-white bg-warning p-3">
                    <div class="card-body">
                        <h5 class="card-title">Messages</h5>
                        <p class="card-text">Check customer inquiries and feedback.</p>
                        <a href="view_messages.php" class="btn btn-light">View Messages</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card text-white bg-info p-3">
                    <div class="card-body">
                        <h5 class="card-title">Hotel Website</h5>
                        <p class="card-text">Go to the public-facing hotel website.</p>
                        <a href="../index.php" class="btn btn-light">Visit Site</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
