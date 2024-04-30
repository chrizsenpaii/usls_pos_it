<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order</title>
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
                <h1 class="font-bold text-2xl text-darkgreen">Purchase Order</h1>
                <h1 class="font-bold text-2xl text-red-500" id="poID">PO-000001</h1>
            </div>
            
            <h3 class="my-4 font-semibold text-lg">Suppliers Items</h3>
            
            <div class="flex flex-col gap-4">
                <!-- supplier select -->
                <div class="flex flex-col gap-1">
                    <label for="selectSupp" class="font-bold">Select supplier:</label>
                    <select name="selectSupp" id="selectSupp" class="px-2 py-3 border-2 w-56">
                        <!-- Add a default option to select all items -->
                        <option value="all"></option>
                        <?php
                        // Include the database connection file
                        include '../php/db_connection.php';

                        // Fetch suppliers from the database
                        $sql_suppliers = "SELECT companyName FROM supplier";
                        $result_suppliers = $conn->query($sql_suppliers);
                        if ($result_suppliers->num_rows > 0) {
                            while ($row = $result_suppliers->fetch_assoc()) {
                                echo "<option value='" . $row['companyName'] . "'>" . $row['companyName'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <input type="search" name="searchSuppItem" id="searchSuppItem" placeholder="Search..." class="flex px-2 py-3 w-56 border-2">
                
                <h2 class="text-darkgreen font-bold text-2xl my-4">Add to items: </h2>
                
                <!-- add button -->
                <div class="flex flex-col px-6 items-end">
                    <button type="button" id="addItemsButton" class="px-2 py-3 bg-midgreen text-white w-32 flex gap-2 justify-center">Add
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>
                
                <!-- items to add -->
                <div class="">
                    <table class="table-fixed w-full uppercase text-left shadow-2xl rounded-2xl border-1">
                        <thead class="">
                            <tr class="bg-slate-300">
                                <th class="px-2 py-3">Supplier</th>
                                <th class="px-2 py-3">Barcode</th>
                                <th class="px-2 py-3">Item Name</th>
                                <th class="px-2 py-3">Quantity</th>
                                <th class="px-2 py-3">Add</th>
                            </tr>
                        </thead>
                        <tbody id="itemsTableBody"></tbody>
                    </table>
                </div>
            </div>
            
            <!-- Items table -->
            <h2 class="text-darkgreen font-bold text-2xl my-12">Items: </h2>
            <form action="">
                <!-- submit item -->
                <div class="flex flex-col">
                    <!-- submit item -->
                    <div class="flex flex-col px-6 mt-7 items-end">
                        <button type="submit" class="px-2 py-3 bg-midgreen text-white w-32 flex gap-2 justify-center">Submit
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    </div>
                    <table class="table-fixed w-full uppercase text-left shadow-2xl rounded-2xl border-1 my-4">
                        <thead class="">
                            <tr class="bg-slate-300">
                                <th class="px-2 py-3">Supplier</th>
                                <th class="px-2 py-3">Barcode</th>
                                <th class="px-2 py-3">Item name</th>
                                <th class="px-2 py-3">Quantity</th>
                                <th class="px-2 py-3">Purchase Date</th>
                            </tr>
                        </thead>
                        <tbody id="selectedItemsTableBody"></tbody>
                    </table>
                </div>
            </form>
        </main>
    </div>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Add event listener to the "Add" button
        document.getElementById('addItemsButton').addEventListener('click', function() {
            // Get all checked checkboxes in the supplier items table
            var checkedItems = document.querySelectorAll('#itemsTableBody input[type="checkbox"]:checked');
            
            // Append checked items to the items table below
            var itemsTableBody = document.getElementById('selectedItemsTableBody');
            checkedItems.forEach(function(item) {
                var row = item.closest('tr');
                var newRow = document.createElement('tr');
                newRow.innerHTML = row.innerHTML;
                
                // Add input fields for quantity and purchase date
                newRow.querySelector('td:nth-child(4)').innerHTML = '<input type="number" class="px-2 py-1 w-20 border-2" name="qtyItem" value="1">';
                newRow.querySelector('td:nth-child(5)').innerHTML = '<input type="date" class="px-2 py-3 border-2 w-64" id="date" name="date">';
                
                // Remove the last cell (Action)
                newRow.removeChild(newRow.lastElementChild);
                
                itemsTableBody.appendChild(newRow);
            });
        });

        // Function to fetch items based on supplier and search query
        function fetchItems(supplierName, searchQuery = '') {
            var xhr = new XMLHttpRequest();
            var url = '../php/get_supplier_items.php?supplier=' + encodeURIComponent(supplierName);
            
            // Append search query to the URL if it's provided and not empty
            if (searchQuery) {
                url += '&search=' + encodeURIComponent(searchQuery);
            }

            xhr.open('GET', url, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Update the table with received data
                    document.getElementById('itemsTableBody').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        // Function to handle search input
        document.getElementById('searchSuppItem').addEventListener('input', function() {
            var supplierName = document.getElementById('selectSupp').value; // Get the selected supplier name
            var searchQuery = this.value.trim(); // Get the search query
            
            // Fetch items based on supplier and search query
            fetchItems(supplierName, searchQuery);
        });

        // Function to fetch all items when the page loads
        window.onload = function() {
            var supplierName = document.getElementById('selectSupp').value; // Get the selected supplier name
            
            // Fetch all items initially
            fetchItems(supplierName);
        };

        // Add event listener to the selectSupp dropdown
        document.getElementById('selectSupp').addEventListener('change', function() {
            var supplierName = this.value; // Get the selected supplier name
            var searchQuery = document.getElementById('searchSuppItem').value.trim(); // Get the search query
            
            // Fetch items based on supplier and search query
            fetchItems(supplierName, searchQuery);
        });
    });
    </script>
</body>
</html>
