<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Add Working Shift Setting";
    include_once("../../header.php");
?>
<!-- halaman utama -->

<div class="row ">

	<div class="col-md-12 ">
       
        <div class="card">
            <div class="card-header">
                <h5 class="title pull-left">Add Data</h5>
                <a href="../index.php" class="btn pull-right">
                    Back
                    <span class="btn-label btn-label-right">
                        <i class="nc-icon nc-minimal-right"></i>
                    </span>
                </a>
            </div>
            <form action="proses.php" method="POST">
			    <div class="card-body">
                    <input type="hidden" name="add" class="form-control" value="<?=$_GET['add']?>">
                    <div class="form-group after-add-more">
                        <label>Kode Working Shift</label>
                        <input type="text" class="form-control" name="code[]">
                    </div>
                    <div class="form-group after-add-more">
                        <label>Nama Working Shift</label>
                        <input type="text" class="form-control" name="name[]">
                    </div>
                    <input class="btn btn-success pull-right" type="submit" value="SUBMIT">
                </div>   
                
                
                <div class="card-footer">   

                </div>
                <br/>
                
            </form>
        </div>
        
	</div>
</div>
<!-- halaman utama end -->
<?php
    include_once("../../footer.php");
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
      $(".add-more").click(function(){ 
          var html = $(".copy").html();
          $(".after-add-more").after(html);
      });

      // saat tombol remove dklik control group akan dihapus 
      $("body").on("click",".remove",function(){ 
          $(this).parents(".control-group").remove();
      });
    });
</script>

<?php
    //javascript
    
    include_once("../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
