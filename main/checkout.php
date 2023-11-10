<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
};

if(isset($_POST['order'])){
    $ref = sprintf("%'012d",mt_rand(0, 999999999999));
    
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);
    $address = $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' ， '. $_POST['pin_code'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];
 
    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);
    
 
 
    if($check_cart->rowCount() > 0){
 
       $insert_order = $conn->prepare("INSERT INTO `orders`(user_id,reference_number, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?,?)");
       $insert_order->execute([$user_id,$ref, $name, $number, $email, $method, $address, $total_products, $total_price]);
 
       $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
       $delete_cart->execute([$user_id]);
 
       $message[] = 'order placed successfully!';
    }else{
       $message[] = 'your cart is empty';
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
            <li class="breadcrumb-item active" aria-current="page">Check Out</li>
          </ol>
        </nav>
        <h1 class="font-weight-normal">Check Out</h1>
      </div> <!-- .container -->
    </div> <!-- .banner-section -->
  </div> <!-- .page-banner -->

  <section class="checkout-orders">

<form action="" method="POST">

<h3>Orders</h3>

   <div class="display-orders">
   <?php
      $total=0;
      $grand_total = 0;
      $discount_total = 0;
      $cart_items[] = '';
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
            $discountRate = $fetch_cart['discount']/100;
            $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
            $total_products = implode($cart_items);
            $total += ($fetch_cart['price'] * $fetch_cart['quantity']);
            $curent_total= $fetch_cart['price'] * $fetch_cart['quantity'];
            $grand_total += (($fetch_cart['price']-($fetch_cart['price']* $discountRate)) * $fetch_cart['quantity']);
            $discount_total += (($fetch_cart['price']* $discountRate) * $fetch_cart['quantity']);
   ?>
      <p> <?= $fetch_cart['name']; ?> <span>(<?= 'RM'.($fetch_cart['price']).' x '. $fetch_cart['quantity']; ?>)
      <?php if($fetch_cart['discount']!=null){   echo '- '.$fetch_cart['discount'].'%'; }
      ?>
      
       =(<?= 'RM'.(($fetch_cart['price']-($fetch_cart['price']* $discountRate))* $fetch_cart['quantity']) ?>)</span> </p>
      
   <?php
   
   
         }
      }else{
         echo '<p class="empty">your cart is empty!</p>';
      }
   ?>
      <input type="hidden" name="total_products" value="<?= $total_products; ?>">
      <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
      
      <div class="grand-total">total : <span>RM<?= $total; ?></span> discount : <span>RM<?= $discount_total; ?></span> After Discount : <span>RM<?= $grand_total; ?></span></div>
   </div>

   <h3>place your orders</h3>

<?php
$select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? ");
$select_user->execute([$user_id]);
$fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

if(!empty($fetch_user['address'])){
$address = $fetch_user['address'];
list($flat, $street, $city, $state, $country, $pin_code) = explode(", ", $address);
}

?>

   <div class="flex">
      <div class="inputBox">
         <span>your name :</span>
         <input type="text" name="name" value="<?php echo $fetch_user['name'];?>" placeholder="enter your name" class="box" maxlength="20" required>
      </div>
      <div class="inputBox">
         <span>your number :</span>
         <input type="number" name="number" value="<?php echo $fetch_user['phone'];?>" placeholder="enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
      </div>
      <div class="inputBox">
         <span>your email :</span>
         <input type="email" name="email" value="<?php echo $fetch_user['email'];?>" placeholder="enter your email" class="box" maxlength="50" required>
      </div>
      <div class="inputBox">
         <span>payment method :</span>
         <select name="method" class="box" required>
            <option value="cash on delivery">cash on delivery</option>
         </select>
      </div>
      <div class="inputBox">
         <span>address line 01 :</span>
         <input type="text" name="flat" value="<?php echo isset($flat) ? $flat : '';?>" placeholder="e.g. flat number" class="box" maxlength="50" required>
      </div>
      <div class="inputBox">
         <span>address line 02 :</span>
         <input type="text" name="street" value="<?php echo isset($street) ? $street : '';?>" placeholder="e.g. street name" class="box" maxlength="50" required>
      </div>
      <div class="inputBox">
         <span>city :</span>
         <input type="text" name="city" value="<?php echo isset($city) ? $city : '';?>" placeholder="e.g. gelugor" class="box" maxlength="50" required>
      </div>
      <div class="inputBox">
         <span>state :</span>
         <input type="text" name="state" value="<?php echo isset($state) ? $state : '';?>" placeholder="e.g. penang" class="box" maxlength="50" required>
      </div>
      <div class="inputBox">
         <span>country :</span>
         <input type="text" name="country" value="<?php echo isset($country) ? $country : '';?>" placeholder="e.g. malaysia" class="box" maxlength="50" required>
      </div>
      <div class="inputBox">
         <span>post code :</span>
         <input type="number" min="0" name="pin_code" value="<?php echo isset($pin_code) ? $pin_code : '';?>" placeholder="e.g. 123456" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
      </div>
   </div>
   
   <input type="submit" name="order" class="btn btn-primary <?= ($grand_total > 1)?'':'disabled'; ?>" value="place order" style="font-size:15px;">

</form>

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