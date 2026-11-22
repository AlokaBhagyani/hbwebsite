

<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

include_once '../admin/db_config.php';
include_once 'header.php';

$messages = $conn->query("SELECT * FROM messages ORDER BY submitted_at DESC");
?>

<title>Customer Messages</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <div class="container my-4">
    <h1>Customer Inquiries & Feedback</h1>

  

  <?php if ($messages->num_rows > 0): ?>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Submitted At</th>
          <th>Name</th>
          <th>Email</th>
          <th>Subject</th>
          <th>Message</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while ($row = $messages->fetch_assoc()): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= $row['submitted_at'] ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['subject']) ?></td>
          <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="text-muted">No messages found.</p>
  <?php endif; ?>
  
</body>
</html>
