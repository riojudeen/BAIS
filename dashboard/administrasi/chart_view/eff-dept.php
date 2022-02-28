<?php
include("../../../config/config.php"); 
?>
    
    <?php
    $start =  dateToDB($_GET['start']);
    $end =  dateToDB($_GET['end']);
    // echo $end;
    $shift =  ($_GET['shift'] != '')?" AND shift = '$_GET[shift]' ":'';
     $q_org = "SELECT `id`,`nama_org`,`cord`,`nama_cord`,`id_parent`,`part` FROM view_cord_area ";
     $q_div = $q_org." WHERE id_parent = '1' AND part = 'division'";
     $s_div = mysqli_query($link, $q_div )or die(mysqli_error($link));
     if(mysqli_num_rows($s_div)>0){
         while($div = mysqli_fetch_assoc($s_div)){
            $q_dept = $q_org." WHERE id_parent = '$div[id]' AND part = 'dept' ";
     $sql_dept = mysqli_query($link, $q_dept)or die(mysqli_error($link));
    //  echo "tes";
     if(mysqli_num_rows($sql_dept) > 0){
         while($dept = mysqli_fetch_assoc($sql_dept)){
            $q_cek_absensi = "SELECT absensi.npk , absensi.check_in, absensi.check_out , absensi.ket, attendance_code.alias
                FROM absensi LEFT JOIN attendance_code 
                ON attendance_code.kode = absensi.ket 
                LEFT JOIN attendance_alias ON attendance_alias.id = attendance_code.alias 
                JOIN org ON org.npk = absensi.npk 

                WHERE org.npk = '$dept[cord]' AND absensi.date = '$end' ";
            $sql_absensi = mysqli_query($link, $q_cek_absensi)or die(mysqli_error($link));
            if(mysqli_num_rows($sql_absensi)){
                $data_absensi = mysqli_fetch_assoc($sql_absensi);
    
                if($data_absensi['ket'] == '' && $data_absensi['check_in'] == '00:00:00' && $data_absensi['check_in'] == '00:00:00'){
                    $status = '-';
                    $ci = '-';
                    $co = '-';
                    $color = "";
    
                }else if($data_absensi['ket'] == '' && ($data_absensi['check_in'] != '00:00:00' OR $data_absensi['check_in'] != '00:00:00')){
                    $status = 'MASUK';
                    $color = "success";
                    $ci = ($data_absensi['check_in'] != '00:00:00' )?'-':$data_absensi['check_in'];
                    $co = ($data_absensi['check_out'] != '00:00:00' )?'-':$data_absensi['check_out'];
                }else{
                    $status = $data_absensi['ket'];
                    $ci = ($data_absensi['check_in'] != '00:00:00' )?'-':$data_absensi['check_in'];
                    $co = ($data_absensi['check_out'] != '00:00:00' )?'-':$data_absensi['check_out'];
                    
                    if($data_absensi['alias'] == 3){
                        $color = "warning";
                    }else if($data_absensi['alias'] == 4 || $data_absensi['alias'] == 5 || $data_absensi['alias'] == 6 || $data_absensi['alias'] == 7 || $data_absensi['alias'] == 8){
                        $color = "info";
                    }else{
                        $color = "danger";
                    }
                }
            }else{
                $status = '-';
                $ci = '-';
                $co = '-';
                $color = "";
            }
             ?>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-user card-plain">
                            <div class="image">
                                <img src="../../assets/img/bg/damir-bosnjak.jpg" alt="...">
                            </div>
                            <div class="card-body">
                                <div class="author">
                                    <a href="#">
                                        <img class="avatar border-gray" src="../../assets/img/mike.jpg" alt="...">
                                        <h5 class="title"><?=$dept['nama_cord']?></h5>
                                    </a>
                                    <p class="description">
                                        DEPT HEAD <?=$dept['nama_org']?>
                                    </p>
                                </div>
                                
                            </div>
                            <div class="card-footer">
                                <hr>
                                <div class="button-container">
                                <div class="row">
                                    <div class="col-md-12 ml-auto bg-<?=$color?> rounded">
                                    <h5><label><?=$status?></label></h5>
                                    </div>
                                    <div class="col-md-6 ml-auto mr-auto">
                                    <h5><?=$ci?><br><label>In</label></h5>
                                    </div>
                                    <div class="col-md-6 mr-auto">
                                    <h5><?=$co?><br><label>Out</label></h5>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <h5><?=$dept['nama_org']?></h5>
                                <hr>
                                <div class="row">
                                    <?php
                                    $q_sect = $q_org." WHERE id_parent = '$dept[id]' AND part = 'section' ";
                                    $s_sect = mysqli_query($link, $q_sect)or die(mysqli_error($link));
                                    if(mysqli_num_rows($s_sect)>0){
                                        while($sect = mysqli_fetch_assoc($s_sect)){
                                            $q_grp = $q_org." WHERE id_parent = '$sect[id]' AND part = 'group'";
                                            $s_grp = mysqli_query($link, $q_grp )or die(mysqli_error($link));
                                            $jml = mysqli_num_rows($s_grp);
                                            if($jml >= 1 && $jml <= 2){
                                                $lebar = $jml*80;
                                            }else{
                                                $lebar = $jml*60;

                                            }
                                            ?>
                                            <div class="col-md-4 border-bottom my-2 px-4">
                                                <ul class="list-unstyled team-members">
                                                    <li>
                                                        <div class="row">
                                                        <div class="col-md-2 col-2">
                                                            <div class="avatar">
                                                            <img src="../../assets/img/faces/ayo-ogunseinde-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7 col-7">
                                                            <?=$sect['nama_org']?>
                                                            <br />
                                                            <span class="text-muted"><small><?=nick($sect['nama_cord'])?></small></span>
                                                        </div>
                                                        <div class="col-md-3 col-3 text-right">
                                                            <a href="attendance.php" class="btn btn-sm btn-outline-success btn-round btn-icon"><i class="nc-icon nc-zoom-split"></i></a>
                                                        </div>
                                                        </div>
                                                    </li>
                                                    
                                                </ul>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <canvas  id="verticalchart_<?=$sect['id']?>_<?=$sect['part']?>" class="ct-chart ct-perfect-fourth verticalchart"  height="<?=$lebar?>"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <?php
                                        }
                                    }
                                    ?>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                    <?php
                }
            }else{
                echo "nodata";
            }
         }
     }
     ?>
     <?php
    $q_org = "SELECT `id`,`nama_org`,`cord`,`nama_cord`,`id_parent`,`part` FROM view_cord_area ";
    $q_div = $q_org." WHERE id_parent = '1' AND part = 'division'";
    $s_div = mysqli_query($link, $q_div )or die(mysqli_error($link));
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
                            $q_grp = $q_org." WHERE id_parent = '$sect[id]' AND part = 'group'";
                            $s_grp = mysqli_query($link, $q_grp )or die(mysqli_error($link));
                            
                            if(mysqli_num_rows($s_grp)>0){
                                $group_name = array();
                                $group_mp = array();
                                $mp_masuk = array();
                                $mp_ijin = array();
                                $i=0;
                                while($grp = mysqli_fetch_assoc($s_grp)){
                                    $org_query = mysqli_query($link, "SELECT npk FROM org WHERE grp = '$grp[id]' ")or die(mysqli_error($link));
                                    $group_name[$i] = cutName($grp['nama_org']);
                                    $group_mp[$i] = mysqli_num_rows($org_query);
                                    $data_mp = mysqli_fetch_assoc($org_query);
                                    $q_cek_absensi ="SELECT absensi.npk FROM absensi LEFT JOIN attendance_code 
                                        ON attendance_code.kode = absensi.ket 
                                        LEFT JOIN attendance_alias ON attendance_alias.id = attendance_code.alias 
                                        JOIN org ON org.npk = absensi.npk 
                                        WHERE org.grp = '$grp[id]' AND absensi.date = '$end'  ";
                                    $q_masuk = " AND ( absensi.ket = '' OR attendance_alias.id = '1' OR attendance_alias.id = '2' 
                                        OR attendance_alias.id = '3')";
                                    $q_ijin = " AND ( attendance_alias.id = '4' OR attendance_alias.id = '5' 
                                        OR attendance_alias.id = '6' OR attendance_alias.id = '7' OR attendance_alias.id = '8' OR attendance_alias.id = '9'  )";
                                    $sql_masuk = mysqli_query($link, $q_cek_absensi.$q_masuk.$shift)or die(mysqli_error($link));
                                    $sql_ijin = mysqli_query($link, $q_cek_absensi.$q_ijin.$shift)or die(mysqli_error($link));

                                    $total_masuk = mysqli_num_rows($sql_masuk);
                                    $total_ijin = mysqli_num_rows($sql_ijin);
                                    
                                    $mp_masuk[$i] = $total_masuk;
                                    $mp_ijin[$i] = $total_ijin;
                                    $i++
                                    ?>
                                    <?php
                                }
                                $data_group = '';
                                foreach($group_name AS $group){
                                    $data_group .= "\"$group\",";
                                }
                                $total = '';
                                foreach($group_mp AS $tot_data){
                                    $total .= "$tot_data,";
                                }
                                $masuk = '';
                                foreach($mp_masuk AS $msk){
                                    $masuk.= "$msk,";
                                }
                                $ijin = '';
                                foreach($mp_ijin AS $ijn){
                                    $ijin .= "$ijn,";
                                    // echo $ijin;
                                }
                                

                            }
                            $data = substr($data_group, 0, -1);
                            $data_jml = substr($total, 0, -1);
                            $data_masuk = substr($masuk, 0, -1);
                            $data_ijin = substr($ijin, 0, -1);
                            ?>
                            <!-- grafik section -->
                            <script>
                                //Load Chart
                                var ctx = $("#verticalchart_<?=$sect['id']?>_<?=$sect['part']?>");
                                var myBarChart = new Chart(ctx, {
                                    type: 'horizontalBar',
                                    data: {
                                        labels: [<?=$data?>],
                                        datasets: [
                                            {
                                                label: "Masuk",
                                                xAxisID: 'A',
                                                // type: 'horizontalBar',
                                                backgroundColor: 
                                                    'rgba(32, 174, 255, 0.8)',
                                                borderColor:
                                                    'rgba(255,99,132,1)',
                                                borderWidth: 0,
                                                data: [<?=$data_masuk?>],
                                            },
                                            {
                                                label: "Ijin / Cuti",
                                                xAxisID: 'A',
                                                backgroundColor: 
                                                    'rgba(255, 72, 9, 0.8)',
                                                borderColor:
                                                    'rgba(255,99,132,1)',
                                                borderWidth: 0,
                                                
                                                data: [<?=$data_ijin?>],
                                            },
                                            {
                                                label: "Total MP",
                                                xAxisID: 'B',
                                                backgroundColor: 
                                                    'rgba(246, 242, 242, 0.8)',
                                                borderColor:
                                                    'rgba(255,99,132,1)',
                                                borderWidth: 0,
                                                
                                                data: [<?=$data_jml?>],
                                            },
                                            
                                        ], 
                                        
                                        
                                    },
                                    options: {
                                        //Set the index of the value where you want to draw the line
                                        lineAtIndex: 60,
                                        legend: {
                                            display: false
                                        },
                                        scales: {

                                            yAxes: [{
                                                
                                                stacked: true,
                                                ticks: {
                                                    display: true
                                                },
                                                gridLines: {
                                                    zeroLineColor: "transparent",
                                                    display: false,
                                                    drawBorder: false,
                                                    color: '#9f9f9f',
                                                    
                                                }

                                            }],
                                            xAxes: [{
                                                id: 'A',
                                                
                                                stacked: true,
                                                barPercentage: 0.6,
                                                barThickness: 10,  // number (pixels) or 'flex'
                                                maxBarThickness: 15, // number (pixels)
                                                position: 'top',
                                                gridLines: {
                                                    zeroLineColor: "white",
                                                    display: false,

                                                    drawBorder: false,
                                                    color: 'transparent',
                                                },
                                                ticks: {
                                                    beginAtZero: true,
                                                    display: false,
                                                    steps: 10,
                                                    stepValue: 5,
                                                    max: 100
                                                },
                                            },{
                                                id: 'B',
                                                stacked: false,
                                                barPercentage: 0.6,
                                                barThickness: 10,  // number (pixels) or 'flex'
                                                maxBarThickness: 15, // number (pixels)
                                                position: 'bottom',
                                                type: 'linear',
                                                gridLines: {
                                                    zeroLineColor: "white",
                                                    display: false,

                                                    drawBorder: false,
                                                    color: 'transparent',
                                                },
                                                ticks: {
                                                    beginAtZero: true,
                                                    display: false,
                                                    steps: 10,
                                                    stepValue: 5,
                                                    max: 100
                                                },
                                            }]
                                        }
                                    }
                                    
                                });
                            </script>
                            <!-- grafik section -->
                            <?php
                        }
                    }
                }
            }
        }
    }
    

    ?>