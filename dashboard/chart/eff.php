
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
      
      ctx = document.getElementById('eff_dept').getContext("2d");
  
      gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
      gradientStroke.addColorStop(0, '#80b6f4');
      gradientStroke.addColorStop(1, chartColor);
  
      gradientFill = ctx.createLinearGradient(0, 75, 0, 300);
      gradientFill.addColorStop(0, "rgba(255, 27, 27, 0.1)");
      gradientFill.addColorStop(1, "rgba(255, 27, 27, 0.0)");

      gradientFill2 = ctx.createLinearGradient(0, 20, 0, 150);
      gradientFill2.addColorStop(0, "rgba(254, 133, 248, 1)");
      gradientFill2.addColorStop(1, "rgba(254, 133, 248, 0.1)");

      gradientFill3 = ctx.createLinearGradient(0, 20, 0, 150);
      gradientFill3.addColorStop(0, "rgba(255, 146, 95, 1)");
      gradientFill3.addColorStop(1, "rgba(255, 146, 95, 0.1)");

      gradientFill4 = ctx.createLinearGradient(0, 20, 0, 150);
      gradientFill4.addColorStop(0, "rgba(158, 95, 255, 1)");
      gradientFill4.addColorStop(1, "rgba(158, 95, 255, 0.1)");


  
      myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [
        <?php
          $totalHari = count($array_tgl);
          $tanggal = "'(eff%)' ,"."'".bln($tanggalAwal)."'";
          foreach($array_tgl as $tgl){
            $tanggal .= ", ".date('d', strtotime($tgl));
          }
          echo $tanggal.", \"(day)\" "
          ?>
      ],
      datasets: [

        {
          label: "Target",
          type: 'line',
          borderColor: 'rgba(255, 27, 27, 0.2)',
          fill: true,
          backgroundColor: gradientFill,
          hoverBorderColor: '#FF1B1B',
          pointRadius: 0,
          pointHoverRadius: 3,
          fill: true,
          order: 0,
          
          data: [
          <?php
            $totalHari = count($array_tgl);
            $data = '95, 95';
            foreach($array_tgl as $tgl){
              $data .= ", ".'95';
            }
            echo $data.",95";
          ?>
          ],
        },{
          label: "eff Body 1",
          type: 'bar',
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill4,
          hoverBorderColor: '#fcc468',
          order: 1,
          borderWidth: 0,
          data: [
            0,20,90,100,95,0,20,90,100,95,20,20,90,100,95,0,20,90,100,95,0,20,90,100,95,0,20,90,100,95,0,20,90,100,95
          ],
        },{
          // stacked: true,
          label: "eff Body 2",
          type: 'bar',
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill2,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            0,20,90,100,95,0,20,90,100,95,0,20,90,100,95,0,20,90,100,95,0,20,90,100,95,0,20,90,100,95,0,20,90,100,95
          ],
        },{
          // stacked: true,
          label: "eff BQC",
          type: 'bar',
          borderColor: '#fcc468',
          fill: true,
          backgroundColor: gradientFill3,
          hoverBorderColor: '#fcc468',
          borderWidth: 0,
          data: [
            0,20,90,100,95,0,20,90,100,95,0,20,90,100,95,0,20,90,100,95,0,20,90,100,95,0,20,90,100,100
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
  ctx = document.getElementById('eff').getContext("2d");

    myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
        datasets: [{
            borderColor: "#6bd098",
            backgroundColor: "#6bd098",
            pointRadius: 0,
            pointHoverRadius: 0,
            borderWidth: 3,
            data: [300, 310, 316, 322, 330, 326, 333, 345, 338, 354]
          },
          {
            borderColor: "#f17e5d",
            backgroundColor: "#f17e5d",
            pointRadius: 0,
            pointHoverRadius: 0,
            borderWidth: 3,
            data: [320, 340, 365, 360, 370, 385, 390, 384, 408, 420]
          },
          {
            borderColor: "#fcc468",
            backgroundColor: "#fcc468",
            pointRadius: 0,
            pointHoverRadius: 0,
            borderWidth: 3,
            data: [370, 394, 415, 409, 425, 445, 460, 450, 478, 484]
          }
        ]
      },
      options: {

        legend: {

          display: false
        },

        tooltips: {
          enabled: false
        },

        scales: {
          yAxes: [{

            ticks: {
              fontColor: "#9f9f9f",
              beginAtZero: false,
              maxTicksLimit: 5,
              //padding: 20
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
              zeroLineColor: "transparent",
              display: false,
            },
            ticks: {
              padding: 20,
              fontColor: "#9f9f9f"
            }
          }]
        },
      }
    });
  
  
      
  
      // var viewsChart = new Chart(e, a);
  
    
  
  
      </script>