<?php
session_start(); // Start the session
include 'includes/db_connect.php'; // Include your database connection file
include 'header.php'; // Include the navigation menu

// Add Guest functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_guest'])) {
    $guest_name = $_POST['guest_name'];
    $contact_info = $_POST['contact_info'];
    $email = $_POST['email'];

    // Insert new guest into the database
    $stmt = $conn->prepare("INSERT INTO Guests (GuestName, ContactInfo, Email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $guest_name, $contact_info, $email);
    if ($stmt->execute()) {
        $success_msg = "Guest added successfully!";
    } else {
        $error_msg = "Error adding guest: " . $stmt->error;
    }
}

// Delete Guest functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_guest'])) {
    $guest_id = $_POST['GuestID'];
    $stmt = $conn->prepare("DELETE FROM Guests WHERE GuestID = ?");
    $stmt->bind_param("i", $guest_id);
    if ($stmt->execute()) {
        $success_msg = "Guest deleted successfully!";
    } else {
        $error_msg = "Error deleting guest: " . $stmt->error;
    }
}

// Fetch existing guests
$sql = "SELECT * FROM Guests";
$result = $conn->query($sql);
?>
<body align="center" style="background-image: linear-gradient(grey,yellow); background-attachment:fixed">
<div class="container" >
    <h2>Manage Guests</h2>

    <!-- Success/Error Messages -->
    <?php if (isset($success_msg)) echo "<div class='alert alert-success'>$success_msg</div>"; ?>
    <?php if (isset($error_msg)) echo "<div class='alert alert-danger'>$error_msg</div>"; ?>

    <!-- Add Guest Form -->
    <h3>Add Guest</h3>
    <form method="POST" action="">
        <label for="guest_name">Guest Name:</label>
        <input type="text" name="guest_name" required>
        <br><br>
        <label for="contact_info">Contact Info:</label>
        <input type="text" name="contact_info" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br><br>
        <input type="submit" name="add_guest" value="Add Guest">
    </form>

    <!-- Existing Guests List -->
    <h3>Existing Guests</h3>
    <table border="1" align="center">
        <tr>
            <th>Guest ID</th>
            <th>Guest Name</th>
            <th>Contact Info</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['GuestID']; ?></td>
                <td><?php echo $row['GuestName']; ?></td>
                <td><?php echo $row['ContactInfo']; ?></td>
                <td><?php echo $row['Email']; ?></td>
                <td>
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="GuestID" value="<?php echo $row['GuestID']; ?>">
                        <input type="submit" name="delete_guest" value="Delete">
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
