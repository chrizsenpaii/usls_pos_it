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
                
                <form action="">
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
                    
                    <!-- full name -->
                    <div class="flex flex-col gap-1">
                        <label for="fName" class="font-bold">Full name:</label>
                        <input type="text" class="px-2 py-3 border-2 w-64" id="fName" placeholder="Full name">
                    </div>
                    <!-- School ID -->
                    <div class="flex flex-col gap-1">
                        <label for="sID" class="font-bold">School ID:</label>
                        <input type="text" class="px-2 py-3 border-2 w-56" id="sID" placeholder="School ID">
                    </div>
                    <!-- Department -->
                    <div class="flex flex-col gap-1">
                        <label for="department" class="font-bold">Department:</label>
                        <select name="deparment" id="department" class="px-2 py-3 border-2 w-56"></select>
                    </div>
                    <!-- role -->
                    <div class="flex flex-col gap-1">
                        <label for="role" class="font-bold">Role:</label>
                        <select name="role" id="role" class="px-2 py-3 border-2 w-56"></select>
                    </div>
                    
                      
                </form>
                </div>
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
                                <th class="px-2 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b">
                                <td class="px-2 py-3">2020088</td>
                                <td class="px-2 py-3">John Doe</td>
                                <td class="px-2 py-3">CET</td>
                                <td class="px-2 py-3">Staff</td>
                                <td class="px-2 py-3 flex gap-4 ">
                                    <i class="fa-solid fa-pen-to-square text-darkgreen text-2xl" id="editUser"></i>
                                    <i class="fa-solid fa-trash text-2xl text-red-600" id="deleteUser"></i>

                                  
                                  </td>
                               
                                  

                            </tr>
                        </tbody>
                    </table>
             
                

            </main>
        
    </div>
    
   
    
</html>