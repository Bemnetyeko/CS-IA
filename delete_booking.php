<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['booking_id'])) {
    $booking_id = intval($_POST['booking_id']);
    $email = $_SESSION['email'];

    // Verify the booking belongs to this user
    $check = $conn->prepare("SELECT id FROM bookings WHERE id = ? AND email = ?");
    $check->bind_param("is", $booking_id, $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ? AND email = ?");
        $stmt->bind_param("is", $booking_id, $email);

        if ($stmt->execute()) {
            $_SESSION['delete_success'] = "Booking deleted successfully!";
        } else {
            $_SESSION['delete_error'] = "Error deleting booking. Please try again.";
        }
        $stmt->close();
    } else {
        $_SESSION['delete_error'] = "Booking not found or unauthorized.";
    }

    $check->close();
}

header("Location: manage_bookings.php");
exit();
?>
