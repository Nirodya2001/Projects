<?php include 'navbar.php'; ?>

<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sales_management');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check for form submission to add a new product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $stock_level = $_POST['stock_level'];

    // Insert the new product into the database
    $sql = "INSERT INTO products (product_name, price, stock_level) VALUES ('$product_name', '$price', '$stock_level')";
    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Check if a product needs to be deleted
if (isset($_GET['delete'])) {
    $product_id = $_GET['delete'];
    
    // Delete product from the database
    $sql = "DELETE FROM products WHERE product_id = $product_id";
    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully";
    } else {
        echo "Error deleting product: " . $conn->error;
    }
}

// Retrieve list of products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Check if the query was successful
if ($result === FALSE) {
    die("Error retrieving products: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <style>
        body{text-align:center; background-image:linear-gradient(white,purple); background-attachment:fixed}
        h1{margin:30px}
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
            text-align: left;
        }
       #add_button{padding:8px}
    </style>
</head>

<body>
    <h1>Add New Product</h1>
    <form action="add_product.php" method="POST">

        <label>Product Name:</label>
        <input type="text" name="product_name" placeholder="Product Name" required><br><br>
        
        <label>Price:</label>
        <input type="text" name="price" placeholder="Price" required><br><br>
        
        <label>Stock Level:</label>
        <input type="number" name="stock_level" placeholder="Stock Level" required><br><br>

        <input  id="add_button" type="submit" value="Add Product">
    </form>

    <h2>Available Products</h2>
    <table align="center">
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Stock Level</th>
            <th>Action</th>
        </tr>
        <?php
        // Display each product in the table
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['product_id']}</td>
                        <td>{$row['product_name']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['stock_level']}</td>
                        <td><a href='add_product.php?delete={$row['product_id']}' onclick=\"return confirm('Are you sure you want to delete this product?');\" >Delete</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No products available</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
