<?php
// Include the file containing the database connection code
include '../php/db_connection.php';

// Function to update item quantity
function updateItemQuantity($conn, $itemID, $receivedQuantity) {
    $sql_update_quantity = "UPDATE items SET quantity = quantity + $receivedQuantity WHERE ID = $itemID";
    $conn->query($sql_update_quantity);
}

// Function to handle "Received" button click
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["receive"])) {
    $dateReceived = $_POST["dateReceived"];
    $purchaseID = $_POST["purchaseID"];
    $itemID = $_POST["itemID"];
    $receivedQuantity = $_POST["receivedQuantity"];

    // Update status of the purchase to "Received"
    $sql_update_purchase_status = "UPDATE purchase_order SET status = 'Received' WHERE ID = $purchaseID";
    $conn->query($sql_update_purchase_status);

    // Retrieve the latest RO number from the database and increment it for the new RO
    $sql_latest_ro = "SELECT MAX(receiveNumber) AS latest_ro FROM receive_orders";
    $result_latest_ro = $conn->query($sql_latest_ro);
    $row_latest_ro = $result_latest_ro->fetch_assoc();
    $latest_ro = $row_latest_ro['latest_ro'];
    $next_ro_number = incrementRO($latest_ro);

    // Insert record into receive_orders table
    $sql_insert_receive_order = "INSERT INTO receive_orders (receiveNumber, poID, dateReceived) VALUES (?, ?, ?)";
    $stmt_receive_order = $conn->prepare($sql_insert_receive_order);

    // Bind parameters for receive_orders table
    $stmt_receive_order->bind_param("sss", $next_ro_number, $purchaseID, $dateReceived);
    
    // Execute the statement
    $stmt_receive_order->execute();

    // Close the statement
    $stmt_receive_order->close();

    // Update item quantity
    updateItemQuantity($conn, $itemID, $receivedQuantity);
}

// Retrieve purchased items data from the database
$sql_purchased_items = "SELECT po.purchaseNumber, i.supplier, i.barcode, i.itemName, po.quantity, po.ID AS purchaseID, i.ID AS itemID
                        FROM purchase_order AS po
                        INNER JOIN items AS i ON po.itemID = i.ID
                        WHERE po.status = ''";
$result_purchased_items = $conn->query($sql_purchased_items);

// Function to increment the Receive Order number
function incrementRO($latest_ro)
{
    if (empty($latest_ro)) {
        // If there's no existing data, set the next RO number to RO-00001
        $next_ro_number = 'RO-00001';
    } else {
        // Extract the numeric part of the RO number
        preg_match('/\d+$/', $latest_ro, $matches);
        $numeric_part = (int)$matches[0] + 1;

        // Construct the next RO number by combining the prefix and the incremented numeric part
        $next_ro_number = 'RO-' . str_pad($numeric_part, 5, '0', STR_PAD_LEFT);
    }
    
    return $next_ro_number;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receiving Order</title>
    <link rel="stylesheet" href="../output.css">
    <script src="https://kit.fontawesome.com/6ea446285e.js" crossorigin="anonymous"></script>
</head>
<body class="bg-darkgreen">
<div class="h-screen grid grid-cols-5 p-4 gap-4">
    <!-- sidebar -->
    <aside class="hidden md:block col-span-1 bg-white rounded-2xl font-semibold overflow-y-clip">
        <?php include 'sidebar.php'; ?>
    </aside>

    <!-- main -->
    <main class="col-span-5 bg-white rounded-2xl md:col-span-4 p-4">
        <div class="flex justify-between">
            <h1 class="font-bold text-2xl text-darkgreen ">Receiving Order</h1>
            <h1 class="font-bold text-2xl text-red-500 " id="roID">RO-000001</h1>
        </div>

        <h3 class="my-4 font-semibold text-lg">Purchased Items</h3>

        <div class="flex flex-col gap-4">
            <!-- user select -->
            <input type="search" name="searchSuppItem" id="searchSuppItem" placeholder="Search..."
                   class="px-2 py-3 w-56 border-2">
            <!-- items to add -->

            <!-- users table -->
            <h2 class="text-darkgreen font-bold text-2xl ">Items: </h2>
            <!-- table -->

            <!-- submit item -->
            <div class="flex flex-col">
                <!-- submit item -->
                <form action="" method="post">
                    <table class="table-fixed w-full uppercase text-left shadow-2xl rounded-2xl border-1 my-4">
                        <thead class="">
                        <tr class="bg-slate-300  ">
                            <th class="px-2 py-3">Purchase ID</th>
                            <th class="px-2 py-3">Supplier</th>
                            <th class="px-2 py-3">Barcode</th>
                            <th class="px-2 py-3">Item name</th>
                            <th class="px-2 py-3">Quantity</th>
                            <th class="px-2 py-3">Date Received</th>
                            <th class="px-2 py-3">Receive</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Check if there are any purchased items
                        if ($result_purchased_items->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result_purchased_items->fetch_assoc()) {
                                echo "<tr class='bg-white border-b'>";
                                echo "<td class='px-2 py-3'>" . $row["purchaseNumber"] . "</td>";
                                echo "<td class='px-2 py-3'>" . $row["supplier"] . "</td>";
                                echo "<td class='px-2 py-3'>" . $row["barcode"] . "</td>";
                                echo "<td class='px-2 py-3'>" . $row["itemName"] . "</td>";
                                echo "<td class='px-2 py-3'>" . $row["quantity"] . "</td>";
                                echo "<td class='px-2 py-3'><input type='date' name='dateReceived' class='px-2 py-3 w-32 border-2'></td>";
                                echo "<td class='px-2 py-3 flex gap-4'>
                                          <input type='hidden' name='purchaseID' value='" . $row["purchaseID"] . "'>
                                          <input type='hidden' name='itemID' value='" . $row["itemID"] . "'>
                                          <input type='hidden' name='receivedQuantity' value='" . $row["quantity"] . "'>
                                          <button type='submit' name='receive' class='px-2 py-3 bg-darkgreen w-24 text-white'>Received</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr class='bg-white border-b'><td colspan='7'>No purchased items found</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>
