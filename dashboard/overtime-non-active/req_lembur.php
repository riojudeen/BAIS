<?php
//////////////////////////////////////////////////////////////////////
include("../../config/config.php");
require_once("../../config/function_status_approve.php");
require_once("../../config/function_access_query.php");
require_once("../../config/function_filter.php");
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Request Lembur";
if(isset($_SESSION['user'])){
    include("../header.php");
    
    list($clm, $area_access, $sub_area_access, $value_access) = access_area_jabatan($link, $jabatan, $npkUser);
    $_SESSION['waktumulai'] = (isset($_POST['waktumulai']))?$_POST['waktumulai']:$_SESSION['waktumulai'];
    $_SESSION['waktuselesai'] = (isset($_POST['waktuselesai']))?$_POST['waktumulai']:$_SESSION['waktuselesai'];
    $_SESSION['shift'] = (isset($_POST['shift']))?$_POST['shift']:$_SESSION['shift'];
 
    $ot_date = $_SESSION['ot_date'];
    // echo $ot_date;
    // $hari_spl = (isset($_POST['start_date']))? $_POST['start_date'] : NULL ;
    // $end_spl = (isset($_POST['end_date']))? $_POST['end_date'] : NULL ;
    $jc = (isset($_POST['jobcode']))? $_POST['jobcode'] : NULL;
    $act = (isset($_POST['activity']))? $_POST['activity'] : NULL;

    //record sesui inputan
    $tglMulai = (isset($_POST['tanggalmulai']))? $_POST['tanggalmulai'] : NULL;
    $tglSelesai = (isset($_POST['tanggalselesai']))? $_POST['tanggalselesai'] : NULL;

    $waktuMulai = (isset($_POST['waktumulai']))? $_POST['waktumulai'] : NULL;
    $waktuSelesai = (isset($_POST['waktuselesai']))? $_POST['waktuselesai'] : NULL;
    $kode_ot = $_SESSION['kode-lembur'];

    if(isset($_POST['npk'])){
        $npk = $_POST['npk'];
        $total_input = count($npk);
    }
    $i = 0;
    if(isset($_POST['shiftfilter'])){
        $array_shift[$i] = $_POST['shiftfilter'];
        $i++;
    }else{
        $array_shift[$i] = '';
    }
    // print_r($array_shift);

    include("ajax/set_record.php");
?>

<form action="req_lembur.php" method="POST">
    <div class="modal fade bd-example-modal-md" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalfilter">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title text-left" id="exampleModalLongTitle">Filter Shift</h5>
                </div>
                
                <div class="modal-body px-3">
                    <div class="card card-body py-1 my-1">
                        <?php
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


                        $tanggalOvertime = dateToDB($ot_date);
                        if(count($arrayShift) > 0){
                            foreach($arrayShift AS $shf){
                                $q_waktuKerja = $q_Wd." WHERE working_days.date = '$tanggalOvertime' AND working_days.shift = '$shf'";
                                $sql_waktuKerja = mysqli_query($link, $q_waktuKerja)or die(mysqli_error($link));
                                $dataWaktuKerja = mysqli_fetch_assoc($sql_waktuKerja);
                                $date_out = date_out($dataWaktuKerja['tanggalKerja'], $dataWaktuKerja['mulai'], $dataWaktuKerja['selesai']);
                                $tblSelect = (in_array($shf, $array_shift))?"checked":"";

                                echo $tblSelect;
                                ?>
                                <div class="form-group">
                        <!-- <label>Waktu Mulai</label> -->
                            
                                    <h6 class="pull-left my-1" >Shift <?=$shf?> (Working Time)</h6>
                                    <div class="box pull-right my-1">
                                        <input class="bootstrap-switch" type="checkbox" <?=$tblSelect?> data-toggle="switch" name="shiftfilter[]" value="<?=$shf?>" data-on-label="<i class='nc-icon nc-check-2'></i>" data-off-label="<i class='nc-icon nc-simple-remove'></i>" data-on-color="warning" data-off-color="warning" />
                                    </div>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="nc-icon nc-time-alarm"></i></span>
                                        </div>
                                        <input type="text"  class="form-control datepicker" name="waktumulai[]" data-date-format="HH:mm:ss" value="<?=$dataWaktuKerja['mulai']?>" required>
                                        <div class="input-group-append pl-0 m-0">
                                            <span class="input-group-text px-2"><i class="text-center">to</i></span>
                                        </div>
                                        <input type="text" class="form-control datepicker" name="waktuselesai[]" data-date-format="HH:mm:ss" value="<?=$dataWaktuKerja['selesai']?>" required>
                                        
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="filter" class="btn btn-primary">Save</button>
                </div>
            
            </div>
        </div>
    </div>
</form>
<?php

// $qryShift = ($qryFilter  != '')?'AND ('.(substr($qryFilter , 2)).')':'';
                                
$t = "org.".$org_access;
$q_ = "SELECT lembur._id  AS id_lembur , 
    lembur.kode_lembur AS kode_lembur , lembur.requester AS requester , 
    lembur.npk AS npk_lembur , 
    lembur.in_date AS tgl_mulai , 
    lembur.out_date AS tgl_selesai , 
    lembur.in_lembur AS waktu_mulai , 
    lembur.out_lembur AS waktu_selesai , 
    lembur.kode_job AS kode_job , 
    lembur.aktifitas AS activity , 
    lembur.tanggal_input AS tanggal_input ,
    lembur.status_approve AS stat_approve , 
    lembur.status AS `status` , karyawan.npk AS npk ,

    karyawan.nama AS nama , 
    karyawan.jabatan AS jabatan , 
    karyawan.shift AS shift ,
    karyawan.id_area AS id_area
    FROM lembur 
    JOIN org ON org.npk = lembur.npk
    JOIN karyawan ON org.npk = karyawan.npk
    WHERE kode_lembur = '$kode_ot' AND $area_access = '$value_access' ";
$q_otMp = $q_."AND CONCAT(lembur.status_approve, lembur.status) = '0a' ";
$q_otRequest = $q_."AND CONCAT(lembur.status_approve, lembur.status) <> '0a' AND CONCAT(lembur.status_approve, lembur.status) <> '100c'   ";

$totalMP = mysqli_num_rows(mysqli_query($link, $q_otMp));


?>
<!-- end modal input data -->
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header ">
                <div class="pull-left">
                    <h5 class="card-title">Input Surat Perintah Lembur</span>
                        <span class="badge badge-pill badge-danger"></span>
                    </h5>
                    <p class="card-category">No Surat : <?=$kode_ot?></p>
                </div>
                
                <div class="box pull-right">
                    <button type="button" class="btn btn-default align-center align-bottom" data-toggle="modal" data-target="#modalinputdata">
                        <span class="btn-label">
                            <i class="fa fa-plus"></i>
                        </span>
                            Input Data
                    </button>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#modalfilter">
                        <span class="btn-label">
                            <i class="nc-icon nc-settings-gear-65"></i>
                        </span>
                        Filter Data
                    </button>
                    
                    <a href="index.php" class="btn btn-default">
                        <span class="btn-label">
                            <i class="nc-icon nc-settings-gear-65"></i>
                        </span>
                        Back
                    </a>
                </div>
            </div>
            <div class="card-body ">
                
                <div class="table-responsive">
                    <table class="table" rules="cols" style="border: 1px solid black">
                        
                        <thead class="text-center">
                            <tr>
                                <th style="border: 1px solid black; width: 120px"><img style="width: 100px" src="../../assets/img/logo_daihatsu.png"></th>
                                <th style="border: 1px solid black; font-size: 25px" colspan="7">Surat Perintah Lembur</th>
                                <th style="border: 1px solid black; font-size: 25px; width: 120px"><?=date('Y')?></th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-1" colspan="9" style="border: 1px solid black; height:2px"></td>
                            </tr>
                            <colgroup>
                                <col style="width: 20px">
                                <col style="width: 25px">
                                <col style="width: 150px">
                            </colgroup>
                            <tr>
                                <td class="py-0" colspan="2" style="height:50px">Line / POS</td>
                                <td class="py-0" style="height:50px">: <?=$areaUser?></td>
                                <td class="p-0 text-muted" rowspan="4" colspan="5">
                                <div class="table-responsive text-nowrap">
                                    <table class="table p-0 m-0">
                                        <tbody>
                                        <?php
                                            // kode lembur
                                            $baris = 5;
                                            $q_jobcode = "SELECT * FROM kode_lembur";
                                            $s_jobcode = mysqli_query($link, $q_jobcode)or die(mysqli_error($link));
                                            $jml_row = mysqli_num_rows($s_jobcode);
                                            
                                            $sisa_kolom = $jml_row % $baris; //sisa baris
                                            if($sisa_kolom > 0){
                                                $hasil_kolom = (($jml_row - $sisa_kolom)/$baris)+1;
                                            }else{
                                                $hasil_kolom = ( $jml_row / $baris);
                                            }
                                            
                                            echo "<tr>";
                                            
                                            for($i=0; $i<$hasil_kolom; $i++){
                                                echo "<td class=\"p-0 m-0\"><table class=\"table table-striped\">"
                                                ?>
                                                <colgroup>
                                                    <col style="width: 50px">
                                                    <col style="width: 200px">
                                                
                                                </colgroup>

                                                <?php
                                                echo "<thead class=\"p-0 mt-0\">";
                                                echo "<th class=\"py-1 px-1\">Kode</th>";
                                                echo "<th class=\"py-1 px-1\">Activity</th>";
                                                echo "<tbody class=\"p-0 mt-0\">";
                                                
                                                $offset = $i * $baris;
                                                $q_code = "SELECT * FROM kode_lembur LIMIT $offset , $baris";
                                                $s_code = mysqli_query($link, $q_code)or die(mysqli_error($link));

                                                for($hasilbaris=0; $hasilbaris<=$baris; $hasilbaris++){
                                                    while($d_jobcode = mysqli_fetch_assoc($s_code)){
                                                        echo "<tr>";
                                                        echo "<td class=\"py-1 px-1\">".$d_jobcode['kode_lembur']."</td>";
                                                        echo "<td class=\"py-1 px-1\">".$d_jobcode['nama']."</td>";
                                                        echo "</tr>";
                                                        
                                                    }
                                                }
                                                if($sisa_kolom > 0 && $hasil_kolom == $i +1){
                                                    $tambah = $baris - $sisa_kolom;
                                                    for($tbh=0 ; $tbh<$tambah ; $tbh++){
                                                        echo "<tr>";
                                                        echo "<td class=\"py-1 px-1\"> -</td>";
                                                        echo "<td class=\"py-1 px-1\"> -</td>";
                                                        echo "</tr>";
                                                    }
                                                }
                                                echo "</tbody></table></td>";
                                            }
                                            echo "</tr>";
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                </td>
                                <th class="py-0 text-center text-white bg-secondary " rowspan="2">Total MP</th>
                            </tr>
                            <tr>
                                <td class="py-0" style="height:50px" colspan="2">Shift</td>
                                <td class="py-0" style="height:50px" >: A, B , N</td>
                                
                            </tr>
                            <tr>
                                <td class="py-0" style="height:50px" colspan="2">Department</td>
                                <td class="py-0" style="height:50px" >: Body 2</td>
                                <td class="py-0 my-0 text-center h1" rowspan="2" style="height:50px" ><?=$totalMP?></td>
                               
                            </tr>
                            <tr>
                                <td class="py-0" colspan="2" style="height:50px" >Hari / Tanggal </td>
                                <td class="py-0" style="height:50px" >: <?=hari($ot_date)?>, <?=tgl(dateToDB($ot_date))?></td>
                                
                            </tr>
                            <!-- isi table form -->
                            <!-- <tr>
                                <td class="py-1" colspan="9" style="border: 1px solid black; height:2px"></td>
                            </tr> -->
                            
                        </tbody>
                        
                    
                    </table>
                </div>
                

                <!-- form -->
                <form class="form-horizontal" action="proses.php" method="POST">
                    
                    <div class="table-responsive text-uppercase" >
                        <table class="table table-hover" rules="cols" style="border:1px solid black">
                            <thead >
                                <tr class="bg-danger text-white" rules="col" >
                                    <th scope="row" class="py-0" rowspan="2" rules="cols" style="border:1px solid black">#</th>
                                    <th scope="row" class="py-0" rowspan="2" rules="cols" style="border:1px solid black">NPK</th>
                                    <th scope="row" class="py-0" rowspan="2" rules="cols" style="border:1px solid black">Nama</th>
                                    <th scope="row" class="py-0" colspan="2" rules="cols" style="border:1px solid black">Jam Overtime</th>
                                    <th scope="row" class="py-0" rowspan="2" rules="cols" style="border:1px solid black">Activity</th>
                                    <th scope="row" class="py-0" rowspan="2" rules="rows" style="border-bottom:1px solid black">Kode</th>
                                    <th scope="row" class="py-0" rowspan="2" style="border-bottom:1px solid black"></th>
                                </tr>
                                <tr class="bg-danger text-white">
                                    <th scope="row" class="py-0" rules="cols" style="border:1px solid black">Mulai</th>
                                    <th scope="row" class="py-0" rules="cols" style="border:1px solid black">Selesai</th>
                                    
                                </tr>
                            </thead>

                            <tbody class="after-add-more" style="border:1px solid black">
                                <?php

                                $s_otMp = mysqli_query($link, $q_otMp)or die(mysqli_error($link));
                                // echo $q_otMp;
                                if($countOtMp = mysqli_num_rows($s_otMp) > 0){
                                    $noo = 1;
                                    while($d_otMp = mysqli_fetch_assoc($s_otMp)){
                                        $s_rqster = mysqli_query($link,"SELECT * FROM karyawan WHERE npk = '$d_otMp[requester]' ")or die(mysqli_error($link));
                                        $d_rqstr = mysqli_fetch_assoc($s_rqster);
                                    ?>
                                    <tr >
                                        <th scope="col" class="p-1" id="jumlah_form"><?=$noo++?></th>
                                        
                                        <td style="width:100px" class="form-group p-1 no-border ">
                                            <input type="hidden" class="form-control"  type="text" name="id[]" value="<?=$d_otMp['id_lembur']?>" required="true" />
                                            <input class="form-control text-center px-0 bg-transparent" min="1" type="text" name="npk[]" value="<?=$d_otMp['npk']?>" required="true"  readonly/>
                                        </td>
                                        <td style="width: 800px" class="form-group  p-1 no-border">
                                            <input class="form-control bg-transparent" type="text" name="nama[]" required="true" value="<?=$d_otMp['nama']?>" readonly/>
                                        </td>
                                        <td class="form-group text-center no-border  p-1 " style="width: 150px; ">
                                            <input type="hidden" class="form-control"  type="text" name="date_in[]" value="<?=$d_otMp['tgl_mulai']?>" required="true" />
                                            <input style="height:40px" class="form-control datepicker bg-transparent" data-date-format="HH:mm:ss" type="text" name="mulai[]" value="<?=$d_otMp['waktu_mulai']?>" required="true" />
                                        </td>
                                        <td class="form-group  text-center p-1 no-border" style="width: 150px">
                                            <input type="hidden" class="form-control"  type="text" name="date_out[]" value="<?=$d_otMp['tgl_selesai']?>" required="true" />
                                            <input style="height:40px" class="form-control datepicker no-border bg-transparent" data-date-format="HH:mm:ss" type="text" name="selesai[]" value="<?=$d_otMp['waktu_selesai']?>" required="true" />
                                        </td>
                                        <td class=" form-group p-1 no-border" style="width: 700px">
                                            <input type="hidden" class="form-control"  type="text" name="requester[]" value="<?=$d_otMp['requester']?>" required="true" />
                                            <input type="hidden" class="form-control"  type="text" name="tanggal_input[]" value="<?=$d_otMp['tanggal_input']?>" required="true" />
                                            <input  class="form-control bg-transparent" type="text" name="activity[]" required="true" value="<?=$d_otMp['activity']?>" required="true"/> 
                                        
                                        </td>
                                        <td class=" form-group p-1 text-right no-border" >
                                            <select style="width:100px" class=" form-control  p-0 mx-0 bg-transparent no-border" data-size="5" type="text" name="jobcode[]" data-container="" data-style="btn btn-md btn-outline-warning bg-white no-border bg-transparent" title="Kode" required="true">
                                            <?php

                                                $s_jc = mysqli_query($link, "SELECT * FROM kode_lembur")or die(mysqli_error($link));
                                                while($d_jc = mysqli_fetch_assoc($s_jc)){
                                                    $selected = ($d_jc['kode_lembur'] == $d_otMp['kode_job'])? "selected" : "";
                                                    echo "<option $selected  title\"$d_jc[kode_lembur]\" value=\"$d_jc[kode_lembur]\">$d_jc[kode_lembur]</option>";
                                                }
                                            ?>
                                            </select>
                                        </td>
                                        <td class="text-right form-group text-nowrap p-1 " style="width: 100px">
                                            <a href="proses.php?del=<?=$d_otMp['id_lembur']?>" type="button" rel="tooltip" class="btn btn-danger btn-round btn-icon btn-link align-top">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }else{
                                    echo "<tr><td class=\"text-center\" colspan=\"8\">Man Power belum dipilih</td></tr>";
                                }
                                ?>
                                
                            </tbody>
                            
                        </table>
                        
                    </div>
                    
                    <div class="box pull-left">
                        <button type="reset" class="btn btn-outline-warning  btn-warning">
                            <span class="btn-label">
                                <i class="nc-icon nc-settings-gear-65"></i>
                            </span>
                            Reset
                        </button>
                    </div>
                    <div class="box pull-right">
                        <button class="btn btn-danger" name="save" type="submit" value="save">
                            <span class="btn-label">
                                <i class="nc-icon nc-settings-gear-65"></i>
                            </span>
                            Save
                        </button>
                        <button class="btn btn-primary" name="request" type="submit">
                            <span class="btn-label">
                                <i class="nc-icon nc-settings-gear-65"></i>
                            </span>
                            Request Submit
                        </button>
                    </div>
                </form>
                
            </div>
            <div class="card-footer ">
                <div class="stats">
                </div>
            </div>
        </div>

    </div>
</div>
<?php

$s_otMpRequest = mysqli_query($link, $q_otRequest)or die(mysqli_error($link));
if(mysqli_num_rows($s_otMpRequest) > 0){
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Pengajuan Sebelumnya</h5>
                <div class="table-responsive text-uppercase" >
                    <table class="table table-hover" rules="cols" style="border:1px solid black">
                        <thead >
                            <tr class="bg-danger text-white" rules="col" >
                                <th scope="row" class="py-0" rowspan="2" rules="cols" style="border:1px solid black">#</th>
                                <th scope="row" class="py-0" rowspan="2" rules="cols" style="border:1px solid black">NPK</th>
                                <th scope="row" class="py-0" rowspan="2" rules="cols" style="border:1px solid black">Nama</th>
                                <th scope="row" class="py-0" colspan="2" rules="cols" style="border:1px solid black">Jam Overtime</th>
                                <th scope="row" class="py-0" rowspan="2" rules="cols" style="border:1px solid black">Activity</th>
                                <th scope="row" class="py-0" rowspan="2" rules="rows" style="border-bottom:1px solid black">Kode</th>
                                <th scope="row" class="py-0" rowspan="2" rules="rows" style="border-bottom:1px solid black">Status</th>
                            </tr>
                            <tr class="bg-danger text-white">
                                <th scope="row" class="py-0" rules="cols" style="border:1px solid black">Mulai</th>
                                <th scope="row" class="py-0" rules="cols" style="border:1px solid black">Selesai</th>
                            </tr>
                        </thead>

                        <tbody class="after-add-more" style="border:1px solid black">
                            <?php

                            // echo $q_otMp;
                            
                                $noo = 1;
                                while($d_otMp = mysqli_fetch_assoc($s_otMpRequest)){
                                    $s_rqster = mysqli_query($link,"SELECT * FROM karyawan WHERE npk = '$d_otMp[requester]' ")or die(mysqli_error($link));
                                    $d_rqstr = mysqli_fetch_assoc($s_rqster);
                                    $info = sumary($d_otMp['stat_approve'], $d_otMp['status'], 'info');
                                    $color = sumary($d_otMp['stat_approve'], $d_otMp['status'], 'color');
                                ?>
                                <tr >
                                    <th scope="col" class="p-1 text-<?=$color?>" ><?=$noo++?></th>
                                    
                                    <td style="width:100px" class="form-group no-border text-<?=$color?>"><?=$d_otMp['npk']?></td>
                                    <td style="width: 800px" class="form-group  no-border text-<?=$color?>"><?=$d_otMp['nama']?></td>
                                    <td class="form-group text-center no-border text-<?=$color?>" style="width: 150px; "><?=$d_otMp['waktu_mulai']?></td>
                                    <td class="form-group  text-center no-border text-<?=$color?>" style="width: 150px"><?=$d_otMp['waktu_selesai']?></td>
                                    <td class=" form-group no-border text-<?=$color?>" style="width: 700px"><?=$d_otMp['activity']?></td>
                                    <td class=" form-group  no-border text-<?=$color?>" ><?=$d_otMp['kode_job']?></td>
                                    <td class=" form-group  no-border text-<?=$color?>" >
                                        <?=$info?>
                                    </td>
                                    
                                </tr>
                            <?php
                                }
                            ?>
                            
                        </tbody>
                        
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
<!-- fungsi javascript untuk menampilkan form dinamis  -->
<!-- penjelasan :
saat tombol add-more ditekan, maka akan memunculkan div dengan class copy -->

<?php


?>

    <?php
//footer
    include_once("../footer.php");
?>
  <script>
    $(document).ready(function() {
       
        $("#area").change(function(){
      	var org = $('#area').val();
        var shf = $('#shf').val();
        
          	$.ajax({
          		type: 'POST',
              	url: "ajax/get_mp.php",
              	data: {'org': org, 'shf': shf},
              	cache: false,
              	success: function(msg){
                  $(".data-mp").html(msg);
                }
            });

        });
    })

</script>
<script>
    function setFormValidation(id) {
      $(id).validate({
        highlight: function(element) {
          $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');  
          $(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
        },
        success: function(element) {
          $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
          $(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
        },
        errorPlacement: function(error, element) {
          $(element).closest('.form-group').append(error);
        },
      });
    }

    $(document).ready(function() {
      setFormValidation('#RegisterValidation');
      setFormValidation('#TypeValidation');
      setFormValidation('#LoginValidation');
      setFormValidation('#RangeValidation');
    });
  </script>
<!-- ajax untuk modal -->

<script type="text/javascript">
    $(function () {
       
        $('#DateTimePicker1').datetimepicker({format: 'DD/MM/YYYY'});
        $('#DateTimePicker2').datetimepicker({format: 'DD/MM/YYYY',
                useCurrent: true //Important! See issue #1075
        });
        <?php
        $minDate = date('d/m/Y', strtotime(dateToDB($ot_date)));
        $maxDate = date('d/m/Y', strtotime('+1 Days', strtotime(dateToDB($ot_date))));
        ?>
        $('#DateTimePicker1').data("DateTimePicker").minDate('<?=$minDate?>');
        $('#DateTimePicker1').data("DateTimePicker").maxDate('<?=$maxDate?>');
        $('#DateTimePicker2').data("DateTimePicker").minDate('<?=$minDate?>');
        $('#DateTimePicker2').data("DateTimePicker").maxDate('<?=$maxDate?>');

        $("#DateTimePicker1").on("dp.change", function (e) {
            $('#DateTimePicker2').data("DateTimePicker").minDate(e.date);
        });
    });
    
</script>

<?php
    
    //footer
        include_once("../endbody.php");
 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
  

