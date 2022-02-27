<style>

    .view {
    margin: auto;
    width: 600px;
    }
    tr:hover td
    { background: #F4F4F4;
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
    width: 100px;
    min-width: 50px;
    max-width: 100px;
    left: 0px;
    
    }

    .first-top-col {
    width: 50px;
    min-width: 50px;
    max-width: 150px;
    top: 0px;
    z-index: 600;
    }

    .second-col {
    width: 50px;
    min-width: 50px;
    max-width: 150px;
    left: 50px;
    }
    .second-top-col {
    width: 20px;
    min-width: 20px;
    max-width: 150px;
    top: 0px;
    z-index: 600;
    }

    .third-col {
    width: 70px;
    min-width: 70px;
    max-width: 300px;
    left: 100px;
    }
    .third-top-col {
    width: 70px;
    min-width: 70px;
    max-width: 300px;
    top: 0px;
    z-index: 600;
    }
    .fourth-col {
    width: 300px;
    min-width: 300px;
    max-width: 300px;
    left: 170px;
    }
    .fourth-top-col {
    width: 300px;
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
<?php

require_once("../../../../config/config.php");
require_once("../../../../config/error.php");
require "../../../../_assets/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    if(isset($_FILES['file-excel']['name']) && in_array($_FILES['file-excel']['type'], $file_mimes)) {
    
        $arr_file = explode('.', $_FILES['file-excel']['name']);
        $extension = end($arr_file);
    
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $reader->load($_FILES['file-excel']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        //cek department akun
        $role_user = $_GET['role'];
        $q_user = mysqli_query($link, "SELECT * FROM user_role WHERE id_role = '$_GET[role]'")or die(mysqli_error($link));
        $leverl_user = mysqli_fetch_assoc($q_user);
        $dept_acc = $_GET['deptacc'];
        $dept = $_GET['dept'];
        $sect = $_GET['sect'];
        $group = $_GET['group'];
        $pos = $_GET['pos'];
        // 
        $status = ($_GET['stats'] !== 'notset')?$_GET['stats']:"belum diatur";
        $jabatan = ($_GET['jab'] !== 'notset')?$_GET['jab']:"belum diatur";
        $shift = ($_GET['groupshift'] !== 'notset')?$_GET['groupshift']:"belum diatur";
        // echo $dept;
        // echo $dept_acc;
        // echo $_GET['doccek'];
        if($_GET['dpass'] !== '1'){
            $displ = "";
        }else{
            $displ = "d-none";
        }
        // 
        if($dept_acc == 'notset'){
            $dataDeptAcc = 'belum diatur'; // diatur di dalam dokumen
            $dataDiv = "belum diatur"; //diatur di dalam dokumen
        }else{
            $q_deptAcc = mysqli_query($link, "SELECT view_cord_area.id AS id, 
            view_cord_area.nama_org AS nama_org, 
            view_cord_area.nama_cord AS nama_cord, 
            view_cord_area.id_parent AS id_parent, 
            division.id_div AS id_div, 
            division.nama_divisi AS nama_divisi 
            FROM view_cord_area LEFT JOIN division ON division.id_div = view_cord_area.id_parent WHERE view_cord_area.part = 'deptAcc' AND id = '$dept_acc' ")or die(mysqli_error($link));
            
            $sql_deptAcc = mysqli_fetch_assoc($q_deptAcc);
            $dataDeptAcc = (mysqli_num_rows($q_deptAcc)>0)?$sql_deptAcc['nama_org']:"belum diatur";
            $idDeptAcc = (mysqli_num_rows($q_deptAcc)>0)?$sql_deptAcc['id']:"belum diatur";

            $dataDiv = (mysqli_num_rows($q_deptAcc)>0)?$sql_deptAcc['nama_divisi']:"belum diatur";
            // data divisi
        }
        
        if($dept == 'notset' && $_GET['doccek'] !== '1'){
            $dataDept = "-";
        }else{
            $q_dept = mysqli_query($link, "SELECT nama_org, nama_cord FROM view_cord_area WHERE part = 'dept' AND id = '$dept' ")or die(mysqli_error($link));
            $sql_dept = mysqli_fetch_assoc($q_dept);
            $dataDept = (mysqli_num_rows($q_dept)>0)?$sql_dept['nama_org']:"belum diatur";
        }
        if($sect == 'notset' && $_GET['doccek'] !== '1'){
            $dataSect = "-";
        }else{
            $q_sect = mysqli_query($link, "SELECT nama_org, nama_cord FROM view_cord_area WHERE part = 'section' AND id = '$sect' ")or die(mysqli_error($link));
            $sql_sect = mysqli_fetch_assoc($q_sect);
            $dataSect = (mysqli_num_rows($q_sect)>0)?$sql_sect['nama_org']:"belum diatur";
        }
        if($group == 'notset' && $_GET['doccek'] !== '1'){
            $dataGroup = '-';
        }else{
            $q_group = mysqli_query($link, "SELECT nama_org, nama_cord FROM view_cord_area WHERE part = 'group' AND id = '$group' ")or die(mysqli_error($link));
            $sql_group = mysqli_fetch_assoc($q_group);
            $dataGroup = (mysqli_num_rows($q_group)>0)?$sql_group['nama_org']:"belum diatur";
        }

        if($pos == 'notset' && $_GET['doccek'] !== '1'){
            $dataPos = '-';
        }else{
            $q_pos = mysqli_query($link, "SELECT nama_org, nama_cord FROM view_cord_area WHERE part = 'pos' AND id = '$pos' ")or die(mysqli_error($link));
            $sql_pos = mysqli_fetch_assoc($q_pos);
            $dataPos = (mysqli_num_rows($q_pos)>0)?$sql_pos['nama_org']:"belum diatur";
        }
        
        if($_GET['doccek'] == '1'){
            $display = '';
        }else{
            $display = '';
        }
            ?>
        <div class="row">
            <div class="col-md-12">
            
                <h6>Employee Data & Organization</h6>
                <div class="row">
                    <div class="col-md-3">
                        <label for="" class="category">Department Account</label>
                        <div class="form-group no-border" style="background:rgba(255, 255, 255, 0.3)">
                            <input type="text" class="form-control no-border" name="derptAcc[]" readonly value="<?=$dataDeptAcc?>">
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <label for="" class="category">Status</label>
                        <div class="form-group no-border" style="background:rgba(255, 255, 255, 0.3)">
                            <input type="text" class="form-control no-border" name="dstatus" readonly value="<?=$status?>">
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <label for="" class="category">Jabatan</label>
                        <div class="form-group no-border" style="background:rgba(255, 255, 255, 0.3)">
                            <input type="text" class="form-control no-border" name="jabatan" readonly value="<?=$jabatan?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="" class="category">Group Shift</label>
                        <div class="form-group no-border" style="background:rgba(255, 255, 255, 0.3)">
                            <input type="text" class="form-control no-border" name="groupshift" readonly value="<?=$shift?>">
                        </div>
                    </div>
                    <div class="col-md-3 <?=$display?>">
                        <label for="" class="category">Department Functional</label>
                        <div class="form-group no-border" style="background:rgba(255, 255, 255, 0.3)">
                            <input type="text" class="form-control no-border" name="department" readonly value="<?=$dataDept?>">
                        </div>
                    </div>
                    <div class="col-md-3 <?=$display?>">
                        <label for="" class="category">Section</label>
                        <div class="form-group no-border" style="background:rgba(255, 255, 255, 0.3)">
                            <input type="text" class="form-control no-border" name="section" readonly value="<?=$dataSect?>">
                        </div>
                    </div>
                    <div class="col-md-3 <?=$display?>">
                        <label for="" class="category">Group</label>
                        <div class="form-group no-border" style="background:rgba(255, 255, 255, 0.3)">
                            <input type="text" class="form-control no-border" name="group" readonly value="<?=$dataGroup?>">
                        </div>
                    </div>
                    <div class="col-md-3 <?=$display?>">
                        <label for="" class="category">Pos Leader</label>
                        <div class="form-group no-border" style="background:rgba(255, 255, 255, 0.3)">
                            <input type="text" class="form-control no-border" name="group" readonly value="<?=$dataPos?>">
                        </div>
                    </div>
                </div>
                <h6>User Setting</h6>
                <div class="row">
                    <div class="col-md-3">
                        <label for="" class="category">Role User</label>
                        <div class="form-group no-border" style="background:rgba(255, 255, 255, 0.3)">
                            <input type="text" class="form-control no-border" name="role" readonly value="<?=$leverl_user['role_name']?>">
                        </div>
                    </div>
                    <div class="col-md-3 <?=$displ?>">
                        <label for="" class="category">password</label>
                        <div class="input-group no-border">
                            <input type="password" disabled class="form-control passw" name="pass" value="<?=$_GET['pass']?>"">
                            <div class="input-group-append">
                                <div class="input-group-text ">
                                    <i class="fa fa-eye mata2 d-none"></i>
                                    <i class="fa fa-eye-slash mata1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive text-left ">
            <table class="table table-hover text-uppercase">
                <thead class="table-info">
                    <th class="text-right first-top-col first-col sticky-col">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input checkAll" checked type="checkbox">
                            <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </th>
                    <th class="text-nowrap sticky-col second-col second-top-col">#</th>
                    <th class="text-nowrap sticky-col third-col third-top-col">Npk</th>
                    <th class="text-nowrap sticky-col fourth-col fourth-top-col">Nama</th>
                    <th class="text-nowrap">Tanggal Masuk</th>
                    <th class="text-nowrap">Jabatan</th>
                    <th class="text-nowrap">Status</th>
                    <th class="text-nowrap">Shift</th>
                    <th class="text-nowrap">pos Leader</th>
                    <th class="text-nowrap">Group</th>
                    <th class="text-nowrap">Section</th>
                    <th class="text-nowrap">Dept Functional</th>
                    <th class="text-nowrap">Dept Account</th>
                    <th class="text-nowrap">Division</th>
                    <th class="text-nowrap">Atasan Langsung</th>
                </thead>
            <tbody>
        </div>
        <?php
        $no = 1;
        for($i = 2;$i < count($sheetData);$i++){
            // jika menggunakan data dokumen
            if($_GET['doccek'] == '1'){
                $npk = $sheetData[$i]['1'];
                $nama = $sheetData[$i]['2'];
                $tglMasuk = $sheetData[$i]['6'];
                // employee data
                // jika data dikosongkan maka akan menggunakan data dokumen
                $status = ($status == 'belum diatur')?$sheetData[$i]['4']:$status;
                $jabatan = ($jabatan == 'belum diatur')?$sheetData[$i]['3']:$jabatan;
                $shift = ($shift == 'belum diatur')?$sheetData[$i]['5']:$shift;
                $deptacc = ($dataDeptAcc=='belum diatur')?$sheetData[$i]['11']:$idDeptAcc;
                // data organisasi

                // echo $deptac c;
                // menggunakan dokumen karena checkbox dicentang
                $pos = $sheetData[$i]['7'];
                $group = $sheetData[$i]['8'];
                $section = $sheetData[$i]['9'];
                $dept = $sheetData[$i]['10'];
                $id_area = $sheetData[$i]['12']; //id atasan
                // echo $dept;
                $q_deptAcc = mysqli_query($link, "SELECT id, nama_org, nama_cord FROM view_cord_area WHERE part = 'deptAcc' AND id = '$deptacc' ")or die(mysqli_error($link));
                $q_dept = mysqli_query($link, "SELECT id, nama_org, nama_cord, id_parent FROM view_cord_area WHERE part = 'dept' AND id = '$dept' ")or die(mysqli_error($link));
                $q_sect = mysqli_query($link, "SELECT id, nama_org, nama_cord FROM view_cord_area WHERE part = 'section' AND id = '$section' ")or die(mysqli_error($link));
                $q_group = mysqli_query($link, "SELECT id, nama_org, nama_cord FROM view_cord_area WHERE part = 'group' AND id = '$group' ")or die(mysqli_error($link));
                $q_pos = mysqli_query($link, "SELECT id, nama_org, nama_cord FROM view_cord_area WHERE part = 'pos' AND id = '$pos' ")or die(mysqli_error($link));
                
                $sql_deptAcc = mysqli_fetch_assoc($q_deptAcc);
                $sql_dept = mysqli_fetch_assoc($q_dept);
                $sql_sect = mysqli_fetch_assoc($q_sect);
                $sql_group = mysqli_fetch_assoc($q_group);
                $sql_pos = mysqli_fetch_assoc($q_pos);

                $dataDeptAcc = (mysqli_num_rows($q_deptAcc)>0)?$sql_deptAcc['nama_org']:"-";
                $dataDept = (mysqli_num_rows($q_dept)>0)?$sql_dept['nama_org']:"-";
                $dataSect = (mysqli_num_rows($q_sect)>0)?$sql_sect['nama_org']:"-";
                $dataGroup = (mysqli_num_rows($q_group)>0)?$sql_group['nama_org']:"-";
                $dataPos = (mysqli_num_rows($q_pos)>0)?$sql_pos['nama_org']:"";
                // mendapatkan id 
                $idDeptAcc = (mysqli_num_rows($q_deptAcc)>0)?$sql_deptAcc['id']:"";
                $idDept = (mysqli_num_rows($q_dept)>0)?$sql_dept['id']:"";
                $idSect = (mysqli_num_rows($q_sect)>0)?$sql_sect['id']:"";
                $idGroup = (mysqli_num_rows($q_group)>0)?$sql_group['id']:"";
                $idPos = (mysqli_num_rows($q_pos)>0)?$sql_pos['id']:"";

                // get divisi & plant
                // echo $sql_dept['id_parent'];
                $q_div = mysqli_query($link, "SELECT id, nama_org, nama_cord, id_parent FROM view_cord_area WHERE part = 'division' AND id = '$sql_dept[id_parent]' ")or die(mysqli_error($link));
                $s_div = mysqli_fetch_assoc($q_div);
                $q_plant = mysqli_query($link, "SELECT id_company, nama FROM company WHERE id_company = '$s_div[id_parent]' ")or die(mysqli_error($link));
                $s_plant = mysqli_fetch_assoc($q_plant);
                

                $dataDiv = (mysqli_num_rows($q_div)>0)?$s_div['nama_org']:"-";
                $dataPlant = (mysqli_num_rows($q_plant)>0)?$s_plant['nama']:"-";

                $idDiv = (mysqli_num_rows($q_div)>0)?$s_div['id']:"";
                $idPlant = (mysqli_num_rows($q_plant)>0)?$s_plant['id_company']:"";

                $id_area = cariID_area($idPos,$idGroup,$idSect,$idDept,$idDiv,$idPlant);
                $q_atasan = mysqli_query($link, "SELECT id, nama_org, cord, nama_cord, id_parent FROM view_cord_area WHERE id = '$id_area' ")or die(mysqli_error($link));
                $s_atasan = mysqli_fetch_assoc($q_atasan);
                $dataAtasan = (mysqli_num_rows($q_atasan)>0)?$s_atasan['nama_cord']:"-";
                $npkAtasan = (mysqli_num_rows($q_atasan)>0)?" - ".$s_atasan['cord']:"";
                // data user
                if($_GET['dpass'] !== '1'){
                    $pass = $_GET['pass'];
                }else{
                    $pass = default_password($tglMasuk);
                }
                $username = default_username($npk)
                
                
                 
                ?>
                <div class="">
                    <input type="hidden" name="npk[]" value="<?=$sql_dept['id_parent']?>">
                    <input type="hidden" name="name[]" value="<?=$nama?>">
                    <input type="hidden" name="tgl_masuk[]" value="<?=$tglMasuk?>">
                    <input type="hidden" name="jabatan[]" value="<?=$jabatan?>">
                    <input type="hidden" name="status[]" value="<?=$status?>">
                    <input type="hidden" name="shift[]" value="<?=$shift?>">
                    <input type="hidden" name="id_area[]" value="<?=$id_area?>">
                    <!-- untuk data organisasi -->
                    <input type="hidden" name="pos[]" value="<?=$idPos?>">
                    <input type="hidden" name="group[]" value="<?=$idGroup?>">
                    <input type="hidden" name="section[]" value="<?=$idSect?>">
                    <input type="hidden" name="dept[]" value="<?=$idDept?>">
                    <input type="hidden" name="division[]" value="<?=$idDiv?>">
                    <input type="hidden" name="plant[]" value="<?=$idPlant?>">
                    <input type="hidden" name="dept_account[]" value="<?=$idDeptAcc?>">
                    <input type="hidden" name="pass[]" value="<?=$pass?>">
                    <input type="hidden" name="username[]" value="<?=$username?>">
                    <input type="hidden" name="role[]" value="<?=$role_user?>">

                </div>

                    
                <tr>
                    <td class="sticky-col first-col">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input checkOne" type="checkbox" name="index[]" checked value="<?=$no?>">
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </td>
                    <td class="text-nowrap sticky-col second-col">
                        <?=$no?>
                    </td>
                    <td class="text-nowrap sticky-col third-col"><?=$npk?></td>
                    <td class="text-nowrap sticky-col fourth-col"><?=$nama?></td>
                    <td class="text-nowrap"><?=$tglMasuk?></td>
                    <td class="text-nowrap"><?=$jabatan?></td>
                    <td class="text-nowrap"><?=$status?></td>
                    <td class="text-nowrap"><?=$shift?></td>
                    <td class="text-nowrap"><?=$dataPos?></td>
                    <td class="text-nowrap"><?=$dataGroup?></td>
                    <td class="text-nowrap"><?=$dataSect?></td>
                    <td class="text-nowrap"><?=$dataDept?></td>
                    <td class="text-nowrap"><?=$dataDeptAcc?></td>
                    <td class="text-nowrap"><?=$dataDiv?></td>
                    <td class="text-nowrap"><?=$dataAtasan?><?=$npkAtasan?></td>
                </tr>
                
                <?php
                $no++;
            }else{
                // jika menggunakan data input form
                $npk = $sheetData[$i]['1'];
                $nama = $sheetData[$i]['2'];
                $tglMasuk = $sheetData[$i]['6'];
                // employee data
                $status = ($status == 'belum diatur')?$sheetData[$i]['4']:$status;
                $jabatan = ($jabatan == 'belum diatur')?$sheetData[$i]['3']:$jabatan;
                $shift = ($shift == 'belum diatur')?$sheetData[$i]['5']:$shift;
                $deptacc = ($dataDeptAcc=='belum diatur')?$sheetData[$i]['11']:$idDeptAcc;
                $id_division = $sheetData[$i]['12']; //id atasan
                $id_area = $sheetData[$i]['13']; //id atasan
                // data organisasi
                // echo $idDeptAcc;
                $dept = $_GET['dept'];
                $sect = $_GET['sect']; 
                $group = $_GET['group'];
                $pos = $_GET['pos'];
                
                $q_deptAcc = mysqli_query($link, "SELECT id, nama_org, nama_cord, id_parent FROM view_cord_area WHERE part = 'deptAcc' AND id = '$dept_acc' ")or die(mysqli_error($link));
                $q_dept = mysqli_query($link, "SELECT id, nama_org, nama_cord FROM view_cord_area WHERE part = 'dept' AND id = '$dept' ")or die(mysqli_error($link));
                $q_sect = mysqli_query($link, "SELECT id, nama_org, nama_cord FROM view_cord_area WHERE part = 'section' AND id = '$sect' ")or die(mysqli_error($link));
                $q_group = mysqli_query($link, "SELECT id, nama_org, nama_cord FROM view_cord_area WHERE part = 'group' AND id = '$group' ")or die(mysqli_error($link));
                $q_pos = mysqli_query($link, "SELECT id, nama_org, nama_cord FROM view_cord_area WHERE part = 'pos' AND id = '$pos' ")or die(mysqli_error($link));
                $sql_deptAcc = mysqli_fetch_assoc($q_deptAcc);
                $sql_dept = mysqli_fetch_assoc($q_dept);
                $sql_sect = mysqli_fetch_assoc($q_sect);
                $sql_group = mysqli_fetch_assoc($q_group);
                $sql_pos = mysqli_fetch_assoc($q_pos);
                // nama area organisasi
                $dataDeptAcc = (mysqli_num_rows($q_deptAcc)>0)?$sql_deptAcc['nama_org']:"-";
                $dataDept = (mysqli_num_rows($q_dept)>0)?$sql_dept['nama_org']:"-";
                $dataSect = (mysqli_num_rows($q_sect)>0)?$sql_sect['nama_org']:"-"; 
                $dataGroup = (mysqli_num_rows($q_group)>0)?$sql_group['nama_org']:"-";
                $dataPos = (mysqli_num_rows($q_pos)>0)?$sql_pos['nama_org']:"-";
                
                // id area organisasi
                $idDeptAcc = (mysqli_num_rows($q_deptAcc)>0)?$sql_deptAcc['id']:"";
                $idDept = (mysqli_num_rows($q_dept)>0)?$sql_dept['id']:"";
                $idSect = (mysqli_num_rows($q_sect)>0)?$sql_sect['id']:"";
                $idGroup = (mysqli_num_rows($q_group)>0)?$sql_group['id']:"";
                $idPos = (mysqli_num_rows($q_pos)>0)?$sql_pos['id']:"";

                if($dataDeptAcc == '-'){
                    $idDiv = $id_division;
                    $q_div = mysqli_query($link, "SELECT id, nama_org, nama_cord, id_parent FROM view_cord_area WHERE part = 'division' AND id = '$idDiv' ")or die(mysqli_error($link));

                }else{
                    $q_div = mysqli_query($link, "SELECT id, nama_org, nama_cord, id_parent FROM view_cord_area WHERE part = 'division' AND id = '$sql_deptAcc[id_parent]' ")or die(mysqli_error($link));
                }

                $s_div = mysqli_fetch_assoc($q_div);
                $q_plant = mysqli_query($link, "SELECT id_company, nama FROM company WHERE id_company = '$s_div[id_parent]' ")or die(mysqli_error($link));
                $s_plant = mysqli_fetch_assoc($q_plant);
                
                // data div dari dokumen
                

                $dataDiv = (mysqli_num_rows($q_div)>0)?$s_div['nama_org']:"-";
                $dataPlant = (mysqli_num_rows($q_plant)>0)?$s_plant['nama']:"-";
                $idDiv = (mysqli_num_rows($q_div)>0)?$s_div['id']:"";
                $idPlant = (mysqli_num_rows($q_plant)>0)?$s_plant['id_company']:"";
                // echo $id_division."<br>";
                $id_area = cariID_area($idPos,$idGroup,$idSect,$idDept,$idDiv,$idPlant);
                $q_atasan = mysqli_query($link, "SELECT id, nama_org, cord, nama_cord, id_parent FROM view_cord_area WHERE id = '$id_area' ")or die(mysqli_error($link));
                $s_atasan = mysqli_fetch_assoc($q_atasan);
                $dataAtasan = (mysqli_num_rows($q_atasan)>0)?$s_atasan['nama_cord']:"-";
                $npkAtasan = (mysqli_num_rows($q_atasan)>0)?" - ".$s_atasan['cord']:"";
                // data user
                if($_GET['dpass'] !== '1'){
                    $pass = $_GET['pass'];
                }else{
                    $pass = default_password($tglMasuk);
                }
                $username = default_username($npk)
                // 
                ?>
                <div class="">
                    <input type="hidden" name="npk[]" value="<?=$npk?>">
                    <input type="hidden" name="name[]" value="<?=$nama?>">
                    <input type="hidden" name="tgl_masuk[]" value="<?=$tglMasuk?>">
                    <input type="hidden" name="jabatan[]" value="<?=$jabatan?>">
                    <input type="hidden" name="status[]" value="<?=$status?>">
                    <input type="hidden" name="shift[]" value="<?=$shift?>">
                    <input type="hidden" name="id_area[]" value="<?=$id_area?>">
                    <!-- untuk data organisasi -->
                    <input type="hidden" name="pos[]" value="<?=$idPos?>">
                    <input type="hidden" name="group[]" value="<?=$idGroup?>">
                    <input type="hidden" name="section[]" value="<?=$idSect?>">
                    <input type="hidden" name="dept[]" value="<?=$idDept?>">
                    <input type="hidden" name="division[]" value="<?=$idDiv?>">
                    <input type="hidden" name="plant[]" value="<?=$idPlant?>">
                    <input type="hidden" name="dept_account[]" value="<?=$idDeptAcc?>">
                    <input type="hidden" name="pass[]" value="<?=$pass?>">
                    <input type="hidden" name="username[]" value="<?=$username?>">
                    <input type="hidden" name="role[]" value="<?=$role_user?>">

                </div>
                <tr>
                    <td class="sticky-col first-col">
                        <div class="form-check ">
                            <label class="form-check-label">
                                <input class="form-check-input checkOne" name="index[]" type="checkbox" value="<?=$no++?>" checked>
                            <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </td>
                    <td class="text-nowrap sticky-col second-col"><?=$no++?></td>
                    <td class="text-nowrap sticky-col third-col"><?=$npk?></td>
                    <td class="text-nowrap sticky-col fourth-col"><?=$nama?></td>
                    <td class="text-nowrap"><?=$tglMasuk?></td>
                    <td class="text-nowrap"><?=$jabatan?></td>
                    <td class="text-nowrap"><?=$status?></td>
                    <td class="text-nowrap"><?=$shift?></td>
                    <td class="text-nowrap"><?=$dataPos?></td>
                    <td class="text-nowrap"><?=$dataGroup?></td>
                    <td class="text-nowrap"><?=$dataSect?></td>
                    <td class="text-nowrap"><?=$dataDept?></td>
                    <td class="text-nowrap"><?=$dataDeptAcc?></td>
                    <td class="text-nowrap"><?=$dataDiv?></td>
                    <td class="text-nowrap"><?=$dataAtasan?><?=$npkAtasan?></td>
                </tr>

                <?php
    
            }
            
            $no++;

        }
       
    }else{
        // $_SESSION['info'] = "Kosong";
        // header("Location: ../manpower.php");
        ?>
        <h6 class="text-danger text-center">File Belum Dipilih / File Salah (Pastikan File Anda Adalah Format Excell Standar)</h6>
        <?php

    }
    
?>

    </tbody>
</table>
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
        $('.mata1').mousedown(function(){
            $('.mata2').removeClass('d-none')
            $('.mata1').addClass('d-none')
            $('.passw').removeAttr('type')
            $('.passw').attr('type','text')
        })
        $('.mata2').mouseup(function(){
            $('.mata1').removeClass('d-none')
            $('.mata2').addClass('d-none')
            $('.passw').removeAttr('type')
            $('.passw').attr('type','password')
        })
    })
</script>
<script>
$(document).ready(function(){
    $('.checkAll').on('click', function(){
        if(this.checked){
            $('.checkOne').each(function() {
                this.checked = true;
            })
        } else {
            $('.checkOne').each(function() {
                this.checked = false;
            })
        }
    });
    $('.checkOne').on('click', function() {
        if($('.checkOne:checked').length == $('.checkOne').length){
            $('.checkAll').prop('checked', true)
        } else {
            $('.checkAll').prop('checked', false)
        }
    })
})
</script>
