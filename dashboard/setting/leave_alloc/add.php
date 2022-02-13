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
                <a href="index.php" class="btn pull-right">
                    Back
                    <span class="btn-label btn-label-right">
                        <i class="nc-icon nc-minimal-right"></i>
                    </span>
                </a>
            </div>
            <form action="proses.php" method="POST">
			    <div class="card-body">
                    <input type="hidden" class="form-control" value="">
                    <div class="form-group after-add-more">
                        <label>Jenis / Kode Cuti</label>
                        <select name="leave_code[]" class="form-control " id="">
                            <option disabled>pilih jenis ijin</option>
                        <?php
                        $qry_leaveCode = mysqli_query($link, "SELECT * FROM attendance_code ")or die(mysqli_error($link));
                        while($leaveCode = mysqli_fetch_assoc($qry_leaveCode)){
                            ?>
                            <option value="<?=$leaveCode['kode']?>"><?=$leaveCode['kode']?> - <?=$leaveCode['keterangan']?></option>

                            <?php
                        }

                        ?>
                           
                            
                        </select>
                        
                        <label>Tanggal Effective / berlaku</label>
                        <div class="form-inline">
                        <input type="text" name="start[]" class="form-control col-lg-3 datepicker" data-date-format="DD/MM/YYYY" placeholder="tanggal berlaku" required >
                        <label class="col-lg-1 float-right">Alokasi :</label>
                        <input type="number" name="alokasi[]" class="form-control col-lg-3" maxLength="3" minLength="1"  placeholder="jumlah alokasi dalam 1 tahun" required>
                        </div>
                        
                        
                        
                        
                        <hr>
                    </div>
                    <input class="btn btn-success pull-right" type="submit" name="add" value="SUBMIT">
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
