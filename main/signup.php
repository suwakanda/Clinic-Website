<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $phone = $_POST['phone'];
   $phone = filter_var($phone, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'email already exists!';
   }elseif(!preg_match('/^[0-9]{10}+$/', $phone)) {
      $message[] = 'Invalid Phone Number';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email,phone, password) VALUES(?,?,?,?)");
         $insert_user->execute([$name, $email,$phone,$cpass]);
         $message[] = 'registered successfully, login now please!';
      }
   }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Clinic</title>

  <link rel="stylesheet" href="../assets/css/maicons.css">

  <link rel="stylesheet" href="../assets/css/bootstrap.css">

  <link rel="stylesheet" href="../assets/vendor/owl-carousel/css/owl.carousel.css">

  <link rel="stylesheet" href="../assets/vendor/animate/animate.css">

  <link rel="stylesheet" href="../assets/css/theme.css">
</head>
<body>

  <!-- Back to top button -->
  <div class="back-to-top"></div>

  <?php include '../components/header.php'; ?>


  <div class="page-section">
    <div class="container">
      <h1 class="text-center wow fadeInUp">Welcome to Register!</h1>

      <form class="main-form text-center" method="post">
        <div class="row mt-2 justify-content-md-center ">
          <div class="col-sm-6 py-2 wow fadeInLeft">
            <input type="text" name="name" class="form-control" required placeholder="Name">
          </div>

          <div class="w-100"></div>

          <div class="col-sm-6 py-2 wow fadeInRight">
            <input type="email" name="email" class="form-control" required placeholder="Email" oninput="this.value = this.value.replace(/\s/g, '')">
          </div>
          
          <div class="w-100"></div>

          <div class="col-sm-6 py-2 wow fadeInLeft">
            <input type="password" name="pass" class="form-control" required placeholder="Password" oninput="this.value = this.value.replace(/\s/g, '')">
          </div>
          
          <div class="w-100"></div>

          <div class="col-sm-6 py-2 wow fadeInRight">
            <input type="password" name="cpass" class="form-control" required placeholder="Confirm your password" oninput="this.value = this.value.replace(/\s/g, '')">
          </div>
       
          <div class="w-100"></div>

          
          <div class="col-sm-6 py-2 wow fadeInLeft">
            <input type="text" name="phone" class="form-control" required placeholder="H/P Number" oninput="this.value = this.value.replace(/\s/g, '')">
          </div>
          
          
          
          
          <div class="col-sm-12 py-2 wow zoomIn">
            <a href="login.php">Alredy have an account?</a>
          </div>
        </div>
        
        <button type="submit" name="submit" class="btn btn-primary mt-3 wow zoomIn">Sign up now!</button>

      </form>
    </div>
  </div> <!-- .page-section -->

 
  <?php include '../components/footer.php'; ?>

<script src="../assets/js/jquery-3.5.1.min.js"></script>

<script src="../assets/js/bootstrap.bundle.min.js"></script>

<script src="../assets/vendor/owl-carousel/js/owl.carousel.min.js"></script>

<script src="../assets/vendor/wow/wow.min.js"></script>

<script src="../assets/js/theme.js"></script>
  
</body>
</html>