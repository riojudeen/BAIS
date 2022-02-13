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
        <div class="row">
            <div class="table-responsive">
                <table class=" table table-hover text-uppercase p-0 m-0">
                    <thead >
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Tipe Hari Libur</th>
                        <th>Keterangan</th>
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
                                    <input type="text" readonly class="form-control bg-transparent border-none border-0" value="<?=tgl_indo($sheetData[$i]['1'])?>">
                                    <input name="date<?=$i?>" type="hidden" class="form-control bg-transparent border-none border-0" value="<?=$sheetData[$i]['1']?>">
                                </td>
                                <td>
                                    <?php
                                    $select1 = ($sheetData[$i]['2'] == 'CB')?"selected":"";
                                    $select2 = ($sheetData[$i]['2'] == 'LN')?"selected":"";
                                    ?>
                                    <select name="holidayType<?=$i?>" id="" class="form-control bg-transparent border-0">
                                        <option <?=$select1?> value="CB">CUTI BERSAMA</option>
                                        <option <?=$select2?> value="LN">LIBUR NASIONAL</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="keterangan<?=$i?>" class="form-control bg-transparent border-none border-0" value="<?=$sheetData[$i]['4']?>">
                                </td>
                                <td class="">
                                    <div class="form-check ">
                                        <label class="form-check-label">
                                            <input class="form-check-input checkOne m-0" name="index[]" type="checkbox" value="<?=$i?>" checked>
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

    </tbody>
</table>

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
