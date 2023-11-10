<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

 

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



?>

<!DOCTYPE html>
<html lang="en">
<head >
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Clinic</title>

  <link rel="stylesheet" href="../assets/css/maicons.css">

  <link rel="stylesheet" href="../assets/css/bootstrap.css">

  <link rel="stylesheet" href="../assets/vendor/owl-carousel/css/owl.carousel.css">

  <link rel="stylesheet" href="../assets/vendor/animate/animate.css">

  <link rel="stylesheet" href="../assets/css/theme.css">

  <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
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

  <section class="category " >

   <h1 class="heading wow fadeInUp">Shop by Category</h1>

   <div class="swiper category-slider" >

   <div class="swiper-wrapper">

   <a href="category.php?category=wheelchair" class="swiper-slide slide wow fadeInUp">
      <img src="../assets/img/icon-1.png" alt="">
      <h3>Wheelchair</h3>
   </a>

   <a href="category.php?category=mask" class="swiper-slide slide wow fadeInUp">
      <img src="../assets/img/icon-2.png" alt="">
      <h3>Mask</h3>
   </a>

   <a href="category.php?category=thermometer" class="swiper-slide slide wow fadeInUp">
      <img src="../assets/img/icon-3.png" alt="">
      <h3>Thermometer</h3>
   </a>

   <a href="category.php?category=firstaidkit" class="swiper-slide slide wow fadeInUp">
      <img src="../assets/img/icon-4.png" alt="">
      <h3>First Aid Kit</h3>
   </a>

   <a href="category.php?category=testingkit" class="swiper-slide slide wow fadeInUp">
      <img src="../assets/img/icon-5.png" alt="">
      <h3>Testing Kit</h3>
   </a>

   </div>

   </div>

</section>

<section class="latest-products ">

   <h1 class="heading wow fadeInUp">Latest Products</h1>

   <div class="swiper products-slider">

   <div class="swiper-wrapper wow fadeInUp">

   <?php
   
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE `isActive` = 0 AND `stock` > 0 ORDER BY id DESC LIMIT 6 "); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
         $discountRate = $fetch_product['discount']/100;
   ?>
   <form action="" method="post" class="swiper-slide slide " >
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <input type="hidden" name="discount" value="<?= $fetch_product['discount']; ?>">
      <input type="hidden" name="stock" value="<?= $fetch_product['stock']; ?>">

      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="../assets/img/product/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <div class="price">RM<?= $fetch_product['price']-($fetch_product['price']*$discountRate); ?> 
         <?php if(isset($fetch_product['discount'])){?>
         /
         <?= $fetch_product['discount']; ?>% off<?php } ?></div>
         
         <input type="number" name="qty" class="qty" min="1" max="<?= $fetch_product['stock']; ?>" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="Add To Cart" class="btn btn-info" name="add_to_cart" style="font-family: sans-serif; font-size: 15px;">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>

 

<?php include '../components/footer.php'; ?>

<script src="../assets/js/jquery-3.5.1.min.js"></script>

<script src="../assets/js/bootstrap.bundle.min.js"></script>

<script src="../assets/vendor/owl-carousel/js/owl.carousel.min.js"></script>

<script src="../assets/vendor/wow/wow.min.js"></script>

<script src="../assets/js/theme.js"></script>
  

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script>

 var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});

var swiper = new Swiper(".products-slider", {
   loop:false,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>


</body>
</html>