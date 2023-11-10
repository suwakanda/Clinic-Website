<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../assets/img/product/'.$image_01;

   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../assets/img/product/'.$image_02;

   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../assets/img/product/'.$image_03;

   $category = $_POST['category'];
   $discount = $_POST['discount'];
   $stock = $_POST['stock'];
   $isActive = $_POST['status'];

   if($discount != 0){$discount = filter_var($discount, FILTER_SANITIZE_STRING);}
   else {$discount = NULL;}


   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exist!';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `products`(name, details, price, image_01, image_02, image_03,category,discount,stock,isActive) VALUES(?,?,?,?,?,?,?,?,?,?)");
      $insert_products->execute([$name, $details, $price, $image_01, $image_02, $image_03, $category, $discount,$stock,$isActive]);

      if($insert_products){
         if($image_size_01 > 2000000 OR $image_size_02 > 2000000 OR $image_size_03 > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            $message[] = 'new product added!';
         }

      }

   }  

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../assets/img/product/'.$fetch_delete_image['image_01']);
   unlink('../assets/img/product/'.$fetch_delete_image['image_02']);
   unlink('../assets/img/product/'.$fetch_delete_image['image_03']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   
   header('location:products.php');
}


if(isset($_GET['active'])){

   $isActive_id = $_GET['active'];
   $update_isActive = $conn->prepare("UPDATE `products` SET isActive = ? WHERE id = ?");
   $update_isActive->execute([0, $isActive_id]);
   
   header('location:products.php');
}

if(isset($_GET['deactive'])){

   $isActive_id = $_GET['deactive'];
   $update_isActive = $conn->prepare("UPDATE `products` SET isActive = ? WHERE id = ?");
   $update_isActive->execute([1, $isActive_id]);
   
   header('location:products.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>
   
 
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../assets/css/admin_style.css">
   
   <link rel="stylesheet" href="assets/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="assets/bootstrap.min.css">
    
   

</head>
<body>

<?php include '../components/admin_header.php'; ?>


<section class="table-product" >
<h1 class="heading">products added</h1>
<div class="card " style="width: 100%;">

        <div class="card-header">
        <div class="card-body pr-2 pl-2">

          <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th class="text-center">Product id</th>
                      <th  class="text-center">Name</th>
                      <th  class="text-center">Category</th>
                      <th  class="text-center">Net Price</th> 
                      <th  class="text-center">Discount</th> 
                      <th  class="text-center">Stock</th> 
                      <th  class="text-center">Status</th> 
                      <th  width='25%' class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  

                  $select_products= $conn->prepare("SELECT * FROM `products` ORDER BY id ");
                  $select_products->execute();
                  if($select_products->rowCount() > 0){
                     while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
            ?>
                  
                  <tr class="text-center">
                  
                    <td><?php echo $fetch_products['id'];?></td>
                    <td><a href="update_product.php?update=<?php echo $fetch_products['id'];?>"><?php echo $fetch_products['name'];?></a></td>
                    
                    <td><?php echo $fetch_products['category']; ?></td>
                    <td><?php echo $fetch_products['price']; ?></td>
                    <td><?php if(isset($fetch_products['discount'])){echo $fetch_products['discount']; ?>%<?php }else{echo '0';} ?></td>
                    <td><?php echo $fetch_products['stock']; ?></td>
                    <td>
                          <?php if ($fetch_products['isActive'] == '0') { ?>
                          <span class="badge badge-lg badge-info text-white">Active</span>
                        <?php }else{ ?>
                       <span class="badge badge-lg badge-danger text-white">Deactive</span>
                        <?php } ?>

                     </td>
                    <td>
                    
                     <a class="btn btn-info btn-sm " href="update_product.php?update=<?= $fetch_products['id']; ?>">Edit</a>
                     <a onclick="return confirm('Are you sure To Delete ?')" class="btn btn-danger btn-sm " href="products.php?delete=<?= $fetch_products['id']; ?>">Remove</a>
                     <?php if ($fetch_products['isActive'] == '0') {  ?>
                               <a onclick="return confirm('Are you sure To Deactive ?')" class="btn btn-warning

                                btn-sm " href="?deactive=<?php echo $fetch_products['id'];?>">Disable</a>
                             <?php } elseif($fetch_products['isActive'] == '1'){?>
                               <a onclick="return confirm('Are you sure To Active ?')" class="btn btn-secondary
      
                                btn-sm " href="?active=<?php echo $fetch_products['id'];?>">Active</a>
                             <?php } ?>
                    </td>
                     
                  
                  <?php }?>
                  <?php }?>
                  
                  
                  </tr>
                  </tbody>

                  
          </table>
        </div>
        </div>
</div>
</section>



<section class="add-products">

   <h1 class="heading">add product</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>product name (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter product name" name="name">
         </div>
         <div class="inputBox">
            <span>product price (required)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" name="price">
         </div>
        <div class="inputBox">
            <span>image 01 (required)</span>
            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>image 02 (required)</span>
            <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>image 03 </span>
            <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" >
        </div>
         <div class="inputBox">
            <span>product details (required)</span>
            <textarea name="details" placeholder="enter product details" class="box" required maxlength="500" cols="30" rows="10"></textarea>
         </div>

         <div class="inputBox">
            <span>discount rate </span>
            <input type="number" min="0" class="box"  max="100" placeholder="enter discount rate %" onkeypress="if(this.value.length == 10) return false;" name="discount" >
         </div>

         <div class="inputBox">
            <span>stock (required)</span>
            <input type="number" min="0" class="box"  max="100" placeholder="enter number of stock" onkeypress="if(this.value.length == 10) return false;" name="stock" required>
         </div>

         <div class="inputBox">
         <span>category:</span>
            <select name="category" class="box" required>
            <option value="wheelchair">wheelchair</option>
            <option value="mask">mask</option>
            <option value="thermometer">thermometer</option>
            <option value="firstaidkit">first aid kit</option>
            <option value="testingkit">testing kit</option>
            </select>
         </div>

         <div class="inputBox">
         <span>Status:</span>
            <select name="status" class="box" required>
            <option selected value="0">Active</option>
            <option value="1">Disable</option>
            </select>
         </div>


      </div>

      
      
      <input type="submit" value="add product" class="normal-btn" name="add_product">
   </form>

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