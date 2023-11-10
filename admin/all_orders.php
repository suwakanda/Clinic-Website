<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_reference_number = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE reference_number = ?");
   $delete_order->execute([$delete_reference_number]);

   header('location:all_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../assets/css/admin_style.css">
   <link rel="stylesheet" href="assets/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="assets/bootstrap.min.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>



<section class="table-product" >
<h1 class="heading">Orders</h1>
<div class="card " style="width: 100%;">

        <div class="card-header">
        <div class="card-body pr-2 pl-2">

          <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th class="text-center">Reference Number</th>
                      <th  class="text-center">Name</th>
                      <th  class="text-center">Email</th>
                      <th  class="text-center">Phone</th> 
                      <th  class="text-center">Total_products</th> 
                      <th  class="text-center">Total_price</th> 
                      <th  class="text-center">Status</th> 
                      <th  class="text-center">Placed_on</th>
                      <th  width='25%' class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                     $select_orders = $conn->prepare("SELECT * FROM `orders`");
                     $select_orders->execute();
                     if($select_orders->rowCount() > 0){
                        while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){   
                  ?>
                  
                  <tr class="text-center">
                  
                    <td><?php echo $fetch_orders['reference_number'];?></td>
                    <td><?php echo $fetch_orders['name'];?></td>
                    
                    <td><?php echo $fetch_orders['email']; ?></td>
                    <td><?php echo $fetch_orders['number']; ?></td>
                    <td><?php echo $fetch_orders['total_products']; ?></td>
                    <td><?php echo $fetch_orders['total_price']; ?></td>
                    <td><?php if($fetch_orders['status'] == '1'){ echo '<span class="badge badge-lg badge-info text-white">Done</span>'; }else{ echo '<span class="badge badge-lg badge-warning text-white">Pending</span>'; }; ?> </td>
                    <td><span class="badge badge-lg badge-secondary text-white"><?php echo  $fetch_orders['placed_on'];  ?></span></td>
                   
                    <td>
                    <a class="btn btn-success btn-sm" href="view_order.php?order_id=<?php echo $fetch_orders['id'];?>">View</a>
                    
                     <a onclick="return confirm('Are you sure To Delete ? The orders information will also be delete!')" class="btn btn-danger btn-sm " href="all_orders.php?delete=<?= $fetch_orders['reference_number']; ?>">Remove</a>     
                    </td>
                     
                  
                  
                  <?php 
               }   
               }else{
                     echo '<p class="empty">no orders placed yet!</p>';
                  }?>
                  
                  
                  </tr>
                  </tbody>

                  
          </table>
        </div>
        </div>
</div>
</section>












<script src="assets/admin_script.js"></script>
 <!-- Jquery script -->
 <script src="assets/jquery.min.js"></script>
  <script src="assets/bootstrap.min.js"></script>
  <script src="assets/jquery.dataTables.min.js"></script>
  <script src="assets/dataTables.bootstrap4.min.js"></script>
  <script>
      $(document).ready(function () {
          $("#flash-msg").delay(7000).fadeOut("slow");
      });

      $(document).ready(function() {
          $('#example').DataTable();
          
      } );
      
      
  </script>
   
</body>
</html>