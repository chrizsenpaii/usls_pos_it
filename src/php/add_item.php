<?php
// Include the database connection file
include 'db_connection.php';

// Retrieve form data
$category = $_POST['catFor'];
$barcode = $_POST['barcode'];
$itemName = $_POST['itemName'];
$supplier = $_POST['supplierCat'];
$dateReceived = $_POST['date'];

// SQL query to insert data into items table
$sql = "INSERT INTO items (category, barcode, itemName, supplier, dateAdded) VALUES ('$category', '$barcode', '$itemName', '$supplier', '$dateReceived')";

// Execute the query
if ($conn->query($sql) === TRUE) {
    // Redirect back to the main page
    header('Location: ../pages/item_m.php');
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
