<?php
// Include the database connection file
include 'db_connection.php';

// Check if the category ID is set and not empty
if (isset($_POST['categoryId']) && !empty($_POST['categoryId'])) {
    // Sanitize the category ID to prevent SQL injection
    $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);

    // SQL DELETE query
    $sql = "DELETE FROM category WHERE categoryID = '$categoryId'";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Deletion successful
        echo "Category deleted successfully";

        // Redirect back to the HTML page
        header("Location: ../pages/category_m.php");
        exit();
    } else {
        // Error in deletion
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Category ID not provided
    echo "Category ID not provided";
}

// Close the database connection
$conn->close();
?>
