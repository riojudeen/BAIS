<?php
include("../../../config/config.php"); 

?>


<div class="col-md-12 ">
    <!-- <div class="owl-carousel"> -->
    <?php
        // echo dateToDB($_GET['monitor_date']);
        // echo $_GET['dept_account'];
        // echo $_GET['shift'];
        $date = dateToDB($_GET['monitor_date']);
        $tanggal = ($_GET['monitor_date'] != '' )?" AND ( absensi.date = '$date' )":'';
        // echo $tanggal;
        $dept_account = ($_GET['dept_account'] != '')?" AND org.dept_account = '$_GET[dept_account]' ":'';
        $shift = ($_GET['shift'] != '')?" AND karyawan.shift = '$_GET[shift]'" :'' ;
        // echo $dept_account;
        $q_org = "SELECT `id`,`nama_org`,`cord`,`nama_cord`,`id_parent`,`part` FROM view_cord_area ";
        $q_div = $q_org." WHERE id_parent = '1' AND part = 'division'";
        $s_div = mysqli_query($link, $q_div )or die(mysqli_error($link));

        $index =  (isset($_GET['index']) && $_GET['index'] != 'undefined')?$_GET['index']:0;

        $q_group = mysqli_query($link,"SELECT * FROM view_daftar_area WHERE part = 'group'")or die(mysqli_error($link));
        $jml_data = mysqli_num_rows($q_group);

        $limit = $index;
        // echo $limit;
        if($limit > $jml_data){
            $limit = 0;
        }
        $q_getGroup = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'group' LIMIT $limit,1");
        $total_data = mysqli_num_rows($q_getGroup);
        $data_getGroup = mysqli_fetch_assoc($q_getGroup);
        $group_id = $data_getGroup['id'];
        if(mysqli_num_rows($s_div)>0){
            while($div=mysqli_fetch_assoc($s_div)){
                $q_dept = $q_org." WHERE id_parent = '$div[id]' AND part = 'dept'";
                $s_dept = mysqli_query($link, $q_dept )or die(mysqli_error($link));
                if(mysqli_num_rows($s_dept)>0){
                    while($dept = mysqli_fetch_assoc($s_dept)){
                        $q_sect = $q_org." WHERE id_parent = '$dept[id]' AND part = 'section'";
                        $s_sect = mysqli_query($link, $q_sect )or die(mysqli_error($link));
                        if(mysqli_num_rows($s_sect)>0){
                            while($sect = mysqli_fetch_assoc($s_sect)){
                                $q_grp = $q_org." WHERE id_parent = '$sect[id]' AND part = 'group' AND id = '$group_id' ";
                                $s_grp = mysqli_query($link, $q_grp )or die(mysqli_error($link));
                                
                                if(mysqli_num_rows($s_grp)>0){
                                    $group_name = array();
                                    $group_mp = array();
                                    $i=0;
                                    while($grp = mysqli_fetch_assoc($s_grp)){
                                        $q_cek_absen = mysqli_query($link, "SELECT absensi.npk AS 'npk_absen',
                                        absensi.check_in AS `check_in`, absensi.ket AS `ket`,
                                        absensi.date AS 'tgl_absen', absensi.shift AS `shift_absen`, karyawan.shift AS `shift_kary` FROM absensi 
                                        JOIN karyawan ON karyawan.npk = absensi.npk
                                        JOIN org ON karyawan.npk = org.npk
                                        WHERE absensi.npk = '$grp[cord]'".$shift.$dept_account.$tanggal)or die(mysqli_error($link));
                                        $data_absen = mysqli_fetch_assoc($q_cek_absen);
                                        $check_in = ($data_absen['check_in'] != '')?$data_absen['check_in']:'TA';
                                        
                                        if(mysqli_num_rows($q_cek_absen)>0){
                                            $ket = ($data_absen['ket'] != '')?$data_absen['ket']:'masuk';
                                            $color_masuk = ($data_absen['ket'] == '' || $data_absen['ket'] == 'TL')?'success':'';
                                            $color_ta = ($data_absen['ket'] == 'M' )?'danger':'';
                                            $color_ijin = ($data_absen['ket'] != '' && ($data_absen['ket'] != 'TL' || $data_absen['ket'] != 'T1' ||  $data_absen['ket'] != 'T2' || $data_absen['ket'] != 'T3') )?"info":'';
                                            $color_telat = ($data_absen['ket'] == 'T1' ||  $data_absen['ket'] == 'T2' || $data_absen['ket'] == 'T3')?"warning":'';
                                            $color = "bg-warning";
                                        }else{
                                            $ket = '-';
                                            $color = "";
                                            $color_masuk = $color_telat = $color_ta = $color_ijin = '';
                                        }
                                        // menapat total karyawan absensi
                                        $query_karyawan = mysqli_query($link, "SELECT karyawan.npk AS npk FROM karyawan JOIN org ON karyawan.npk = org.npk 
                                        WHERE org.grp = '$grp[id]' ".$dept_account.$shift)or die(mysqli_error($link));
                                        $total_karyawan = mysqli_num_rows($query_karyawan);
                                        // untuk query absensi dari data absensi
                                        $qry_absensi_hr = "SELECT absensi.npk AS 'npk_absen' FROM absensi 
                                            JOIN karyawan ON karyawan.npk = absensi.npk
                                            JOIN org ON karyawan.npk = org.npk 
                                            LEFT JOIN attendance_code ON attendance_code.kode = absensi.ket
                                            LEFT JOIN attendance_alias ON attendance_alias.id = attendance_code.alias
                                            WHERE org.grp = '$grp[id]'";
                                        // untuk masuk
                                        $filter_masuk = " AND (attendance_alias.id = '1' OR attendance_alias.id = '2' OR
                                            attendance_alias.id = '3' OR attendance_code.kode = '' OR attendance_code.kode IS NULL )";
                                        $filter_telat = " AND (attendance_alias.id = '3' )";
                                        $filter_ijin = " AND (attendance_alias.id = '4' OR attendance_alias.id = '5' OR attendance_alias.id = '6' OR attendance_alias.id = '7' OR attendance_alias.id = '8' )";
                                        $filter_mangkir = " AND (attendance_alias.id = '9' )";
                                        // echo $qry_absensi_hr.$filter_ijin.$tanggal.$dept_account.$shift;
                                        $query_masuk = mysqli_query($link, $qry_absensi_hr.$filter_masuk.$tanggal.$dept_account.$shift)or die(mysqli_error($link));
                                        $query_telat = mysqli_query($link, $qry_absensi_hr.$filter_telat.$tanggal.$dept_account.$shift)or die(mysqli_error($link));
                                        $query_ijin = mysqli_query($link, $qry_absensi_hr.$filter_ijin.$tanggal.$dept_account.$shift)or die(mysqli_error($link));
                                        $query_mangkir = mysqli_query($link, $qry_absensi_hr.$filter_mangkir.$tanggal.$dept_account.$shift)or die(mysqli_error($link));
                                            
                                            $total_masuk = mysqli_num_rows($query_masuk);
                                            $total_telat = mysqli_num_rows($query_telat);
                                            $total_ijin = mysqli_num_rows($query_ijin);
                                            $total_mangkir = mysqli_num_rows($query_mangkir);
                                            
                                        $percent_masuk = ($total_karyawan > 0 )?($total_masuk / $total_karyawan)*100:0;
                                        $percent_telat = ($total_karyawan > 0 )?($total_telat / $total_karyawan)*100:0;
                                        $percent_ijin = ($total_karyawan > 0 )?($total_ijin / $total_karyawan)*100:0;
                                        $percent_mangkir = ($total_karyawan > 0 )?($total_mangkir / $total_karyawan)*100:0;
                                        $percent_eff = ($total_karyawan > 0 )?round((($total_masuk+$total_telat)/$total_karyawan)*100):0;
                                        // get team
                                        $q_team = $q_org." WHERE id_parent = '$grp[id]' AND part = 'pos'";
                                        $s_team = mysqli_query($link, $q_team)or die(mysqli_error($link));

                                        ?> 
                                        <!-- group -->
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <h4 class="text-uppercase title text-nowrap text-truncate my-0 py-0"><?=$grp['nama_org']?></h4>
                                                                <hr class="m-0">
                                                                <ul class="list-unstyled team-members">
                                                                    <li>
                                                                        <div class="row text-center">
                                                                            <div class="col-md-12 col-12 author text-center">
                                                                                <div class="card card-plain card-user my-0 py-0 px-5">
                                                                                    <div class="avatar text-center ">
                                                                                        <img src="<?=getFoto($grp['cord'])?>" alt="Circle Image" class="mx-auto img-circle img-no-padding img-responsive">
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12 col-12 text-nowrap text-truncate">
                                                                                <h6><?=$grp['nama_cord']?></h6>
                                                                                <span style="width:100%; z-index:1000" class=" badge badge-pill badge-<?=$color_masuk?><?=$color_ta?><?=$color_ijin?><?=$color_telat?>"><?=$ket?></span>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <?php
                                                            if($percent_eff >= 98){
                                                                $color_eff = "bg-success";
                                                                $text_eff = "text-white";
                                                            }else if($percent_eff >= 95 && $percent_eff <= 97){
                                                                $color_eff = "bg-warning";
                                                                $text_eff = "text-white";
                                                            }else{
                                                                $color_eff = "bg-danger";
                                                                $text_eff = "text-white";
                                                            }

                                                            ?>
                                                            <div class="col-md-10">
                                                                <div class="row">
                                                                    <div class="col-md-2 px-4">
                                                                        <div class="row">
                                                                            <div class="col-md-12 number border <?=$color_eff?> <?=$text_eff?> rounded-lg my-2 px-2 text-center">

                                                                                <span class="card-label mb-0 mt-1 ">- eff -</span>
                                                                                <hr class="my-0 text-white">
                                                                                <h4 class="text-uppercase pt-0 mt-0 mb-0 pb-0"><?=$percent_eff?></h4>
                                                                                <hr class="my-0 text-white">
                                                                                %
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    <div class="col-md-10">
                                                                        <div class="row">

                                                                            <div class="col-md-3">
                                                                                <div class="row">
                                                                                    <div class="col-3 col-md-3">
                                                                                        <span class="fa-stack" >
                                                                                            <i class="far fa-circle fa-stack-2x text-success fa-inverse mt-1"></i>
                                                                                            <i class="fa fa-briefcase text-success fa-stack-1x fa-inverse mt-1"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <div class="col-9 col-md-9 ">
                                                                                        <div class=" pr-2">
                                                                                            <p class="card-category py-0 my-0 ">Masuk</p>
                                                                                            <p class="card-title py-0 my-0 text-danger"><?=$total_masuk?> <p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="progress">
                                                                                            <div class="progress-bar progress-bar-animated progress-bar-striped bg-success" role="progressbar" style="width: <?=$percent_masuk?>%;" aria-valuenow="<?=$percent_masuk?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="row">
                                                                                    <div class="col-3 col-md-3">
                                                                                        <span class="fa-stack" >
                                                                                            <i class="far fa-circle fa-stack-2x text-danger fa-inverse mt-1"></i>
                                                                                            <i class="fa fa-bell-slash fa-stack-1x text-danger fa-inverse mt-1"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <div class="col-9 col-md-9 ">
                                                                                        <div class=" pr-2">
                                                                                            <p class="card-category py-0 my-0 text-truncate">TA Keterangan</p>
                                                                                            <p class="card-title py-0 my-0 text-danger"><?=$total_mangkir?><p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="progress">
                                                                                            <div class="progress-bar progress-bar-animated progress-bar-striped bg-danger" role="progressbar" style="width: <?=$percent_mangkir?>%;" aria-valuenow="<?=$percent_mangkir?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="row">
                                                                                    <div class="col-3 col-md-3">
                                                                                        <span class="fa-stack" >
                                                                                            <i class="far fa-circle fa-stack-2x text-info fa-inverse mt-1"></i>
                                                                                            <i class="fas fa-suitcase-rolling fa-stack-1x text-info fa-inverse mt-1"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <div class="col-9 col-md-9 ">
                                                                                        <div class=" pr-2">
                                                                                            <p class="card-category py-0 my-0 ">Ijin / Sakit</p>
                                                                                            <p class="card-title py-0 my-0 text-info"><?=$total_ijin?><p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="progress">
                                                                                            <div class="progress-bar progress-bar-animated progress-bar-striped bg-info" role="progressbar" style="width: <?=$percent_ijin?>%;" aria-valuenow="<?=$percent_ijin?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="row">
                                                                                    <div class="col-3 col-md-3">
                                                                                        <span class="fa-stack" >
                                                                                            <i class="far fa-circle fa-stack-2x text-warning fa-inverse mt-1"></i>
                                                                                            <i class="nc-icon nc-user-run fa-stack-1x text-warning fa-inverse mt-1"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <div class="col-9 col-md-9 ">
                                                                                        <div class=" pr-2">
                                                                                            <p class="card-category py-0 my-0 ">Terlambat</p>
                                                                                            <p class="card-title py-0 my-0 text-warning"><?=$total_telat?><p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="progress">
                                                                                            <div class="progress-bar progress-bar-animated progress-bar-striped bg-warning" role="progressbar" style="width: <?=$percent_telat?>%;" aria-valuenow="<?=$percent_telat?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr class="mt-0 mb-2">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <?php
                                                                        $q_tm_unregistered = mysqli_query($link, "SELECT karyawan.npk AS `npk`, 
                                                                                karyawan.nama AS `nama`, org.post AS `pos`,
                                                                                org.grp AS `group`, org.dept_account AS `dept_account`
                                                                                FROM org JOIN karyawan ON karyawan.npk = org.npk 
                                                                                WHERE org.grp = '$grp[id]' ".$dept_account.$shift)or die(mysqli_error($link));
                                                                        if(mysqli_num_rows($q_tm_unregistered)>0){
                                                                            
                                                                            ?>
                                                                            <div class="row">
                                                                                <div class="col-md-12 ">
                                                                                
                                                                                    <!-- <p class="text-nowrap text-truncate m-0">Unregistered Team</p> -->
                                                                                    <div class=" table-full-width">
                                                                                        <table class="text-uppercase table-sm text-truncate text-center"  width="100%" style="border-spacing: 20px;" >
                                                                                            <tbody style="border:1px solid white;">
                                                                                                <tr>
                                                                                                <?php
                                                                                                        $index = 1;
                                                                                                        $max = 1;
                                                                                                        while($data_unregist = mysqli_fetch_assoc($q_tm_unregistered)){
                                                                                                            $q_cek_absen = mysqli_query($link, "SELECT absensi.npk AS 'npk_absen',
                                                                                                                absensi.check_in AS `check_in`, absensi.ket AS `ket`,
                                                                                                                absensi.date AS 'tgl_absen', absensi.shift AS `shift_absen`, karyawan.shift AS `shift_kary` FROM absensi 
                                                                                                                JOIN karyawan ON karyawan.npk = absensi.npk
                                                                                                                JOIN org ON karyawan.npk = org.npk
                                                                                                                WHERE absensi.npk = '$data_unregist[npk]'".$shift.$dept_account.$tanggal)or die(mysqli_error($link));
                                                                                                                $data_absen = mysqli_fetch_assoc($q_cek_absen);
                                                                                                                $check_in = ($data_absen['check_in'] != '')?$data_absen['check_in']:'TA';
                                                                                                                    
                                                                                                                if(mysqli_num_rows($q_cek_absen)>0){
                                                                                                                    $color_masuk = ($data_absen['ket'] == '' || $data_absen['ket'] == 'TL')?'bg-success':'';
                                                                                                                    $color_ta = ($data_absen['ket'] == 'M' )?'bg-danger':'';
                                                                                                                    $color_ijin = ($data_absen['ket'] != '' || $data_absen['ket'] != 'TL' || $data_absen['ket'] != 'T1' &&  $data_absen['ket'] != 'T2' && $data_absen['ket'] != 'T3' )?"bg-info":'';
                                                                                                                    $color_telat = ($data_absen['ket'] == 'T1' ||  $data_absen['ket'] == 'T2' || $data_absen['ket'] == 'T3')?"bg-warning":'';
                                                                                                                    $color = "bg-warning";
                                                                                                                }else{
                                                                                                                    $color = "";
                                                                                                                    $color_masuk = $color_telat = $color_ta = $color_ijin = '';
                                                                                                                }
                                                                                                            ?>
                                                                                                            <td id="<?=$data_unregist['npk']?>" style="max-width:50px;background-color:rgba(216, 215, 215);border:1px solid white;" celpadding="5px" class=" data-karyawan text-truncate <?=$color_masuk?> <?=$color_ta?> <?=$color_ijin?> <?=$color_telat?>" >
                                                                                                                <?=$data_unregist['nama']?>
                                                                                                            </td>
                                                                                                            <?php
                                                                                                            if($max++ == 10 * $index){
                                                                                                                $index++;
                                                                                                                ?>
                                                                                                                </tr><tr>
                                                                                                                <?php
                                                                                                            }
                                                                                                            
                                                                                                            // if($)
                                                                                                            // $break = $max / $index;
                                                                                                            // if($break == 10 && $max > 10){
                                                                                                                
                                                                                                            // }
                                                                                                            // $max++;
                                                                                                            
                                                                                                        }
                                                                                                        $selisih = (10 * $index) - $max;
                                                                                                        // echo$selisih;
                                                                                                        if($selisih > 0){
                                                                                                            for($i = 0 ; $i<=$selisih;$i++){
                                                                                                                ?>
                                                                                                                <td style="min-width:50px;max-width:50px;background-color:rgba(216, 215, 215);border:1px solid white;" celpadding="5px" >
                                                                                                                <?php
                                                                                                            }
                                                                                                        }
                                                                                                ?>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div> 
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>

                                                        <?php
                                                        if(mysqli_num_rows($s_team)>0){
                                                            while($team = mysqli_fetch_assoc($s_team)){
                                                                

                                                                $q_tm = mysqli_query($link, "SELECT karyawan.npk AS `npk`, 
                                                                karyawan.nama AS `nama`, org.post AS `pos`,
                                                                org.grp AS `group`, org.dept_account AS `dept_account`
                                                                FROM org JOIN karyawan ON karyawan.npk = org.npk 
                                                                WHERE org.post = '$team[id]' AND org.npk <> '$team[cord]' ")or die(mysqli_error($link));
                                                                ?>
                                                                <div class="row">
                                                                    <div class="col-md-12 ">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <p class="text-nowrap text-truncate m-0 col-md-6"><?=$team['nama_org']?></p>
                                                                                    <p class="text-nowrap text-truncate m-0 col-md-6 text-right"><?=$team['nama_cord']?></p>
                                                                                </div>
                                                                                <div class="  table-full-width">
                                                                                    <table class=" table-sm text-truncate text-center" style="border:1px solid white" width="100%">
                                                                                        <tbody style="border:1px solid white">
                                                                                            <tr style="border:1px solid white">
                                                                                            <?php
                                                                                                if(mysqli_num_rows($q_tm)>0){
                                                                                                    $index = 1;
                                                                                                    while($data_mp = mysqli_fetch_assoc($q_tm)){
                                                                                                        $q_cek_absen = mysqli_query($link, "SELECT absensi.npk AS 'npk_absen',
                                                                                                                absensi.check_in AS `check_in`, absensi.ket AS `ket`,
                                                                                                                absensi.date AS 'tgl_absen', absensi.shift AS `shift_absen`, karyawan.shift AS `shift_kary` FROM absensi 
                                                                                                                JOIN karyawan ON karyawan.npk = absensi.npk
                                                                                                                JOIN org ON karyawan.npk = org.npk
                                                                                                                WHERE absensi.npk = '$data_mp[npk]'".$shift.$dept_account.$tanggal)or die(mysqli_error($link));
                                                                                                                $data_absen = mysqli_fetch_assoc($q_cek_absen);
                                                                                                                $check_in = ($data_absen['check_in'] != '')?$data_absen['check_in']:'TA';
                                                                                                                    
                                                                                                                if(mysqli_num_rows($q_cek_absen)>0){
                                                                                                                    $color_masuk = ($data_absen['ket'] == '' || $data_absen['ket'] == 'TL')?'bg-success':'';
                                                                                                                    $color_ta = ($data_absen['ket'] == 'M' )?'bg-danger':'';
                                                                                                                    $color_ijin = ($data_absen['ket'] != '' || $data_absen['ket'] != 'TL' || $data_absen['ket'] != 'T1' &&  $data_absen['ket'] != 'T2' && $data_absen['ket'] != 'T3' )?"bg-info":'';
                                                                                                                    $color_telat = ($data_absen['ket'] == 'T1' &&  $data_absen['ket'] == 'T2' && $data_absen['ket'] == 'T3')?"bg-warning":'';
                                                                                                                    $color = "bg-warning";
                                                                                                                }else{
                                                                                                                    $color = "";
                                                                                                                    $color_masuk = $color_telat = $color_ta = $color_ijin = '';
                                                                                                                }
                                                                                                        $index++;
                                                                                                        ?>
                                                                                                        <td style="max-width:50px" class=" text-truncate table-success ">
                                                                                                            <a class="stretched-link"><?=$data_mp['nama']?></a>
                                                                                                            
                                                                                                        </td>
                                                                                                        <?php
                                                                                                        if($index == 10){
                                                                                                            ?>
                                                                                                            </tr><tr>
                                                                                                            <?php
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> 
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        

                                                        // $org_query = mysqli_query($link, "SELECT npk FROM org WHERE grp = '$grp[id]' ")or die(mysqli_error($link));
                                                        
                                                        // $group_name[$i] = cutName($grp['nama_org']);
                                                        // $group_mp[$i] = mysqli_num_rows($org_query);
                                                        // $i++
                                                        ?>
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- group -->
                                        
                                        
                                        
                                        <?php
                                    }
                                    
                                }
                               
                            }
                        }
                    }
                }
            }
        }
        ?>
    <!-- </div> -->
</div>