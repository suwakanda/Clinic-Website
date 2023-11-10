<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}


date_default_timezone_set('Asia/Kuala_Lumpur');

$today = date('Y-m-d');
$year = date('Y');
if(isset($_GET['year'])){
  $year = $_GET['year'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
   <link rel="stylesheet" href="../assets/css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

      
   <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

            if($fetch_profile['role_id'] == 1){

              header('location:../admin/dashboard.php');
        ?>
      

   
<?php }elseif($fetch_profile['role_id'] == 2){ 
  
  
  header('location:../doctor/admin/index.php');
  
  
  ?>







  


  <?php } ?>

</section>


<script>
$(function(){
  $('#select_year').change(function(){
    window.location.href = 'dashboard.php?year='+$(this).val();
  });
});
</script>


<script src="assets/admin_script.js"></script>
   
</body>
</html>

