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
                <a href="../index.php?tab=holidays" class="btn pull-right">
                    Back
                    <span class="btn-label btn-label-right">
                        <i class="nc-icon nc-minimal-right"></i>
                    </span>
                </a>
            </div>
            <form action="proses.php" method="POST">
			    <div class="card-body">
                    <input type="hidden" name="add" class="form-control" value="<?=$_GET['add']?>">
                    <div class="control-group after-add-more">
                        <label>Date</label>
                        <input type="date" name="date[]" class="form-control col-lg-3" data-date-format="DD/MM/YYYY" placeholder="pilih tanggal libur" required >
                        <label>Holiday Type</label>
                        <select name="type[]" class="form-control " id="">
                            <option value="" disabled>Pilih Jenis Libur</option>
                            <option value="LN">Libur Nasional</option>
                            <option value="CB">Cuti Bersama</option>
                        </select>
                        <label>Keterangan</label>
                        <input type="text" name="ket[]" class="form-control" maxLength="30" placeholder="contoh : Hari Raya Idul Fitri.. cuti bersama akhir tahun.." required>
                        
                        <button class="btn btn-info add-more" type="button">
                        <i class="nc-icon nc-simple-add"></i> Add
                        </button>
                        <hr>
                    </div>
                    

            <!-- class hide membuat form disembunyikan  -->
            <!-- hide adalah fungsi bootstrap 3, klo bootstrap 4 pake invisible  -->
                    <div class="copy d-none">
                        <div class="control-group">
                            <label>Date</label>
                            <input type="date" name="date[]" class="form-control col-lg-3" data-date-format="DD/MM/YYYY" placeholder="pilih tanggal libur" >
                            <label>Holiday Type</label>
                            <select name="type[]" class="form-control " id="">
                                <option value="" disabled>Pilih Jenis Libur</option>    
                                <option value="LN">Libur Nasional</option>
                                <option value="CB">Cuti Bersama</option>
                            </select>
                            <label>Keterangan</label>
                            <input type="text" name="ket[]" class="form-control" maxLength="30" placeholder="contoh : Hari Raya Idul Fitri.. cuti bersama akhir tahun.." >
                            
                            <br>
                            <button class="btn btn-danger remove" type="button"><i class="nc-icon nc-simple-remove"></i> Remove</button>
                            
                            <hr>
                        </div>
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
