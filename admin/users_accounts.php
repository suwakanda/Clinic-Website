<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_user->execute([$delete_id]);
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_orders->execute([$delete_id]);
   $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE user_id = ?");
   $delete_messages->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
  
   header('location:users_accounts.php');
}


if(isset($_POST['submit'])){

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $role_id = $_POST['role_id'];
  $role_id = filter_var($role_id, FILTER_SANITIZE_STRING);
  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_STRING);
  $phone = $_POST['phone'];
  $phone = filter_var($phone, FILTER_SANITIZE_STRING);
  $pass = sha1($_POST['pass']);
  $pass = filter_var($pass, FILTER_SANITIZE_STRING);
  $cpass = sha1($_POST['cpass']);
  $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

  $select_admin = $conn->prepare("SELECT * FROM `users` WHERE name = ?");
  $select_admin->execute([$name]);

  if($select_admin->rowCount() > 0){
     $message[] = 'username already exist!';
  }else{
     if($pass != $cpass){
        $message[] = 'confirm password not matched!';
     }else{
        $insert_admin = $conn->prepare("INSERT INTO `users`(name,role_id,email,phone,password) VALUES(?,?,?,?,?)");
        $insert_admin->execute([$name,$role_id,$email,$phone,$cpass]);
        $message[] = 'new registered successfully!';
     }
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../assets/css/admin_style.css">
   <link rel="stylesheet" href="assets/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="assets/bootstrap.min.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>


<section class="table-product" >
<h1 class="heading">user accounts</h1>
<div class="card " style="width: 100%;">

        <div class="card-header">
        <div class="card-body pr-2 pl-2">

          <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th class="text-center">User id</th>
                      <th  class="text-center">Name</th>
                      <th  class="text-center">Email</th>
                      <th  class="text-center">Phone</th> 
                      <th  width='25%' class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $i=1;
                     $select_accounts = $conn->prepare("SELECT * FROM `users`");
                     $select_accounts->execute();
                     if($select_accounts->rowCount() > 0){
                        while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
                  ?>
                  
                  <tr class="text-center">
                  
                    <td><?php echo $i++;?></td>
                    <td><?php echo $fetch_accounts['name'];?><br>
                          <?php if ($fetch_accounts['role_id']  == '1'){
                          echo "<span class='badge badge-lg badge-info text-white'>Admin</span>";
                        } elseif ($fetch_accounts['role_id'] == '2') {
                          echo "<span class='badge badge-lg badge-warning text-white'>Doctors </span>";
                        }elseif ($fetch_accounts['role_id'] == '3') {
                          echo "<span class='badge badge-lg badge-dark text-white'>User </span>";
                        } ?>
                  
                  
                  </td>
                    
                    <td><?php echo $fetch_accounts['email']; ?></td>
                    <td><span class="badge badge-lg badge-secondary text-white"><?php echo $fetch_accounts['phone']; ?></span></td>
                   
                    <td>
                     <a class="btn btn-success btn-sm" href="accounts_details.php?id=<?php echo $fetch_accounts['id'];?>">View</a>
                     <a onclick="return confirm('Are you sure To Delete ? The user related information will also be delete!')" class="btn btn-danger btn-sm " href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>">Remove</a>     
                    </td>
                     
                  
                  <?php }?>
                  <?php }else{
                     echo '<p class="empty">no accounts available!</p>';
                  }?>
                  
                  
                  </tr>
                  </tbody>

                  
          </table>
        </div>
        </div>
</div>
</section>


<section class="form-container">

   <form action="" method="post">
      <h3>register admin or doctor</h3>
      <input type="text" name="name" required placeholder="enter username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="email" name="email" required placeholder="enter email" maxlength="40"  class="box" >
      <input type="number" name="phone" required placeholder="enter phone" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="enter password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="confirm password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <select name="role_id" class="box" required>
      <option value="1">admin</option> 
      <option value="2">doctor</option> 
      </select>
      <input type="submit" value="register now" class="normal-btn" name="submit">
   </form>

</section>




<script src="assets/admin_script.js"></script>
 <!-- Jquery script -->
 <script src="assets/jquery.min.js"></script>
  <script src="assets/bootstrap.min.js"></script>
  <script src="assets/jquery.dataTables.min.js"></script>
  <script src="assets/dataTables.bootstrap4.min.js"></script>
  <script>
      $(document).ready(function () {
          $("#flash-msg").delay(7000).fadeOut("slow");
      });

      $(document).ready(function() {
          $('#example').DataTable();
          
      } );
      
      
  </script>
   
</body>
</html>