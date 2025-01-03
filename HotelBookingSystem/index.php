

<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Hotel Booking System</title>
    <style>
	body {text-align:center; background-image: linear-gradient(grey,yellow,pink); background-attachment:fixed}
	h1 {padding:15px}
	nav {padding:10px}
	ul {list-style-type:none}
	li {padding:15px; font-size:25px}
	li a{text-decoration:none; color:blue}
	
    </style>
</head>
<body >
    <h1>Welcome to the Hotel Booking System, <?php echo $_SESSION['user']; ?>!</h1>
    <nav>
        <ul>
            <li><a href="rooms.php">Manage Rooms</a></li>
            <li><a href="bookings.php">Manage Bookings</a></li>
            <li><a href="guests.php">Manage Guests</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>
