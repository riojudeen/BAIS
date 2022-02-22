<?php
include("../../../config/config.php"); 
?>
    
    <?php
     $q_org = "SELECT `id`,`nama_org`,`cord`,`nama_cord`,`id_parent`,`part` FROM view_cord_area ";
     $q_div = $q_org." WHERE id_parent = '1' AND part = 'division'";
     $s_div = mysqli_query($link, $q_div )or die(mysqli_error($link));
     if(mysqli_num_rows($s_div)>0){
         while($div = mysqli_fetch_assoc($s_div)){
            $q_dept = $q_org." WHERE id_parent = '$div[id]' AND part = 'dept' ";
     $sql_dept = mysqli_query($link, $q_dept)or die(mysqli_error($link));
     if(mysqli_num_rows($sql_dept) > 0){
         while($dept = mysqli_fetch_assoc($sql_dept)){
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
                                    <div class="col-lg-3 col-md-6 col-6 ml-auto bg-warning rounded">
                                    <h5>12<br><label>status</label></h5>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-6 ml-auto mr-auto">
                                    <h5>07:30<br><label>masuk</label></h5>
                                    </div>
                                    <div class="col-lg-3 mr-auto">
                                    <h5>20:00<br><label>pulang</label></h5>
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
                                            $lebar = $jml*40;
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
                                $i=0;
                                while($grp = mysqli_fetch_assoc($s_grp)){
                                    $org_query = mysqli_query($link, "SELECT npk FROM org WHERE grp = '$grp[id]' ")or die(mysqli_error($link));
                                    $group_name[$i] = cutName($grp['nama_org']);
                                    $group_mp[$i] = mysqli_num_rows($org_query);
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
                                

                            }
                            $data = substr($data_group, 0, -1);
                            $data_jml = substr($total, 0, -1);
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
                                                // type: 'horizontalBar',
                                                backgroundColor: 
                                                    'rgba(32, 174, 255, 0.8)',
                                                borderColor:
                                                    'rgba(255,99,132,1)',
                                                borderWidth: 0,
                                                data: [<?=$total?>],
                                            },
                                            {
                                                label: "Ijin / Cuti",
                                                backgroundColor: 
                                                    'rgba(255, 72, 9, 0.8)',
                                                borderColor:
                                                    'rgba(255,99,132,1)',
                                                borderWidth: 0,
                                                
                                                data: [<?=$total?>],
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
                                                stacked: true,
                                                barPercentage: 0.4,
                                                barThickness: 10,  // number (pixels) or 'flex'
                                                maxBarThickness: 15, // number (pixels)
                                                gridLines: {
                                                    zeroLineColor: "white",
                                                    display: false,

                                                    drawBorder: false,
                                                    color: 'transparent',
                                                },
                                                ticks: {
                                                    beginAtZero: true,
                                                    display: false
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