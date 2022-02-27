<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Dashboard";
if(isset($_SESSION['user'])){
  include_once("../header.php");
  include_once("../manpower/calcMp.php");
    $_SESSION['thn'] = (isset($_POST['tahun']))? $_POST['tahun'] : date('Y');
    $_SESSION['startM'] = (isset($_POST['start']))? $_POST['start'] : date('m');
    $_SESSION['endM'] = (isset($_POST['start']))? $_POST['start'] : date('m');



    $y = $_SESSION['thn'];
    // echo $y."<br>";
    $sM = $_SESSION['startM'];
    $eM = $_SESSION['endM'];
    // mysqli_query($link, "UPDATE working_days SET ket = 'DOP' WHERE ket = 'DOT' ");
    // echo $_SESSION['startM']."<br >";
    // echo $_SESSION['endM']."<br >";
    $tahun = $_SESSION['thn'];

    $tanggalAwal = date('Y-m-d', strtotime($y.'-'.$sM.'-01'));
    // echo "tanggal awal : ".$tanggalAwal."<br>";
    $tanggalAkhir = date('Y-m-t', strtotime($y.'-'.$eM.'-01'));
    // echo "tanggal akhir : ". $tanggalAkhir."<br>";


    $count_awal = date_create($tanggalAwal);
    $count_akhir = date_create($tanggalAkhir);
    if($sM <= $eM){
        $hari = date_diff($count_awal,$count_akhir)->days +1;;
    }else{
        $hari = 0;
    }
    // echo $access_;

    $awal = $blnAwal = strtotime($tanggalAwal); // merubah tanggal awal menjadi format timestamp agar bisa dijumlahkan;
    $akhir =  strtotime($tanggalAkhir); // merubah tanggal akhir menjadi format timestamp agar bisa dijumlahkan;
   
////   
    $clm = "org.".$org_access;
    $sql_totMangkir = mysqli_query($link, "SELECT 

    absensi.id AS id_absenHr,
    absensi.npk AS npk_absenHr, 
    absensi.shift AS shift_absenHr,
    absensi.date AS tanggalHr,
    absensi.check_in AS check_inHr,
    absensi.check_out AS check_outHr,
    absensi.ket AS keteranganHr,

    org.npk AS npk_org,
    org.sub_post AS sub_post,
    org.post AS post,
    org.grp AS grp,
    org.sect AS sect,
    org.dept AS dept,
    org.dept_account AS dept_account,
    org.division AS division,
    org.plant AS plant,

    karyawan.npk AS npk_,
    karyawan.nama AS nama_,
    karyawan.shift AS shift_,
    karyawan.id_area AS id_area_,
    karyawan.department AS department_

    FROM absensi
    JOIN karyawan ON karyawan.npk = absensi.npk
    JOIN org ON org.npk = karyawan.npk
    -- LEFT JOIN req_absensi ON req_absensi.npk = absensi.npk
    WHERE absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND (absensi.ket = 'M' OR absensi.ket = 'TL') AND $clm = '$access_' ")or die(mysqli_error($link));
    $totalMangkir= mysqli_num_rows($sql_totMangkir);

    $sql_totCuti = mysqli_query($link, "SELECT 

    absensi.id AS id_absenHr,
    absensi.npk AS npk_absenHr, 
    absensi.shift AS shift_absenHr,
    absensi.date AS tanggalHr,
    absensi.check_in AS check_inHr,
    absensi.check_out AS check_outHr,
    absensi.ket AS keteranganHr,

    attendance_code.kode AS kode_absen,
    attendance_code.type AS tipe_absen,

    org.npk AS npk_org,
    org.sub_post AS sub_post,
    org.post AS post,
    org.grp AS grp,
    org.sect AS sect,
    org.dept AS dept,
    org.dept_account AS dept_account,
    org.division AS division,
    org.plant AS plant,

    karyawan.npk AS npk_,
    karyawan.nama AS nama_,
    karyawan.shift AS shift_,
    karyawan.id_area AS id_area_,
    karyawan.department AS department_

    FROM absensi
    JOIN karyawan ON karyawan.npk = absensi.npk
    JOIN org ON org.npk = karyawan.npk
    JOIN attendance_code ON attendance_code.kode = absensi.ket
    -- LEFT JOIN req_absensi ON req_absensi.npk = absensi.npk
    WHERE absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND (absensi.ket <> 'S1' OR absensi.ket <> 'S2' ) AND $clm = '$access_' AND attendance_code.type <> 'REMARK' ")or die(mysqli_error($link));
    $totalCuti= mysqli_num_rows($sql_totCuti);

    $sql_totSakit = mysqli_query($link, "SELECT 

    absensi.id AS id_absenHr,
    absensi.npk AS npk_absenHr, 
    absensi.shift AS shift_absenHr,
    absensi.date AS tanggalHr,
    absensi.check_in AS check_inHr,
    absensi.check_out AS check_outHr,
    absensi.ket AS keteranganHr,

    org.npk AS npk_org,
    org.sub_post AS sub_post,
    org.post AS post,
    org.grp AS grp,
    org.sect AS sect,
    org.dept AS dept,
    org.dept_account AS dept_account,
    org.division AS division,
    org.plant AS plant,

    karyawan.npk AS npk_,
    karyawan.nama AS nama_,
    karyawan.shift AS shift_,
    karyawan.id_area AS id_area_,
    karyawan.department AS department_

    FROM absensi
    JOIN karyawan ON karyawan.npk = absensi.npk
    JOIN org ON org.npk = karyawan.npk
    -- LEFT JOIN req_absensi ON req_absensi.npk = absensi.npk
    WHERE absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND (absensi.ket = 'S1' OR absensi.ket = 'S2') AND $clm = '$access_' ")or die(mysqli_error($link));
    $totalSakit= mysqli_num_rows($sql_totSakit);

    $sql_totMasuk = mysqli_query($link, "SELECT 

    absensi.id AS id_absenHr,
    absensi.npk AS npk_absenHr, 
    absensi.shift AS shift_absenHr,
    absensi.date AS tanggalHr,
    absensi.check_in AS check_inHr,
    absensi.check_out AS check_outHr,
    absensi.ket AS keteranganHr,

    org.npk AS npk_org,
    org.sub_post AS sub_post,
    org.post AS post,
    org.grp AS grp,
    org.sect AS sect,
    org.dept AS dept,
    org.dept_account AS dept_account,
    org.division AS division,
    org.plant AS plant,

    karyawan.npk AS npk_,
    karyawan.nama AS nama_,
    karyawan.shift AS shift_,
    karyawan.id_area AS id_area_,
    karyawan.department AS department_

    FROM absensi
    JOIN karyawan ON karyawan.npk = absensi.npk
    JOIN org ON org.npk = karyawan.npk
    -- LEFT JOIN req_absensi ON req_absensi.npk = absensi.npk
    WHERE absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND (absensi.check_in <> '' OR absensi.check_out <> '') AND $clm = '$access_' ")or die(mysqli_error($link));
    $totalMasuk = mysqli_num_rows($sql_totMasuk);

    $sql_totAbs = mysqli_query($link, "SELECT 

    absensi.id AS id_absenHr,
    absensi.npk AS npk_absenHr, 
    absensi.shift AS shift_absenHr,
    absensi.date AS tanggalHr,
    absensi.check_in AS check_inHr,
    absensi.check_out AS check_outHr,
    absensi.ket AS keteranganHr,

    org.npk AS npk_org,
    org.sub_post AS sub_post,
    org.post AS post,
    org.grp AS grp,
    org.sect AS sect,
    org.dept AS dept,
    org.dept_account AS dept_account,
    org.division AS division,
    org.plant AS plant,

    karyawan.npk AS npk_,
    karyawan.nama AS nama_,
    karyawan.shift AS shift_,
    karyawan.id_area AS id_area_,
    karyawan.department AS department_

    FROM absensi
    JOIN karyawan ON karyawan.npk = absensi.npk
    JOIN org ON org.npk = karyawan.npk
    -- LEFT JOIN req_absensi ON req_absensi.npk = absensi.npk
    WHERE absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' ")or die(mysqli_error($link));
    $totalAbs = mysqli_num_rows($sql_totAbs);
    // echo $totalAbs;
    // echo $totalMasuk;
    // echo $totalSakit;
    if($totalAbs > 0){
      $percentMasuk = ($totalMasuk / $totalAbs) * 100;
      $percentSakit = ($totalSakit/ $totalAbs) * 100;
      $percentCuti = ($totalCuti/ $totalAbs) * 100;
      $percentMangkir = ($totalMangkir/ $totalAbs) * 100;
    }else{
      $percentMasuk = 0;
      $percentSakit = 0;
      $percentCuti = 0;
      $percentMangkir = 0;
    }
    

    
    // echo $percentMasuk ;
    // echo $percentCuti ;
    // echo $percentMangkir ;
////
    $sql = mysqli_query($link, "SELECT * FROM info ORDER BY id DESC LIMIT 3")or die(mysqli_error($link));
    $totalInfo = mysqli_num_rows($sql);
    $noInfo = 1;
    $max = ($totalInfo  > 3)? 3 : $totalInfo;


    $bln = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","Sepember","Oktober","November","Desember");
    $totalBln = count($bln);
?>

<!--konten isi -->
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
            <?php
            for($i = 1 ; $i <= $max; $i++){
                $cActives = ($i == $noInfo)?"active":"";
                $slide = $i-1;
            ?>
                <li data-target="#carouselExampleCaptions" data-slide-to="<?=$slide?>" class="<?=$cActives?>"></li>
            <?php
            }
            ?>
            </ol>
            <div class="carousel-inner">
                <?php
                
                $startNo= 1;
                $no = 1;
                while($data = mysqli_fetch_assoc($sql)){
                
                $cActive = ($no == $startNo)?"active":"";
                ?>
                <div class="carousel-item <?=$cActive?>">
                    <img src="/BAIS/dashboard/img/content/<?=$data['image']?>" class="d-block w-100 " alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?=$data['title']?></h5>
                        <p><?=$data['info']?></p>
                    </div>
                </div>
                <?php
                $no++;
                }
                ?>
                
                
            </div>
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- <div class="col-md-6">
    <div class="card card-chart">
        <div class="card-header">
        <h5 class="card-title">24 Hours Performance</h5>
        <p class="card-category">Line Chart</p>
        </div>
        <div class="card-body">
        <canvas id="activeUsers"></canvas>
        </div>
    </div> -->
    <!-- </div> -->
    <div class="col-md-12">
    <div class="card card-chart">
        <div class="card-header">
        <h5 class="card-title">Overtime Cost Achievements</h5>
        <p class="card-category">Line Chart with Points</p>
        <?=$org_access."<br>"?>
        <?=$access_?>
        </div>
        <div class="card-body">
        <canvas id="chartStock"></canvas>
        </div>
    </div>
    </div>
</div>
<div class="row">
    <!-- <div class="col-md-6">
    <div class="card card-chart">
        <div class="card-header">
        <h5 class="card-title">Views</h5>
        <p class="card-category">Bar Chart</p>
        </div>
        <div class="card-body">
        <canvas id="chartViews"></canvas>
        </div>
    </div>
    </div> -->
    <!-- <div class="col-md-6">
    <div class="card car-chart">
        <div class="card-header">
        <h5 class="card-title">Activity</h5>
        <p class="card-category">Multiple Bars Chart</p>
        </div>
        <div class="card-body">
        <canvas id="chartActivity"></canvas>
        </div>
    </div>
    </div> -->
</div>
<div class="row">
    <div class="col-md-12">
    <div class="card ">
        <div class="card-header ">
        <h5 class="card-title">Labour Cost Contribution</h5>
        <p class="card-category">Komposisi Team / Area</p>
        </div>
        <div class="card-body ">
            <div class="row">
                <div class="col-4">
                    <canvas id="chartEmail" class="ct-chart ct-perfect-fourth" width="456" height="300"></canvas>   
                </div>
            </div>
        </div>
        <div class="card-footer ">
        <span class="legend">
            <i class="fa fa-circle text-primary"></i> Direct Labour
        </span>
        <span class="legend">
            <i class="fa fa-circle text-primary"></i> Indirect Labour
        </span>
     
        </div>
    </div>
    </div>
    <div class="col-md-12">
    <div class="card ">
        <div class="card-header ">
        <h5 class="card-title"></h5>
        <p class="card-category"></p>
        </div>
        <div class="card-body ">
        <canvas id=chartHours width="400" height="100"></canvas>
        </div>
        <div class="card-footer ">
        <hr>
        <div class="stats">
            <i class="fa fa-history"></i> Updated 3 minutes ago
        </div>
        </div>
    </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        
        <div class="card card-stats">
        <div class="card-header">
            
            <canvas id="chartmp" class="ct-chart ct-perfect-fourth" width="456" height="300"></canvas> 
            <div class="legend">
                <i class="fa fa-circle text-primary"></i> <?=$areaUser?>
            </div>
        </div>
        <hr>
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="nc-icon nc-single-02 text-primary"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">Total Man Power</p>
                            <p class="card-title"><?=$totalMpArea?> MP
                            <p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <hr>
                <div class="stats">
                    <i class="nc-icon nc-chart-pie-36"></i>
                    detail overview
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header">
                
                <canvas id="chartleave" class="ct-chart ct-perfect-fourth" width="456" height="300"></canvas> 
                <div class="legend">
                    <i class="fa fa-circle text-info"></i> <?=$areaUser?>
                </div>
            </div>
            <hr>
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="fa fa-quote-left text-success"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">Cuti / Ijin</p>
                            <p class="card-title"><?=$totalCuti?> MP
                            <p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <hr>
                <div class="stats">
                    <i class="nc-icon nc-chart-pie-36"></i>
                    detail overview
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header">
                
                <canvas id="chartsick" class="ct-chart ct-perfect-fourth" width="456" height="300"></canvas> 
                <div class="legend">
                    <i class="fa fa-circle text-primary"></i> <?=$areaUser?>
                </div>
            </div>
            <hr>
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="fa fa-bed text-warning"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">Sakit / Rawat Inap</p>
                            <p class="card-title"><?=$totalSakit?> MP
                            <p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <hr>
                <div class="stats">
                    <i class="nc-icon nc-chart-pie-36"></i>
                    detail overview
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header">
                
                <canvas id="chartnopermit" class="ct-chart ct-perfect-fourth" width="456" height="300"></canvas> 
                <div class="legend">
                    <i class="fa fa-circle text-primary"></i> <?=$areaUser?>
                </div>
            </div>
            <hr>
            <div class="card-body ">
                <div class="row">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                            <i class="fa fa-bell-slash text-danger"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">Mangkir / Absen TA</p>
                            <p class="card-title"><?=$totalMangkir?> MP
                            <p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <hr>
                <div class="stats">
                    <i class="nc-icon nc-chart-pie-36"></i>
                    detail overview
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include_once('../absensi/grafik_ijin.php');
include_once('../absensi/grafik_sakit.php');
include_once('../absensi/grafik_mangkir.php');
?>





<?php
//footer
    include_once("../footer.php");
    ?>
<script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
      demo.initChartPageCharts();
    });
  </script>
    <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();


      demo.initVectorMap();

    });
  </script>
    <script>
    // CHARTS
      chartColor = "#FFFFFF";
      
      ctx = document.getElementById('chartIjin').getContext("2d");
  
      gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
      gradientStroke.addColorStop(0, '#80b6f4');
      gradientStroke.addColorStop(1, chartColor);
  
      gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
      gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
      gradientFill.addColorStop(1, "rgba(249, 99, 59, 0.40)");
  
      myChart = new Chart(ctx, {
        type: 'bar',
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
  
  
      ctx = document.getElementById('chartmp').getContext("2d");
      
      myChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ['<?=$areaUser?>', 2],
          datasets: [{
            label: "Emails",
            pointRadius: 0,
            pointHoverRadius: 0,
            backgroundColor: ['#4acccd', '#f4f3ef'],
            borderWidth: 0,
            data: [<?=$totalMasuk?>, <?=$totalAbs-$totalMasuk?>]
          }]
        },
        options: {
          elements: {
            center: {
              text: '<?=$percentMasuk?>%',
              color: '#66615c', // Default is #000000
              fontStyle: 'Arial', // Default is Arial
              sidePadding: 60 // Defualt is 20 (as a percentage)
            }
          },
          cutoutPercentage: 90,
          legend: {
  
            display: false
          },
  
          tooltips: {
            enabled: false
          },
  
          scales: {
            yAxes: [{
  
              ticks: {
                display: false
              },
              gridLines: {
                drawBorder: false,
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
      ctx = document.getElementById('chartleave').getContext("2d");
  
      myChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ['<?=$areaUser?>', 2],
          datasets: [{
            label: "Emails",
            pointRadius: 0,
            pointHoverRadius: 0,
            backgroundColor: ['#04BB87', '#f4f3ef'],
            borderWidth: 0,
            data: [<?=$percentCuti?>, <?=100-$percentCuti?>]
          }]
        },
        options: {
          elements: {
            center: {
              text: '<?=$percentCuti?>%',
              color: '#66615c', // Default is #000000
              fontStyle: 'Arial', // Default is Arial
              sidePadding: 60 // Defualt is 20 (as a percentage)
            }
          },
          cutoutPercentage: 90,
          legend: {
  
            display: false
          },
  
          tooltips: {
            enabled: false
          },
  
          scales: {
            yAxes: [{
  
              ticks: {
                display: false
              },
              gridLines: {
                drawBorder: false,
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
      ctx = document.getElementById('chartsick').getContext("2d");
  
      myChart = new Chart(ctx, {
        type: 'pie',
        data: {

          labels: ['<?=$areaUser?>', 2],
          datasets: [{
            label: "Emails",
            pointRadius: 0,
            pointHoverRadius: 0,
            backgroundColor: ['#FCC468', '#f4f3ef'],
            borderWidth: 0,
            
            data: [<?=$percentSakit?>, <?=100-$percentSakit?>]
          }]
        },
        options: {
          elements: {
            center: {
              text: '<?=$percentSakit?>%',
              color: '#66615c', // Default is #000000
              fontStyle: 'Arial', // Default is Arial
              sidePadding: 60 // Defualt is 20 (as a percentage)
            }
          },
          cutoutPercentage: 90,
          legend: {
  
            display: false
          },
  
          tooltips: {
            enabled: false
          },
  
          scales: {
            yAxes: [{
  
              ticks: {
                display: false
              },
              gridLines: {
                drawBorder: false,
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
      ctx = document.getElementById('chartnopermit').getContext("2d");
  
      myChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ['<?=$areaUser?>', 2],
          datasets: [{
            label: "Emails",
            pointRadius: 0,
            pointHoverRadius: 0,
            backgroundColor: ['#F17E5D', '#f4f3ef'],
            borderWidth: 0,
            data: [<?=$percentMangkir?>, <?=100-$percentMangkir?>]
          }]
        },
        options: {
          elements: {
            center: {
              text: '<?=$percentMangkir?>%',
              color: '#66615c', // Default is #000000
              fontStyle: 'Arial', // Default is Arial
              sidePadding: 60 // Defualt is 20 (as a percentage)
            }
          },
          cutoutPercentage: 90,
          legend: {
  
            display: false
          },
  
          tooltips: {
            enabled: false
          },
  
          scales: {
            yAxes: [{
  
              ticks: {
                display: false
              },
              gridLines: {
                drawBorder: false,
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
  
      // var viewsChart = new Chart(e, a);
  
    
  
  
      </script>
    <?php
    include_once("../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>