<?php
// Include the database connection file
include 'db_connection.php';

// Check if supplier is selected or not
if (isset($_GET['supplier'])) {
    $supplierName = $_GET['supplier'];
    $searchQuery = isset($_GET['search']) ? $_GET['search'] : ''; // Get the search query

    // Fetch items based on the selected supplier or all items if "All Suppliers" is selected
    if ($supplierName == 'all') {
        // Query to fetch items based on search query
        $sql_items = "SELECT * FROM items WHERE barcode LIKE '%$searchQuery%' OR itemName LIKE '%$searchQuery%'";
    } else {
        // Query to fetch items based on the selected supplier and search query
        $sql_items = "SELECT * FROM items WHERE supplier = '$supplierName' AND (barcode LIKE '%$searchQuery%' OR itemName LIKE '%$searchQuery%')";
    }
} else {
    // If no supplier is selected, fetch all items based on search query
    $searchQuery = isset($_GET['search']) ? $_GET['search'] : ''; // Get the search query
    $sql_items = "SELECT * FROM items WHERE barcode LIKE '%$searchQuery%' OR itemName LIKE '%$searchQuery%'";
}

$result_items = $conn->query($sql_items);

// Check if any items exist
if ($result_items) {
    if ($result_items->num_rows > 0) {
        // Loop through each item and display in table rows
        while ($row = $result_items->fetch_assoc()) {
            echo "<tr>";
            echo "<td class='px-2 py-3'>" . $row['supplier'] . "</td>";
            echo "<td class='px-2 py-3'>" . $row['barcode'] . "</td>";
            echo "<td class='px-2 py-3'>" . $row['itemName'] . "</td>";
            echo "<td class='px-2 py-3'>" . $row['quantity'] . "</td>";
            echo "<td class='px-2 py-3 flex gap-4 text-center'>";
            echo "<input type='checkbox' name='checkedItem' id='checkedItem'>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        // If no items found
        echo "<tr><td colspan='4'>No items found</td></tr>";
    }
} else {
    // If query execution failed
    echo "<tr><td colspan='4'>Error fetching items</td></tr>";
}

$conn->close(); // Close the database connection
?>
