<?php include 'navbar.php'; ?>

<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sales_management');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Handle form submission to add a new sale
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['customer_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Get the product price
    $product_query = "SELECT price, stock_level FROM products WHERE product_id = $product_id";
    $product_result = $conn->query($product_query);
    $product = $product_result->fetch_assoc();
    $price = $product['price'];
    $stock_level = $product['stock_level'];

    // Check if sufficient stock is available
    if ($quantity > $stock_level) {
        echo "Error: Not enough stock available.";
    } else {
        // Calculate total price
        $total_price = $price * $quantity;

        // Insert sale into sales_orders table
        $insert_sale = "INSERT INTO sales_orders (customer_id, product_id, quantity, total_price, order_date) 
                        VALUES ($customer_id, $product_id, $quantity, $total_price, NOW())";
        if ($conn->query($insert_sale) === TRUE) {
            // Update product stock
            $new_stock_level = $stock_level - $quantity;
            $update_stock = "UPDATE products SET stock_level = $new_stock_level WHERE product_id = $product_id";
            $conn->query($update_stock);
            echo "Sale added successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Retrieve list of customers
$customers_query = "SELECT customer_id, customer_name FROM customers";
$customers_result = $conn->query($customers_query);

// Retrieve list of products
$products_query = "SELECT product_id, product_name, price FROM products";
$products_result = $conn->query($products_query);

// Retrieve sales records
$sales_query = "SELECT sales_orders.order_id, customers.customer_name, products.product_name, 
                       sales_orders.quantity, sales_orders.total_price, sales_orders.order_date 
                FROM sales_orders
                JOIN customers ON sales_orders.customer_id = customers.customer_id
                JOIN products ON sales_orders.product_id = products.product_id";
$sales_result = $conn->query($sales_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Sale</title>
     <style>
        body {text-align:center; background-image: linear-gradient(white,purple); background-attachment:fixed}
        button{padding:8px}
     </style>
</head>
<body>
    <h2>Add a New Sale</h2>
    <form method="POST" action="">
        <label for="customer_id">Customer:</label>
        <select name="customer_id" required>
            <option value="">Select a customer</option>
            <?php while ($customer = $customers_result->fetch_assoc()): ?>
                <option value="<?= $customer['customer_id'] ?>"><?= $customer['customer_name'] ?></option>
            <?php endwhile; ?>
        </select> <br><br>

        <label for="product_id">Product:</label>
        <select name="product_id" required>
            <option value="">Select a product</option>
            <?php while ($product = $products_result->fetch_assoc()): ?>
                <option value="<?= $product['product_id'] ?>"><?= $product['product_name'] ?> - $<?= $product['price'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required min="1"><br><br>

        <button type="submit">Add Sale</button>
    </form>

    <h2>Sales Records</h2>
    <table border="1" align="center">
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Order Date</th>
        </tr>
        <?php if ($sales_result->num_rows > 0): ?>
            <?php while ($sale = $sales_result->fetch_assoc()): ?>
                <tr>
                    <td><?= $sale['order_id'] ?></td>
                    <td><?= $sale['customer_name'] ?></td>
                    <td><?= $sale['product_name'] ?></td>
                    <td><?= $sale['quantity'] ?></td>
                    <td>$<?= $sale['total_price'] ?></td>
                    <td><?= $sale['order_date'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No sales records available</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
