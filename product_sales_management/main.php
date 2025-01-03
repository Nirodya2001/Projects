
<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Screen</title>
    <style>
	body {text-align:center; background-image: linear-gradient(white,purple); background-attachment:fixed}
	h2 {padding-top:20px}
	nav {padding:15px}
	ul {list-style-type:none}
	li {padding:15px; font-size:23px}
	li a{text-decoration:none; color:white}
	
    </style>
</head>
<body>
    <h2 >Welcome to Product Sales Management System</h2>
   <nav>
        <ul>
            <li><a href="add_product.php">Add Products</a></li>
            <li><a href="add_customer.php">Add Customer</a></li>            
            <li><a href="add_sale.php">Add Sales</a></li>            
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>
