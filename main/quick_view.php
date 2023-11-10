<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['add_to_cart'])){

  if($user_id == ''){
     header('location:login.php');
  }else{

     $pid = $_POST['pid'];
     $pid = filter_var($pid, FILTER_SANITIZE_STRING);
     $name = $_POST['name'];
     $name = filter_var($name, FILTER_SANITIZE_STRING);
     $price = $_POST['price'];
     $price = filter_var($price, FILTER_SANITIZE_STRING);
     $image = $_POST['image'];
     $image = filter_var($image, FILTER_SANITIZE_STRING);
     $qty = $_POST['qty'];
     $qty = filter_var($qty, FILTER_SANITIZE_STRING);
     $discount = $_POST['discount'];
     $discount = filter_var($discount, FILTER_SANITIZE_STRING);
     $stock = $_POST['stock'];
     $stock = filter_var($stock, FILTER_SANITIZE_STRING);

     $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
     $check_cart_numbers->execute([$name, $user_id]);

     if($check_cart_numbers->rowCount() > 0){
        $message[] = 'already added to cart!';
     }else{

        $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image, discount,stock) VALUES(?,?,?,?,?,?,?,?)");
        $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image, $discount,$stock]);
        $message[] = 'added to cart!';
        
     }

  }

}



?>

<!DOCTYPE html>
<html lang="en">
<head >
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Clinic</title>
  
 

  <link rel="stylesheet" href="../assets/css/maicons.css">

  <link rel="stylesheet" href="../assets/css/bootstrap.css">

  <link rel="stylesheet" href="../assets/vendor/owl-carousel/css/owl.carousel.css">

  <link rel="stylesheet" href="../assets/vendor/animate/animate.css">

  <link rel="stylesheet" href="../assets/css/theme.css">

   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  
   
  <!-- custom css file link  -->
  <link rel="stylesheet" href="../assets/css/style.css">
 
<div style="font-size : 162.25%"><?php include '../components/header.php'; ?></div>

<body >

  <!-- Back to top button -->
  <div class="back-to-top"></div>
  <div class="page-banner overlay-dark bg-image" style="background-image: url(../assets/img/bg_image_1.jpg); ">
    <div class="banner-section">
      <div class="container text-center wow fadeInUp">
        <nav aria-label="Breadcrumb">
          <ol class="breadcrumb breadcrumb-dark bg-transparent justify-content-center py-0 mb-2">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Product</li>
          </ol>
        </nav>
        <h1 class="font-weight-normal">Product</h1>
      </div> <!-- .container -->
    </div> <!-- .banner-section -->
  </div> <!-- .page-banner -->

  <section class="quick-view">

   <?php
     $pid = $_GET['pid'];
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); 
     $select_products->execute([$pid]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <input type="hidden" name="discount" value="<?= $fetch_product['discount']; ?>">
      <input type="hidden" name="stock" value="<?= $fetch_product['stock']; ?>">

      <div class="row">
         <div class="image-container">
            <div class="main-image">
               <img src="../assets/img/product/<?= $fetch_product['image_01']; ?>" alt="">
            </div>
            <div class="sub-image">
            
            <?php if (!empty($fetch_product['image_01'])){?>
               <img src="../assets/img/product/<?= $fetch_product['image_01']; ?>" alt=""><?php } ?>

               <?php if (!empty($fetch_product['image_02'])){?>
               <img src="../assets/img/product/<?= $fetch_product['image_02']; ?>" alt=""><?php } ?>
               
               <?php if (!empty($fetch_product['image_03'])){?>
               <img src="../assets/img/product/<?= $fetch_product['image_03']; ?>" alt=""> <?php } ?>
            </div>
         </div>
         <div class="content">
            <div class="name"><?= $fetch_product['name']; ?></div>
            <div class="flex">

   
      <?php if(isset($fetch_product['discount'])){ $discountRate = $fetch_product['discount']/100;?>
         <div class="price">Now RM<?= $fetch_product['price']-($fetch_product['price']*$discountRate); ?></div>
      <div class="discount"> <span style="text-decoration: line-through">RM<?= $fetch_product['price'] ;?></span>     
      <span><?= $fetch_product['discount']; ?> % OFF</span></div><?php }else{ ?><div class="price">RM<?= $fetch_product['price']; ?>
      </div> <?php }?>
  
            <input type="number" name="qty" class="qty" min="1" max="<?= $fetch_product['stock']; ?>" onkeypress="if(this.value.length == 2) return false;" value="1">
 
            </div>

            
            <div class="details"><?= $fetch_product['details']; ?></div>
            <div class="flex-btn">
               <input type="submit" value="Add To Cart" class="btn btn-info" name="add_to_cart" style="font-size:15px;">
               
            </div>
         </div>
      </div>
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

</section>
 

<?php include '../components/footer.php'; ?>


  
  <script src="../assets/js/script.js"></script>


  





</body>
</html>