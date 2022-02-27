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
                <h5 class="title pull-left">Add Master Data</h5>
                <a href="../index.php" class="btn pull-right">
                    Back
                    <span class="btn-label btn-label-right">
                        <i class="nc-icon nc-minimal-right"></i>
                    </span>
                </a>
            </div>
            <hr>
            <form action="proses.php" method="POST">
			    <div class="card-body">
                    <input type="hidden" name="edit" class="form-control" value="<?=$_GET['id']?>">
                    <?php
                    $q_break =mysqli_query($link, "SELECT * FROM working_break WHERE id='$_GET[id]'")or die(mysqli_error($link));
                    $sql_break = mysqli_fetch_assoc($q_break);
                    $effective = DBtoForm($sql_break['effective_date']);
                    ?>
                    <div class="control-group after-add-more data-add-1" data-id="1">
                        <h5 class="text-uppercase">Data 1</h5>
                        <label>Skema</label>
                        <input type="text" name="skema[]" class="form-control" maxLength="30" value="<?=$sql_break['scheme_name']?>"  required >
                        <label>Start Time</label>
                        <input type="text" name="start[]" class="form-control datepicker" data-date-format="HH:mm" value="<?=$sql_break['start_time']?>"  required >
                        <label>End Time</label>
                        <input type="text" name="end[]" class="form-control datepicker" data-date-format="HH:mm" value="<?=$sql_break['end_time']?>" required >
                        
                        <label>Effective Date</label>
                        <input type="text" name="effective[]" class="form-control datepicker" data-date-format="DD/MM/Y" value="<?=$effective?>" required >
                        <br>
                    </div>
                </div>
                <hr>
                <div class="card-footer">
                    <button class="btn btn-success pull-right" type="submit">SUBMIT</button>
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
    

<?php
    //javascript
    
    include_once("../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
