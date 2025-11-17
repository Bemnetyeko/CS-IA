<?php
session_start();
require_once 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['name'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];

// Fetch all users
$query = "SELECT id, name, email, role FROM users ORDER BY id ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Information - Admin</title>
  <link rel="stylesheet" href="admin_users.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    <h2>User Information</h2>

    <div class="search-box">
      <input type="text" id="searchInput" placeholder="Search here...">
      <i class="fa fa-search"></i>
    </div>

    <table id="usersTable">
      <thead>
        <tr>
          <th>UserID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Bookings</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars(ucfirst($row['role'])) ?></td>
          <td><a href="admin_view_bookings.php?email=<?= urlencode($row['email']) ?>">View Bookings</a></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <script>
    // Simple client-side search
    document.getElementById("searchInput").addEventListener("keyup", function() {
      var input = this.value.toLowerCase();
      var rows = document.querySelectorAll("#usersTable tbody tr");

      rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(input) ? "" : "none";
      });
    });
  </script>
</body>
</html>
