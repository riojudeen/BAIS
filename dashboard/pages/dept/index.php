<?php

//////////////////////////////////////////////////////////////////////
include("../../../config/config.php"); 

//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Department";
if(isset($_SESSION['user'])){

    include_once("../../header.php");
    
?>
<div class="collapse" id="tambah" data-toggle="collapse" aria-expanded="false" aria-controls="tambah">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color:#E7E5E5">
                    
                    <div class="pull-right">
                        <a href="<?=base_url('file/template/')?>Format_department.xlsx" class="btn btn-warning" ><i class="fa fa-times"></i> format</a>
                        <a href="" class="btn btn-info" data-toggle="collapse" data-target="#tambah" aria-expanded="false" aria-controls="dept"><i class="fa fa-times"></i> close</a>
                    </div>
                    <h5 class="">Tambah Data Department</h5>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Tambah Manual</a>
                            <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Import</a>
                            
                        </div>
                    </nav>
                
                </div>
                    
                <div class="card-body ">
                    <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
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
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <form class="form-inline" action="proses.php" method="post" enctype="multipart/form-data">
                            
                                <div class="form-group pull-right fileinput fileinput-new com-12" data-provides="fileinput">
                                        <span class="fileinput-preview"></span>
                                        <span class="btn btn-sm btn-link btn-raised btn-info btn-file">
                                            <span class="fileinput-new">Select File</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="file" id="file">
                                        </span>
                                            <a href="" class="btn bt-sm btn-danger btn-link fileinput-exists" data-dismiss="fileinput">
                                            <i class="fa fa-times"></i></a>
                                            <input type="submit" name="import" value="import" class="btn btn-primary fileinput-exists">
                                    
                                </div>
                                
                            </form>
                            
                        </div>
                    </div>           
                        
                
                
                    
                </div>
                
                <div class="card-footer">
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row ">
    <div class="col-md-12">       
        <div class="card">
            <form method="post" name="prosesdept">
                <div class="card-header ">
                
                    <h5 class="card-title pull-left">Daftar Department</h5>
                    <div class="box pull-right">
                        <a href="" type="button" class="btn btn-md btn-info" data-toggle="collapse" data-target="#tambah" aria-expanded="false" aria-controls="tambah"><i class="fa fa-plus"></i> Tambah</a>                         
                        <a href="../manpower.php" class="btn btn-default"><i class="nc-icon nc-bullet-list-67"></i> Data Manpower</a>                       
                        
                    </div>
                </div>
                <div class="card-body ">
                
                    <div class="table-responsive ">
                        <table class="table table-striped table-hover" id="table_dept" style="text-transform:uppercase;">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kode</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Koordinator / Dept Head</th>
                                    <th scope="col">NPK</th>
                                    
                                    
                                    <th scope="col">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="dept_all" id="dept_all" value="">
                                            <span class="form-check-sign"></span>                                                  
                                        </label>
                                    </div>
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sqldept = mysqli_query($link, "SELECT * FROM department
                                        LEFT JOIN karyawan ON department.npk_cord = karyawan.npk
                                        ORDER BY department.id_dept ASC") or die(mysqli_error($link));
                            $jml_dept = mysqli_num_rows($sqldept);
                            
                                                    
                            if($jml_dept > 0){
                                $no = 1;
                            while($dept = mysqli_fetch_assoc($sqldept)){
                                ?>                   
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$dept['id_dept']?></td>
                                    <td><?=$dept['dept']?></td>
                                    <td><?=$dept['nama']?></td>
                                    <td><?=$dept['npk']?></td>
                                    
                                    <?php
                                    echo "<td>";
                                    ?>
                                    <div class="form-check pull-rigth">
                                        <label class="form-check-label">
                                            <input class="deptcheck form-check-input" type="checkbox" name="deptchecked[]"
                                            value="<?=$dept['id_dept']?>">
                                            <span class="form-check-sign"></span>                                                    
                                        </label>
                                    </div>
                                    
                                    </td>
                                </tr>
                            <?php 
                            }
                            } else {
                                echo "<tr><td colspan=\"4\">tidak ada data ditemukan</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                
                </div>
                
                
                <div class="card-footer pull-right">
                    <div class="box">
                        <button class="btn btn-md btn-warning" onclick="edit()"><i class="fa fa-edit"></i> Edit <em class="text-danger">[checked]</em></button>
                        <button class="btn btn-md btn-danger" onclick="hapus()"><i class="fa fa-trash"></i> Delete <em class="text-warning">[checked]</em></button>
                            <br>
                    </div>
                        <div class="card-stats">
                        </div>
                </div>
            </form>
        </div>
        
    </div>
</div>




<script>
//untuk crud masal update department
    function edit() {
        document.prosesdept.action = 'edit.php';
        document.prosesdept.submit();
    }
    function hapus() {            
        var conf = confirm('yakin ingin menghapus data? ');
        if (conf) {
            document.prosesdept.action ='delete.php';
            document.prosesdept.submit();
        }        
    }
</script>
<script>
//untuk data tables

    $(document).ready(function(){
        $('#table_dept').DataTable({
            
            columnDefs: [
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": [0, 5]
                }
            ],
            "order": [1,"asc"]
        });
    })
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