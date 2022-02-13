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
        //cek department akun
        ?>
        <div class="row" method="POST" action="wd/proses.php">
            <div class="table-responsive">
                <table class=" table table-hover text-uppercase p-0 m-0">
                    <thead >
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Shift</th>
                        <th>Kode Jam Kerja</th>
                        <th>Operational</th>
                        <th>Kode Isirahat</th>
                        <th>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input checkAll" checked type="checkbox">
                                <span class="form-check-sign"></span>
                                </label>
                            </div>
                        </th>
                    </thead>
                    <tbody>
                        <?php
                        if(count($sheetData) > 0 ){
                            for($i = 1;$i < count($sheetData);$i++){
                            ?> 
                            <tr>
                                <td>
                                    <?=$i?>
                                </td>
                                <td>
                                    <input name="date<?=$i?>" type="text" class="form-control bg-transparent border-none border-0 pl-0" value="<?=DBtoForm($sheetData[$i]['1'])?>">
                                </td>
                                <td>
                                    <select name="shift<?=$i?>" id="" class="form-control bg-transparent border-none border-0 pl-0">
                                        <?php
                                        $query = mysqli_query($link, "SELECT * FROM shift")or die(mysqli_error($link));
                                        if(mysqli_num_rows($query)>0){
                                            while($dataShift = mysqli_fetch_assoc($query)){
                                                $select = ($sheetData[$i]['2'] == $dataShift['id_shift']) ?"selected":"";
                                                ?>
                                                <option <?=$select?> value="<?=$dataShift['id_shift']?>"><?=$dataShift['shift']?></option>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <option value="">Belum Ada Data</option>
                                            <?php
                                        }
                                        ?>
                                    </select>    
                                </td>
                                <td>
                                    <select name="wh<?=$i?>" id="" class="form-control bg-transparent border-none border-0 pl-0">
                                        <?php
                                        $query = mysqli_query($link, "SELECT * FROM working_hours")or die(mysqli_error($link));
                                        if(mysqli_num_rows($query)>0){
                                            while($dataWh = mysqli_fetch_assoc($query)){
                                                $select = ($sheetData[$i]['3'] == $dataWh['id']) ?"selected":"";
                                                ?>
                                                <option <?=$select?> value="<?=$dataWh['id']?>"><?=$dataWh['id']?></option>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <option value="">Belum Ada Data</option>
                                            <?php
                                        }
                                        ?>
                                        
                                    </select>    
                                </td>
                                <td>
                                    <?php
                                    $select1 = ($sheetData[$i]['7'] == 'HOP')?"selected":"";
                                    $select2 = ($sheetData[$i]['7'] == 'DOP')?"selected":"";
                                    ?>
                                    <select name="opreationalType<?=$i?>" id="" class="form-control bg-transparent border-0 pl-0">
                                        <option <?=$select1?> value="HOP">Daily Operational</option>
                                        <option <?=$select2?> value="DOP">Holiday Operational</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="wb<?=$i?>" id="" class="form-control bg-transparent border-none border-0 pl-0">
                                        <?php
                                        $query = mysqli_query($link, "SELECT * FROM working_break_shift GROUP BY break_group_id")or die(mysqli_error($link));
                                        if(mysqli_num_rows($query)>0){
                                            while($dataWb = mysqli_fetch_assoc($query)){
                                                $select = ($sheetData[$i]['7'] == $dataWb['id']) ?"selected":"";
                                                ?>
                                                <option <?=$select?> value="<?=$dataWb['break_group_id']?>"><?=$dataWb['break_group_id']?></option>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <option value="">Belum Ada Data</option>
                                            <?php
                                        }
                                        ?>
                                        
                                    </select>  
                                </td>
                                <td class="">
                                    <div class="form-check ">
                                        <label class="form-check-label">
                                            <input class="form-check-input checkOne m-0 pl-0" name="index[]" type="checkbox" value="<?=$i?>" checked>
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                        }
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        
       
    }else{
        // $_SESSION['info'] = "Kosong";
        // header("Location: ../manpower.php");
        ?>
        <h6 class="text-danger text-center">File Belum Dipilih / File Salah (Pastikan File Anda Adalah Format Excell Standar)</h6>
        <?php
    
    }
    
?>

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
