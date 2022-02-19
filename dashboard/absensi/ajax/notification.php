<?php

//////////////////////////////////////////////////////////////////////
include("../../../config/config.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >=1 && $level <=8){
        require_once("../../../config/approval_system.php");
        if(isset($_GET['npk']) && $_GET['npk'] != '' && $_GET['mulai'] != ''){
            $npk = (isset($_GET['npk']))?$_GET['npk']:'';
            $mulai = (isset($_GET['mulai']))?$_GET['mulai']:'';
            $total = (isset($_GET['total']))?$_GET['total']:'';
            $code = (isset($_GET['code']))?$_GET['code']:'';
            // echo $mulai;
            $tanggal_array = json_decode(loopHari($mulai, $total));
            $array_data = array();
            $array_data_absensi = array();
            $index = 0;
            foreach($tanggal_array AS $date){
                // echo $date;
                $cek_req = mysqli_query($link, "SELECT `id`,
                req_absensi.npk,
                req_absensi.shift,
                req_absensi.date,
                req_absensi.date_in,
                req_absensi.date_out,
                req_absensi.check_in,
                req_absensi.check_out,
                req_absensi.keterangan ,
                req_absensi.requester,
                req_absensi.status,
                req_absensi.req_status,
                req_absensi.req_date,
                req_absensi.note,
                req_absensi.shift_req,
                req_absensi.id_absensi ,
                attendance_code.kode AS `kode`,
                attendance_code.kode AS `ket_kode`,
                attendance_code.type AS `type`
                FROM req_absensi JOIN attendance_code ON req_absensi.keterangan = attendance_code.kode WHERE npk = '$npk' AND `date` = '$date' AND  shift_req <> 1 ")or die(mysqli_error($link));
                $data_req = mysqli_fetch_assoc($cek_req);
                $data_npk = $data_req['npk'];
                $data_tgl = $data_req['date'];
                $data_ket = $data_req['keterangan'];
                $data_ket_kode = $data_req['ket_kode'];
                $data_in = $data_req['check_in'];
                $data_out = $data_req['check_out'];
                $type = $data_req['type'];
                $data = array('npk' => $data_npk , 
                    'tgl' => "$data_tgl" , 
                    'ket' => $data_ket , 
                    'ket_kode' => $data_ket_kode , 
                    'check_in' =>  $data_in , 
                    'check_out' => $data_out,
                    'type' => $type);
                // echo $data_tgl;
                if(mysqli_num_rows($cek_req) > 0){
                    array_push($array_data, $data);
                }
                // cek absensi
                $cek_absensi = mysqli_query($link, "SELECT absensi.id,
                absensi.npk,
                absensi.shift,
                absensi.date,
                absensi.date_in,
                absensi.date_out,
                absensi.check_in,
                absensi.check_out,
                absensi.ket,
                absensi.shift,
                
                attendance_code.kode AS `kode`,
                attendance_code.kode AS `ket_kode`,
                attendance_code.type AS `type`
                FROM absensi LEFT JOIN attendance_code ON absensi.ket = attendance_code.kode WHERE absensi.npk = '$npk' AND absensi.date = '$date'")or die(mysqli_error($link));
                // data absensi
                $data_absensi = mysqli_fetch_assoc($cek_absensi);
                $data_npk_absensi = $data_absensi['npk'];
                $data_shift_absensi = $data_absensi['shift'];
                $data_date_absensi = $data_absensi['date'];
                $data_ket_absensi = $data_absensi['ket'];
                $data_in_absensi = $data_absensi['check_in'];
                $data_out_absensi = $data_absensi['check_out'];
                $data_type_absensi = $data_absensi['type'];
                // echo $data_npk_absensi;
                $data_absensi = array('npk' => $data_npk_absensi , 
                    'tgl' => "$data_date_absensi" , 
                    'shift' => $data_shift_absensi , 
                    'ket' => $data_ket_absensi , 
                    'ket_kode' => $data_ket_absensi , 
                    'check_in' =>  $data_in_absensi , 
                    'check_out' => $data_out_absensi,
                    'type' => $data_type_absensi);
                // echo $data_tgl;
                if(mysqli_num_rows($cek_absensi) > 0){
                    array_push($array_data_absensi, $data_absensi);
                }

            }
            // echo count($array_data);
            // var_dump($array_data);
            if(count($array_data) > 0 ){
                ?>
                <div id="notification_result" data-id="0" class="alert alert-warning alert-with-icon alert-dismissible fade show" data-notify="container">
                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <span data-notify="icon" class="nc-icon nc-bell-55"></span>
                    <span data-notify="message">
                        Pengajuan sudah pernah dibuat
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-striped" >
                            <table class="table-sm" width="100%">
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($array_data AS $data => $val){
                                        ?>
                                        <tr>
                                            <td>Pengajuan ke - <?=$no++?></td>
                                            <td><?=tgl($val['tgl'])?></td>
                                            <td><?=jam($val['check_in'])?></td>
                                            <td><?=jam($val['check_out'])?></td>
                                            <td><?=$val['type']?></td>
                                            <td><?=$val['ket_kode']?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                        
                            
                    </div>
                </div>
                <hr>

                <?php
            }else{
                ?>
                <div id="notification_result" data-id="1" class="alert alert-info alert-with-icon alert-dismissible fade show" data-notify="container">
                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <span data-notify="icon" class="nc-icon nc-bell-55"></span>
                    <span data-notify="message">
                        Pengajuan belum pernah dibuat
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-striped" >
                            <table class="table-sm" width="100%">
                                <tbody>
                                <?php
                                $no = 1;
                                // echo count($array_data_absensi);
                                    foreach($array_data_absensi AS $data => $val){
                                        ?>
                                        <tr>
                                            <td><?=tgl($val['tgl'])?></td>
                                            <td><?=jam($val['check_in'])?></td>
                                            <td><?=jam($val['check_out'])?></td>
                                            <td><?=$val['type']?></td>
                                            <td><?=$val['ket_kode']?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                        
                            
                    </div>
                </div>
                <hr>
                <?php
            }
        }
        ?>
        

        <?php
    }else{
        include_once ("../../no_access.php");
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>