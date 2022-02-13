<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Adda Data Working Scheme";
    include_once("../../header.php");
?>
<!-- halaman utama -->

<div class="row ">

	<div class="col-md-12 ">
        <div class="alert alert-secondary text-default">
            <span>Pengaturan Working Scheme digunakan untuk mengatur jam kerja normal (tanpa overtime) dan pergantian shift shift secara periodic, 
            secara tidak langsung, pengauran ini juga akan mempengaruhi bagaimana waktu overtime dihitung dan dicalkulasi sebagai variable cost overtime</span>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="title pull-left">Add Setting</h5>
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
                        <label>Group Shift</label>
                        <select name="shift[]" id="" data-style="text-uppercase btn-primary btn-outline-primary text-primary" class="text-uppercase form-control selectpicker ml-0 p-0" title="pilih shift">
                        <option value="" disabled>Pilih Shift</option>
                        <?php
                        $sqlShift = mysqli_query($link, "SELECT * FROM shift")or die(mysqli_error($link));
                        while($dataShift = mysqli_fetch_assoc($sqlShift)){
                            echo "<option data-subtext=\"id shift : $dataShift[id_shift]\" value=\"$dataShift[id_shift]\" >$dataShift[shift]</option>";
                        }
                        ?>
                        </select>
                        <span class="text-primary form-text py-0 mt-0">Pilih Group Shift yang ingin anda setting</span>
                        <br>
                        
                        
                        <label class="mx-0 mt-1 p-0">Working Hours :</label>
                        <select name="wh[]" id="" data-style="btn-primary btn-outline-primary text-primary" class="text-uppercase form-control selectpicker ml-0 p-0" title="Working Hours" >
                        <option value="" disabled>Pilih Working Hours</option>
                        <?php
                        $sqlwh = mysqli_query($link, "SELECT * FROM working_hours")or die(mysqli_error($link));
                        while($datawh = mysqli_fetch_assoc($sqlwh)){
                            echo "<option data-subtext=\"$datawh[code_name]\" value=\"$datawh[id]\" > [check in:$datawh[start]] [check-out:$datawh[end]]</option>";
                        }
                        ?>
                        </select>
                        <span class="text-primary form-text py-0 mt-0">Pilih Jam Kerja dan Shift Pagi / Malam yang ingin anda setting</span>
                        <br>
                        <label class="mx-0 mt-1 mb-0 p-0">Shifting :</label>
                        <select name="shifting[]" id="" data-style="btn-primary btn-outline-primary text-primary" class="text-uppercase form-control selectpicker ml-0 p-0" title="Pilih Shifting">
                        <option value="" disabled>Pilih Shifting</option>
                        <?php
                        $sqlShifting = mysqli_query($link, "SELECT * FROM shifting")or die(mysqli_error($link));
                        while($dataShifting = mysqli_fetch_assoc($sqlShifting)){
                            echo "<option value=\"$dataShifting[id]\" >$dataShifting[name_code]</option>";
                        }
                        ?>
                        </select>
                        <span class="text-primary form-text py-0 mt-0">Periodic Pergantian shift</span>
                        <br>
                        <label>Tanggal Effective</label>
                        <input type="text" name="effdate[]" class="text-info border-info form-control datepicker" data-date-format="DD/MM/YYYY" placeholder="tanggal efektif" required >
                        <span class="text-primary form-text py-0 mt-0">Pilih tanggal kapan pengaturan working scheme akan berlaku</span>
                        <br>
                        
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
