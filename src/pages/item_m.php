<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items Management</title>
    <link rel="stylesheet" href="../output.css">
    <script src="https://kit.fontawesome.com/6ea446285e.js" crossorigin="anonymous"></script>
</head>
<body class="bg-darkgreen">
    <div class=" h-screen grid grid-cols-5 p-4 gap-4">
            <!-- sidebar -->
            <aside class=" hidden md:block col-span-1 bg-white rounded-2xl  font-semibold overflow-y-clip ">
            <?php include 'sidebar.php'; ?>

                
            </aside>


            <!-- main -->
            <main class="col-span-5 bg-white rounded-2xl md:col-span-4 p-4">
                <h1 class="font-bold text-2xl text-darkgreen ">Items  Management</h1>
                <h3 class="my-4 font-semibold text-lg">Add new Items</h3>
                
                <form action="../php/add_item.php" method="POST">

                   
                     <!-- submit item -->
                     <div class=" flex flex-col px-6 mt-7 items-end ">
                        <div></div>
                        <button type="submit" class="px-2 py-3 bg-midgreen text-white w-32 flex gap-2 justify-center">Add
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                              </svg>
                              
                        </button>
                    </div>
                   
            
                <div class="flex gap-4 pb-2 ">
                    <!-- category type -->
                    <div class="flex flex-col gap-1">
                        <label for="catFor" class="font-bold">Category:</label>
                        <select name="catFor" id="catFor" class="px-2 py-3 border-2 w-56">
                            <?php
                            // Include the database connection file
                            include '../php/db_connection.php';

                            // Fetch categories with catFor = 'items'
                            $sql_categories = "SELECT categoryName FROM category WHERE categoryFor = 'items'";
                            $result_categories = $conn->query($sql_categories);
                            if ($result_categories->num_rows > 0) {
                                while ($row = $result_categories->fetch_assoc()) {
                                    echo "<option value='" . $row['categoryName'] . "'>" . $row['categoryName'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <!-- barcode  -->
                    <div class="flex flex-col gap-1">
                        <label for="barcode" class="font-bold">Barcode:</label>
                        <input type="text" class="px-2 py-3 border-2 w-64" id="barcode" name="barcode" placeholder="Barcode">
                    </div>
                    <!-- Item name -->
                    <div class="flex flex-col gap-1">
                        <label for="itemName" class="font-bold">Item name:</label>
                        <input type="text" class="px-2 py-3 border-2 w-64" id="itemName" name="itemName" placeholder="Item name">
                    </div>
                     <!-- supplier -->
                     <div class="flex flex-col gap-1">
                        <label for="supplierCat" class="font-bold">Supplier:</label>
                        <select name="supplierCat" id="supplierCat" class="px-2 py-3 border-2 w-56">
                            <?php
                            // Fetch suppliers
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
                        </div>
                    <!-- date  -->
                        <div class="flex flex-col gap-1 py-2">
                            <label for="date" class="font-bold">Date Received:</label>
                            <input type="date" class="px-2 py-3 border-2 w-64" id="date" name="date" required>
                        </div>

                    
                </form>
                
                <!-- users table -->
                <h2 class="text-darkgreen font-bold text-2xl my-12">Items: </h2>
                <!-- table -->
                
                    <table class=" table-fixed w-full uppercase text-left  shadow-2xl rounded-2xl border-1 ">
                        <thead class="">
                            <tr class="bg-slate-300  ">
                              
                                <th class="px-2 py-3">Category</th>
                                <th class="px-2 py-3">Barcode</th>
                                <th class="px-2 py-3">Item name</th>
                                <th class="px-2 py-3">Supplier</th>
                                <th class="px-2 py-3">Date Added</th>
                                <th class="px-2 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    // Include the database connection file
                    include '../php/db_connection.php';

                    // Fetch items from the database
                    $sql_items = "SELECT * FROM items";
                    $result_items = $conn->query($sql_items);

                    if ($result_items->num_rows > 0) {
                        while ($row = $result_items->fetch_assoc()) {
                            echo "<tr class='bg-white border-b'>";
                            echo "<td class='px-2 py-3'>" . $row['category'] . "</td>";
                            echo "<td class='px-2 py-3'>" . $row['barcode'] . "</td>";
                            echo "<td class='px-2 py-3'>" . $row['itemName'] . "</td>";
                            echo "<td class='px-2 py-3'>" . $row['supplier'] . "</td>";
                            echo "<td class='px-2 py-3'>" . $row['dateAdded'] . "</td>";
                            echo "<td class='px-2 py-3 flex gap-4'>";
                            echo "<i class='fa-solid fa-trash text-2xl text-red-600 delete-icon' data-item-id='" . $row['ID'] . "'></i>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No items found</td></tr>";
                    }
                    ?>
                </tbody>
                    </table>
             
                

            </main>
            <script>
        // Add event listener to delete icons
        document.addEventListener('DOMContentLoaded', function() {
            const deleteIcons = document.querySelectorAll('.delete-icon');
            deleteIcons.forEach(icon => {
                icon.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');
                    if (confirm('Are you sure you want to delete this item?')) {
                        // Send AJAX request to delete_item.php with itemId
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '../php/delete_item.php', true);
                        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                // Reload the page after successful deletion
                                location.reload();
                            } else {
                                alert('Error deleting item. Please try again.');
                            }
                        };
                        xhr.onerror = function() {
                            alert('Error deleting item. Please try again.');
                        };
                        xhr.send('itemId=' + itemId);
                    }
                });
            });
        });
    </script>
    </div>
    
   
    
</html>