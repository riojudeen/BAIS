<?php

//////////////////////////////////////////////////////////////////////
// include("../../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Leave Allocation Settings";
if(isset($_SESSION['user'])){
?>

<div class="row ">
    <div class="col-md-12">
        <div class="pull-left ">
            <h5 class="title">Transfer Data Cuti Personal Site</h5>
            <p class="card-category ">Periode : <?=tgl($tanggalAwal)." s.d. ".tgl($tanggalAkhir)?></p>
        </div>
        <div class="box pull-right">
            <button class="btn btn-sm btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <span class="btn-label">
                    <i class="nc-icon nc-cloud-download-93"></i>
                </span>
            Import Data
            </button>
            
            <!-- <a href="proses/export.php?export=mp" class="btn btn-success" name="export" data-toggle="tooltip" data-placement="bottom" title="Export to Excel File">
                <span class="btn-label">
                    <i class="nc-icon nc-cloud-upload-94"></i>
                </span>
                Export
            </a> -->
        </div>
        <form method="post" name="proses" action="" >
        <div class="table-responsive">
            <table class="table table-striped table_org" id="uangmakan" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NPK</th>
                        <th>Nama</th>
                        <th>Shift</th>
                        <th>Area</th>
                        <th>Tanggal</th>
                        <th>Check in</th>
                        <th>Check out</th>
                        <th>Ket</th>
                        <th scope="col" class="sticky-col first-last-col first-last-top-col text-right">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="allmp">
                                <span class="form-check-sign"></span>
                                </label>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-uppercase">
                    <?php
                    // echo $tanggalAwal."<br>";
                    // echo $tanggalAkhir."<br>";
                    
                    $clm = "org.".$org_access;
                    $sql_req = mysqli_query($link, "SELECT req_absensi.id AS id_absen,
                    req_absensi.npk AS npk_absen, 
                    req_absensi.shift AS shift_absen,
                    req_absensi.date AS tanggal,
                    req_absensi.date_in AS tanggal_masuk,
                    req_absensi.date_out AS tanggal_keluar,
                    req_absensi.check_in AS check_in,
                    req_absensi.check_out AS check_out,
                    req_absensi.keterangan AS keterangan,
                    req_absensi.requester AS requester,
                    req_absensi.status AS status_absen,
                    req_absensi.req_status AS req_status,
                    req_absensi.req_date AS req_date,

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

                    FROM req_absensi
                    JOIN karyawan ON karyawan.npk = req_absensi.npk
                    JOIN org ON org.npk = karyawan.npk
                    WHERE req_absensi.date BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND $clm = '$access_' AND req_absensi.note = 'transfer PS' ORDER BY req_absensi.status, req_absensi.date ASC")or die(mysqli_error($link));
                    $no = 1;
                    // echo mysqli_num_rows($sql_req);
                    if(mysqli_num_rows($sql_req) > 0){
                        while($data_reqAbsensi = mysqli_fetch_assoc($sql_req)){
                            $checkIn = ($data_reqAbsensi['check_in'] == '00:00:00')? "-" : $data_reqAbsensi['check_in'];
                            $checkOut = ($data_reqAbsensi['check_out'] == '00:00:00')? "-" : $data_reqAbsensi['check_out'];

                            switch($data_reqAbsensi['status_absen']){
                                case 0 :
                                    $stt = "draft";
                                    $clr = "danger";
                                    $prs = "0";
                                    break;
                                case 25 :
                                    $stt = "diajukan";
                                    $clr = "danger";
                                    $prs = "25";
                                    break;
                                case 50 :
                                    $stt = "approved";
                                    $clr = "warning";
                                    $prs = "50";
                                    break;
                                case 75 :
                                    $stt = "process";
                                    $clr = "info";
                                    $prs = "75";
                                    break;
                                case 100 :
                                    $stt = "success";
                                    $clr = "success";
                                    $prs = "100";
                                    break;
                            }
                            $stts = $data_reqAbsensi['status_absen'].$data_reqAbsensi['req_status'];
                            switch($stts){
                                case '0a' :
                                    $info = "draft";
                                    break;
                                case '0b' :
                                    $info = "ditolak";
                                    break;
                                case '25a' :
                                    $info = "pending";
                                    break;
                                case '50a' :
                                    $info = "disetujui";
                                    break;
                                case '50b' :
                                    $info = "ditolak";
                                    break;
                                case '75a' :
                                    $info = "diproses";
                                    break;
                                case '75c' :
                                    $info = "dikembalikan";
                                    break;
                                case '75b' :
                                    $info = "ditolak";
                                    break;
                                case '100a' :
                                    $info = "sukses";
                                    break;
                            }
                            
                        ?>
                        <tr>
                            <td><?=$no++?></td>
                            <td><?=$data_reqAbsensi['npk_absen']?></td>
                            <td><?=$data_reqAbsensi['nama_']?></td>
                            <td><?=$data_reqAbsensi['shift_absen']?></td>
                            <td><?=$data_reqAbsensi['dept_account']?></td>
                            <td><?=hari_singkat($data_reqAbsensi['tanggal']).", ".DBtoForm($data_reqAbsensi['tanggal'])?></td>
                            <td><?=$checkIn?></td>
                            <td><?=$checkOut?></td>
                            
                            <td><?=$data_reqAbsensi['keterangan']?></td>
                            
                            <td class="sticky-col first-last-col text-right">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input  class="form-check-input mp" name="checked[]" type="checkbox" value="<?=$data_reqAbsensi['id_absen']?>">
                                    <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </td>
                            
                        </tr>    
                            <?php
                        }
                    }else{
                        ?>
                        <tr><td colspan="13" class="text-center">Tidak ditmukan data di database</td></tr>
                        <?php
                    }
                    ?>
                    
                </tbody>
                <tfoot>

                </tfoot>
                    
            </table>
        

        <hr>
        </form>
           
    </div>
    <div class="box pull-right">
        <button class="btn btn-success editall">
            <span class="btn-label">
                <i class="nc-icon nc-check-2"></i>
            </span>
            Edit
        </button>
        <button  class="btn btn-danger  deleteall" >
            <span class="btn-label">
                <i class="nc-icon nc-simple-remove" ></i>
            </span>    
            Delete
        </button>

    </div>
</div>
<?php
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>