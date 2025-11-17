<?php
session_start();
require_once 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$name = $_SESSION['name'] ?? 'User';
$role = $_SESSION['role'] ?? 'user';

// Check booking ID
if (!isset($_GET['booking_id'])) {
    header("Location: manage_bookings.php");
    exit();
}

$booking_id = intval($_GET['booking_id']);

// Fetch booking data (and verify user owns it)
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ? AND email = ?");
$stmt->bind_param("is", $booking_id, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['booking_error'] = "Booking not found or unauthorized.";
    header("Location: manage_bookings.php");
    exit();
}

$booking = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Booking</title>
  <link rel="stylesheet" href="booking2.css" />
</head>
<body>
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

<div class="form-container">
  <h2>Edit Your Booking</h2>

  <form action="update_booking.php" method="POST">
    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">

    <div>
      <label>Phone:</label>
      <input type="text" name="phone" value="<?= htmlspecialchars($booking['phone']) ?>">
    </div>
    <div>
      <label>Service Type:</label>
      <select name="service_type">
        <option value="confession" <?= $booking['service_type'] == 'confession' ? 'selected' : '' ?>>Confession</option>
        <option value="baptism" <?= $booking['service_type'] == 'baptism' ? 'selected' : '' ?>>Baptism</option>
        <option value="marriage" <?= $booking['service_type'] == 'marriage' ? 'selected' : '' ?>>Marriage</option>
      </select>
    </div>
    <div>
      <label>Date:</label>
      <input type="date" name="date" value="<?= htmlspecialchars($booking['date']) ?>">
    </div>
    <div>
      <label>Number of People:</label>
      <input type="number" name="num_people" value="<?= htmlspecialchars($booking['num_people']) ?>">
    </div>
    <div>
      <label>Time:</label>
      <input type="time" name="time" value="<?= htmlspecialchars($booking['time']) ?>">
    </div>
    <div>
      <label>Language:</label>
      <div class="radio-group">
        <label><input type="radio" name="lang" value="English" <?= $booking['language'] == 'English' ? 'checked' : '' ?>> English</label>
        <label><input type="radio" name="lang" value="Amharic" <?= $booking['language'] == 'Amharic' ? 'checked' : '' ?>> Amharic</label>
        <label><input type="radio" name="lang" value="Tigrinya" <?= $booking['language'] == 'Tigrinya' ? 'checked' : '' ?>> Tigrinya</label>
      </div>
    </div>
    <div>
      <label>Special Request:</label>
      <textarea name="special_request"><?= htmlspecialchars($booking['special_request']) ?></textarea>
    </div>
    <div style="grid-column: 1 / -1; text-align:center;">
      <button type="submit" class="submit-btn">Save Changes</button>
    </div>
  </form>
</div>
</body>
</html>
