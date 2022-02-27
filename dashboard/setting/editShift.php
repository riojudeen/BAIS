<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    if(empty($_GET['shf'])){
        $_SESSION['info'] = 'Kosong';
        echo "<script>document.location.href='master.php'</script>";
    }
    $halaman = "Edit Master Shift";
    include_once("../header.php");

    $query = mysqli_query($link,"SELECT * FROM shift WHERE id_shift = '$_GET[shf]' ")or die(mysqli_error($link));
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
                    
                    <label>Kode Shift</label>
                    <input readonly value="<?=$data['id_shift']?>" type="text" name="code[]" class="form-control" maxLength="5" placeholder="maximum 5 karakter (ex. ABC001 etc...)" required autofocus>
                    <label>Shift</label>
                    <input value="<?=$data['shift']?>" type="text" name="shift[]" class="form-control" placeholder="nama shift " maxLength="10" required autofocus>
                    <label for="">Production Shift</label>
                    <select name="production[]" id="" class="form-control">
                        <?php
                        if($data['production'] == '1'){
                            ?>
                            <option selected value="1">YES</option>
                            <option value="0">NO</option>
                            <?php
                        }else{
                            ?>
                            <option value="1">YES</option>
                            <option selected value="0">NO</option>
                            <?php
                        }
                        ?>
                        
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
