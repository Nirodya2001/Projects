<?php
session_start(); // Start the session if needed
include 'header.php'; // Include the navigation bar
?>

<?php
session_start();
include 'includes/db_connect.php'; // Include the Database Connection

// Redirect to login if user is not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Fetch existing bookings
$sql = "SELECT b.BookingID, g.GuestName AS GuestName, r.RoomNumber, b.CheckInDate, b.CheckOutDate
        FROM Bookings b
        JOIN Guests g ON b.GuestID = g.GuestID
        JOIN Rooms r ON b.RoomID = r.RoomID";
$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Management</title>
</head>
<body align="center" style="background-image: linear-gradient(grey,yellow); background-attachment:fixed">
    <h2>Booking Management</h2>

    <!-- Add New Booking Form -->
    <h3>Add New Booking</h3>
    <form action="add_booking.php" method="post">
        <label>Guest ID:</label>
        <input type="number" name="GuestID" required><br><br>
        
        <label>Room ID:</label>
        <input type="number" name="RoomID" required><br><br>

        <label>Check-In Date:</label>
        <input type="date" name="CheckInDate" required><br><br>
        
        <label>Check-Out Date:</label>
        <input type="date" name="CheckOutDate" required><br><br>

        <input type="submit" value="Add Booking">
    </form>

    <!-- Booking List -->
<h3>Existing Bookings</h3>
<table border="1" align="center">
    <tr>
        <th>Booking ID</th>
        <th>Guest Name</th>
        <th>Room Number</th>
        <th>Check-In Date</th>
        <th>Check-Out Date</th>
        <th>Actions</th>
    </tr>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['BookingID']; ?></td>
            <td><?php echo $row['GuestName']; ?></td>
            <td><?php echo $row['RoomNumber']; ?></td>
            <td><?php echo $row['CheckInDate']; ?></td>
            <td><?php echo $row['CheckOutDate']; ?></td>
            <td>
                <form action="delete_booking.php" method="post" style="display:inline;">
                    <input type="hidden" name="BookingID" value="<?php echo $row['BookingID']; ?>">
                    <input type="submit" value="Delete">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="6">No bookings found.</td></tr>
    <?php endif; ?>
</table>


   
</body>
</html>
