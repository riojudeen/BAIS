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
                        <!-- <label>Waktu Mulai</label> -->
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



<!-- halaman utama -->
<!-- menyimpan data flash -->
<div class="info-data" data-infodata="<?php if(isset($_SESSION['info'])){ echo $_SESSION['info']; } unset($_SESSION['info']); ?>" id="del"></div>
<!-- menyimpan data flash -->
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header ">
                <h5 class="card-title pull-left">Daftar Man Power</h5>
                <div class="box pull-right">
                    <button class="btn btn-warning btn-icon btn-round" data-toggle="tooltip" data-placement="bottom" title="Format File Import">
                        <i class="nc-icon nc-paper"></i>
                    </button>
                    <a href="" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Import excel to database">
                        <span class="btn-label">
                            <i class="nc-icon nc-cloud-download-93"></i>
                        </span>
                    Import
                    </a>
                    <button class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Export to Excel File">
                        <span class="btn-label">
                            <i class="nc-icon nc-cloud-upload-94"></i>
                            
                        </span>
                        Export
                    </button>
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
            <div class="card-body ">
                <form method="post">
                <div class="col-sm-7 pull-left">
                    <div class="row">
                        <label class="ml-3 col-form-label col-sm-1 pl-0">Sort</label>
                        <div class="col-sm-1 px-0">
                            <div class="form-group">
                            <input type="number" class="form-control" value="1">
                            </div>
                        </div>
                        <label class="ml-2 col-form-label pl-0 mr-3">/ 100</label>
                        <div class="col-md-1 px-0">
                            <div class="form-group">
                            <input type="submit" class="btn btn-primary my-0 btn-round btn-icon" value="go">
                            </div>
                        </div>
                        <div class="col-md-3 px-0">
                            <div class="form-group">
                            <input type="button"  class="btn btn-warning my-0 " value="Filter">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box pull-right">
                    <div class="input-group no-border">
                        <input type="text" value="" class="form-control" placeholder="Search...">
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
                        <table class="table table-hover text-nowrap table-bordered" id="table_mp">
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
                            // echo tes('try');
                            $q_mP = mysqli_query($link, " SELECT 
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
                            ")or die(mysqli_error($link));
                            // mengambil data department
                            // echo tes('try');
                            $sComp = mysqli_query($link, "SELECT * FROM company WHERE id_company = 1")or die(mysqli_error($link));


                            $sDiv = mysqli_query($link, "SELECT * FROM company WHERE id_company = 1")or die(mysqli_error($link));
                            $sDept = mysqli_query($link, "SELECT * FROM department")or die(mysqli_error($link));
                            $sSect = mysqli_query($link, "SELECT * FROM section")or die(mysqli_error($link));
                            $sGroup = mysqli_query($link, "SELECT * FROM groupfrm")or die(mysqli_error($link));
                            $sPos = mysqli_query($link, "SELECT * FROM pos_leader")or die(mysqli_error($link));

                            $jmlDept = mysqli_num_rows($sDept);
                            $jmlSect = mysqli_num_rows($sSect);
                            $jmlGroup = mysqli_num_rows($sGroup);
                            $jmlPos = mysqli_num_rows($sPos);
                            
                            $batas = 10 ;
                            $noo = 1;

                            
                                if($jmlDept > 0){
                                    //mendapatkan nilai department
                                    //ubah code divisi untuk divisi selain body
                                    $s_Dept = mysqli_query($link, "SELECT * FROM department WHERE id_div = 1 ORDER BY id_dept ASC")or die(mysqli_error($link));
                                    ?>
                                    
                                        
                                    <?php
                                    while($d_Dept = mysqli_fetch_assoc($s_Dept)){
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
                                               $data[] = $dataMp; 
                                               
                                            ?>
                                            <tr id="<?=$dataMp['npk']?>">
                                                <td class="sticky-col first-col"><?=$noo++?></td>
                                                <td class="<?=$d_Dept['id_dept']?> sticky-col second-col"><?=$dataMp['npk']?></td>
                                                <td class="<?=$d_Dept['id_dept']?> sticky-col third-col"><?=$dataMp['nama']?></td>
                                                <td class="<?=$d_Dept['id_dept']?> "><?=$dataMp['status']?></td>
                                                <td class="<?=$d_Dept['id_dept']?>"><?=$dataMp['nama_jab']?></td>
                                                <td class="<?=$d_Dept['id_dept']?>"><?=$dataMp['tgl_masuk']?></td>
                                                <td class="<?=$d_Dept['id_dept']?>"><?=$dataMp['shift']?></td>
                                                <td class="<?=$d_Dept['id_dept']?>"><?=$dataMp['dept']?></td>
                                                <td class="<?=$d_Dept['id_dept']?>"><?=$dataMp['dept']?></td>
                                                <td class="<?=$d_Dept['id_dept']?>"><?=$dataMp['dept']?></td>
                                                <td class="<?=$d_Dept['id_dept']?>"><?=$dataMp['dept']?></td>
                                                <td class="<?=$d_Dept['id_dept']?>"><?=$dataMp['deptAcc']?></td>
                                                <td class="<?=$d_Dept['id_dept']?>"><?=$dataMp['divisi']?></td>
                                                <td class="<?=$d_Dept['id_dept']?>"><?=$dataMp['namaCompany']?></td>
                                                <td class="sticky-col second-last-col">
                                                    <a href="edit_mp.php?edit=<?=$dataMp['npk']?>" class="btn btn-warning btn-icon btn-sm edit"><i      
                                                        class="fa fa-edit"></i></a>
                                                    <a href="proses/proses.php?del=<?=$dataMp['npk']?>" class="btn btn-danger btn-icon btn-sm remove del"><i     
                                                        class="fa fa-times"></i></a>
                                                </td>
                                                <td class="sticky-col first-last-col">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input mp" name="mpchecked[]" type="checkbox" value="<?=$dataMp['npk']?>">
                                                        <span class="form-check-sign"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                </tr>
                                                <?php
                                            }
                                            
                                        }else{
                                            // echo "<tr>";
                                            // echo "<td colspan=\"16\">TIDAK DITEMUKAN DATA MAN POWER $d_Dept[dept]  di Database</td>";
                                            // echo "</tr>";
                                        }
                                        ?>
                                        <?php
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
                                                        $data[] = $dataMpSect; 
                                                    ?>
                                                    <tr id="<?=$dataMpSect['npk']?>">
                                                        <td class="sticky-col first-col"><?=$noo++?></td>
                                                        <td class="<?=$dSect['id_section']?> sticky-col second-col"><?=$dataMpSect['npk']?></td>
                                                        <td class="<?=$dSect['id_section']?> sticky-col third-col"><?=$dataMpSect['nama']?></td>
                                                        <td class="<?=$dSect['id_section']?> "><?=$dataMpSect['status']?></td>
                                                        <td class="<?=$dSect['id_section']?>"><?=$dataMpSect['nama_jab']?></td>
                                                        <td class="<?=$dSect['id_section']?>"><?=$dataMpSect['tgl_masuk']?></td>
                                                        <td class="<?=$dSect['id_section']?>"><?=$dataMpSect['shift']?></td>
                                                        <td class="<?=$dSect['id_section']?>"><?=$dataMpSect['section']?></td>
                                                        <td class="<?=$dSect['id_section']?>"><?=$dataMpSect['section']?></td>
                                                        <td class="<?=$dSect['id_section']?>"><?=$dataMpSect['section']?></td>
                                                        <td class="<?=$dSect['id_section']?>"><?=$dataMpSect['dept']?></td>
                                                        <td class="<?=$dSect['id_section']?>"><?=$dataMpSect['deptAcc']?></td>
                                                        <td class="<?=$dSect['id_section']?>"><?=$dataMpSect['divisi']?></td>
                                                        <td class="<?=$dSect['id_section']?>"><?=$dataMpSect['namaCompany']?></td>
                                                        <td class="sticky-col second-last-col">
                                                            <a href="edit_mp.php?edit=<?=$dataMpSect['npk']?>" class="btn btn-warning  btn-icon btn-sm edit"><i      
                                                                class="fa fa-edit"></i></a>
                                                            <a href="proses/proses.php?del=<?=$dataMpSect['npk']?>" class="btn btn-danger btn-icon btn-sm remove del"><i     
                                                                class="fa fa-times"></i></a>
                                                        </td>
                                                        <td class="sticky-col first-last-col">
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input mp" name="mpchecked[]" type="checkbox" value="<?=$dataMpSect['npk']?>">
                                                                <span class="form-check-sign"></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                                    <?php
                                                        
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
                                                                $data[] = $dataMpGroup; 
                                                                ?>
                                                                <tr id="<?=$dataMpGroup['npk']?>">
                                                                    <td class="sticky-col first-col"><?=$noo++?></td>
                                                                    <td class="<?=$dGroup['id_group']?> sticky-col second-col"><?=$dataMpGroup['npk']?></td>
                                                                    <td class="<?=$dGroup['id_group']?> sticky-col third-col"><?=$dataMpGroup['nama']?></td>
                                                                    <td class="<?=$dGroup['id_group']?> "><?=$dataMpGroup['status']?></td>
                                                                    <td class="<?=$dGroup['id_group']?>"><?=$dataMpGroup['nama_jab']?></td>
                                                                    <td class="<?=$dGroup['id_group']?>"><?=$dataMpGroup['tgl_masuk']?></td>
                                                                    <td class="<?=$dGroup['id_group']?>"><?=$dataMpGroup['shift']?></td>
                                                                    <td class="<?=$dGroup['id_group']?>"><?=$dataMpGroup['groupfrm']?></td>
                                                                    <td class="<?=$dGroup['id_group']?>"><?=$dataMpGroup['groupfrm']?></td>
                                                                    <td class="<?=$dGroup['id_group']?>"><?=$dataMpGroup['section']?></td>
                                                                    <td class="<?=$dGroup['id_group']?>"><?=$dataMpGroup['dept']?></td>
                                                                    <td class="<?=$dGroup['id_group']?>"><?=$dataMpGroup['deptAcc']?></td>
                                                                    <td class="<?=$dGroup['id_group']?>"><?=$dataMpGroup['divisi']?></td>
                                                                    <td class="<?=$dGroup['id_group']?>"><?=$dataMpGroup['namaCompany']?></td>
                                                                    <td class="sticky-col second-last-col">
                                                                        <a href="edit_mp.php?edit=<?=$dataMpGroup['npk']?>" class="btn btn-warning btn-icon btn-sm edit"><i      
                                                                            class="fa fa-edit"></i></a>
                                                                        <a href="proses/proses.php?del=<?=$dataMpGroup['npk']?>" class="btn btn-danger btn-icon btn-sm remove del"><i     
                                                                            class="fa fa-times"></i></a>
                                                                    </td>
                                                                    <td class="sticky-col first-last-col">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input class="form-check-input mp" name="mpchecked[]" type="checkbox" value="<?=$dataMpGroup['npk']?>">
                                                                            <span class="form-check-sign"></span>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                
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
                                                                        $data[] = $dataMpPos; 
                                                                        ?>
                                                                        <tr id="<?=$dataMpPos['npk']?>">
                                                                            <td class="sticky-col first-col"><?=$noo++?></td>
                                                                            <td class="<?=$dPos['id_post']?> sticky-col second-col"><?=$dataMpPos['npk']?></td>
                                                                            <td class="<?=$dPos['id_post']?> sticky-col third-col"><?=$dataMpPos['nama']?></td>
                                                                            <td class="<?=$dPos['id_post']?> "><?=$dataMpPos['status']?></td>
                                                                            <td class="<?=$dPos['id_post']?>"><?=$dataMpPos['nama_jab']?></td>
                                                                            <td class="<?=$dPos['id_post']?>"><?=$dataMpPos['tgl_masuk']?></td>
                                                                            <td class="<?=$dPos['id_post']?>"><?=$dataMpPos['shift']?></td>
                                                                        
                                                                            <td class="<?=$dPos['id_post']?>"><?=$dataMpPos['pos']?></td>
                                                                            <td class="<?=$dPos['id_post']?>"><?=$dataMpPos['groupfrm']?></td>
                                                                            <td class="<?=$dPos['id_post']?>"><?=$dataMpPos['section']?></td>
                                                                            <td class="<?=$dPos['id_post']?>"><?=$dataMpPos['dept']?></td>
                                                                            <td class="<?=$dPos['id_post']?>"><?=$dataMpPos['deptAcc']?></td>
                                                                            <td class="<?=$dPos['id_post']?>"><?=$dataMpPos['divisi']?></td>
                                                                            <td class="<?=$dPos['id_post']?>"><?=$dataMpPos['namaCompany']?></td>
                                                                            <td class="sticky-col second-last-col">
                                                                                <a href="edit_mp.php?edit=<?=$dataMpPos['npk']?>" class="btn btn-warning  btn-icon btn-sm edit"><i      
                                                                                    class="fa fa-edit"></i></a>
                                                                                <a href="proses/proses.php?del=<?=$dataMpPos['npk']?>" class="btn btn-danger btn-icon btn-sm remove del"><i     
                                                                                    class="fa fa-times"></i></a>
                                                                            </td>
                                                                            <td class="sticky-col first-last-col">
                                                                                <div class="form-check">
                                                                                    <label class="form-check-label">
                                                                                        <input class="form-check-input mp" name="mpchecked[]" type="checkbox" value="<?=$dataMpPos['npk']?>">
                                                                                    <span class="form-check-sign"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }else{
                                                                    // echo "<tr>";
                                                                    // echo "<td colspan=\"16\">TIDAK DITEMUKAN DATA MAN POWER $dPos[nama_pos] di Database</td>";
                                                                    // echo "</tr>";
                                                                }
                                                            }
                                                        }else{
                                                            // echo "<tr>";
                                                            // echo "<td colspan=\"16\"> TIDAK ADA DATA MAN POWER GROUP $dGroup[nama_group]</td>";
                                                            // echo "</tr>";
                                                        }
                                                    }
                                                    ////////////////////pos
                                                    
                                                }else{
                                                    // echo "<tr>";
                                                    // echo "<td colspan=\"16\"> TIDAK ADA DATA MAN POWER SECTION $dSect[section]</td>";
                                                    // echo "</tr>";
                                                }
                                            }

                                            ///////////////////////////////group
                                        }else{
                                            // echo "<tr>";
                                            // echo "<td colspan=\"16\"> TIDAK ADA DATA MAN POWER DEPARTMENT $d_Dept[dept] </td>";
                                            // echo "</tr>";
                                        }
                                        ////////////////////////////section
                                    }
                                }else{
                                    //jika tidak ada data mp dengan kode divisi Body 
                                    ?>
                                    <tr>
                                        <td colspan="16">Tidak Ada Data Department di Database Body</td>
                                    </tr>
                                    
                                    <?php
                                }
                            
                            
                            /*
                            $no = 1;
                            while($dMp = mysqli_fetch_assoc($q_mP)){
                                ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$dMp['npk']?></td>
                                    <td><?=$dMp['nama']?></td>
                                    <td><?=$dMp['status']?></td>
                                    <td><?=$dMp['nama_jab']?></td>
                                    <td><?=$dMp['tgl_masuk']?></td>
                                    <td><?=$dMp['shift']?></td>
                                    <td><?=$dMp['pos']?></td>
                                    <td><?=$dMp['groupfrm']?></td>
                                    <td><?=$dMp['section']?></td>
                                    <td><?=$dMp['dept']?></td>
                                    <td><?=$dMp['deptAcc']?></td>
                                    <td><?=$dMp['divisi']?></td>
                                    <td><?=$dMp['namaCompany']?></td>
                                    <td>
                                        <a href="proses.php?npk=<?=$dMp['npk']?>" class="btn btn-warning btn-link btn-icon btn-sm edit"><i      
                                            class="fa fa-edit"></i></a>
                                        <a href="proses.php?npk=<?=$dMp['npk']?>" class="btn btn-danger btn-link btn-icon btn-sm remove"><i     
                                            class="fa fa-times"></i></a>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox">
                                            <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            */
                            
                            
                            
                            
                            ?>
                            </tbody>
                            <tfoot>
                                <?php
                                    print_r($data['1']);
                                ?>
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
            <div class="card-footer">

            </div>
            
        </div>
    </div>
</div>
<!-- script untuk notifikasi hapus -->
<script>
    $(document).ready(function(){
        const notifikasi = $('.info-data').data('infodata');
        if(notifikasi == "Disimpan" || notifikasi=="Dihapus"){
            Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: 'Data Berhasil '+notifikasi,
            })
        }else if(notifikasi == "Gagal Disimpan" || notifikasi=="Gagal Dihapus"){
            Swal.fire({
            icon: 'error',
            title: 'GAGAL',
            text: 'Data '+notifikasi,
            })
        }else if(notifikasi == "Kosong"){
            Swal.fire({
            icon: 'error',
            title: 'GAGAL',
            text: 'Data Dipilih '+notifikasi+' atau tidak ada',
            })
        }
        $('.del').on('click', function(e){
            e.preventDefault();
            var getLink = $(this).attr('href');
            var id = $(this).parents("tr").attr("id");
                
            Swal.fire({
            title: 'Anda Yakin ?',
            text: "Data Man Power dengan NPK : " + id + " akan dihapus secara permanent",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF5733',
            cancelButtonColor: '#B2BABB',
            confirmButtonText: 'Yes, delete!'
            }).then((result) => {
                if (result.value) {
                    window.location.href = getLink;
                }
            })
            
        }); 

    });
</script>
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


<?php
    include_once("../footer.php"); 

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
