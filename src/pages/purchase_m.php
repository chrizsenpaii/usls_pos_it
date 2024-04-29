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
    <div class=" h-screen grid grid-cols-5 p-4 gap-4">
            <!-- sidebar -->
            <aside class=" hidden md:block col-span-1 bg-white rounded-2xl  font-semibold overflow-y-clip ">
            <?php include 'sidebar.php'; ?>

                
            </aside>


            <!-- main -->
            <main class="col-span-5 bg-white rounded-2xl md:col-span-4 p-4 ">
                <div class="flex justify-between">
                    <h1 class="font-bold text-2xl text-darkgreen ">Purchase Order</h1>
                    <h1 class="font-bold text-2xl text-red-500 " id="poID">PO-000001</h1>
                </div>
                
                <h3 class="my-4 font-semibold text-lg">Suppliers Items</h3>
                
                <form action="">
                   
                  
                   
            
                <div class="flex  flex-col gap-4 ">
                    <!-- user select -->
                    <div class=" flex flex-col gap-1">
                        <label for="selectSupp" class="font-bold">Select supplier:</label>
                        <select name="selectSupp" id="selectSupp" class="px-2 py-3 border-2 w-56">

                        </select>
                        <input type="search" name="searchSuppItem" id="searchSuppItem" placeholder="Search..." class=" flex px-2 py-3 w-56 border-2">
                    </div>
                   
                   <!-- items to add -->
                 <div class="">
                    <table class=" table-fixed w-full uppercase text-left  shadow-2xl rounded-2xl border-1 ">
                        <thead class="">
                            <tr class="bg-slate-300  ">
                                <th class="px-2 py-3">Barcode</th>
                                <th class="px-2 py-3">Item Name</th>
                                <th class="px-2 py-3">Quantity</th>
                                <th class="px-2 py-3">Add</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b">
                                <td class="px-2 py-3">John Doe</td>
                                <td class="px-2 py-3">11111</td>
                                <td class="px-2 py-3">CET</td>
                                <td class="px-2 py-3 flex gap-4  text-center">
                                 <input type="checkbox" name="checkedItem" id="checkedItem">

                                  
                                  </td>
                               
                                  

                            </tr>
                        </tbody>
                    </table>
             
                 </div>
                   
                </div>
                </form>
                
                <!-- users table -->
                <h2 class="text-darkgreen font-bold text-2xl my-12">Items: </h2>
                <!-- table -->

                    <form action="">
                        <!-- submit item -->
                     <div class="flex flex-col">
                         <!-- submit item -->
                     <div class=" flex flex-col px-6 mt-7 items-end ">
                        <div></div>
                        <button type="submit" class="px-2 py-3 bg-midgreen text-white w-32 flex gap-2 justify-center">Submit
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                              </svg>
                              
                        </button>
                    </div>
                    <table class=" table-fixed w-full uppercase text-left  shadow-2xl rounded-2xl border-1  my-4">
                        <thead class="">
                            <tr class="bg-slate-300  ">
                              
                                <th class="px-2 py-3">Supplier</th>
                                <th class="px-2 py-3">Barcode</th>
                                <th class="px-2 py-3">Item name</th>
                                <th class="px-2 py-3">Quantity</th>
                                <th class="px-2 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b">
                                <td class="px-2 py-3">John Doe</td>
                                <td class="px-2 py-3">11111</td>
                                <td class="px-2 py-3">CET</td>
                                <td class="px-2 py-3"><input type="number" name="qtyItem" id="qtyItem" class="px-2 py-3 w-20 border-2"></td>
                               
                                <td class="px-2 py-3 flex gap-4 ">
                                   
                                    <i class="fa-solid fa-trash text-2xl text-red-600" id="deleteCat"></i>

                                  
                                  </td>
                               
                                  

                            </tr>
                        </tbody>
                    </table>
                </div>
                </form>
             
                

            </main>
        
    </div>
    
   
    
</html>