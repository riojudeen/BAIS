<?php
include("../../../config/config.php"); 
include("../../../config/schedule_system.php"); 
include("../../../config/approval_system.php"); 
    // $today = date('Y-m-d');
    $today = date('Y-m-d');
    $selesai = dateToDB($_GET['end']);
    $mulai = dateToDB($_GET['start']);
    $data_tanggal = json_decode(get_date($mulai, $selesai));
    // print_r($data_tanggal);
    $q_org = "SELECT `id`,`nama_org`,`cord`,`nama_cord`,`id_parent`,`part` FROM view_cord_area ";
    $q_div = $q_org." WHERE id_parent = '1' AND part = 'division'";
    $q_div = mysqli_query($link, $q_div )or die(mysqli_error($link));
    $shift =  ($_GET['shift'] != '')?" AND absensi.shift = '$_GET[shift]' ":'';
    $org_shift =  ($_GET['shift'] != '')?" AND shift = '$_GET[shift]' ":'';
    // echo mysqli_num_rows($q_div);
    $data_dept = array(); //penampung data dept account id
    $data_masuk = array(); //penampung data jumlah karyawan masuk
    $data_ijin = array(); //penampung data jumlah karyawan masuk
    if(mysqli_num_rows($q_div)> 0){
        while($div = mysqli_fetch_assoc($q_div)){
          $q_dept_account = $q_org." WHERE id_parent = '$div[id]' AND part = 'deptAcc' ";
          $sql_dept_account = mysqli_query($link, $q_dept_account)or die(mysqli_error($link));
          // echo mysqli_num_rows($sql_dept_account);
          if(mysqli_num_rows($sql_dept_account)>0){
            $index = 0;
            
            while($data_dept_account = mysqli_fetch_assoc($sql_dept_account)){
              
              $index_masuk = 0;
              $data_dept[$data_dept_account['id']] = array();//jadikan data array department sebagai array penampung

              foreach($data_tanggal AS $tgl ){
                $q_abs_dept ="SELECT absensi.npk FROM absensi 
                    LEFT JOIN attendance_code 
                    ON attendance_code.kode = absensi.ket 
            
                    LEFT JOIN attendance_alias ON attendance_alias.id = attendance_code.alias 
                    JOIN org ON org.npk = absensi.npk 
                    WHERE  absensi.date = '$tgl' AND org.division = '$div[id]' AND org.dept_account = '$data_dept_account[id]' ";
                $q_masuk_dept = " AND ( absensi.ket = '' OR attendance_alias.id = '1' OR attendance_alias.id = '2' 
                    OR attendance_alias.id = '3')";
                $q_ijin_dept = " AND ( attendance_alias.id = '4' OR attendance_alias.id = '5' 
                    OR attendance_alias.id = '6' OR attendance_alias.id = '7' OR attendance_alias.id = '8' OR attendance_alias.id = '9'  )";
                $sql_total = mysqli_query($link, $q_abs_dept.$shift)or die(mysqli_error($link));
                $sql_masuk_dept = mysqli_query($link, $q_abs_dept.$q_masuk_dept.$shift)or die(mysqli_error($link));
                $sql_ijin_dept = mysqli_query($link, $q_abs_dept.$q_ijin_dept.$shift)or die(mysqli_error($link));
                // $sql_absen_dept = mysqli_query($link, $q_abs_dept.$shift)or die(mysqli_error($link));
                
                $tot_dept = mysqli_num_rows($sql_total);
                $masuk_dept = mysqli_num_rows($sql_masuk_dept);
                $ijin_dept = mysqli_num_rows($sql_ijin_dept);

                $eff_masuk = ($tot_dept>0)?($masuk_dept/$tot_dept)*100:0;
                $eff_ijin = ($tot_dept>0)?($ijin_dept/$tot_dept)*100:0;
                // array_push($data_dept[$index], $masuk_dept);
                // array_push($data_dept[$index], $tgl);
                $data_masuk[$tgl] = array(
                  'masuk' => round($eff_masuk),
                  'ijin' => round($eff_ijin)
                );
                
                 //tampung data masuk ke dalam array assosiatif department

              }
              array_push($data_dept[$data_dept_account['id']], $data_masuk);
              $index++;

            }
          }
          // print_r($data_dept);
          // echo count($data_dept);
          $label_dept_account = '';
          foreach($data_dept AS $dept => $val){
            // echo getOrgName($link, $dept, "deptAcc")."<br>";
            $label_dept_account .= getOrgName($link, $dept, "deptAcc").",";
            // print_r($val)."<br>";
            foreach($data_tanggal AS $tgl){
              // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
            }
          }
          $label_dept_account = substr($label_dept_account, 0, -1);
          // echo $label_dept_account;
          

        $q_total_karyawan = mysqli_query($link, "SELECT npk FROM view_organization WHERE id_division = '$div[id]' ".$org_shift)or die(mysqli_error($link));
        $total_karyawan = mysqli_num_rows($q_total_karyawan);
        $q_cek_absensi ="SELECT absensi.npk FROM absensi 
            LEFT JOIN attendance_code 
            ON attendance_code.kode = absensi.ket 
    
            LEFT JOIN attendance_alias ON attendance_alias.id = attendance_code.alias 
            JOIN org ON org.npk = absensi.npk 
            WHERE  absensi.date = '$today' AND org.division = '$div[id]' ";

        $q_masuk = " AND ( absensi.ket = '' OR attendance_alias.id = '1' OR attendance_alias.id = '2' 
            OR attendance_alias.id = '3')";
        $q_ijin = " AND ( attendance_alias.id = '4' OR attendance_alias.id = '5' 
            OR attendance_alias.id = '6' OR attendance_alias.id = '7' OR attendance_alias.id = '8' OR attendance_alias.id = '9'  )";
        $sql_masuk = mysqli_query($link, $q_cek_absensi.$q_masuk.$shift)or die(mysqli_error($link));
        $sql_ijin = mysqli_query($link, $q_cek_absensi.$q_ijin.$shift)or die(mysqli_error($link));
    
        $total_masuk = mysqli_num_rows($sql_masuk);
        $total_ijin = mysqli_num_rows($sql_ijin);
        $total_selisih = $total_karyawan - ($total_masuk+$total_ijin);

        // effisiensi masuk 
        if($total_karyawan > 0){
          $eff_mp = round(($total_masuk/$total_karyawan)*100);
        }else{
          $eff_mp = 0;
        }
        // echo $q_cek_absensi.$q_masuk.$shift
        $percent_masuk = ($total_karyawan>0)?round(($total_masuk/$total_karyawan)*100):0;
        $percent_ijin = ($total_karyawan>0)?round(($total_ijin/$total_karyawan)*100):0;
        $percent_gap = ($total_karyawan>0)?round(($total_selisih/$total_karyawan)*100):0;
        // echo $percent_masuk."<br>";
        // echo $percent_ijin."<br>";
        // echo $percent_gap."<br>";
        // echo $total_karyawan."<br>";
        if($total_selisih > 0){
          $label = "'Masuk','Tidak Masuk / Ijin','Gap'";
          $data = "$percent_masuk,$percent_ijin,$percent_gap";
        }else{
          $label = "Masuk,Tidak Masuk / Ijin,Gap";
          $data = "$percent_masuk,$percent_ijin,$percent_gap";
        }
        // echo $data;
        
            ?>
            <!-- divisi efficiency -->
            <div class="col-md-12">
                <div class="card card-plain">
                    
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-3">
                                <h5 class="">Body Division</h5>
                                <p class="card-category"><?=tgl($today)?></p>
                                <canvas id="chartDonut<?=$div['id']?>" class="ct-chart ct-perfect-fourth"  height="300"></canvas>
                            </div>
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
                                    ctx = document.getElementById('chartDonut<?=$div['id']?>').getContext("2d");

                                    myChart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: [<?=$label?>],
                                        datasets: [{
                                        label: "Effisiensi Kehadiaran",
                                        pointRadius: 0,
                                        pointHoverRadius: 0,
                                        backgroundColor: ['#4acccd', '#FF5733', '#f4f3ef'],
                                        borderWidth: 0,
                                        data: [<?=$data?>]
                                        }]
                                    },
                                    options: {
                                        elements: {
                                        center: {
                                            text: '<?=$eff_mp?>%',
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
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-7">
                                        <h5 class="">Atendance Efficiency </h5>
                                        <p class="card-category">periode : <?=tgl(dateToDB($_GET['start']))?> - <?=tgl(dateToDB($_GET['end']))?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <canvas id="attendancerate" class="ct-chart ct-perfect-fourth"  height="90"></canvas>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            
            <div class="col-md-12">
                <div class="row">
                <?php
                    $q_dept = $q_org." WHERE id_parent = '$div[id]' AND part = 'dept' ";
                    $sqldept = mysqli_query($link, $q_dept)or die(mysqli_error($link));
                    if(mysqli_num_rows($sqldept) > 0){
                        while($dept = mysqli_fetch_assoc($sqldept)){
                          $q_abs_dept ="SELECT absensi.npk FROM absensi 
                              LEFT JOIN attendance_code 
                              ON attendance_code.kode = absensi.ket 
                      
                              LEFT JOIN attendance_alias ON attendance_alias.id = attendance_code.alias 
                              JOIN org ON org.npk = absensi.npk 
                              WHERE  absensi.date = '$today' AND org.division = '$div[id]' AND org.dept_account = '$dept[id]' ";
                          $q_masuk_dept = " AND ( absensi.ket = '' OR attendance_alias.id = '1' OR attendance_alias.id = '2' 
                              OR attendance_alias.id = '3')";
                          $q_ijin_dept = " AND ( attendance_alias.id = '4' OR attendance_alias.id = '5' 
                              OR attendance_alias.id = '6' OR attendance_alias.id = '7' OR attendance_alias.id = '8' OR attendance_alias.id = '9'  )";
                          $sql_total = mysqli_query($link, $q_abs_dept.$shift)or die(mysqli_error($link));
                          $sql_masuk_dept = mysqli_query($link, $q_abs_dept.$q_masuk_dept.$shift)or die(mysqli_error($link));
                          $sql_ijin_dept = mysqli_query($link, $q_abs_dept.$q_ijin_dept.$shift)or die(mysqli_error($link));
                          // $sql_absen_dept = mysqli_query($link, $q_abs_dept.$shift)or die(mysqli_error($link));
                          $masukDept = mysqli_num_rows($sql_masuk_dept);
                          $ijinDept = mysqli_num_rows($sql_ijin_dept);
                          $total = mysqli_num_rows($sql_total);

                          $eff = ($total > 0)?round(($masukDept/$total)*100):0;
                          $color_eff = ($eff >= 95)?"success":"danger";
                            ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats " style="border: 1px solid rgba(184, 223, 254)">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-2 col-md-2 ">
                                        <div class="icon-big text-center icon-warning">
                                            <i class="nc-icon nc-globe text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="col-10 col-md-10 ">
                                        <div class="row">
                                            <div class="col-md-5 numbers ">
                                                <p class="card-title"><?=$eff?>%<p>
                                            </div>
                                            <div class="col-md-7 border-left">
                                                <h6 class=""><?=$dept['nama_org']?></h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="category">Total MP: <br> <?=$total?><p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="category">Masuk: <br> <?=$masukDept?><p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="progress">
                                                <div class="progress-bar bg-<?=$color_eff?>" role="progressbar" style="width: <?=$eff?>%;" aria-valuenow="<?=$eff?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                
                                            </div>

                                          </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-footer my-0">
                            <a href="?dept=<?=$dept['id']?>" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                            <?php
                        }
                    }
                    ?>
                    
                    
                    
                </div>
            </div>
            <!-- divisi efficiency -->
            <?php
        }
    }
    ?>
    
<script>
    // CHARTS
    chartColor = "#FFFFFF";
    
    ctx = document.getElementById('attendancerate').getContext("2d");

    gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#80b6f4');
    gradientStroke.addColorStop(1, chartColor);

    gradientFill = ctx.createLinearGradient(0, 50, 0, 200);
    gradientFill.addColorStop(0, "rgba(55, 164, 255,1)");
    gradientFill.addColorStop(1, "rgba(55, 164, 255,0.4)");

    gradientFill1 = ctx.createLinearGradient(0, 50, 0, 200);
    gradientFill1.addColorStop(0, "rgba(55, 164, 255,1)");
    gradientFill1.addColorStop(1, "rgba(55, 164, 255, 0.1)");

    gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
    gradientFill2.addColorStop(0, "rgba(1, 181, 225, 1)");
    gradientFill2.addColorStop(1, "rgba(1, 181, 225, 0.1)");

    gradientFill3 = ctx.createLinearGradient(0, 50, 0, 200);
    gradientFill3.addColorStop(0, "rgba(5, 217, 246, 1)");
    gradientFill3.addColorStop(1, "rgba(5, 217, 246, 0.1)");
    gradientFill4 = ctx.createLinearGradient(0, 50, 0, 200);
    gradientFill4.addColorStop(0, "rgba(5, 217, 246, 1)");
    gradientFill4.addColorStop(1, "rgba(5, 217, 246, 0.1)");
    gradientFill5 = ctx.createLinearGradient(0, 50, 0, 200);
    gradientFill5.addColorStop(0, "rgba(5, 217, 246, 1)");
    gradientFill5.addColorStop(1, "rgba(5, 217, 246, 0.1)");

    myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [
          <?php
          $data_label = '';
          $i = 1;
            foreach($data_tanggal AS $tgl){
              $data = explode('-',$tgl);
              $tanggal = $data[2];
              $data_label .= "'".$tanggal."',";
              // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
            }
            $data_label = substr($data_label, 0, -1);
            echo 
            "$data_label";
          ?>
        ],
        
        datasets: [
          <?php
            $no = 1;
            foreach($data_dept AS $dept => $val){
              $dept = getOrgName($link, $dept, "deptAcc");
              $masuk = '';
              foreach($data_tanggal AS $tgl){
                $masuk .= $val[0][$tgl]['masuk'].",";
                // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
              }
              $masuk = substr($masuk, 0, -1);
              echo 
              "{ 
                label: \"$dept\",
                type: 'bar',
                borderColor: '#fcc468',
                fill: true,
                backgroundColor: gradientFill$no,
                hoverBorderColor: '#fcc468',
                order: $no,
                borderWidth: 0,
                data: [
                  $masuk
                ],
              },";
              $no++;
              // echo getOrgName($link, $dept, "deptAcc")."<br>";
              // print_r($val)."<br>";
              
            }
            $data_target = '';
            foreach($data_tanggal AS $tgl){
              $data_target .= "95,";
              // echo $val[0][$tgl]['masuk']."-".$val[0][$tgl]['ijin']."<br>";
            }
            $data_target = substr($data_target, 0,-1);
            echo 
            "{
              label: \"Target\",
              borderColor: '#fcc468',
              fill: true,
              type: 'line',
              backgroundColor: 'rgba(255, 39, 0, 0.1)',
              hoverBorderColor: '#fcc468',
              borderWidth: 0,
              data: [
                $data_target
              ],
            }"
          ?>
          // {
          //   label: "Production",
          //   borderColor: '#fcc468',
          //   fill: true,
          //   backgroundColor: gradientFill,
          //   hoverBorderColor: '#fcc468',
          //   borderWidth: 0,
          //   data: [
          //     10, 100,150,75,200,200,150,125,230,132,216,147,111,160,216,170,157,116,283,156,275
          //   ],
          // },{
          //   label: "Production",
          //   borderColor: '#fcc468',
          //   fill: true,
          //   backgroundColor: gradientFill2,
          //   hoverBorderColor: '#fcc468',
          //   borderWidth: 0,
          //   data: [
          //     10, 100,150,75,200,200,150,125,230,132,216,147,111,160,216,170,157,116,283,156,275
          //   ],
          // },{
          //   label: "Target",
          //   borderColor: '#fcc468',
          //   fill: true,
          //   type: 'line',
          //   backgroundColor: 'rgba(255, 39, 0, 0.1)',
          //   hoverBorderColor: '#fcc468',
          //   borderWidth: 0,
          //   data: [
          //     100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100
          //   ],
          // },{
          //   label: "Acc",
          //   borderColor: '#fcc468',
          //   fill: true,
          //   type: 'line',
          //   backgroundColor: 'rgba(255, 39, 0, 0.1)',
          //   hoverBorderColor: '#fcc468',
          //   borderWidth: 0,
          //   data: [
          //     10, 200,300,150,400,450,300,250,460,264,432,398,222,333,432,345,314,234,567,313,555
          //   ],
          // }
          
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
            ticks: {
            fontColor: "#9f9f9f",
            fontStyle: "bold",
            beginAtZero: false,
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
            barPercentage: 0.9,
            gridLines: {
              zeroLineColor: "white",
              
              display: false,

              drawBorder: false,
              color: 'transparent',
            },
            ticks: {
              padding: 20,
              
              fontColor: "#9f9f9f",
              fontStyle: "bold",
              
              
            }
          }]
        }
      }
    });
    </script>