<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
};




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
            <li class="breadcrumb-item active" aria-current="page">Order View</li>
          </ol>
        </nav>
        <h1 class="font-weight-normal">Order View</h1>
      </div> <!-- .container -->
    </div> <!-- .banner-section -->
  </div> <!-- .page-banner -->

  
  <section class="orders">

<h1 class="heading">Order View</h1>

<div class="box-container">

<?php
   if($user_id == ''){
      echo '<p class="empty">please login to see your orders</p>';
   }else{
    $reference_number = $_GET['reference_number'];
      $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE reference_number = ?");
      $select_orders->execute([$reference_number]);
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
?>
<div class="box">
   <p>Reference No : <span><?= $fetch_orders['reference_number']; ?></span></p>
   <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
   <p>name : <span><?= $fetch_orders['name']; ?></span></p>
   <p>email : <span><?= $fetch_orders['email']; ?></span></p>
   <p>number : <span><?= $fetch_orders['number']; ?></span></p>
   <p>address : <span><?= $fetch_orders['address']; ?></span></p>
   <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
   <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
   <p>total price : <span>RM<?= $fetch_orders['total_price']; ?>/-</span></p>
   <p>status : <span style="color:<?php if($fetch_orders['status'] == '1'){ echo 'green'; }else{ echo 'orange'; }; ?>">
   <?php if($fetch_orders['status'] == '1'){ echo 'Done'; }else{ echo 'Pending'; }; ?></span> </p>
   
   
</a></span></p>
</div>
<?php
   
   }
   }else{
      echo '<p class="empty">no orders placed yet</p>';
   }
   }
?>

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