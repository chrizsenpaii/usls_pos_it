<?php
// Include the database connection file
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $companyName = mysqli_real_escape_string($conn, $_POST['compName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $companyNumber = mysqli_real_escape_string($conn, $_POST['compNo']);

    // Insert query
    $sql = "INSERT INTO supplier (companyName, email, location, companyNumber) VALUES ('$companyName', '$email', '$location', '$companyNumber')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the supplier management page with success message
        header("location: ../pages/supplier_m.php?message=success");
        exit();
    } else {
        // Redirect to the supplier management page with error message
        header("location: ../pages/supplier_m.php?message=error");
        exit();
    }
}

// Close connection
mysqli_close($conn);
?>
