<?php
?>

<script>

ctx = document.getElementById('jobcost').getContext("2d");

    myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: [1, 2, 3],
        datasets: [{
          label: "Contribute",
          pointRadius: 0,
          pointHoverRadius: 0,
          backgroundColor: [
            '#e3e3e3',
            '#4acccd',
            '#4EB7F3',
            '#6AF99B',
            '#00A6D3',
            '#4EB7F3',
            '#6AF99B',
            '#FA651B',
            '#DC78FF'
          ],
          borderWidth: 0,
          data: [542, 480, 430, 600, 480, 200, 542, 100, 50]
        }]
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
</script>


<script>

ctx = document.getElementById('mhComposition').getContext("2d");

    myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: [1, 2, 3],
        datasets: [{
          label: "Contribute",
          pointRadius: 0,
          pointHoverRadius: 0,
          backgroundColor: [
            '#e3e3e3',
            '#4acccd',
            '#4EB7F3',
            '#6AF99B',
            '#00A6D3',
            '#4EB7F3',
            '#6AF99B',
            '#FA651B',
            '#DC78FF'
          ],
          borderWidth: 0,
          data: [542, 480, 430, 600, 480, 200, 542, 100, 50]
        }]
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
</script>
