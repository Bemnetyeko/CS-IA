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
  <link rel="stylesheet" href="general_about.css" />
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

  <!-- ABOUT SECTION -->
  <h1 class="about-title">About Our Church</h1>
  <div class="about-container">
    <!-- Left Column -->
    <div class="about-left">
      <div class="about-item">
        <img src="Images/churchfront.jpg" alt="Church History">
        <div>
          <h3>Church History</h3>
          <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Optio nesciunt iusto laboriosam ea provident quaerat unde praesentium ipsam sapiente voluptatem, facere nihil doloremque alias incidunt cupiditate ratione recusandae culpa. Iusto reprehenderit amet, dignissimos iure eum eligendi illo quidem delectus officiis.</p>
        </div>
      </div>

      <div class="about-item">
        <img src="Images/fire.jpg" alt="Mission and Beliefs">
        <div>
          <h3>Mission & Beliefs</h3>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia veritatis molestiae dignissimos voluptatum delectus adipisci sapiente quisquam a ex quod necessitatibus odit laboriosam, voluptatibus non at possimus et veniam inventore dolores similique quaerat nam? Assumenda placeat est facere quo commodi!</p>
        </div>
      </div>

      <div class="about-item">
        <img src="Images/clergy.jpg" alt="Priest Bios">
        <div>
          <h3>Priest Biographies</h3>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque expedita mollitia quod optio eligendi consectetur earum consequatur ab dicta dolorem ut labore, fuga nihil odio aspernatur voluptatem unde molestiae quidem nulla molestias quibusdam tempora commodi! Repellendus similique in aliquam odit?</p>
        </div>
      </div>
    </div>

    <!-- Right Column -->
    <div class="about-right">
      <a href="https://www.google.com/maps/place/Saint+Gebriel..." target="_blank">
        <img src="Images/map.jpg" alt="Church Map" class="map-img">
      </a>
      <div class="contact-info">
        <p><strong>Address:</strong> KG 654 St, Kigali</p>
        <p><strong>Phone Number:</strong> +250 xxx xxx xxx</p>
        <p><strong>Opening Hours:</strong> Mon–Sun, 8:00–18:00</p>
      </div>
    </div>
  </div>
</body>
</html>
