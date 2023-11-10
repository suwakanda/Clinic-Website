<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};


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
                $id = $_GET['id'];
                $select_article = $conn->prepare("SELECT * FROM `article` WHERE `isActive` = 0 And id = ? "); 
                $select_article->execute([$id]);
                if($select_article->rowCount() > 0){
                $fetch_article = $select_article->fetch(PDO::FETCH_ASSOC);
                    
              ?>
  <div class="page-section pt-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <nav aria-label="Breadcrumb">
            <ol class="breadcrumb bg-transparent py-0 mb-5">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item"><a href="article.php">Article</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo $fetch_article['title'];?></li>
            </ol>
          </nav>
        </div>
      </div> <!-- .row -->

      <div class="row">
        <div class="col-lg-8">
          <article class="blog-details">
            <div class="post-thumb">
              <img src="../assets/img/article/<?php echo $fetch_article['image'];?>" alt="">
            </div>
            <div class="post-meta">
              <div class="post-author">
                <span class="text-grey">By</span> <a href="#"><?php echo $fetch_article['author'];?></a>  
              </div>
              <span class="divider">|</span>
              <div class="post-date">
                <a href=""><?php echo $fetch_article['date'];?></a>
              </div>
          
            </div>
            <h2 class="post-title h1"><?php echo $fetch_article['title'];?></h2>
            <div class="post-content">
            <?php echo $fetch_article['article'];?>
            </div>
            
          </article> <!-- .article-details -->

        </div>
        <?php
      
   }else{
      echo '<p class="empty">no article added yet!</p>';
   }
   ?>
        
      </div> <!-- .row -->
    </div> <!-- .container -->
  </div> <!-- .page-section -->

  

  <?php include '../components/footer.php'; ?>


<script src="../assets/js/jquery-3.5.1.min.js"></script>

<script src="../assets/js/bootstrap.bundle.min.js"></script>

<script src="../assets/vendor/owl-carousel/js/owl.carousel.min.js"></script>

<script src="../assets/vendor/wow/wow.min.js"></script>

<script src="../assets/js/theme.js"></script>
  
</body>
</html>