<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Man Power Management Seting";
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
                
                
                
                
                <!-- <span class="pull-right">
                    <form class="form-inline" action="" method="post">
                        <div class="input-group no-border">
                            <input type="text" name="pencarian" class="form-control" placeholder="Search...">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <button type="submit" class="btn btn-sm my-0 btn-link btn-icon" aria-hidden="true"><i class="nc-icon nc-zoom-split"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </span> -->
            </div>
            <hr>
            
            <?php
            // echo union();
            // echo tes('try');
            

            $sComp = mysqli_query($link, "SELECT * FROM company WHERE id_company = '1'")or die(mysqli_error($link));
            $jDiv = mysqli_query($link, "SELECT * FROM division WHERE id_company = '1' ")or die(mysqli_error($link));
            $jDept = mysqli_query($link, "SELECT * FROM department")or die(mysqli_error($link));
            $jSect = mysqli_query($link, "SELECT * FROM section")or die(mysqli_error($link));
            $jGroup = mysqli_query($link, "SELECT * FROM groupfrm")or die(mysqli_error($link));
            $jPos = mysqli_query($link, "SELECT * FROM pos_leader")or die(mysqli_error($link));
            $jmlDiv = mysqli_num_rows($jDiv);
            $jmlDept = mysqli_num_rows($jDept);
            $jmlSect = mysqli_num_rows($jSect);
            $jmlGroup = mysqli_num_rows($jGroup);
            $jmlPos = mysqli_num_rows($jPos);
            

            $batas = (isset($_SESSION['sort']))? $_SESSION['sort'] : 50;
            $hal = @$_GET['hal'];
            
            if(empty($hal)){
                $posisi = 0;
                $hal = 1;
            } else {                 
                $posisi = ($hal - 1) * $batas; 
            }
            
            ////////////////////////////////////////////
            if(isset($_POST['cari'])){
                //jika ada masukan parameter hasil pencarian kedalam variabel $pencarian
                $pencarian = trim(mysqli_real_escape_string($link, $_POST['cari']));
                //jika pencarian ada, masukan hasil queri pencarian ke dalam variabel query jumlah
                if($pencarian !== ''){
                    $sql = "SELECT * FROM karyawan WHERE npk LIKE '%$pencarian%'or nama LIKE '%$pencarian%'";
                    $query_mp = $sql;
                    // $queryjml = $sql;

                    $noo = 1;
                    $queryMp = mysqli_query($link, $sql)or die(mysqli_error($link));
                    while($dataMp = mysqli_fetch_assoc($queryMp)){
                        $union = mysqli_query($link, "SELECT id_div AS id , nama_divisi AS nama_org , npk_cord AS cord , id_company AS id_parent , part AS part FROM division WHERE id_div='$dataMp[id_area]'
                                UNION ALL SELECT id_dept AS id , dept AS nama_org , npk_cord AS cord , id_div AS id_parent, part AS part FROM department WHERE id_dept='$dataMp[id_area]'
                                UNION ALL SELECT id_section AS id , section AS nama_org , npk_cord AS cord , id_dept AS id_parent, part AS part FROM section WHERE id_section='$dataMp[id_area]'
                                UNION ALL SELECT id_group AS id , nama_group AS nama_org , npk_cord AS cord , id_section AS id_parent, part AS part FROM groupfrm WHERE id_group='$dataMp[id_area]'
                                UNION ALL SELECT id_post AS id , nama_pos AS nama_org , npk_cord AS cord , id_group AS id_parent, part AS part FROM pos_leader WHERE id_post='$dataMp[id_area]'")or die(mysqli_error($link));
                        $dataUnion = mysqli_fetch_assoc($union);
                        if($dataUnion['part'] == 'division'){
                            $qDiv = mysqli_query($link, 
                            "SELECT 
                            company.id_company AS idCompany, 
                            company.nama AS namaCompany , 
                            company.npk_cord AS directure,
                            division.id_div AS idDiv, 
                            division.nama_divisi AS divisi, 
                            division.npk_cord AS dh, 
                            division.id_company AS id_company,
                            
                            karyawan.npk AS npk, 
                            karyawan.nama AS nama, 
                            karyawan.tgl_masuk AS tgl_masuk, 
                            karyawan.jabatan AS jabatanMp, 
                            karyawan.shift AS shift, 
                            karyawan.status AS `status`, 
                            karyawan.department AS deptMp, 
                            karyawan.id_area AS id_area,
                            jabatan.id_jabatan AS id_jab, 
                            jabatan.jabatan AS nama_jab , 
                            jabatan.level AS level_jab
                            FROM karyawan 
                            LEFT JOIN division ON division.id_div = karyawan.id_area
                            LEFT JOIN company ON company.id_company = division.id_company
                            LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan 
                            LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account 
                            WHERE karyawan.npk = '$dataMp[npk]' ORDER BY level_jab ASC")or die(mysqli_error($link));
                            if(mysqli_num_rows($qDiv) > 0){
                                while($dataMpDiv = mysqli_fetch_assoc($qDiv)){
                                    $data[$noo++] = $dataMpDiv;
                                }
                            }
                        }else if($dataUnion['part'] == 'dept'){
                            $qDept = mysqli_query($link, 
                            "SELECT 
                            company.id_company AS idCompany, 
                            company.nama AS namaCompany , 
                            company.npk_cord AS directure,
                            division.id_div AS idDiv, 
                            division.nama_divisi AS divisi, 
                            division.npk_cord AS dh, 
                            division.id_company AS id_company,
                            dept_account.id_dept_account AS idDeptAcc, 
                            dept_account.department_account AS deptAcc, 
                            dept_account.npk_dept AS mg, 
                            dept_account.id_div AS id_div,
                            department.id_dept AS idDept, 
                            department.dept AS dept, 
                            department.npk_cord AS dept_cord, 
                            department.id_div AS id_div,
                            karyawan.npk AS npk, 
                            karyawan.nama AS nama, 
                            karyawan.tgl_masuk AS tgl_masuk, 
                            karyawan.jabatan AS jabatanMp, 
                            karyawan.shift AS shift, 
                            karyawan.status AS `status`, 
                            karyawan.department AS deptMp, 
                            karyawan.id_area AS id_area,
                            jabatan.id_jabatan AS id_jab, 
                            jabatan.jabatan AS nama_jab , 
                            jabatan.level AS level_jab
                            FROM karyawan 
                            LEFT JOIN department ON karyawan.id_area = department.id_dept
                            LEFT JOIN division ON division.id_div = department.id_div
                            LEFT JOIN company ON company.id_company = division.id_company
                            LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan 
                            LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account 
                            WHERE karyawan.npk = '$dataMp[npk]' ORDER BY level_jab ASC")or die(mysqli_error($link));
                            if(mysqli_num_rows($qDept) > 0){
                                while($dataMp = mysqli_fetch_assoc($qDept)){
                                    $data[$noo++] = $dataMp; 
                                }
                            }else{
                                // echo "<tr>";
                                // echo "<td colspan=\"16\">TIDAK DITEMUKAN DATA MAN POWER $d_Dept[dept]  di Database</td>";
                                // echo "</tr>";
                            }
                        }else if($dataUnion['part'] == 'section'){
                            $mpSect = mysqli_query($link, " SELECT 
                            company.id_company AS idCompany,
                            company.nama AS namaCompany ,
                            company.npk_cord AS directure,

                            division.id_div AS idDiv,
                            division.nama_divisi AS divisi,
                            division.npk_cord AS dh,
                            division.id_company AS id_company,

                            dept_account.id_dept_account AS idDeptAcc,
                            dept_account.department_account AS deptAcc,
                            dept_account.npk_dept AS mg, 
                            dept_account.id_div AS id_div,

                            department.id_dept AS idDept,
                            department.dept AS dept,
                            department.npk_cord AS dept_cord,
                            department.id_div AS id_div,

                            section.id_section AS idSect,
                            section.section AS section,
                            section.npk_cord AS spv,
                            section.id_dept AS id_dept,

                            karyawan.npk AS npk,
                            karyawan.nama AS nama,
                            karyawan.tgl_masuk AS tgl_masuk,
                            karyawan.jabatan AS jabatanMp,
                            karyawan.shift AS shift,
                            karyawan.status AS `status`,
                            karyawan.department AS deptMp,
                            karyawan.id_area AS id_area,

                            jabatan.id_jabatan AS id_jab,
                            jabatan.jabatan AS nama_jab ,
                            jabatan.level AS level_jab

                            FROM karyawan 
                            LEFT JOIN section ON section.id_section = karyawan.id_area
                            LEFT JOIN department ON section.id_dept = department.id_dept
                            LEFT JOIN division ON department.id_div = division.id_div 
                            LEFT JOIN company ON division.id_company = company.id_company
                            LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account
                            LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan
                            WHERE karyawan.npk = '$dataMp[npk]' ORDER BY level_jab ASC
                            ")or die(mysqli_error($link));
                            $countMpSect = mysqli_num_rows($mpSect);
                            //cetak mp dengan id section 
                            if($countMpSect > 0){
                                while($dataMpSect = mysqli_fetch_assoc($mpSect)){
                                    $data[$noo++] = $dataMpSect; 
                                    
                                }
                        
                            }else{
                                // echo "<tr>";
                                // echo "<td colspan=\"16\">TIDAK DITEMUKAN DATA MAN POWER $dSect[section] di Database</td>";
                                // echo "</tr>";
                            }
                        }else if($dataUnion['part'] == 'group'){
                            $s_MpGroup = mysqli_query($link, " SELECT 
                            company.id_company AS idCompany,
                            company.nama AS namaCompany ,
                            company.npk_cord AS directure,

                            division.id_div AS idDiv,
                            division.nama_divisi AS divisi,
                            division.npk_cord AS dh,
                            division.id_company AS id_company,

                            dept_account.id_dept_account AS idDeptAcc,
                            dept_account.department_account AS deptAcc,
                            dept_account.npk_dept AS mg, 
                            dept_account.id_div AS id_div,

                            department.id_dept AS idDept,
                            department.dept AS dept,
                            department.npk_cord AS dept_cord,
                            department.id_div AS id_div,

                            section.id_section AS idSect,
                            section.section AS section,
                            section.npk_cord AS spv,
                            section.id_dept AS id_dept,

                            groupfrm.id_group AS idGroup,
                            groupfrm.nama_group AS groupfrm,
                            groupfrm.npk_cord AS group_cord,
                            groupfrm.id_section AS id_sect,

                            karyawan.npk AS npk,
                            karyawan.nama AS nama,
                            karyawan.tgl_masuk AS tgl_masuk,
                            karyawan.jabatan AS jabatanMp,
                            karyawan.shift AS shift,
                            karyawan.status AS `status`,
                            karyawan.department AS deptMp,
                            karyawan.id_area AS id_area,

                            jabatan.id_jabatan AS id_jab,
                            jabatan.jabatan AS nama_jab ,
                            jabatan.level AS level_jab

                            FROM karyawan 
                            LEFT JOIN groupfrm ON karyawan.id_area = groupfrm.id_group 
                            LEFT JOIN section ON section.id_section = groupfrm.id_section
                            LEFT JOIN department ON section.id_dept = department.id_dept
                            LEFT JOIN division ON department.id_div = division.id_div 
                            LEFT JOIN company ON division.id_company = company.id_company
                            LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account
                            LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan
                            WHERE karyawan.npk = '$dataMp[npk]' ORDER BY level_jab ASC
                            ")or die(mysqli_error($link));
                            $countMpGroup = mysqli_num_rows($s_MpGroup);
                            if($countMpGroup > 0){
                                while($dataMpGroup = mysqli_fetch_assoc($s_MpGroup)){
                                    $data[$noo++] = $dataMpGroup; 
                                }
                                
                            }else{
                                // echo "<tr>";
                                // echo "<td colspan=\"16\">TIDAK DITEMUKAN DATA MAN POWER $dGroup[nama_group] di Database</td>";
                                // echo "</tr>";
                            }
                        }else{
                            $s_MpPos = mysqli_query($link, " SELECT 
                            company.id_company AS idCompany,
                            company.nama AS namaCompany ,
                            company.npk_cord AS directure,

                            division.id_div AS idDiv,
                            division.nama_divisi AS divisi,
                            division.npk_cord AS dh,
                            division.id_company AS id_company,

                            dept_account.id_dept_account AS idDeptAcc,
                            dept_account.department_account AS deptAcc,
                            dept_account.npk_dept AS mg, 
                            dept_account.id_div AS id_div,

                            department.id_dept AS idDept,
                            department.dept AS dept,
                            department.npk_cord AS dept_cord,
                            department.id_div AS id_div,

                            section.id_section AS idSect,
                            section.section AS section,
                            section.npk_cord AS spv,
                            section.id_dept AS id_dept,

                            groupfrm.id_group AS idGroup,
                            groupfrm.nama_group AS groupfrm,

                            groupfrm.npk_cord AS group_cord,
                            groupfrm.id_section AS id_sect,

                            pos_leader.id_post AS idPost,
                            pos_leader.nama_pos AS pos,
                            pos_leader.npk_cord AS post_cord,
                            pos_leader.id_group AS leader,

                            karyawan.npk AS npk,
                            karyawan.nama AS nama,
                            karyawan.tgl_masuk AS tgl_masuk,
                            karyawan.jabatan AS jabatanMp,
                            karyawan.shift AS shift,
                            karyawan.status AS `status`,
                            karyawan.department AS deptMp,
                            karyawan.id_area AS id_area,

                            jabatan.id_jabatan AS id_jab,
                            jabatan.jabatan AS nama_jab ,
                            jabatan.level AS level_jab

                            FROM karyawan LEFT JOIN pos_leader ON karyawan.id_area = pos_leader.id_post
                            LEFT JOIN groupfrm ON pos_leader.id_group = groupfrm.id_group 
                            LEFT JOIN section ON section.id_section = groupfrm.id_section
                            LEFT JOIN department ON section.id_dept = department.id_dept
                            LEFT JOIN division ON department.id_div = division.id_div 
                            LEFT JOIN company ON division.id_company = company.id_company
                            LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account
                            LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan
                            WHERE karyawan.npk = '$dataMp[npk]' ORDER BY level_jab ASC
                            ")or die(mysqli_error($link));
                            $countMpPos = mysqli_num_rows($s_MpPos);
                            if($countMpPos > 0){
                                //cari data Mp Pos
                                while($dataMpPos = mysqli_fetch_assoc($s_MpPos)){
                                    $data[$noo++] = $dataMpPos; 
                                    
                                }
                                
                            }else{
                                // echo "<tr>";
                                // echo "<td colspan=\"16\">TIDAK DITEMUKAN DATA MAN POWER $dPos[nama_pos] di Database</td>";
                                // echo "</tr>";
                            }
                        }
                    }
                //jika inputan kosong , masukkan  nilai posisi + 1 ke dalam no    
                } else{
                    // $query_mp = "SELECT * FROM karyawan LIMIT $posisi, $batas";
                    // $queryjml = "SELECT * FROM karyawan";
                    // $no = $posisi + 1;
                    
                    ////////////////////////////////////////////jika tidak ada pencarian
                    // echo tes('try');
                    
                    $noo = 1;
                    if($jmlDiv > 0){
                        //mendapatkan nilai department
                        //ubah code divisi untuk divisi selain body
                        $s_Div= mysqli_query($link, "SELECT * FROM division WHERE id_company = '1' ORDER BY id_div ASC")or die(mysqli_error($link));
                        
                        while($d_Div = mysqli_fetch_assoc($s_Div)){
                            //mendapatkan data karyawan yang memiliki id department , termasuk manager s.d TM
                            $qDiv = mysqli_query($link, 
                            "SELECT 
                            company.id_company AS idCompany, 
                            company.nama AS namaCompany , 
                            company.npk_cord AS directure,
                            division.id_div AS idDiv, 
                            division.nama_divisi AS divisi, 
                            division.npk_cord AS dh, 
                            division.id_company AS id_company,
                            
                            karyawan.npk AS npk, 
                            karyawan.nama AS nama, 
                            karyawan.tgl_masuk AS tgl_masuk, 
                            karyawan.jabatan AS jabatanMp, 
                            karyawan.shift AS shift, 
                            karyawan.status AS `status`, 
                            karyawan.department AS deptMp, 
                            karyawan.id_area AS id_area,
                            jabatan.id_jabatan AS id_jab, 
                            jabatan.jabatan AS nama_jab , 
                            jabatan.level AS level_jab
                            FROM karyawan 
                            LEFT JOIN division ON division.id_div = karyawan.id_area
                            LEFT JOIN company ON company.id_company = division.id_company
                            LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan 
                            LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account 
                            WHERE karyawan.id_area = '$d_Div[id_div]' ORDER BY level_jab ASC")or die(mysqli_error($link));
                            if(mysqli_num_rows($qDiv) > 0){
                                while($dataMpDiv = mysqli_fetch_assoc($qDiv)){
                                    $data[$noo++] = $dataMpDiv;
                                }
                            }
                            $sDept = mysqli_query($link, "SELECT * FROM department WHERE id_div = '$d_Div[id_div]' ")or die(mysqli_error($link));
                            $deptCount = mysqli_num_rows($sDept);

                            if($deptCount > 0){
                                while($d_Dept = mysqli_fetch_assoc($sDept)){
                                    //mendapatkan data karyawan yang memiliki id department , termasuk manager s.d TM
                                    $qDept = mysqli_query($link, 
                                    "SELECT 
                                    company.id_company AS idCompany, 
                                    company.nama AS namaCompany , 
                                    company.npk_cord AS directure,
                                    division.id_div AS idDiv, 
                                    division.nama_divisi AS divisi, 
                                    division.npk_cord AS dh, 
                                    division.id_company AS id_company,
                                    dept_account.id_dept_account AS idDeptAcc, 
                                    dept_account.department_account AS deptAcc, 
                                    dept_account.npk_dept AS mg, 
                                    dept_account.id_div AS id_div,
                                    department.id_dept AS idDept, 
                                    department.dept AS dept, 
                                    department.npk_cord AS dept_cord, 
                                    department.id_div AS id_div,
                                    karyawan.npk AS npk, 
                                    karyawan.nama AS nama, 
                                    karyawan.tgl_masuk AS tgl_masuk, 
                                    karyawan.jabatan AS jabatanMp, 
                                    karyawan.shift AS shift, 
                                    karyawan.status AS `status`, 
                                    karyawan.department AS deptMp, 
                                    karyawan.id_area AS id_area,
                                    jabatan.id_jabatan AS id_jab, 
                                    jabatan.jabatan AS nama_jab , 
                                    jabatan.level AS level_jab
                                    FROM karyawan 
                                    LEFT JOIN department ON karyawan.id_area = department.id_dept
                                    LEFT JOIN division ON division.id_div = department.id_div
                                    LEFT JOIN company ON company.id_company = division.id_company
                                    LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan 
                                    LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account 
                                    WHERE karyawan.id_area = '$d_Dept[id_dept]' ORDER BY level_jab ASC")or die(mysqli_error($link));
                                    if(mysqli_num_rows($qDept) > 0){
                                        while($dataMp = mysqli_fetch_assoc($qDept)){
                                            $data[$noo++] = $dataMp; 
                                        }
                                    }else{
                                        // echo "<tr>";
                                        // echo "<td colspan=\"16\">TIDAK DITEMUKAN DATA MAN POWER $d_Dept[dept]  di Database</td>";
                                        // echo "</tr>";
                                    }
                                
                                    ////////////////////////////section
                                    // cari data section dengan id department yang sama
                                    $sSect = mysqli_query($link, "SELECT * FROM section WHERE id_dept = '$d_Dept[id_dept]' ")or die(mysqli_error($link));
                                    $sectCount = mysqli_num_rows($sSect);
                                    if($sectCount > 0 ){
                                        while($dSect = mysqli_fetch_assoc($sSect)){
                                            //cari data karyawan dengan id section yang sama 
                                            $mpSect = mysqli_query($link, " SELECT 
                                            company.id_company AS idCompany,
                                            company.nama AS namaCompany ,
                                            company.npk_cord AS directure,
            
                                            division.id_div AS idDiv,
                                            division.nama_divisi AS divisi,
                                            division.npk_cord AS dh,
                                            division.id_company AS id_company,
            
                                            dept_account.id_dept_account AS idDeptAcc,
                                            dept_account.department_account AS deptAcc,
                                            dept_account.npk_dept AS mg, 
                                            dept_account.id_div AS id_div,
            
                                            department.id_dept AS idDept,
                                            department.dept AS dept,
                                            department.npk_cord AS dept_cord,
                                            department.id_div AS id_div,
            
                                            section.id_section AS idSect,
                                            section.section AS section,
                                            section.npk_cord AS spv,
                                            section.id_dept AS id_dept,
            
                                            karyawan.npk AS npk,
                                            karyawan.nama AS nama,
                                            karyawan.tgl_masuk AS tgl_masuk,
                                            karyawan.jabatan AS jabatanMp,
                                            karyawan.shift AS shift,
                                            karyawan.status AS `status`,
                                            karyawan.department AS deptMp,
                                            karyawan.id_area AS id_area,
            
                                            jabatan.id_jabatan AS id_jab,
                                            jabatan.jabatan AS nama_jab ,
                                            jabatan.level AS level_jab
            
                                            FROM karyawan 
                                            LEFT JOIN section ON section.id_section = karyawan.id_area
                                            LEFT JOIN department ON section.id_dept = department.id_dept
                                            LEFT JOIN division ON department.id_div = division.id_div 
                                            LEFT JOIN company ON division.id_company = company.id_company
                                            LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account
                                            LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan
                                            WHERE karyawan.id_area = '$dSect[id_section]' ORDER BY level_jab ASC
                                            ")or die(mysqli_error($link));
                                            $countMpSect = mysqli_num_rows($mpSect);
                                            //cetak mp dengan id section 
                                            if($countMpSect > 0){
                                                while($dataMpSect = mysqli_fetch_assoc($mpSect)){
                                                    $data[$noo++] = $dataMpSect; 
                                                    
                                                }
                                        
                                            }else{
                                                // echo "<tr>";
                                                // echo "<td colspan=\"16\">TIDAK DITEMUKAN DATA MAN POWER $dSect[section] di Database</td>";
                                                // echo "</tr>";
                                            }
                                            
            
                                            ///////////////////////////////group
                                            // cari data group foreman dengan id section yang sama
                                            $sGroup = mysqli_query($link, "SELECT * FROM groupfrm WHERE id_section = '$dSect[id_section]' ")or die(mysqli_error($link));
                                            $groupCount = mysqli_num_rows($sGroup);
                                            if($groupCount > 0){
                                                while($dGroup = mysqli_fetch_assoc($sGroup)){
                                                    //cari man power dengan id group yang sama
                                                    $s_MpGroup = mysqli_query($link, " SELECT 
                                                    company.id_company AS idCompany,
                                                    company.nama AS namaCompany ,
                                                    company.npk_cord AS directure,
            
                                                    division.id_div AS idDiv,
                                                    division.nama_divisi AS divisi,
                                                    division.npk_cord AS dh,
                                                    division.id_company AS id_company,
            
                                                    dept_account.id_dept_account AS idDeptAcc,
                                                    dept_account.department_account AS deptAcc,
                                                    dept_account.npk_dept AS mg, 
                                                    dept_account.id_div AS id_div,
            
                                                    department.id_dept AS idDept,
                                                    department.dept AS dept,
                                                    department.npk_cord AS dept_cord,
                                                    department.id_div AS id_div,
            
                                                    section.id_section AS idSect,
                                                    section.section AS section,
                                                    section.npk_cord AS spv,
                                                    section.id_dept AS id_dept,
            
                                                    groupfrm.id_group AS idGroup,
                                                    groupfrm.nama_group AS groupfrm,
                                                    groupfrm.npk_cord AS group_cord,
                                                    groupfrm.id_section AS id_sect,
            
                                                    karyawan.npk AS npk,
                                                    karyawan.nama AS nama,
                                                    karyawan.tgl_masuk AS tgl_masuk,
                                                    karyawan.jabatan AS jabatanMp,
                                                    karyawan.shift AS shift,
                                                    karyawan.status AS `status`,
                                                    karyawan.department AS deptMp,
                                                    karyawan.id_area AS id_area,
            
                                                    jabatan.id_jabatan AS id_jab,
                                                    jabatan.jabatan AS nama_jab ,
                                                    jabatan.level AS level_jab
            
                                                    FROM karyawan 
                                                    LEFT JOIN groupfrm ON karyawan.id_area = groupfrm.id_group 
                                                    LEFT JOIN section ON section.id_section = groupfrm.id_section
                                                    LEFT JOIN department ON section.id_dept = department.id_dept
                                                    LEFT JOIN division ON department.id_div = division.id_div 
                                                    LEFT JOIN company ON division.id_company = company.id_company
                                                    LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account
                                                    LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan
                                                    WHERE karyawan.id_area = '$dGroup[id_group]' ORDER BY level_jab ASC
                                                    ")or die(mysqli_error($link));
                                                    $countMpGroup = mysqli_num_rows($s_MpGroup);
                                                    if($countMpGroup > 0){
                                                        while($dataMpGroup = mysqli_fetch_assoc($s_MpGroup)){
                                                            $data[$noo++] = $dataMpGroup; 
                                                        }
                                                        
                                                    }else{
                                                        // echo "<tr>";
                                                        // echo "<td colspan=\"16\">TIDAK DITEMUKAN DATA MAN POWER $dGroup[nama_group] di Database</td>";
                                                        // echo "</tr>";
                                                    }
                                                
                                                    ////////////////////pos
                                                    //dapatkan nilai pos
                                                    $sPos = mysqli_query($link, "SELECT * FROM pos_leader WHERE id_group = '$dGroup[id_group]' ")or die(mysqli_error($link));
                                                    $countPos = mysqli_num_rows($sPos);
                                                    if($countPos > 1){
                                                        while($dPos = mysqli_fetch_assoc($sPos)){
                                                            //cari man power dengan id group yang sama
                                                            $s_MpPos = mysqli_query($link, " SELECT 
                                                            company.id_company AS idCompany,
                                                            company.nama AS namaCompany ,
                                                            company.npk_cord AS directure,
            
                                                            division.id_div AS idDiv,
                                                            division.nama_divisi AS divisi,
                                                            division.npk_cord AS dh,
                                                            division.id_company AS id_company,
            
                                                            dept_account.id_dept_account AS idDeptAcc,
                                                            dept_account.department_account AS deptAcc,
                                                            dept_account.npk_dept AS mg, 
                                                            dept_account.id_div AS id_div,
            
                                                            department.id_dept AS idDept,
                                                            department.dept AS dept,
                                                            department.npk_cord AS dept_cord,
                                                            department.id_div AS id_div,
            
                                                            section.id_section AS idSect,
                                                            section.section AS section,
                                                            section.npk_cord AS spv,
                                                            section.id_dept AS id_dept,
            
                                                            groupfrm.id_group AS idGroup,
                                                            groupfrm.nama_group AS groupfrm,
                                                            groupfrm.npk_cord AS group_cord,
                                                            groupfrm.id_section AS id_sect,
            
                                                            pos_leader.id_post AS idPost,
                                                            pos_leader.nama_pos AS pos,
                                                            pos_leader.npk_cord AS post_cord,
                                                            pos_leader.id_group AS leader,
            
                                                            karyawan.npk AS npk,
                                                            karyawan.nama AS nama,
                                                            karyawan.tgl_masuk AS tgl_masuk,
                                                            karyawan.jabatan AS jabatanMp,
                                                            karyawan.shift AS shift,
                                                            karyawan.status AS `status`,
                                                            karyawan.department AS deptMp,
                                                            karyawan.id_area AS id_area,
            
                                                            jabatan.id_jabatan AS id_jab,
                                                            jabatan.jabatan AS nama_jab ,
                                                            jabatan.level AS level_jab
            
                                                            FROM karyawan LEFT JOIN pos_leader ON karyawan.id_area = pos_leader.id_post
                                                            LEFT JOIN groupfrm ON pos_leader.id_group = groupfrm.id_group 
                                                            LEFT JOIN section ON section.id_section = groupfrm.id_section
                                                            LEFT JOIN department ON section.id_dept = department.id_dept
                                                            LEFT JOIN division ON department.id_div = division.id_div 
                                                            LEFT JOIN company ON division.id_company = company.id_company
                                                            LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account
                                                            LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan
                                                            WHERE karyawan.id_area = '$dPos[id_post]' ORDER BY level_jab ASC
                                                            ")or die(mysqli_error($link));
                                                            $countMpPos = mysqli_num_rows($s_MpPos);
                                                            if($countMpPos > 0){
                                                                //cari data Mp Pos
                                                                while($dataMpPos = mysqli_fetch_assoc($s_MpPos)){
                                                                    $data[$noo++] = $dataMpPos; 
                                                                    
                                                                }
                                                                
                                                            }else{
                                                                // echo "<tr>";
                                                                // echo "<td colspan=\"16\">TIDAK DITEMUKAN DATA MAN POWER $dPos[nama_pos] di Database</td>";
                                                                // echo "</tr>";
                                                            }
                                                        }
                                                        //membebaskan memori
                                                        mysqli_free_result($sPos);
                                                    }else{
                                                        // echo "<tr>";
                                                        // echo "<td colspan=\"16\"> TIDAK ADA DATA MAN POWER GROUP $dGroup[nama_group]</td>";
                                                        // echo "</tr>";
                                                    }
                                                }
                                                ////////////////////pos
                                                //membebaskan memori
                                                mysqli_free_result($sGroup);
                                            }else{
                                                // echo "<tr>";
                                                // echo "<td colspan=\"16\"> TIDAK ADA DATA MAN POWER SECTION $dSect[section]</td>";
                                                // echo "</tr>";
                                            }
                                        }
                                        //membebaskan memori
                                        mysqli_free_result($sSect);
                                        ///////////////////////////////group
                                    }else{
                                        // echo "<tr>";
                                        // echo "<td colspan=\"16\"> TIDAK ADA DATA MAN POWER DEPARTMENT $d_Dept[dept] </td>";
                                        // echo "</tr>";
                                    }
                                    ////////////////////////////section
                                }
                                //membebaskan memori
                                mysqli_free_result($sDept);
                            }else{
                                // <tr>
                                //     <td colspan="16">Tidak Ada Data Department di Database Body</td>
                                // </tr>
                            }

                        }
                        mysqli_free_result($s_Div);
                    }
                    ////////////////////////////////////////////jika tidak ada pencarian end
                }
            //jika tidak ada inputan pencarian tidak dilakukan, masukkan  nilai posisi + 1 ke dalam no     
            } else {
                // $query_mp = "SELECT * FROM karyawan LIMIT $posisi, $batas";
                // $queryjml = "SELECT * FROM karyawan";
                // $no = $posisi + 1;
                
                ////////////////////////////////////////////jika tidak ada pencarian
                // echo tes('try');
                
                $noo = 1;
                if($jmlDiv > 0){
                    //mendapatkan nilai department
                    //ubah code divisi untuk divisi selain body
                    $s_Div= mysqli_query($link, "SELECT * FROM division WHERE id_company = '1' ORDER BY id_div ASC")or die(mysqli_error($link));
                    
                    while($d_Div = mysqli_fetch_assoc($s_Div)){
                        //mendapatkan data karyawan yang memiliki id department , termasuk manager s.d TM
                        $qDiv = mysqli_query($link, 
                        "SELECT 
                        company.id_company AS idCompany, 
                        company.nama AS namaCompany , 
                        company.npk_cord AS directure,
                        division.id_div AS idDiv, 
                        division.nama_divisi AS divisi, 
                        division.npk_cord AS dh, 
                        division.id_company AS id_company,
                        
                        karyawan.npk AS npk, 
                        karyawan.nama AS nama, 
                        karyawan.tgl_masuk AS tgl_masuk, 
                        karyawan.jabatan AS jabatanMp, 
                        karyawan.shift AS shift, 
                        karyawan.status AS `status`, 
                        karyawan.department AS deptMp, 
                        karyawan.id_area AS id_area,
                        jabatan.id_jabatan AS id_jab, 
                        jabatan.jabatan AS nama_jab , 
                        jabatan.level AS level_jab
                        FROM karyawan 
                        LEFT JOIN division ON division.id_div = karyawan.id_area
                        LEFT JOIN company ON company.id_company = division.id_company
                        LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan 
                        LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account 
                        WHERE karyawan.id_area = '$d_Div[id_div]' ORDER BY level_jab ASC")or die(mysqli_error($link));
                        if(mysqli_num_rows($qDiv) > 0){
                            while($dataMpDiv = mysqli_fetch_assoc($qDiv)){
                                $data[$noo++] = $dataMpDiv;
                            }
                        }
                        $sDept = mysqli_query($link, "SELECT * FROM department WHERE id_div = '$d_Div[id_div]' ")or die(mysqli_error($link));
                        $deptCount = mysqli_num_rows($sDept);

                        if($deptCount > 0){
                            while($d_Dept = mysqli_fetch_assoc($sDept)){
                                //mendapatkan data karyawan yang memiliki id department , termasuk manager s.d TM
                                $qDept = mysqli_query($link, 
                                "SELECT 
                                company.id_company AS idCompany, 
                                company.nama AS namaCompany , 
                                company.npk_cord AS directure,
                                division.id_div AS idDiv, 
                                division.nama_divisi AS divisi, 
                                division.npk_cord AS dh, 
                                division.id_company AS id_company,
                                dept_account.id_dept_account AS idDeptAcc, 
                                dept_account.department_account AS deptAcc, 
                                dept_account.npk_dept AS mg, 
                                dept_account.id_div AS id_div,
                                department.id_dept AS idDept, 
                                department.dept AS dept, 
                                department.npk_cord AS dept_cord, 
                                department.id_div AS id_div,
                                karyawan.npk AS npk, 
                                karyawan.nama AS nama, 
                                karyawan.tgl_masuk AS tgl_masuk, 
                                karyawan.jabatan AS jabatanMp, 
                                karyawan.shift AS shift, 
                                karyawan.status AS `status`, 
                                karyawan.department AS deptMp, 
                                karyawan.id_area AS id_area,
                                jabatan.id_jabatan AS id_jab, 
                                jabatan.jabatan AS nama_jab , 
                                jabatan.level AS level_jab
                                FROM karyawan 
                                LEFT JOIN department ON karyawan.id_area = department.id_dept
                                LEFT JOIN division ON division.id_div = department.id_div
                                LEFT JOIN company ON company.id_company = division.id_company
                                LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan 
                                LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account 
                                WHERE karyawan.id_area = '$d_Dept[id_dept]' ORDER BY level_jab ASC")or die(mysqli_error($link));
                                if(mysqli_num_rows($qDept) > 0){
                                    while($dataMp = mysqli_fetch_assoc($qDept)){
                                        $data[$noo++] = $dataMp; 
                                    }
                                }else{
                                    // echo "<tr>";
                                    // echo "<td colspan=\"16\">TIDAK DITEMUKAN DATA MAN POWER $d_Dept[dept]  di Database</td>";
                                    // echo "</tr>";
                                }
                            
                                ////////////////////////////section
                                // cari data section dengan id department yang sama
                                $sSect = mysqli_query($link, "SELECT * FROM section WHERE id_dept = '$d_Dept[id_dept]' ")or die(mysqli_error($link));
                                $sectCount = mysqli_num_rows($sSect);
                                if($sectCount > 0 ){
                                    while($dSect = mysqli_fetch_assoc($sSect)){
                                        //cari data karyawan dengan id section yang sama 
                                        $mpSect = mysqli_query($link, " SELECT 
                                        company.id_company AS idCompany,
                                        company.nama AS namaCompany ,
                                        company.npk_cord AS directure,
        
                                        division.id_div AS idDiv,
                                        division.nama_divisi AS divisi,
                                        division.npk_cord AS dh,
                                        division.id_company AS id_company,
        
                                        dept_account.id_dept_account AS idDeptAcc,
                                        dept_account.department_account AS deptAcc,
                                        dept_account.npk_dept AS mg, 
                                        dept_account.id_div AS id_div,
        
                                        department.id_dept AS idDept,
                                        department.dept AS dept,
                                        department.npk_cord AS dept_cord,
                                        department.id_div AS id_div,
        
                                        section.id_section AS idSect,
                                        section.section AS section,
                                        section.npk_cord AS spv,
                                        section.id_dept AS id_dept,
        
                                        karyawan.npk AS npk,
                                        karyawan.nama AS nama,
                                        karyawan.tgl_masuk AS tgl_masuk,
                                        karyawan.jabatan AS jabatanMp,
                                        karyawan.shift AS shift,
                                        karyawan.status AS `status`,
                                        karyawan.department AS deptMp,
                                        karyawan.id_area AS id_area,
        
                                        jabatan.id_jabatan AS id_jab,
                                        jabatan.jabatan AS nama_jab ,
                                        jabatan.level AS level_jab
        
                                        FROM karyawan 
                                        LEFT JOIN section ON section.id_section = karyawan.id_area
                                        LEFT JOIN department ON section.id_dept = department.id_dept
                                        LEFT JOIN division ON department.id_div = division.id_div 
                                        LEFT JOIN company ON division.id_company = company.id_company
                                        LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account
                                        LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan
                                        WHERE karyawan.id_area = '$dSect[id_section]' ORDER BY level_jab ASC
                                        ")or die(mysqli_error($link));
                                        $countMpSect = mysqli_num_rows($mpSect);
                                        //cetak mp dengan id section 
                                        if($countMpSect > 0){
                                            while($dataMpSect = mysqli_fetch_assoc($mpSect)){
                                                $data[$noo++] = $dataMpSect; 
                                                
                                            }
                                    
                                        }else{
                                            // echo "<tr>";
                                            // echo "<td colspan=\"16\">TIDAK DITEMUKAN DATA MAN POWER $dSect[section] di Database</td>";
                                            // echo "</tr>";
                                        }
                                        
        
                                        ///////////////////////////////group
                                        // cari data group foreman dengan id section yang sama
                                        $sGroup = mysqli_query($link, "SELECT * FROM groupfrm WHERE id_section = '$dSect[id_section]' ")or die(mysqli_error($link));
                                        $groupCount = mysqli_num_rows($sGroup);
                                        if($groupCount > 0){
                                            while($dGroup = mysqli_fetch_assoc($sGroup)){
                                                //cari man power dengan id group yang sama
                                                $s_MpGroup = mysqli_query($link, " SELECT 
                                                company.id_company AS idCompany,
                                                company.nama AS namaCompany ,
                                                company.npk_cord AS directure,
        
                                                division.id_div AS idDiv,
                                                division.nama_divisi AS divisi,
                                                division.npk_cord AS dh,
                                                division.id_company AS id_company,
        
                                                dept_account.id_dept_account AS idDeptAcc,
                                                dept_account.department_account AS deptAcc,
                                                dept_account.npk_dept AS mg, 
                                                dept_account.id_div AS id_div,
        
                                                department.id_dept AS idDept,
                                                department.dept AS dept,
                                                department.npk_cord AS dept_cord,
                                                department.id_div AS id_div,
        
                                                section.id_section AS idSect,
                                                section.section AS section,
                                                section.npk_cord AS spv,
                                                section.id_dept AS id_dept,
        
                                                groupfrm.id_group AS idGroup,
                                                groupfrm.nama_group AS groupfrm,
                                                groupfrm.npk_cord AS group_cord,
                                                groupfrm.id_section AS id_sect,
        
                                                karyawan.npk AS npk,
                                                karyawan.nama AS nama,
                                                karyawan.tgl_masuk AS tgl_masuk,
                                                karyawan.jabatan AS jabatanMp,
                                                karyawan.shift AS shift,
                                                karyawan.status AS `status`,
                                                karyawan.department AS deptMp,
                                                karyawan.id_area AS id_area,
        
                                                jabatan.id_jabatan AS id_jab,
                                                jabatan.jabatan AS nama_jab ,
                                                jabatan.level AS level_jab
        
                                                FROM karyawan 
                                                LEFT JOIN groupfrm ON karyawan.id_area = groupfrm.id_group 
                                                LEFT JOIN section ON section.id_section = groupfrm.id_section
                                                LEFT JOIN department ON section.id_dept = department.id_dept
                                                LEFT JOIN division ON department.id_div = division.id_div 
                                                LEFT JOIN company ON division.id_company = company.id_company
                                                LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account
                                                LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan
                                                WHERE karyawan.id_area = '$dGroup[id_group]' ORDER BY level_jab ASC
                                                ")or die(mysqli_error($link));
                                                $countMpGroup = mysqli_num_rows($s_MpGroup);
                                                if($countMpGroup > 0){
                                                    while($dataMpGroup = mysqli_fetch_assoc($s_MpGroup)){
                                                        $data[$noo++] = $dataMpGroup; 
                                                    }
                                                    
                                                }else{
                                                    // echo "<tr>";
                                                    // echo "<td colspan=\"16\">TIDAK DITEMUKAN DATA MAN POWER $dGroup[nama_group] di Database</td>";
                                                    // echo "</tr>";
                                                }
                                            
                                                ////////////////////pos
                                                //dapatkan nilai pos
                                                $sPos = mysqli_query($link, "SELECT * FROM pos_leader WHERE id_group = '$dGroup[id_group]' ")or die(mysqli_error($link));
                                                $countPos = mysqli_num_rows($sPos);
                                                if($countPos > 1){
                                                    while($dPos = mysqli_fetch_assoc($sPos)){
                                                        //cari man power dengan id group yang sama
                                                        $s_MpPos = mysqli_query($link, " SELECT 
                                                        company.id_company AS idCompany,
                                                        company.nama AS namaCompany ,
                                                        company.npk_cord AS directure,
        
                                                        division.id_div AS idDiv,
                                                        division.nama_divisi AS divisi,
                                                        division.npk_cord AS dh,
                                                        division.id_company AS id_company,
        
                                                        dept_account.id_dept_account AS idDeptAcc,
                                                        dept_account.department_account AS deptAcc,
                                                        dept_account.npk_dept AS mg, 
                                                        dept_account.id_div AS id_div,
        
                                                        department.id_dept AS idDept,
                                                        department.dept AS dept,
                                                        department.npk_cord AS dept_cord,
                                                        department.id_div AS id_div,
        
                                                        section.id_section AS idSect,
                                                        section.section AS section,
                                                        section.npk_cord AS spv,
                                                        section.id_dept AS id_dept,
        
                                                        groupfrm.id_group AS idGroup,
                                                        groupfrm.nama_group AS groupfrm,
                                                        groupfrm.npk_cord AS group_cord,
                                                        groupfrm.id_section AS id_sect,
        
                                                        pos_leader.id_post AS idPost,
                                                        pos_leader.nama_pos AS pos,
                                                        pos_leader.npk_cord AS post_cord,
                                                        pos_leader.id_group AS leader,
        
                                                        karyawan.npk AS npk,
                                                        karyawan.nama AS nama,
                                                        karyawan.tgl_masuk AS tgl_masuk,
                                                        karyawan.jabatan AS jabatanMp,
                                                        karyawan.shift AS shift,
                                                        karyawan.status AS `status`,
                                                        karyawan.department AS deptMp,
                                                        karyawan.id_area AS id_area,
        
                                                        jabatan.id_jabatan AS id_jab,
                                                        jabatan.jabatan AS nama_jab ,
                                                        jabatan.level AS level_jab
        
                                                        FROM karyawan LEFT JOIN pos_leader ON karyawan.id_area = pos_leader.id_post
                                                        LEFT JOIN groupfrm ON pos_leader.id_group = groupfrm.id_group 
                                                        LEFT JOIN section ON section.id_section = groupfrm.id_section
                                                        LEFT JOIN department ON section.id_dept = department.id_dept
                                                        LEFT JOIN division ON department.id_div = division.id_div 
                                                        LEFT JOIN company ON division.id_company = company.id_company
                                                        LEFT JOIN dept_account ON karyawan.department = dept_account.id_dept_account
                                                        LEFT JOIN jabatan ON karyawan.jabatan = jabatan.id_jabatan
                                                        WHERE karyawan.id_area = '$dPos[id_post]' ORDER BY level_jab ASC
                                                        ")or die(mysqli_error($link));
                                                        $countMpPos = mysqli_num_rows($s_MpPos);
                                                        if($countMpPos > 0){
                                                            //cari data Mp Pos
                                                            while($dataMpPos = mysqli_fetch_assoc($s_MpPos)){
                                                                $data[$noo++] = $dataMpPos; 
                                                                
                                                            }
                                                            
                                                        }else{
                                                            // echo "<tr>";
                                                            // echo "<td colspan=\"16\">TIDAK DITEMUKAN DATA MAN POWER $dPos[nama_pos] di Database</td>";
                                                            // echo "</tr>";
                                                        }
                                                    }
                                                    //membebaskan memori
                                                    mysqli_free_result($sPos);
                                                }else{
                                                    // echo "<tr>";
                                                    // echo "<td colspan=\"16\"> TIDAK ADA DATA MAN POWER GROUP $dGroup[nama_group]</td>";
                                                    // echo "</tr>";
                                                }
                                            }
                                            ////////////////////pos
                                            //membebaskan memori
                                            mysqli_free_result($sGroup);
                                        }else{
                                            // echo "<tr>";
                                            // echo "<td colspan=\"16\"> TIDAK ADA DATA MAN POWER SECTION $dSect[section]</td>";
                                            // echo "</tr>";
                                        }
                                    }
                                    //membebaskan memori
                                    mysqli_free_result($sSect);
                                    ///////////////////////////////group
                                }else{
                                    // echo "<tr>";
                                    // echo "<td colspan=\"16\"> TIDAK ADA DATA MAN POWER DEPARTMENT $d_Dept[dept] </td>";
                                    // echo "</tr>";
                                }
                                ////////////////////////////section
                            }
                            //membebaskan memori
                            mysqli_free_result($sDept);
                        }else{
                            // <tr>
                            //     <td colspan="16">Tidak Ada Data Department di Database Body</td>
                            // </tr>
                        }

                    }
                    mysqli_free_result($s_Div);
                }
                ////////////////////////////////////////////jika tidak ada pencarian end
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

                                if(isset($data)){
                                    if(isset($_POST['cari']) && $hal > 0){
                                        $posisi = 0;
                                    }
                                    // $trigger = $sort % $batas;
                                    // echo $trigger;
                                    // if($trigger == 0){
                                    $limit = $posisi + $sort; 
                                    //cek agar jika sort maximal data array tidak offset
                                    if($limit > $totalData){
                                        $end = $totalData;
                                    }else{
                                        $end = $limit;
                                    }
                                    // }else{
                                        // $limit = $sort - $trigger; 
                                    // }
                                    
                                    
                                       
                                    for($i = $posisi + 1; $i<=$end; $i++){
                                        ?>
                                        <tr>
                                        <td class="sticky-col first-col"><?=$i?></td>
                                        <td class="sticky-col second-col"><?=$data[$i]['npk']?></td>
                                        <td class="sticky-col third-col"><?=$data[$i]['nama']?></td>
                                        <td ><?=$data[$i]['status']?></td>
                                        <td ><?=$data[$i]['jabatanMp']?></td>
                                        <td ><?=$data[$i]['tgl_masuk']?></td>
                                        <td ><?=$data[$i]['shift']?></td>
                                        <?php
                                        $pos_leader = (!empty($data[$i]['pos']))? $data[$i]['pos'] : "-";
                                        $groupfrm = (!empty($data[$i]['groupfrm']))? $data[$i]['groupfrm'] : "-"; 
                                        $section = (!empty($data[$i]['section']))? $data[$i]['section'] : "-"; 
                                        $department = (!empty($data[$i]['dept']))? $data[$i]['dept'] : "-"; 
                                        $dept_Account = (!empty($data[$i]['deptAcc']))? $data[$i]['deptAcc'] : "-"; 
                                        $division = (!empty($data[$i]['divisi']))? $data[$i]['divisi'] : "-"; 
                                        
                                        
                                        ?>
                                        <td ><?=$pos_leader?></td>
                                        <td ><?=$groupfrm?></td>
                                        <td ><?=$section ?></td>
                                        <td ><?=$department?></td>
                                        <td ><?=$dept_Account?></td>
                                        <td ><?=$division?></td>
                                        <td ><?=$data[$i]['namaCompany']?></td>
                                        <td class="sticky-col second-last-col">
                                            <a href="edit_mp.php?edit=<?=$data[$i]['npk']?>" class="btn btn-warning btn-icon btn-sm edit"><i      
                                                class="fa fa-edit"></i></a>
                                            <a href="proses/proses.php?del=<?=$data[$i]['npk']?>" class="btn btn-danger btn-icon btn-sm remove del"><i     
                                                class="fa fa-times"></i></a>
                                        </td>
                                        <td class="sticky-col first-last-col">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input mp" name="mpchecked[]" type="checkbox" value="<?=$data[$i]['npk']?>">
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
                                    // print_r($data['1']);
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
