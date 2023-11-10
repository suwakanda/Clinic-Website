<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
   $delete_admins->execute([$delete_id]);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../assets/css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">accounts</h1>

   <div class="box-container">


   <?php
      $id = $_GET['id'];
      $select_accounts = $conn->prepare("SELECT * FROM `users` WHERE id LIKE '%{$id}%'");
      $select_accounts->execute();
      $row = $select_accounts->fetch(PDO::FETCH_ASSOC);
      if($select_accounts->rowCount() > 0){  
   ?>
   <div class="box">
      <p> id : <span><?= $row['id']; ?></span> </p>
      <p> name : <span><?= $row['name']; ?></span> </p>
      <p> email : <span><?= $row['email']; ?></span> </p>
      <p> phone : <span><?= $row['phone']; ?></span> </p>
     
      
      <div class="flex-btn">
         <a href="admin_accounts.php?delete=<?= $row['id']; ?>" onclick="return confirm('delete this account?')" class="delete-btn">delete</a>
         <?php
            if($row['id'] == $admin_id){
               echo '<a href="update_profile.php" class="option-btn">update</a>';
            }
         ?>
      </div>
   </div>
   <?php
         
      }else{
         echo '<p class="empty">no accounts available!</p>';
      }
   ?>

   </div>

</section>



<script src="assets/admin_script.js"></script>
   
</body>
</html>