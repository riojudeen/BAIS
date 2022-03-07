<style>

    .view {
    margin: auto;
    width: 600px;
    }
    tr:hover td
    { background: #F4F4F4;
    }
    .wrapper {
    position: relative;
    overflow: auto;
    border: 1px solid black;
    white-space: nowrap;
    }

    .sticky-col {
    position: -webkit-sticky;
    position: sticky;
    background-color: white;
    }

    .first-col {
    width: 100px;
    min-width: 50px;
    max-width: 100px;
    left: 0px;
    
    }

    .first-top-col {
    width: 50px;
    min-width: 50px;
    max-width: 150px;
    top: 0px;
    z-index: 600;
    }

    .second-col {
    width: 50px;
    min-width: 50px;
    max-width: 150px;
    left: 50px;
    }
    .second-top-col {
    width: 20px;
    min-width: 20px;
    max-width: 150px;
    top: 0px;
    z-index: 600;
    }

    .third-col {
    width: 70px;
    min-width: 70px;
    max-width: 300px;
    left: 100px;
    }
    .third-top-col {
    width: 70px;
    min-width: 70px;
    max-width: 300px;
    top: 0px;
    z-index: 600;
    }
    .fourth-col {
    width: 300px;
    min-width: 300px;
    max-width: 300px;
    left: 170px;
    }
    .fourth-top-col {
    width: 300px;
    min-width: 300px;
    max-width: 300px;
    top: 0px;
    z-index: 600;
    }

    .first-last-col {
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    right: 0px;
    }
    .first-last-top-col {
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    top: 0px;
    z-index: 600;
    }

    .second-last-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    right: 50px;
    }
    .second-last-top-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    top: 0px;
    z-index: 600;
    }
    th {
    background: white;
    position: sticky;
    top: 0;
    z-index: 500;
    }

</style>
<?php

require_once("../../../../config/config.php");
require_once("../../../../config/error.php");
require "../../../../_assets/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    if(isset($_FILES['file-excel']['name']) && in_array($_FILES['file-excel']['type'], $file_mimes)) {
    
        $arr_file = explode('.', $_FILES['file-excel']['name']);
        $extension = end($arr_file);
    
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $reader->load($_FILES['file-excel']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        $total_update = (isset($_GET['total_update']) && $_GET['total_update'] == 1)?1:0;
        

        $role_user = ($_GET['role'] != '')?$_GET['role']:'';
        //cek department akun
        // $role_user = $_GET['role'];
        // $q_user = mysqli_query($link, "SELECT * FROM user_role WHERE id_role = '$_GET[role]'")or die(mysqli_error($link));
        // $leverl_user = mysqli_fetch_assoc($q_user);
        
        // echo count($sheetData);
        ?>
        <input type="text" name="total_update" value="<?=$total_update?>">
        <div class="table-responsive text-left ">
            <table class="table table-hover text-uppercase">
                <thead class="table-info">
                    <th class="text-left first-top-col first-col sticky-col ">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input checkAll" checked type="checkbox">
                            <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </th>
                    <th class="text-nowrap sticky-col second-col second-top-col">#</th>
                    <th class="text-nowrap sticky-col third-col third-top-col">Npk</th>
                    <th class="text-nowrap sticky-col fourth-col fourth-top-col">Nama</th>
                    <th class="text-nowrap">Tanggal Masuk</th>
                    <th class="text-nowrap">Jabatan</th>
                    <th class="text-nowrap">Status</th>
                    <th class="text-nowrap">Shift</th>
                    
                </thead>
            <tbody>
        <?php
        $no = 1;
        echo $_GET['dok'];
        for($i = 2;$i < count($sheetData);$i++){
            if((isset($_GET['dok'])) && $_GET['dok'] == ''){
                $shift = ($_GET['groupshift'])?$_GET['groupshift']:'';
                $jab = ($_GET['jab'] != '')?$_GET['jab']:'';
                $stats = ($_GET['stats'] != '' )?$_GET['stats']:'';
                
            }else{
                $stats = $sheetData[$i]['4'];
                $jab = $sheetData[$i]['3'];
                $shift = $sheetData[$i]['5'];
            }

            $npk = $sheetData[$i]['1'];
            $nama = $sheetData[$i]['2'];
            
            $tglMasuk = $sheetData[$i]['6'];

            
            if(isset($_GET['dpass']) && $_GET['dpass'] == ''){
                $pass = $_GET['pass'];
            }else{
                $pass = default_password($tglMasuk);
            }
            $username = default_username($npk);
            $q_jab = mysqli_query($link, "SELECT jabatan FROM jabatan WHERE id_jabatan = '$jab'")or die(mysqli_error($link));
            $sql_jab = mysqli_fetch_assoc($q_jab);
            $jabatan = $sql_jab['jabatan'];
            $q_status = mysqli_query($link, "SELECT status_mp FROM status_mp WHERE id = '$stats'")or die(mysqli_error($link));
            $sql_stats = mysqli_fetch_assoc($q_status);
            $status = $sql_stats['status_mp'];
            // echo $no++." - ";
            // echo $nama." - ";
            // echo $npk." - ";
            // echo $stats." - ";
            // echo $jab." - ";
            // echo $tglMasuk." <br> ";
            ?>
           <tr class="">
                <td class="sticky-col first-col">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input checkOne" type="checkbox" name="index[]" checked value="<?=$no?>">
                            <span class="form-check-sign"></span>
                        </label>
                    </div>
                </td>
                <td class="text-nowrap sticky-col second-col">
                    <?=$no?>
                </td>
                <td class="text-nowrap sticky-col third-col col-md-3">
                <?=$npk?>
                    
                    <input type="hidden" name="npk-<?=$no?>" value="<?=$npk?>">
                    <input type="hidden" name="name-<?=$no?>" value="<?=$nama?>">
                    <input type="hidden" name="tgl_masuk-<?=$no?>" value="<?=$tglMasuk?>">
                    <input type="hidden" name="jabatan-<?=$no?>" value="<?=$jab?>">
                    <input type="hidden" name="status-<?=$no?>" value="<?=$stats?>">
                    <input type="hidden" name="shift-<?=$no?>" value="<?=$shift?>">
                    <input type="hidden" name="role-<?=$no?>" value="<?=$role_user?>">
                    <input type="hidden" name="pass-<?=$no?>" value="<?=$pass?>">
                    <input type="hidden" name="username-<?=$no?>" value="<?=$username?>">
                    
                </td>
                <td class="text-nowrap sticky-col fourth-col"><?=$nama?></td>
                <td class="text-nowrap"><?=tgl($tglMasuk)?></td>
                <td class="text-nowrap"><?=$jabatan?></td>
                <td class="text-nowrap"><?=$status?></td>
                <td class="text-nowrap"><?=$shift?></td>
                
            </tr>
            <?php
            $no++;
            
        }
        
       
    }else{
        // $_SESSION['info'] = "Kosong";
        // header("Location: ../manpower.php");
        ?>
        <h6 class="text-danger text-center">File Belum Dipilih / File Salah (Pastikan File Anda Adalah Format Excell Standar)</h6>
        <?php

    }
    
?>

    </tbody>
</table>
<script>
    $(document).ready(function(){
        $('#allmp').on('click', function() {
            if(this.checked){
                $('.mp').each(function() {
                    this.checked = true;
                })
            } else {
                $('.mp').each(function() {
                    this.checked = false;
                })
            }
        });
        $('.mp').on('click', function() {
            if($('.mp:checked').length == $('.mp').length){
                $('#allmp').prop('checked', true)
            } else {
                $('#allmp').prop('checked', false)
            }
        })
        $('.mata1').mousedown(function(){
            $('.mata2').removeClass('d-none')
            $('.mata1').addClass('d-none')
            $('.passw').removeAttr('type')
            $('.passw').attr('type','text')
        })
        $('.mata2').mouseup(function(){
            $('.mata1').removeClass('d-none')
            $('.mata2').addClass('d-none')
            $('.passw').removeAttr('type')
            $('.passw').attr('type','password')
        })
    })
</script>
<script>
$(document).ready(function(){
    $('.checkAll').on('click', function(){
        if(this.checked){
            $('.checkOne').each(function() {
                this.checked = true;
            })
        } else {
            $('.checkOne').each(function() {
                this.checked = false;
            })
        }
    });
    $('.checkOne').on('click', function() {
        if($('.checkOne:checked').length == $('.checkOne').length){
            $('.checkAll').prop('checked', true)
        } else {
            $('.checkAll').prop('checked', false)
        }
    })
})
</script>
