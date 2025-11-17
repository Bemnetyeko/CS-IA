<?php
session_start();
require_once 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['name'] ?? 'User';
$email = $_SESSION['email'];
$role = $_SESSION['role'] ?? 'user';

// Fetch all bookings made by the user
$stmt = $conn->prepare("SELECT * FROM bookings WHERE email = ? ORDER BY created_at DESC");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Your Bookings</title>
  <link rel="stylesheet" href="m_bookings.css"/>
</head>
<body>
  <!-- HEADER -->
  <header>
    <a href="user_dashboard.php" class="logo">
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
        <a href="user_about.php">ABOUT US</a>
        <a href="services.php">SERVICES</a>
        <a href="booking.php">BOOK A SERVICE</a>
        <a href="manage_bookings.php">MANAGE BOOKINGS</a>
        <a href="user-contact-us.php">CONTACT US</a>
      </nav>
      <button class="menu-button">☰</button>
    </div>

    <!-- Desktop Nav -->
    <nav class="desktop-nav">
      <a href="user_about.php">ABOUT US</a>
      <a href="services.php">SERVICES</a>
      <a href="manage_bookings.php">MANAGE BOOKINGS</a>
      <a href="booking.php">BOOK A SERVICE</a>
      <a href="user-contact-us.php">CONTACT US</a>
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
    <h2>Manage Your Bookings</h2>

    <?php if (isset($_SESSION['delete_success'])): ?>
      <div class="success-message"><?= $_SESSION['delete_success']; unset($_SESSION['delete_success']); ?></div>
    <?php elseif (isset($_SESSION['delete_error'])): ?>
      <div class="error-message"><?= $_SESSION['delete_error']; unset($_SESSION['delete_error']); ?></div>
    <?php elseif (isset($_SESSION['booking_success'])): ?>
      <div class="success-message"><?= $_SESSION['booking_success']; unset($_SESSION['booking_success']); ?></div>
    <?php elseif (isset($_SESSION['booking_error'])): ?>
      <div class="error-message"><?= $_SESSION['booking_error']; unset($_SESSION['booking_error']); ?></div>
    <?php endif; ?>

    <div class="bookings-list">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="booking-card">
          <h3><?= htmlspecialchars(ucfirst($row['service_type'])) ?></h3>
          <p><strong>Booking ID:</strong> <?= $row['id'] ?></p>
          <p><strong>Date:</strong> <?= htmlspecialchars($row['date']) ?></p>
          <p><strong>Time:</strong> <?= htmlspecialchars($row['time']) ?></p>
          <p><strong>Number of People:</strong> <?= htmlspecialchars($row['num_people']) ?></p>
          <p><strong>Language:</strong> <?= htmlspecialchars($row['language']) ?></p>
          <p><strong>Special Requests:</strong> <?= htmlspecialchars($row['special_request']) ?: "None" ?></p>
          <p><strong>Status:</strong> 
            <span class="status <?= htmlspecialchars($row['status']) ?>">
              <?= ucfirst($row['status']) ?>
            </span>
          </p>
          <p><em>Created at <?= htmlspecialchars($row['created_at']) ?></em></p>

          <!-- Action Buttons -->
          <div class="action-buttons">
            <a href="edit_booking.php?booking_id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
            <form action="delete_booking.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this booking?');" style="display:inline;">
              <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
              <button type="submit" class="delete-btn">Delete</button>
            </form>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <script>
    function confirmDelete(form) {
      return confirm("Are you sure you want to delete this booking?");
    }
  </script>
</body>
</html>
