<?php
session_start();
require_once 'config.php';

// Ensure only admin can access
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['booking_id'])) {
    $booking_id = intval($_POST['booking_id']);

    // Delete booking record securely using a prepared statement
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {
        $_SESSION['delete_success'] = "Booking deleted successfully!";
    } else {
        $_SESSION['delete_error'] = "Error deleting booking. Please try again.";
    }

    $stmt->close();
}


header("Location: admin_manage_bookings.php");
exit();
?>
