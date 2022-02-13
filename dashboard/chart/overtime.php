<?php
if($dept == '5'){
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
  
  ctx = document.getElementById('labourcost14').getContext("2d");

  gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
  gradientStroke.addColorStop(0, '#80b6f4');
  gradientStroke.addColorStop(1, chartColor);

  gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
  gradientFill.addColorStop(0, "rgba(32, 204, 255, 1)");
  gradientFill.addColorStop(1, "rgba(112, 223, 255, 0.2)");

  gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
  gradientFill2.addColorStop(0, "rgba(255, 164, 32, 1)");
  gradientFill2.addColorStop(1, "rgba(249, 99, 59, 0.30)");

  myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        <?php
          $totalHari = count($array_tgl);
          $tanggal = "'".bln($tanggalAwal)."'";
          foreach($array_tgl as $tgl){
            $tanggal .= ", ".date('d', strtotime($tgl));
          }
          echo $tanggal
          ?>
      ],
      datasets: [

        {
          label: "OT MIX D14",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = otcost($link, $cnt, $tanggalAkhir, $car14, $car12, $mix14, $mix);
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(otcost($link, $cnt, $tgl, $car14, $car12, $mix14, $mix));
            }
            echo $data;
            ?>
          ],
        },{
          label: "OT S/P D14",
          borderColor: '#00C9D6',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#00C9D6',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = otcost($link, $cnt, $tanggalAkhir, $car14, $car12, $sp14, $sp);
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(otcost($link, $cnt, $tgl, $car14, $car12, $sp14, $sp));
            }
            echo $data;
            ?>
          ],
        },{
          label: "IDR OT",
          borderColor: '#00C9D6',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#00C9D6',
          borderWidth: 0,
          data: [
            <?php
            $cost_bulanan = otcost($link, $cnt, $tanggalAkhir, $car14, '0', $dataidr1, $idr);
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(otcost($link, $cnt, $tgl, $car14, '0', $dataidr1, $idr));
            }
            echo $data;
            ?>
          ],
        },{
          label: "SALARY MIX D14",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill2,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = salaryRateDirectDailyMix($cnts, $dept, $car14, $mix14, $tanggalAwal, $tanggalAkhir, $db_mos, $db_bais)/1000;
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(salaryRateDirectDailyMix($cnts, $dept, $car14, $mix14, $tanggalAwal, $tgl, $db_mos, $db_bais)/1000);
            }
            echo $data;
            ?>
          ],
        },{
          label: "SALARY S/P D14",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill2,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = salaryRateDirectDailySpc($cnts, $dept, $car14, $sp14, $tanggalAwal, $tanggalAkhir, $db_mos, $db_bais)/1000;
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(salaryRateDirectDailySpc($cnts, $dept, $car14, $sp14, $tanggalAwal, $tgl, $db_mos, $db_bais)/1000);
            }
            echo $data;
            ?>
          ],
        },{
          label: "SALARY IDR S/P D14",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill2,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = salaryRateIndirectDailySpc($cnts, $dept, $car14, $sp14, $tanggalAwal, $tanggalAkhir, $db_mos, $db_bais)/1000;
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(salaryRateIndirectDailySpc($cnts, $dept, $car14, $sp14, $tanggalAwal, $tgl, $db_mos, $db_bais)/1000);
            }
            echo $data;
            ?>
          ],
        },{
          label: "SALARY IDR MIX D14",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill2,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = salaryRateIndirectDailyMix($cnts, $dept, $car14, $mix14, $tanggalAwal, $tanggalAkhir, $db_mos, $db_bais)/1000;
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(salaryRateIndirectDailyMix($cnts, $dept, $car14, $mix14, $tanggalAwal, $tgl, $db_mos, $db_bais)/1000);
            }
            echo $data;
            ?>
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
            <?php
            $target = lbr_target($link, 'overtime', $tanggalAkhir);
            foreach($array_tgl as $tgl){
              $target .= ', '.(lbr_target($link, 'overtime', $tgl));
            }
            echo $target;
            
            ?>
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

        display: false
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
            max: 2000
          },
          gridLines: {
            zeroLineColor: "transparent",
            display: true,
            drawBorder: false,
            color: '#9f9f9f',
          }

        }],
        xAxes: [{
          stacked: true,
          barPercentage: 0.4,
          barThickness: 15,  // number (pixels) or 'flex'
          maxBarThickness: 20, // number (pixels)
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
// CHARTS
  chartColor = "#FFFFFF";
  
  ctx = document.getElementById('labourcost12').getContext("2d");

  gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
  gradientStroke.addColorStop(0, '#80b6f4');
  gradientStroke.addColorStop(1, chartColor);

  gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
  gradientFill.addColorStop(0, "rgba(32, 204, 255, 1)");
  gradientFill.addColorStop(1, "rgba(112, 223, 255, 0.2)");

  gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
  gradientFill2.addColorStop(0, "rgba(255, 164, 32, 1)");
  gradientFill2.addColorStop(1, "rgba(249, 99, 59, 0.30)");

  myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        <?php
          $totalHari = count($array_tgl);
          $tanggal = "'".bln($tanggalAwal)."'";
          foreach($array_tgl as $tgl){
            $tanggal .= ", ".date('d', strtotime($tgl));
          }
          echo $tanggal
          ?>
      ],
      datasets: [

        {
          label: "OT MIX D14",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = otcost($link, $cnt, $tanggalAkhir, $car12, $car14, $mix12, $mix);
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(otcost($link, $cnt, $tgl, $car12, $car14, $mix12, $mix));
            }
            echo $data;
            ?>
          ],
        },{
          label: "OT S/P D12",
          borderColor: '#00C9D6',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#00C9D6',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = otcost($link, $cnt, $tanggalAkhir, $car12, $car14, $sp12, $sp);
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(otcost($link, $cnt, $tgl, $car12, $car14, $sp12, $sp));
            }
            echo $data;
            ?>
          ],
        },{
          label: "IDR OT",
          borderColor: '#00C9D6',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#00C9D6',
          borderWidth: 0,
          data: [
            <?php
            $cost_bulanan = otcost($link, $cnt, $tanggalAkhir, $car12 , '0', $dataidr1, $idr);
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(otcost($link, $cnt, $tgl, $car12, '0', $dataidr1, $idr));
            }
            echo $data;
            ?>
          ],
        },{
          label: "SALARY MIX D12",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill2,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = salaryRateDirectDailyMix($cnts, $dept, $car12, $mix12, $tanggalAwal, $tanggalAkhir, $db_mos, $db_bais)/1000;
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(salaryRateDirectDailyMix($cnts, $dept, $car12, $mix12, $tanggalAwal, $tgl, $db_mos, $db_bais)/1000);
            }
            echo $data;
            ?>
          ],
        },{
          label: "SALARY S/P D14",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill2,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = salaryRateDirectDailySpc($cnts, $dept, $car12, $sp12, $tanggalAwal, $tanggalAkhir, $db_mos, $db_bais)/1000;
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(salaryRateDirectDailySpc($cnts, $dept, $car12, $sp12, $tanggalAwal, $tgl, $db_mos, $db_bais)/1000);
            }
            echo $data;
            ?>
          ],
        },{
          label: "SALARY IDR S/P D12",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill2,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = salaryRateIndirectDailySpc($cnts, $dept, $car12, $sp12, $tanggalAwal, $tanggalAkhir, $db_mos, $db_bais)/1000;
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(salaryRateIndirectDailySpc($cnts, $dept, $car12, $sp12, $tanggalAwal, $tgl, $db_mos, $db_bais)/1000);
            }
            echo $data;
            ?>
          ],
        },{
          label: "SALARY IDR MIX D12",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill2,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = salaryRateIndirectDailyMix($cnts, $dept, $car12, $mix12, $tanggalAwal, $tanggalAkhir, $db_mos, $db_bais)/1000;
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(salaryRateIndirectDailyMix($cnts, $dept, $car12, $mix12, $tanggalAwal, $tgl, $db_mos, $db_bais)/1000);
            }
            echo $data;
            ?>
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
            <?php
            $target = lbr_target($link, 'overtime', $tanggalAkhir);
            foreach($array_tgl as $tgl){
              $target .= ', '.(lbr_target($link, 'overtime', $tgl));
            }
            echo $target;
            
            ?>
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

        display: false
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
            max: 2000
          },
          gridLines: {
            zeroLineColor: "transparent",
            display: true,
            drawBorder: false,
            color: '#9f9f9f',
          }

        }],
        xAxes: [{
          stacked: true,
          barPercentage: 0.4,
          barThickness: 15,  // number (pixels) or 'flex'
          maxBarThickness: 20, // number (pixels)
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
// CHARTS
  chartColor = "#FFFFFF";
  
  ctx = document.getElementById('overtimed14').getContext("2d");

  gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
  gradientStroke.addColorStop(0, '#80b6f4');
  gradientStroke.addColorStop(1, chartColor);

  gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
  gradientFill.addColorStop(0, "rgba(32, 204, 255, 1)");
  gradientFill.addColorStop(1, "rgba(112, 223, 255, 0.2)");

  myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        <?php
          $totalHari = count($array_tgl);
          $tanggal = "'".bln($tanggalAwal)."'";
          foreach($array_tgl as $tgl){
            $tanggal .= ", ".date('d', strtotime($tgl));
          }
          echo $tanggal
          ?>
      ],
      datasets: [
        {
          label: "OT MIX D14",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = otcost($link, $cnt, $tanggalAkhir, $car14, $car12, $mix14, $mix);
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(otcost($link, $cnt, $tgl, $car14, $car12, $mix14, $mix));
            }
            echo $data;
            ?>
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

        display: false
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
            max: 300
          },
          gridLines: {
            zeroLineColor: "transparent",
            display: true,
            drawBorder: false,
            color: '#9f9f9f',
          }

        }],
        xAxes: [{
          stacked: true,
          barPercentage: 0.4,
          barThickness: 15,  // number (pixels) or 'flex'
          maxBarThickness: 20, // number (pixels)
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
// CHARTS
  chartColor = "#FFFFFF";
  
  ctx = document.getElementById('overtimed12').getContext("2d");

  gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
  gradientStroke.addColorStop(0, '#80b6f4');
  gradientStroke.addColorStop(1, chartColor);

  gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
  gradientFill.addColorStop(0, "rgba(32, 204, 255, 1)");
  gradientFill.addColorStop(1, "rgba(112, 223, 255, 0.2)");

  myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        <?php
          $totalHari = count($array_tgl);
          $tanggal = "'".bln($tanggalAwal)."'";
          foreach($array_tgl as $tgl){
            $tanggal .= ", ".date('d', strtotime($tgl));
          }
          echo $tanggal
          ?>
      ],
      datasets: [
        {
          label: "OVERTIME MIX D12",
          borderColor: '#00C9D6',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#00C9D6',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = otcost($link, $cnt, $tanggalAkhir, $car12, $car14, $mix12, $mix);
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(otcost($link, $cnt, $tgl, $car12, $car14, $mix12, $mix));
            }
            echo $data;
            ?>
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

        display: false
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
            max: 300
          },
          gridLines: {
            zeroLineColor: "transparent",
            display: true,
            drawBorder: false,
            color: '#9f9f9f',
          }

        }],
        xAxes: [{
          stacked: true,
          barPercentage: 0.4,
          barThickness: 15,  // number (pixels) or 'flex'
          maxBarThickness: 20, // number (pixels)
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
// CHARTS
  chartColor = "#FFFFFF";
  
  ctx = document.getElementById('overtimesp14').getContext("2d");

  gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
  gradientStroke.addColorStop(0, '#80b6f4');
  gradientStroke.addColorStop(1, chartColor);

  gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
  gradientFill.addColorStop(0, "rgba(32, 204, 255, 1)");
  gradientFill.addColorStop(1, "rgba(112, 223, 255, 0.2)");

  myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        <?php
          $totalHari = count($array_tgl);
          $tanggal = "'".bln($tanggalAwal)."'";
          foreach($array_tgl as $tgl){
            $tanggal .= ", ".date('d', strtotime($tgl));
          }
          echo $tanggal
          ?>
      ],
      datasets: [

        {
          label: "OT S/P D14",
          borderColor: '#00C9D6',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#00C9D6',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = otcost($link, $cnt, $tanggalAkhir, $car14, $car12, $sp14, $sp);
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(otcost($link, $cnt, $tgl, $car14, $car12, $sp14, $sp));
            }
            echo $data;
            ?>
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

        display: false
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
            max: 300
          },
          gridLines: {
            zeroLineColor: "transparent",
            display: true,
            drawBorder: false,
            color: '#9f9f9f',
          }

        }],
        xAxes: [{
          stacked: true,
          barPercentage: 0.4,
          barThickness: 15,  // number (pixels) or 'flex'
          maxBarThickness: 20, // number (pixels)
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
// CHARTS
  chartColor = "#FFFFFF";
  
  ctx = document.getElementById('overtimesp12').getContext("2d");

  gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
  gradientStroke.addColorStop(0, '#80b6f4');
  gradientStroke.addColorStop(1, chartColor);

  gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
  gradientFill.addColorStop(0, "rgba(32, 204, 255, 1)");
  gradientFill.addColorStop(1, "rgba(112, 223, 255, 0.2)");

  myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        <?php
          $totalHari = count($array_tgl);
          $tanggal = "'".bln($tanggalAwal)."'";
          foreach($array_tgl as $tgl){
            $tanggal .= ", ".date('d', strtotime($tgl));
          }
          echo $tanggal
          ?>
      ],
      datasets: [

        {
          label: "OT S/P D12",
          borderColor: '#00C9D6',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#00C9D6',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = otcost($link, $cnt, $tanggalAkhir, $car12, $car14, $sp12, $sp);
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(otcost($link, $cnt, $tgl, $car12, $car14, $sp12, $sp));
            }
            echo $data;
            ?>
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

        display: false
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
            max: 300
          },
          gridLines: {
            zeroLineColor: "transparent",
            display: true,
            drawBorder: false,
            color: '#9f9f9f',
          }

        }],
        xAxes: [{
          stacked: true,
          barPercentage: 0.4,
          barThickness: 15,  // number (pixels) or 'flex'
          maxBarThickness: 20, // number (pixels)
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
// CHARTS
  chartColor = "#FFFFFF";
  
  ctx = document.getElementById('overtimeIDR').getContext("2d");

  gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
  gradientStroke.addColorStop(0, '#80b6f4');
  gradientStroke.addColorStop(1, chartColor);

  gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
  gradientFill.addColorStop(0, "rgba(32, 204, 255, 1)");
  gradientFill.addColorStop(1, "rgba(112, 223, 255, 0.2)");

  myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        <?php
          $totalHari = count($array_tgl);
          $tanggal = "'".bln($tanggalAwal)."'";
          foreach($array_tgl as $tgl){
            $tanggal .= ", ".date('d', strtotime($tgl));
          }
          echo $tanggal
          ?>
      ],
      datasets: [

        {
          label: "IDR OT",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            $cost_bulanan = otcost($link, $cnt, $tanggalAkhir, $car12 , '0', $dataidr1, $idr);
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(otcost($link, $cnt, $tgl, $car12, '0', $dataidr1, $idr));
            }
            echo $data;
            ?>
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

        display: false
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
            max: 300
          },
          gridLines: {
            zeroLineColor: "transparent",
            display: true,
            drawBorder: false,
            color: '#9f9f9f',
          }

        }],
        xAxes: [{
          stacked: true,
          barPercentage: 0.4,
          barThickness: 15,  // number (pixels) or 'flex'
          maxBarThickness: 20, // number (pixels)
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

}else{
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
  
  ctx = document.getElementById('labourcost40').getContext("2d");

  gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
  gradientStroke.addColorStop(0, '#80b6f4');
  gradientStroke.addColorStop(1, chartColor);

  gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
  gradientFill.addColorStop(0, "rgba(32, 204, 255, 1)");
  gradientFill.addColorStop(1, "rgba(112, 223, 255, 0.2)");

  gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
  gradientFill2.addColorStop(0, "rgba(255, 164, 32, 1)");
  gradientFill2.addColorStop(1, "rgba(249, 99, 59, 0.30)");

  myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        <?php
          $totalHari = count($array_tgl);
          $tanggal = "'".bln($tanggalAwal)."'";
          foreach($array_tgl as $tgl){
            $tanggal .= ", ".date('d', strtotime($tgl));
          }
          echo $tanggal
          ?>
      ],
      datasets: [

        {
          label: "OT DIRECT D40D",
          borderColor: '#00C9D6',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#00C9D6',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = otcost($link, $cnt, $tanggalAkhir, $car40, '0', $sp40, $sp);
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(otcost($link, $cnt, $tgl, $car40, '0', $sp40, $sp));
            }
            echo $data;
            ?>
          ],
        },{
          label: "IDR OT",
          borderColor: '#00C9D6',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#00C9D6',
          borderWidth: 0,
          data: [
            <?php
            $cost_bulanan = otcost($link, $cnt, $tanggalAkhir, $car40, '0', $dataidr1, $idr);
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(otcost($link, $cnt, $tgl, $car40, '0', $dataidr1, $idr));
            }
            echo $data;
            ?>
          ],
        },{
          label: "SALARY DIRECT D40D",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill2,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = salaryRateDirectDailySpc($cnts, $dept, $car40, $sp40, $tanggalAwal, $tanggalAkhir, $db_mos, $db_bais)/1000;
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(salaryRateDirectDailySpc($cnts, $dept, $car40, $sp40, $tanggalAwal, $tgl, $db_mos, $db_bais)/1000);
            }
            echo $data;
            ?>
          ],
        },{
          label: "SALARY IDR D40",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill2,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = salaryRateIndirectDailySpc($cnts, $dept, $car40, $sp40, $tanggalAwal, $tanggalAkhir, $db_mos, $db_bais)/1000;
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(salaryRateIndirectDailySpc($cnts, $dept, $car40, $sp40, $tanggalAwal, $tgl, $db_mos, $db_bais)/1000);
            }
            echo $data;
            ?>
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
            <?php
            $target = lbr_target($link, 'overtime', $tanggalAkhir);
            foreach($array_tgl as $tgl){
              $target .= ', '.(lbr_target($link, 'overtime', $tgl));
            }
            echo $target;
            
            ?>
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

        display: false
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
            max: 4000
          },
          gridLines: {
            zeroLineColor: "transparent",
            display: true,
            drawBorder: false,
            color: '#9f9f9f',
          }

        }],
        xAxes: [{
          stacked: true,
          barPercentage: 0.4,
          barThickness: 15,  // number (pixels) or 'flex'
          maxBarThickness: 20, // number (pixels)
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
// CHARTS
  chartColor = "#FFFFFF";
  
  ctx = document.getElementById('overtimed40').getContext("2d");

  gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
  gradientStroke.addColorStop(0, '#80b6f4');
  gradientStroke.addColorStop(1, chartColor);

  gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
  gradientFill.addColorStop(0, "rgba(32, 204, 255, 1)");
  gradientFill.addColorStop(1, "rgba(112, 223, 255, 0.2)");

  gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
  gradientFill2.addColorStop(0, "rgba(255, 164, 32, 1)");
  gradientFill2.addColorStop(1, "rgba(249, 99, 59, 0.30)");

  myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        <?php
          $totalHari = count($array_tgl);
          $tanggal = "'".bln($tanggalAwal)."'";
          foreach($array_tgl as $tgl){
            $tanggal .= ", ".date('d', strtotime($tgl));
          }
          echo $tanggal
          ?>
      ],
      datasets: [

        {
          label: "OT DIRECT D40D",
          borderColor: '#00C9D6',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#00C9D6',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = otcost($link, $cnt, $tanggalAkhir, $car40, '0', $sp40, $sp);
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(otcost($link, $cnt, $tgl, $car40, '0', $sp40, $sp));
            }
            echo $data;
            ?>
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

        display: false
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
            max: 4000
          },
          gridLines: {
            zeroLineColor: "transparent",
            display: true,
            drawBorder: false,
            color: '#9f9f9f',
          }

        }],
        xAxes: [{
          stacked: true,
          barPercentage: 0.4,
          barThickness: 15,  // number (pixels) or 'flex'
          maxBarThickness: 20, // number (pixels)
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
// CHARTS
  chartColor = "#FFFFFF";
  
  ctx = document.getElementById('overtimeIDR').getContext("2d");

  gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
  gradientStroke.addColorStop(0, '#80b6f4');
  gradientStroke.addColorStop(1, chartColor);

  gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
  gradientFill.addColorStop(0, "rgba(32, 204, 255, 1)");
  gradientFill.addColorStop(1, "rgba(112, 223, 255, 0.2)");

  gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
  gradientFill2.addColorStop(0, "rgba(255, 164, 32, 1)");
  gradientFill2.addColorStop(1, "rgba(249, 99, 59, 0.30)");

  myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        <?php
          $totalHari = count($array_tgl);
          $tanggal = "'".bln($tanggalAwal)."'";
          foreach($array_tgl as $tgl){
            $tanggal .= ", ".date('d', strtotime($tgl));
          }
          echo $tanggal
          ?>
      ],
      datasets: [

        {
          label: "IDR OT",
          borderColor: '#00C9D6',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#00C9D6',
          borderWidth: 0,
          data: [
            <?php
            $cost_bulanan = otcost($link, $cnt, $tanggalAkhir, $car40, '0', $dataidr1, $idr);
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(otcost($link, $cnt, $tgl, $car40, '0', $dataidr1, $idr));
            }
            echo $data;
            ?>
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

        display: false
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
            max: 4000
          },
          gridLines: {
            zeroLineColor: "transparent",
            display: true,
            drawBorder: false,
            color: '#9f9f9f',
          }

        }],
        xAxes: [{
          stacked: true,
          barPercentage: 0.4,
          barThickness: 15,  // number (pixels) or 'flex'
          maxBarThickness: 20, // number (pixels)
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
// CHARTS
  chartColor = "#FFFFFF";
  
  ctx = document.getElementById('salaryd40').getContext("2d");

  gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
  gradientStroke.addColorStop(0, '#80b6f4');
  gradientStroke.addColorStop(1, chartColor);

  gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
  gradientFill.addColorStop(0, "rgba(32, 204, 255, 1)");
  gradientFill.addColorStop(1, "rgba(112, 223, 255, 0.2)");

  gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
  gradientFill2.addColorStop(0, "rgba(255, 164, 32, 1)");
  gradientFill2.addColorStop(1, "rgba(249, 99, 59, 0.30)");

  myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        <?php
          $totalHari = count($array_tgl);
          $tanggal = "'".bln($tanggalAwal)."'";
          foreach($array_tgl as $tgl){
            $tanggal .= ", ".date('d', strtotime($tgl));
          }
          echo $tanggal
          ?>
      ],
      datasets: [

        {
          label: "SALARY DIRECT D40D",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill2,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = salaryRateDirectDailySpc($cnts, $dept, $car40, $sp40, $tanggalAwal, $tanggalAkhir, $db_mos, $db_bais)/1000;
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(salaryRateDirectDailySpc($cnts, $dept, $car40, $sp40, $tanggalAwal, $tgl, $db_mos, $db_bais)/1000);
            }
            echo $data;
            ?>
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

        display: false
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
            max: 4000
          },
          gridLines: {
            zeroLineColor: "transparent",
            display: true,
            drawBorder: false,
            color: '#9f9f9f',
          }

        }],
        xAxes: [{
          stacked: true,
          barPercentage: 0.4,
          barThickness: 15,  // number (pixels) or 'flex'
          maxBarThickness: 20, // number (pixels)
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
// CHARTS
  chartColor = "#FFFFFF";
  
  ctx = document.getElementById('salaryIDR').getContext("2d");

  gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
  gradientStroke.addColorStop(0, '#80b6f4');
  gradientStroke.addColorStop(1, chartColor);

  gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
  gradientFill.addColorStop(0, "rgba(32, 204, 255, 1)");
  gradientFill.addColorStop(1, "rgba(112, 223, 255, 0.2)");

  gradientFill2 = ctx.createLinearGradient(0, 50, 0, 200);
  gradientFill2.addColorStop(0, "rgba(255, 164, 32, 1)");
  gradientFill2.addColorStop(1, "rgba(249, 99, 59, 0.30)");

  myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        <?php
          $totalHari = count($array_tgl);
          $tanggal = "'".bln($tanggalAwal)."'";
          foreach($array_tgl as $tgl){
            $tanggal .= ", ".date('d', strtotime($tgl));
          }
          echo $tanggal
          ?>
      ],
      datasets: [

        {
          label: "SALARY IDR D40",
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill2,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            <?php
            
            $cost_bulanan = salaryRateIndirectDailySpc($cnts, $dept, $car40, $sp40, $tanggalAwal, $tanggalAkhir, $db_mos, $db_bais)/1000;
            $data = $cost_bulanan;
            foreach($array_tgl as $tgl){
              $data .= ', '.(salaryRateIndirectDailySpc($cnts, $dept, $car40, $sp40, $tanggalAwal, $tgl, $db_mos, $db_bais)/1000);
            }
            echo $data;
            ?>
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

        display: false
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
            max: 4000
          },
          gridLines: {
            zeroLineColor: "transparent",
            display: true,
            drawBorder: false,
            color: '#9f9f9f',
          }

        }],
        xAxes: [{
          stacked: true,
          barPercentage: 0.4,
          barThickness: 15,  // number (pixels) or 'flex'
          maxBarThickness: 20, // number (pixels)
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