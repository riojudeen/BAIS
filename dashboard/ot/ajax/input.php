<?php
require_once("../../../config/config.php");
require_once("../../../config/approval_system.php");
if(isset($_SESSION['user'])){
    if(isset($_POST['tipe'])){
        if($_POST['tipe'] == ''){
            $required = "required";
            $requiredCode = "required";
        }else if($_POST['tipe'] == 'SUPEM'){
            // echo "SUPEM";
            $required = "";
            $requiredCode = "required";
        }else if($_POST['tipe'] == 'SUKET'){
            // echo "SUKET";
            $required = "";
            $requiredCode = "";
        }
        
        $date = dateToDB($_POST['date']);
        $sql_absenHr = mysqli_query($link, "SELECT absensi.id AS id_absen,
        absensi.npk AS npk_absen, 
        absensi.shift AS shift_absen,
        absensi.date AS tanggal,
        absensi.check_in AS check_in,
        absensi.check_out AS check_out,
        absensi.ket AS ket,
        

        org.npk AS npk_org,
        org.sub_post AS sub_post,
        org.post AS post,
        org.grp AS grp,
        org.sect AS sect,
        org.dept AS dept,
        org.dept_account AS dept_account,
        org.division AS division,
        org.plant AS plant,

        karyawan.npk AS npk_,
        karyawan.nama AS nama_,
        karyawan.shift AS shift_,
        karyawan.id_area AS id_area_,
        karyawan.department AS department_

        FROM absensi
        LEFT JOIN karyawan ON karyawan.npk = absensi.npk
        LEFT JOIN org ON org.npk = karyawan.npk
        WHERE  absensi.npk = '$_POST[npk]' AND absensi.date = '$date' ")or die(mysqli_error($link));
$dataAbsenHr = mysqli_fetch_assoc($sql_absenHr);
$check_in = ($dataAbsenHr['check_in'] == '00:00:00')? "" : jam($dataAbsenHr['check_in']);
$check_out = ($dataAbsenHr['check_out'] == '00:00:00')? "" : jam($dataAbsenHr['check_out']);

$disableIn = ($check_in != '')?"readonly":"";
$disableOut = ($check_in != '')?"readonly":"";

if($_POST['tipe'] == 'SUPEM'){
    $disableIn = "readonly";
    $disableOut = "readonly";
}else{
    $disableIn = ($check_in != '')?"readonly":"";
    $disableOut = ($check_out != '')?"readonly":"";
}

$query_cekCuti = "SELECT `npk`,`date`,`check_in`, `note`, `keterangan`, `check_out`,`date_in`,`date_out`, `req_date` FROM `req_absensi` WHERE id = '$_POST[npk]$date' AND shift_req <> 1";
$sqlCheck = mysqli_query($link, $query_cekCuti)or die(mysqli_error($link));
$dataCek = mysqli_fetch_assoc($sqlCheck);
if(mysqli_num_rows($sqlCheck) > 0){
    $check_in = $dataCek['check_in'];
    $check_out = $dataCek['check_out'];
    $disableIn = "readonly";
    $disableOut = "readonly";
    $ket = $dataCek['note'];
    $submit = "disabled";
    $notif = 1;
}else{
    $check_in = $check_in;
    $check_out = $check_out;
    $ket = "";
    $submit = "";
    $notif = 0;
    
}

// echo $dataAbsenHr['check_out'];
// echo $date;
?>

<div class="row">
    
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 pr-1">
                <label>Check In </label>
                <div class="form-group ">
                    <input required <?=$disableIn?> type="time" name="ci" minLength="8" maxLength="8" class="form-control datepicker mr-2 " data-date-format="HH:mm" placeholder="Jam Masuk" value="<?=$check_in?>" required >
                </div>
            </div>
            <div class="col-md-6 pl-1">
                <label>Check Out</label>
                <div class="form-group">
                    <input required <?=$disableOut?> type="time" name="co" minLength="8" maxLength="8" class="form-control datepicker ml-2" data-date-format="HH:mm" placeholder="Jam Pulang" value="<?=$check_out?>" required >
                </div>
            </div>
            <div class="col-md-12">
                <label>Keterangan</label>
                <select <?=$submit?> name="kode_absen[]" class="form-control col-lg-12 text-uppercase col-lg-4" id="" <?=$requiredCode?>>
                <?php
                $sqlAbs = mysqli_query($link, "SELECT * FROM attendance_code WHERE `type` = '$_POST[tipe]' ")or die(mysqli_error($link));
                if($notif > 0 ){
                    ?>
                        <option readonly selected value="<?=$dataCek['keterangan']?>"><?=$dataCek['keterangan']?></option>
                    <?php
                }
                if(mysqli_num_rows($sqlAbs) > 0){
                    ?>
                    <option disabled>pilih</option>
                    <?php
                    while($dataCode = mysqli_fetch_assoc($sqlAbs)){
                        $slct = ($dataCode['kode'] == $dataAbsenHr['ket'])? "selected" : "";
                        ?>
                        <option value="<?=$dataCode['kode']?>" <?=$slct?>><?=$dataCode['keterangan']?> - <?=$dataCode['kode']?></option>
                            
                        <?php
                    }
                }else{
                    ?>
                    <option value=""><?=noData()?></option>
                    <?php
                }
                ?>

                </select>

            </div>
            <div class="col-md-12">
                <label>Alasan / keperluan</label>
                <div class="form-group">
                    <textarea <?=$submit?> name="note[]" minLength="5" maxLength="20" rows="4" cols="70" placeholder="tulis alasan / keperluan pengajuan.." class="form-control textarea" required><?=$ket?></textarea>
                </div>
            </div>
        </div>

    </div>
    
</div>

<script>
 $('.selectpicker').selectpicker(function(){
     
 })
</script>

<?php
    }
}
?>


                            