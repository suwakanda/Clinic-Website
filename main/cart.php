<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
};

if(isset($_POST['delete'])){
  $cart_id = $_POST['cart_id'];
  $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
  $delete_cart_item->execute([$cart_id]);
}


if(isset($_POST['update_qty'])){
  $cart_id = $_POST['cart_id'];
  $qty = $_POST['qty'];
  $qty = filter_var($qty, FILTER_SANITIZE_STRING);
  $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
  $update_qty->execute([$qty, $cart_id]);
  $message[] = 'cart quantity updated';

  
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
            <li class="breadcrumb-item active" aria-current="page">Cart</li>
          </ol>
        </nav>
        <h1 class="font-weight-normal">Cart</h1>
      </div> <!-- .container -->
    </div> <!-- .banner-section -->
  </div> <!-- .page-banner -->


<section class="h-100 gradient-custom">
  <div class="container py-5">
    <div class="row d-flex justify-content-center my-4">
      <div class="col-md-8">
        <div class="card mb-4">
          <div class="card-header py-3">
            <h5 class="mb-0">Cart </h5>
          </div>
          
          <div class="card-body">
           <?php
              $product_total=0;
              $sub_product_total=0;
              $grand_total = 0;
              $discount_total = 0;

              $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
              $select_cart->execute([$user_id]);
              if($select_cart->rowCount() > 0){ 
                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
              ?>
            <form action="" method="post" class="box">
            <!-- Single item -->
            <div class="row">
            <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
              <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                <!-- Image -->
                <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>">
                  <img src="../assets/img/product/<?= $fetch_cart['image']; ?>"
                    class="w-100" />
                  
                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                  </a>
                </div>
                <!-- Image -->
              </div>

              <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                <!-- Data -->
                <p><strong><?= $fetch_cart['name']; ?></strong></p>
                
                <!-- Price -->
                <p class="text-start text-md-center">
                
                <strong style="color:red;">RM <?= $fetch_cart['price']; if($fetch_cart['discount'] != 0){?>            
                /
                <?= $fetch_cart['discount']; ?>% <?php }; ?></strong>
                </p>
                
                
              </div>

              <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <!-- Quantity -->
                <div class="d-flex mb-4" style="max-width: 300px">
                  
                <?php $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                  $select_product->execute([$fetch_cart['pid']]);
                  if($select_cart->rowCount() > 0){
                  $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);
                  ?>
                  <div class="form-inline">
                    <div class="form-group mb-2">
                    <input style="padding: 5px;"type="number" name="qty"  min="1" max="<?= $fetch_product['stock'];} ?>" value="<?= $fetch_cart['quantity']; ?>"type="number" class="form-control" />
                    </div>
                    <div class="form-group mx-sm-3">
                    <button style="padding:10px; height: 4.5rem; border-radius: .5rem; background-color: var(--orange); width: 5rem; font-size: 2rem; color:var(--white); cursor: pointer; " 
                    type="submit" class="fas fa-edit" name="update_qty" title="Update"></button>
                    </div>
                    
                    <button type="submit" class="fas fa-edit fa-trash btn-danger " data-mdb-toggle="tooltip" 
                        title="Remove item" style="   height: 4.5rem; border-radius: .5rem;   font-size: 2rem; cursor: pointer; width: 5rem; " name="delete">
                       
                    
                  
                  </div>
                  
                  </form>
                </div>
                <!-- Quantity -->
                <div style="display:none;">
                <?= 
                $discountRate = $fetch_cart['discount']/100;
                $sub_total =  ($fetch_cart['price']-($fetch_cart['price']* $discountRate)) * $fetch_cart['quantity']; 
                $product_total = $fetch_cart['price']* $fetch_cart['quantity'];
                $discount_total = ($fetch_cart['price']* $discountRate) * $fetch_cart['quantity'];
                ?>
                </div>
                  
                
                
                </div>
              </div>
              
            <hr class="my-4" />
            <?php
            $sub_product_total += $product_total;
            $grand_total += $sub_total;
              }
              
          }else{
              echo '<p class="empty" style="font-size:20px">Your Cart is Empty !</p>';
          }
          ?>
            <!-- Single item -->
          </div>
          
        </div>
        
         
      </div>
     
      <div class="col-md-4">
        <div class="card mb-4">
          <div class="card-header py-3">
            <h5 class="mb-0">Summary</h5>
          </div>
          

          <div class="card-body">
            <ul class="list-group list-group-flush">
              <li
                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                Products
                <span>RM <?= $sub_product_total; ?>   </span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                Discount
                <span>RM <?= $discount_total; ?></span>
              </li>
              <li
                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                <div>
                  <strong>Total amount</strong>
                  <strong>
                    <p class="mb-0">(including VAT)</p>
                  </strong>
                </div>
                <span><strong>RM <?= $grand_total; ?></strong></span>
              </li>
              
            </ul>

            <button onclick="document.location='checkout.php'" type="button" class="btn btn-primary btn-lg btn-block <?= ($grand_total > 1)?'':'disabled'; ?>">
              Go to checkout
            </button>
          </div>
        </div>
      </div>
    </div>
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


<!-- MDB -->
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"
></script>

</body>
</html>