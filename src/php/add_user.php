<?php
// Include the database connection file
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullName = $_POST['fName'];
    $schoolID = $_POST['sID'];
    $department = $_POST['department'];
    $role = $_POST['role'];
    $contactNumber = $_POST['contactNo'];

    // SQL INSERT query
    $sql = "INSERT INTO users (schoolID, fullName, department, role,contactNumber) VALUES ('$schoolID', '$fullName', '$department', '$role','$contactNumber')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "New user added successfully";
        // Redirect to the same page after insertion
        header("Location: ../pages/user_m.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
