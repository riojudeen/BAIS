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
                                        $q_team = $q_org." WHERE id_parent = '$grp[id]' AND part = 'pos'";
                                        $s_team = mysqli_query($link, $q_team)or die(mysqli_error($link));
                                        ?> 
                                        <!-- group -->
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h6 class="text-uppercase title"><?=$grp['nama_org']?></h6>
                                                                <ul class="list-unstyled team-members">
                                                                    <li>
                                                                        <div class="row">
                                                                        <div class="col-md-2 col-2">
                                                                            <div class="avatar">
                                                                            <img src="../../assets/img/faces/ayo-ogunseinde-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-7 col-7">
                                                                                <?=$grp['nama_cord']?>
                                                                                <br>
                                                                            <span class="text-muted"><small><?=$grp['nama_cord']?></small></span>
                                                                        </div>
                                                                        <div class="col-md-3 col-3 text-right">
                                                                            <a href="attendance.php" class="btn btn-sm btn-outline-success btn-round btn-icon"><i class="fa fa-eye"></i></a>
                                                                        </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-9">
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
                                                                                    <p class="card-title py-0 my-0 text-danger">50 MP<p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="progress">
                                                                                    <div class="progress-bar progress-bar-animated progress-bar-striped bg-success" role="progressbar" style="width: 20%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                                                    <p class="card-category py-0 my-0 ">TA Keterangan</p>
                                                                                    <p class="card-title py-0 my-0 text-danger">50 MP<p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="progress">
                                                                                    <div class="progress-bar progress-bar-animated progress-bar-striped bg-danger" role="progressbar" style="width: 20%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                                                    <p class="card-title py-0 my-0 text-info">50 MP<p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="progress">
                                                                                    <div class="progress-bar progress-bar-animated progress-bar-striped bg-info" role="progressbar" style="width: 20%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                                                    <p class="card-title py-0 my-0 text-warning">50 MP<p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="progress">
                                                                                    <div class="progress-bar progress-bar-animated progress-bar-striped bg-warning" role="progressbar" style="width: 20%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <?php
                                                        $q_tm_unregistered = mysqli_query($link, "SELECT karyawan.npk AS `npk`, 
                                                                karyawan.nama AS `nama`, org.post AS `pos`,
                                                                org.grp AS `group`, org.dept_account AS `dept_account`
                                                                FROM org JOIN karyawan ON karyawan.npk = org.npk 
                                                                WHERE org.grp = '$grp[id]' ")or die(mysqli_error($link));
                                                        if(mysqli_num_rows($q_tm_unregistered)>0){
                                                            
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-md-12 ">
                                                                   
                                                                    <p class="text-nowrap text-truncate m-0">Unregistered Team</p>
                                                                    <div class=" table-full-width">
                                                                        <table class=" table-sm text-truncate text-center"  width="100%" style="border-spacing: 20px">
                                                                            <tbody style="border:1px solid white;">
                                                                                <tr >
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
                                                                                                    $color_telat = ($data_absen['ket'] == 'T1' &&  $data_absen['ket'] == 'T2' && $data_absen['ket'] == 'T3')?"bg-warning":'';
                                                                                                    $color = "bg-warning";
                                                                                                }else{
                                                                                                    $color = "";
                                                                                                    $color_masuk = $color_telat = $color_ta = $color_ijin = '';
                                                                                                }
                                                                                            ?>
                                                                                            <td style="max-width:50px;background-color:rgba(216, 215, 215);border-radius:200px 200px 200px 200px;padding:5px" class=" text-truncate <?=$color_masuk?> <?=$color_ta?> <?=$color_ijin?> <?=$color_telat?>" ><?=$data_unregist['nama']?></td>
                                                                                            <?php
                                                                                            if($max++ == 10 * $index){
                                                                                                $index++;
                                                                                                ?>
                                                                                                </tr><tr>
                                                                                                <?php
                                                                                            }
                                                                                            // $break = $max / $index;
                                                                                            // if($break == 10 && $max > 10){
                                                                                                
                                                                                            // }
                                                                                            // $max++;
                                                                                            
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
                                            </div>
                                        </div>
                                        <!-- group -->
                                        
                                        
                                        <?php
                                        /*
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
                                                                                        absensi.date AS 'tgl_absen', absensi.shift AS `shift_absen`, karyawan.shift AS `shift_kary` FROM absensi 
                                                                                        JOIN karyawan ON karyawan.npk = absensi.npk
                                                                                        JOIN org ON karyawan.npk = org.npk
                                                                                        WHERE absensi.npk = '$data_mp[npk_absen]'".$shift.$dept_account.$tanggal)or die(mysqli_error($link));
                                                                                        $index++;
                                                                                        ?>
                                                                                        <td style="max-width:50px" class=" text-truncate table-success "><?=$data_mp['nama']?></td>
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
                                        
                                        <?php
                                        */
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