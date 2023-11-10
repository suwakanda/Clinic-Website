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
    padding-top:0 !important;
}
</style>

<div class="container-fluid">
    <form id="article_form" class="py-2" >
    <div class="row" id="article">
        <div class="col-6" id="frm-field">
            <input type="hidden" name="id" value="<?php echo isset($row['id']) ? $row['id'] : '' ?>">
            <input type="hidden" name="old_image" value="<?php echo isset($row['image']) ? $row['image'] : '' ?>">

                
                <div class="form-group d-flex justify-content-center">
				<img src="../../assets/img/article/<?php echo $row['image'] ?>"  class="img-fluid img-thumbnail">
				</div>
                
                <div class="form-group">
					<label for="" class="control-label">Image</label>
					<div class="custom-file">
		              <input type="file"  id="customFile" name="img">
		              <label class="custom-file-label" for="customFile">Choose file</label>
		            </div>
				</div>
                <div class="form-group">
                    <label for="name" class="control-label">Title</label>
                    <input type="text" class="form-control" name="title" value="<?php echo isset($row['title']) ? $row['title'] : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="author" class="control-label">Author</label>
                    <input type="text" class="form-control" name="author" value="<?php echo isset($row['author']) ? $row['author'] : '' ?>"  required>
                </div>
               
                <div class="form-group">
                    <label for="Category" class="control-label">Category</label>
                    <select type="text" class="custom-select" name="category" required>
                    <option <?php echo isset($row['category']) && $row['category'] == "Neulorogy" ? "selected": "" ?>>Neulorogy</option>
                    <option <?php echo isset($row['category']) && $row['category'] == "General Health" ? "selected": "" ?>>General Health</option>                    
                   <option <?php echo isset($row['category']) && $row['category'] == "Cardiology" ? "selected": "" ?>>Cardiology</option>
                    </select>
                </div>
                
        </div>
        <div class="col-6">
                
                <div class="form-group">
                    <label for="article" class="control-label">Article</label>
                    <textarea class="form-control" name="article" rows="3" required><?php echo isset($row['article']) ? $row['article'] : '' ?></textarea>
                </div>

        </div>
        <div class="form-group d-flex justify-content-end w-100 form-group">
            <button class="btn-primary btn">Submit Appointment</button>
            <button class="btn-light btn ml-2" type="button" data-dismiss="modal">Cancel</button>
        </div>
        </form>
    </div>
</div>


<script>
$(function(){
    $('#article_form').submit(function(e){
        e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_article",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
                       location.reload()
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: $('#uni_modal').offset().top }, "fast");
                    }else{
						alert_toast("An error occured",'error');
                        console.log(resp)
					}
						end_loader();
				}
			})
    })
    $('#uni_modal').on('hidden.bs.modal', function (e) {
        if($('#article_form').length <= 0)
            location.reload()
    })
})
</script>


