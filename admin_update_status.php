<?php
session_start();
require_once 'config.php';

// Ensure only admin can access
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['booking_id'], $_POST['action'])) {
    $booking_id = intval($_POST['booking_id']);
    $action = $_POST['action'];

    if ($action === "approve") {
        $status = "Approved";
    } elseif ($action === "unapprove") {
        $status = "Pending";
    } else {
        $_SESSION['status_error'] = "Invalid action.";
        header("Location: admin_manage_bookings.php");
        exit();
    }

    $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $booking_id);

    if ($stmt->execute()) {
        $_SESSION['status_success'] = "Booking status updated successfully!";
    } else {
        $_SESSION['status_error'] = "Error updating status. Please try again.";
    }

    $stmt->close();
}

header("Location: admin_manage_bookings.php");
exit();
?>
