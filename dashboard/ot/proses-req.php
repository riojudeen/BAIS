<?php
require_once("../../config/config.php");
require_once("../../config/approval_system.php");
require_once("../../config/schedule_system.php");
if(isset($_SESSION['user']) && $level >=1 && $level <=8){
    
    if(isset($_POST['request'])){
        if(isset($_GET['del_req'])){
            foreach($_POST['request'] AS $data){
                list($id , $npk, $work_date) = pecahID($data);
                mysqli_query($link, "DELETE FROM lembur WHERE _id = '$id' AND npk = '$npk' AND work_date = '$work_date' ")or die(mysqli_error($link));
            }
            ?>
            <script>
                Swal.fire({
                    title: 'Dihapus',
                    text: 'Draft Pengajuan Telah Dihapus',
                    timer: 2000,
                    
                    icon: 'success',
                    showCancelButton: false,
                    showConfirmButton: false,
                    confirmButtonColor: '#00B9FF',
                    cancelButtonColor: '#B2BABB',
                    
                })
            </script>
            <?php
        }else if(isset($_GET['ot_req'])){
            foreach($_POST['request'] AS $data){
                list($id , $npk, $work_date) = pecahID($data);
                mysqli_query($link, "UPDATE lembur SET `status` = 'a' , status_approve = '25' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$work_date' ")or die(mysqli_error($link));
            }
            ?>
            <script>
                Swal.fire({
                    title: 'Diajukan',
                    text: 'Draft Pengajuan Telah Diajukan',
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
        ?>
    <?php
    }else{
        
        ?>
        <script>
            Swal.fire({
                title: 'Data Kosong',
                text: 'Pilih Data Pengajuan Yang ingin Diproses',
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