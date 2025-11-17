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
  <link rel="stylesheet" href="services2.css" />
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
<div class="services-wrapper">
  <h1 class="services-title">Services</h1>

  <div class="services-container">
    <!-- Service 1 -->
    <div class="service-card">
      <img src="Images/fire.jpg" alt="Confession">
      <h3>Confession</h3>
      <p>
        Our priests are available for confession sessions to guide 
        and strengthen your faith journey.
      </p>
    </div>

    <!-- Service 2 -->
    <div class="service-card">
      <img src="Images/liturgypic.jpg" alt="Baptism">
      <h3>Baptism</h3>
      <p>
        We offer baptism services as a sacred step into the life 
        of the Orthodox faith.
      </p>
    </div>

    <!-- Service 3 -->
    <div class="service-card">
      <img src="Images/marriage.jpg" alt="Marriage">
      <h3>Marriage</h3>
      <p>
        Celebrate your union with a holy sacrament of marriage 
        conducted at our church.
      </p>
    </div>
  </div>
</div>
</body>
</html>
