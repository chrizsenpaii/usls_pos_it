<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
                <h1 class="font-bold text-2xl text-darkgreen ">User Management</h1>
                <h3 class="my-4 font-semibold text-lg">Add new user</h3>
                
                <form method="post" action="../php/add_user.php">

                    <!-- submit -->
                    <div class="flex justify-end px-2 pb-4">
                        <button type="submit" class="px-2 py-3 bg-midgreen text-white w-32 flex gap-2 justify-center">Add
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                              </svg>
                              
                        </button>
                    </div>
                   
                <!-- add user -->
                <div class="flex gap-8 py-2 ">
                    
                    <!-- full name -->
                    <div class="flex flex-col gap-1">
                        <label for="fName" class="font-bold">Full name:</label>
                        <input type="text" class="px-2 py-3 border-2 w-64" id="fName" name="fName" placeholder="Full name" required>
                    </div>
                    <!-- School ID -->
                    <div class="flex flex-col gap-1">
                        <label for="sID" class="font-bold">School ID:</label>
                        <input type="text" class="px-2 py-3 border-2 w-56"  name ="sID" id="sID" placeholder="School ID" required>
                    </div>
                    <!-- Department -->
                    <div class="flex flex-col gap-1">
                        <label for="department" class="font-bold">Department:</label>
                        <select name="department" id="department" class="px-2 py-3 border-2 w-56" >
                            <?php
                            // Include the database connection file
                            include '../php/db_connection.php';

                            // Fetch departments
                            $sql_departments = "SELECT categoryName FROM category WHERE categoryFor = 'department'";
                            $result_departments = $conn->query($sql_departments);
                            if ($result_departments->num_rows > 0) {
                                while ($row = $result_departments->fetch_assoc()) {
                                    echo "<option value='" . $row['categoryName'] . "'>" . $row['categoryName'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <!-- role -->
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-bold">Role:</label>
                        <select name="role" id="role" class="px-2 py-3 border-2 w-56" >
                            <?php
                            // Fetch roles
                            $sql_roles = "SELECT categoryName FROM category WHERE categoryFor = 'roles'";
                            $result_roles = $conn->query($sql_roles);
                            if ($result_roles->num_rows > 0) {
                                while ($row = $result_roles->fetch_assoc()) {
                                    echo "<option value='" . $row['categoryName'] . "'>" . $row['categoryName'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                   
                    </div> 
                     <!-- contact no -->
                     <div class="flex flex-col gap-1 ">
                        <label for="contactNo" class="font-bold">Contact number:</label>
                        <input type="text" class="px-2 py-3 border-2 w-64" id="contactNo" name="contactNo" placeholder="Contact Number" required>
                    </div>
                </form>
                
                <!-- users table -->
                <h2 class="text-darkgreen font-bold text-2xl my-12">Users: </h2>
                <!-- table -->
                
                    <table class=" table-fixed w-full uppercase text-left  shadow-2xl rounded-2xl border-1 ">
                        <thead class="">
                            <tr class="bg-slate-300  ">
                                <th class="px-2 py-3">School ID</th>
                                <th class="px-2 py-3">Name</th>
                                <th class="px-2 py-3">Department</th>
                                <th class="px-2 py-3">Role</th>
                                <th class="px-2 py-3">Contact Number</th>
                                <th class="px-2 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Include the database connection file
                            include '../php/db_connection.php';

                            // Fetch users
                            $sql_users = "SELECT * FROM users";
                            $result_users = $conn->query($sql_users);
                            if ($result_users->num_rows > 0) {
                                while ($row = $result_users->fetch_assoc()) {
                                    echo "<tr class='bg-white border-b'>";
                                    echo "<td class='px-2 py-3'>" . $row['schoolID'] . "</td>";
                                    echo "<td class='px-2 py-3'>" . $row['fullName'] . "</td>";
                                    echo "<td class='px-2 py-3'>" . $row['department'] . "</td>";
                                    echo "<td class='px-2 py-3'>" . $row['role'] . "</td>";
                                    echo "<td class='px-2 py-3'>" . $row['contactNumber'] . "</td>";
                                    echo "<td class='px-2 py-3 flex gap-4'>";
                                  
                                    echo "<i class='fa-solid fa-trash text-2xl text-red-600' onclick='deleteUser(" . $row['ID'] . ")'></i>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='px-2 py-3'>No users found</td></tr>";
                            }
                            ?>
                        </tbody>

                    </table>
             
                

            </main>
        
    </div>
    
    <script>
    // Function to handle edit user
 
    // Function to handle delete user
    function deleteUser(userID) {
        // Confirm before deleting the user
        if (confirm("Are you sure you want to delete this user?")) {
            // Create a form to submit the user ID for deletion
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", "../php/delete_user.php");

            // Create an input field to hold the user ID
            var input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("name", "deleteUserID");
            input.setAttribute("value", userID);

            // Append the input field to the form
            form.appendChild(input);

            // Append the form to the document body and submit it
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

    
</html>