<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
// $_GET['section'] = '1-001-001-001';
if(isset($_SESSION['user'])  ){
    if(isset($_GET['section'])){
        $id = $_GET['section'];
        // $id = $_GET['dept'];
        // echo "$id";
        $query_npk_cord = mysqli_query($link, "SELECT cord FROM view_daftar_area WHERE id = '$id' AND part = 'section' ")or die(mysqli_error($link));
        $sql_cord = mysqli_fetch_assoc($query_npk_cord);
        $npk_cord = $sql_cord['cord'];

        $query = "SELECT SUM(dl) AS dl, SUM(mp) AS mp FROM view_employee_sumary WHERE parent = '$id'";
        $queryJml = "SELECT * FROM view_employee_sumary WHERE parent = '$id' GROUP BY id";
        $sql_jml = mysqli_query($link, $queryJml)or die(mysqli_error($link));
        $jmlGroup = mysqli_num_rows($sql_jml);
        $sql = mysqli_query($link, $query)or die(mysqli_error($link));
        $data = mysqli_fetch_assoc($sql);
        $dataIdl = ($data['mp'] == '')?0:$data['mp'];
        $dataDl = ($data['dl'] == '')?0:$data['dl']
        // fhfjfjkjgj
        ?>

        
        <div class="row">
            <div class=" col-md-4 col-sm-12">
                <div class="card card-stats border border-info">
                    <div class="card-body " id="2">
                        <div class="row">
                            <div class="col-5 col-md-4 ">
                                <div class="icon-big text-center icon-info">
                                    <span class="fa-stack text-primary" >
                                        <i class="fas fa-sitemap fa-stack-1x fa-inverse mt-1 text-primary"></i>
                                    
                                        <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                        <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                    </span>
                            
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers ">
                                    <p class="card-title text-primary "><?=$jmlGroup?><p>
                                    <p class="card-category text-right text-primary mb-3">Group</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-stats border border-info">
                    <div class="card-body " id="2">
                        <div class="row">
                            <div class="col-5 col-md-4 ">
                                <div class="icon-big text-center icon-info">
                                    <span class="fa-stack text-primary" >
                                        <i class="fas fa-hard-hat fa-stack-1x fa-inverse mt-1 text-primary"></i>
                                    
                                        <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                        <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                    </span>
                            
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers ">
                                    <p class="card-title text-primary "><?=$dataDl?><p>
                                    <p class="card-category text-right text-primary mb-3">Direct Labour</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-stats border border-info">
                    <div class="card-body " id="2">
                        <div class="row">
                            <div class="col-5 col-md-4 ">
                                <div class="icon-big text-center icon-info">
                                    <span class="fa-stack text-primary" >
                                        <i class="fas fa-hard-hat fa-stack-1x fa-inverse mt-1 text-primary"></i>
                                    
                                        <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                        <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                    </span>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers ">
                                    <p class="card-title text-primary "><?=$dataIdl?><p>
                                    <p class="card-category text-right text-primary mb-3">Indirect Labour</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row px-3" >
            <div class="col-md-12 border rounded-lg" style="background-color:rgba(214, 219, 223, 0.2)">
                <div class="row mt-2">
                    <h6 class="category card-title col-md-6 pull-left text-uppercase" >Summary man power</h6>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <canvas class="" id="dataArrTot" height="300" ></canvas>
                            </div>
                            <div class="graph col-md-9" >
                                <canvas class="" id="dataArr" width="456" height="150" ></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
   
        <div class="row">
            <div class="col-md-12" id="data-mp">
                
                <?php
                $q_section = mysqli_query($link, "SELECT * FROM section WHERE id_section = '$id' ")or die(mysqli_error($link));
                if(mysqli_num_rows($q_section) > 0){
                    while($data_section = mysqli_fetch_assoc($q_section)){
                        
                        ?>
                        <div class="">
                            <table class="table table-hover ">
                                <thead class="">
                                    <th width="20">#</th>
                                    <th width="250">Group</th>
                                    <th width="70">FRM</th>
                                    <th width="70">TL</th>
                                    <th width="70">TM K1</th>
                                    <th width="70">TM K2</th>
                                    <th width="70">TM P</th>
                                    <th width="70">Σ MP</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $q_groupfrm = mysqli_query($link,"SELECT * FROM groupfrm WHERE id_section = '$data_section[id_section]' ")or die(mysqli_error($link));
                                    if(mysqli_num_rows($q_groupfrm) > 0){
                                        $no = 1;
                                        while($data_group = mysqli_fetch_assoc($q_groupfrm)){
                                            $q_total = mysqli_query($link, "SELECT npk FROM org WHERE grp = '$data_group[id_group]' GROUP BY npk")or die(mysqli_error($link));
                                            $total = mysqli_num_rows($q_total);
                                            // $q_frm = mysqli_query($link, "SELECT npk FROM org WHERE grp = '$data_group[id_group]' GROUP BY npk")or die(mysqli_error($link));
                                            // $q_teamleader = mysqli_query($link, "SELECT post FROM org WHERE grp = '$data_group[id_group]' GROUP BY npk")or die(mysqli_error($link));
                                            $q_tm = "SELECT sub_post, `status` FROM org 
                                            JOIN karyawan ON karyawan.npk = org.npk ";
                                            $sql_k1 = mysqli_query($link, $q_tm."  WHERE `status` = 'C1' AND karyawan.jabatan = 'TM' AND org.grp = '$data_group[id_group]' GROUP BY org.npk")or die(mysqli_error($link));
                                            $sql_k2 = mysqli_query($link, $q_tm."  WHERE `status` = 'C2' AND karyawan.jabatan = 'TM' AND org.grp = '$data_group[id_group]' GROUP BY org.npk")or die(mysqli_error($link));
                                            $sql_p = mysqli_query($link, $q_tm."  WHERE `status` = 'P' AND karyawan.jabatan = 'TM' AND org.grp = '$data_group[id_group]' GROUP BY org.npk")or die(mysqli_error($link));
                                            $sql_tl = mysqli_query($link, $q_tm."  WHERE (karyawan.jabatan = 'TL' OR  karyawan.jabatan = 'ATL') AND org.grp = '$data_group[id_group]' GROUP BY org.npk")or die(mysqli_error($link));
                                            $sql_frm = mysqli_query($link, $q_tm."  WHERE (karyawan.jabatan = 'FRM' OR  karyawan.jabatan = 'AFRM') AND org.grp = '$data_group[id_group]' GROUP BY org.npk")or die(mysqli_error($link));
                                            
                                            $q_team_member = mysqli_query($link, "SELECT npk, sub_post FROM org WHERE post = '$data_group[id_group]' GROUP BY npk")or die(mysqli_error($link));
                                            
                                            $jml_tm = (mysqli_num_rows($q_team_member) != 0 )? mysqli_num_rows($q_team_member) : 0;
                                            $jml_tm1 = (mysqli_num_rows($sql_k1) !=0)?mysqli_num_rows($sql_k1):"";
                                            $jml_tm2 = (mysqli_num_rows($sql_k2) != 0)?mysqli_num_rows($sql_k2):"";
                                            $jml_p = (mysqli_num_rows($sql_p) != 0)?mysqli_num_rows($sql_p):"";
                                            $jml_tl = (mysqli_num_rows($sql_tl) != 0)?mysqli_num_rows($sql_tl):"";
                                            $jml_frm = (mysqli_num_rows($sql_frm) != 0)?mysqli_num_rows($sql_frm):"";


                                            
                                            $color1 = "rgba(52, 152, 219, 0.2".sprintf("%02d", $jml_frm).")";
                                            $color2 = "rgba(26, 188, 156, 0.2".sprintf("%02d", $jml_tl).")";
                                            $color3 = "rgba(241, 196, 15, 0.2".sprintf("%02d", $jml_tm1).")";
                                            $color4 = "rgba(248, 196, 113, 0.2".sprintf("%02d", $jml_tm2).")";
                                            $color5 = "rgba(247, 220, 111, 0.2".sprintf("%02d", $jml_p).")";
                                            
                                            // echo $color1;
                                            ?>
                                            <tr>
                                                <td><?=$no++?></td>
                                                <td ><?=$data_group['nama_group']?></td>
                                                <td style="background-color: <?=$color1?>"><?=$jml_frm?></td>
                                                <td style="background-color: <?=$color2?>"><?=$jml_tl?></td>
                                                <td style="background-color: <?=$color3?>"><?=$jml_tm1?></td>
                                                <td style="background-color: <?=$color4?>"><?=$jml_tm2?></td>
                                                <td style="background-color: <?=$color5?>"><?=$jml_p?></td>
                                                <td><?=$total?></td>
                                            </tr>
                                            <?php
                                        }
                                    }else{
                                        ?>
                                        <tr>
                                            <td class="text-uppercase text-center" colspan="10">
                                                Belum ada register group untuk section ini
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <h5 class="card-title col-md-6 pull-left text-uppercase" >Deteail Man Power</h5>
                </div>
                <div class="table-responsive text-uppercase">
                    <table class="table-striped table  text-nowrap">
                        <thead class="table-info">
                            <th>#</th>
                            <th>NPK</th>
                            <th>NAMA</th>
                            <th>Jabatan</th>
                            <th>shift</th>
                            <th>Status</th>
                            <th>POS</th>
                            <th>TEAM</th>
                            <th>GROUP</th>
                            <th>SECTION</th>
                            <th>DEPT ADMINISTRATIF</th>
                        </thead>
                        <tbody>
                            <?php
                            $query_mp = mysqli_query($link, "SELECT * FROM view_organization WHERE id_sect = '$id' AND npk <> '$npk_cord' ")or die(mysqli_error($link));
                            if(mysqli_num_rows($query_mp)>0){
                                $no =1;
                                while($dataMp = mysqli_fetch_assoc($query_mp)){
                                    ?>
                                    <tr>
                                        
                                        <td><?=$no++?></td>
                                        <td><?=$dataMp['npk']?></td>
                                        <td><?=$dataMp['nama']?></td>
                                        <td><?=$dataMp['jabatan']?></td>
                                        <td><?=$dataMp['shift']?></td>
                                        <td><?=$dataMp['status']?></td>
                                        <td><?=$dataMp['subpos']?></td>
                                        <td><?=$dataMp['pos']?></td>
                                        <td><?=$dataMp['groupfrm']?></td>
                                        <td><?=$dataMp['section']?></td>
                                        <td><?=$dataMp['dept_account']?></td>
                                    </tr>
                                    <?php
                                }
                            }else{
                                ?>
                                <tr>
                                    <td colspan="12" class="text-center">Belum ada arrangement man power</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
            $dt_group = '';
            
            $queryFrm = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_sect = '$id' AND (jabatan = 'FRM' OR jabatan = 'AFRM') AND npk <> '$npk_cord'";
            $queryTl = " SELECT COUNT(npk) AS tot_tl FROM view_organization WHERE id_sect = '$id' AND (jabatan = 'TL' OR jabatan = 'ATL') AND npk <> '$npk_cord'";
            $queryC1 = " SELECT COUNT(npk) AS tot_c1 FROM view_organization WHERE id_sect = '$id' AND (jabatan = 'TL') AND `status` = 'C1' AND npk <> '$npk_cord'";
            $queryC2 = " SELECT COUNT(npk) AS tot_c2 FROM view_organization WHERE id_sect = '$id' AND (jabatan = 'TM') AND `status` = 'C2' AND npk <> '$npk_cord' ";
            $queryP = " SELECT COUNT(npk) AS tot_p FROM view_organization WHERE id_sect = '$id' AND (jabatan = 'TM') AND `status` = 'P' AND npk <> '$npk_cord' ";
            $query_tot = " SELECT COUNT(npk) AS tot FROM view_organization WHERE id_sect = '$id' AND npk <> '$npk_cord' ";
            $sql_ = mysqli_query($link, $query_tot)or die(mysqli_error($link));
            $data_ = mysqli_fetch_assoc($sql_);

            $sql_Frm = mysqli_query($link, $queryFrm)or die(mysqli_error($link));
            $data_FRM = mysqli_fetch_assoc($sql_Frm);

            $sql_TL = mysqli_query($link, $queryTl)or die(mysqli_error($link));
            $data_TL = mysqli_fetch_assoc($sql_TL);
            
            $sql_C1 = mysqli_query($link, $queryC1)or die(mysqli_error($link));
            $data_C1 = mysqli_fetch_assoc($sql_C1);
            
            $sql_C2 = mysqli_query($link, $queryC2)or die(mysqli_error($link));
            $data_C2 = mysqli_fetch_assoc($sql_C2);

            $sql_P = mysqli_query($link, $queryP)or die(mysqli_error($link));
            $data_P = mysqli_fetch_assoc($sql_P);

            $dataFrm = (isset($data_FRM['tot_foreman']) AND $data_FRM['tot_foreman'] != '')?$data_FRM['tot_foreman']:0;
            $dataTL = (isset($data_TL['tot_tl']) AND $data_TL['tot_tl'] != '')?$data_TL['tot_tl']:0;
            $dataC1 = (isset($data_C1['tot_c1']) AND $data_C1['tot_c1'] != '')?$data_C1['tot_c1']:0;
            $dataC2 = (isset($data_C2['tot_c2']) AND $data_C2['tot_c2'] != '')?$data_C2['tot_c2']:0;
            $dataP = (isset($data_P['tot_p']) AND $data_P['tot_p'] != '')?$data_P['tot_p']:0;
            $dataTot = (isset($data_['tot']) AND $data_['tot'] != '')?$data_['tot']:0;

            $data_graph = $dataFrm .",".$dataTL .",".$dataC1 .",".$dataC2 .",".$dataP;
            // echo $data_graph;
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
                ctx = document.getElementById('dataArrTot').getContext("2d");

                myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['FRM','TL','TM C1','TM C2','TM P'],
                    datasets: [{
                    label: "Effisiensi Kehadiaran",
                    pointRadius: 0,
                    pointHoverRadius: 0,
                    backgroundColor: ['rgba(52, 152, 219, 1)', 'rgba(26, 188, 156, 1)', 'rgba(241, 196, 15, 1)','rgba(248, 196, 113, 1)','rgba(247, 220, 111, 0.5)'],
                    borderWidth: 0,
                    data: [<?=$data_graph?>]
                    }]
                },
                options: {
                    elements: {
                    center: {
                        text: '<?=$dataTot?> MP',
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
    
    ctx = document.getElementById('dataArr').getContext("2d");

    gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#80b6f4');
    gradientStroke.addColorStop(1, chartColor);

    gradientFill = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill.addColorStop(0, "rgba(52, 152, 219, 1)");
    gradientFill.addColorStop(1, "rgba(52, 152, 219, 0.5)");

    gradientFill2 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill2.addColorStop(0, "rgba(26, 188, 156, 1)");
    gradientFill2.addColorStop(1, "rgba(26, 188, 156, 0.5)");

    gradientFill3 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill3.addColorStop(0, "rgba(241, 196, 15, 1)");
    gradientFill3.addColorStop(1, "rgba(241, 196, 15, 0.5)");


    gradientFill4 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill4.addColorStop(0, "rgba(248, 196, 113, 1)");
    gradientFill4.addColorStop(1, "rgba(248, 196, 113, 0.5)");

    gradientFill5 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill5.addColorStop(0, "rgba(247, 220, 111, 1)");
    gradientFill5.addColorStop(1, "rgba(247, 220, 111, 0.5)");

    myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [
            <?php
             $query = "SELECT * FROM view_employee_sumary WHERE parent = '$id'";
             $sql = mysqli_query($link,$query)or die(mysqli_error($link));

             if(mysqli_num_rows($sql)>0){
                 $dataGroup = '';
                 $array_group = array();
                while($data = mysqli_fetch_assoc($sql)){
                        $dataGroup .= "'".initial($data['nama'])."',";
                        array_push($array_group, $data['id']);
                    }
                    $dt = substr($dataGroup, 0, -1);
                    echo $dt;
                
             }
          ?>
        ],
        datasets: [
          {
            label: "Foreman",
            yAxisID: 'A',
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [ 
                <?php
                $dt_group = '';
                foreach($array_group AS $group){
                    $query = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'FRM' OR jabatan = 'AFRM')";
                    $query_tl = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'TL' OR jabatan = 'ATL')";
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql)>0){
                        while($data_mp = mysqli_fetch_assoc($sql)){
                            $dt_group .= $data_mp['tot_foreman']." ,";
                        }
                        
                        
                    }
                }
                $dt_group = substr($dt_group, 0, -1);
                echo $dt_group;
                // echo $query;
             ?>
            ],
          },{
            label: "Team Leader",
            yAxisID: 'A',
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill2,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
                <?php
                $dt_group = '';
                foreach($array_group AS $group){
                    $query = " SELECT COUNT(npk) AS tot_tl FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'TL' OR jabatan = 'ATL')";
                    // $query_tl = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'TL' OR jabatan = 'ATL') GROUP BY id_grp ";
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql)>0){
                        while($data_mp = mysqli_fetch_assoc($sql)){
                            $dt_group .= $data_mp['tot_tl']." ,";
                        }
                        
                    }
                }
                $dt_group_tl = substr($dt_group, 0, -1);
                echo $dt_group_tl;
                // echo $query;
             ?>
            ],
          },{
            yAxisID: 'A',
            label: "TM Kontrak 1",
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill3,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
                <?php
                $dt_group = '';
                foreach($array_group AS $group){
                    $query = " SELECT COUNT(npk) AS tot_tm FROM view_organization WHERE id_grp = '$group' AND jabatan = 'TM' AND `status` = 'C1' ";
                    // $query_tl = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'TL' OR jabatan = 'ATL') GROUP BY id_grp ";
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql)>0){
                        while($data_mp = mysqli_fetch_assoc($sql)){
                            $dt_group .= $data_mp['tot_tm']." ,";
                        }
                        
                    }
                }
                $dt_group_tm = substr($dt_group, 0, -1);
                echo $dt_group_tm;
                // echo $query;
             ?>
            ],
          },{
            yAxisID: 'A',
            label: "TM Kontrak 2",
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill4,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
                <?php
                $dt_group = '';
                foreach($array_group AS $group){
                    $query = " SELECT COUNT(npk) AS tot_tm FROM view_organization WHERE id_grp = '$group' AND jabatan = 'TM' AND `status` = 'C2' ";
                    // $query_tl = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'TL' OR jabatan = 'ATL') GROUP BY id_grp ";
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql)>0){
                        while($data_mp = mysqli_fetch_assoc($sql)){
                            $dt_group .= $data_mp['tot_tm']." ,";
                        }
                        
                    }
                }
                $dt_group_tm = substr($dt_group, 0, -1);
                echo $dt_group_tm;
                // echo $query;
             ?>
            ],
          },{
            yAxisID: 'A',
            label: "TM Permanent",
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill5,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
                <?php
                $dt_group = '';
                foreach($array_group AS $group){
                    $query = " SELECT COUNT(npk) AS tot_tm FROM view_organization WHERE id_grp = '$group' AND jabatan = 'TM' AND `status` = 'P' ";
                    // $query_tl = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'TL' OR jabatan = 'ATL') GROUP BY id_grp ";
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql)>0){
                        while($data_mp = mysqli_fetch_assoc($sql)){
                            $dt_group .= $data_mp['tot_tm']." ,";
                        }
                        
                    }
                }
                $dt_group_tm = substr($dt_group, 0, -1);
                echo $dt_group_tm;
                // echo $query;
             ?>
            ],
          },{
            yAxisID: 'B',
            type: 'line',
            label: "Total",
            borderColor: 'rgba(246, 242, 242, 1)',
            fill: true,
            backgroundColor: "rgba(246, 242, 242, 0.0)",
            hoverBorderColor: 'rgba(246, 242, 242, 0.0)',
            borderWidth: 0,
            data: [
                <?php
                $dt_group = '';
                foreach($array_group AS $group){
                    $query = " SELECT COUNT(npk) AS tot_tm FROM view_organization WHERE id_grp = '$group' ";
                    // $query_tl = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'TL' OR jabatan = 'ATL') GROUP BY id_grp ";
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql)>0){
                        while($data_mp = mysqli_fetch_assoc($sql)){
                            $dt_group .= $data_mp['tot_tm']." ,";
                        }
                        
                    }
                }
                $dt_group_tm = substr($dt_group, 0, -1);
                echo $dt_group_tm;
                // echo $query;
             ?>
            ],
          },
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

          display: false
        },
        scales: {

          yAxes: [{
            id: 'A',
            position: 'left',
            stacked: true,
            ticks: {
              fontColor: "#9f9f9f",
              fontStyle: "bold",
              beginAtZero: true,
              maxTicksLimit: 5,
              padding: 20,
              steps: 10,
              stepValue: 10,
              max: 80
            },
            
            gridLines: {
              zeroLineColor: "transparent",
              display: true,
              drawBorder: false,
              color: '#9f9f9f',
            }

          },{
            id: 'B',
            position: 'right',
            stacked: false,
            ticks: {
              fontColor: "#9f9f9f",
              fontStyle: "bold",
              beginAtZero: true,
              maxTicksLimit: 5,
              padding: 20,
              steps: 10,
              stepValue: 5,
              max: 50
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
            barThickness: 50,  // number (pixels) or 'flex'
            maxBarThickness: 50, // number (pixels)
            gridLines: {
              zeroLineColor: "white",
              display: true,

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
    
        <?php
    }else if(isset($_GET['group'])){
        $id = $_GET['group'];
        // echo "$id";
        $query = "SELECT dl, mp, (dl+mp) AS total FROM view_employee_sumary WHERE id = '$id'";
        
        $sql_jml = mysqli_query($link, $query)or die(mysqli_error($link));
        $jmlGroup = mysqli_num_rows($sql_jml);
        $sql = mysqli_query($link, $query)or die(mysqli_error($link));
        $data = mysqli_fetch_assoc($sql);
        $dataIdl = $data['mp'];
        $dataDl = $data['dl'];
        $dataTot = $data['total'];
        // fhfjfjkjgj
        ?>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-stats border border-info">
                    <div class="card-body " id="2">
                        <div class="row">
                            <div class="col-5 col-md-4 ">
                                <div class="icon-big text-center icon-info">
                                    <span class="fa-stack text-primary" >
                                        <i class="fas fa-sitemap fa-stack-1x fa-inverse mt-1 text-primary"></i>
                                    
                                        <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                        <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                    </span>
                            
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers ">
                                    <p class="card-title text-primary "><?=$dataTot?><p>
                                    <p class="card-category text-right text-primary mb-3">Karyawan</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-stats border border-info">
                    <div class="card-body " id="2">
                        <div class="row">
                            <div class="col-5 col-md-4 ">
                                <div class="icon-big text-center icon-info">
                                    <span class="fa-stack text-primary" >
                                        <i class="fas fa-hard-hat fa-stack-1x fa-inverse mt-1 text-primary"></i>
                                        <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                        <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                    </span>
                            
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers ">
                                    <p class="card-title text-primary "><?=$dataDl?><p>
                                    <p class="card-category text-right text-primary mb-3">Direct Labour</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-stats border border-info">
                    <div class="card-body " id="2">
                        <div class="row">
                            <div class="col-5 col-md-4 ">
                                <div class="icon-big text-center icon-info">
                                    <span class="fa-stack text-primary" >
                                        <i class="fas fa-hard-hat fa-stack-1x fa-inverse mt-1 text-primary"></i>
                                    
                                        <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                        <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                    </span>
                            
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers ">
                                    <p class="card-title text-primary "><?=$dataIdl?><p>
                                    <p class="card-category text-right text-primary mb-3">Indirect Labour</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <canvas class="" id="dataArrTot" height="300" ></canvas>
                    </div>
                    <div class="graph col-md-9" >
                        <canvas class="" id="dataArr" width="456" height="150" ></canvas>
                    </div>
                </div>
                
            </div>
        </div>
        <hr>
   
        
        
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="card-title col-md-6 pull-left text-uppercase" >Data Man Power</h6>
                </div>
                <div class="table-responsive text-uppercase">
                    <table class="table-hover table text-nowrap">
                        <thead>
                            <th>#</th>
                            <th>NPK</th>
                            <th>NAMA</th>
                            <th>Jabatan</th>
                            <th>shift</th>
                            <th>Status</th>
                            <th>POS</th>
                            <th>TEAM</th>
                            <th>GROUP</th>
                            <th>SECTION</th>
                            <th>DEPT ADMIN</th>
                        </thead>
                        <tbody>
                            <?php
                            $query_mp = mysqli_query($link, "SELECT * FROM view_organization WHERE id_grp = '$id' ")or die(mysqli_error($link));
                            if(mysqli_num_rows($query_mp)>0){
                                $no =1;
                                while($dataMp = mysqli_fetch_assoc($query_mp)){
                                    ?>
                                    <tr>
                                        
                                        <td><?=$no++?></td>
                                        <td><?=$dataMp['npk']?></td>
                                        <td><?=$dataMp['nama']?></td>
                                        <td><?=$dataMp['jabatan']?></td>
                                        <td><?=$dataMp['shift']?></td>
                                        <td><?=$dataMp['status']?></td>
                                        <td><?=$dataMp['subpos']?></td>
                                        <td><?=$dataMp['pos']?></td>
                                        <td><?=$dataMp['groupfrm']?></td>
                                        <td><?=$dataMp['section']?></td>
                                        <td><?=$dataMp['dept_account']?></td>
                                    </tr>
                                    <?php
                                }
                            }else{
                                ?>
                                <tr>
                                    <td colspan="12" class="text-center">Belum ada arrangement man power</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
            $dt_group = '';
            
            $queryFrm = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_grp = '$id' AND (jabatan = 'FRM' OR jabatan = 'AFRM')";
            $queryTl = " SELECT COUNT(npk) AS tot_tl FROM view_organization WHERE id_grp = '$id' AND (jabatan = 'TL' OR jabatan = 'ATL')";
            $queryC1 = " SELECT COUNT(npk) AS tot_c1 FROM view_organization WHERE id_grp = '$id' AND (jabatan = 'TL') AND `status` = 'C1'";
            $queryC2 = " SELECT COUNT(npk) AS tot_c2 FROM view_organization WHERE id_grp = '$id' AND (jabatan = 'TM') AND `status` = 'C2'";
            $queryP = " SELECT COUNT(npk) AS tot_p FROM view_organization WHERE id_grp = '$id' AND (jabatan = 'TM') AND `status` = 'P'  ";
            $query_tot = " SELECT COUNT(npk) AS tot FROM view_organization WHERE id_grp = '$id' ";
            $sql_ = mysqli_query($link, $query_tot)or die(mysqli_error($link));
            $data_ = mysqli_fetch_assoc($sql_);

            $sql_Frm = mysqli_query($link, $queryFrm)or die(mysqli_error($link));
            $data_FRM = mysqli_fetch_assoc($sql_Frm);

            $sql_TL = mysqli_query($link, $queryTl)or die(mysqli_error($link));
            $data_TL = mysqli_fetch_assoc($sql_TL);
            
            $sql_C1 = mysqli_query($link, $queryC1)or die(mysqli_error($link));
            $data_C1 = mysqli_fetch_assoc($sql_C1);
            
            $sql_C2 = mysqli_query($link, $queryC2)or die(mysqli_error($link));
            $data_C2 = mysqli_fetch_assoc($sql_C2);

            $sql_P = mysqli_query($link, $queryP)or die(mysqli_error($link));
            $data_P = mysqli_fetch_assoc($sql_P);

            $dataFrm = (isset($data_FRM['tot_foreman']) AND $data_FRM['tot_foreman'] != '')?$data_FRM['tot_foreman']:0;
            $dataTL = (isset($data_TL['tot_tl']) AND $data_TL['tot_tl'] != '')?$data_TL['tot_tl']:0;
            $dataC1 = (isset($data_C1['tot_c1']) AND $data_C1['tot_c1'] != '')?$data_C1['tot_c1']:0;
            $dataC2 = (isset($data_C2['tot_c2']) AND $data_C2['tot_c2'] != '')?$data_C2['tot_c2']:0;
            $dataP = (isset($data_P['tot_p']) AND $data_P['tot_p'] != '')?$data_P['tot_p']:0;
            $dataTot = (isset($data_['tot']) AND $data_['tot'] != '')?$data_['tot']:0;

            $data_graph = $dataFrm .",".$dataTL .",".$dataC1 .",".$dataC2 .",".$dataP;
            // echo $data_graph;
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
                ctx = document.getElementById('dataArrTot').getContext("2d");

                myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['FRM','TL','TM C1','TM C2','TM P'],
                    datasets: [{
                    label: "Effisiensi Kehadiaran",
                    pointRadius: 0,
                    pointHoverRadius: 0,
                    backgroundColor: ['rgba(52, 152, 219, 1)', 'rgba(26, 188, 156, 1)', 'rgba(241, 196, 15, 1)','rgba(248, 196, 113, 1)','rgba(247, 220, 111, 0.5)'],
                    borderWidth: 0,
                    data: [<?=$data_graph?>]
                    }]
                },
                options: {
                    elements: {
                    center: {
                        text: '<?=$dataTot?> MP',
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
    
    ctx = document.getElementById('dataArr').getContext("2d");

    gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#80b6f4');
    gradientStroke.addColorStop(1, chartColor);

    gradientFill = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill.addColorStop(0, "rgba(52, 152, 219, 1)");
    gradientFill.addColorStop(1, "rgba(52, 152, 219, 0.5)");

    gradientFill2 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill2.addColorStop(0, "rgba(26, 188, 156, 1)");
    gradientFill2.addColorStop(1, "rgba(26, 188, 156, 0.5)");

    gradientFill3 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill3.addColorStop(0, "rgba(241, 196, 15, 1)");
    gradientFill3.addColorStop(1, "rgba(241, 196, 15, 0.5)");


    gradientFill4 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill4.addColorStop(0, "rgba(248, 196, 113, 1)");
    gradientFill4.addColorStop(1, "rgba(248, 196, 113, 0.5)");

    gradientFill5 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill5.addColorStop(0, "rgba(247, 220, 111, 1)");
    gradientFill5.addColorStop(1, "rgba(247, 220, 111, 0.5)");

    myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [
            <?php
             $query = "SELECT * FROM view_employee_sumary WHERE id = '$id'";
             $sql = mysqli_query($link,$query)or die(mysqli_error($link));

             if(mysqli_num_rows($sql)>0){
                 $dataGroup = '';
                 $array_group = array();
                while($data = mysqli_fetch_assoc($sql)){
                        $dataGroup .= "'".initial($data['nama'])."',";
                        array_push($array_group, $data['id']);
                    }
                    $dt = substr($dataGroup, 0, -1);
                    echo $dt;
                
             }
          ?>
        ],
        datasets: [
          {
            label: "Foreman",
            yAxisID: 'A',
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [ 
                <?php
                $dt_group = '';
                foreach($array_group AS $group){
                    $query = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'FRM' OR jabatan = 'AFRM')";
                    $query_tl = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'TL' OR jabatan = 'ATL')";
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql)>0){
                        while($data_mp = mysqli_fetch_assoc($sql)){
                            $dt_group .= $data_mp['tot_foreman']." ,";
                        }
                        
                        
                    }
                }
                $dt_group = substr($dt_group, 0, -1);
                echo $dt_group;
                // echo $query;
             ?>
            ],
          },{
            label: "Team Leader",
            yAxisID: 'A',
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill2,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
                <?php
                $dt_group = '';
                foreach($array_group AS $group){
                    $query = " SELECT COUNT(npk) AS tot_tl FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'TL' OR jabatan = 'ATL')";
                    // $query_tl = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'TL' OR jabatan = 'ATL') GROUP BY id_grp ";
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql)>0){
                        while($data_mp = mysqli_fetch_assoc($sql)){
                            $dt_group .= $data_mp['tot_tl']." ,";
                        }
                        
                    }
                }
                $dt_group_tl = substr($dt_group, 0, -1);
                echo $dt_group_tl;
                // echo $query;
             ?>
            ],
          },{
            yAxisID: 'A',
            label: "TM Kontrak 1",
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill3,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
                <?php
                $dt_group = '';
                foreach($array_group AS $group){
                    $query = " SELECT COUNT(npk) AS tot_tm FROM view_organization WHERE id_grp = '$group' AND jabatan = 'TM' AND `status` = 'C1' ";
                    // $query_tl = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'TL' OR jabatan = 'ATL') GROUP BY id_grp ";
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql)>0){
                        while($data_mp = mysqli_fetch_assoc($sql)){
                            $dt_group .= $data_mp['tot_tm']." ,";
                        }
                        
                    }
                }
                $dt_group_tm = substr($dt_group, 0, -1);
                echo $dt_group_tm;
                // echo $query;
             ?>
            ],
          },{
            yAxisID: 'A',
            label: "TM Kontrak 2",
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill4,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
                <?php
                $dt_group = '';
                foreach($array_group AS $group){
                    $query = " SELECT COUNT(npk) AS tot_tm FROM view_organization WHERE id_grp = '$group' AND jabatan = 'TM' AND `status` = 'C2' ";
                    // $query_tl = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'TL' OR jabatan = 'ATL') GROUP BY id_grp ";
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql)>0){
                        while($data_mp = mysqli_fetch_assoc($sql)){
                            $dt_group .= $data_mp['tot_tm']." ,";
                        }
                        
                    }
                }
                $dt_group_tm = substr($dt_group, 0, -1);
                echo $dt_group_tm;
                // echo $query;
             ?>
            ],
          },{
            yAxisID: 'A',
            label: "TM Permanent",
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill5,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
                <?php
                $dt_group = '';
                foreach($array_group AS $group){
                    $query = " SELECT COUNT(npk) AS tot_tm FROM view_organization WHERE id_grp = '$group' AND jabatan = 'TM' AND `status` = 'P' ";
                    // $query_tl = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'TL' OR jabatan = 'ATL') GROUP BY id_grp ";
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql)>0){
                        while($data_mp = mysqli_fetch_assoc($sql)){
                            $dt_group .= $data_mp['tot_tm']." ,";
                        }
                        
                    }
                }
                $dt_group_tm = substr($dt_group, 0, -1);
                echo $dt_group_tm;
                // echo $query;
             ?>
            ],
          },{
            yAxisID: 'B',
            type: 'line',
            label: "Total",
            borderColor: 'rgba(246, 242, 242, 1)',
            fill: true,
            backgroundColor: "rgba(246, 242, 242, 0.0)",
            hoverBorderColor: 'rgba(246, 242, 242, 0.0)',
            borderWidth: 0,
            data: [
                <?php
                $dt_group = '';
                foreach($array_group AS $group){
                    $query = " SELECT COUNT(npk) AS tot_tm FROM view_organization WHERE id_grp = '$group' ";
                    // $query_tl = " SELECT COUNT(npk) AS tot_foreman FROM view_organization WHERE id_grp = '$group' AND (jabatan = 'TL' OR jabatan = 'ATL') GROUP BY id_grp ";
                    $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql)>0){
                        while($data_mp = mysqli_fetch_assoc($sql)){
                            $dt_group .= $data_mp['tot_tm']." ,";
                        }
                        
                    }
                }
                $dt_group_tm = substr($dt_group, 0, -1);
                echo $dt_group_tm;
                // echo $query;
             ?>
            ],
          },
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

          display: false
        },
        scales: {

          yAxes: [{
            id: 'A',
            position: 'left',
            stacked: true,
            ticks: {
              fontColor: "#9f9f9f",
              fontStyle: "bold",
              beginAtZero: true,
              maxTicksLimit: 5,
              padding: 20,
              steps: 10,
              stepValue: 5,
              max: 50
            },
            gridLines: {
              zeroLineColor: "transparent",
              display: false,
              drawBorder: false,
              color: '#9f9f9f',
            }

          },{
            id: 'B',
            position: 'right',
            stacked: false,
            ticks: {
              fontColor: "#9f9f9f",
              fontStyle: "bold",
              beginAtZero: true,
              maxTicksLimit: 5,
              padding: 20,
              steps: 10,
              stepValue: 5,
              max: 50
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
            barThickness: 50,  // number (pixels) or 'flex'
            maxBarThickness: 50, // number (pixels)
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
        <?php
    }
}else{
    
}
    ?>
    