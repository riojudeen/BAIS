<style>
    .dropdown-menu {
    background-color: #fdfcfc;
    border: 0 none;
    border-radius: 12px;
    margin-top: 10px;
    padding: 0px;
    box-shadow: 1px 1px 10px rgba(61, 61, 61, 0.5);
}
.bootstrap-timepicker-widget.timepicker-orient-top:before {
    top: -7px;
    
}

.bootstrap-timepicker-widget.timepicker-orient-left:before {
    left: 6px;
}
.bootstrap-timepicker-widget table td a {
    border: 1px  transparent solid;
    width: 100%;
    display: inline-block;
    margin: 0;
    padding: 8px 0;
    outline: 0;
    color: #333;
}
.bootstrap-timepicker-widget table td a:after{
    content : "< >";
    padding : 0px;

}
</style>
<?php
include("../../../config/config.php");
require_once("../../../config/function_status_approve.php");
require_once("../../../config/function_access_query.php");
require_once("../../../config/function_filter.php");
if(isset($_POST['tgl'])){
    list($clm, $area_access, $sub_area_access, $value_access) = access_area_jabatan($link, $jabatan, $npkUser);
    
    $npk_user = $npkUser;
    
    //mengambil tahun berjalan 
    $tahun = date('Y');

    $ot_date = (!empty($_POST['tgl']))? $_POST['tgl'] : "";

    //membuat session shift 
    $tanggalOvertime = ($ot_date != '')?dateToDB($ot_date):"";
    //query working days
    $q_shift = mysqli_query($link, "SELECT karyawan.shift FROM karyawan 
    JOIN org ON karyawan.npk = org.npk
    WHERE $area_access = '$value_access' GROUP BY karyawan.shift")or die(mysqli_error($link));

    $index = 0;
    $jml = mysqli_num_rows($q_shift);
    if(mysqli_num_rows($q_shift) > 0){
        while($dataShift = mysqli_fetch_assoc($q_shift)){
            $arrayShift[$index] = $dataShift['shift'];
            $index++;
        }
    }
    
    $q_Wd = "SELECT working_days.date AS 'tanggalKerja',
            working_days.wh AS 'idJamKerja',
            working_days.shift AS 'idJamKerja',
            working_days.ket AS 'ketHariKerja',
            working_hours.code_name AS 'kodeNamaWH',
            working_hours.start AS 'mulai',
            working_hours.end AS 'selesai',
            working_hours.ket AS 'ketWh'

            FROM working_days LEFT JOIN working_hours 
            ON working_hours.id = working_days.wh"; 
    
    if(count($arrayShift) > 0){
        foreach($arrayShift AS $shift){
            $q_waktuKerja = $q_Wd." WHERE working_days.date = '$tanggalOvertime' AND working_days.shift = '$shift'";
            $sql_waktuKerja = mysqli_query($link, $q_waktuKerja)or die(mysqli_error($link));
            $dataWaktuKerja = mysqli_fetch_assoc($sql_waktuKerja);
            $date_out = date_out($dataWaktuKerja['tanggalKerja'], $dataWaktuKerja['mulai'], $dataWaktuKerja['selesai']);

            // echo $tanggalOvertime;
            ?>
            <div class="row border rounded mx-1 my-2 ">
                <legend class="text-left border-bottom px-2">Shft <?=$shift?></legend>
                <div class="col-md-12 px-2">
                    <div class="form-group">
                        <label>Waktu Mulai</label>
                        <div class="input-group bg-transparent ">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent "><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="hidden" name="shift[]" value="<?=$shift?>" />
                            <input type="text"  class="form-control datepicker bg-transparent " id="DateTimePicker1<?=$shift?>" name="tanggalmulai<?=$shift?>" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($dataWaktuKerja['tanggalKerja'])?>" readonly>
                            <div class="input-group-append pl-0 m-0">
                                <span class="input-group-text  px-2 bg-transparent "><i class="nc-icon nc-time-alarm"></i></span>
                            </div>
                            <input type="text" class="form-control datepicker bg-transparent " name="waktumulai[]" value="<?=$dataWaktuKerja['mulai']?>" data-date-format="HH:ii:ss" readonly>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12 px-2"> 
                    <div class="form-group">
                        <label>Waktu Selesai</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent no-border"><i class="fa fa-calendar"></i></span>
                            </div>
                            
                            <input type="text" class="form-control datepicker bg-transparent " id="DateTimePicker2<?=$shift?>" name="tanggalselesai<?=$shift?>" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($date_out)?>" readonly>
                            <div class="input-group-append pl-0 m-0 bg-transparent ">
                                <span class="input-group-text px-2 bg-transparent "><i class="nc-icon nc-time-alarm"></i></span>
                            </div>
                            <input type="text" class="form-control datepicker bg-transparent " name="waktuselesai[]" value="<?=$dataWaktuKerja['selesai']?>" data-date-format="HH:ii:ss" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        }
    }else{
        //jangan tampilkan jka tidak ada yang dipilih
    }
}

?>

<script type="text/javascript">
$(document).ready(function() {
    <?php
    if(count($arrayShift) > 0){
        foreach($arrayShift AS $shift){
            ?>
            $(function () {
                $('#DateTimePicker1<?=$shift?>').datetimepicker({format: 'DD/MM/YYYY'});
                $('#DateTimePicker2<?=$shift?>').datetimepicker({format: 'DD/MM/YYYY',
                 useCurrent: true //Important! See issue #1075     
            });
                $("#DateTimePicker1<?=$shift?>").on("dp.change", function (e) {
                    $('#DateTimePicker2<?=$shift?>').data("DateTimePicker").minDate(e.date);
                });
                $("#DateTimePicker2<?=$shift?>").on("dp.change", function (e) {
                    $('#DateTimePicker1<?=$shift?>').data("DateTimePicker").maxDate(e.date);
                });
            });
            <?php
        }
    }
    ?>
})
</script>
<script type="text/javascript">
$(document).ready(function() {

    $('.timepicker').timepicker({
        showInputs: false,
        showMeridian: false
    })

   
})
</script>
