<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Employee Seting";
    include_once("../header.php");
?>
<style>

    .view {
    margin: auto;
    width: 600px;
    }

    .wrapper {
    position: relative;
    overflow: auto;
    border: 1px solid black;
    white-space: nowrap;
    }

    .sticky-col {
    position: -webkit-sticky;
    position: sticky;
    background-color: white;
    }

    .first-col {
    width: 50px;
    min-width: 50px;
    max-width: 100px;
    border: 1px solid black;
    left: 0px;
    }

    .first-top-col {
    width: 50px;
    min-width: 50px;
    max-width: 100px;
    top: 0px;
    z-index: 600;
    }

    .second-col {
    width: 100px;
    min-width: 100px;
    max-width: 150px;
    left: 50px;
    }
    .second-top-col {
    width: 100px;
    min-width: 100px;
    max-width: 150px;
    top: 0px;
    z-index: 600;
    }

    .third-col {
    width: 300px;
    min-width: 300px;
    max-width: 300px;
    left: 150px;
    }
    .third-top-col {
    width: 100px;
    min-width: 300px;
    max-width: 300px;
    top: 0px;
    z-index: 600;
    }

    .first-last-col {
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    right: 0px;
    }
    .first-last-top-col {
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    top: 0px;
    z-index: 600;
    }

    .second-last-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    right: 50px;
    }
    .second-last-top-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    top: 0px;
    z-index: 600;
    }
    th {
    background: white;
    position: sticky;
    top: 0;
    z-index: 500;
    }

</style>



<div class="collapse" id="collapseExample">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title pull-left">Import Data Excel</h5>
                    <div class="pull-right">
                        <a  class="btn btn-danger btn-icon btn-round btn-link" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a>
                    </div>
                </div>
                <hr>
                <div class="card-body text-center">
                    <form method="post" enctype="multipart/form-data" action="proses/import.php">
                        <div class="form-group border rounded ">
                            <div class="fileinput fileinput-new text-center " data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail mt-4 mx-0" style="min-width:300px">
                                    <input type="text" class="form-control mx-0">
                                </div>
                                <div>
                                    <span class="btn btn-outline-default btn-round btn-rose btn-file">
                                    <span class="fileinput-new ">Select File</span>
                                    <span class="fileinput-exists">Change</span>
                                        <input type="file"  name="file_import" />
                                    </span>
                                    <a href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right">Upload File Excel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- halaman utama -->

<div class="row">
<!-- menyimpan data flash -->
<div class="info-data" data-infodata="<?php if(isset($_SESSION['info'])){ echo $_SESSION['info']; } unset($_SESSION['info']); ?>" id="del"></div>
<!-- menyimpan data flash -->


<!-- modal tambah  -->

<div class="modal fade" id="generate" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="addMp.php" method="POST" id="RangeValidation">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h4 class="title title-up">Jumlah Record MP</h4>
                </div>
                <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        
                            <input type="text" name="count" class="form-control text-center" min="1" id="inputgenerate" placeholder="input record set" autofocus required>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <div class="left-side">
                        <button type="button" class="btn btn-default btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-danger btn-link">Generate</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal tambah -->
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header ">
                <h5 class="card-title pull-left">Daftar Man Power</h5>
                
                    <div class="box pull-right">
                        <a href="file/FormatUpdate_MP.xlsx" class="btn btn-warning btn-icon btn-round" data-toggle="tooltip" data-placement="bottom" title="Download Format">
                            <i class="nc-icon nc-paper"></i>
                        </a>
                        <button class="btn btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <span class="btn-label">
                                <i class="nc-icon nc-cloud-download-93"></i>
                            </span>
                        Import
                        </button>
                        
                        <a href="proses/export.php?export=mp" class="btn btn-success" name="export" data-toggle="tooltip" data-placement="bottom" title="Export to Excel File">
                            <span class="btn-label">
                                <i class="nc-icon nc-cloud-upload-94"></i>
                                
                            </span>
                            Export
                        </a>
                        <button class="btn btn-default" data-toggle="modal" data-target="#generate">
                        Add Data
                        </button>
                        
                    </div>
            </div>
            <hr>
            
            <?php
            $qry_organization = "SELECT
            org.npk AS npk_org,
            org.sub_post AS sub_post,
            org.post AS post,
            org.grp AS grp,
            org.sect AS sect,
            org.dept AS dept,
            org.dept_account AS dept_account,
            org.division AS division,
            org.plant AS plant,
           
            -- groupfrm.id_group AS id_group,
            -- groupfrm.nama_group AS nama_group,
            -- groupfrm.npk_cord AS cordinator_group,
            -- groupfrm.id_section AS parent_group,
            -- section.id_section AS id_section,
            -- section.section AS nama_section,
            -- section.npk_cord AS cordinator_section,
            -- section.id_dept AS parent_section,
            -- department.id_dept AS id_dept,
            -- department.dept AS nama_dept,
            -- department.npk_cord AS cordinator_dept,
            -- department.id_div AS parent_dept,
            -- dept_account.id_dept_account AS id_area,
            -- dept_account.department_account AS nama_area,
            -- dept_account.npk_dept AS cordinator, 
            -- dept_account.id_div AS id_parent,
            -- division.id_div AS id_division,
            -- division.nama_divisi AS nama_division,
            -- division.npk_cord AS cordinator_division,
            -- division.id_company AS parent_division,
            karyawan.npk AS npk,
            karyawan.nama AS nama,
            karyawan.shift AS shift,
            karyawan.jabatan AS jabatan,
            karyawan.tgl_masuk AS tgl_masuk,
            karyawan.status AS 'status'
            -- shift.id_shift AS id_shift,
            -- shift.shift AS nama_shift,
            -- jabatan.id_jabatan AS id_jabatan,
            -- jabatan.jabatan AS nama_jabatan, 
            -- jabatan.level AS level_jabatan
            FROM org 
            JOIN karyawan ON karyawan.npk = org.npk
            LIMIT 10
            -- JOIN pos_leader ON org.post = pos_leader.id_post
            -- JOIN groupfrm ON org.grp = groupfrm.id_group
            -- JOIN section ON org.sect = section.id_section
            -- JOIN department ON org.dept = department.id_dept
            -- JOIN dept_account ON org.dept_account = dept_account.id_dept_account
            -- JOIN division ON org.division = division.id_div
            -- JOIN shift  ON karyawan.shift = shift.id_shift
            -- JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan
            ";

            $sql_organization = mysqli_query($link, $qry_organization)or die(mysqli_error($link));
            $jml_ = mysqli_num_rows($sql_organization);
            echo $jml_;

            
            $batas = (isset($_SESSION['sort']))? $_SESSION['sort'] : 50;
            $hal = @$_GET['hal'];
            
            if(empty($hal)){
                $posisi = 0;
                $hal = 1;
            } else {                 
                $posisi = ($hal - 1) * $batas; 
            }


            
            if(isset($data)){
                $totalData = count($data);
            }else{
                $totalData = 0;
            }
            
            
            if(isset($_POST['cari'])){
                $_SESSION['sort'] = $totalData;
            }else if(isset($_POST['go'])){
                if($_POST['sort'] <= $totalData && $_POST['sort'] > 0){
                    $_SESSION['sort'] = $_POST['sort'];
                }else if($_POST['sort'] <= 0){
                    $_SESSION['sort'] = 1;
                }else{
                    $_SESSION['sort'] = $totalData;
                }
            }else{
                $_SESSION['sort'] = $batas;
            }
            $sort = (isset($_SESSION['sort']))? $_SESSION['sort'] : $batas;

                
            
           
            ?>
                <div class="row ">
                    <div class="col-md-12">
                        <div class="collapse" id="collapseOne">
                            <div class="card card-plain">
                                <div class="card-header">
                                    <h5 class="card-title pull-left"></h5>
                                    <div class="pull-right">
                                        <a  class="btn btn-danger btn-icon btn-round btn-link" data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data" action="proses/import.php">
                                        <button type="submit" class="btn btn-primary pull-right">save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    
                    <form method="POST">
                    <div class="col-sm-7 pull-left">
                        <div class="row">
                            <label class="ml-3 col-form-label col-sm-1 pl-0">Sort</label>
                            <div class="col-sm-2 px-0">
                                <div class="form-group">
                                <input type="number" name="sort" class="form-control" value="<?=$sort?>">
                                </div>
                            </div>
                            <label class="ml-2 col-form-label pl-0 mr-3">/ <?=$totalData?></label>
                            
                            <!-- <div class="col-md-2 px-0">
                                <div class="form-group">
                                <input type="button"  class="btn btn-warning my-0 " value="Filter" data-toggle="collapse"  href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                </div>
                            </div> -->
                            <div class="col-md-1 px-0">
                                <div class="form-group">
                                <input type="submit" name="go" class="btn btn-primary my-0 btn-round btn-icon" value="go">
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    <form method="POST">
                    <div class="box pull-right">
                        <div class="input-group no-border">
                            <input type="text" name="cari" class="form-control" placeholder="Cari nama atau npk..">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="nc-icon nc-zoom-split"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    
                    
                    <form method="post" name="prosesmp" action="" >
                        <div class="table-responsive" style="min-height:500px">
                            <table class="table text-nowrap table-bordered" id="table_mp">
                                <thead>
                                    <tr>
                                        <th scope="col" class="sticky-col first-col first-top-col">No</th>
                                        <th scope="col" class="sticky-col second-col second-top-col">NPK</th>
                                        <th scope="col" class="sticky-col third-col third-top-col">Nama</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Jabatan</th>
                                        <th scope="col">Tanggal Masuk</th>
                                        <th scope="col">Shift</th>
                                        <th scope="col">Area / Pos</th>
                                        <th scope="col">Group</th>
                                        <th scope="col">Section</th>
                                        <th scope="col">Dept</th>
                                        <th scope="col">Dept Account</th>
                                        <th scope="col">Division</th>
                                        <th scope="col">Plant</th>
                                        <th scope="col" class="sticky-col second-last-col second-last-top-col">Action</th>
                                        <th scope="col" class="sticky-col first-last-col first-last-top-col">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" id="allmp">
                                                <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                if($jml_ > 0){
                                    while($data = mysqli_fetch_assoc($sql_organization)){
                                        $pos = mysqli_fetch_assoc(mysqli_query($link, "SELECT nama_pos, id_post FROM pos_leader WHERE id_post = '$data[post]' "));
                                        ?>
                                        <tr>
                                        <td class="sticky-col first-col"><?=$i++?></td>
                                        <td class="sticky-col second-col"><?=$data['npk']?></td>
                                        <td class="sticky-col third-col"><?=$data['nama']?></td>
                                        <td ><?=$data['status']?></td>
                                        <td ><?=$data['jabatan']?></td>
                                        <td ><?=$data['tgl_masuk']?></td>
                                        <td ><?=$data['shift']?></td>
                                        <?php
                                        // $pos_leader = (!empty($data[$i]['pos']))? $data[$i]['pos'] : "-";
                                        // $groupfrm = (!empty($data[$i]['groupfrm']))? $data[$i]['groupfrm'] : "-"; 
                                        // $section = (!empty($data[$i]['section']))? $data[$i]['section'] : "-"; 
                                        // $department = (!empty($data[$i]['dept']))? $data[$i]['dept'] : "-"; 
                                        // $dept_Account = (!empty($data[$i]['deptAcc']))? $data[$i]['deptAcc'] : "-"; 
                                        // $division = (!empty($data[$i]['divisi']))? $data[$i]['divisi'] : "-"; 
                                        
                                        
                                        ?>
                                        <td ><?=$pos['nama_pos']?></td>
                                        <td ><?=$data['grp']?></td>
                                        <td ><?=$data['sect']?></td>
                                        <td ><?=$data['dept']?></td>
                                        <td ><?=$data['dept_account']?></td>
                                        <td ><?=$data['division']?></td>
                                        <td ><?=$data['plant']?></td>
                                        <td class="sticky-col second-last-col">
                                            <a href="edit_mp.php?edit=<?=$data['npk']?>" class="btn btn-warning btn-icon btn-sm edit"><i      
                                                class="fa fa-edit"></i></a>
                                            <a href="proses/proses.php?del=<?=$data['npk']?>" class="btn btn-danger btn-icon btn-sm remove del"><i     
                                                class="fa fa-times"></i></a>
                                        </td>
                                        <td class="sticky-col first-last-col">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input mp" name="mpchecked[]" type="checkbox" value="<?=$data['npk']?>">
                                                <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </td>
                                        </tr>

                                        <?php
                                    }
                                }else{
                                    ?>
                                    <tr>
                                        <td class="bg-light text-center" colspan="16">0 Data ditemukan di Database</td>
                                    </tr>
                                    <?php
                                }
                                
                                ?>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-success editall">
                            <span class="btn-label">
                                <i class="nc-icon nc-check-2"></i>
                            </span>
                            Edit
                        </button>
                        <!-- <button class="btn btn-warning">
                            <i class="nc-icon nc-zoom-split"></i>
                            Warning
                        </button> -->
                        <button  class="btn btn-danger delete" >
                            <span class="btn-label">
                                <i class="nc-icon nc-simple-remove" ></i>
                            </span>    
                            Delete
                        </button>
                    </div>
                </form>
            </div>
            <hr>
            <div class="card-footer">
            <?php
            /////////////////////////////////pagination//////////////////
            if(empty($_POST['cari'])){?>
                <div >
                <?php
                    $jml = $totalData;
                    echo "<h6 class=\"pull-left\">Jumlah data :  $jml</h6>";
                    ?>
                </div>
                
                    
                <?php
                $jml_hal = ceil($jml / $sort);
                $index_hal = 2;
                $start = ($hal > $index_hal) ? $hal - $index_hal : 1;
                $end = ($hal < ($jml_hal - $index_hal)) ? $hal + $index_hal : $jml_hal;
                
                $next = $hal + 1;
                ?>
                <div class="pull-right">
                    <ul class="pagination pagination-sm">
                <?php
                if($hal == 1){
                    echo '<li class="page-item disabled"><a class="page-link btn-primary" href="#" aria-label="Previous">FIRST</a></li>';
                    echo '<li class="page-item disabled"><a class="page-link btn-primary" href="#" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span></a></li>';
                
                } else{
                    $prev = ($hal > 1)? $hal - 1 : 1;
                    echo '<li class="page-item"><a class="page-link btn-primary" href="?hal=1" aria-label="Previous">FIRST</a></li>';
                    echo '<li class="page-item"><a class="page-link btn-primary" href="?hal='.$prev.'" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span></a></li>';
                }
                for($i = $start; $i <= $end; $i++){
                    $link_active = ($hal == $i)? ' active' : '';
                    echo "<li class=\"page-item $link_active\"><a href=\"?hal=$i\" class=\"page-link btn-primary btn-link\"\">$i</a></li>";
                }
                if($hal == $jml_hal){
                    echo "<li class=\"page-item disabled\"><a class=\"page-link btn-primary btn-link\" href=\"#\"><i class=\"fa fa-angle-double-right\" aria-hidden=\"true\"></i></a></li>";
                    echo "<li class=\"page-item disabled\"><a class=\"page-link btn-primary btn-link\" href=\"#\">LAST</a></li>";
                } else{
                    echo "<li class=\"page-item\"><a class=\"page-link btn-primary btn-link\" href=\"?hal=$next\"><i class=\"fa fa-angle-double-right\" aria-hidden=\"true\"></i></a></li>";
                    echo "<li class=\"page-item\"><a class=\"page-link btn-primary btn-link\" href=\"?hal=$jml_hal\">LAST</a></li>";
                }
                ///////////////////////////////////////////////////////////////
            } else { 
                $_GET['cari'] = 1;
                $jml = $totalData;
                echo "<h6 class=\"pull-left\">ditemukan <strong>$jml</strong> hasil pencarian ";
                echo "</h6>";
            }
            
            ?>
                        
                    
                    </ul>
                </div>
            <?php
            ?>    
            </div>
            
        </div>
    </div>
</div>
<?php
// tutup koneksi dengan database mysql
mysqli_close($link);

    include_once("../footer.php");
    //javascript
    ?>
    
    <script>
    $('#generate').on('shown.bs.modal', function () {
    $('#inputgenerate').focus()
    })
    </script>
    <!-- select masal -->
    <script>
        $(document).ready(function(){
            $('#allmp').on('click', function() {
                if(this.checked){
                    $('.mp').each(function() {
                        this.checked = true;
                    })
                } else {
                    $('.mp').each(function() {
                        this.checked = false;
                    })
                }

            });

            $('.mp').on('click', function() {
                if($('.mp:checked').length == $('.mp').length){
                    $('#allmp').prop('checked', true)
                } else {
                    $('#allmp').prop('checked', false)
                }
            })
        })
    </script>

    <!-- untuk proses tombol edit & delete masal -->
    <script>
    //untuk crud masal update department

        $('.delete').on('click', function(e){
            e.preventDefault();
            var getLink = 'proses/mass_del.php';
                
            Swal.fire({
            title: 'Anda Yakin ?',
            text: "Semua data yang dicheck / centang akan dihapus permanent",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF5733',
            cancelButtonColor: '#B2BABB',
            confirmButtonText: 'Yes, delete!'
            }).then((result) => {
                if (result.value) {
                    document.prosesmp.action = getLink;
                    document.prosesmp.submit();
                }
            })
            
        });
        $('.editall').on('click', function(e){
            e.preventDefault();
            var getLink = 'mass_editMp.php';

            document.prosesmp.action = getLink;
            document.prosesmp.submit();
        }); 
    </script>
    <script>
        $(document).ready(function(){
            $('#allmp').on('click', function() {
                if(this.checked){
                    $('.mp').each(function() {
                        this.checked = true;
                    })
                } else {
                    $('.mp').each(function() {
                        this.checked = false;
                    })
                }

            });

            $('.mp').on('click', function() {
                if($('.mp:checked').length == $('.mp').length){
                    $('#allmp').prop('checked', true)
                } else {
                    $('#allmp').prop('checked', false)
                }
            })
        })
    </script>

    <!-- untuk proses tombol edit & delete masal -->
    <script>
    //untuk crud masal update department
        $('.delete').on('click', function(e){
            e.preventDefault();
            var getLink = 'proses/mass_del.php';
                
            Swal.fire({
            title: 'Anda Yakin ?',
            text: "Semua data yang dicheck / centang akan dihapus permanent",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF5733',
            cancelButtonColor: '#B2BABB',
            confirmButtonText: 'Yes, delete!'
            }).then((result) => {
                if (result.value) {
                    document.prosesmp.action = getLink;
                    document.prosesmp.submit();
                }
            })
            
        });
        $('.editall').on('click', function(e){
            e.preventDefault();
            var getLink = 'mass_editMp.php';

            document.prosesmp.action = getLink;
            document.prosesmp.submit();
        }); 
    </script>

    <?php
    include_once("../endbody.php"); 

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
