<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Management</title>
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
                <h1 class="font-bold text-2xl text-darkgreen ">Supplier  Management</h1>
                <h3 class="my-4 font-semibold text-lg">Add new supplier</h3>
                
                <form method="post" action="../php/add_supplier.php">
                    <!-- submit -->
                    <div class="flex justify-end px-2 pb-4">
                        <button type="submit" class="px-2 py-3 bg-midgreen text-white w-32 flex gap-2 justify-center">Add
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                              </svg>
                              
                        </button>
                    </div>
                   
                <!-- add user -->
                <div class="flex gap-8 ">
                    
                    <!-- Company name -->
                    <div class="flex flex-col gap-1">
                        <label for="compName" class="font-bold">Company name:</label>
                        <input type="text" class="px-2 py-3 border-2 w-64"  name="compName" id="compName" placeholder="Company name">
                    </div>
                    <!-- email -->
                    <div class="flex flex-col gap-1">
                        <label for="email" class="font-bold">Email:</label>
                        <input type="email" class="px-2 py-3 border-2 w-56"  name="email" id="email" placeholder="Email">
                    </div>
                    <!-- Location -->
                    <div class="flex flex-col gap-1">
                        <label for="location" class="font-bold">Location:</label>
                        <input type="text" class="px-2 py-3 border-2 w-56"  name="location" id="location" placeholder="Location">
                    </div>
                    <!-- Company Number -->
                    <div class="flex flex-col gap-1">
                        <label for="compNo" class="font-bold">Company number:</label>
                        <input type="text" class="px-2 py-3 border-2 w-56" id="compNo" name="compNo" placeholder="Company Number">
                    </div>
                    
                      
                </form>
                </div>
                <!-- users table -->
                <h2 class="text-darkgreen font-bold text-2xl my-12">Suppliers: </h2>
                <!-- table -->
                
                    <table class=" table-fixed w-full uppercase text-left  shadow-2xl rounded-2xl border-1 ">
                        <thead class="">
                            <tr class="bg-slate-300  ">
                              
                                <th class="px-2 py-3">Company Name</th>
                                <th class="px-2 py-3">Email</th>
                                <th class="px-2 py-3">Location</th>
                                <th class="px-2 py-3">Company Number</th>
                                <th class="px-2 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Include the database connection file
                        include '../php/db_connection.php';

                        // Fetch suppliers
                        $sql_suppliers = "SELECT * FROM supplier";
                        $result_suppliers = $conn->query($sql_suppliers);
                        if ($result_suppliers->num_rows > 0) {
                            while ($row = $result_suppliers->fetch_assoc()) {
                                echo "<tr class='bg-white border-b'>";
                                echo "<td class='px-2 py-3'>" . $row['companyName'] . "</td>";
                                echo "<td class='px-2 py-3'>" . $row['email'] . "</td>";
                                echo "<td class='px-2 py-3'>" . $row['location'] . "</td>";
                                echo "<td class='px-2 py-3'>" . $row['companyNumber'] . "</td>";
                                echo "<td class='px-2 py-3 flex gap-4'>";
                            
                                echo "<i class='fa-solid fa-trash text-2xl text-red-600 deleteSupplier' onclick='deleteSupplier(" . $row['ID'] . ")'></i>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='px-2 py-3'>No suppliers found</td></tr>";
                        }
                        ?>
                    </tbody>
                    </table>
             
                

            </main>
        
    </div>
    <script>
    // Function to handle delete supplier
    function deleteSupplier(supplierID) {
        // Confirm before deleting the supplier
        if (confirm("Are you sure you want to delete this supplier?")) {
            // Create a form to submit the supplier ID for deletion
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", "../php/delete_supplier.php");

            // Create an input field to hold the supplier ID
            var input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("name", "deleteSupplierID");
            input.setAttribute("value", supplierID);

            // Append the input field to the form
            form.appendChild(input);

            // Append the form to the document body and submit it
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

   
    
</html>