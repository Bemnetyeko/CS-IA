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
  <link rel="stylesheet" href="admin_dashboard.css" />
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
        <a href="booking.php">BOOK A SERVICE</a>
        <a href="manage_bookings.php">MANAGE BOOKINGS</a>
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
<div class="admin-container">
    <div class="overlay"></div>
    <div class="content">
      <h1>Welcome!</h1>
      <h2>What would you like to do?</h2>

      <div class="buttons">
        <a href="user_about.php" class="admin-btn">ABOUT US</a>
        <a href="services.php" class="admin-btn">SERVICES</a>
        <a href="booking.php" class="admin-btn">BOOK A SERVICE</a>
        <a href="manage_bookings.php" class="admin-btn">MANAGE BOOKINGS</a>
        <a href="user-contact-us.php" class="admin-btn">CONTACT US</a>
      </div>
    </div>
</body>
</html>
