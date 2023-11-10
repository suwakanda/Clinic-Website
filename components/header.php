<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<header>

    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
      <div class="container" >
        <a class="navbar-brand" href="index.php">Clinic</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupport" aria-controls="navbarSupport" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupport">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item ">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="about.php">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="doctors.php">Doctors</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="article.php">Article</a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="product.php">Product</a>
            </li>
            
            

            
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);?>

            <li class="nav-item">
              <a class="nav-link" href="makeappointment.php">Appointment</a>
            </li>
            <?php 
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();

            $count_order_items = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ");
            $count_order_items->execute([$user_id]);
            $total_order_counts = $count_order_items->rowCount();
         ?>
              <li class="nav-item">
            <a href="appointment_history.php" style=" padding: 5px;" ><i class="fa-solid fa-calendar-check"></i></a>
            </li>
            <li class="nav-item">
            <a href="cart.php" style=" padding: 5px;"><i class="fas fa-shopping-cart" ></i><span>(<?= $total_cart_counts; ?>)</span></a>
            </li>
            <li class="nav-item">
              <a href="orders.php"><i class="fa-solid fa-file-invoice-dollar"></i><span>(<?= $total_order_counts; ?>)</span></a>
            </li>
            <li class="nav-item">
              <a class="mai-person ml-lg-3" href="update_user.php"> </a>
            </li>


            <li class="nav-item">
            <a class="mai-log-out-outline ml-lg-3" href="../components/user_logout.php"  onclick="return confirm('logout from the website?');"></a> 
            </li>
         
         <?php
            }else{
         ?>
            <li class="nav-item">
              <a class="btn btn-primary ml-lg-3" href="login.php">Login </a>
            </li>

            <li class="nav-item">
              <a class="btn btn-primary ml-lg-3" href="signup.php">Register</a>
            </li>
         <?php
            }
         ?>      
         
      
          </ul>
        </div> <!-- .navbar-collapse -->
      </div> <!-- .container -->
    </nav>
  </header>