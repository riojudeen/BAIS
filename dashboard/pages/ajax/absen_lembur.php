<?php
//////////////////////////////////////////////////////////////////////
include_once("../../../config/config.php");

// echo $_POST['end'];
// echo $_POST['tdata'];

$_SESSION['functional'] = "";
$_SESSION['shift'] = "";
$_SESSION['area'] = "";
$_SESSION['dept'] = "";
$_SESSION['monitor'] = "";
$_SESSION['cari'] = "";
$_SESSION['start'] = "";
$_SESSION['end'] = "";
$_SESSION['tdata'] = "";
$index = 0;
// query jumlah
$t = "org.".$org_access;
$qry_karyawan = "SELECT karyawan.npk AND org.npk FROM karyawan LEFT JOIN org ON org.npk = karyawan.npk WHERE $t = '$access_'";
$sqlKaryawan = mysqli_query($link, $qry_karyawan)or die(mysqli_error($link));
$jml_karyawan = mysqli_num_rows($sqlKaryawan);

if(isset($_POST['dept']) OR isset($_POST['area']) OR isset($_POST['shift']) OR isset($_POST['functional']) OR isset($_POST['monitor']) OR isset($_POST['cari']) OR isset($_POST['start']) OR isset($_POST['end']) OR isset($_POST['tdata'])){
    if(isset($_POST['start'])){
        $_SESSION['start'] .= $_POST['start'];
        
    }else{
        $_SESSION['start'] = "";
    }
    if(isset($_POST['end'])){
        $_SESSION['end'] .= $_POST['end'];
        
    }else{
        $_SESSION['end'] = "";
    }
    if(isset($_POST['cari'])){
        $_SESSION['cari'] .= $_POST['cari'];
        
    }else{
        $_SESSION['cari'] = "";
    }
    if(isset($_POST['tdata'])){
        $_SESSION['tdata'] .=  $_POST['tdata'];
    }else{
        $_SESSION['tdata'] = "";
    }

    if(isset($_POST['dept'])){
        foreach($_POST['dept'] AS $dept){
            $_SESSION['dept'] .= "OR org.dept_account = '$dept' ";
            // echo $qry_dept;
        }
    }else{
        $_SESSION['dept'] = "";
    }

    if(isset($_POST['monitor'])){
        foreach($_POST['monitor'] AS $monitor){
            $mon[$index++] = $monitor;
            // echo $qry_dept;
        }
    }else{
        $mon[$index++] = "absensi";
    }

    if(isset($_POST['area'])){
        foreach($_POST['area'] AS $area){
            $_SESSION['area'] .= "OR org.grp = '$area' ";
            // echo $qry_area;
        }
    }else{
        $_SESSION['area'] .= "";
    }

    if(isset($_POST['shift'])){
        foreach($_POST['shift'] AS $shift){
            $_SESSION['shift'] .= "OR karyawan.shift = '$shift' ";
            // echo $qry_shift;
        }
    }else{
        $_SESSION['shift'] .= "";
    }

    if(isset($_POST['functional'])){
        foreach($_POST['functional'] AS $functional){
            $_SESSION['functional'] .= "OR org.dept_account = '$functional' ";
            // echo $qry_functional;
        }
    }else{
        $_SESSION['functional'] .= "";
    }
    
}else{
    $_SESSION['functional'] = "";
    $_SESSION['shift']  = "";
    $_SESSION['area'] = "";
    $_SESSION['dept'] = "";
    $_SESSION['monitor'] = "";
    $_SESSION['cari'] = "";
    $_SESSION['start'] = "";
    $_SESSION['end'] = "";
    $_SESSION['tdata'] = '10';
    $mon[$index++] = "absensi";
    
}
$shift = ($_SESSION['shift'] != '')?'AND ('.substr($_SESSION['shift'], 2).')':"";
$dept = ($_SESSION['dept'] != '')?'AND ('.substr($_SESSION['dept'], 2).')':"";
$functional = ($_SESSION['functional'] != '')?'AND ('.substr($_SESSION['functional'], 2).')':"";
$area = ($_SESSION['area'] != '')?'AND ('.substr($_SESSION['area'], 2).')':"";
$cari = ($_SESSION['cari'] != '')? "AND ( karyawan.npk LIKE '%$_SESSION[cari]%' OR karyawan.nama LIKE '%$_SESSION[cari]%' )":"";

$batas_atas = $jml_karyawan;
if($_SESSION['tdata'] == '' || $_SESSION['tdata'] < 0){
    $limit = "LIMIT 0";
}else if($_SESSION['tdata'] > $batas_atas ){
    $limit = "LIMIT ".$batas_atas ;
}else{
    $limit = "LIMIT ".$_SESSION['tdata'] ;
}


// $_SESSION['functional'];
// $_SESSION['shift'];
// $_SESSION['area'];
// $_SESSION['dept'];
// $_SESSION['monitor'];
// $_SESSION['cari'];
// $_SESSION['start'];
// $_SESSION['end'];
// $_SESSION['data'];

$start_date = ($_SESSION['start'] == "")? date('Y-m-01'): dateToDB($_SESSION['start']);
$end_date = ($_SESSION['end'] == "")? date('Y-m-d'): dateToDB($_SESSION['end']);

// echo $functional."<br>";
// echo $shift."<br>";
// echo $area."<br>";
// echo $dept."<br>";
// // echo print_r($_SESSION['monitor']);
// echo $cari."<br>";
// echo $start_date."<br>";
// echo $end_date."<br>";
// echo $limit."<br>";

$t = "org.".$org_access;
$qryMonitoring = "SELECT karyawan.npk AS npk_karyawan,
    karyawan.nama AS nama_karyawan,
    karyawan.shift AS shift_karyawan,
    
    org.npk AS npk_org,
    org.post AS post_org,
    org.grp AS grp_org,
    org.sect AS sect_org,
    org.dept AS dept_org,
    org.dept_account AS dept_account,
    org.division AS div_org,
    org.plant AS plant_org,
    
    groupfrm.id_group AS idGroup,
    groupfrm.nama_group AS groupfrm,
    groupfrm.npk_cord AS group_cord,
    groupfrm.id_section AS id_sect,

    dept_account.id_dept_account AS idDeptAcc,
    dept_account.department_account AS deptAcc,
    dept_account.npk_dept AS mg, 
    dept_account.id_div AS id_div
    
    FROM karyawan
    LEFT JOIN org ON org.npk = karyawan.npk
    LEFT JOIN groupfrm ON groupfrm.id_group = org.grp
    LEFT JOIN dept_account ON dept_account.id_dept_account = org.dept_account


    WHERE  $t = '$access_' $functional $area $dept $shift $cari";

    $sql_MP = mysqli_query($link, $qryMonitoring)or die(mysqli_error($link));
    // echo mysqli_num_rows($sql_);
$qryMonitoringAbsen = "SELECT karyawan.npk AS npk_karyawan,
    karyawan.nama AS nama_karyawan,
    karyawan.shift AS shift_karyawan,
    
    org.npk AS npk_org,
    org.post AS post_org,
    org.grp AS grp_org,
    org.sect AS sect_org,
    org.dept AS dept_org,
    org.dept_account AS dept_account,
    org.division AS div_org,
    org.plant AS plant_org,
    
    groupfrm.id_group AS idGroup,
    groupfrm.nama_group AS groupfrm,
    groupfrm.npk_cord AS group_cord,
    groupfrm.id_section AS id_sect,

    dept_account.id_dept_account AS idDeptAcc,
    dept_account.department_account AS deptAcc,
    dept_account.npk_dept AS mg, 
    dept_account.id_div AS id_div,
    
    absensi.id AS id_absenHR,
    absensi.npk AS npk_absenHR, 
    absensi.shift AS shift_absen,
    absensi.date AS tanggalHR,
    absensi.check_in AS check_inHR,
    absensi.check_out AS check_outHR,
    absensi.ket AS ket,
    absensi.id_req AS id_reqAbsen,

    req_absensi.id AS id_absen,
    req_absensi.npk AS npk_absen,
    req_absensi.shift AS shift_absenReq,
    req_absensi.date AS tanggal,
    req_absensi.date_in AS tanggal_masuk,
    req_absensi.date_out AS tanggal_keluar,
    req_absensi.check_in AS check_in,
    req_absensi.check_out AS check_out,
    req_absensi.keterangan AS keterangan,
    req_absensi.requester AS requester,
    req_absensi.status AS status_absen,
    req_absensi.req_status AS req_status,
    req_absensi.req_date AS req_date
    
    FROM karyawan
    LEFT JOIN org ON org.npk = karyawan.npk
    LEFT JOIN groupfrm ON groupfrm.id_group = org.grp
    LEFT JOIN dept_account ON dept_account.id_dept_account = org.dept_account

    LEFT JOIN absensi ON absensi.npk = karyawan.npk
    LEFT JOIN req_absensi ON req_absensi.id = absensi.id_req

    WHERE  $t = '$access_' ";

    $sql_Absen = mysqli_query($link, $qryMonitoringAbsen)or die(mysqli_error($link));
    // echo mysqli_num_rows($sql_);
        
$qryMonitoringLembur = "SELECT 
    karyawan.npk AS npk_karyawan,
    karyawan.nama AS nama_karyawan,
    karyawan.shift AS shift_karyawan,
    
    org.npk AS npk_org,
    org.post AS post_org,
    org.grp AS grp_org,
    org.sect AS sect_org,
    org.dept AS dept_org,
    org.dept_account AS dept_account,
    org.division AS div_org,
    org.plant AS plant_org,
    
    groupfrm.id_group AS idGroup,
    groupfrm.nama_group AS groupfrm,
    groupfrm.npk_cord AS group_cord,
    groupfrm.id_section AS id_sect,

    dept_account.id_dept_account AS idDeptAcc,
    dept_account.department_account AS deptAcc,
    dept_account.npk_dept AS mg, 
    dept_account.id_div AS id_div,
    
    -- -- attendance_code.kode AS kode_absen,
    -- -- attendance_code.keterangan AS ket_kode_absen,
    -- -- attendance_code.type AS tipe_kode_absen,

    hr_lembur.id AS id_lemburHr,
    hr_lembur.npk AS npk_lemburHr,
    hr_lembur.date AS date_lemburHr,
    hr_lembur.start AS start_lemburHr,
    hr_lembur.end AS end_lemburHr,
    hr_lembur.id_req AS id_reqLembur,

    lembur._id AS id_lembur, 
    lembur.kode_lembur AS kode_lembur, 
    lembur.requester AS requester, 
    lembur.npk AS npk_lembur,
    lembur.in_date AS in_date,
    lembur.out_date AS out_date,
    lembur.in_lembur AS start_lembur,
    lembur.out_lembur AS end_lembur,
    lembur.kode_job AS kode_job,
    lembur.aktifitas AS activity,
    lembur.tanggal_input AS tgl_input,
    lembur.status_approve AS statApp,
    lembur.status AS stats
    
    
    FROM karyawan
    LEFT JOIN org ON org.npk = karyawan.npk
    LEFT JOIN groupfrm ON groupfrm.id_group = org.grp
    LEFT JOIN dept_account ON dept_account.id_dept_account = org.dept_account
    

    LEFT JOIN lembur ON lembur.npk = karyawan.npk
    LEFT JOIN hr_lembur ON lembur._id = hr_lembur.id_req
    
    
    WHERE  $t = '$access_'";

    $sql_Lembur = mysqli_query($link, $qryMonitoringLembur)or die(mysqli_error($link));
       
        // -- WHERE absensi.date BETWEEN '2021-05-03' AND '2021-05-03' AND $t = '$access_' "
            
 
    //jika tanggal tidak diset
    $hari_ini = $start_date ;

    $tgl_pertama = date('Y-m-01', strtotime($hari_ini));
    $tgl_terakhir = date('Y-m-t', strtotime($hari_ini));

    $sampai = (isset($end_date)) ? $end_date : $hari_ini;
    $dari = (isset($start_date)) ? $start_date : $tgl_pertama;

    //menghitung total hari
    $start = $month = strtotime($dari);
    $end = strtotime($sampai);

    $awal = date_create($dari);
    $akhir = date_create($sampai);
    $jml = date_diff($awal,$akhir);
    $jml_hari = $jml->days +1;

    $no_urut = 1;

    // total monitor
    $totalMonitoring = count($mon);
    // echo $totalMonitoring;
    // echo $mon['0'];
?>
<div class="table-responsive table-bordered" style="height:600px">
    <table class="table table-hover text-nowrap text-uppercase" rules="cols" style="border: #C6C7C8">
    
        <thead class="text-white text-center bg-danger" style="border: #C6C7C8">
            <tr >
                <th scope="col" rowspan="2">No</th>
                <th scope="col" rowspan="2">NPK</th>
                <th scope="col" rowspan="2">Nama</th>
                <th scope="col" rowspan="2">SHF</th>
                <th scope="col" rowspan="2">area</th>
                <th scope="col" rowspan="2">dept</th>
                <th scope="col" rowspan="2">Monitor</th>
                <?php
                    $offset = 10; //triger offset untuk limit

                    $i = 0;
                    $array_tgl = array();
                    while($month <= $end){
                        $tgl = date('Y-m-d', $month);
                        $month = strtotime("+1 day", $month);
                        $hari = hari_singkat($tgl);
                        $array_tgl[$i++] = $tgl;
                        $color = ($hari == "Sab" || $hari == "Min" ) ? "background: rgba(211, 84, 0, 0.3)" : "";

                        echo "<th scope=\"col\" colspan=\"3\" style=\"text-align: center;".$color++."\">$tgl</th>";
                    }
                ?>
                <th scope="col" colspan="10">Rekap Absen</th>

                <tr>
                <?php
                for($i = 0; $i < $jml_hari ; $i++){
                    $date = $array_tgl[$i];
                    $cell_ = date('D, d - M', strtotime($date));
                    $cell = explode(' ', $cell_);
                    $color = ($cell['0'] == "Sun," || $cell['0'] == "Sat," ) ? "style=\"background: rgba(211, 84, 0, 0.3)\"" : "";
                    
                    echo "<th $color scope=\"col\">IN</th>
                    <th $color scope=\"col\" >OUT</th>
                    <th $color scope=\"col\" >KET</th>";
                }
                ?>
                <th scope="col" rowspan="1">S1</th>
                <th scope="col" rowspan="1">S2</th>
                <th scope="col" rowspan="1">T1</th>
                <th scope="col" rowspan="1">T2</th>
                <th scope="col" rowspan="1">T3</th>
                <th scope="col" rowspan="1">TL</th>
                <th scope="col" rowspan="1">M</th>
                <th scope="col" rowspan="1">C1</th>
                <th scope="col" rowspan="1">C2</th>
                <th scope="col" rowspan="1">Others</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            //query mp
            $no_spl = 1;
            $qryMonitoring .= " $limit";
            // echo $qryMonitoring;
            $sql_monMp = mysqli_query($link, $qryMonitoring)or die(mysqli_error($link));
            
            while($data_mon = mysqli_fetch_assoc($sql_monMp)){
                //query lembur sesuai dengan npk karyawan
                // $sql_lembur = "SELECT * FROM lembur WHERE npk = $data_mon[npk_karyawan]";
                // $lembur = mysqli_query($link, $sql_lembur)or die(mysqli_error($link));
                
                ?>
            <tr>
                <th rowspan="<?=$totalMonitoring?>" scope="row"><?=$no_spl++?></td>
                <td rowspan="<?=$totalMonitoring?>"><?=$data_mon['npk_karyawan']?></td>
                <td rowspan="<?=$totalMonitoring?>"><?=$data_mon['nama_karyawan']?></td>
                <td rowspan="<?=$totalMonitoring?>"><?=$data_mon['shift_karyawan']?></td>
                <td rowspan="<?=$totalMonitoring?>"><?=$data_mon['groupfrm']?></td>
                <td rowspan="<?=$totalMonitoring?>"><?=$data_mon['deptAcc']?></td>
                <?php
                
                for($indexMon = 0 ; $indexMon < $totalMonitoring ; $indexMon++){
                    ?>
                    <td ><?=$mon[$indexMon]?></td>
                    <?php
                    if($mon[$indexMon] == 'absensi'){
                        foreach($array_tgl as $tgl_){//looping tanggal request
                            //ambil array data lembur 
                            $qry_absen = $qryMonitoringAbsen." AND absensi.npk = '$data_mon[npk_karyawan]' AND absensi.date = '$tgl_' ";
                            
                            $sqlAbsen = mysqli_query($link, $qry_absen)or die(mysqli_error($link));
                            $dataAbsen = mysqli_fetch_assoc($sqlAbsen);

                            $check_in = ($dataAbsen['check_inHR'] == "00:00:00")?"":$dataAbsen['check_inHR'];
                            $check_out = ($dataAbsen['check_outHR'] == "00:00:00")?"":$dataAbsen['check_outHR'];
                            $hari = hari_singkat($tgl_);
                            $color = ($hari == "Sab" || $hari == "Min" ) ? "background: rgba(228, 227, 227, 0.5)" : "";

                            switch($dataAbsen['status_absen']){
                                case '':
                                    $bg_color = "";
                                    $text_color = "";
                                    $text_tooltip = "BELUM ADA PENGAJUAN";
                                    break;
                                case '0':
                                    $bg_color = "muted";
                                    $text_color = "danger";
                                    $text_tooltip = "DRAFT PENGAJUAN";
                                    break;

                                case '25':
                                    $bg_color = "danger";
                                    $text_color = "white";
                                    $text_tooltip = "WAITING APPROVAL";
                                    break;

                                case '50':
                                    $bg_color = "warning";
                                    $text_color = "white";
                                    $text_tooltip = "WAITING ADMIN PROCESS";
                                    break;
                                case '75':
                                    $bg_color = "info";
                                    $text_color = "white";
                                    $text_tooltip = "ADMIN PROCESS";
                                    break;
                                case '100':
                                    $bg_color = "success";
                                    $text_color = "white";
                                    $text_tooltip = "CLOSE / SUCCESS";
                                    break;
                            }
                            $tooltipIn = ($dataAbsen['status_absen'] != '')?"data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"$dataAbsen[check_in]\"":"";
                            $tooltipOut = ($dataAbsen['status_absen'] != '')?"data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"$dataAbsen[check_out]\"":"";
                            $tooltipKet = ($dataAbsen['status_absen'] != '')?"data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"$dataAbsen[keterangan] - STATUS : $text_tooltip\"":"";
                            
                            ?>
                            
                            <td class="bg-<?=$bg_color?> text-<?=$text_color?>" style="<?=$color?>" <?=$tooltipIn?>><?=$check_in?></td>
                            <td class="bg-<?=$bg_color?> text-<?=$text_color?>" style="<?=$color?>" <?=$tooltipOut?>><?=$check_out?></td>
                            <td class="bg-<?=$bg_color?> text-<?=$text_color?>" style="<?=$color?>" <?=$tooltipKet?>><?=$dataAbsen['ket']?></td>
                            <?php
                        }
                        $qry_absen = $qryMonitoringAbsen." AND absensi.npk = '$data_mon[npk_karyawan]'";
                        $qry_M = $qry_absen." AND absensi.ket = 'M' ";
                        $qry_TL = $qry_absen." AND absensi.ket = 'TL' ";
                        $qry_C1 = $qry_absen." AND absensi.ket = 'C1' ";
                        $qry_C2 = $qry_absen." AND absensi.ket = 'C2' ";
                        $qry_S1 = $qry_absen." AND absensi.ket = 'S1' ";
                        $qry_S2 = $qry_absen." AND absensi.ket = 'S2' ";
                        $qry_T1 = $qry_absen." AND absensi.ket = 'T1' ";
                        $qry_T2 = $qry_absen." AND absensi.ket = 'T2' ";
                        $qry_T3 = $qry_absen." AND absensi.ket = 'T3' ";
                        $qry_Oth = $qry_absen." AND absensi.ket <> '' ";

                        $total_M = mysqli_num_rows(mysqli_query($link, $qry_M));
                        $total_C1 = mysqli_num_rows(mysqli_query($link, $qry_C1));
                        $total_C2 = mysqli_num_rows(mysqli_query($link, $qry_C2));
                        $total_S1 = mysqli_num_rows(mysqli_query($link, $qry_S1));
                        $total_S2 = mysqli_num_rows(mysqli_query($link, $qry_S2));
                        $total_T1 = mysqli_num_rows(mysqli_query($link, $qry_T1));
                        $total_T2 = mysqli_num_rows(mysqli_query($link, $qry_T2));
                        $total_T3 = mysqli_num_rows(mysqli_query($link, $qry_T3));
                        $total_TL = mysqli_num_rows(mysqli_query($link, $qry_TL));
                        $total_Oth = mysqli_num_rows(mysqli_query($link, $qry_Oth));
                        $other = $total_Oth - ($total_M + $total_C1 + $total_C2 +$total_S1 +$total_S2+$total_T1+$total_T2+$total_T3+$total_TL);


                        ?>
                        <td rowspan="<?=$totalMonitoring?>"><?=$total_S1?></td>
                        <td rowspan="<?=$totalMonitoring?>"><?=$total_S2?></td>
                        <td rowspan="<?=$totalMonitoring?>"><?=$total_T1?></td>
                        <td rowspan="<?=$totalMonitoring?>"><?=$total_T2?></td>
                        <td rowspan="<?=$totalMonitoring?>"><?=$total_T3?></td>
                        <td rowspan="<?=$totalMonitoring?>"><?=$total_TL?></td>
                        <td rowspan="<?=$totalMonitoring?>"><?=$total_M?></td>
                        <td rowspan="<?=$totalMonitoring?>"><?=$total_C1?></td>
                        <td rowspan="<?=$totalMonitoring?>"><?=$total_C2?></td>
                        <td rowspan="<?=$totalMonitoring?>"><?=$other?></td>
                        
                        <?php
                        if($totalMonitoring > 1){
                            echo "</tr><tr>";
                        }else{
                            echo "";
                        }
                    }else{
                        foreach($array_tgl as $tgl_){//looping tanggal request
                            //ambil array data lembur 
                            $qry_Lembur = $qryMonitoringLembur." AND (lembur.npk = '$data_mon[npk_karyawan]' AND lembur.in_date = '$tgl_')  ";
                            $sqlLembur = mysqli_query($link, $qry_Lembur)or die(mysqli_error($link));
                            $dataLembur = mysqli_fetch_assoc($sqlLembur);
                            $check_in = ($dataLembur['start_lembur'] == "00:00:00")?"":$dataLembur['start_lembur'];
                            $check_out = ($dataLembur['end_lembur'] == "00:00:00")?"":$dataLembur['end_lembur'];
                            $hari = hari_singkat($tgl_);
                            $ket = $dataLembur['kode_job'];

                            $color = ($hari == "Sab" || $hari == "Min" ) ? "background: rgba(228, 227, 227, 0.5)" : "";
                            switch($dataLembur['statApp']){
                                case 0:
                                $bg_color = "";
                                $text_color = "danger";
                                $text_tooltip = "DRAFT PENGAJUAN";
                                break;
                                case 25:
                                $bg_color = "danger";
                                $text_color = "white";
                                $text_tooltip = "WAITING APPROVAL";
                                break;
                                case 50:
                                $bg_color = "warning";
                                $text_color = "white";
                                $text_tooltip = "WAITING ADMIN PROCESS";
                                break;
                                case 75 :
                                $bg_color = "info";
                                $text_color = "white";
                                $text_tooltip = "ADMIN PROCESS";
                                break;
                                case 100:
                                $bg_color = "success";
                                $text_color = "white";
                                $text_tooltip = "CLOSE / SUCCESS";
                                break;
                            }
                            $tooltipIn = ($dataLembur['statApp'] != '')?"data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"$check_in \"":"";
                            $tooltipOut = ($dataLembur['statApp'] != '')?"data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"$check_out\"":"";
                            $tooltipKet = ($dataLembur['statApp'] !== '')?"data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"$ket - STATUS : $text_tooltip\"":"";
                            
                            ?>
                            
                            <td class="bg-<?=$bg_color?> text-<?=$text_color?>" style="<?=$color?>" <?=$tooltipIn?>><?=$check_in?></td>
                            <td class="bg-<?=$bg_color?> text-<?=$text_color?>" style="<?=$color?>" <?=$tooltipOut?>><?=$check_out?></td>
                            <td class="bg-<?=$bg_color?> text-<?=$text_color?>" style="<?=$color?>" <?=$tooltipKet?>><?=$ket?></td>
                            <?php
                        }
                        
                        if($totalMonitoring > 1){
                            echo "</tr><tr>";
                        }else{
                            echo "";
                        }
                    }
                }

                ?>
                
                
                <?php
                
                
                
                
                ?>
                
            </tr>
            <?php
            }
            ?>
        </tbody>
            
    </table>
</div>
<?php
    // ///////////////////////////////////////
    // mysqli_free_result($lembur);
    // mysqli_free_result($sql_monspl);

    // // tutup koneksi dengan database mysql
    // mysqli_close($link);

    ?>