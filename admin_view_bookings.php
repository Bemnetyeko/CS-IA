<?php
session_start();
require_once 'config.php';

// Restrict access to admins
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['name'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];

if (!isset($_GET['email'])) {
    echo "<h2>No user selected.</h2>";
    exit();
}

$user_email = $_GET['email'];

$stmt = $conn->prepare("SELECT * FROM bookings WHERE email = ? ORDER BY created_at DESC");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Bookings - <?= htmlspecialchars($user_email) ?></title>
  <link rel="stylesheet" href="admin_view_bookings.css">
</head>
<body>

<!-- HEADER -->
  <header>
    <a href="admin_dashboard.php" class="logo">
      <img src="Images/home-icon3.png" alt="Home" class="home-icon">
    </a>

    <!-- Mobile Menu -->
    <div class="mobile-menu">
      <nav class="mobile-nav">
        <div class="profile-menu">
          <img src="Images/profile-icon.png" alt="Profile" class="profile-icon">
          <div class="dropdown">
            <p><strong><?= htmlspecialchars($name) ?></strong></p>
            <p><?= htmlspecialchars($email) ?></p>
            <p><em><?= htmlspecialchars(ucfirst($role)) ?></em></p>
            <hr>
            <a href="logout.php" class="logout-link">Logout</a>
          </div>
        </div>
        <a href="admin_users.php">USER INFORMATION</a>
        <a href="admin_manage_bookings.php">MANAGE BOOKINGS</a>
      </nav>
      <button class="menu-button">☰</button>
    </div>

    <!-- Desktop Nav -->
    <nav class="desktop-nav">
      <a href="admin_users.php">USER INFORMATION</a>
      <a href="admin_manage_bookings.php">MANAGE BOOKINGS</a>
      <div class="profile-menu">
        <img src="Images/profile-icon.png" alt="Profile" class="profile-icon">
        <div class="dropdown">
          <p><strong><?= htmlspecialchars($name) ?></strong></p>
          <p><?= htmlspecialchars($email) ?></p>
          <p><em><?= htmlspecialchars(ucfirst($role)) ?></em></p>
          <hr>
          <a href="logout.php" class="logout-link">Logout</a>
        </div>
      </div>
    </nav>
  </header>

<div class="container">
  <a href="admin_users.php" class="back-btn">← Back to Users</a>
  <h2>Bookings for <?= htmlspecialchars($user_email) ?></h2>

  <?php if ($result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Service</th>
          <th>Date</th>
          <th>Time</th>
          <th>People</th>
          <th>Language</th>
          <th>Status</th>
          <th>Special Request</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars(ucfirst($row['service_type'])) ?></td>
          <td><?= htmlspecialchars($row['date']) ?></td>
          <td><?= htmlspecialchars($row['time']) ?></td>
          <td><?= htmlspecialchars($row['num_people']) ?></td>
          <td><?= htmlspecialchars($row['language']) ?></td>
          <td>
            <span class="status <?= strtolower(htmlspecialchars($row['status'])) ?>">
              <?= ucfirst($row['status']) ?>
            </span>
          </td>
          <td><?= htmlspecialchars($row['special_request']) ?: 'None' ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="no-bookings">No bookings found for this user.</p>
  <?php endif; ?>
</div>
</body>
</html>
