<?php

require_once("../../../config/config.php"); 
// $year = (isset($_SESSION['tahun']))?  $_SESSION['tahun'] : date('Y');
// echo $year;
if(isset($_POST['go'])){
    $_SESSION['tahun'] = $_POST['year'];
    $year = $_SESSION['tahun'];
}else{
    $year = date('Y');
}
$bulanini = date('m');
$bln = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","Sepember","Oktober","November","Desember");
$totalBln = count($bln);

$hari = array("Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu");
?>
<div class="modal fade bd-example-modal-lg" id="datapreview" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="holidays/proses.php" method="POST" id="RangeValidation">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h5 class="title text-left">Data Preview</h5>
                </div>
                <div class="modal-body px-2">
                    
                    <div id='ajax-wait' class="text-center">
                        <img alt='loading...' src='<?=base_url()?>/assets/img/Ellipsis-1s-200px.gif' width='32' height='32' style="display:none"/>
                    </div>
                    <div class="data_load  col-md-12"></div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-info btn-link" name="addholidays">Tambah Data</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col md-12">
        <div class="collapse collapse-view" >
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >
        
                        <div class="card-body  mt-2">
                        
                            <form method="post" enctype="multipart/form-data" action="proses.php">
                                
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        
                                        <fieldset>
                                        <legend class="text-muted h6">Add Seting</legend>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="">Upload File Excel</label>
                                                
                                            </div>
                                            
                                        </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="form-group rounded py-auto text-center border" style="border:1px dashed rgba(255, 255, 255, 0.4);background:rgba(255, 255, 255, 0.3)">
                                    
                                    <div class="fileinput fileinput-new text-center " data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail mt-4 mx-0" style="min-width:300px">
                                            <input type="text" class="form-control mx-0">
                                        </div>
                                        <div >
                                            <span class="btn btn-sm btn-link btn-round btn-rose btn-file ">
                                            <span class="fileinput-new ">Select File</span>
                                            <span class="fileinput-exists">Change</span>
                                                <input type="file"  name="file-excel" id="file_export"/>
                                            </span>
                                            <a  href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <button type="reset" class="btn btn-sm btn-warning">Reset</button>
                                <button type="button" class="btn btn-sm btn-primary load-data" data-toggle="modal" data-target="#loaddata">Load Data</button>
                                <a href="<?=base_url('file/template/Format_hari_kerja.xlsx')?>" class="btn btn-sm btn-link btn-info pull-right"><i class="fas fa-file-excel"></i> download format</a>
                                <hr>
                                
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form action="wd/proses.php" method="POST">
    
    <div class="row">
        <div class="col md-12">
            <div class="row">
                <div class="col-md-6">
                </div>
            </div>
            <div class="collapse show collapse-view" id="tambah">
                <div class="row">
                    <div class="col-md-12">
                        
                        <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >
            
                            <div class="card-body">  
                                <div class="row">
                                    
                                    <div class="col-md-2 pr-1">
                                        <div class="form-group-sm ">
                                            <label for="">Tanggal Awal</label>
                                            <input name="start_date" type="date" class="form-control" required >
                                        </div>
                                    </div>
                                    <div class="col-md-3 pl-0">
                                        <div class="form-group-sm">
                                            <label for="">Shift Awal</label>
                                            <select name="shift_start" id="" class="form-control"  required >
                                            <?php
                                                $q_working_shift = mysqli_query($link, "SELECT `id`,`name`,`req_date` FROM `working_day_shift`")or die(mysqli_error($link));
                                                if(mysqli_num_rows($q_working_shift)>0){
                                                    while($shift = mysqli_fetch_assoc($q_working_shift)){
                                                        ?>
                                                        <option   value="<?=$shift['id']?>"><?=$shift['name']?></option>
                                                        <?php
                                                    }
                                                }
                                                
                                            ?>
                                                
                                            </select>
                                        </div>

                                        <div class="form-group-sm mt-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" name="nonproduction" type="hidden" value="">
                                                <!-- <span class="form-check-sign"> Non Production Shift </span> -->
                                                </label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-2 pl-1">
                                        <div class="form-group-sm">
                                            <label for="">Tanggal Akhir</label>
                                            <input name="end_date" type="date" class="form-control"  required >
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group-sm">
                                            <label for="">Group Shift</label>
                                            <select name="group_shift" type="date" class="form-control text-uppercase"  required >

                                            
                                            <?php
                                                $q_shift = mysqli_query($link,"SELECT `id_shift`,`shift` FROM `shift`" )or die(mysqli_error($link));
                                                if(mysqli_num_rows($q_shift)>0){
                                                    while($shift = mysqli_fetch_assoc($q_shift)){
                                                        ?>
                                                        <option   value="<?=$shift['id_shift']?>"><?=$shift['shift']?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                            </select>    
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="col-md-3 ">
                                        <div class="input-group-sm">
                                            <label for="">Mulai Pergantian Shift</label>
                                            <select readonly name="start_day" class="form-control"  required >

                                            
                                            <?php
                                                foreach($hari AS $dataHari ){
                                                    $select = ($dataHari == 'Minggu')?"selected":"disabled";
                                                    ?>
                                                        <option  <?=$select?> value="<?=$dataHari?>"><?=$dataHari?></option>
                                                    <?php
                                                }
                                            ?>
                                            </select>
                                            <input type="hidden" class="form-control" value="7" name="skema">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <a  class="btn btn-sm btn-info " data-toggle="collapse" href=".tambah" role="button" aria-expanded="true" aria-controls="#tambah"> Generate</a>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        
        <div class="col md-12">
            <div class="collapse tambah collapse-view" id="tambah">
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-muted h6">Seting Jam Kerja Harian</h6>
                        <div class="card shadow-none border  " style="background:rgba(201, 201, 201, 0.2)" >
            
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                        $q_workingShift = mysqli_query($link, "SELECT `id`,`name`,`req_date` FROM `working_day_shift`")or die(mysqli_error($link));
                                        if(mysqli_num_rows($q_workingShift) > 0){
                                            while($dataShift = mysqli_fetch_assoc($q_workingShift)){
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6 class="title"><?=$dataShift['name']?></h6>
                                                        <div class="table-full-width table-hover">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th >#</th>
                                                                        <th class="col-md-2">Hari</th>
                                                                        <th class="col-md-2">Skema Jam Kerja</th>
                                                                        <th class="col-md-2">Skema Waktu Istirahat</th>
                                                                        <th class="text-right">Libur</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $no = 1;
                                                                    foreach($hari AS $dataHari ){
                                                                        $checked = ($dataHari == 'Sabtu' OR $dataHari == 'Minggu')?"checked":"disabled";
                                                                        ?>
                                                                        <tr>
                                                                            <td><?=$no?></td>
                                                                            <td class="col-md-1">
                                                                                <div class="form-group-sm">
                                                                                    <input type="text" readonly required  name="<?=$dataHari?>_<?=$dataShift['id']?>" class="form-control" value="<?=$dataHari?>">
                                                                                </div>
                                                                            </td>
                                                                            <td class="col-md-4">
                                                                                <div class="form-group-sm ">
                                                                                    <select required name="wh_<?=$dataHari?>_<?=$dataShift['id']?>"  class="selectpicker " data-width="100%" data-style="btn btn-sm btn-outline-primary btn-link" data-title="pilih waktu kerja" data-size="5">
                                                                                        <?php
                                                                                            $query_wh = mysqli_query($link, "SELECT id, code_name, `start`, `end`, ket FROM working_hours ")or die(mysqli_error($link));
                                                                                            if(mysqli_num_rows($query_wh) > 0){
                                                                                                while($data = mysqli_fetch_assoc($query_wh)){
                                                                                                    ?>
                                                                                                    <option value="<?=$data['id']?>" title="<?=$data['start']?> - <?=$data['end']?>" data-subtext="<?=$data['ket']?>"><?=$data['code_name']?> : <?=$data['start']?> - <?=$data['end']?> </option>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </td>
                                                                            <td class="col-md-5">
                                                                                <div class="form-group-sm">
                                                                                    <select  required  name="wb_<?=$dataHari?>_<?=$dataShift['id']?>" data-width="100%" class="selectpicker " data-style="btn btn-sm btn-outline-primary btn-link w-100" data-title="pilih seting istirahat" data-size="5">
                                                                                        <?php
                                                                                            $query_wbs = mysqli_query($link, "SELECT `id_working_day_shift`,`id_working_break`,`effective_date`,`break_group_id` FROM `working_break_shift` GROUP BY `break_group_id` ")or die(mysqli_error($link));
                                                                                            if(mysqli_num_rows($query_wbs) > 0){
                                                                                                while($dataW = mysqli_fetch_assoc($query_wbs)){
                                                                                                    ?>

                                                                                                    <option value="<?=$dataW['break_group_id']?>" title="SETING <?=$dataW['break_group_id']?>  " data-subtext="SETING <?=$dataW['break_group_id']?> ">
                                                                                                        <?php
                                                                                                                $query_wb = mysqli_query($link, "SELECT working_break.start_time AS `start`,
                                                                                                                    working_break.scheme_name AS `name`,
                                                                                                                working_break.end_time AS `end`  FROM `working_break_shift` 
                                                                                                                JOIN working_break ON working_break.id = working_break_shift.id_working_break WHERE 
                                                                                                                working_break_shift.break_group_id = '$dataW[break_group_id]'
                                                                                                                ")or die(mysqli_error($link));
                                                                                                                if(mysqli_num_rows($query_wb)>0){
                                                                                                                    $data = "";
                                                                                                                    while($dataWb = mysqli_fetch_assoc($query_wb)){
                                                                                                                        $data .= $dataWb['start']." - ".$dataWb['start']." , <br> ";
                                                                                                                    }
                                                                                                                    
                                                                                                                    echo substr($data, 0 , -2);
                                                                                                                }
                                                                                                        ?>
                                                                                                    
                                                                                                    </option>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-right">
                                                                                <div class="form-group-sm">
                                                                                    <div class="form-check">
                                                                                        <label class="form-check-label">
                                                                                            <input   <?=$checked?> class="form-check-input" name="holiday[]" type="checkbox" value="<?=$dataHari?>">
                                                                                        <span class="form-check-sign"> </span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    <?php
                                                                    $no++;
                                                                    }

                                                                    ?>
                                                                    <tr>
                                                                        <td></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-warning"  type="reset"> Reset </button>
                                        <input name="generate" class="btn btn-success" type="SUBMIT" value="submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<div class="row">
    <div class="col-md-12">
        <div class="form-inline">
            <div class="input-group no-border">
                <div class="form-group-sm">
                    <select type="date" name="start" id="startdate" class="form-control pl-2" >
                        <option Disabled>Pilih Bulan</option>
                        <?php
                        $i =0;
                        foreach($bln AS $namaBln){
                            $i++;
                            $selectBln = ($i == $bulanini)?"selected":"";
                            
                            echo "<option  $selectBln value=\"$i\">$namaBln</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group-sm ">
                    <div class="form-control">
                        to
                    </div>
                </div>
                <div class="form-group-sm">
                    <select type="date" name="end"  id="enddate" class="form-control pl-2" >
                        <option Disabled>Pilih Bulan</option>
                        <?php
                        $i =0;
                        foreach($bln AS $namaBln){
                            
                            $i++;
                            $selectBln = ($i == $bulanini)?"selected":"";
                            echo "<option $selectBln value=\"$i\">$namaBln</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group-sm">
                    <select type="year" name="year" id="year" class="form-control" >
                        <?php
                        $thn = mysqli_query($link, "SELECT `date` FROM working_days GROUP BY YEAR(`date`) ASC")or die(mysqli_error($link));
                        while($dataThn = mysqli_fetch_assoc($thn)){
                            
                            $tgl = $dataThn['date'];
                            $dataThn_pecah = explode("-", $tgl);
                            $tahun = $dataThn_pecah['0'];
                            $select = ($tahun == $year) ? "selected" : "";
                            echo "<option $select value=\"$tahun\">$tahun</option>";
                        }
                        ?>
                        
                    </select>
                    
                </div>
                <div class="form-group-sm">
                    <select name="groupshift" id="groupshift" class="form-control">
                        <?php
                        $query = mysqli_query($link, "SELECT * FROM shift")or die(mysqli_error($link));
                        if(mysqli_num_rows($query)>0){
                            while($data = mysqli_fetch_assoc($query)){
                                ?>
                                <option value="<?=$data['id_shift']?>"><?=$data['shift']?></option>
                                <?php
                            }
                        }else{
                            ?>
                            <option value="">Belum Ada Data</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="input-group-append">
                <input type="submit" name="go" id="sortyear" class="ml-2 col-lg-1 btn btn-sm btn-round btn-icon btn-link" value="go">  
            </div>
        </div>
    </div>
</div>

<div class="viewdata"></div>
<script src="<?=base_url('assets/datepicker/js/bootstrap-datepicker.js')?>"></script>
<script src="<?=base_url('assets/datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<script>
    $(document).ready(function(e){
        function get_data(){
            var year = $('#year').val();
            var sd = $('#startdate').val();
            var ed = $('#enddate').val();
            var shift = $('#groupshift').val();
            $('.viewdata').load("wd/ajax/index.php?year="+year+"&startdate="+sd+"&enddate="+ed+"&groupshift="+shift);
        }
        get_data();
        $('#sortyear').click(function(a){
            a.preventDefault();
            get_data();
        })
        
        $(".selectpicker").selectpicker();
            
        
    })
    
</script>
<script>
    $(document).ready(function(e){
        e.preventDefault
        $('.load-data').on('click', function() {
            var file_data = $('#file_export').prop('files')[0];   
            var form_data = new FormData();
            
            form_data.append('file-excel', file_data);
            // alert(form_data);                             
            $.ajax({
                url: 'wd/ajax/import.php',
                dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                // encode: 'true',  // <-- what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(resp){
                    
                    // var cek = Object.keys(file_data).length
                    // console.log(file_data)
                    if(file_data !== undefined){
                        $('#dataimport').modal('show');
                        $(".data_load").html(resp);
                    }else{
                        Swal.fire('Dokumen Belum dipilih')
                    }
                }
            });
        });
    })
</script>