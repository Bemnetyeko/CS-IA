<?php
session_start();
require_once 'config.php';
require_once 'send_email.php'; // include PHPMailer email function

// Ensure only admin can access
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['booking_id'], $_POST['action'])) {
    $booking_id = intval($_POST['booking_id']);
    $action = $_POST['action'];
    $denial_reason = $_POST['denial_reason'] ?? null;

    // Step 1: Fetch booking information first (to get user email, etc.)
    $stmt = $conn->prepare("SELECT name, email, service_type, date, time FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
    $stmt->close();

    if (!$booking) {
        $_SESSION['update_error'] = "Booking not found.";
        header("Location: admin_manage_bookings.php");
        exit();
    }

    $user_name = $booking['name'];
    $user_email = $booking['email'];
    $service_type = ucfirst($booking['service_type']);
    $date = $booking['date'];
    $time = $booking['time'];

    // Step 2: Handle actions
    if ($action === 'approve') {
        $new_status = 'Approved';
        $query = "UPDATE bookings SET status = ?, denial_reason = NULL WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $new_status, $booking_id);

        $email_subject = "Your booking has been approved";
        $email_body = "
            <p>Dear {$user_name},</p>
            <p>Your booking for <strong>{$service_type}</strong> on <strong>{$date}</strong> at <strong>{$time}</strong> has been <strong>approved</strong>.</p>
            <p>We look forward to seeing you!</p>
            <p>– Church Admin Team</p>
        ";

    } elseif ($action === 'unapprove') {
        $new_status = 'Pending';
        $query = "UPDATE bookings SET status = ?, denial_reason = NULL WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $new_status, $booking_id);

        $email_subject = "Your booking status changed to pending";
        $email_body = "
            <p>Dear {$user_name},</p>
            <p>Your booking for <strong>{$service_type}</strong> on <strong>{$date}</strong> at <strong>{$time}</strong> has been changed back to <strong>Pending</strong>.</p>
            <p>We’ll notify you once it’s reviewed again.</p>
            <p>– Church Admin Team</p>
        ";

    } elseif ($action === 'deny') {
        $new_status = 'Denied';
        $query = "UPDATE bookings SET status = ?, denial_reason = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $new_status, $denial_reason, $booking_id);

        $email_subject = "Your booking has been denied";
        $email_body = "
            <p>Dear {$user_name},</p>
            <p>Unfortunately, your booking for <strong>{$service_type}</strong> on <strong>{$date}</strong> at <strong>{$time}</strong> has been <strong>denied</strong>.</p>
            <p><strong>Reason:</strong> {$denial_reason}</p>
            <p>You may contact the church office for more details.</p>
            <p>– Church Admin Team</p>
        ";

    } else {
        $_SESSION['update_error'] = "Invalid action.";
        header("Location: admin_manage_bookings.php");
        exit();
    }

    // Step 3: Execute update and send email
    if ($stmt->execute()) {
        sendEmail($user_email, $email_subject, $email_body);
        $_SESSION['update_success'] = "Booking updated and user notified successfully!";
    } else {
        $_SESSION['update_error'] = "Error updating booking status.";
    }

    $stmt->close();
}

header("Location: admin_manage_bookings.php");
exit();
?>
