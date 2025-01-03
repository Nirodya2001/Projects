<?php
include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookingID = $_POST['BookingID'];

    // Prepare and bind
    $stmt = $conn->prepare("DELETE FROM Bookings WHERE BookingID = ?");
    $stmt->bind_param("i", $bookingID);

    if ($stmt->execute()) {
        echo "Booking deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect back to bookings page
    header("Location: bookings.php");
    exit();
}
?>
