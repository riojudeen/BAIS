<?php

require_once("../../../config/config.php");
require_once("../../../config/error.php");
require "../../../_assets/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    if(isset($_FILES['file_import']['name']) && in_array($_FILES['file_import']['type'], $file_mimes)) {
    
        $arr_file = explode('.', $_FILES['file_import']['name']);
        $extension = end($arr_file);
    
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $reader->load($_FILES['file_import']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        ?>
        <div class="table-responsive text-left">
            <table class="table table-striped">
                <thead>
                    <th style="width:50px">#</th>
                    <th style="width:100px">Npk</th>
                    <th style="width:300px">Nama</th>
                    <th style="width:100px">Jam Mulai</th>
                    <th style="width:100px">Jam Selesai</th>
                    <th style="width:100px">Menit</th>
                    <th style="width:500px">Activity</th>
                    <th style="width:100px">Area</th>
                    <th style="width:50px">Shift</th>
                    <th style="width:50px">Kode Job</th>
                    
                    <th>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="allmp">
                            <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </th>
                </thead>

            <tbody>
                    
        </div>
        <?php
        $no = 1;
        for($i = 11;$i < count($sheetData);$i++){
            $npk = $sheetData[$i]['4'];
            $nama = $sheetData[$i]['5'];
            $mulai = $sheetData[$i]['12'];
            $selesai = $sheetData[$i]['13'];
            $menit = $sheetData[$i]['14'];
            $activity = $sheetData[$i]['15'];
            $ot_cost = $sheetData[$i]['21'];
            $jalur = $sheetData[$i]['22'];
            $shift = $sheetData[$i]['23'];
            $kode = $sheetData[$i]['24'];
            $id_jalur = $sheetData[$i]['21'];
            
            
            ?>
            <tr>
                <td>
                    <input class="bg-transparent border-none form-control m-0 p-0 " name="no[]"  type="text" style="border: 0px" value="<?=$no?>" readonly>
                    <input class="bg-transparent border-none form-control m-0 p-0 " name="ot_cost-<?=$no?>[]"  type="hidden" style="border: 0px" value="<?=$ot_cost?>" readonly>
                    <input class="bg-transparent border-none form-control m-0 p-0 " name="id_jalur-<?=$no?>[]"  type="hidden" style="border: 0px" value="<?=$id_jalur?>" readonly>
                </td>
                <td>
                    <input class="bg-transparent border-none form-control m-0 p-0" name="npk-<?=$no?>[]" type="text" style="border: 0px" value="<?=$npk?>" readonly>
                </td>
                <td>
                    <input class="bg-transparent border-none form-control m-0 p-0" name="nama-<?=$no?>[]" type="text" style="border: 0px" value="<?=$nama?>" readonly>    
                </td>
                <td>
                    <input class="bg-transparent border-none form-control m-0 p-0 datepicker" name="mulai-<?=$no?>[]" type="type" maxlength="5" style="border: 0px" value="<?=$mulai?>" >    
                </td>
                <td>
                    <input class="bg-transparent border-none form-control m-0 p-0" name="selesai-<?=$no?>[]"  type="text" style="border: 0px" maxlength="5" value="<?=$selesai?>" >
                </td>
                <td>
                    <input class="bg-transparent border-none form-control m-0 p-0" name="menit-<?=$no?>[]"  type="number" style="border: 0px" pattern="[1-9]" value="<?=$menit?>" >    
                </td>
                <td>
                    <input class="bg-transparent border-none form-control m-0 p-0" name="activity-<?=$no?>[]" type="text" style="border: 0px" value="<?=$activity?>" >    
                </td>
                <td>
                    <input class="bg-transparent border-none form-control m-0 p-0" name="jalur-<?=$no?>[]" type="text" style="border: 0px" value="<?=$jalur?>" readonly>
                </td>
                <td>
                    <input class="bg-transparent border-none form-control m-0 p-0" name="shift-<?=$no?>[]"  type="text" style="border: 0px" value="<?=$shift?>" readonly>    
                </td>
                <td>
                    <input class="bg-transparent border-none form-control m-0 p-0" name="kode-<?=$no?>[]" type="text" style="border: 0px" value="<?=$kode?>" readonly>   
                </td>
                <td>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input mp" name="mpchecked[]" type="checkbox" value="<?=$no?>">
                        <span class="form-check-sign"></span>
                        </label>
                    </div>
                </td>
            </tr>
            
            <?php
            $no++;

        }
       
    }else{
        // $_SESSION['info'] = "Kosong";
        // header("Location: ../manpower.php");
        ?>
        <h6 class="text-danger">File Belum Dipilih</h6>
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
                })
            </script>