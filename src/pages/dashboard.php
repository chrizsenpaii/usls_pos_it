<?php
// Include the file containing the database connection code
include '../php/db_connection.php';

// Query to retrieve users from the database
$sql_users = "SELECT ID, fullName FROM users";
$result_users = $conn->query($sql_users);
// Query to retrieve items from the database
$sql_items = "SELECT * FROM items";
$result_items = $conn->query($sql_items);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Management</title>
    <link rel="stylesheet" href="../output.css">
    <script src="https://kit.fontawesome.com/6ea446285e.js" crossorigin="anonymous"></script>
</head>
<body class="bg-darkgreen">
    <div class="h-screen grid grid-cols-5 p-4 gap-4">
        <!-- sidebar -->
        <aside class="hidden md:block col-span-1 bg-white rounded-2xl  font-semibold overflow-y-clip">
            <?php include 'sidebar.php'; ?>
        </aside>

        <!-- main -->
        <main class="col-span-5 bg-white rounded-2xl md:col-span-4 p-4">
            <h1 class="font-bold text-2xl text-darkgreen">Assign Management</h1>
            <h3 class="my-4 font-semibold text-lg">Assign items</h3>

         
                <div class="flex flex-col gap-4">
                    <!-- user select -->
                    <div class="flex flex-col gap-1">
                        <label for="selectUser" class="font-bold">Select user:</label>
                        <select name="selectUser" id="selectUser" class="px-2 py-3 border-2 w-56">
                            <?php
                            // Check if there are any users
                            if ($result_users->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result_users->fetch_assoc()) {
                                    echo "<option value='" . $row["ID"] . "'>" . $row["fullName"] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No users found</option>";
                            }
                            ?>
                        </select>
                        <input type="search" name="searchItem" id="searchItem" placeholder="Search..." class="px-2 py-3 w-56 border-2">
                    </div>
                    <!-- add button -->
                    <div class="flex flex-col px-6 items-end">
                        <button type="button" id="addItemsButton" class="px-2 py-3 bg-midgreen text-white w-32 flex gap-2 justify-center">Add
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    </div>

                    <!-- items to add -->
                    <div>
                        <table id="itemsToAddTable" class="table-fixed w-full uppercase text-left shadow-2xl rounded-2xl border-1">
                            <thead>
                                <tr class="bg-slate-300">
                                    <th class="px-2 py-3">Barcode</th>
                                    <th class="px-2 py-3">Item Name</th>
                                    <th class="px-2 py-3">Supplier</th>
                                    <th class="px-2 py-3">Quantity</th>
                                    <th class="px-2 py-3">Add</th>
                                </tr>
                            </thead>
                            <?php
                                // Check if there are any items
                                if ($result_items->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result_items->fetch_assoc()) {
                                        echo "<tr class='bg-white border-b'>";
                                        echo "<td class='px-2 py-3'>" . $row["barcode"] . "</td>";
                                        echo "<td class='px-2 py-3'>" . $row["itemName"] . "</td>";
                                        echo "<td class='px-2 py-3'>" . $row["supplier"] . "</td>";
                                        echo "<td class='px-2 py-3'>" . $row["quantity"] . "</td>";
                                        echo "<td class='px-2 py-3 flex gap-4 text-center'>";
                                        echo "<input type='checkbox' name='checkedItem' id='checkedItem' data-item-id='" . $row["ID"] . "'>"; // Add data-item-id attribute with the itemID
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr class='bg-white border-b'>";
                                    echo "<td colspan='5' class='px-2 py-3 text-center'>No items found</td>";
                                    echo "</tr>";
                                }
                                ?>

                        </table>
                    </div>
                </div>
            

            <!-- users table -->
            <h2 class="text-darkgreen font-bold text-2xl my-12">Items: </h2>
            <!-- table -->

            <form id="assignmentForm" action="../php/submit_assignment.php" method="POST">
            <input type="hidden" name="userID" id="userID" value="">
                <!-- submit item -->
                <div class="flex flex-col">
                    <!-- submit item -->
                    <div class="flex flex-col px-6 mt-7 items-end">
                        <div></div>
                        <button type="submit" class="px-2 py-3 bg-midgreen text-white w-32 flex gap-2 justify-center">Submit
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    </div>
                    <table class="table-fixed w-full uppercase text-left shadow-2xl rounded-2xl border-1 my-4">
                        <thead>
                            <tr class="bg-slate-300">
                                <th class="px-2 py-3">User</th>
                                <th class="px-2 py-3">Barcode</th>
                                <th class="px-2 py-3">Item name</th>
                                <th class="px-2 py-3">Quantity</th>
                                <th class="px-2 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody id="assignedItemsTable">
                            <!-- This will be populated dynamically -->
                        </tbody>
                    </table>
                </div>
            </form>
        </main>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("addItemsButton").addEventListener("click", function() {
        var checkboxes = document.querySelectorAll("input[name='checkedItem']:checked");
        var selectedUserID = document.getElementById("selectUser").value; // Get the selected user ID
        
        checkboxes.forEach(function(checkbox) {
            var row = checkbox.closest("tr");
            var barcode = row.querySelector("td:nth-child(1)").textContent;
            var itemName = row.querySelector("td:nth-child(2)").textContent;
            var supplier = row.querySelector("td:nth-child(3)").textContent;
            var quantity = 1;
            var itemID = checkbox.dataset.itemId; // Retrieve itemID from the checkbox

            var newRow = "<tr class='bg-white border-b'>";
            newRow += "<td class='px-2 py-3'>" + selectedUserID + "</td>"; // Insert selected user ID
            newRow += "<td class='px-2 py-3'>" + barcode + "</td>";
            newRow += "<td class='px-2 py-3'>" + itemName + "</td>";
            newRow += "<td class='px-2 py-3'><input type='number' name='qtyItem[]' class='px-2 py-3 w-20 border-2' value='" + quantity + "'></td>";
            newRow += "<td class='px-2 py-3 flex gap-4 '>";
            newRow += "<i class='fa-solid fa-trash text-2xl text-red-600 delete-icon'></i>";
            newRow += "</td>";
            newRow += "</tr>";

            // Append the new row to the assignedItemsTable
            document.getElementById("assignedItemsTable").insertAdjacentHTML("beforeend", newRow);

            // Add hidden input fields for userID and itemID for each added item
            var hiddenUserIDInput = "<input type='hidden' name='userIDs[]' value='" + selectedUserID + "'>";
            var hiddenItemIDInput = "<input type='hidden' name='itemIDs[]' value='" + itemID + "'>";
            document.getElementById("assignedItemsTable").insertAdjacentHTML("beforeend", hiddenUserIDInput);
            document.getElementById("assignedItemsTable").insertAdjacentHTML("beforeend", hiddenItemIDInput);
        });

        // Reset checkboxes after adding items
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });

        var deleteIcons = document.querySelectorAll('.delete-icon');
        deleteIcons.forEach(function(icon) {
            icon.addEventListener('click', function() {
                var row = this.closest('tr'); // Find the closest row to the clicked icon
                row.remove(); // Remove the row
            });
        });
    });

    // Add an event listener for the submit button
    document.getElementById("assignmentForm").addEventListener("submit", function(event) {
        // Prevent the default form submission behavior
        event.preventDefault();
        
        // Submit the form
        this.submit();
    });
});
</script>


   
</body>
</html>
