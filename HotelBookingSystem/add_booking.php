<?php
session_start();
include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $guestID = $_POST['GuestID'];
    $roomID = $_POST['RoomID'];
    $checkInDate = $_POST['CheckInDate'];
    $checkOutDate = $_POST['CheckOutDate'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO Bookings (GuestID, RoomID, CheckInDate, CheckOutDate) VALUES (?, ?, ?, ?)");   // Insert new Booking
    $stmt->bind_param("iiss", $guestID, $roomID, $checkInDate, $checkOutDate);

    if ($stmt->execute()) {
        echo "Booking added successfully.";
        header("Location: bookings.php");
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
