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
  <title>Book A Service</title>
  <link rel="stylesheet" href="booking2.css"/>
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

  <div class="form-container">
    <?php if (isset($_SESSION['booking_success'])): ?>
      <div class="success-message"><?= $_SESSION['booking_success']; unset($_SESSION['booking_success']); ?></div>
    <?php elseif (isset($_SESSION['booking_error'])): ?>
      <div class="error-message"><?= $_SESSION['booking_error']; unset($_SESSION['booking_error']); ?></div>
    <?php endif; ?>

    <h2>Book A Service</h2>
    <form action="booking_action.php" method="POST">
      <div>
        <label>Phone:</label>
        <input type="text" placeholder="Phone" name="phone" required>
      </div>
      <div>
        <label>Select your Service:</label>
        <select name="service_type" required>
          <option value="">--Select Service--</option>
          <option value="confession">Confession</option>
          <option value="baptism">Baptism</option>
          <option value="marriage">Marriage</option>
        </select>
      </div>
      <div>
        <label>Date:</label>
        <input type="date" name="date" required>
      </div>
      <div>
        <label>Number of people:</label>
        <input type="number" name="num_people" required>
      </div>
      <div>
        <label>Time:</label>
        <input type="time" name="time" required>
      </div>
      <div>
        <label>Language:</label>
        <div class="radio-group">
          <label><input type="radio" name="lang" value="English" required> English</label>
          <label><input type="radio" name="lang" value="Amharic"> Amharic</label>
          <label><input type="radio" name="lang" value="Tigrinya"> Tigrinya</label>
        </div>
      </div>
      <div>
        <label>Special request:</label>
        <textarea name="special_request" placeholder="Enter your special request here..."></textarea>
      </div>
      <div style="grid-column: 1 / -1; text-align:center;">
        <button type="submit" class="submit-btn">Submit Booking</button>
      </div>
    </form>
  </div>
</body>
</html>
