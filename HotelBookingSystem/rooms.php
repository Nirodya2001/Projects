<?php
session_start(); // Start the session if needed
include 'header.php'; // Include the navigation bar
?>

<?php
session_start();
include 'includes/db_connect.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (!$conn) {
    die("Database connection error: " . $conn->connect_error);
}

?>


<?php
// Insert a new room
if (isset($_POST['add_room'])) {
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $price_per_night = $_POST['price_per_night'];

    $sql = "INSERT INTO Rooms (RoomNumber, RoomType, PricePerNight) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $room_number, $room_type, $price_per_night);
    $stmt->execute();
    header("Location: rooms.php");
    exit();
}

// Delete a room
if (isset($_GET['delete'])) {
    $room_id = $_GET['delete'];
    $sql = "DELETE FROM Rooms WHERE RoomID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    header("Location: rooms.php");
    exit();
}

// Edit room details (extra code would be needed to populate the form for editing)
if (isset($_GET['edit'])) {
    $room_id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM Rooms WHERE RoomID = $room_id");
    if ($result->num_rows == 1) {
        $room = $result->fetch_assoc();
        // Populate form with room details here for editing (e.g., separate form with action=update_room)
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management - Hotel Booking System</title>
    <style>
	body {text-align:center; background-image: linear-gradient(grey,yellow); background-attachment:fixed}
	table {text-align:center}
    </style>
</head>
<body>
    <h1>Manage Rooms</h1>

    <!-- Form to add a new room -->
    <h2>Add New Room</h2>
    <form action="rooms.php" method="post">
        <label for="room_number">Room Number:</label>
        <input type="text" id="room_number" name="room_number" required><br><br>
        <label for="room_type">Room Type:</label>
        <input type="text" id="room_type" name="room_type" required><br><br>
        <label for="price_per_night">Price per Night:</label>
        <input type="number" id="price_per_night" name="price_per_night" required><br><br>
        <button type="submit" name="add_room">Add Room</button>
    </form>

    <!-- Table to display rooms -->
    <h2>Current Rooms</h2>
    <table border="1" align="center">
        <tr>
            <th>Room ID</th>
            <th>Room Number</th>
            <th>Room Type</th>
            <th>Price per Night</th>
            <th>Actions</th>
        </tr>
        <?php
        // Fetch all rooms from the database
        $result = $conn->query("SELECT * FROM Rooms");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['RoomID']}</td>
                <td>{$row['RoomNumber']}</td>
                <td>{$row['RoomType']}</td>
                <td>{$row['PricePerNight']}</td>
                <td>
                    <a href='rooms.php?delete={$row['RoomID']}'>Delete</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>
