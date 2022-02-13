<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Adda Data Holiday";
    include_once("../../header.php");
    echo $_GET['id'];
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
                    <input type="hidden" name="id[]" class="form-control" value="<?=$_GET['id']?>">
                    <div class="control-group after-add-more">
                        <?php
                        $data = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM holidays WHERE id = '$_GET[id]' "));
                        $array = array("CB", "LN");
                        ?>
                        <label>Date</label>
                        <input value="<?=$data['date']?>" type="date" name="date[]" class="form-control col-lg-3" data-date-format="DD/MM/YYYY" placeholder="pilih tanggal libur" required >
                        <label>Holiday Type</label>
                        <select name="type[]" class="form-control " id="">
                        <?php
                        ?>
                        
                            <option value="" disabled>Pilih Jenis Libur</option>
                            <?php
                            foreach($array as $dataLibur){
                                if($data['type'] == $dataLibur){
                                    $select = "selected";
                                }else{
                                    $select = "";
                                }
                                $name = ($dataLibur == "CB")?"Cuti Bersama":"Libur Nasional";
                            ?>
                                <option <?=$select?> value="<?=$dataLibur?>"><?=$name?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <label>Keterangan</label>
                        <input value="<?=$data['ket']?>" type="text" name="ket[]" class="form-control" maxLength="30" placeholder="contoh : Hari Raya Idul Fitri.. cuti bersama akhir tahun.." required>
                        
                    </div>
                    
                    <input  class="btn btn-success pull-right" type="submit" name="edit" value="Save">
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
