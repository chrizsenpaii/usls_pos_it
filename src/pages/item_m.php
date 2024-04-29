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
                
                <form action="">
                   
                     <!-- submit item -->
                     <div class=" flex flex-col px-6 mt-7 items-end ">
                        <div></div>
                        <button type="submit" class="px-2 py-3 bg-midgreen text-white w-32 flex gap-2 justify-center">Add
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                              </svg>
                              
                        </button>
                    </div>
                   
            
                <div class="flex gap-4 ">
                    <!-- category type -->
                    <div class="flex flex-col gap-1">
                        <label for="catFor" class="font-bold">Category:</label>
                        <select name="catFor" id="catFor" class="px-2 py-3 border-2 w-56">

                        </select>
                    </div>
                    <!-- barcode  -->
                    <div class="flex flex-col gap-1">
                        <label for="barcode" class="font-bold">Barcode:</label>
                        <input type="text" class="px-2 py-3 border-2 w-64" id="barcode" placeholder="Barcode">
                    </div>
                    <!-- Item name -->
                    <div class="flex flex-col gap-1">
                        <label for="itemName" class="font-bold">Item name:</label>
                        <input type="text" class="px-2 py-3 border-2 w-64" id="itemName" placeholder="Item name">
                    </div>
                     <!-- supplier -->
                     <div class="flex flex-col gap-1">
                        <label for="supplierCat" class="font-bold">Supplier:</label>
                        <select name="supplierCat" id="supplierCat" class="px-2 py-3 border-2 w-56">

                        </select>
                    </div>
                   
                    
                      
                </form>
                </div>
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
                                <th class="px-2 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b">
                                <td class="px-2 py-3">John Doe</td>
                                <td class="px-2 py-3">11111</td>
                                <td class="px-2 py-3">CET</td>
                                <td class="px-2 py-3">supplier</td>
                               
                                <td class="px-2 py-3 flex gap-4 ">
                                    <i class="fa-solid fa-pen-to-square text-darkgreen text-2xl" id="editCat"></i>
                                    <i class="fa-solid fa-trash text-2xl text-red-600" id="deleteCat"></i>

                                  
                                  </td>
                               
                                  

                            </tr>
                        </tbody>
                    </table>
             
                

            </main>
        
    </div>
    
   
    
</html>