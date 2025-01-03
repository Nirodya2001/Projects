<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Dummy credentials (replace with database verification later)
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == 'admin' && $password == '1234') { // Replace with actual DB validation
        $_SESSION['loggedin'] = true;
        header('Location: main.php'); // Redirect to the main screen
    } else {
        echo "Invalid username or password!";
    }
}
?>
