<?php
require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
   
    $qry2 = $conn->query("SELECT * FROM `article` where id = '{$_GET['id']}' ");
    $row=mysqli_fetch_assoc($qry2);

  }
?>
<style>
#uni_modal .modal-content>.modal-footer{
    display:none;
}
#uni_modal .modal-body{
    padding-bottom:0 !important;
}
</style>
<div class="container-fluid">

        <div class="form-group d-flex justify-content-center">
				<img src="../../assets/img/article/<?php echo $row['image'] ?>"  class="img-fluid img-thumbnail">
				</div>
    <p><b>Title:</b> <?php echo $row['title'] ?></p>
    <p><b>Category:</b> <?php echo $row['category'] ?></p>
    <p><b>Author:</b> <?php echo $row['author'] ?></p>
    <p><b>Article:</b> <?php echo $row['article']  ?></p>
    <p><b>Status:</b>
        <?php 
        switch($row['isActive']){ 
            case(0): 
                echo '<span class="badge badge-success">Active</span>';
            break; 
            case(1): 
            echo '<span class="badge badge-secondary">Disable</span>';
            break; 
            
            default: 
                echo '<span class="badge badge-secondary">NA</span>';
        }
        ?>
    </p>
</div>
<div class="modal-footer border-0">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
