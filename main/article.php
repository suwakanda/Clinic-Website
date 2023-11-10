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

  <div class="page-banner overlay-dark bg-image" style="background-image: url(../assets/img/bg_image_1.jpg);">
    <div class="banner-section">
      <div class="container text-center wow fadeInUp">
        <nav aria-label="Breadcrumb">
          <ol class="breadcrumb breadcrumb-dark bg-transparent justify-content-center py-0 mb-2">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Article</li>
          </ol>
        </nav>
        <h1 class="font-weight-normal">Article</h1>
      </div> <!-- .container -->
    </div> <!-- .banner-section -->
  </div> <!-- .page-banner -->

  <div class="page-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
                        <?php
                if (isset($_POST["submit"])) {
                  
                  $search = $_POST["search"];
                  $select_article = $conn->prepare("SELECT * FROM `article` WHERE `isActive` = 0  AND title like '%$search%' 
                  OR  category like'%$search%h' OR author like'%$search%' OR article like'%$search%'
                  ");
                  $select_article->execute();
                   

                }else{
                  $select_article = $conn->prepare("SELECT * FROM `article` WHERE `isActive` = 0  ORDER BY id DESC LIMIT 6 "); 
                  $select_article->execute();
                 
                }
                
                if($select_article->rowCount() > 0){
                  while($fetch_article = $select_article->fetch(PDO::FETCH_ASSOC)){
              ?>
            <div class="col-sm-6 py-3">
              <div class="card-blog">
                <div class="header">
                  <div class="post-category">
                    <a href="article-details.php?id=<?php echo $fetch_article['id'];?>"><?php echo $fetch_article['category'];?></a>
                  </div>
                  <a href="article-details.php?id=<?php echo $fetch_article['id'];?>" class="post-thumb">
                    <img src="../assets/img/article/<?php echo $fetch_article['image'];?>" alt="">
                  </a>
                </div>
                <div class="body">
                  <h5 class="post-title"><a href="article-details.php?id=<?php echo $fetch_article['id'];?>"><?php echo $fetch_article['title'];?></a></h5>
                  <div class="site-info">
                    <div class="avatar mr-2">
                      
                      <span><?php echo $fetch_article['author'];?></span>
                    </div>
                    <span class="mai-time"><?php echo $fetch_article['date'];?></span> 
                  </div>
                </div>
              </div>
            </div>
            <?php
      }
   }else{
      echo '<p class="empty">no article added yet!</p>';
   }
   ?>
            
         
          </div> <!-- .row -->
        </div>
        <div class="col-lg-4">
          <div class="sidebar">
            <div class="sidebar-block">
              <h3 class="sidebar-title">Search</h3>
              <form action="#" method="post" class="search-form">
                <div class="form-group">
                  <input type="text" name="search" class="form-control" placeholder="Type a keyword and hit enter">
                  <button type="submit" name="submit" class="btn"><span class="icon mai-search"></span></button>
                </div>
              </form>
            </div>
            <div class="sidebar-block">
              <h3 class="sidebar-title">Categories</h3>
              <ul class="categories">
                <li><a href="article_category.php?category=cardiology">Cardiology </a></li>
                <li><a href="article_category.php?category=neulorogy">Neurology </a></li>
                <li><a href="article_category.php?category=general health">General Health </a></li>
              </ul>
            </div>
         
          </div>
        </div> 
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