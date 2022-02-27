<?php
include("../../../config/config.php"); 
$_POST['count'] = 1;
?>

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
                            <td>
                                <input type="text" class="form-control" name="id-<?=$i?>" maxlength="2" id="id_dept" readonly >
                            </td>
                            <td>
                                <input type="text" class="form-control" name="dept-<?=$i?>" id="nama_dept" required>
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
        <script src="<?=base_url('assets/js/core/jquery.min.js')?>"></script>
<script src="<?=base_url('assets/js/core/popper.min.js')?>"></script>
<script src="<?=base_url('assets/js/core/bootstrap.min.js')?>"></script>
<script src="<?=base_url('assets/js/plugins/perfect-scrollbar.jquery.min.js')?>"></script>
<script src="<?=base_url('assets/js/plugins/moment.min.js')?>"></script>
<script>

function autofill(){
    var nama_dept = $("#nama_dept").val();
        $.ajax({
            type: "POST",
            url: "dept/generate_id.php",
            data: {nama_dept: nama_dept},
        }). success: function(msg){
                  $("#sect").html(msg)
            
        
    });
}
</script>