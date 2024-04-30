<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
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
                <h1 class="font-bold text-2xl text-darkgreen ">Category  Management</h1>
                <h3 class="my-4 font-semibold text-lg">Add new Category</h3>
                
                <form method="post" action="../php/add_category.php">
                    <!-- submit -->
                    
                   
                <!-- add user -->
                <div class="flex gap-8 ">
                    <!-- category type -->
                    <div class="flex flex-col gap-1">
                        <label for="catFor" class="font-bold">Category for:</label>
                        <select name="catFor" id="catFor" class="px-2 py-3 border-2 w-56">
                            <option value="roles">Roles</option>
                            <option value="items">Items</option>
                            <option value="department">Department</option>

                        </select>
                    </div>
                    <!-- Company name -->
                    <div class="flex flex-col gap-1">
                        <label for="catName" class="font-bold">Category name:</label>
                        <input type="text" class="px-2 py-3 border-2 w-64" name="catName" id="catName" placeholder="Category name">
                    </div>
                    <!-- submit category -->
                    <div class=" flex flex-col px-2 mt-7 ">
                        <div></div>
                        <button type="submit" class="px-2 py-3 bg-midgreen text-white w-32 flex gap-2 justify-center">Add
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                              </svg>
                              
                        </button>
                    </div>
                    
                      
                </form>
                </div>
                <!-- users table -->
                <h2 class="text-darkgreen font-bold text-2xl my-12">Categories: </h2>
                <!-- table -->
                
                    <table class=" table-fixed w-full uppercase text-left  shadow-2xl rounded-2xl border-1 ">
                        <thead class="">
                            <tr class="bg-slate-300  ">
                              
                                <th class="px-2 py-3">Category For</th>
                                <th class="px-2 py-3">Category name</th>
                            
                                <th class="px-2 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    // Include the database connection file
                    include '../php/db_connection.php';

                    // Fetch categories from the database
                    $sql = "SELECT * FROM category";
                    $result = $conn->query($sql);

                    // Check if any category exists
                    if ($result->num_rows > 0) {
                        // Loop through each category and display in table rows
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='px-2 py-3'>" . $row['categoryFor'] . "</td>";
                            echo "<td class='px-2 py-3'>" . $row['categoryName'] . "</td>";
                            echo "<td class='px-2 py-3 flex gap-4'>";
                            echo "<i class='fa-solid fa-trash text-2xl text-red-600 hover:cursor-pointer ' id='deleteCat' onclick='deleteCategory(" . $row['categoryID'] . ")'></i>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // If no category found
                        echo "<tr><td colspan='3'>No categories found</td></tr>";
                    }
                    ?>
                </tbody>
                    </table>
             
                

            </main>
        
    </div>
    <script>
        // Function to handle deletion of category
        function deleteCategory(categoryId) {
            // Prompt user for confirmation
            if (confirm("Are you sure you want to delete this category?")) {
                // Send asynchronous request to delete category
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../php/delete_category.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Refresh page after successful deletion
                        location.reload();
                    }
                };
                xhr.send("categoryId=" + categoryId);
            }
        }
    </script>
    
   
    
</html>