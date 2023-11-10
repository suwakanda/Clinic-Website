<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


include '../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
};

$select_user = $conn->prepare("SELECT * FROM `users` WHERE `id` = $user_id "); 
$select_user->execute();
if($select_user->rowCount() > 0){$fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);};

if(isset($_POST['submit'])){
  extract($_POST);

   $patient_id = $_POST['patient_id'];
   $patient_id = filter_var($patient_id, FILTER_SANITIZE_STRING);
   $id = $_POST['id'];
   $id = filter_var($id, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $gender = $_POST['gender'];
   $gender = filter_var($gender, FILTER_SANITIZE_STRING);
   $contact = $_POST['contact'];
   $contact = filter_var($contact, FILTER_SANITIZE_STRING);
   $dob = $_POST['dob'];
   $dob = filter_var($dob, FILTER_SANITIZE_STRING);
   $date_sched = $_POST['date_sched'];
   $date_sched = filter_var($date_sched, FILTER_SANITIZE_STRING);
   $ailment = $_POST['ailment'];
   $ailment = filter_var($ailment, FILTER_SANITIZE_STRING);

$sched_set_qry = $conn->prepare("SELECT * FROM `schedule_settings`")or die('query failed');
$sched_set_qry->execute();
$sched_set = array_column($sched_set_qry->fetchAll(PDO::FETCH_ASSOC),'meta_value','meta_field');

		$morning_start = date("Y-m-d ") . explode(',',$sched_set['morning_schedule'])[0];
		$morning_end = date("Y-m-d ") . explode(',',$sched_set['morning_schedule'])[1];
		$afternoon_start = date("Y-m-d ") . explode(',',$sched_set['afternoon_schedule'])[0];
		$afternoon_end = date("Y-m-d ") . explode(',',$sched_set['afternoon_schedule'])[1];

		$sched_time = date("Y-m-d ") . date("H:i",strtotime($date_sched));
    

		if(!in_array(strtolower(date("l",strtotime($date_sched))),explode(',',strtolower($sched_set['day_schedule'])))){
			$message[] = "Selected Schedule Day of Week is invalid.";
		}elseif(!( (strtotime($sched_time) >= strtotime($morning_start) && strtotime($sched_time) <= strtotime($morning_end)) || (strtotime($sched_time) >= strtotime($afternoon_start) && strtotime($sched_time) <= strtotime($afternoon_end)) )){
			$message[] = "Selected Schedule Time is invalid.";
      }else{
    $insert_patientlist = $conn->prepare("INSERT INTO `patient_list`(name,id) VALUES(?,?) ON DUPLICATE KEY UPDATE name = VALUES(name)");
    $insert_patientlist->execute([$name,$user_id]);
    
    if($insert_patientlist->rowCount() > 0){
    $insert_patientlist = $conn->prepare("UPDATE `patient_list` set name = '{$name}' where id = '{$user_id}'  ");
    $insert_patientlist->execute();
    }elseif($insert_patientlist->rowCount() == 0){
      $select_patient = $conn->prepare("SELECT * FROM `patient_list` WHERE name = ?");
      $select_patient->execute([$name]);
      $row = $select_patient->fetch(PDO::FETCH_ASSOC);

      $insert_appointment = $conn->prepare("INSERT INTO `appointments`(date_sched, patient_id,status, ailment) VALUES(?,?,?,?)");
      $insert_appointment->execute([$date_sched,$row['id'],$status,$ailment]);
      $data = "";
      $placeholders = ""; // Initialize placeholders string
      $values = array(); // Initialize an array to hold values

        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('lid','date_sched','status','ailment'))) {
                if (!empty($data)) $data .= ", ";
                $data .= " ({$row['id']},'{$k}','{$v}')"; // Replace with placeholders
                
            }
        }
  
      if (!empty($data)) { // Check if there is data to insert
        $sql = "INSERT INTO `patient_meta` (patient_id, meta_field, meta_value) VALUES $data";
        $save_meta = $conn->prepare($sql);
        $save_meta->execute($values);
        

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
        
     
       
        $mail->Subject = 'Clinic Appointment';
        $mail->Body = 'you are succefull book appointment! wait our answer to comfirm the appointment!! will contact you soon';
        
     
      
        
        $mail->send();
     



        $message[] = "Succefull book appointment!";
        } else {
            // Handle the case when there is no data to insert
            $message[]= "No data to insert.";
        }

   }else{
      $message[] = 'fail to save';
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

 


<?php
  $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? ");
   $select_user->execute([$user_id]);
   $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
  ?>

  <div class="page-section">
    <div class="container">
      <h1 class="text-center wow fadeInUp">Make an Appointment</h1>

      <form class="main-form" method="post">
        <div class="row mt-5 ">
          <div class="col-12 col-sm-6 py-2 wow fadeInLeft">
            <span>Name</span>
            <input type="text" name="name" class="form-control" placeholder="Full name" value="<?=  $fetch_user['name']; ?>"  readonly >
          </div>
          <div class="col-12 col-sm-6 py-2 wow fadeInRight">
            <span>Email</span>
            <input type="text" name="email"class="form-control" placeholder="Email address.." value="<?=  $fetch_user['email']; ?>   "  readonly >
          </div>
          <div class="col-12 col-sm-6 py-2 wow fadeInLeft" data-wow-delay="300ms">
            <select name="gender" id="gender" class="custom-select">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          

          <div class="col-12 col-sm-6 py-2 wow fadeInRight" data-wow-delay="500ms">
            <input type="text" name="contact" class="form-control" placeholder="Phone Number.." value="<?=  $fetch_user['phone']; ?>   "  readonly >
          </div>
          <div class="col-12 col-sm-6 py-2 wow fadeInLeft" data-wow-delay="500ms">
          <label for="dob" class="control-label">Date of Birth</label>
          <input type="date" class="form-control" name="dob"  required>

          </div>
          <div class="col-12 col-sm-6 py-2 wow fadeInLeft" data-wow-delay="500ms">
          <label for="appointment" class="control-label">Appointment</label>
            <input type="datetime-local" class="form-control" name="date_sched" required>

          </div>
          <div class="col-12 py-2 wow fadeInUp" data-wow-delay="600ms">
            <textarea name="ailment" id="ailment" class="form-control" rows="6" placeholder="Enter ailment.."></textarea>
          </div>
        </div>
        <input type="hidden" name="status" value="0">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="patient_id" value="">

        <button type="submit" name="submit" class="btn btn-primary mt-3 wow zoomIn">Submit Request</button>
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