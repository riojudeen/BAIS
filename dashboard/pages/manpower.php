<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
require_once("../../config/function_status_approve.php");
require_once("../../config/function_access_query.php");
require_once("../../config/function_filter.php");
//redirect ke halaman dashboard index jika sudah ada session

$halaman = "Man Power";
if(isset($_SESSION['user'])){

    include("../header.php");
    list($clm, $area_access, $sub_area_access, $value_access) = access_area_jabatan($link, $jabatan, $npkUser);
    list($clm_access, $clm_parent, $sub_clm) = access_area_level($level);
//menghitung jumah karyawan 
$qry_Jml = "SELECT
    org.npk AS npk_org,
    org.sub_post AS sub_post,
    org.post AS post,
    org.grp AS grp,
    org.sect AS sect,
    org.dept AS dept,
    org.dept_account AS dept_account,
    org.division AS division,
    org.plant AS plant,
    karyawan.npk AS npk,
    karyawan.nama AS nama,
    karyawan.jabatan AS jabatan,
    karyawan.shift AS shift ";
    

$qry_jmlDH = $qry_Jml. ", division.id_div AS id_area,
    division.nama_divisi AS nama_area,
    division.npk_cord AS cordinator,
    division.id_company AS id_parent 
    FROM org 
    JOIN division ON division.id_div = org.division
    
    JOIN karyawan ON karyawan.npk = org.npk
    WHERE karyawan.jabatan = 'DH' OR karyawan.jabatan = 'ADH' ";

    $sql_jmlDH = mysqli_query($link, $qry_jmlDH)or die(mysqli_error($link));
    $jmlDivHead = mysqli_num_rows($sql_jmlDH);
    // echo "<br>".$jmlDivHead;

$qry_jmlDE = $qry_Jml. ", dept_account.id_dept_account AS id_area_deptAcc,
    dept_account.department_account AS nama_area_deptAcc,
    dept_account.npk_dept AS cordinator_deptAcc, 
    dept_account.id_div AS id_parent_deptAcc, 
    department.id_dept AS id_area,
    department.dept AS nama_area,
    department.npk_cord AS cordinator,
    department.id_div AS id_parent
    FROM org 
    JOIN department ON department.id_dept = org.dept
    JOIN dept_account ON dept_account.id_dept_account = org.dept_account
    JOIN karyawan ON karyawan.npk = org.npk
    WHERE karyawan.jabatan = 'MNG' OR karyawan.jabatan = 'AMNG' ";

    $sql_jmlDE = mysqli_query($link, $qry_jmlDE)or die(mysqli_error($link));
    $jmlDeptHead = mysqli_num_rows($sql_jmlDE);
    // echo "<br>".$jmlDeptHead;

$qry_jmlSH = $qry_Jml. ", dept_account.id_dept_account AS id_area_deptAcc,
    dept_account.department_account AS nama_area_deptAcc,
    dept_account.npk_dept AS cordinator_deptAcc, 
    dept_account.id_div AS id_parent_deptAcc, 
    section.id_section AS id_area,
    section.section AS nama_area,
    section.npk_cord AS cordinator,
    section.id_dept AS id_parent
    FROM org 
    JOIN section ON section.id_section = org.sect
    JOIN dept_account ON dept_account.id_dept_account = org.dept_account
    JOIN karyawan ON karyawan.npk = org.npk
    WHERE karyawan.jabatan = 'SPV' OR karyawan.jabatan = 'ASPV' ";

    $sql_jmlSH = mysqli_query($link, $qry_jmlSH)or die(mysqli_error($link));
    $jmlSectHead = mysqli_num_rows($sql_jmlSH);
    // echo "<br>".$jmlSectHead;

$qry_jmlFRM = $qry_Jml. ", dept_account.id_dept_account AS id_area_deptAcc,
    dept_account.department_account AS nama_area_deptAcc,
    dept_account.npk_dept AS cordinator_deptAcc, 
    dept_account.id_div AS id_parent_deptAcc,

    groupfrm.id_group AS id_area,
    groupfrm.nama_group AS nama_area,
    groupfrm.npk_cord AS cordinator,
    groupfrm.id_section AS id_parent
    FROM org 
    JOIN groupfrm ON groupfrm.id_group = org.grp
    JOIN dept_account ON dept_account.id_dept_account = org.dept_account
    JOIN karyawan ON karyawan.npk = org.npk
    WHERE karyawan.jabatan = 'FRM' OR karyawan.jabatan = 'AFRM' ";

    $sql_jmlFRM = mysqli_query($link, $qry_jmlFRM)or die(mysqli_error($link));
    $jmlForeman = mysqli_num_rows($sql_jmlFRM);
    // echo "<br>".$jmlForeman;

$qry_jmlTL = $qry_Jml. ", dept_account.id_dept_account AS id_area_deptAcc,
    dept_account.department_account AS nama_area_deptAcc,
    dept_account.npk_dept AS cordinator_deptAcc, 
    dept_account.id_div AS id_parent_deptAcc,
    pos_leader.id_post AS id_area,
    pos_leader.nama_pos AS nama_area,
    pos_leader.npk_cord AS cordinator,
    pos_leader.id_group AS id_parent
    FROM org 
    JOIN pos_leader ON pos_leader.id_post = org.post
    JOIN dept_account ON dept_account.id_dept_account = org.dept_account
    JOIN karyawan ON karyawan.npk = org.npk
    WHERE karyawan.jabatan = 'TL' OR karyawan.jabatan = 'ATL' ";

    $sql_jmlTL = mysqli_query($link, $qry_jmlTL)or die(mysqli_error($link));
    $jmlTL = mysqli_num_rows($sql_jmlTL);
    // echo "<br>".$jmlTL;

$qry_jmlTM = $qry_Jml. ", dept_account.id_dept_account AS id_area_deptAcc,
    dept_account.department_account AS nama_area_deptAcc,
    dept_account.npk_dept AS cordinator_deptAcc, 
    dept_account.id_div AS id_parent_deptAcc,
    pos_leader.id_post AS id_area,
    pos_leader.nama_pos AS nama_area,
    pos_leader.npk_cord AS cordinator,
    pos_leader.id_group AS id_parent
    FROM org 
    JOIN pos_leader ON pos_leader.id_post = org.post
    JOIN dept_account ON dept_account.id_dept_account = org.dept_account
    JOIN karyawan ON karyawan.npk = org.npk
    WHERE karyawan.jabatan = 'TM' ";

    $sql_jmlTM = mysqli_query($link, $qry_jmlTM)or die(mysqli_error($link));
    $jmlTM = mysqli_num_rows($sql_jmlTM);
    // echo "<br>".$jmlTM;

    $total = $jmlTM + $jmlTL + $jmlSectHead + $jmlForeman + $jmlDeptHead + $jmlDivHead;
    // echo "<br>".$total;

$qry_JabKar = " SELECT karyawan.npk AS npk,
    karyawan.nama AS nama,
    karyawan.jabatan AS jabatan,
    karyawan.shift AS shift,
    org.npk AS npk_org,
    org.sub_post AS sub_post,
    org.post AS post,
    org.grp AS grp,
    org.sect AS sect,
    org.dept AS dept,
    org.dept_account AS dept_account,
    org.division AS division,
    org.plant AS plant,
    dept_account.id_dept_account AS id_area_deptAcc,
    dept_account.department_account AS nama_area_deptAcc,
    dept_account.npk_dept AS cordinator_deptAcc, 
    dept_account.id_div AS id_parent_deptAcc 
    FROM org
    JOIN dept_account ON dept_account.id_dept_account = org.dept_account
    JOIN karyawan ON karyawan.npk = org.npk";

$qry_JabKarDH = " SELECT karyawan.npk AS npk,
    karyawan.nama AS nama,
    karyawan.jabatan AS jabatan,
    karyawan.shift AS shift,
    org.npk AS npk_org,
    org.sub_post AS sub_post,
    org.post AS post,
    org.grp AS grp,
    org.sect AS sect,
    org.dept AS dept,
    org.dept_account AS dept_account,
    org.division AS division,
    org.plant AS plant
    FROM org
    JOIN karyawan ON karyawan.npk = org.npk";

$q_DH = $qry_JabKarDH." WHERE karyawan.jabatan = 'DH' OR karyawan.jabatan = 'ADH' ";
$s_DH = mysqli_query($link, $q_DH)or die(mysqli_error($link));
$j_DH = mysqli_num_rows($s_DH);
// echo "<br>".$j_DH;

$q_DE = $qry_JabKar." WHERE karyawan.jabatan = 'MNG' OR karyawan.jabatan = 'AMNG' ";
$s_DE = mysqli_query($link, $q_DE)or die(mysqli_error($link));
$j_DE = mysqli_num_rows($s_DE);
// echo "<br>".$j_DE;

$q_SH = $qry_JabKar." WHERE karyawan.jabatan = 'SPV' OR karyawan.jabatan = 'ASPV' ";
$s_SH = mysqli_query($link, $q_SH)or die(mysqli_error($link));
$j_SH = mysqli_num_rows($s_SH);
// echo "<br>".$j_SH;

$q_FRM = $qry_JabKar." WHERE karyawan.jabatan = 'FRM' OR karyawan.jabatan = 'AFRM' ";
$s_FRM = mysqli_query($link, $q_FRM)or die(mysqli_error($link));
$j_FRM = mysqli_num_rows($s_FRM);
// echo "<br>".$j_FRM;

$q_TL = $qry_JabKar." WHERE karyawan.jabatan = 'TL' OR karyawan.jabatan = 'ATL' ";
$s_TL = mysqli_query($link, $q_TL)or die(mysqli_error($link));
$j_TL = mysqli_num_rows($s_TL);
// echo "<br>".$j_TL;

$q_TM = $qry_JabKar." WHERE karyawan.jabatan = 'TM' ";
$s_TM = mysqli_query($link, $q_TM)or die(mysqli_error($link));
$j_TM = mysqli_num_rows($s_TM);
// echo "<br>".$j_TM;



    echo "<br>".$clm_access;
    echo "<br>";
    echo $clm_parent;
    echo "<br>";
    echo $sub_clm;
    echo "<br>";

if($level == 1){
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";

}else if($level == 2){
    //lihat data organisasi dan data man power
    $query = mysqli_query($link, "SELECT * FROM org WHERE npk = '$npkUser' ")or die(mysqli_error($link));
    $dataaccess_org = mysqli_fetch_assoc($query);
    $access_org = $dataaccess_org['division'];
    $table_parent = 'division';
    $clm_parent_ = 'id_div';
    $select_parent = "division.id_div AS id_area,
        division.nama_divisi AS nama_area,
        division.npk_cord AS cordinator,
        division.id_company AS id_parent";
    $table_join = 'department';
    $id_join = 'department.id_div';
    $select_join = "department.id_dept AS id_area,
        department.dept AS nama_area,
        department.npk_cord AS cordinator,
        department.id_div AS id_parent";
    $qryDept_account = '';
    $joinDeptAcc = "";
    $clauseDeptAcc = "";
    
}else if($level == 3){
    //lihat data organisasi dan data man power
    $query = mysqli_query($link, "SELECT * FROM org WHERE npk = '$npkUser' ")or die(mysqli_error($link));
    $dataaccess_org = mysqli_fetch_assoc($query);
    $access_org = $dataaccess_org['grp'];
    $table_parent = 'groupfrm';
    $clm_parent_ = 'id_group';
    $select_parent = "groupfrm.id_group AS id_area,
        groupfrm.nama_group AS nama_area,
        groupfrm.npk_cord AS cordinator,
        groupfrm.id_section AS id_parent";
    $table_join = 'pos_leader';
    
    $id_join = 'pos_leader.id_group';
    $select_join = "pos_leader.id_post AS id_area,
        pos_leader.nama_pos AS nama_area,
        pos_leader.npk_cord AS cordinator,
        pos_leader.id_group AS id_parent";
    $qryDept_account = '';
    $joinDeptAcc = "";
    $clauseDeptAcc = "";
}else if($level == 4){
    //lihat data organisasi dan data man power 
    $query = mysqli_query($link, "SELECT * FROM org WHERE npk = '$npkUser' ")or die(mysqli_error($link));
    $dataaccess_org = mysqli_fetch_assoc($query);
    $access_org = $dataaccess_org['sect'];
    $table_parent = 'section';
    $clm_parent_ = 'id_section';
    $table_join = 'groupfrm';
    $select_parent = "section.id_section AS id_area,
        section.section AS nama_area,
        section.npk_cord AS cordinator,
        section.id_dept AS id_parent";
    $id_join = 'groupfrm.id_section';
    $select_join = "groupfrm.id_group AS id_area,
        groupfrm.nama_group AS nama_area,
        groupfrm.npk_cord AS cordinator,
        groupfrm.id_section AS id_parent";
    $qryDept_account = '';
    $joinDeptAcc = "";
    $clauseDeptAcc = "";

}else if($level == 5){
    //lihat data organisasi dan data man power 
    $query = mysqli_query($link, "SELECT * FROM org WHERE npk = '$npkUser' ")or die(mysqli_error($link));
    $dataaccess_org = mysqli_fetch_assoc($query);
    $access_org = $dataaccess_org['dept'];
    $table_parent = 'department';
    $clm_parent_ = 'id_dept';
    $select_parent = "department.id_dept AS id_area,
        department.dept AS nama_area,
        department.npk_cord AS cordinator,
        department.id_div AS id_parent";
    $table_join = 'section';
    $id_join = 'section.id_dept';
    $select_join = "section.id_section AS id_area,
        section.section AS nama_area,
        section.npk_cord AS cordinator,
        section.id_dept AS id_parent";
    $qryDept_account = '';
    $joinDeptAcc = "";
    $clauseDeptAcc = "";
       
}else if($level == 6){
    //lihat data organisasi dan data man power 
    $query = mysqli_query($link, "SELECT * FROM org WHERE npk = '$npkUser' ")or die(mysqli_error($link));
    $dataaccess_org = mysqli_fetch_assoc($query);
    $access_org = $dataaccess_org['division'];
    $table_parent = 'dept_account';
    $clm_parent_ = 'id_dept_account';
    $table_join = 'department';
    $id_join = 'department.id_div';
    $select_join = "department.id_dept AS id_area,
        department.dept AS nama_area,
        department.npk_cord AS cordinator,
        department.id_div AS id_parent";
    $qryDept_account = "dept_account.id_dept_account AS id_area,
        dept_account.department_account AS nama_area,
        dept_account.npk_dept AS cordinator, 
        dept_account.id_div AS id_parent,";
    $joinDeptAcc = " JOIN dept_account ON dept_account.id_dept_account = org.dept_account";
    $clauseDeptAcc = " AND org.dept_account = '$access_' ";

}else if($level == 7){
    //lihat data organisasi dan data man power 
    $query = mysqli_query($link, "SELECT * FROM org WHERE npk = '$npkUser' ")or die(mysqli_error($link));
    $dataaccess_org = mysqli_fetch_assoc($query);
    $access_org = $dataaccess_org['division'];
    $table_parent = 'division';
    $clm_parent_ = 'id_div';
    $select_parent = "division.id_div AS id_area,
        division.nama_divisi AS nama_area,
        division.npk_cord AS cordinator,
        division.id_company AS id_parent";
    $table_join = 'department';
    $id_join = 'department.id_div';
    $select_join = "department.id_dept AS id_area,
        department.dept AS nama_area,
        department.npk_cord AS cordinator,
        department.id_div AS id_parent";
    $qryDept_account = '';
    $joinDeptAcc = "";
    $clauseDeptAcc = "";
    
}else if($level == 8 ){
    //lihat data organisasi dan data man power 
    $query = mysqli_query($link, "SELECT * FROM org WHERE npk = '$npkUser' ")or die(mysqli_error($link));
    $dataaccess_org = mysqli_fetch_assoc($query);
    $access_org = $dataaccess_org['division'];
    $table_parent = 'division';
    $clm_parent_ = 'id_div';
    $select_parent = "division.id_div AS id_area,
        division.nama_divisi AS nama_area,
        division.npk_cord AS cordinator,
        division.id_company AS id_parent";
    $table_join = 'department';
    $id_join = 'department.id_div';
    $select_join = "department.id_dept AS id_area,
        department.dept AS nama_area,
        department.npk_cord AS cordinator,
        department.id_div AS id_parent";

    $qryDept_account = '';
    $joinDeptAcc = "";
    $clauseDeptAcc = "";

}

$qry = "SELECT karyawan.npk AS npk,
karyawan.shift AS shift,
karyawan.nama AS nama,
karyawan.jabatan AS jabatan,
org.npk AS npk_org,
$qryDept_account
$select_join
FROM karyawan 
JOIN org ON karyawan.npk = org.npk
$joinDeptAcc
JOIN $table_join ON $sub_clm = $id_join
WHERE $clm_parent = '$access_org' $clauseDeptAcc";

$qry_area = "SELECT $select_join FROM $table_join WHERE $id_join = '$access_org' ";
//area user
$q_area = ($level == 6)?substr($qryDept_account, 0, -1):$select_parent;
$sql_area_user = mysqli_query($link, "SELECT $q_area FROM $table_parent WHERE $clm_parent_ = '$access_' ")or die(mysqli_error($link));

$dataAreaUser = mysqli_fetch_assoc($sql_area_user);
$dataAreaU = $dataAreaUser['nama_area'];
// echo $dataAreaU ;


// echo $qry;

$sql_area_ = mysqli_query($link, $qry)or die(mysqli_error($link));
//query
?>
    <div class="jumbotron jumbotron-fluid bg-white" style="background: url(../../assets/img/bg/federico-beccari.jpg)">
        <div class="container " >
            <h1 class="display-4 text-white mb-0"><?=$dataAreaU?></h1>
            <?php
            $jam = date('H');
            if($jam >= 0 && $jam <= 11){
                $selamat = "Selamat Pagi";
            }else if($jam >= 11 && $jam <= 15 ){
                $selamat = "Selamat Siang";
            }else if($jam >= 16 && $jam <= 18 ){
                $selamat = "Selamat Sore";
            }else if($jam >= 19 && $jam <= 23 ){
                $selamat = "Selamat Malam";
            }
            ?>
            <p class="lead text-white">Hi, <?=$nick?> , <?=$selamat?>!</p>
        </div>
    </div>
        <!--card-->

    <?php
    $sqlAreaLevel = $qry_area." GROUP BY id_area ";
    $AreabyLevel = mysqli_query($link, $sqlAreaLevel)or die(mysqli_error($link));
    $jmlArea = mysqli_num_rows($AreabyLevel);



    // echo $jmlArea;
    $max = 4;
    $min = 3;

    $data =$jmlArea;
    $baris = 12;

    $jmlhasilbaris = floor(($data*$max)/$baris);
    $sisalebar = ($data*$max)-($baris*$jmlhasilbaris);

    $sisakartu = ($baris-$sisalebar)/$max;
    
    $maxCard = 3;

    $lbr = $data*$max;
    $jmlcard = $lbr%$maxCard;
    $col = 12%$lbr;
    
    $mod = 12%13;


    $lebarCol = 12/$jmlArea;
    ?>
    <div class="row">
        <?php
        if($level > 6){
        ?>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats  text-white" style="background:#D2D2D2">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning border-right">
                                <i class="fa fa-divhead"> </i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category text-white">Division Head</p>
                                <p class="card-title stretched-link"> MP</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="" class="stretched-link view_data" id="dh"></a>
                </div>
            </div>
        </div>
        <?php
        }
        if($level > 4 ){
        ?>
        <div class="col-lg-4 col-md-6 col-sm-6" >
            <div class="card card-stats  text-white" style="background:#FD6C48">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning border-right">
                                <i class="fa fa-depthead"> </i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category text-white">Dept Head</p>
                                <p class="card-title"> MP </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="" class="stretched-link view_data" id="de"></a>
                </div>
            </div>
        </div>
        <?php
        }
        if($level > 3){
        ?>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats bg-info text-white">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning border-right">
                                <i class="fa fa-secthead"> </i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category text-white">Section Head</p>
                                <p class="card-title"> MP
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="" class="stretched-link view_data" id="sh"></a>
                </div>
            </div>
        </div>
        <?php
        }
        if($level > 2){
        ?>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats  text-white" style="background:#57E4FA">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning border-right">
                                <i class="fa fa-foreman"> </i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category text-white">Foreman</p>
                                <p class="card-title"> MP
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="" class="stretched-link view_data" id="fr"></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats text-white" style="background:#F1DB68">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-white border-right">
                            <i class="fa fa-leader"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category text-white">Team leader</p>
                                <p class="card-title"> MP
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="" class="stretched-link view_data" id="tl"></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats bg-warning">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning border-right">
                                <i class="fa fa-teammember text-white"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category text-white ">Team Member</p>
                                <p class="card-title text-white"> MP
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="" class="stretched-link view_data" id="tm"></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats bg-danger text-white">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-white border-right">
                                <i class="fa fa-permanent"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category text-white">Permanent</p>
                                <p class="card-title"> MP
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="" class="stretched-link view_data" id="p"></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats text-white bg-primary" >
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-white border-right">
                                <i class="fa fa-kontrak2"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category text-white">Kontrak 2</p>
                                <p class="card-title"> MP
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="" class="stretched-link view_data" id="k2"></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats bg-success text-white">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-white border-right">
                                <i class="fa fa-kontrak1"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category text-white">Kontrak 1</p>
                                <p class="card-title"> MP
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="" class="stretched-link view_data" id="k1"></a>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
   
    
    <?php

    include("../manpower/filter.php"); 
    ?>
    <form action="proses.php" method="GET">
        <div id="view_data"></div>
    </form>
    <?php
    if(isset($_GET['sumary'])){
        include_once("../manpower/sumary.php");
    }else{
        include_once("../manpower/daftarmp.php");
    }
    
    //footer
        include_once("../footer.php");
        ?>
         <script>
    //untuk crud masal update department
        function edit() {
            document.prosesdept.action = 'dept/edit.php';
            document.prosesdept.submit();
        }
        function hapus() {            
            var conf = confirm('yakin ingin menghapus data? ');
            if (conf) {
                document.prosesdept.action ='dept/delete.php';
                document.prosesdept.submit();
            }        
        }
    </script>
    <script>
    //untuk data tables

        // $(document).ready(function(){
        //     $('#table_mp').DataTable({
                
        //         columnDefs: [
        //             {
        //                 "searchable": false,
        //                 "orderable": false,
        //                 "targets": [0, ,9, 10]
        //             }
        //         ],
        //         "order": [1,"asc"]
        //     });
        // })
    
    </script>
    <script>
		$(document).ready(function() {
		  $('#searching').on('shown.bs.modal', function() {
			$('#focusInput').trigger('focus');
		  });
		});	
	</script>
    <script type="text/javascript">
        $(document).ready(function(){
            
            $('.view_data').click(function(e){
                e.preventDefault();
                var id = $(this).attr("id");
                $.ajax({
                    url: '../manpower/detail.php',	
                    method: 'post',
                    data: {id:id},		
                    success:function(data){		
                        $('#view_data').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                        $('#myView').modal("show");	// menampilkan dialog modal nya
                    }
                });
            });
        });

    </script>
    <!-- <script>
        chartColor = "#FFFFFF";
        ctx = document.getElementById('chartareaorg').getContext("2d");

        gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#80b6f4');
        gradientStroke.addColorStop(1, chartColor);

        gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
        gradientFill.addColorStop(1, "rgba(249, 99, 59, 0.40)");

        myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
            labels: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
            datasets: [

                {
                label: "Data",
                borderColor: '#fcc468',
                fill: true,
                backgroundColor: '#fcc468',
                hoverBorderColor: '#fcc468',
                borderWidth: 5,
                data: [100, 120, 80, 100, 90, 130, 110, 100, 80, 110, 130, 140, 130, 120, 130, 80, 100, 90, 120, 130],
                }
            ]
            },
            options: {
                indexAxis: 'y',
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
            tooltips: {
                tooltipFillColor: "rgba(0,0,0,0.5)",
                tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                tooltipFontSize: 14,
                tooltipFontStyle: "normal",
                tooltipFontColor: "#fff",
                tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                tooltipTitleFontSize: 14,
                tooltipTitleFontStyle: "bold",
                tooltipTitleFontColor: "#fff",
                tooltipYPadding: 6,
                tooltipXPadding: 6,
                tooltipCaretSize: 8,
                tooltipCornerRadius: 6,
                tooltipXOffset: 10,
            },


            legend: {
                display: false
            },
            scales: {

                yAxes: [{
                ticks: {
                    fontColor: "#9f9f9f",
                    fontStyle: "bold",
                    beginAtZero: true,
                    maxTicksLimit: 5,
                    padding: 20
                },
                gridLines: {
                    zeroLineColor: "transparent",
                    display: true,
                    drawBorder: false,
                    color: '#9f9f9f',
                }

                }],
                xAxes: [{
                barPercentage: 0.4,
                gridLines: {
                    zeroLineColor: "white",
                    display: false,

                    drawBorder: false,
                    color: 'transparent',
                },
                ticks: {
                    padding: 20,
                    fontColor: "#9f9f9f",
                    fontStyle: "bold"
                }
                }]
            }
            }
        });
    </script> -->

    <?php
    include_once("../endbody.php");
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>