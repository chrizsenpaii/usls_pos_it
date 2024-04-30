<?php
// Include the database connection file
include 'db_connection.php';

// Check if the deleteUserID parameter is set and not empty
if (isset($_POST['deleteSupplierID']) && !empty($_POST['deleteSupplierID'])) {
    // Escape the supplier ID for security
    $supplierID = mysqli_real_escape_string($conn, $_POST['deleteSupplierID']);

    // Delete query
    $sql = "DELETE FROM supplier WHERE ID = '$supplierID'";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the supplier management page with success message
        header("location: ../pages/supplier_m.php?message=delete_success");
        exit();
    } else {
        // Redirect to the supplier management page with error message
        header("location: ../pages/supplier_m.php?message=delete_error");
        exit();
    }
} else {
    // Redirect to the supplier management page with error message if deleteUserID parameter is not set
    header("location: ../pages/supplier_m.php?message=delete_error");
    exit();
}

// Close connection
mysqli_close($conn);
?>
