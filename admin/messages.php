<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages.php');
}

if(isset($_GET['read'])){

   $message_id = $_GET['read'];
   $update_status = $conn->prepare("UPDATE `messages` SET status = ? WHERE id = ?");
   $update_status->execute([1, $message_id]);
   
   header('location:messages.php');
}

if(isset($_GET['unread'])){

   $message_id = $_GET['unread'];
   $update_status = $conn->prepare("UPDATE `messages` SET status = ? WHERE id = ?");
   $update_status->execute([0, $message_id]);
   
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../assets/css/admin_style.css">
   <link rel="stylesheet" href="assets/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="assets/bootstrap.min.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>


<section class="table-product" >
<h1 class="heading">Messages</h1>
<div class="card " style="width: 100%;">

        <div class="card-header">
        <div class="card-body pr-2 pl-2">

          <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th class="text-center">User id</th>
                      <th  class="text-center">Name</th>
                      <th  class="text-center">Email</th>
                      <th  class="text-center">Subject</th> 
                      <th  class="text-center">Status</th> 
                      <th  width='25%' class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $i=1;
                     $select_messages = $conn->prepare("SELECT * FROM `messages`");
                     $select_messages->execute();
                     if($select_messages->rowCount() > 0){
                        while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){   
                  ?>
                  
                  <tr class="text-center">
                  
                    <td><?php echo $i++;?></td>
                    <td><?php echo $fetch_message['name'];?><br>

                  </td>
                    
                    <td><?php echo $fetch_message['email']; ?></td>
                    <td><span class="badge badge-lg badge-secondary text-white"><?php echo $fetch_message['subject']; ?></span></td>
                   
                    <td>
                          <?php if ($fetch_message['status'] == '0') { ?>
                          <span class="badge badge-lg badge-warning text-white">Unread</span>
                          <?php }else{ ?>
                        <span class="badge badge-lg badge-success text-white">Read</span>
                          <?php } ?>

                     </td>


                    <td>
                     <a class="btn btn-success btn-sm" href="?view=<?php echo $fetch_message['id'];?>">View</a>
                     <a onclick="return confirm('Are you sure To Delete ? The user related information will also be delete!')" class="btn btn-danger btn-sm " href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>">Remove</a>     
                     
                          <?php if ($fetch_message['status'] == '0') { ?>
                           <a onclick="return confirm('Are you sure to mark as read ?')" class="btn btn-primary btn-sm " href="?read=<?php echo $fetch_message['id'];?>">Read</a>
                              <?php } elseif($fetch_message['status'] == '1'){?>
                              <a onclick="return confirm('Are you sure mark as unread ?')" class="btn btn-secondary btn-sm " href="?unread=<?php echo $fetch_message['id'];?>">Unread</a>
                              <?php } ?>
                        
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


<?php
   if(isset($_GET['view'])){
      $message_id = $_GET['view'];
      $select_messages = $conn->prepare("SELECT * FROM `messages` WHERE id = ?");
      $select_messages->execute([$message_id]);
      if($select_messages->rowCount() > 0){
         while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
   ?>

<section class="contacts">

<h1 class="heading">messages</h1>

<div class="box-container">

   
   <div class="box">
   <p> name : <span><?= $fetch_message['name']; ?></span></p>
   <p> email : <span><?= $fetch_message['email']; ?></span></p>
   <p> subject : <span><?= $fetch_message['subject']; ?></span></p>
   <p> message : <span><?= $fetch_message['message']; ?></span></p>
   <a href="messages.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">you have no messages</p>';
      }

   }
   ?>

</div>

</section>




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







<script src="assets/admin_script.js"></script>
   
</body>
</html>