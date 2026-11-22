
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="../admin/dashboard.php">AB Hotel Admin</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <!-- Room Management -->
          <li class="nav-item">
            <a class="nav-link" href="../admin/manage_rooms.php">Room Management</a>
          </li>

          <!-- Bookings Overview -->
          <li class="nav-item">
            <a class="nav-link" href="../admin/bookings.php">Bookings Overview</a>
          </li>

          <!-- Messages -->
          <li class="nav-item">
            <a class="nav-link" href="../admin/view_messages.php">Messages</a>
          </li>

          <!-- Hotel Website -->
          <li class="nav-item">
            <a class="nav-link" href="../index.php" target="_blank">Hotel Website</a>
          </li>
        </ul>

        <!-- Optional: Logout button -->
        <form class="d-flex">
          <a href="../admin/logout.php" class="btn btn-outline-light">Logout</a>
        </form>
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
