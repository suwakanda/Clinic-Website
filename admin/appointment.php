<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];

    $delete_product = $conn->prepare("DELETE FROM `appointments` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    
    header('location:appointment.php');
 }
 
 if(isset($_GET['pending'])){

    $app_id = $_GET['pending'];
    $update_isActive = $conn->prepare("UPDATE `appointments` SET status = ? WHERE id = ?");
    $update_isActive->execute([0, $app_id]);
    
    header('location:appointment.php');
 }

 if(isset($_GET['comfirm'])){
    $app_id = $_GET['comfirm'];
    $update_isActive = $conn->prepare("UPDATE `appointments` SET status = ? WHERE id = ?");
    $update_isActive->execute([1, $app_id]);
    
    header('location:appointment.php');
 }

 if(isset($_GET['cancel'])){

    $app_id = $_GET['cancel'];
    $update_isActive = $conn->prepare("UPDATE `appointments` SET status = ? WHERE id = ?");
    $update_isActive->execute([2, $app_id]);
    
    header('location:appointment.php');
 }


 if(isset($_POST['update_schedule'])){
   $data = "";
   foreach($_POST as $k => $v){
      if(is_array($_POST[$k]))
      $v = implode(',',$_POST[$k]);
      if(!empty($data)) $data .= ",";
      $data .= " ('{$k}','{$v}') ";
   }
   $sql = "INSERT INTO `schedule_settings` (`meta_field`,`meta_value`) VALUES {$data}";
   if(!empty($data)){
      $conn->query("DELETE FROM `schedule_settings`");
      
   }
   $save = $conn->query($sql);
   if($save){
      
      $message[] = 'Schedule settings successfully updated';
   }else{
      
      $message[] = "An Error occure while excuting the query.";

   }
   
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
   <link rel="stylesheet" href="assets/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="assets/bootstrap.min.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>


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

<section class="table-product" >
<h1 class="heading">Appointments</h1>
<div class="card " style="width: 100%;">
        <div class="card-header">
        <div class="card-body pr-2 pl-2">
          <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th class="text-center">Appointment id</th>
                      <th  class="text-center">Patient Name</th>
                      <th  class="text-center">Ailment</th>
                      <th  class="text-center">Appointmen Date</th> 
                      <th  class="text-center">Status</th>
                      <th  width='25%' class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                     $select_appointment = $conn->prepare("SELECT * FROM `appointments`");
                     $select_appointment->execute();
                     if($select_appointment->rowCount() > 0){
                        while($fetch_appointment = $select_appointment->fetch(PDO::FETCH_ASSOC)){   

                            $select_patient = $conn->prepare("SELECT * FROM `patient_list` where id = ?");
                            $select_patient->execute([$fetch_appointment['patient_id']]);
                            $fetch_patient = $select_patient->fetch(PDO::FETCH_ASSOC)

                  ?>
                  
                  <tr class="text-center">
                  
                    <td><?php echo $fetch_appointment['id'];?></td>
                    <td><?php echo $fetch_patient['name'];?></td>
                    <td><?php echo $fetch_appointment['ailment']; ?></td>
                    
                    <td><?php echo $fetch_appointment['date_sched']; ?></td>
                    <td>
                        <?php if ($fetch_appointment['status'] == '0') { ?>
                          <span class="badge badge-lg badge-warning text-white">Pending</span>
                          <?php }elseif(($fetch_appointment['status'] == '1')){ ?>
                        <span class="badge badge-lg badge-success text-white">Comfirmed</span>
                          <?php }elseif(($fetch_appointment['status'] == '2')){ ?>
                            <span class="badge badge-lg badge-danger text-white">Cancelled</span>
                            <?php } ?>
                        </td>
                    <td>
                     <a onclick="return confirm('Are you sure To Delete ? The orders information will also be delete!')" class="btn btn-danger btn-sm " href="?delete=<?= $fetch_appointment['id']; ?>">Remove</a>     
                             <!-- pending --> 
                             <?php if($fetch_appointment['status'] == '1'){?>
                               <a onclick="return confirm('Are you sure To Cancel ?')" class="btn btn-danger btn-sm " 
                               href="?cancel=<?php echo $fetch_appointment['id'];?>">Cancel</a>
                             <?php }elseif($fetch_appointment['status'] == '2'){?>
                                <a onclick="return confirm('Are you sure To Comfrim? ?')" class="btn btn-success btn-sm " 
                                href="?comfirm=<?php echo $fetch_appointment['id'];?>">Comfrim</a>
                                <?php
                             } ?>


                            <!-- comfirm --> 
                            <?php if ($fetch_appointment['status'] == '0') {  ?>
                               <a onclick="return confirm('Are you sure To Cancel ?')" class="btn btn-danger btn-sm " 
                                href="?cancel=<?php echo $fetch_appointment['id'];?>">Cancel</a>
                             <?php }elseif($fetch_appointment['status'] == '2'){?>
                                <a onclick="return confirm('Are you sure To pending ?')" class="btn btn-warning btn-sm " 
                                href="?pending=<?php echo $fetch_appointment['id'];?>">pending</a>
                                <?php
                             } ?>
                            <!-- cancel --> 
                            <?php if ($fetch_appointment['status'] == '0') {  ?>
                               <a onclick="return confirm('Are you sure To Comfirm ?')" class="btn btn-success btn-sm " 
                                href="?comfirm=<?php echo $fetch_appointment['id'];?>">Comfirm</a>
                             <?php } elseif($fetch_appointment['status'] == '1'){?>
                                
                               <a onclick="return confirm('Are you sure To Pending ?')" class="btn btn-warning btn-sm " 
                               href="?pending=<?php echo $fetch_appointment['id'];?>">Pending</a>
                             <?php }?>
                                
                    
                    </td>
                     
                  
                  <?php }?>
                  <?php }else{
                     echo '<p class="empty">no article yet!</p>';
                  }?>
                  
                  
                  </tr>
                  </tbody>

                  
          </table>
        </div>
        </div>
</div>
</section>



<?php

$query = "SELECT * FROM `schedule_settings`";
$stmt = $conn->query($query);
if ($stmt) {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $meta = [];
    if ($result) {
        foreach ($result as $row) {
            $meta[$row['meta_field']] = $row['meta_value'];
        }
    }
} 

?>


<section class="table-product" >
   <div class="col-lg-12">
      <div class="card card-outline card-primary">
         <div class="card-header">
            <h5 class="card-title">Clinic Schedule Settings</h5>
         </div>
         <div class="card-body">
            <form action="" id="schedule_settings" method="post">
               <div id="msg" class="form-group"></div>
                  <div class="row">
                  <div class="col-lg-6">
                  <div class="form-group">
                     <label for="" class="control-label">Weekly Schedule</label><br>
                     <div class="icheck-primary">
                           <input type="checkbox" id="checkboxPrimary1" name="day_schedule[]" value='Sunday' <?php echo isset($meta['day_schedule']) && in_array("Sunday",explode(",",$meta['day_schedule'])) ? "checked" : ''  ?>>
                           <label for="checkboxPrimary1">
                              Sunday
                           </label>
                     </div>
                     <div class="icheck-primary">
                           <input type="checkbox" id="checkboxPrimary2" name="day_schedule[]" value='Monday'  <?php echo isset($meta['day_schedule']) && in_array("Monday",explode(",",$meta['day_schedule'])) ? "checked" : ''  ?>>
                           <label for="checkboxPrimary2">
                              Monday
                           </label>
                     </div>
                     <div class="icheck-primary">
                           <input type="checkbox" id="checkboxPrimary3" name="day_schedule[]" value='Tuesday'  <?php echo isset($meta['day_schedule']) && in_array("Tuesday",explode(",",$meta['day_schedule'])) ? "checked" : ''  ?>>
                           <label for="checkboxPrimary3">
                              Tuesday
                           </label>
                     </div>
                     <div class="icheck-primary">
                           <input type="checkbox" id="checkboxPrimary4" name="day_schedule[]" value='Wednesday'  <?php echo isset($meta['day_schedule']) && in_array("Wednesday",explode(",",$meta['day_schedule'])) ? "checked" : ''  ?>>
                           <label for="checkboxPrimary4">
                              Wednesday
                           </label>
                     </div>
                     <div class="icheck-primary">
                           <input type="checkbox" id="checkboxPrimary5" name="day_schedule[]" value='Thursday'  <?php echo isset($meta['day_schedule']) && in_array("Thursday",explode(",",$meta['day_schedule'])) ? "checked" : ''  ?>>
                           <label for="checkboxPrimary5">
                              Thursday
                           </label>
                     </div>
                     <div class="icheck-primary">
                           <input type="checkbox" id="checkboxPrimary6" name="day_schedule[]" value='Friday'  <?php echo isset($meta['day_schedule']) && in_array("Friday",explode(",",$meta['day_schedule'])) ? "checked" : ''  ?>>
                           <label for="checkboxPrimary6">
                              Friday
                           </label>
                     </div>
                     <div class="icheck-primary">
                           <input type="checkbox" id="checkboxPrimary7" name="day_schedule[]" value='Saturday'  <?php echo isset($meta['day_schedule']) && in_array("Saturday",explode(",",$meta['day_schedule'])) ? "checked" : ''  ?>>
                           <label for="checkboxPrimary7">
                              Saturday
                           </label>
                     </div>
                  </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group">
                           <label for="" class="control-label">Morning Time Schedule</label>
                              <div class="row row-cols-3">
                              <input type="time" class="form-control col" name="morning_schedule[]" value="<?php echo isset($meta['morning_schedule']) ? explode(',',$meta['morning_schedule'])[0] : "" ?>" required>
                              <span class="col-auto"> - </span>
                              <input type="time" class="form-control col" name="morning_schedule[]" value="<?php echo isset($meta['morning_schedule']) ? explode(',',$meta['morning_schedule'])[1] : "" ?>" required>
                           </div>
                     </div>
                     <div class="form-group">
                           <label for="" class="control-label">Afternoon Time Schedule</label>
                           <div class="row row-cols-3">
                              <input type="time" class="form-control col" name="afternoon_schedule[]" value="<?php echo isset($meta['afternoon_schedule']) ? explode(',',$meta['afternoon_schedule'])[0] : "" ?>" required>
                              <span class="col-auto"> - </span>
                              <input type="time" class="form-control col" name="afternoon_schedule[]" value="<?php echo isset($meta['afternoon_schedule']) ? explode(',',$meta['afternoon_schedule'])[1] : "" ?>" required>
                           </div>
                     </div>

                     
                  </div>
                  </div>
                  <button class="btn btn-sm btn-primary"   type="submit" name="update_schedule">Update</button>
            </form>
         </div>
         
      </div>
   </div>

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

