<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Adda Data Holiday";
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
                    <input type="hidden" name="id" class="form-control" value="<?=$_GET['id']?>">
                    <div class="form-group after-add-more">
                        <?php
                        $dataWH = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM working_hours WHERE id = '$_GET[id]' "));
                        ?>
                        <label>Day / Night</label>
                        <select name="name_code[]" class="form-control " id="">
                            <?php
                            if($dataWH['code_name'] == "DAY"){
                                $select1 = "selected";
                                $select2 = "";
                            }else {
                                $select2= "selected";
                                $select1 = "";
                            }
                            ?>
                            <option <?=$select1?> value="DAY">DAY</option>
                            <option <?=$select2?> value="NIGHT">NIGHT</option>
                            
                        </select>
                        
                        <label>Check In / Check Out</label>
                        <div class="form-inline">
                        <input value="<?=$dataWH['start']?>" type="text" name="start[]" class="form-control col-lg-3 datepicker" data-date-format="HH:mm:ss" placeholder="Jam Masuk" required >
                        
                        <input value="<?=$dataWH['end']?>" type="text" name="end[]" class="form-control col-lg-3 datepicker ml-3" data-date-format="HH:mm:ss" placeholder="Jam Pulang" required >
                        
                        
                        </div>
                        <label>Keterangan</label>
                        <input value="<?=$dataWH['ket']?>" type="text" name="ket[]" class="form-control" maxLength="30" placeholder="Catatan : Pagi Normal.., etc" required>
                        
                        
                        <hr>
                    </div>
                    <input class="btn btn-success pull-right" type="submit" name="edit" value="SUBMIT">
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
