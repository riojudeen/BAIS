<?php

//////////////////////////////////////////////////////////////////////
include("../../../config/config.php");
include("../../../config/schedule_system.php");
if(isset($_SESSION['user'])){
    if($level >=1 && $level <=8){
        require_once("../../../config/approval_system.php");
        // cek data karyawan 
        
        $npk = $_GET['npk'];
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
        $origin_query = "SELECT 
            view_organization.npk,
            view_organization.nama,
            view_organization.tgl_masuk,
            view_organization.jabatan,
            view_organization.shift,
            view_organization.pos,
            view_organization.status,
            view_organization.pos,
            view_organization.groupfrm,
            view_organization.section,
            view_organization.dept,
            view_organization.subpos,
            view_organization.division,
            view_organization.dept_account
            
            FROM view_organization ";
        $access_org = orgAccessOrg($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npkUser, $data_access);
        // echo $npk;
        
        $queryMP = filtergenerator($link, $level, $generate, $origin_query, $access_org);
        // echo $generate;
        $sqlMP = mysqli_query($link, $queryMP." AND npk = '$npk' " )or die(mysqli_error($link));
        $jmlMP = mysqli_num_rows($sqlMP);
        // echo $jmlMP;
        
        if(isset($_GET['npk']) && $_GET['npk'] != '' && $_GET['mulai'] != ''){
            
            if($jmlMP> 0 ){
                /*
                pemberitahuan akan muncul untuk menjadi data trigger apakah pengajuan 
                bisa proses atau tidak berdasarkan 
                ketersediaan data karyawan , input data request dan 
                progress pengajuan data sebelumnya

                untuk data SUPEM cuti panjang dan cuti tahunan , 
                pengajuan baru bisa diproses jika data proses admin sudah selesai 
                atau HRD sudah approve

                Jika pengajuan masih dalam progress proses admin, pengajuan tidak dapat 
                diproses
                */
                $type_absensi = mysqli_query($link, "SELECT `type` FROM attendance_code WHERE kode = '$_GET[code]' ")or die(mysqli_error($link));
                $type_abs = mysqli_fetch_assoc($type_absensi);
                $data_type = $type_abs['type'];
                if($_GET['code'] != ''){
                
                    $npk = (isset($_GET['npk']))?$_GET['npk']:'';
                    $mulai = (isset($_GET['mulai']))?$_GET['mulai']:'';
                    $total = (isset($_GET['total']))?$_GET['total']:'';
                    $code = (isset($_GET['code']))?$_GET['code']:''; //attendance_code
    
                    // echo $npk;
                    $tanggal_array = json_decode(loopHari($mulai, $total));
                    $array_data = array();
                    $array_data_absensi = array();
                    $array_data_cuti = array();
                    $index = 0;
                    
                    //pengecheckan data absensi request 
                    if($code == 'C1' || $code == 'C2'){
                        $qry_cek_request = "SELECT 
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
                                attendance_code.type AS `type`,
                                CONCAT(req_absensi.status,req_absensi.req_status) AS progress
                        FROM req_absensi JOIN attendance_code ON req_absensi.keterangan = attendance_code.kode 
                        WHERE req_absensi.npk = '$npk' AND  req_absensi.shift_req <> 1 
                        AND CONCAT(req_absensi.status,req_absensi.req_status) = '75a' AND req_absensi.keterangan = '$code' ";
                        $cek_req_cuti = mysqli_query($link, $qry_cek_request)or die(mysqli_error($link));
                        if(mysqli_num_rows($cek_req_cuti) > 0){
                            while($cek_result = mysqli_fetch_assoc($cek_req_cuti)){
                                $data_npk = $cek_result['npk'];
                                $data_tgl = $cek_result['date'];
                                $data_ket = $cek_result['keterangan'];
                                $data_ket_kode = $cek_result['ket_kode'];
                                $data_in = ($cek_result['check_in'] == '00:00:00' || $cek_result['check_in'] == '' )?"-":jam($cek_result['check_in']);
                                $data_out = ($cek_result['check_out'] == '00:00:00' || $cek_result['check_out'] == '' )?"-":jam($cek_result['check_out']);
                                $type = $cek_result['type'];
                                $prog = $cek_result['progress'];
        
                                
                                $data_cuti = array('npk' => $data_npk , 
                                    'tgl' => "$data_tgl" , 
                                    'ket' => $data_ket , 
                                    'ket_kode' => $data_ket_kode , 
                                    'check_in' =>  $data_in , 
                                    'check_out' => $data_out,
                                    'type' => $type,
                                    'progress' => $prog);
        
                                array_push($array_data_cuti, $data_cuti);
                            }
                            
                        }
                    }
                    
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
                        req_absensi.keterangan AS `keterangan` ,
                        req_absensi.requester,
                        req_absensi.status,
                        req_absensi.req_status,
                        req_absensi.req_date,
                        req_absensi.note,
                        req_absensi.shift_req,
                        req_absensi.id_absensi ,
                        attendance_code.kode AS `kode`,
                        attendance_code.keterangan AS `ket_kode`,
                        attendance_code.type AS `type`
                        FROM req_absensi JOIN attendance_code ON req_absensi.keterangan = attendance_code.kode WHERE npk = '$npk' AND `date` = '$date' AND  shift_req <> 1 AND attendance_code.type = '$data_type' ")or die(mysqli_error($link));
                        if(mysqli_num_rows($cek_req) > 0){
                            $data_req = mysqli_fetch_assoc($cek_req);
                            $data_npk = $data_req['npk'];
                            $data_tgl = $data_req['date'];
                            $data_ket = $data_req['keterangan'];
                            $data_ket_kode = $data_req['ket_kode'];
                            $data_in = ($data_req['check_in'] == '00:00:00' || $data_req['check_in'] == '' )?"-":jam($data_req['check_in']);
                                $data_out = ($data_req['check_out'] == '00:00:00' || $data_req['check_out'] == '' )?"-":jam($data_req['check_out']);
                            $type = $data_req['type'];
                            
                            $data = array('npk' => $data_npk , 
                                'tgl' => "$data_tgl" , 
                                'ket' => $data_ket , 
                                'ket_kode' => $data_ket_kode , 
                                'check_in' =>  $data_in , 
                                'check_out' => $data_out,
                                'type' => $type);
                            // echo $data_tgl;
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
                        $data_in_absensi = ($data_absensi['check_in'] == '00:00:00' || $data_absensi['check_in'] == '' )?"-":jam($data_absensi['check_in']);
                                $data_out_absensi = ($data_absensi['check_out'] == '00:00:00' || $data_absensi['check_out'] == '' )?"-":jam($data_absensi['check_out']);
                        
                        $data_type_absensi = $data_absensi['type'];
                        // echo $data_npk_absensi;
                        if(mysqli_num_rows($cek_absensi) > 0){
                           
                            $data_absensi = array('npk' => $data_npk_absensi , 
                                'tgl' => "$data_date_absensi" , 
                                'shift' => $data_shift_absensi , 
                                'ket' => $data_ket_absensi , 
                                'ket_kode' => $data_ket_absensi , 
                                'check_in' =>  $data_in_absensi , 
                                'check_out' => $data_out_absensi,
                                'type' => $data_type_absensi);
                                array_push($array_data_absensi, $data_absensi);
                            // echo $data_tgl;
                        }
    
                    }
                    // echo count($array_data);
                    // var_dump($array_data);
                    if(count($array_data) > 0 ||  count($array_data_cuti)>0){
                        if(count($array_data_cuti)>0){
                            ?>
    
                            <div id="notification_result" data-id="0" class="text-uppercase alert alert-primary alert-with-icon alert-dismissible fade show" data-notify="container">
                                
                                <span data-notify="icon" class="nc-icon nc-bell-55"></span>
                                <span data-notify="message">
                                    Pengajuan Cuti Masih Dalam Proses Di HRD 
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-striped" >
                                        <table class="table-sm" width="100%">
                                            <tbody>
                                                <thead class="table-primary text-uppercase">
                                                    <tr>
                                                        
                                                        <th colspan="2">Tanggal</th>
                                                        <th>IN</th>
                                                        <th>OUT</th>
                                                        <th colspan="2">Jenis Pengajuan</th>
                                                        <th colspan="1">Progress</th>
                                                    </tr>
                                                </thead>
                                            <?php
                                            $no = 1;
                                                foreach($array_data_cuti AS $data => $val){
                                                    ?>
                                                    <tr>
                                                        <td>Pengajuan ke - <?=$no++?></td>
                                                        <td><?=tgl($val['tgl'])?></td>
                                                        <td><?=$val['check_in']?></td>
                                                        <td><?=$val['check_out']?></td>
                                                        <td><?=$val['type']?></td>
                                                        <td><?=$val['ket_kode']?></td>
                                                        <td><?=authText($val['progress'])?></td>
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
                            // print_r($array_data);
                            ?>
                            <div id="notification_result" data-id="0" class="text-uppercase alert alert-warning alert-with-icon alert-dismissible fade show" data-notify="container">
                                
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
                                                <thead class="table-warning text-uppercase">
                                                    <tr>
                                                    <th colspan="2">Tanggal</th>
                                                        <th>IN</th>
                                                        <th>OUT</th>
                                                        <th colspan="2">Jenis Pengajuan</th>
                                                    </tr>
                                                </thead>
                                            <?php
                                            $no = 1;
                                                foreach($array_data AS $data => $val){
                                                    ?>
                                                    <tr>
                                                        <td>Pengajuan ke - <?=$no++?></td>
                                                        <td><?=tgl($val['tgl'])?></td>
                                                        <td><?=$val['check_in']?></td>
                                                        <td><?=$val['check_out']?></td>
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
                    }else{
                        ?>
                        <div id="notification_result" data-id="1" class="text-uppercase  alert alert-info alert-with-icon alert-dismissible fade show" data-notify="container">
                                
                                <span data-notify="icon" class="nc-icon nc-bell-55"></span>
                                <span data-notify="message">
                                    Pengajuan belum pernah dibuat. klik proses untuk melanjutkan
                                </span>
                            </div>
                        </div>
                        <?php
                        $tgl_mulai = $mulai;
                        $add_day = $total-1;
                        $tgl_selesai = date('Y-m-d', strtotime("$add_day days", strtotime($tgl_mulai)));;
                        $qry_alocation = "SELECT leave_alocation.alocation AS 'aloc', attendance_code.addition AS 'add' FROM
                            attendance_code JOIN leave_alocation ON attendance_code.kode = leave_alocation.id_leave WHERE leave_alocation.effective_date <= '$tgl_mulai' AND leave_alocation.end >= '$tgl_selesai' AND attendance_code.kode = '$_GET[code]'";
                        $sql_alocation = mysqli_query($link, $qry_alocation)or die(mysqli_error($link));
                        // echo $qry_alocation;
                        // echo mysqli_num_rows($sql_alocation);
                        if(mysqli_num_rows($sql_alocation) > 0){
                            $data_eff = mysqli_fetch_assoc($sql_alocation);
                            $add = ($data_eff['add'] == '')?0:$data_eff['add'];
                            $max_day = $data_eff['aloc']+$add;
                            ?>
                            <input type="hidden" id="aloc_day" value="<?=$max_day?>">
                            
                            <?php
                        }

                        ?>
                        
                        <?php
                    }
                }
            }else{
                ?>
                <div id="notification_result" data-id="0" class="text-uppercase  alert alert-danger alert-with-icon alert-dismissible fade show" data-notify="container">
                        
                    <span data-notify="icon" class="nc-icon nc-bell-55"></span>
                    <span data-notify="message">
                        Data Karyawan Belum Ada Atau Tidak tersedia di Area Anda
                    </span>
                </div>
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