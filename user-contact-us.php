<?php
session_start();

// Block access if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['name'];
$email = $_SESSION['email'];
$role = $_SESSION['role'] ?? 'user';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User About Us</title>
  <link rel="stylesheet" href="contact-us.css" />
</head>
<body>
  <!-- HEADER -->
  <header>
    <!-- Logo outside navbar -->
    <a href="user_dashboard.php" class="logo">
      <img src="Images/home-icon3.png" alt="Home" class="home-icon">
    </a>

    <!-- Mobile Menu -->
    <div class="mobile-menu">
      <nav class="mobile-nav">
        <!-- Profile Dropdown -->
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
        <a href="languages.php">LANGUAGES</a>
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
      <a href="languages.php">LANGUAGES</a>
      <a href="user-contact-us.php">CONTACT US</a>

      <!-- Profile Dropdown -->
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
    <!-- CONTACT SECTION -->
<section class="contact-section">
  <h1 class="contact-title">Contact Us</h1>
  <div class="contact-container">
    <!-- Left: Map -->
    <div class="contact-map">
      <a href="https://www.google.com/maps/place/Saint+Gebriel..." target="_blank">
        <img src="Images/map.jpg" alt="Church Location" class="map-img">
      </a>
    </div>

    <!-- Right: Info -->
    <div class="contact-info">
      <p><strong>Address:</strong> KG 654 St, Kigali</p>
      <p><strong>Phone Number:</strong> +250 XXX XXX XXX</p>
      <p><strong>Opening Hours:</strong> Mon–Sun, 8:00–18:00</p>
    </div>
  </div>
</section>
</body>
</html>