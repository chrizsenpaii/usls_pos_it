<?php
// Include the database connection file
include 'db_connection.php';

// Check if itemId is set and not empty
if(isset($_POST['itemId']) && !empty($_POST['itemId'])) {
    // Sanitize itemId to prevent SQL injection
    $itemId = $_POST['itemId'];

    // Prepare SQL statement to delete item from the database
    $sql = "DELETE FROM items WHERE ID = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $itemId);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Item deleted successfully
        echo "Item deleted successfully.";
    } else {
        // Error occurred while deleting item
        echo "Error deleting item. Please try again.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If itemId is not set or empty, show error message
    echo "Invalid request. Please provide a valid item ID.";
}
?>
