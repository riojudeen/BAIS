<?php
include('modal.php');

$_SESSION['thn'] = (isset($_POST['tahun']))? $_POST['tahun'] : date('Y');
$_SESSION['startM'] = (isset($_POST['start']))? $_POST['start'] : date('m');
$_SESSION['endM'] = (isset($_POST['end']))? $_POST['end'] : date('m');
$y = $_SESSION['thn'];
// echo $y."<br>";
$sM = $_SESSION['startM'];
$eM = $_SESSION['endM'];
// mysqli_query($link, "UPDATE working_days SET ket = 'DOP' WHERE ket = 'DOT' ");
// echo $_SESSION['startM']."<br >";
// echo $_SESSION['endM']."<br >";
$tahun = $_SESSION['thn'];

$tanggalAwal = date('Y-m-d', strtotime($y.'-'.$sM.'-01'));
// echo "tanggal awal : ".$tanggalAwal."<br>";
$tanggalAkhir = date('Y-m-t', strtotime($y.'-'.$eM.'-01'));
// echo "tanggal akhir : ". $tanggalAkhir."<br>";


$count_awal = date_create($tanggalAwal);
$count_akhir = date_create($tanggalAkhir);
if($sM <= $eM){
    $hari = date_diff($count_awal,$count_akhir)->days +1;;
}else{
    $hari = 0;
}

$awal = $blnAwal = strtotime($tanggalAwal); // merubah tanggal awal menjadi format timestamp agar bisa dijumlahkan;
$akhir =  strtotime($tanggalAkhir); // merubah tanggal akhir menjadi format timestamp agar bisa dijumlahkan;
// echo $awal."<br>";
// echo $akhir."<br>";

$i = 0; //index awal 0 agar array di dalam looping dimulai dari 1
if($hari > 0 ){
    while($blnAwal <= $akhir){
        $tgl = date('Y-m-d', $blnAwal);
        $blnAwal = strtotime("+1 day", $blnAwal);
        $hari = explode(' ', $tgl);
        $array_tgl[$i++] = $tgl;
        $color = ($hari['0'] == "Sun," || $hari['0'] == "Sat," ) ? "background: rgba(211, 84, 0, 0.3)" : "";
        // echo $tgl."<br>";
    }
}else{
    $array_tgl = array();
}
// echo count($array_tgl);


$bln = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","Sepember","Oktober","November","Desember");
$totalBln = count($bln);

?>
<div class="collapse" id="collapseExample">
    <div class="row ">
        <div class="col-md-12">
            <form action="proses/prosesAttPort.php" method="POST">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title pull-left">Import Data Excel</h5>
                    <div class="pull-right">   
                        <a  class="btn btn-danger btn-icon btn-round btn-link" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="nc-icon nc-simple-remove"></i></a>
                    </div>
                </div>
                <hr>
                <div class="card-body text-center">
                    <form method="post" enctype="multipart/form-data" action="proses/import.php">
                        <div class="form-group border rounded py-auto">
                            
                            <div class="fileinput fileinput-new text-center " data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail mt-4 mx-0" style="min-width:300px">
                                    <input type="text" class="form-control mx-0">
                                </div>
                                <div>
                                    <span class="btn btn-outline-default btn-round btn-rose btn-file">
                                    <span class="fileinput-new ">Select File</span>
                                    <span class="fileinput-exists">Change</span>
                                        <input type="file"  name="file_import" />
                                    </span>
                                    <a href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right">Upload File Excel</button>
                    </form>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="row ">
	<div class="col-md-12 ">
		<div class="card">
			<div class="card-header">
				<h5 class="title pull-left">Working Calendar</h5>
                <div class="box pull-right">
                    <!-- <a href="file/FormatUpdate_MP.xlsx" class="btn btn-warning btn-icon btn-round" data-toggle="tooltip" data-placement="bottom" title="Download Format">
                        <i class="nc-icon nc-paper"></i>
                    </a> -->
                    <button class="btn btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <span class="btn-label">
                            <i class="nc-icon nc-cloud-download-93"></i>
                        </span>
                    Import
                    </button>
                    
                    <a href="proses/export.php?export=mp" class="btn btn-success" name="export" data-toggle="tooltip" data-placement="bottom" title="Export to Excel File">
                        <span class="btn-label">
                            <i class="nc-icon nc-cloud-upload-94"></i>
                            
                        </span>
                        Export
                    </a>
                    <a href="shiftsettings/index.php" class="btn btn-danger" name="shift" data-toggle="tooltip" data-placement="bottom" title="Penjadwalan Shift">
                        <span class="btn-label">
                            <i class="nc-icon nc-cloud-upload-94"></i>
                            
                        </span>Perubahan Shift
                    </a>
                </div>
			</div>
            
            
			<div class="card-body">
            
                <form method="POST">
                    <div class="box pull-left">
                        <div class="input-group border-1">
                            <div class="input-group-prepend py-0 m-0 py-0 ">
                                <div class="input-group-text">
                                    <i class="nc-icon nc-calendar-60"></i>
                                </div>
                            </div>
                            <!-- <input  type="text" name="tahun" class=" form-control datepicker" data-date-format="MM-YYYY"> -->
                            <select type="date" name="start" class="form-control pl-2" >
                                <option Disabled>Pilih Bulan</option>
                                <?php
                                $i =0;
                                foreach($bln AS $namaBln){
                                    $i++;
                                    $selectBln = ($i == $sM)?"selected":"";
                                    
                                    echo "<option  $selectBln value=\"$i\">$namaBln</option>";
                                }
                                ?>
                            </select>
                            <div class="input-group-append ml-0 px-auto ">
                                <div class="input-group-text pl-2">
                                    <i class="">to</i>
                                </div>
                            </div>
                            <select type="date" name="end" class="form-control pl-2" >
                                <option Disabled>Pilih Bulan</option>
                                <?php
                                $i =0;
                                foreach($bln AS $namaBln){
                                    
                                    $i++;
                                    $selectBln = ($i == $eM)?"selected":"";
                                    echo "<option $selectBln value=\"$i\">$namaBln</option>";
                                }
                                ?>
                            </select>
                            <div class="input-group-prepend px-auto">
                                <div class="input-group-text">
                                    
                                </div>
                            </div>
                           
                            <select type="text" name="tahun" class=" form-control">
                            <option Disabled>Tahun</option>
                            <?php
                            $thnPertama = 2021;
                            for($i=date("Y"); $i>=$thnPertama; $i--){
                                $selectThn = ($i == $tahun)?"selected":"";
                                echo "<option $selectThn value=\"$i\">$i</option>";
                            }
                            ?>
                            </select>
                            <input type="submit" name="sort" class="btn-icon btn btn-round p-0 ml-2 my-auto" value="go" >
                            
                        </div>
                        
                        <!-- <div class="col-4">
                            <input class="btn btn-icon btn-round" name="sort" value="go">
                        </div> -->
                    </div>
                </form>
                <!-- <form method="POST">
                    <div class="box pull-right">
                        <div class="input-group no-border">
                            <input type="text" name="cari" class="form-control" placeholder="Cari nama atau npk..">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="nc-icon nc-zoom-split"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> -->
                <hr class="row col-12 mb-0">
                <div class="card-plain row col-12 mt-3">
                    <span class="badge badge-pill badge-info mr-2" style="width:150px">
                        DAY SHIFT
                    </span>
                    <span class="badge badge-pill badge-danger mr-2" style="width:150px">
                    NIGHT SHIFT 
                    </span>
                    <span class="badge badge-pill badge-warning mr-2" style="width:150px">
                    HOLIDAY
                    </span>
                    <span class="badge badge-pill badge-light text-secondary mr-2" style="width:150px">
                    <i class="nc-icon nc-check-2 "></i> Production
                    </span>
                    <span class="badge badge-pill badge-light text-secondary mr-2" style="width:150px">
                    <i class="nc-icon nc-simple-remove "></i> No Production
                    </span> 
                </div>
                <hr class="row col-12 mt-2">
                <form method="post" name="proses" action="" >
                <div class="table-responsive">
                    <table class="table table-bordered table_org" id="uangmakan" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th rowspan="2">#</th>
                                
                                <th colspan="2" rowspan="2" class="text-nowrap">Working Day Shift</th>
                                <?php
                                
                                foreach($array_tgl AS $tanggal){
                                   ?>
                                    <th><?=tgl_bulan($tanggal)?></th>
                                   <?php
                                }
                                ?>
                                <th rowspan="2" class="text-right">Action</th>
                                <th rowspan="2" class="text-right">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="allcek">
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                
                                <?php
                                
                                foreach($array_tgl AS $tanggal){
                                   ?>
                                    <th><?=hari_singkat($tanggal)?></th>
                                   <?php
                                }
                                ?>
                                
                            </tr>
                        </thead>
                        <tbody class="text-uppercase">
                        <?php
                        $noUrut = 1;
                        $index = 0;
                        $sqlWS = mysqli_query($link, "SELECT * FROM working_hours GROUP BY code_name")or die(mysqli_error($link));
                        
                        $sqlSHF = mysqli_query($link, "SELECT * FROM shift ORDER BY id_shift")or die(mysqli_error($link));
                        $totalWS = mysqli_num_rows($sqlSHF)or die(mysqli_error($link));
                        $hari_ini = date('Y-m-d');
                        if(mysqli_num_rows($sqlWS) > 0){
                            while($dataWS = mysqli_fetch_assoc($sqlWS)){
                            ?>
                            <tr>
                                <td rowspan="<?=$totalWS?>"><?=$noUrut++?></td>
                                <td rowspan="<?=$totalWS?>" class="text-center"><?="<i class=\"nc-icon nc-sun-fog-29\"></i><br>".$dataWS['code_name']?></td>
                                <?php
                                $sqlS = mysqli_query($link, "SELECT * FROM shift ORDER BY id_shift")or die(mysqli_error($link));
                                while($shift_ = mysqli_fetch_assoc($sqlS)){
                                    ?>
                                        <td><?=$shift_['id_shift']?></td>
                                    <?php
                                    foreach($array_tgl AS $tgl_){
                                        $sqlHolidays = mysqli_query($link, "SELECT * FROM holidays WHERE `date` = '$tgl_' ")or die(mysqli_error($link));
                                        $color = (mysqli_num_rows($sqlHolidays) > 0)?"bg-light":"";
                                        $colorToday = ($tgl_ == $hari_ini)?"bg-light":"";
                                        $sqlWD = mysqli_query($link, "SELECT working_hours.id AS id_wh,
                                        working_hours.code_name AS code_wh,
                                        working_days.wh AS wh,
                                        working_days.ket AS ket,
                                        working_days.id AS id
                                        
                                         FROM working_days LEFT JOIN working_hours ON working_hours.id = working_days.wh 
                                         WHERE working_days.shift = '$shift_[id_shift]' AND working_days.date = '$tgl_' ")or die(mysqli_error($link));
                                        while($wd_ = mysqli_fetch_assoc($sqlWD)){
                                            if($wd_['code_wh'] == $dataWS['code_name'] ){
                                                $colorTbl = "info";
                                                $icon = "nc-check-2";
                                                 
                                            }else{
                                                $colorTbl = "danger";
                                                $icon = "nc-simple-remove";
                                            }
                                            $colorTbl = ($wd_['ket'] == 'HOP')? "warning": $colorTbl;
                                            ?>
                                            <td class="text-center <?=$color." ".$colorToday?> "><a href="wd/edit.php?id=<?=$wd_['id']?>" class="stretched-link btn btn-<?=$colorTbl?> btn-icon card bg-<?=$colorTbl?> m-0" data-toggle="modal" data-id="<?=$wd_['id']?>" id="<?=$wd_['id']?>" data-target="#modal" ><i class="nc-icon <?=$icon?>"></i></a></td>
                                            <?php 
                                        }
                                        
                                    }
                                    ?>
                                    <td class="text-right text-nowrap">
                                    <a href="editAttPort.php?t=portAtt&id=" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                    <a href="tes.php?t=portAtt&id=" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove" data-id="form_absensi"><i class="fa fa-times"></i></a>
                                    </td>

                                    <td class="text-right">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input cek" name="mpchecked[]" type="checkbox" value="<?=$data[$i]['npk']?>">
                                            <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </td>
                                    </tr>
                                    <?php
                                }
                                
                                ?>
                            
                            <?php
                            
                            }
                        }else{
                            echo "<tr><td class=\"text-center\" colspan=\"10\">Tidak ditemukan data di database</td></tr>";
                        }
                        ?>
                        </tbody>
                        
                    </table>
                </div>
                <hr class="row col-12 mb-0">
                <div class="card-plain row col-12 mt-3 ">
                    <span class="badge badge-pill badge-info mr-2" style="width:150px">
                        DAY SHIFT
                    </span>
                    <span class="badge badge-pill badge-danger mr-2" style="width:150px">
                    NIGHT SHIFT 
                    </span>
                    <span class="badge badge-pill badge-warning mr-2" style="width:150px">
                    HOLIDAY
                    </span>
                    <span class="badge badge-pill badge-light text-secondary mr-2" style="width:150px">
                    <i class="nc-icon nc-check-2 "></i> Production
                    </span>
                    <span class="badge badge-pill badge-light text-secondary mr-2" style="width:150px">
                    <i class="nc-icon nc-simple-remove "></i> No Production
                    </span> 
                </div>
                <hr class="row col-12 mt-2">
                
                <div class="box pull-right">
                    <button class="btn btn-success editall ">
                        <span class="btn-label">
                            <i class="nc-icon nc-check-2"></i>
                        </span>
                        Edit
                    </button>
                    <button  class="btn btn-danger  deleteall" >
                        <span class="btn-label">
                            <i class="nc-icon nc-simple-remove" ></i>
                        </span>    
                        Delete
                    </button>

                </div>
                </form>
            </div>
            <div class="card-footer">
                
            </div>
		</div>
	</div>
</div>
