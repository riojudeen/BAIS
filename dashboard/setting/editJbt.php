<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    if(empty($_GET['jbt'])){
        $_SESSION['info'] = 'Kosong';
        echo "<script>document.location.href='master.php'</script>";
    }
    $halaman = "Edit Master Jabatan";
    include_once("../header.php");

    $id_jbt = mysqli_query($link,"SELECT * FROM jabatan WHERE id_jabatan = '$_GET[jbt]' ")or die(mysqli_error($link));
    $data = mysqli_fetch_assoc($id_jbt);

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
                    <input readonly value="<?=$data['id_jabatan']?>" type="text" name="code[]" class="form-control" maxLength="5" placeholder="maximum 5 karakter (ex. ABC001 etc...)" required autofocus>
                    <label>Nama Jabatan</label>
                    <input value="<?=$data['jabatan']?>" type="text" name="jbt[]" class="form-control" placeholder="nama jabatan " required autofocus>
                    <label>Level</label>
                    <input value="<?=$data['level']?>" type="text" name="lvl[]" class="form-control" pattern="[0-9]{1,3}" placeholder="diisi dengan angka" required autofocus>
                    
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
