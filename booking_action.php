<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $phone = trim($_POST['phone']);
    $service_type = $_POST['service_type'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $num_people = $_POST['num_people'];
    $language = $_POST['lang'] ?? '';
    $special_request = trim($_POST['special_request']);

    // Simple validation
    if (empty($service_type) || empty($date) || empty($time) || empty($phone)) {
        $_SESSION['booking_error'] = "Please fill in all required fields.";
        header("Location: booking.php");
        exit();
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO bookings 
        (name, email, phone, service_type, date, time, num_people, language, special_request)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssiss", 
        $name, $email, $phone, $service_type, $date, $time, $num_people, $language, $special_request);

    if ($stmt->execute()) {
        $_SESSION['booking_success'] = "Your booking has been submitted successfully!";
    } else {
        $_SESSION['booking_error'] = "Error submitting booking. Please try again.";
    }

    $stmt->close();
    header("Location: booking.php");
    exit();
}

require_once 'send_email.php';

if ($stmt->execute()) {
    sendEmail($email, "Booking Confirmation", "
        <h2>Thank you, $name!</h2>
        <p>Your booking for <strong>$service_type</strong> on <strong>$date</strong> at <strong>$time</strong> has been received.</p>
        <p>Status: Pending</p>
        <p>We’ll notify you once it’s approved or denied.</p>
    ");
    $_SESSION['booking_success'] = "Your booking has been submitted successfully!";
}
 
?>