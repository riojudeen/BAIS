<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Portal Data Overtime";
    include_once("../../header.php");
    // mysqli_query($link, "DELETE FROM ot_cost ");

    $_SESSION['startD'] = (isset($_GET['start']))? dateToDB($_GET['start']) : date('Y-m-01');
    $_SESSION['endD'] = (isset($_GET['end']))? dateToDB($_GET['end']) : date('Y-m-d');

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

    // foreach($array_tgl as $tgl){
    //     echo $tgl."<br>";
    // }


    $awal = $blnAwal = strtotime($tanggalAwal); // merubah tanggal awal menjadi format timestamp agar bisa dijumlahkan;
    $akhir =  strtotime($tanggalAkhir); // merubah tanggal akhir menjadi format timestamp agar bisa dijumlahkan;

    $bln = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","Sepember","Oktober","November","Desember");
    $totalBln = count($bln);

    $startD = "2021-07-01";
    $endD = "2021-08-31";
    $qryDept = mysqli_query($link, "SELECT * FROM dept_account GROUP BY id_dept_account")or die(mysqli_error($link));

    
    //unit


    
    while($dataDept = mysqli_fetch_assoc($qryDept)){
        $qryUnit = mysqli_query($link, "SELECT * FROM unit_type  WHERE id_dept = '$dataDept[id_dept_account]' ")or die(mysqli_error($link));
        $totalMenit = 0;
        while($dataUnit = mysqli_fetch_assoc($qryUnit)){
            // echo $dataUnit['id_unit'];
            $qryProd = mysqli_query($link, "SELECT * FROM unit_prod WHERE id_unit = '$dataUnit[id_unit]' ")or die(mysqli_error($link));
            while($dataProd = mysqli_fetch_assoc($qryProd)){
                // echo $dataProd['id_prod'];
                $qryProdArea = mysqli_query($link, "SELECT * FROM unit_prodarea WHERE id_prod = '$dataProd[id_prod]' ")or die(mysqli_error($link));
                while($dataProdArea = mysqli_fetch_assoc($qryProdArea)){
                    // echo $dataProdArea['id'];
                    $qryOt = mysqli_query($link, "SELECT SUM(overtime) AS ot FROM ot_cost WHERE id_prodarea = '$dataProdArea[id]' ")or die(mysqli_error($link));
                    $dataOt = mysqli_fetch_assoc($qryOt);
                    $totalMenit += $dataOt['ot'];
                }
            }
        }
        $dataarray[$dataDept['id_dept_account']] = [
            'menit' => $totalMenit
        ];
        
    }
    // var_dump($dataarray);

?>
<!-- modal import data cost -->
<form method="post" id="form_upload" enctype="multipart/form-data" action="proses.php">
    <div class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalfilter">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title text-left" id="exampleModalLongTitle">Upload File</h5>
                </div>
                
                <div class="modal-body px-3">
                    <div class="row">
                        
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-md-12 col-form-label">Department</label>
                                        <select name="dept" id="dept" class="form-control">
                                            <option disabled>Pilih Department</option>
                                            <?php
                                            $query = "SELECT * FROM dept_account";
                                            $sql = mysqli_query($link, $query)or die(mysqli_error($link));
                                            if(mysqli_num_rows($sql) > 0){
                                                while($data = mysqli_fetch_assoc($sql)){
                                                    ?>
                                                    <option value="<?=$data['id_dept_account']?>"><?=$data['department_account']?></option>
                                                    <?php
                                                }
                                            }else{
                                                ?>
                                                <option>Tidak Ada Data Department</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <!-- <input type="text" class="form-control" placeholder=".col-md-4"> -->
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12 col-form-label">Production Unit</label>
                                        <select name="prod" id="prod" class="form-control">
                                            <option disabled>Pilih Unit Produksi</option>
                                            
                                        </select>
                                        <!-- <input type="text" class="form-control" placeholder=".col-md-4"> -->
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12 col-form-label">Production Area</label>
                                        <select name="prodarea" id="prodarea" class="form-control">
                                            <option disabled>Pilih Area Produksi</option>
                                            
                                        </select>
                                        <!-- <input type="text" class="form-control" placeholder=".col-md-4"> -->
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                    <label class="col-md-12 col-form-label">Tanggal Kerja</label>
                                        <input type="text" class="form-control datepicker tanggal"  name="tanggal" id="tanggal" data-date-format="DD/MM/YYYY" placeholder="tanggal">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-md-12 col-form-label">Work Shift</label>  
                                        <select name="area" id="workingshift" class="form-control ">
                                            <option>Pilih Shift Kerja</option>
                                        </select>
                                        <!-- <input type="text" class="form-control" placeholder=".col-md-4"> -->
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card-body text-center">
                        
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
                                            <input type="file" name="file_import" id="file_export"/>
                                        </span>
                                        <a href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary" id="load">Load Data</button>
                            <div class="data_load">

                            </div>
                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="filter" class="btn btn-primary">Submit</button>
                </div>
            
            </div>
        </div>
    </div>
</form>
<div class="row">
    <?php
    foreach($dataarray as $dept => $keydept){
        ?>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats bg-success text-white">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fa fa-briefcase text-white"></i>
                                
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category text-white"><?=$dept?></p>
                                <?php
                                    $qry_rate = mysqli_query($link, "SELECT * FROM ot_rate WHERE id_dept = '$dept' GROUP BY id")or die(mysqli_error($link));
                                    $sql_rate = mysqli_fetch_assoc($qry_rate);
                                    $ot_rate = $sql_rate['ot_rate'];
                                ?>
                                <p class="card-title"> <?=rupiah($keydept['menit']*$ot_rate/1000/1000)?>
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-footer ">
                    <div class="stats">
                        <a class="stretched-link view_data text-white" id="masuk" >x Rp.1000.000</a>
                        <a class="pull-right text-white" id="masuk" ><?="OT Rate "?><?=rupiah($ot_rate)?></a> 
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<!-- <form action="" method="get"> -->
<div class="row">
    <div class="col-md-12" >
        <div class="card bg-transparent" >
            <div class="card-body bg-transparent">
            
                <div class="row">
                    <form method="get" class="col-md-5 border-2">
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
                    </form>
                    <div class="col-md-7 border-2 ">
                        
                        
                        <div class="box pull-right">
                        
                        <a href="<?=base_url('file/template/format_overtime.xlsx')?>" class="btn btn-warning btn-icon btn-round" data-toggle="tooltip" data-placement="bottom" title="Download Format">
                            <i class="nc-icon nc-paper"></i>
                        </a>
                        <a href="overtime/index.php" class="btn btn-danger btn-icon btn-round" name="export" data-toggle="tooltip" data-placement="bottom" title="Production Result">
                            <span class="btn-label">
                                <i class="nc-icon nc-money-coins"></i>
                            </span>
                        </a>
                        <button class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg">
                            <span class="btn-label">
                                <i class="nc-icon nc-cloud-download-93"></i>
                            </span>
                        Import
                        </button>
                        
                        <a href="../portOt.php" class="btn btn-default" >
                        Back
                            <span class="btn-label">
                                <i class="nc-icon nc-minimal-right"></i>
                            </span>
                            
                        </a>
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
<?php
$otRate = 72540;
$qryCostUnit = mysqli_query($link, "SELECT unit_type.id_unit AS id_unit,
unit_type.model_name AS model,
unit_type.model_alias AS alias,
unit_type.id_dept AS id_dept
FROM unit_type ")or die(mysqli_error($link));
while($dataCostUnit = mysqli_fetch_assoc($qryCostUnit)){
    $menit = 0;
    // echo $dataCostUnit['model']."-";
    $qryUnitProdArea = mysqli_query($link, "SELECT 
    unit_prod.id_prod AS unit_prod,
    unit_prod.prod_alias AS prod_alias,
    unit_prod.prod_name AS prod_name,
    unit_prod.id_unit AS prod_id_unit,
    unit_prodarea.id AS id_prodarea,
    unit_prodarea.id_group AS group_prodarea,
    unit_prodarea.id_prod AS id_prod_prodarea FROM unit_prodarea
    JOIN unit_prod ON unit_prodarea.id_prod = unit_prod.id_prod WHERE unit_prod.id_unit = '$dataCostUnit[id_unit]' GROUP BY unit_prodarea.id")or die(mysqli_error($link));
    while($dataProdarea = mysqli_fetch_assoc($qryUnitProdArea)){
        // echo $dataProdarea['id_prodarea']."-";
        $qrySum = mysqli_query($link, "SELECT SUM(overtime) AS ot FROM ot_cost WHERE id_prodarea = '$dataProdarea[id_prodarea]' AND (`date` BETWEEN '$tanggalAwal' AND '$tanggalAkhir' )")or die(mysqli_error($link));
        $totalMenit = mysqli_fetch_assoc($qrySum);
        $menit = $menit + $totalMenit['ot'];
        
    }
    
    $qryUnitResult = mysqli_query($cnt, "SELECT SUM(a)  AS `a`,SUM(b)  AS `b` FROM production  WHERE unit = '$dataCostUnit[id_unit]' AND (`date` BETWEEN '$tanggalAwal' AND '$tanggalAwal')")or die(mysqli_error($cnt));
    $result = mysqli_fetch_assoc($qryUnitResult);
    $prod_result = $result['a']+$result['b'];

    
    // echo $menit." - ";
    // echo $dataCostUnit['id_unit']." - ";
    // echo $prod_result."<br>";
}
$in = 0;
$qryModelUnit = mysqli_query($link, "SELECT unit_type.id_unit AS id_unit,
unit_type.model_name AS model,
unit_type.model_alias AS alias,
unit_type.id_dept AS id_dept
FROM unit_type ")or die(mysqli_error($link));
while($dataModelUnit = mysqli_fetch_assoc($qryModelUnit)){
    $array_model[$in++] = $dataModelUnit['id_unit'];
}
$in = 0;
$qry_dept = mysqli_query($link, "SELECT * FROM dept_account")or die(mysqli_error($link));
while($data_dept = mysqli_fetch_assoc($qry_dept)){
    $array_dept[$in++] = $data_dept['id_dept_account'];
}
// var_dump($array_dept);

foreach($array_tgl as $t){
    foreach($array_dept as $id_dept){
        $qryIdr = mysqli_query($link,"SELECT * FROM labour WHERE id_dept = '$id_dept' ")or die(mysqli_error($link));
        while($idr_dept = mysqli_fetch_assoc($qryIdr)){
            // unit
            $totUnit = 0;
            $qryUnit = mysqli_query($link, "SELECT * FROM unit_type WHERE id_dept = '$id_dept'")or die(mysqli_error($cnt));
            while($dataUnit = mysqli_fetch_assoc($qryUnit)){
                $qryUnitResult = mysqli_query($cnt, "SELECT SUM(a)  AS `a`,SUM(b)  AS `b` FROM production  WHERE unit = '$dataUnit[id_unit]' AND (`date` BETWEEN '$t' AND '$t' ) ")or die(mysqli_error($cnt));
                $result = mysqli_fetch_assoc($qryUnitResult);
                $prod_result = $result['a']+$result['b'];
                $totUnit = $totUnit + $prod_result;
                // echo $totUnit;
            }
            $unitIDR[$idr_dept['id'].'-'.$t] = $totUnit;
        }
    }
    foreach($array_dept as $id_dept){
        $qryIdr = mysqli_query($link,"SELECT * FROM labour WHERE id_dept = '$id_dept' ")or die(mysqli_error($link));
        while($idr_dept = mysqli_fetch_assoc($qryIdr)){
            // menit
            $qrySum = mysqli_query($link, "SELECT SUM(overtime) AS ot FROM ot_cost WHERE id_prodarea = '$idr_dept[id]' AND (`date` BETWEEN '$t' AND '$t' )")or die(mysqli_error($link));
            $totalMenit = mysqli_fetch_assoc($qrySum);
            $menit = ($totalMenit['ot'] == 0)?0:$totalMenit['ot'];
            $menitIDR[$idr_dept['id'].'-'.$t] = $menit;
        }
    }
}
// var_dump($menitIDR);
// var_dump($unitIDR);
foreach($array_tgl as $t){
    
    $qryCostUnit = mysqli_query($link, "SELECT unit_type.id_unit AS id_unit,
    unit_type.model_name AS model,
    unit_type.model_alias AS alias,
    unit_type.id_dept AS id_dept
    FROM unit_type ")or die(mysqli_error($link));
    while($dataCostUnit = mysqli_fetch_assoc($qryCostUnit)){
        $menit = 0;

        // echo $dataCostUnit['model']."-";
        $qryUnitProdArea = mysqli_query($link, "SELECT 
        unit_prod.id_prod AS unit_prod,
        unit_prod.prod_alias AS prod_alias,
        unit_prod.prod_name AS prod_name,
        unit_prod.id_unit AS prod_id_unit,
        unit_prodarea.id AS id_prodarea,
        unit_prodarea.id_group AS group_prodarea,
        unit_prodarea.id_prod AS id_prod_prodarea FROM unit_prodarea
        JOIN unit_prod ON unit_prodarea.id_prod = unit_prod.id_prod WHERE unit_prod.id_unit = '$dataCostUnit[id_unit]' GROUP BY unit_prodarea.id")or die(mysqli_error($link));
        $dataProdarea = mysqli_fetch_assoc($qryUnitProdArea);
        // echo $dataProdarea['id_prodarea']."-";
        $qrySum = mysqli_query($link, "SELECT SUM(overtime) AS ot FROM ot_cost WHERE id_prodarea = '$dataProdarea[id_prodarea]' AND (`date` BETWEEN '$t' AND '$t' )")or die(mysqli_error($link));
        $totalMenit = mysqli_fetch_assoc($qrySum);
        $menit = ($totalMenit['ot'] == 0)?0:$totalMenit['ot'];
        //indirect
        
        //direct
        $qryUnitResult = mysqli_query($cnt, "SELECT SUM(a)  AS `a`,SUM(b)  AS `b` FROM production  WHERE unit = '$dataCostUnit[id_unit]' AND (`date` BETWEEN '$t' AND '$t' ) ")or die(mysqli_error($cnt));
        $result = mysqli_fetch_assoc($qryUnitResult);
        $prod_result = $result['a']+$result['b'];
        
        // $array_model[$in++] = $dataCostUnit['id_unit'];
        $array_menit[$dataCostUnit['id_unit'].'-'.$t] = $menit;
        $array_prod[$dataCostUnit['id_unit'].'-'.$t] = $prod_result;
        
    }
}
?>
<!-- </form> -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title pull-left">
                    Ovetime Direct Labour
                </h5>
            </div>
            <div class="card-body">
                <div class="table table-responsive">
                    <table class="table table-stiped">
                        <thead>
                            <th>Satuan</th>
                            <?php
                            foreach($array_tgl as $tglHeader){
                                ?>
                                <th class="text-nowrap"><?=$tglHeader?></th>
                                <?php
                            }
                            ?>
                        </thead>
                        <tbody>
                                <?php
                                foreach($array_model as $model){
                                    
                                    ?>
                                    <tr>
                                        <td rowspan="3"><?=$model?></td>
                                        <td>menit</td>
                                    <?php
                                    foreach($array_tgl as $dt){
                                        ?>
                                        <td><?=$array_menit[$model.'-'.$dt]?></td>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td>unit</td>
                                    
                                    <?php
                                    foreach($array_tgl as $dt){
                                        ?>
                                        <td><?=$array_prod[$model.'-'.$dt]?></td>
                                        <?php
                                    }
                                    ?>
                                     <tr>
                                        <td>Cost / Unit</td>
                                    
                                    <?php
                                    foreach($array_tgl as $dt){
                                        $cost = ($array_prod[$model.'-'.$dt] > 0)?($array_menit[$model.'-'.$dt]*$otRate)/$array_prod[$model.'-'.$dt]:0;
                                        ?>
                                        <td><?=rupiah($cost)?></td>
                                        <?php
                                    }
                                    ?>
                                    </tr>
                                    <?php
                                }
                                // var_dump($array_model);
                                // var_dump($array_menit);
                                // print_r($array_prod);
                                ?>

                                
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title pull-left">
                    Ovetime InDirect Labour
                </h5>
            </div>
            <div class="card-body">
                <div class="table table-responsive">
                    <table class="table table-stiped">
                        <thead>
                            <th>Satuan</th>
                            <?php
                            foreach($array_tgl as $tglHeader){
                                ?>
                                <th class="text-nowrap"><?=$tglHeader?></th>
                                <?php
                            }
                            ?>
                        </thead>
                        <tbody>
                            
                                
                                <?php
                                foreach($array_dept as $dept){
                                    $qryIdr = mysqli_query($link,"SELECT * FROM labour WHERE id_dept = '$dept' ")or die(mysqli_error($link));
                                    $sql_IDR = mysqli_fetch_assoc($qryIdr);
                                    $model = $sql_IDR['id'];
                                    ?>
                                    <tr>
                                        <td rowspan="3"><?=$dept?></td>
                                        <td>menit</td>
                                    <?php
                                    foreach($array_tgl as $dt){
                                        ?>
                                        <td><?=$menitIDR[$model.'-'.$dt]?></td>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td>unit</td>
                                    
                                    <?php
                                    foreach($array_tgl as $dt){
                                        ?>
                                        <td><?=$unitIDR[$model.'-'.$dt]?></td>
                                        <?php
                                    }
                                    ?>
                                     <tr>
                                        <td>Cost / Unit</td>
                                    
                                    <?php
                                    foreach($array_tgl as $dt){
                                        $cost = ($unitIDR[$model.'-'.$dt] > 0)?($menitIDR[$model.'-'.$dt]*$otRate)/$unitIDR[$model.'-'.$dt]:0;
                                        ?>
                                        <td><?=rupiah($cost)?></td>
                                        <?php
                                    }
                                    ?>
                                    </tr>
                                    <?php
                                }
                                // var_dump($array_model);
                                // var_dump($array_menit);
                                // print_r($array_prod);
                                ?>

                                
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title pull-left">
                    Sumary Cost
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table_org" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Production Area</th>
                            <th>Total Menit</th>
                            <th>Ot Rate</th>
                            <th>Total Cost</th>
                            <th class="text-right">Action</th>
                            <th class="text-right">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" id="cek">
                                    <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    $sqlProd = mysqli_query($link, "SELECT * FROM unit_prod")or die(mysqli_error($link));
                    if(mysqli_num_rows($sqlProd) > 0){
                        while($data = mysqli_fetch_assoc($sqlProd)){
                            ?>
                            
                            <?php
                            $qry_unit = mysqli_query($link, "SELECT unit_type.id_unit AS id_unit,
                            unit_type.id_dept AS id_unit,
                            ot_rate.id_dept AS id_dept,
                            ot_rate.ot_rate AS ot_rate
                            

                            FROM unit_type JOIN ot_rate ON unit_type.id_dept = ot_rate.id_dept WHERE id_unit = '$data[id_unit]' GROUP BY id_dept ")or die(mysqli_error($link));
                            $sql_rate = mysqli_fetch_assoc($qry_unit);
                            $ot_rate = $sql_rate['ot_rate'];
                            
                            // $qry_rate = mysqli_query($link, "SELECT * FROM ot_rate WHERE id_dept = '$dept' GROUP BY id")or die(mysqli_error($link));
                            // $sql_rate = mysqli_fetch_assoc($qry_rate);
                            // $ot_rate = $sql_rate['ot_rate'];

                            $menit = 0;
                            $totalcost = 0;
                            $qryarea = mysqli_query($link, "SELECT * FROM unit_prodarea WHERE id_prod = '$data[id_prod]' GROUP BY id ")or die(mysqli_error($link));
                            while($dataarea = mysqli_fetch_assoc($qryarea)){
                                
                                $qryOt = mysqli_query($link, "SELECT SUM(overtime) AS ot FROM ot_cost WHERE id_prodarea = '$dataarea[id]' ")or die(mysqli_error($link));
                                $dataOt = mysqli_fetch_assoc($qryOt);
                                $menit += $dataOt['ot'];
                                
                                
                                $totalcost = $menit * $ot_rate;
                            }
                            
                            
                            ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=$data['prod_alias']?></td>
                                <td><?=$menit?></td>
                                <td><?=rupiah($ot_rate)?></td>
                                <td><?=rupiah($totalcost)?></td>
                                
                                <td class="text-right text-nowrap">
                                    <a href="" class="btn-round btn-outline-primary btn btn-primary btn-link btn-icon btn-sm edit"><i class="fa fa-eye"></i></a>
                                    
                                </td>
                                <td class="text-right">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input cek" name="checked[]" type="checkbox" value=">">
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
    </div>
</div>
<div class="row">
    <div class="col-md-12 d-none">

        <div class="card">
            <div class="card-header">
                <h5 class="title pull-left">Database Overtime</h5>
                <div class="box pull-right">
                    <div class="my-2 mr-2 float-right order-3">
                        <div class="input-group bg-transparent">
                            <input type="text" name="cari" class="form-control bg-transparent" placeholder="Cari nama atau npk..">
                            <div class="input-group-append bg-transparent">
                                <div class="input-group-text bg-transparent">
                                    <i class="nc-icon nc-zoom-split"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <form method="post" name="proses" action="" >
                <div class="table-responsive">
                    <table class="table table-striped table_org" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Group Area</th>
                                <th>Production Type</th>
                                <th>Tanggal</th>
                                <th>Total Menit</th>
                                <th>OT Code</th>
                                <th>OT Cost / hour</th>
                                <th>Total Cost</th>
                                <th class="text-right">Action</th>
                                <th class="text-right">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="allcek">
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // $no = 1;
                        // $sqlOt = mysqli_query($link, "SELECT * FROM ot_cost")or die(mysqli_error($link));
                        
                        // if(mysqli_num_rows($sqlOt) > 0){
                        //     while($dataOt = mysqli_fetch_assoc($sqlOt)){
                        //         // catch areaprod
                        //         $qry_prdarea = mysqli_query($link, "SELECT unit_prodarea.id AS id_prd,
                        //         unit_prodarea.id_group AS id_grp,
                        //         unit_prodarea.id_prod AS id_prod,
                        //         unit_prodarea.id_unit AS id_unit,

                        //         groupfrm.id_group AS grp,
                        //         groupfrm.nama_group AS nama_grp,
                        //         groupfrm.id_section AS id_sect,
                                
                        //         section.id_section AS sect,
                        //         section.section AS nama_sect,

                        //         unit_prod.id_prod AS prd,
                        //         unit_prod.prod_alias AS prd_alias,
                        //         unit_prod.prod_name AS nama_prd
                        //         FROM `unit_prodarea` JOIN groupfrm ON unit_prodarea.id_group = groupfrm.id_group
                        //         JOIN section ON section.id_section = groupfrm.id_section 
                        //         JOIN unit_prod ON unit_prodarea.id_prod = unit_prod.id_prod
                        //         WHERE unit_prodarea.id = '$dataOt[id_prodarea]' ")or die(mysqli_error($link));

                        //         $data_group = mysqli_fetch_assoc($qry_prdarea);


                        ?>
                        </tbody>
                        
                    </table>
                </div>
            
                <hr>
                <div class="box pull-right">
                    <button class="btn btn-success editall">
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
    
<!-- halaman utama end -->
<?php
    include_once("../../footer.php"); 
    //javascript
    ?>
    <script>
        $(document).ready(function(){
            $("#dept").blur(function(){
                var dept = $(this).val()
                
                
                $.ajax({
                type: 'POST',
                url: "prd.php",
                data : {dept : dept},
                success: function(msg){
                    $("#prod").html(msg);
                    }
                });
            });
            $("#tanggal").blur(function(){
                var tgl = $(this).val()

                $.ajax({
                type: 'POST',
                url: "ws.php",
                data : {tgl : tgl},
                success: function(msg){
                    $("#workingshift").html(msg);
                    }
                });
            });
            $("#prod").blur(function(){
                var prod = $(this).val()

                $.ajax({
                type: 'POST',
                url: "prodarea.php",
                data : {prod : prod},
                success: function(msg){
                    $("#prodarea").html(msg);
                    }
                });
            });
            
        })
    </script>
        <script>
        $(document).ready(function(){
            $('#load').on('click', function() {
                var file_data = $('#file_export').prop('files')[0];   
                var form_data = new FormData();               
                form_data.append('file_import', file_data);
                // alert(form_data);                             
                $.ajax({
                    url: 'import.php', // <-- point to server-side PHP script 
                    dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                        
                    type: 'post',
                    success: function(resp){
                        // alert(resp); // <-- display response from the PHP script, if any
                        $(".data_load").html(resp);
                    
                    }
                });
            });
        })
    </script>
    
    <?php
    include_once("../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>