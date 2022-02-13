<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    if(empty($_GET['abs'])){
        $_SESSION['info'] = 'Kosong';
        echo "<script>document.location.href='master.php'</script>";
    }
    $halaman = "Edit Master Absensi";
    include_once("../header.php");

    $query = mysqli_query($link,"SELECT * FROM attendance_code WHERE kode = '$_GET[abs]' ")or die(mysqli_error($link));
    $data = mysqli_fetch_assoc($query);

?>
<!-- halaman utama -->
<div class="row ">

	<div class="col-md-12 ">
       
        <div class="card">
            <div class="card-header">
                <h5 class="title pull-left">Edit Master Data</h5>
                <a href="master.php" class="btn pull-right">
                    Back
                    <span class="btn-label btn-label-right">
                        <i class="nc-icon nc-minimal-right"></i>
                    </span>
                </a>
            </div>
            <form action="proses/prosesMaster.php" method="POST">
            <div class="card-body">
                <input type="hidden" name="master" class="form-control" value="<?=$_GET['t']?>">
                <div class="control-group after-add-more">
                    
                    <label>Kode Jbatan</label>
                    <input readonly value="<?=$data['kode']?>" type="text" name="code[]" class="form-control" maxLength="5" placeholder="maximum 5 karakter (ex. ABC001 etc...)" required autofocus>
                    <label>Nama Jabatan</label>
                    <input value="<?=$data['keterangan']?>" type="text" name="ijin[]" class="form-control" placeholder="nama jabatan " required autofocus>
                    <label>Type Ijin dan Pemberitahuan</label>
                    <select name="type[]"  class="form-control">
                        <?php
                        if($data['type'] == 'SUPEM'){
                            $select1 = "selected";
                            $select2 = "";
                            $select3 = "";
                        }else if($data['type'] == 'SUKET'){
                            $select1 = "";
                            $select2 = "selected";
                            $select3 = "";
                        }else{
                            $select1 = "";
                            $select2 = "";
                            $select3 = "selected";
                        }
                        ?>
                        <option <?=$select1?> value="SUPEM">Surat Pemberitahuan</option>
                        <option <?=$select2?> value="SUKET">Surat Keterangan</option>
                        <option <?=$select3?> value="REMARK">Remark</option>
                    </select>
                <button class="btn btn-success pull-right" type="submit" name="editMaster">SAVE</button>
                </div> 
            
            </div>
            <div class="card-footer">   
            </div>
                
            </form>
        </div>
        
	</div>
</div>
<!-- halaman utama end -->
<?php
    include_once("../footer.php");
    
    //javascript
    include_once("../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
