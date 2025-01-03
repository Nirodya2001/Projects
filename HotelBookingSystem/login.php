<?php
session_start();
include 'includes/db_connect.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to retrieve the user's hashed password
    $sql = "SELECT * FROM Users WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            $_SESSION['user'] = $user['Username'];
            header("Location: index.php");
            exit();
        } else {
            echo "<p>Incorrect password.</p>";
        }
    } else {
        echo "<p>User not found.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hotel Booking System</title>
    <style>
	body {text-align:center; background-image: linear-gradient(grey,yellow); background-attachment:fixed}
	h2 {padding:10px; font-size:30px}
	
    </style>
</head>
<body>
    <h2>Login</h2><br><br>
    <form action="login.php" method="post">
        <label for="username">Username:</label> &nbsp;
        <input type="text" id="username" name="username" required><br><br>
        <label for="password" >Password:</label> &nbsp;
        <input type="password" id="password" name="password" required><br><br><br>
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>
