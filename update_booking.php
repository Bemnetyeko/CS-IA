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

    $phone = trim($_POST['phone']);
    $service_type = $_POST['service_type'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $num_people = $_POST['num_people'];
    $language = $_POST['lang'] ?? '';
    $special_request = trim($_POST['special_request']);

    if (empty($service_type) || empty($date) || empty($time)) {
        $_SESSION['booking_error'] = "Please fill in all required fields.";
        header("Location: edit_booking.php?booking_id=$booking_id");
        exit();
    }
    // Updating bookings table 
    $stmt = $conn->prepare("
        UPDATE bookings
        SET phone = ?, service_type = ?, date = ?, time = ?, num_people = ?, language = ?, special_request = ?
        WHERE id = ? AND email = ?
    ");
    $stmt->bind_param("ssssissis", $phone, $service_type, $date, $time, $num_people, $language, $special_request, $booking_id, $email);

    //Success or error messages will be shown
    if ($stmt->execute()) {
        $_SESSION['booking_success'] = "Your booking was updated successfully!";
    } else {
        $_SESSION['booking_error'] = "Error updating booking. Please try again.";
    }

    $stmt->close();
}

header("Location: manage_bookings.php");
exit();
?>
