<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `article` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../assets/img/article/'.$fetch_delete_image['image']);
   
    $delete_product = $conn->prepare("DELETE FROM `article` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    
    header('location:article.php');
 }
 
 if(isset($_GET['active'])){

    $isActive_id = $_GET['active'];
    $update_isActive = $conn->prepare("UPDATE `article` SET isActive = ? WHERE id = ?");
    $update_isActive->execute([0, $isActive_id]);
    
    header('location:article.php');
 }

 if(isset($_GET['deactive'])){

    $isActive_id = $_GET['deactive'];
    $update_isActive = $conn->prepare("UPDATE `article` SET isActive = ? WHERE id = ?");
    $update_isActive->execute([1, $isActive_id]);
    
    header('location:article.php');
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

<section class="table-product" >
<h1 class="heading">Article</h1>
<div class="card " style="width: 100%;">

        <div class="card-header">
        <div class="card-body pr-2 pl-2">

          <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th class="text-center">Article id</th>
                      <th  class="text-center">Title</th>
                      <th  class="text-center">Category</th>
                      <th  class="text-center">Author</th> 
                      <th  class="text-center">Created date</th> 
                      <th  width='25%' class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                     $select_article = $conn->prepare("SELECT * FROM `article`");
                     $select_article->execute();
                     if($select_article->rowCount() > 0){
                        while($fetch_article = $select_article->fetch(PDO::FETCH_ASSOC)){   
                  ?>
                  
                  <tr class="text-center">
                  
                    <td><?php echo $fetch_article['id'];?></td>
                    <td><?php echo $fetch_article['title'];?></td>
                    
                    <td><?php echo $fetch_article['category']; ?></td>
                    <td><?php echo $fetch_article['author']; ?></td>
                    <td><?php echo $fetch_article['date']; ?></td>
                   
                    <td>
                    <a class="btn btn-info btn-sm" href="edit_article.php?article_id=<?php echo $fetch_article['id'];?>">Edit</a>
                    
                     <a onclick="return confirm('Are you sure To Delete ? The orders information will also be delete!')" class="btn btn-danger btn-sm " href="article.php?delete=<?= $fetch_article['id']; ?>">Remove</a>     
                     <?php if ($fetch_article['isActive'] == '0') {  ?>
                               <a onclick="return confirm('Are you sure To Deactive ?')" class="btn btn-warning

                                btn-sm " href="?deactive=<?php echo $fetch_article['id'];?>">Disable</a>
                             <?php } elseif($fetch_article['isActive'] == '1'){?>
                               <a onclick="return confirm('Are you sure To Active ?')" class="btn btn-secondary
      
                                btn-sm " href="?active=<?php echo $fetch_article['id'];?>">Active</a>
                             <?php } ?>
                    
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

<section class="add-products">

   <h1 class="heading">Add Article</h1>

   <form action="" method="post" enctype="multipart/form-data">
     
      <span>Title</span>
      <input type="text" name="title" required class="box" maxlength="100" placeholder="Enter the title" required> 
      
      <span>Article</span>
      <textarea name="article" class="box" required cols="30" rows="10" placeholder="Enter the article" required></textarea>
      <span>Image</span>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
      
      <span>Author</span>
      <input type="text" name="author" required class="box" maxlength="100" placeholder="Enter the author name" required>
      <div class="inputBox">
         <span>CATEGORY (require):</span>
            <select name="category" id="category" class="box" required >
            
            <option value="Neulorogy">Neulorogy</option>
            <option value="Cardiology">Cardiology</option>
            <option value="General Health">General Health</option>
            
            </select>
      </div>
      
      <div class="flex-btn">
         <input type="submit" name="add article" class="normal-btn" value="add">
      
      </div>
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

