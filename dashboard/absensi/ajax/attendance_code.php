<?php
include("../../../config/config.php");
if(isset($_GET['id'])){
    ?>
    <option value="">Pilih Jenis Pengajuan</option>
    <?php
    $query_attendance_code = mysqli_query($link, "SELECT * FROM attendance_code WHERE `type`= '$_GET[id]' ORDER BY `kode` ASC ")or die(mysqli_error($link));
    
    if(mysqli_num_rows($query_attendance_code)>0){
        while($data_attendance_code = mysqli_fetch_assoc($query_attendance_code)){
            ?>
            <option value="<?=$data_attendance_code['kode']?>"><?=$data_attendance_code['keterangan']?></option>
            <?php
        }
    }else{
        ?>
        <option value="" disabled>Jenis Pengajuan Tidak Ada</option>
        <?php
    }
}else{
    ?>
    <option value="">Tipe Pengajuan Belum Dipilih</option>
    <?php
}