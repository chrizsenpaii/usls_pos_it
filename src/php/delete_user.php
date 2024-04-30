<?php
// Include the database connection file
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteUserID'])) {
    // Retrieve user ID
    $userID = $_POST['deleteUserID'];

    // SQL DELETE query
    $sql = "DELETE FROM users WHERE ID = $userID";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the user management page after deletion
        header("Location: ../pages/user_m.php");
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}
?>
