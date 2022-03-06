<?php
// include("../../config/config.php"); 
$show = (isset($_POST['cari']))? "collapse show" : "collapse show";
// echo $level;
?>
<div class="row">
    <div class="col-md-12">
    <?php
    include_once('modal.php');
    ?>
    </div>
</div>


<div class="<?=$show?> " id="absensi">
    <?php
        include_once('hr_absensi.php');
    ?>
</div>

<div class="row">
    <div class="col-md-12" id="dataijin">
        <div class="card " >
            <div class="card-header ">
            <form action="" method="POST">
                <div class="pull-left ">
                    <h4 class="card-title " >Progress Pengajuan Absensi</h4>
                    <p class="card-category ">Periode : <?=tgl($tanggalAwal)." s.d. ".tgl($tanggalAkhir)?></p>
                </div>
                <div class="pull-right">
                    <button class="btn btn-success requestall" type="button" >
                            <i class="nc-icon nc-send "></i> Send Request
                    </button>
                    <button class="btn btn-danger deleteall" type="button">
                        <i class="nc-icon nc-simple-remove "></i> Delete All
                    </button>
                </div>
            </form>
            </div>
            <hr>
            <div class="card-body " >
                <div class="row">
                    <div class="col">
                    <form action="" name="proses" method="POST">
                        <div class="table-responsive" >
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NPK</th>
                                        <th>Nama</th>
                                        <th>Shift</th>
                                        <th>Area</th>
                                        <th>department</th>
                                        <th>Tanggal</th>
                                        <th>Check in</th>
                                        <th>Check out</th>
                                        <th>Ket</th>
                                        <th>Progress</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
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
                                    
                                    
                                    $sql_req = mysqli_query($link, $select_join)or die(mysqli_error($link));
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
                                                //draft sistem
                                                case '0a' :
                                                    $info = "draft";
                                                    $disp = "d-none";
                                                    break;

                                                //pengajuan pending belum diapproval
                                                case '25a' :
                                                    $info = "approval pending";
                                                    $disp = "d-none";
                                                    break;

                                                //sistem proses di spv
                                                case '50a' :
                                                    $info = "pengajuan disetujui";
                                                    $disp = "d-none";
                                                    break;
                                                //perlu dikonfirmasi
                                                case '50b' :
                                                    $info = "pengajuan ditolak";
                                                    $disp = "d-none";
                                                    break;
                                                case '50c' :
                                                    $info = "kurang lengkap";
                                                    $disp = "d-none";
                                                    break;

                                                //pengajuan diproses admin
                                                case '75a' :
                                                    $info = "diproses admin";
                                                    $disp = "d-none";
                                                    break;
                                                //sistem proses di admin
                                                case '75b' :
                                                    $info = "dikembalikan admin";
                                                    $disp = "d-none";
                                                    break;
                                                //sistem proses di admin
                                                case '75c' :
                                                    $info = "cuti habis";
                                                    $disp = "d-none";
                                                    break;

                                                //pengjuan sukses dan sudah berubah di personal site
                                                case '100a' :
                                                    $info = "sukses";
                                                    $disp = "d-none";
                                                    break;
                                                case '100b' :
                                                    $info = "diarsipkan";
                                                    $disp = "d-none";
                                                    break;
                                            }
                                            
                                        ?>
                                        <tr id="<?=$data_reqAbsensi['id_absen']?>">
                                            <td><?=$no++?></td>
                                            <td><?=$data_reqAbsensi['npk_absen']?></td>
                                            <td><?=$data_reqAbsensi['nama_']?></td>
                                            <td><?=$data_reqAbsensi['shift_absen']?></td>
                                            <td><?=$data_reqAbsensi['groupfrm']?></td>
                                            <td><?=$data_reqAbsensi['deptAcc']?></td>
                                            <td><?=hari_singkat($data_reqAbsensi['tanggal']).", ".DBtoForm($data_reqAbsensi['tanggal'])?></td>
                                            <td><?=$checkIn?></td>
                                            <td><?=$checkOut?></td>
                                           
                                            <td><?=$data_reqAbsensi['keterangan']?></td>
                                            <td>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-animated progress-bar-<?=$clr?> progress-bar-striped" role="progressbar" style="width: <?=$prs?>%" aria-valuenow="<?=$prs?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            </td>
                                            <td><?=$info?></td>
                                            <td class="text-right text-nowrap">
                                            <?php
                                            if($info == 'draft'){
                                                ?>
                                                <a class="btn-round btn-outline-info btn btn-info btn-link btn-icon btn-sm view_data" data-id="form_absensi"><i class="nc-icon nc-single-copy-04 "></i></a>
                                                <a href="proses.php?req=<?=$data_reqAbsensi['id_absen']?>" class="btn-round btn-outline-success btn btn-success btn-link btn-icon btn-sm proses" data-id="form_absensi"><i class="nc-icon nc-send "></i></a>
                                                <a href="proses.php?del=<?=$data_reqAbsensi['id_absen']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove" data-id="form_absensi"><i class="fa fa-times"></i></a>
                                               <?php
                                            }else{
                                            ?>
                                                <a class="btn-round btn-outline-info btn btn-info btn-link btn-icon btn-sm view_data" data-id="form_absensi "><i class="nc-icon nc-single-copy-04 "></i></a>
                                                <a disabled href="proses.php?req=<?=$data_reqAbsensi['id_absen']?>" class="btn-round btn-outline-success btn btn-success btn-link btn-icon btn-sm proses" data-id="form_absensi"><i class="nc-icon nc-send "></i></a>
                                                <a disabled href="proses.php?del=<?=$data_reqAbsensi['id_absen']?>" 
                                                class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove" 
                                                data-id="form_absensi"><i class="fa fa-times"></i></a>
                                                </td>
                                            <?php
                                            }
                                            if($info == 'draft'){
                                                ?>
                                                <td class="sticky-col first-last-col text-right">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input  class="form-check-input mp" name="checked[]" type="checkbox" value="<?=$data_reqAbsensi['id_absen']?>">
                                                        <span class="form-check-sign"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                        
                                            <?php
                                            }else{
                                                ?>
                                                <td class="sticky-col first-last-col text-right">
                                                    <div class="form-check disabled">
                                                        <label class="form-check-label">
                                                            <input  disabled class="form-check-input"  type="checkbox" value="<?=$data_reqAbsensi['id_absen']?>">
                                                        <span class="form-check-sign"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <?php
                                            }
                                            ?>
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
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

