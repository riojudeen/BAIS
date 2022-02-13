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
        <h5 class="pull-left">Tambah data Department</h5>
            <div class="pull-right">
                <a href="index.php" class="btn btn-default"><i class="nc-icon nc-bullet-list-67"></i> Data</a>
                <a href="generate.php" class="btn btn-default"><i class="nc-icon nc-minimal-left"></i> Reset Record</a>
            </div>
            
        </div>
        <div class="card-body ">
        <form class="form-inline" action="proses.php" method="post">
        <input type="text" class="form-control" name="total" value="<?=$_POST['count']?>">
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
                        for ($i=1; $i<=$_POST['count']; $i++){?>
                            <tr><td><?=$i?></td>
                            <td >
                                <input type="text" class="form-control" name="id-<?=$i?>" maxlength="5" id="kode" readonly required>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="dept-<?=$i?>" id="nama" required>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="npk-<?=$i?>" required>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="nama-<?=$i?>" required>
                            </td>
                            <td>
                            
                                <button class="btn btn-danger btn-icon"><i class="nc-icon nc-simple-remove"></i></button>
                            </td></tr>
                        <?php
                        }
                        ?>
                    </tbody>
                        
                </table>
                    
            </div>
            <div class="box col">
                <div class="form-group pull-right">
                    <input class="btn btn-primary" type="submit" name="add" value="Simpan Semua">
                </div>
            </div>

        </form>


        </div>

        



        <div class="card-footer">
        </div>

    </div>
</div>
</div>
<script type="text/javascript">
            function isi_otomatis(){
                var nim = $("#nama").val();
                $.ajax({
                    url: 'generate_id.php',
                    data:"nama="+nama ,
                }).success(function (data) {
                    var data = $('#kode').val($kode_dept);
                   
                });
            }
        </script>
</script>


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