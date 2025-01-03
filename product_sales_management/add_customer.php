<?php include 'navbar.php'; ?>

<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sales_management');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Add customer functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_customer'])) {
    $customer_id = $_POST['customer_id'];
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Insert new customer into the database
    $stmt = $conn->prepare("INSERT INTO customers (customer_id,customer_name,email,phone) VALUES (?, ?, ?,?)");
    $stmt->bind_param("ssss", $customer_id,$customer_name, $email,$phone);
    if ($stmt->execute()) {
        $success_msg = "Customer added successfully!";
    } else {
        $error_msg = "Error adding customer: " . $stmt->error;
    }
}

// Delete Customer functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_customer'])) {
    $guest_id = $_POST['customer_id'];
    $stmt = $conn->prepare("DELETE FROM customers WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);
    if ($stmt->execute()) {
        $success_msg = "Customer deleted successfully!";
    } else {
        $error_msg = "Error deleting customert: " . $stmt->error;
    }
}

// Fetch existing customers
$sql = "SELECT * FROM customers";
$result = $conn->query($sql);
?>
<body align="center" style="background-image: linear-gradient(white,purple); background-attachment:fixed">
<div class="container" >
    <h2>Manage Customers</h2>

    <!-- Success/Error Messages -->
    <?php if (isset($success_msg)) echo "<div class='alert alert-success'>$success_msg</div>"; ?>
    <?php if (isset($error_msg)) echo "<div class='alert alert-danger'>$error_msg</div>"; ?>

    <!-- Add Customer Form -->
    <h3>Add Customer</h3>
    <form method="POST" action="">
        <label for="Customer_id">Customer ID:</label>
        <input type="text" name="customer_id" required>
        <br><br>
        <label for="Customer_name">Customer Name:</label>
        <input type="text" name="customer_name" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="text" name="email" required>
        <br><br>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" required>
        <br><br>
        <input type="submit" name="add_customer" value="Add Customer">
    </form>

    <!-- Existing customer List -->
    <h3>Existing Customers</h3>
    <table border="1" align="center">
        <tr>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['customer_id']; ?></td>
                <td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td>
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">
                        <input type="submit" name="delete_customer" value="Delete">
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>

          <?php else: ?>
            <tr><td colspan="5">No guests found.</td></tr>
        <?php endif; ?>
    </table>
</div>
</body>
<?php
$conn->close(); // Close the database connection
?>
