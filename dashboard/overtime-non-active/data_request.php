
<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 

//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Request Lembur";

if(isset($_SESSION['user'])){

    include("../header.php");

    $kode_lembur = (isset($_GET['c']))? $_GET['c'] : NULL;
    $requester = (isset($_GET['r']))? $_GET['r'] : NULL;

    $qry_requester = "SELECT nama, department, id_area FROM karyawan WHERE npk = $requester";
    $sql_requester = mysqli_query($link, $qry_requester)or die(mysqli_error($link));
    $data_requester = mysqli_fetch_assoc($sql_requester);
    $nama_requester = $data_requester['nama'];
    $area_requester = $data_requester['id_area'];
    $dept_requester = $data_requester['department'];

    //mendapatkan department
    $qry_dept = "SELECT * FROM department WHERE id_dept = '$dept_requester'";
    $dept_ = mysqli_query($link, $qry_dept)or die(mysqli_error($link));
    $data_dept = mysqli_fetch_assoc($dept_);
    $department = $data_dept['dept'];
    $dept_cord = $data_dept['npk_cord'];

    

?>

<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header ">
                <div class="pull-left">
                <h5>Data Pengajuan Lembur</h5>
                    <span class="badge badge-pill badge-danger">5 data</span>
                    <span class="card-title text-danger">Senin, 5 February 2021</span>                    
                </div>
                <div class="box border border-secondary rounded-lg pull-right">
                    <table class="text-secondary border-secondary" rules="all" cellpadding="3">
                        <tbody>
                            <tr>
                                <th scope="rows" rules="cols-right">Doc No</th> 
                                <td colspan="3">: <?=$kode_lembur?></td>
                                <td rowspan="3">QR-CODE</td>
                            </tr>
                            <tr>
                                <th scope="rows">Dept/Jalur</th> 
                                <td >: Body 2</td>
                                <td colspan="2">Under Front</td>
                            </tr>
                            <tr>
                                <th >Cost</th>
                                <td >: Rp 5.0000.0000</td>
                                <th scope="rows">MP</th>
                                <td >: 20</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
            <hr class="border-secondary border-2">
            <div class="card-body ">
                
                <div class=" box pull-left">
                    <form class="form-inline" action="" method="post">
                        <div class="input-group no-border">
                            <input type="text" name="cari" class="form-control" placeholder="cari nama / npk">
                            
                            <div class="input-group-append border-1">
                                <button type="submit" class="btn my-0 btn-danger btn-icon" aria-hidden="true"><i class="nc-icon nc-zoom-split"></i></button>
                            </div>
                            
                        </div>
                    </form>
                </div>
                <div class="box pull-right">
                    
                    <button class="btn btn-success">
                        <span class="btn-label">
                            <i class="nc-icon nc-settings-gear-65"></i>
                        </span>
                        Approve
                    </button>
                    <button class="btn btn-warning">
                        <span class="btn-label">
                            <i class="nc-icon nc-settings-gear-65"></i>
                        </span>
                        Tolak
                    </button>
                    
                    <button class="btn btn-default">
                        <span class="btn-label">
                            <i class="nc-icon nc-settings-gear-65"></i>
                        </span>
                        Kembali
                    </button>
                    
                    
                </div>
                <div class="table-responsive" style="height:200">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">NO</th> 
                                <th scope="col">Nama</th> 
                                <th scope="col">NPK</th>
                                <th scope="col">Area / Pos</th>
                                <th scope="col">Mulai</th>
                                <th scope="col">Selesai</th>
                                <th scope="col">Time Stamp</th>
                                <th scope="col">Closed Request</th>
                                <th scope="col">Progress</th>
                                <th scope="col">Status</th>
                                <th scope="col">Check</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="rows">1</td>
                                <td>Rio Setiawan Judin</td>
                                <td>44131</td>
                                <td>Digitalisasi</td>
                                <td>16:00</td>
                                <td>20:00</td>
                                <td>15-Feb-2021 19:00:00</td>
                                <td><i class="text-danger nc-icon nc-time-alarm"></i> 1 Day Left 24:00:00</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-animated progress-bar-success progress-bar-striped" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td>Sukses</td>
                                <td>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox">
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </td>   
                                                        							
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer ">
                <div class="stats">
                    <i class=""></i> Pengajuan
                </div>
            </div>
        </div>
    </div>
</div>





<?php


?>

    <?php
//footer
    include_once("../footer.php");

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }

  

?>
<script>
ctx=document.getElementById('BarChartExample').getContext("2d");
  myChart=new Chart(ctx, {
    type: 'line', data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"], datasets: [{
        label: "Active Users", borderColor: "#6bd098", pointRadius: 0, pointHoverRadius: 0, fill: false, borderWidth: 3, data: [542, 480, 430, 550, 530, 453, 380, 434, 568, 610]
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
            fontColor: "#9f9f9f", beginAtZero: false, maxTicksLimit: 5
          },
          gridLines: {
            drawBorder: false, zeroLineColor: "transparent", color: 'rgba(255,255,255,0.05)'
          }
        }],
        xAxes: [{
          barPercentage: 1.6, gridLines: {
              display: false
          },
          ticks: {
            padding: 20, fontColor: "#9f9f9f"
          }
        }]
      }
    }
  }
);
</script>