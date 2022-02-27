<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Edit Data Working Shift";
    include_once("../../header.php");
    $q_working_shift = mysqli_query($link, "SELECT `id`,`name`,`req_date` FROM `working_day_shift` WHERE id='$_GET[id]'")or die(mysqli_error($link));
    $sql = mysqli_fetch_assoc($q_working_shift );
    $data = $sql['name'];
?>
<!-- halaman utama -->

<div class="row ">

	<div class="col-md-12 ">
       
        <div class="card">
            <div class="card-header">
                <h5 class="title pull-left">Edit Data</h5>
                <a href="../index.php" class="btn pull-right">
                    Back
                    <span class="btn-label btn-label-right">
                        <i class="nc-icon nc-minimal-right"></i>
                    </span>
                </a>
            </div>
            <form action="proses.php" method="POST">
			    <div class="card-body">
                    <input type="hidden" name="edit" class="form-control" value="<?=$_GET['add']?>" >
                    <div class="form-group after-add-more">
                        <label>Kode Working Shift</label>
                        <input type="text" class="form-control" name="code[]" value="<?=$_GET['id']?>" readonly>
                    </div>
                    <div class="form-group after-add-more">
                        <label>Nama Working Shift</label>
                        
                        <input type="text" class="form-control" name="name[]" value="<?=$data?>">
                    </div>
                    <input class="btn btn-success pull-right" type="submit"  value="SUBMIT">
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
