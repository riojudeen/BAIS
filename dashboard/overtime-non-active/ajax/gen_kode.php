<?php
include("../../../config/config.php");
$npk_user = $_SESSION['user'];
if(!empty($_POST['code'])){
    
    $string_tanggal = $_POST['code'];
    
    $pecah_tanggal= explode("/", $string_tanggal);
    $kode_tahun = $pecah_tanggal[2];
    $kode_hari = $pecah_tanggal[0];
    $bln = $pecah_tanggal[1];
        $mList = array(
        '01' => 'I',
        '02' => 'II',
        '03' => 'III',
        '04' => 'IV',
        '05' => 'V',
        '06' => 'VI',
        '07' => 'VII',
        '08' => 'VIII',
        '09' => 'IX',
        '10' => 'X',
        '11' => 'XI',
        '12' => 'XII');
    $bln_romawi = $mList[$bln];
    $date = date('d/m/Y');
    $pecah_tglInput= explode("/", $date);
    $kode_tglInput = $pecah_tglInput[0].$pecah_tglInput[1];
    $s_area = mysqli_query($link, "SELECT karyawan.department AS dept , dept_account.id_dept_account AS id_dept , division.nama_divisi AS divisi , karyawan.id_area AS id_area
    FROM karyawan JOIN dept_account ON karyawan.department = dept_account.id_dept_account LEFT JOIN division ON dept_account.id_div = division.id_div WHERE npk = '$npk_user' ") or die(mysqli_error($link));
    $kode_area = mysqli_fetch_assoc($s_area);
    $id_area = $kode_area['id_area'];
    $pecah_string_div = explode(" ", $kode_area['divisi']);
    $string_div = substr($pecah_string_div[0], 0,1);
    //mengambil kode dept account , 
    $string_dept = $kode_area['id_dept'];
    $kode_lembur = $string_div."/".$string_dept."-".$kode_tahun."/".$bln_romawi."/".$kode_hari."/".$id_area."-".$kode_tglInput;
    
    
    
    ?>
    <h6 class="text-center">Kode Lembur:</h6> 
    <h6 class=" text-uppercase text-danger text-center "><?=$kode_lembur?></h6> 
    <p class="text-center"><em class="text-info">save</em> untuk melanjutkan</p>
    <input type="hidden" name="kode-lembur" value="<?=$kode_lembur?>" />
    
    <?php
    $_SESSION['kode-lembur'] = $kode_lembur;
    $_SESSION['ot_date'] = $_POST['code'];
    
}else{
    ?>
    <p class="text-center text-danger text-uppercase">pastikan data diisi dengan lengkap</p>
    <?php
}


?>