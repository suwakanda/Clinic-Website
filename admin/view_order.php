<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $status = $_POST['status'];
   $email = $_POST['email'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);
   $update_payment = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
   $update_payment->execute([$status, $order_id]);


   require '../phpmailer/src/Exception.php';
   require '../phpmailer/src/PHPMailer.php';
   require '../phpmailer/src/SMTP.php';
   $mail = new PHPMailer(true);
   
   $mail->isSMTP();
   $mail->Host = 'smtp.gmail.com';
   $mail->SMTPAuth = true;
   $mail->Username = 'clinicreply@gmail.com';
   $mail->Password = 'rgko tzox mpfb yshd';
   $mail->SMTPSecure = 'ssl';
   $mail->Port = 465;
   
   $mail->setFrom('clinicreply@gmail.com');
   
   $mail->addAddress($email);
   

   if($status ==  '1'){
      $mail->Subject = 'Your Order Status Are Updated!';
      $mail->Body = 'Your order is completed !';
   }elseif($status == '2'){
      $mail->Subject = 'Your Order Status Are Updated!';
      $mail->Body = 'Your order is under pending now !';
   }

   $mail->send();

   $message[] = 'status updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>placed orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../assets/css/admin_style.css">
   


</head>
<body>
<?php include '../components/admin_header.php'; ?>

<section class="orders">

<h1 class="heading">Details orders</h1>

<div class="box-container">

   <?php
      $order_id = $_GET['order_id'];
      $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE id LIKE '%{$order_id}%' ");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         $fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)
   ?>
   <div class="box">
      <p> Reference No : <span><?= $fetch_orders['reference_number']; ?></span> </p>
      <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> total products : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> total price : <span>RM<?= $fetch_orders['total_price']; ?>/-</span> </p>
      <p> payment method : <span><?= $fetch_orders['method']; ?></span> </p>
      <form action="" method="post">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <input type="hidden" name="email" value="<?= $fetch_orders['email']; ?>">
         <select name="status" class="select">
            <option selected disabled><?php if($fetch_orders['status'] == 1){echo "Done";}else{echo "pending";}  ?></option>
            <option value="2">pending</option>
            <option value="1">Done</option>
         </select>
        <div class="flex-btn">
         <input type="submit" value="update" class="option-btn" name="update_payment">
         <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
        </div>
      </form>
   </div>
   <?php
         
      }else{
         echo '<p class="empty">order not found!!!</p>';
      }
   ?>

</div>

</section>


<script src="assets/admin_script.js"></script>

   
</body>
</html>