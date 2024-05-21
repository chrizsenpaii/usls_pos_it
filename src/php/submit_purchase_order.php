<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set in the POST data
    if (isset($_POST["itemID"]) && isset($_POST["quantity"]) && isset($_POST["purchaseDate"])) {
        // Get the values from the POST data
        $itemIDs = $_POST["itemID"];
        $quantities = $_POST["quantity"];
        $purchaseDate = $_POST["purchaseDate"];

        // Replace this with your database connection code
        include 'db_connection.php';

        // Retrieve the latest PO number from the database and increment it for the new PO
        $sql_latest_po = "SELECT MAX(purchaseNumber) AS latest_po FROM purchase_order";
        $result_latest_po = $conn->query($sql_latest_po);
        $row_latest_po = $result_latest_po->fetch_assoc();
        $latest_po = $row_latest_po['latest_po'];
        $next_po_number = incrementPO($latest_po);

        // Example of inserting data into the purchase_order table
        // Insert the data into the purchase_order table
        $sql = "INSERT INTO purchase_order (purchaseNumber, itemID, quantity, date) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Loop through the arrays and bind parameters for each item
        for ($i = 0; $i < count($itemIDs); $i++) {
            // Bind parameters to the prepared statement
            $stmt->bind_param("siss", $next_po_number, $itemIDs[$i], $quantities[$i], $purchaseDate[$i]);
            // Execute the statement
            $stmt->execute();
        }

        // Close the statement
        $stmt->close();
        // Close the database connection
        $conn->close();

        // Redirect back to the form page after successful submission
        header("Location: ../pages/purchase_m.php");
        exit; // Ensure that no further code is executed after redirection
    } else {
        echo "Required fields are missing.";
    }
} else {
    // Redirect back to the form page if accessed directly
    header("Location: ../pages/purchase_m.php");
    exit;
}

// Function to increment the Purchase Order number
function incrementPO($latest_po)
{
    if (empty($latest_po)) {
        // If there's no existing data, set the next PO number to PO-00001
        $next_po_number = 'PO-00001';
    } else {
        // Extract the numeric part of the PO number
        preg_match('/\d+$/', $latest_po, $matches);
        $numeric_part = (int)$matches[0] + 1;

        // Construct the next PO number by combining the prefix and the incremented numeric part
        $next_po_number = 'PO-' . str_pad($numeric_part, 5, '0', STR_PAD_LEFT);
    }
    
    return $next_po_number;
}
?>
