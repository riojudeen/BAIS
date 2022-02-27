<?php

//////////////////////////////////////////////////////////////////////
include("../../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Man Power";
if(isset($_SESSION['user'])){

    include_once("../../header.php");
?>

<div class="row ">
    <div class="col-md-12">
        <div class="card card-primary card-stats" style='border: 1px solid #FF4848;'>
            <div class="card-header">
                <div class="pull-right">
                    <a href="../manpower.php" class="btn btn-default"><i class="nc-icon nc-minimal-left"></i> Kembali</a>
                </div>
                <h5>Tambah data Department</h5>
            </div>
            <div class="card-body ">
                <form class="form-inline" action="add.php" method="post">
                    <div class="form-group col-2">
                        <label for="">Jumlah Record Data</label>                
                    </div>
                    <div class="form-group col-8">
                        <input type="number" class="form-control col" name="count" required>
                    </div>
                    <div class="form-group pull-right">
                        <input type="submit" name="generate" value="generate" class="btn btn-primary">
                    </div>
                </form>
            </div>

            <div class="card-footer">
            </div>

        </div>
    </div>
</div>

<?php

    ///////////////////////////////////////


    // tutup koneksi dengan database mysql
    mysqli_close($link);

    ?>

<?php
    //footer
        include_once("../../footer.php");

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>