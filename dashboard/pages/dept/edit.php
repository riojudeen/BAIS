<?php

//////////////////////////////////////////////////////////////////////
include("../../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Man Power";
if(isset($_SESSION['user'])){

    include_once("../../header.php");

if(!isset($_POST['deptchecked'])){
    echo "<script>alert('tidak ada data yang dipilih');window.location='index.php';</script>";
} else {
    $check = $_POST['deptchecked'];
    
    ?>

    
    


<div class="row ">
    <div class="col-md-12">
        <div class="card card-primary card-stats" style='border: 1px solid #FF4848;'>
        <div class="card-header">
        <h5 class="pull-left">Edit data Department</h5>
            <div class="pull-right">

                <a href="index.php" class="btn btn-default"><i class="nc-icon nc-minimal-left"></i> Kembali</a>
            </div>
            
        </div>
        <div class="card-body ">
        <form class="form-inline" action="proses.php" method="post">
            <div class="table-responsive" style="height:200">                    
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kode</th>
                            <th scope="col">Department</th>
                            <th scope="col">NPK Koordinator</th>
                            <th scope="col">Nama Koordinator</th>
                            <th scope="col"></th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        <?php
                    $no = 1 ;
                    foreach($check as $id){
                        $sql_dept = mysqli_query($link, "SELECT * FROM department WHERE id_dept = '$id'") or die(mysqli_error($link));
                        while($data_dept = mysqli_fetch_assoc($sql_dept)) {?>
                            <tr><td><?=$no++?></td>
                            <td>
                                <input type="hidden" class="form-control" name="id[]" value="<?=$data_dept['id_dept']?>" maxlength="5" readonly>
                                <input type="text" class="form-control" name="id[]" value="<?=$data_dept['id_dept']?>" maxlength="5" readonly >
                            </td>
                            <td>
                                <input type="text" class="form-control" name="dept[]" value="<?=$data_dept['dept']?>"  required autofocus>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="npk[]" value="<?=$data_dept['npk_cord']?>" required>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="nama[]" value="<?=$data_dept['dept_cord']?>" readonly>
                            </td>
                            <td>
                            </tr>



                        <?php

                        }

                    }
                    ?>
                    
                    </tbody>
                        
                </table>
                    
            </div>
            <div class="box col">
                <div class="form-group pull-right">
                    <input class="btn btn-primary" type="submit" name="edit" value="Simpan Semua" required>                    
                </div>
            </div>

        </form>


        </div>

        



        <div class="card-footer">
        </div>

    </div>
</div>
</div>

<?php
}
?>

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