<?php
// Include the database connection file
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $categoryFor = $_POST['catFor'];
    $categoryName = $_POST['catName'];

    // SQL INSERT query
    $sql = "INSERT INTO category (categoryFor, categoryName) VALUES ('$categoryFor', '$categoryName')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "New category added successfully";
        
        // Redirect back to the HTML page after adding category
        header("Location: ../pages/category_m.php");
        exit(); // Make sure to exit after redirecting
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
