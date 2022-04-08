<?php
require_once("../../config/config.php");
require_once("../../config/approval_system.php");
require_once("../../config/schedule_system.php");
if(isset($_SESSION['user']) && $level >=1 && $level <=8){
    
    // $_GET['return'] = '44131';
    if(isset($_POST['checked'])){
        $input_activity = array();
        for($i = 0 ; $i < $_POST['total_activity']; $i++){
            $ot_activity = trim(mysqli_real_escape_string($link,$_POST['input_ot_activity'.$i]));
            array_push($input_activity,$ot_activity);
        }
        if((array_search('', $input_activity)) != '' ){
            
            ?>
            <script>
                Swal.fire({
                    title: 'Activity Belum Diisi',
                    text: 'Pastikan Semua Form Telah Diisi',
                    timer: 2000,
                    
                    icon: 'warning',
                    showCancelButton: false,
                    showConfirmButton: false,
                    confirmButtonColor: '#00B9FF',
                    cancelButtonColor: '#B2BABB',
                    
                })
            </script>
        <?php
        }else{
            


            $work_date = trim(mysqli_real_escape_string($link, $_POST['tanggal_kerja']));
            $ot_type = trim(mysqli_real_escape_string($link,$_POST['ot_type']));
            $shift_request = trim(mysqli_real_escape_string($link,$_POST['shift_request']));
            $tanggal_mulai = trim(mysqli_real_escape_string($link,$_POST['tanggal_mulai']));
            // $waktu_mulai = trim(mysqli_real_escape_string($link,$_POST['waktu_mulai']));
            $tanggal_selesai = trim(mysqli_real_escape_string($link,$_POST['tanggal_selesai']));
            // $waktu_selesai = trim(mysqli_real_escape_string($link,$_POST['waktu_selesai']));
            // $ot_activity = trim(mysqli_real_escape_string($link,$_POST['ot_activity']));
            // $ot_code = trim(mysqli_real_escape_string($link,$_POST['ot_code']));
            $doc_code = trim(mysqli_real_escape_string($link,$_POST['doc_code']));
            $requester = $npkUser;
            $tgl_input = date('Y-m-d');
            $query = " INSERT INTO lembur (`_id`,`kode_lembur`,`requester`,`npk`,`work_date`,`in_date`,
            `out_date`,`in_lembur`,`out_lembur`,`kode_job`,`aktifitas`,`tanggal_input`) VALUES";
            
                
                for($i = 0 ; $i < $_POST['total_activity']; $i++){
                    $waktu_mulai = trim(mysqli_real_escape_string($link,$_POST['start_activity'.$i]));
                    $waktu_selesai = trim(mysqli_real_escape_string($link,$_POST['end_activity'.$i]));
                    $ot_activity = trim(mysqli_real_escape_string($link,$_POST['input_ot_activity'.$i]));
                    $ot_code = trim(mysqli_real_escape_string($link,$_POST['code_activity'.$i]));
                    for($index = 0; $index < count($_POST['checked']);$index++){
                        $npk_data = $_POST['checked'][$index];
                    
                        $query .= " ('$ot_type','$doc_code','$requester','$npk_data','$work_date','$tanggal_mulai','$tanggal_selesai',
                        '$waktu_mulai','$waktu_selesai','$ot_code','$ot_activity','$tgl_input'),";
                    }
                }
            
            
            $query = substr($query, 0, -1);
            // echo $query;
            $sql = mysqli_query($link, $query);
            // echo mysqli_error($link);

            if($sql){
                // tanggal_kerja=2022-03-10&ot_type=PO&shift_request=A&tanggal_mulai=2022-03-11&waktu_mulai=04%3A30&tanggal_selesai=2022-03-11&waktu_selesai=07%3A00&ot_code=5S&ot_activity=tes
                ?>
                <script>
                    Swal.fire({
                        title: 'Telah Dibuat',
                        text: 'Pengajuan Overtime Telah Dibuat dan Siap Diajukan',
                        timer: 2000,
                        
                        icon: 'success',
                        showCancelButton: false,
                        showConfirmButton: false,
                        confirmButtonColor: '#00B9FF',
                        cancelButtonColor: '#B2BABB',
                        
                    })
                </script>
            <?php
            
            }else{
                ?>
                <script>
                    Swal.fire({
                        title: 'Gagal Dibuat <?=mysqli_error($link)?>',
                        text: '',
                        timer: 2000,
                        
                        icon: 'success',
                        showCancelButton: false,
                        showConfirmButton: false,
                        confirmButtonColor: '#00B9FF',
                        cancelButtonColor: '#B2BABB',
                        
                    })
                </script>
                <?php
               
            }
        }
        
    }else{
        ?>
            <script>
                Swal.fire({
                    title: 'Data Karyawan Kosong',
                    text: 'Karyawan Belum Dipilih',
                    timer: 2000,
                    
                    icon: 'warning',
                    showCancelButton: false,
                    showConfirmButton: false,
                    confirmButtonColor: '#00B9FF',
                    cancelButtonColor: '#B2BABB',
                    
                })
            </script>
        <?php
    }
}