<?php
$_SESSION['startD'] = (isset($_POST['start']))? dateToDB($_POST['start']) : date('Y-m-01');
$_SESSION['endD'] = (isset($_POST['end']))? dateToDB($_POST['end']) : date('Y-m-d');

$sD = $_SESSION['startD'];
$eD = $_SESSION['endD'];

$tanggalAwal = date('Y-m-d', strtotime($sD));
// echo "tanggal awal : ".$tanggalAwal."<br>";
$tanggalAkhir = date('Y-m-d', strtotime($eD));
// echo "tanggal akhir : ". $tanggalAkhir."<br>";

$count_awal = date_create($tanggalAwal);
$count_akhir = date_create($tanggalAkhir);

if($sD <= $eD){
    $hari = date_diff($count_awal,$count_akhir)->days +1;
}else{
    $hari = 0;
}

$awal = $blnAwal = strtotime($tanggalAwal); // merubah tanggal awal menjadi format timestamp agar bisa dijumlahkan;
$akhir =  strtotime($tanggalAkhir); // merubah tanggal akhir menjadi format timestamp agar bisa dijumlahkan;

$bln = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","Sepember","Oktober","November","Desember");
$totalBln = count($bln);

?>
<form method="POST">
<div class="row">
    <div class="col-md-12" >
        <div class="card bg-transparent" >
            <div class="card-body bg-transparent">
                <div class="row">
                    <div class="col-md-5 border-2">
                        <div class="input-group border-2 bg-transparent no-border">
                            <div class="input-group-prepend ">
                                <div class="input-group-text bg-transparent">
                                    <i class="nc-icon nc-calendar-60"></i>
                                </div>
                            </div>
                            <!-- <input  type="text" name="tahun" class=" form-control datepicker" data-date-format="MM-YYYY"> -->
                            <input type="text" name="start" class="form-control bg-transparent datepicker" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tanggalAwal)?>">
                                
                            <div class="input-group-prepend ml-0 bg-transparent">
                                <div class="input-group-text px-2 bg-transparent">
                                    <i>to</i>
                                </div>
                            </div>
                            <input type="text" name="end" class="form-control bg-transparent datepicker" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tanggalAkhir)?>">
                            
                            <input type="submit" name="sort" class="btn-icon btn btn-round p-0 ml-2 my-auto " value="go" >
                            
                        </div>
                        
                        <!-- <div class="col-4">
                            <input class="btn btn-icon btn-round" name="sort" value="go">
                        </div> -->
                    </div>
                    <div class="col-md-7 border-2 ">
                        <div class="box float-right">
                        <?php
                        if(isset($_GET['sumary'])){
                            $lnk = 'manpower.php';
                            $icn = 'nc-bullet-list-67';
                        }else{
                            $lnk = '?sumary';
                            $icn = 'nc-bookmark-2';
                        }
                        ?>
                            <a href="<?=$lnk?>" type="button" class="btn btn-primary btn-icon btn-round align-center align-bottom generate" data-toggle="modalgenerate" data-target=".bd-example-modal-xl">
                                <span class="btn-label">
                                    <i class="nc-icon <?=$icn?>"></i>
                                </span>
                            </a>
                        </div>
                        <p class="float-right mr-2">
                            <button id="" type="submit" name="cari" class="btn btn-icon btn-default btn-outline-default btn-round" type="button" data-toggle="collapse" data-target="#absensi" aria-expanded="false" aria-controls="absensi">
                                <i class="nc-icon nc-zoom-split "> </i>
                            </button>   
                        </p>
                        
                        <div class="mr-2 my-0 py-0 float-right order-2">
                            <div class="input-group bg-transparent">
                                <select type="text" name="area[]" class="bg-transparent selectpicker" data-title="area" data-style="btn btn-outline-default" placeholder="Cari nama atau npk.." multiple>
                                    <?php
                                    while($area = mysqli_fetch_assoc($dataArea)){
                                        $select = (in_array($area['id_area'], $array_area))?"selected":"";
                                        ?>
                                        
                                        <option <?=$select?> data-subtext="<?=$area['id_area']?>"  value="<?=$area['id_area']?>"><?=$area['nama_area']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mr-2 my-0 py-0 float-right order-3 ">
                            <div class="input-group bg-transparent">
                                <select type="text" name="shift[]" class="bg-transparent selectpicker" data-title="shift" data-style="btn btn-outline-default" placeholder="Cari nama atau npk.." multiple>
                                    <?php
                                    $sqlShift = mysqli_query($link , "SELECT * FROM shift");
                                    while($dataShift = mysqli_fetch_assoc($sqlShift)){
                                        $select = (in_array($dataShift['id_shift'], $array_shift))?"selected":"";
                                        ?>
                                        <option <?=$select?> value="<?=$dataShift['id_shift']?>"><?=$dataShift['shift']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                       
                        <!-- <div class="col-4">
                            <input class="btn btn-icon btn-round" name="sort" value="go">
                        </div> -->
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
</form>