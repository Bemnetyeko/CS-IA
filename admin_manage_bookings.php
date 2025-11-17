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

// Fetch all bookings
$query = "SELECT * FROM bookings ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Manage Bookings</title>
  <link rel="stylesheet" href="admin_m_booking.css" />
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
  <h2>Manage All Bookings</h2>

  <?php if (isset($_SESSION['status_success'])): ?>
    <div class="success-message"><?= $_SESSION['status_success']; unset($_SESSION['status_success']); ?></div>
  <?php elseif (isset($_SESSION['status_error'])): ?>
    <div class="error-message"><?= $_SESSION['status_error']; unset($_SESSION['status_error']); ?></div>
  <?php elseif (isset($_SESSION['delete_success'])): ?>
    <div class="success-message"><?= $_SESSION['delete_success']; unset($_SESSION['delete_success']); ?></div>
  <?php elseif (isset($_SESSION['delete_error'])): ?>
    <div class="error-message"><?= $_SESSION['delete_error']; unset($_SESSION['delete_error']); ?></div>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>User Name</th>
        <th>User Email</th>
        <th>Phone</th>
        <th>Service</th>
        <th>Date</th>
        <th>Time</th>
        <th>People</th>
        <th>Language</th>
        <th>Special Request</th>
        <th>Created At</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['name'] ?? 'N/A') ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phone'] ?? 'N/A') ?></td>
          <td><?= htmlspecialchars(ucfirst($row['service_type'])) ?></td>
          <td><?= htmlspecialchars($row['date']) ?></td>
          <td><?= htmlspecialchars($row['time']) ?></td>
          <td><?= htmlspecialchars($row['num_people']) ?></td>
          <td><?= htmlspecialchars($row['language']) ?></td>
          <td>
            <?php if (!empty($row['special_request'])): ?>
              <button class="view-request-btn" onclick="openModal('<?= htmlspecialchars(addslashes($row['special_request'])) ?>')">
                View
              </button>
            <?php else: ?>
              —
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($row['created_at']) ?></td>
          <td>
            <span class="status <?= strtolower($row['status']) ?>">
              <?= ucfirst($row['status']) ?>
            </span>
            <?php if (!empty($row['denial_reason'])): ?>
              <br><small><em>Reason: <?= htmlspecialchars($row['denial_reason']) ?></em></small>
            <?php endif; ?>
          </td>
          <td>
            <?php 
              $status = strtolower(trim($row['status'])); 
              if ($status === 'pending'): 
            ?>
              <form action="admin_update_booking.php" method="POST" style="display:inline;" onsubmit="return confirm('Approve this booking?');">
                <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                <input type="hidden" name="action" value="approve">
                <button type="submit" class="approve-btn">Approve</button>
              </form>

              <button class="deny-btn" onclick="openDenyPrompt(<?= $row['id'] ?>)">Deny</button>

            <?php elseif ($status === 'approved'): ?>
              <form action="admin_update_booking.php" method="POST" style="display:inline;" onsubmit="return confirm('Unapprove this booking?');">
                <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                <input type="hidden" name="action" value="unapprove">
                <button type="submit" class="unapprove-btn">Unapprove</button>
              </form>

            <?php elseif ($status === 'denied'): ?>
              <span class="denied-text">Denied</span>

            <?php endif; ?>

            <form action="admin_delete_booking.php" method="POST" style="display:inline;" onsubmit="return confirm('Delete this booking?');">
              <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
              <button type="submit" class="delete-btn">Delete</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- Modal for Viewing Special Requests -->
<div id="requestModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h3>Special Request</h3>
    <p id="requestText"></p>
  </div>
</div>

<script>
function openModal(requestText) {
  document.getElementById('requestText').innerText = requestText;
  document.getElementById('requestModal').style.display = 'flex';
}

function closeModal() {
  document.getElementById('requestModal').style.display = 'none';
}

window.onclick = function(event) {
  const modal = document.getElementById('requestModal');
  if (event.target === modal) {
    modal.style.display = "none";
  }
};

function openDenyPrompt(bookingId) {
  const reason = prompt("Please enter the reason for denying this booking:");
  if (reason !== null && reason.trim() !== "") {
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "admin_update_booking.php";

    const idInput = document.createElement("input");
    idInput.type = "hidden";
    idInput.name = "booking_id";
    idInput.value = bookingId;

    const actionInput = document.createElement("input");
    actionInput.type = "hidden";
    actionInput.name = "action";
    actionInput.value = "deny";

    const reasonInput = document.createElement("input");
    reasonInput.type = "hidden";
    reasonInput.name = "denial_reason";
    reasonInput.value = reason;

    form.appendChild(idInput);
    form.appendChild(actionInput);
    form.appendChild(reasonInput);
    document.body.appendChild(form);
    form.submit();
  } else {
    alert("Denial canceled — reason is required.");
  }
}
</script>
</body>
</html>
