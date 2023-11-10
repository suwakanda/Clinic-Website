<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update'])){

   $id = $_POST['id'];
   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $article = $_POST['article'];
   $article = filter_var($article, FILTER_SANITIZE_STRING);
   $author = $_POST['author'];
   $author = filter_var($author, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `article` SET title = ?, article = ?, author = ? ,category = ?  WHERE id = ?");
   $update_product->execute([$title, $article, $author, $category, $id]);

   $message[] = 'article updated successfully!';

   $old_image_01 = $_POST['old_image_01'];
   $image_01 = $_FILES['image']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image']['size'];
   $image_tmp_name_01 = $_FILES['image']['tmp_name'];
   $image_folder_01 = '../assets/img/article/'.$image_01;

   if(!empty($image_01)){
      if($image_size_01 > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image_01 = $conn->prepare("UPDATE `article` SET image = ? WHERE id = ?");
         $update_image_01->execute([$image_01, $id]);

         move_uploaded_file($image_tmp_name_01, $image_folder_01);
         unlink('../assets/img/article/'.$old_image_01);
         $message[] = 'image updated successfully!';
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
   <title>update product</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../assets/css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="update-product">

   <h1 class="heading">Edit article</h1>

   <?php
      $article_id = $_GET['article_id'];
      $select_article = $conn->prepare("SELECT * FROM `article` WHERE id = ?");
      $select_article->execute([$article_id]);
      if($select_article->rowCount() > 0){
         while($fetch_article = $select_article->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $fetch_article['id']; ?>">
      <input type="hidden" name="old_image_01" value="<?= $fetch_article['image']; ?>">
     
      <div class="image-container">
         <div class="main-image">
            <img src="../assets/img/article/<?= $fetch_article['image']; ?>" alt="">
         </div>
         
         </div>
      </div>
      <span>Title</span>
      <input type="text" name="title" required class="box" maxlength="100" placeholder="enter product name" value="<?= $fetch_article['title']; ?>">
      
      <span>Article</span>
      <textarea name="article" class="box" required cols="30" rows="10"><?= $fetch_article['article']; ?></textarea>
      <span>Image</span>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      
      <span>Author</span>
      <input type="text" name="author" required class="box" maxlength="100" placeholder="enter product name" value="<?= $fetch_article['author']; ?>">
      <div class="inputBox">
         <span>CATEGORY (require):</span>
            <select name="category" id="category" class="box" required >
            <option selected disabled value="<?php  $fetch_article['category']; ?>"><?= $fetch_article['category']; ?></option>
            <option value="Neulorogy">Neulorogy</option>
            <option value="Cardiology">Cardiology</option>
            <option value="General Health">General Health</option>
            
            </select>
      </div>
      
      <div class="flex-btn">
         <input type="submit" name="update" class="normal-btn" value="update">
         <a href="article.php" class="option-btn">go back</a>
      </div>
   </form>
   
   <?php
         }
      }else{
         echo '<p class="empty">no article found!</p>';
      }
   ?>

</section>












<script src="assets/admin_script.js"></script>
   
</body>
</html>