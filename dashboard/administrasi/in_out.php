<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "In-Out Monitoring";
if(isset($_SESSION['user'])){

    include_once("../header.php");
?>
<div class="row">
    
    <div class="col-md-4">
        <h5 class=""></h5>
    </div>
    <div class="col-md-8 ">
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <label class="col-md-4 col-form-label text-right">Based On :</label>
                    <div class="col-md-8">
                        <div class="form-group-sm pr-1">
                            <select name="show_dept" id="show_dept" class="form-control">
                                <option value="deptAcc">Departmen Administratif</option>
                                <option value="dept">Departmen Functional</option>
                            </select>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <label class="col-md-3 col-form-label text-right">Date :</label>
                    <div class="col-md-9">
                        <div class="form-group-sm pr-1">
                            <input type="text" class="form-control datepicker">
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <label class="col-md-3 col-form-label text-right">Shift :</label>
                    <div class="col-md-9">
                        <div class="form-group-sm pr-1">
                            <select name="shift" id="shift" class="form-control">
                                <option value="">Pilih Shift</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1 text-right">
                <div class="row ">
                    <!-- <div class="nav-link active btn-magnify mt-0"><i class="fas fa-th-list"></i></div> -->
                    <div class="nav-link text-danger btn-magnify mt-0"><i class="fas fa-th-large"></i></div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 ">
        <div class="owl-carousel">
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
                                            <!-- group -->
                                            <div class="card card-plain rounded-lg border ">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="card card-stats " style="border: 1px solid rgba(184, 223, 254)">
                                                                <div class="card-body ">
                                                                    <div class="row">
                                                                        <div class="col-5 col-md-4">
                                                                            <div class="icon-big text-center icon-warning">
                                                                                <i class="fa fa-briefcase text-success"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-7 col-md-8 ">
                                                                            <div class="numbers pr-2">
                                                                                <p class="card-category">Masuk</p>
                                                                                <p class="card-title">50 MP<p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="card-footer">
                                                                    <div class="progress">
                                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                    <!-- <a href="in_out.php" class="stretched-link "></a> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="card card-stats " style="border: 1px solid rgba(184, 223, 254)">
                                                                <div class="card-body ">
                                                                    <div class="row">
                                                                        <div class="col-5 col-md-4">
                                                                            <div class="icon-big text-center icon-warning">
                                                                                <i class="fa fa-bell-slash text-danger"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-7 col-md-8 ">
                                                                            <div class="numbers pr-2">
                                                                                <p class="card-category">TA Keterangan</p>
                                                                                <p class="card-title">50 MP<p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="card-footer">
                                                                    <div class="progress">
                                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                    <!-- <a href="in_out.php" class="stretched-link "></a> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="card card-stats " style="border: 1px solid rgba(184, 223, 254)">
                                                                <div class="card-body ">
                                                                    <div class="row">
                                                                        <div class="col-5 col-md-4">
                                                                            <div class="icon-big text-center icon-warning">
                                                                                <i class=" fas fa-suitcase-rolling text-info"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-7 col-md-8 ">
                                                                            <div class="numbers pr-2">
                                                                                <p class="card-category">Ijin / Sakit</p>
                                                                                <p class="card-title">50 MP<p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="card-footer">
                                                                    <div class="progress">
                                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                    <!-- <a href="in_out.php" class="stretched-link "></a> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="card card-stats " style="border: 1px solid rgba(184, 223, 254)">
                                                                <div class="card-body ">
                                                                    <div class="row">
                                                                        <div class="col-5 col-md-4">
                                                                            <div class="icon-big text-center icon-warning">
                                                                                <i class="nc-icon nc-user-run text-warning"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-7 col-md-8 ">
                                                                            <div class="numbers pr-2">
                                                                                <p class="card-category">Terlambat</p>
                                                                                <p class="card-title">50 MP<p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="card-footer">
                                                                    <div class="progress">
                                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                    <!-- <a href="in_out.php" class="stretched-link "></a> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="m-0">
                                                
                                                <div class="card-body ">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                            <h5 class="text-uppercase title"><?=$grp['nama_org']?></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="table-full-width">
                                                                    <table class="table-sm" width="100%">
                                                                        <tbody>
                                                                        <?php
                                                                        $q_team = "SELECT org.npk AS `npk`, karyawan.nama AS `nama`, org.grp AS `grp`, org.post AS `pos` FROM org LEFT JOIN pos_leader ON pos_leader.id_post 
                                                                        LEFT JOIN karyawan ON karyawan.npk = org.npk 
                                                                        WHERE org.grp = '$grp[id]' GROUP BY org.post";
                                                                        $q_team_mp = "SELECT org.npk AS `npk`, karyawan.nama AS `nama`, org.grp AS `grp`, org.post AS `pos` FROM org LEFT JOIN pos_leader ON pos_leader.id_post 
                                                                        LEFT JOIN karyawan ON karyawan.npk = org.npk 
                                                                        WHERE org.grp = '$grp[id]' ";
                                                                        $q_tm = "SELECT org.npk AS `npk`, karyawan.nama AS `nama` FROM org LEFT JOIN karyawan ON karyawan.npk = org.npk ";
                                                                        $s_team = mysqli_query($link, $q_team)or die(mysqli_error($link));
                                                                        if(mysqli_num_rows($s_team)>0){
                                                                            
                                                                            while($team = mysqli_fetch_assoc($s_team)){
                                                                                $team_name = ($team['pos'] == '')?'Tidak Teregister':$team['pos'];
                                                                                ?>
                                                                                <tr>
                                                                                    <td colspan="20"><?=$team_name?></td>
                                                                                </tr>
                                                                                
                                                                                <?php
                                                                                ?>
                                                                                

                                                                                <tr>
                                                                                <?php
                                                                                $tm = $q_tm." WHERE org.post = '$team[pos]' ";
                                                                                $s_tm = mysqli_query($link, $tm)or die(mysqli_error($link));
                                                                                if(mysqli_num_rows($s_tm)>0){
                                                                                    echo mysqli_num_rows($s_tm);
                                                                                    ?>
                                                                                    
                                                                                    <?php
                                                                                    $no = 1;
                                                                                    while($data = mysqli_fetch_assoc($s_tm)){
                                                                                        ?>
                                                                                        <td><?=$data['nama']?></td>
                                                                                        <?php
                                                                                    }
                                                                                }else{
                                                                                    // echo "tidak ada data";
                                                                                    ?>
                                                                                    <td><?=$data['nama']?></td>
                                                                                    <?php
                                                                                }
                                                                                
                                                                                ?>

                                                                                <?php
                                                                            }
                                                                        }
                                                                    ?> 
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>   
                                                
                                                </div>
                                            </div>



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
                                    
                                }
                            }
                        }
                    }
                }
            }
            ?>
            
            <div class="card card-plain rounded-lg border ">
                <div class="card-header">
                    <h5 class="">Under Body</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-stats " style="border: 1px solid rgba(184, 223, 254)">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="fa fa-briefcase text-success"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8 ">
                                            <div class="numbers pr-2">
                                                <p class="card-category">Masuk</p>
                                                <p class="card-title">30 MP<p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="card-footer">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <!-- <a href="in_out.php" class="stretched-link "></a> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats " style="border: 1px solid rgba(184, 223, 254)">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="fa fa-bell-slash text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8 ">
                                            <div class="numbers pr-2">
                                                <p class="card-category">TA Ket</p>
                                                <p class="card-title">50 MP<p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="card-footer">
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <!-- <a href="in_out.php" class="stretched-link "></a> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats " style="border: 1px solid rgba(184, 223, 254)">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class=" fas fa-suitcase-rolling text-info"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8 ">
                                            <div class="numbers pr-2">
                                                <p class="card-category">Ijin / Sakit</p>
                                                <p class="card-title">10 MP<p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="card-footer">
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <!-- <a href="in_out.php" class="stretched-link "></a> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats " style="border: 1px solid rgba(184, 223, 254)">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="nc-icon nc-user-run text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8 ">
                                            <div class="numbers pr-2">
                                                <p class="card-category">Terlambat</p>
                                                <p class="card-title">5 MP<p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="card-footer">
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <!-- <a href="in_out.php" class="stretched-link "></a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-striped table-full-width">
                    <table class="table table-sm text-truncate text-center">
                        <thead>
                            <th >Foreman</th>
                            <th >Team Leader</th>
                            <th colspan="10">Team Member</th>
                        </thead>
                        <tbody >
                            <tr class="border">
                                <td rowspan="20" style="max-width:50px" class=" text-truncate table-success align-top">Jepri Dhani Pratama</td>
                                <td rowspan="3" style="max-width:50px" class=" text-truncate table-success align-top ">Muhammad</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Juju</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Sulaiman</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Jajang</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Setiawan</td>
                                <td style="max-width:50px" class=" text-truncate table-danger ">Dedy</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Bambang</td>
                                <td style="max-width:50px" class=" text-truncate table-danger ">Yudhoyono</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Yudhoyono</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Raffi</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">BlackPink</td>
                            </tr>
                            <tr>
                                <td style="max-width:50px" class=" text-truncate table-success ">Andri</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Darwanto</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">dafit</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Rosman</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Setiawan</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Dedy</td>
                                <td style="max-width:50px" class=" text-truncate table-info ">Sudarman</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Yudhoyono</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Yudhoyono</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Subagja</td>
                            </tr>
                                <td style="max-width:50px" class=" text-truncate table-success ">Sudarman</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">dafit</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Rosman</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Darwanto</td>
                                <td style="max-width:50px" class=" text-truncate table-warning ">Andri</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Subagja</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Rosmiana</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Jokowi</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Megawati</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Soeharto</td>
                            </tr>
                                <td rowspan="1" style="max-width:50px" class=" text-truncate table-success align-top ">Muhammad</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Ranger</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">dafit</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Sudarman</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Megawati</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Rosmiana</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Rosman</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Subagja</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Darwanto</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Soeharto</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Jokowi</td>
                            </tr>
                            </tr>
                                <td rowspan="2" style="max-width:50px" class=" text-truncate table-success align-top ">Muhammad</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Subagja</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Ranger</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">dafit</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Sudarman</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Megawati</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Rosmiana</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Rosman</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Jokowi</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Darwanto</td>
                                <td style="max-width:50px" class=" text-truncate table-success ">Soeharto</td>
                            </tr>
                            </tr>
                                
                            <td style="max-width:50px" class=" text-truncate table-success ">Darwanto</td>
                            <td style="max-width:50px" class=" text-truncate table-success ">Megawati</td>
                            <td style="max-width:50px" class=" text-truncate table-success ">dafit</td>
                            <td style="max-width:50px" class=" text-truncate table-success ">Sudarman</td>
                            <td style="max-width:50px" class=" text-truncate table-success ">Soeharto</td>
                            <td style="max-width:50px" class=" text-truncate table-success ">Ranger</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
        
    
    
</div>
<?php
    include_once("../footer.php");
    ?>
<script>
    $(document).ready(function(){
        Chart.pluginService.register({
        beforeDraw: function(chart) {
            if (chart.config.options.elements.center) {
            //Get ctx from string
            var ctx = chart.chart.ctx;

            //Get options from the center object in options
            var centerConfig = chart.config.options.elements.center;
            var fontStyle = centerConfig.fontStyle || 'Arial';
            var txt = centerConfig.text;
            var color = centerConfig.color || '#000';
            var sidePadding = centerConfig.sidePadding || 20;
            var sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 2)
            //Start with a base font of 30px
            ctx.font = "30px " + fontStyle;

            //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
            var stringWidth = ctx.measureText(txt).width;
            var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

            // Find out how much the font can grow in width.
            var widthRatio = elementWidth / stringWidth;
            var newFontSize = Math.floor(30 * widthRatio);
            var elementHeight = (chart.innerRadius * 2);

            // Pick a new font size so it will not be larger than the height of label.
            var fontSizeToUse = Math.min(newFontSize, elementHeight);

            //Set font settings to draw it correctly.
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
            var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
            ctx.font = fontSizeToUse + "px " + fontStyle;
            ctx.fillStyle = color;

            //Draw text in center
            ctx.fillText(txt, centerX, centerY);
            }
        }
        });
        ctx = document.getElementById('chartDonut1').getContext("2d");

        myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [1, 2, 3],
            datasets: [{
            label: "Emails",
            pointRadius: 0,
            pointHoverRadius: 0,
            backgroundColor: ['#4acccd', '#f4f3ef', '#FF5733'],
            borderWidth: 0,
            data: [60, 30, 10]
            }]
        },
        options: {
            elements: {
            center: {
                text: '95%',
                color: '#66615c', // Default is #000000
                fontStyle: 'Arial', // Default is Arial
                sidePadding: 60 // Defualt is 20 (as a percentage)
            }
            },
            cutoutPercentage: 80,
            legend: {

            display: false
            },

            tooltips: {
            enabled: true
            },

            scales: {
            yAxes: [{

                ticks: {
                display: false
                },
                gridLines: {
                drawBorder: true,
                zeroLineColor: "transparent",
                color: 'rgba(255,255,255,0.05)'
                }

            }],

            xAxes: [{
                barPercentage: 1.6,
                gridLines: {
                drawBorder: false,
                color: 'rgba(255,255,255,0.1)',
                zeroLineColor: "transparent"
                },
                ticks: {
                display: false,
                }
            }]
            },
        }
        });
    })
</script>
<script>
    // CHARTS
    chartColor = "#FFFFFF";
    
    ctx = document.getElementById('attendancerate').getContext("2d");

    gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#80b6f4');
    gradientStroke.addColorStop(1, chartColor);

    gradientFill = ctx.createLinearGradient(0, 50, 0, 200);
    gradientFill.addColorStop(0, "rgba(148, 234, 255, 0.4)");
    gradientFill.addColorStop(1, "rgba(133, 228, 251, 0.1)");

    gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
    gradientFill2.addColorStop(0, "rgba(255, 164, 32, 0.4)");
    gradientFill2.addColorStop(1, "rgba(249, 99, 59, 0.1)");

    myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [
          'aug', 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30
        ],
        datasets: [
          {
            label: "Production",
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
              10, 100,150,75,200,200,150,125,230,132,216,147,111,160,216,170,157,116,283,156,275
            ],
          },{
            label: "Production",
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill2,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
              10, 100,150,75,200,200,150,125,230,132,216,147,111,160,216,170,157,116,283,156,275
            ],
          },{
            label: "Target",
            borderColor: '#fcc468',
            fill: true,
            type: 'line',
            backgroundColor: 'rgba(255, 39, 0, 0.1)',
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
              100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100
            ],
          },{
            label: "Acc",
            borderColor: '#fcc468',
            fill: true,
            type: 'line',
            backgroundColor: 'rgba(255, 39, 0, 0.1)',
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
              10, 200,300,150,400,450,300,250,460,264,432,398,222,333,432,345,314,234,567,313,555
            ],
          }
        ]
      },
      options: {
        
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
          display: true
        },
        scales: {

          yAxes: [{
            stacked: true,
            ticks: {
              fontColor: "#9f9f9f",
              fontStyle: "bold",
              beginAtZero: true,
              maxTicksLimit: 5,
              padding: 20,
              steps: 10,
              stepValue: 5,
              max: 1000
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
              padding: 20,
              fontColor: "#9f9f9f",
              fontStyle: "bold"
            }
          }]
        }
      }
    });
    </script>
    <script>
        //Load Chart
        var ctx = $("#verticalchart");
        var myBarChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ["Group 1", "Group 1", "name group asal1", "Group 1", "Group 1", "Group 1", "Group 1"],
                datasets: [
                    {
                        label: "Masuk",
                        backgroundColor: 
                            'rgba(32, 174, 255, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    },
                    {
                        label: "Ijin / Cuti",
                        backgroundColor: 
                            'rgba(255, 72, 9, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    }
                ]
                
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
    <!-- dummy -->
    <script>
        //Load Chart
        var ctx = $("#verticalchart2");
        var myBarChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ["Group 1", "Group 1", "name group asal1", "Group 1", "Group 1", "Group 1", "Group 1"],
                datasets: [
                    {
                        label: "Masuk",
                        backgroundColor: 
                            'rgba(32, 174, 255, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    },
                    {
                        label: "Ijin / Cuti",
                        backgroundColor: 
                            'rgba(255, 72, 9, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    }
                ]
                
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
    <script>
        //Load Chart
        var ctx = $("#verticalchart3");
        var myBarChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ["Group 1", "Group 1", "name group asal1", "Group 1", "Group 1", "Group 1", "Group 1"],
                datasets: [
                    {
                        label: "Masuk",
                        backgroundColor: 
                            'rgba(32, 174, 255, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    },
                    {
                        label: "Ijin / Cuti",
                        backgroundColor: 
                            'rgba(255, 72, 9, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    }
                ]
                
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
    <script>
        //Load Chart
        var ctx = $("#verticalchart4");
        var myBarChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ["Group 1", "Group 1", "name group asal1", "Group 1", "Group 1", "Group 1", "Group 1"],
                datasets: [
                    {
                        label: "Masuk",
                        backgroundColor: 
                            'rgba(32, 174, 255, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    },
                    {
                        label: "Ijin / Cuti",
                        backgroundColor: 
                            'rgba(255, 72, 9, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    }
                ]
                
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
    <script>
        //Load Chart
        var ctx = $("#verticalchart5");
        var myBarChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ["Group 1", "Group 1", "name group asal1", "Group 1", "Group 1", "Group 1", "Group 1"],
                datasets: [
                    {
                        label: "Masuk",
                        backgroundColor: 
                            'rgba(32, 174, 255, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    },
                    {
                        label: "Ijin / Cuti",
                        backgroundColor: 
                            'rgba(255, 72, 9, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    }
                ]
                
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
    <script>
        //Load Chart
        var ctx = $("#verticalchart6");
        var myBarChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ["Group 1", "Group 1", "name group asal1", "Group 1", "Group 1", "Group 1", "Group 1"],
                datasets: [
                    {
                        label: "Masuk",
                        backgroundColor: 
                            'rgba(32, 174, 255, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    },
                    {
                        label: "Ijin / Cuti",
                        backgroundColor: 
                            'rgba(255, 72, 9, 0.8)',
                        borderColor:
                            'rgba(255,99,132,1)',
                        borderWidth: 0,
                        data: [65, 59, 80, 81, 56, 55, 40],
                    }
                ]
                
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
    <script>
        $(document).ready(function(){
            var owl = $('.owl-carousel');
            owl.owlCarousel({
                items:1,
                loop:true,
                margin:10,
                autoplay:true,
                autoplayTimeout:3000,
                autoplayHoverPause:true
            });
            $('.play').on('click',function(){
                owl.trigger('play.owl.autoplay',[1000])
            })
            $('.stop').on('click',function(){
                owl.trigger('stop.owl.autoplay')
            })
        });
    </script>
    <?php
    include_once("../endbody.php"); 

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
  

?>