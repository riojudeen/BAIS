<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Edit Data Leave Alocation";
    include_once("../../header.php");
    if(isset($_GET['edit'])){
        $dataAloc = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM leave_alocation WHERE id = '$_GET[edit]' "));
        // echo $dataAloc['alocation'];
?>
<!-- halaman utama -->

<div class="row ">

	<div class="col-md-12 ">
       
        <div class="card">
            <div class="card-header">
                <h5 class="title pull-left">Edit Data</h5>
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
                    <input type="hidden" name="id[]" class="form-control col-lg-3 "  placeholder="tanggal berlaku" required value="<?=$dataAloc['id']?>">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="form-group after-add-more">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Jenis / Kode Cuti</label>
                                        <select name="leave_code[]" class="form-control " id="" readonly>
                                            <option disabled>pilih jenis ijin</option>
                                        <?php
                                        $qry_leaveCode = mysqli_query($link, "SELECT * FROM attendance_code ")or die(mysqli_error($link));
                                        while($leaveCode = mysqli_fetch_assoc($qry_leaveCode)){
                                            $select_ = ($leaveCode['kode'] == $_GET['kode'])?"selected":"";
                            
                                            ?>
                                            <option <?=$select_?> value="<?=$leaveCode['kode']?>"><?=$leaveCode['kode']?> - <?=$leaveCode['keterangan']?></option>

                                            <?php
                                        }
                                        ?> 
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Tipe Periodik</label>
                                        <select name="leave_period_type[]" class="form-control " id="">
                                            <?php
                                             $notset = ($leaveCode['type'] == '' || (!isset($leaveCode['type'])))?"selected":"";
                                             $anual = (isset($leaveCode['type']))?(($leaveCode['type'] == 'annual')?"selected":""):"";
                                             $long = (isset($leaveCode['type']))?(($leaveCode['type'] == 'long')?"selected":""):"";
                                            ?>
                                            <option disabled>pilih tipe periodik</option>
                                            <option <?=$notset?> value="" >Periode Tidak Diatur</option>
                                            <option <?=$anual?> value="annual" >Tahunan</option>
                                            <option <?=$long?> value="long" >Panjang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Tanggal Effective / berlaku</label>
                                        <div class="form-inline">
                                            <input type="text" value="<?=DBtoForm($dataAloc['effective_date'])?>" name="start[]" class="form-control col-lg-3 datepicker" data-date-format="DD/MM/YYYY" placeholder="tanggal mulai berlaku" required >
                                            <label class="col-lg-1 float-right">sampai :</label>
                                            <input type="text" value="<?=DBtoForm($dataAloc['end'])?>" name="end[]" class="form-control col-lg-3 datepicker" data-date-format="DD/MM/YYYY" placeholder="tanggal selesai" required >
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Alokasi</label>
                                        <div class="form-inline">
                                            
                                            <input type="number" value="<?=$dataAloc['alocation']?>" name="alokasi[]" class="form-control col-lg-3" maxLength="3" minLength="1"  placeholder="jumlah alokasi dalam 1 tahun" required>
                                        
                                        </div>
                                    </div>
                                </div>
                                
                                <hr>
                            </div>
                        </div>
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
    }else{
        $_SESSION['info'] = 'Kosong';
        echo "<script>document.location.href='index.php'</script>";
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>