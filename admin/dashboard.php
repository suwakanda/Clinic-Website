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
        ?>
      <div class="box">
         <?php
            $total_pendings = 0;
            $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE status = ?");
            $select_pendings->execute(['2']);
            if($select_pendings->rowCount() > 0){
               while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                  $total_pendings += $fetch_pendings['total_price'];
               }
            }
         ?>
         <h3><span>RM</span><?= $total_pendings; ?><span>/-</span></h3>
         <p>Total Pendings</p>
         <a href="all_orders.php" class="normal-btn">see orders</a>
      </div>

      <div class="box">
         <?php
            $total_completes = 0;
            $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE status = ?");
            $select_completes->execute(['1']);
            if($select_completes->rowCount() > 0){
               while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                  $total_completes += $fetch_completes['total_price'];
               }
            }
         ?>
         <h3><span>RM</span><?= $total_completes; ?><span>/-</span></h3>
         <p>Completed Orders</p>
         <a href="all_orders.php" class="normal-btn">see orders</a>
      </div>

      

      <div class="box">
         <?php
            $select_products = $conn->prepare("SELECT * FROM `products`");
            $select_products->execute();
            $number_of_products = $select_products->rowCount()
         ?>
         <h3><?= $number_of_products; ?></h3>
         <p>Products Added</p>
         <a href="products.php" class="normal-btn">see products</a>
      </div>

      <div class="box">
         <?php
            $select_messages = $conn->prepare("SELECT * FROM `messages` WHERE status = 0");
            $select_messages->execute();
            $number_of_messages = $select_messages->rowCount()
         ?>
         <h3><?= $number_of_messages; ?></h3>
         <p>New Messages</p>
         <a href="messages.php" class="normal-btn">see messages</a>
      </div>

      

      

   </div>
   <br>
   <h1 class="heading">sales report</h1>

                  <label>Select Year: </label>
                    <select class="form-control input-sm" id="select_year">
                      <?php
                        for($i=2021; $i<=2030; $i++){
                          $selected = ($i==$year)?'selected':'';
                          echo "
                            <option value='".$i."' ".$selected.">".$i."</option>
                          ";
                        }
                      ?>
                    </select>
   <div style="width:auto;">
  <canvas id="myChart" ></canvas>
</div>

<!-- Chart Data -->
<?php
  $months = array();
  $sales = array();
  for( $m = 1; $m <= 12; $m++ ) {
    try{
      $stmt = $conn->prepare("SELECT * FROM orders  WHERE MONTH(placed_on)=:month AND YEAR(placed_on)=:year");
      $stmt->execute(['month'=>$m, 'year'=>$year]);
      $total = 0;
      foreach($stmt as $srow){
        $subtotal = $srow['total_price'];
        $total += $subtotal;    
      }
      array_push($sales, round($total, 2));
    }
    catch(PDOException $e){
      echo $e->getMessage();
    }

    $num = str_pad( $m, 2, 0, STR_PAD_LEFT );
    $month =  date('M', mktime(0, 0, 0, $m, 1));
    array_push($months, $month);
  }

  $months = json_encode($months);
  $sales = json_encode($sales);

?>
<!-- End Chart Data -->


 
<script>
  // === include 'setup' then 'config' above ===
  
  const data = {
    labels: <?php echo $months; ?>,
    datasets: [{
      label: 'sales',
      data: <?php echo $sales; ?>,
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(201, 203, 207, 0.2)'
      ],
      borderColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(201, 203, 207)'
      ],
      borderWidth: 1
    }]
  };

  const config = {
    type: 'bar',
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  };

  var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>

   
<?php }elseif($fetch_profile['role_id'] == 2){ 
  
  
  header('location:../doctor/dashboard.php');
  
  
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

