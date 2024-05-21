<?php
// Include the file containing the database connection code
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $userIDs = $_POST['userIDs']; // Retrieve an array of user IDs
    $itemIDs = $_POST['itemIDs'];
    $quantities = $_POST['qtyItem'];

    // Get the current date
    $dateAssigned = date("Y-m-d");

    // Generate the assignedID dynamically
    $assignedID = "AS-" . sprintf("%05d", mt_rand(1, 99999));

    // Initialize an array to store errors
    $errors = [];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Prepare and execute the SQL statement to insert the data into the assigned_items table
        $sql = "INSERT INTO assigned_items (assignedID, itemID, userID, dateAssigned) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Check if the statement was prepared successfully
        if ($stmt) {
            // Iterate over itemIDs, userIDs, and retrieve quantities
            foreach ($itemIDs as $key => $itemID) {
                // Retrieve the quantity and userID for the current item
                $quantity = $quantities[$key];
                $userID = $userIDs[$key];

                // Bind parameters
                $stmt->bind_param("siss", $assignedID, $itemID, $userID, $dateAssigned);
                $stmt->execute();

                // Check if any errors occurred during the database operation
                if ($conn->errno) {
                    throw new Exception("Error inserting data: " . $conn->error);
                }

                // Update the quantity of the item in the items table
                $update_sql = "UPDATE items SET quantity = quantity - ? WHERE ID = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ii", $quantity, $itemID);
                $update_stmt->execute();

                // Check if any errors occurred during the update operation
                if ($conn->errno) {
                    throw new Exception("Error updating item quantity: " . $conn->error);
                }

                // Close the prepared statement for item update
                $update_stmt->close();
            }

            // Commit the transaction if no errors occurred
            $conn->commit();
            
            // Redirect to the dashboard page
            header("Location: ../pages/dashboard.php");
            exit(); // Make sure to exit after redirection
        } else {
            throw new Exception("Error preparing SQL statement: " . $conn->error);
        }

        // Close the prepared statement for assigned items insertion
        $stmt->close();
    } catch (Exception $e) {
        // Rollback the transaction if an error occurred
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $conn->close();
}
?>
