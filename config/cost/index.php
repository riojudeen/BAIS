<?php
// require_once("../config.php");
// array tgl
// var_dump($array_tgl);
// echo "<br>";
// echo "<br>";
// //indirect labour
// var_dump($menitIDR);
// echo "<br>";
// echo "<br>";
// var_dump($unitIDR);
// echo "<br>";
// echo "<br>";
// var_dump($array_dept);
// echo "<br>";
// echo "<br>";
// //direct labour
// var_dump($array_menit);
// echo "<br>";
// echo "<br>";
// var_dump($array_prod);
// echo "<br>";
// echo "<br>";
// var_dump($array_model);
// echo "<br>";
// echo "<br>";
/*
?>
<table class="table table-stiped">
    <thead>
        <th>Unit</th>
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
<table class="table table-stiped">
    <thead>
        <th>Dept</th>
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
<?php
*/
function otcost($link, $cnt, $tgl, $car1, $car2, $prod, $tipeprod){
    //konversi tanggal
    // $tanggal = date('Y-m-01', strtotime($tgl));
    $awalTahun = date('Y-4-01', strtotime($tgl));
    $akhirTahun = date('Y-m-d', strtotime('+1 year', strtotime($tgl)));
    //jika mix
    $sD = date('Y-m-01', strtotime($tgl));
    $eD = date('Y-m-d', strtotime($tgl));
    
        $qryMHU2 = mysqli_query($link,"SELECT cs_mhu.nokey AS `nokey`,
        cs_mhu.car AS `id_unit`,
        cs_mhu.mhu AS `mhu`,
        cs_mhu.date AS `tanggal`,
        unit_type.id_unit AS `unitID`,
        unit_type.model_name AS `modelName`,
        unit_type.model_alias AS `modelAlias`,
        unit_type.id_dept AS `deptID`,
        ot_rate.id AS `ot_rateID`,
        ot_rate.ot_rate AS `ot_rate`,
        ot_rate.start_period AS `sPeriod`,
        ot_rate.end_period AS `ePeriod`,
        ot_rate.id_dept AS `idDept`
        FROM cs_mhu JOIN unit_type ON cs_mhu.car = unit_type.id_unit
        JOIN ot_rate ON ot_rate.id_dept = unit_type.id_dept
        WHERE ot_rate.start_period BETWEEN '$awalTahun' AND '$akhirTahun' AND cs_mhu.car = '$car2' ")or die(mysqli_error($link));
        $sql_MHU2 = mysqli_fetch_assoc($qryMHU2);
        $mhu2 = $sql_MHU2['mhu'];

        //cari unit
        $qry_Prod2 = mysqli_query($cnt, "SELECT SUM(production.a) AS `a`, SUM(production.b) AS `b`, production.date AS `tanggal` FROM production 
        WHERE production.date BETWEEN '$sD' AND '$eD' AND (production.unit = '$car2') ")or die(mysqli_error($cnt));
        //hasil unit
        $sql_Prod2 = mysqli_fetch_assoc($qry_Prod2);
        $unit2 = $sql_Prod2['a']+$sql_Prod2['b'];
        
    
    $qryMHU1 = mysqli_query($link,"SELECT cs_mhu.nokey AS `nokey`,
    cs_mhu.car AS `id_unit`,
    cs_mhu.mhu AS `mhu`,
    cs_mhu.date AS `tanggal`,
    unit_type.id_unit AS `unitID`,
    unit_type.model_name AS `modelName`,
    unit_type.model_alias AS `modelAlias`,
    unit_type.id_dept AS `deptID`,
    ot_rate.id AS `ot_rateID`,
    ot_rate.ot_rate AS `ot_rate`,
    ot_rate.start_period AS `sPeriod`,
    ot_rate.end_period AS `ePeriod`,
    ot_rate.id_dept AS `idDept`
    FROM cs_mhu JOIN unit_type ON cs_mhu.car = unit_type.id_unit
    JOIN ot_rate ON ot_rate.id_dept = unit_type.id_dept
    WHERE ot_rate.start_period BETWEEN '$awalTahun' AND '$akhirTahun' AND cs_mhu.car = '$car1' ")or die(mysqli_error($link));
    $sql_MHU1 = mysqli_fetch_assoc($qryMHU1);
    $mhu1 = $sql_MHU1['mhu'];

    // //cari unit
    // $qry_Prod1 = mysqli_query($cnt, "SELECT SUM(production.a) AS `a`, SUM(production.b) AS `b`, production.date AS `tanggal`,
    // unit_prod.id_prod AS `idProd`,
    // unit_prod.prod_alias AS `aliasProd`,
    // unit_prod.prod_name AS `nameProd`,
    // unit_prod.id_unit AS `idUnit`,
    // unit_type.id_unit AS `unitID`,
    // unit_type.model_name AS `modelName`,
    // unit_type.id_dept AS `deptID` FROM production 
    // JOIN unit_prod ON unit_prod.unit = unit_prod.id_prod
    // JOIN unit_type ON unit_prod.id_unit = unit_type.id_unit WHERE unit_type.id_unit = '$car1' AND production.date = '$tgl' ")or die(mysqli_error($cnt));
    // //hasil unit
    // $unit1 = $qry_Prod1['a']+$qry_Prod1['b'];

    //cari unit
    $qry_Prod1 = mysqli_query($cnt, "SELECT SUM(production.a) AS `a`, SUM(production.b) AS `b`, production.date AS `tanggal` FROM production 
    WHERE production.date BETWEEN '$sD' AND '$eD' AND (production.unit = '$car1') ")or die(mysqli_error($cnt));
    //hasil unit
    $sql_Prod1 = mysqli_fetch_assoc($qry_Prod1);
    $unit1 = $sql_Prod1['a']+$sql_Prod1['b'];

    // menit
    $qry_menit = mysqli_query($link, "SELECT SUM(overtime) AS `ot`,
    unit_prodarea.id_group AS id_group,
    unit_prodarea.id_prod AS id_prod,
    unit_prod.id_prod AS idProd,
    unit_prod.prod_alias AS alias,
    unit_prod.id_unit AS idUnit,
    unit_type.id_unit AS unitID,
    unit_type.model_alias AS aliasModel,
    unit_type.id_dept AS deptID
    FROM ot_cost JOIN unit_prodarea ON unit_prodarea.id = ot_cost.id_prodarea
    JOIN unit_prod ON unit_prodarea.id_prod = unit_prod.id_prod
    JOIN unit_type ON unit_prod.id_unit = unit_type.id_unit
    
    WHERE  unit_prod.id_prod = '$prod' AND (ot_cost.date BETWEEN '$sD' AND '$eD') ")or die(mysqli_error($link));
    $sql_menit = mysqli_fetch_assoc($qry_menit);
    $menitot = $sql_menit['ot'];
    $ot_rate = 72600;

    // menit IDR BODY 1
    $qry_menitIDR = mysqli_query($link, "SELECT SUM(overtime) AS `ot`
    FROM ot_cost WHERE  id_prodarea = '$prod' AND (ot_cost.date BETWEEN '$sD' AND '$eD') AND ot_cost.cost = 'IDR' ")or die(mysqli_error($link));
    $sql_menitIDR = mysqli_fetch_assoc($qry_menitIDR);
    $menitotIDR = $sql_menitIDR['ot'];
    $ot_rate = 72600;

    $jam = $menitot / 60;
    $jamIDR = $menitotIDR / 60;
    if($tipeprod == 'mix'){
        
        $pembagi = ($unit1*$mhu1)+($unit2 * $mhu2);
        if($pembagi > 0 ){
            $totalcost = ($mhu1*$jam*$ot_rate)/($pembagi)/1000;
        }else{
            $totalcost = 0;
        }
        
    }else if($tipeprod == 'shell'){
        $pembagi = $unit1;
        if($pembagi > 0 ){
            $totalcost = ($jam*$ot_rate)/($pembagi)/1000;
        }else{
            $totalcost = 0;
        }
        // return $totalcost;
    }else if($tipeprod == 'idr'){
        $pembagi = $unit1+$unit2;
        if($pembagi > 0 ){
            $totalcost = ($jamIDR*$ot_rate)/($pembagi)/1000;
        }else{
            $totalcost = 0;
        }
    }
    return $totalcost;
}

// SALARY Cost

//SALARY CALCULATION
//Labour Direct Mix
function salaryRateDirectDailyMix($cnts, $dept, $cd_cars, $cd_prcs, $dates, $datef, $db_mos, $db_bais){
    // $dayOne = firstDay($dates);
    //$tlWorkDay = mysqli_fetch_array(mysqli_query($cnts,"SELECT totalday FROM cs_workingday WHERE date='$dayOne'"));
    $lastDay = TotalDays($datef);
    $runDay = date("d", strtotime($datef));
    $workDay = $runDay/$lastDay;
    $salaryTL = mysqli_query($cnts,"SELECT cmh.mhu, cmp.total, cp.nokey, csl.salaryrate, (cmh.mhu * cmp.total * csl.salaryrate * $workDay) AS MHTotal

                            FROM $db_mos.car_prod cpd
                            LEFT JOIN $db_mos.costcenter cc ON cc.nokey = cpd.dept
                                LEFT JOIN $db_mos.cost_type_car ctc ON ctc.costcenter = cc.cost_center
                            LEFT JOIN $db_mos.car_list cl ON cl.nokey = cpd.car
                            LEFT JOIN $db_mos.car_prodtype cp ON cp.prod_code = cpd.nokey
                                LEFT JOIN $db_mos.cost_perct cpt ON cpt.area = cp.nokey
                            
                            LEFT JOIN $db_bais.cs_mhu cmh ON cmh.car = cl.nokey
                            LEFT JOIN $db_bais.cs_mp cmp ON cmp.prodarea = cp.nokey
                            LEFT JOIN $db_bais.cs_salary csl ON csl.dept = cc.nokey

                            WHERE cl.status='active' AND cc.nokey='$dept' AND cl.nokey='$cd_cars' AND cp.nokey='$cd_prcs' AND cmh.date='$dates' 
                            AND cmp.type ='1' AND cmp.gol ='3' AND csl.gol ='3'                                  
    ");
    $stl = mysqli_fetch_array($salaryTL);
    $salaryTotal = $stl['MHTotal'];

    $devider = 0;
    $dvLoop = mysqli_query($cnts,"SELECT cmh.mhu,
                            (SELECT SUM(prd.a)+SUM(prd.b) FROM $db_mos.production prd WHERE prd.unit=cl.nokey AND prd.date BETWEEN '$dates' AND '$datef') AS totalunit

                            FROM $db_mos.car_prod cpd
                            LEFT JOIN $db_mos.costcenter cc ON cc.nokey = cpd.dept
                            LEFT JOIN $db_mos.car_list cl ON cl.nokey = cpd.car

                            LEFT JOIN $db_bais.cs_mhu cmh ON cmh.car = cl.nokey

                            WHERE cl.status='active' AND cc.nokey='$dept' AND cmh.date='$dates'                               
    "); 
    foreach($dvLoop as $dp){
        $kali = $dp['mhu'] * $dp['totalunit'];
        $devider = $devider + $kali;
    }    

    $salaryCU =round(($devider!=0)?($salaryTotal/$devider):0);

    return $salaryCU;
  }

 
//Labour Direct SP
function salaryRateDirectDailySpc($cnts, $dept, $cd_cars, $cd_prcs, $dates, $datef, $db_mos, $db_bais){
    $dayOne = firstDay($dates);
    //$tlWorkDay = mysqli_fetch_array(mysqli_query($cnts,"SELECT totalday FROM cs_workingday WHERE date='$dayOne'"));
    $lastDay = TotalDays($datef);
    $runDay = date("d", strtotime($datef));
    $workDay = $runDay/$lastDay;
    $salaryTL = mysqli_query($cnts,"SELECT cmh.mhu, cmp.total, cp.nokey, csl.salaryrate, (cmp.total * csl.salaryrate * $workDay) AS MHTotal

                            FROM $db_mos.car_prod cpd
                            LEFT JOIN $db_mos.costcenter cc ON cc.nokey = cpd.dept
                                LEFT JOIN $db_mos.cost_type_car ctc ON ctc.costcenter = cc.cost_center
                            LEFT JOIN $db_mos.car_list cl ON cl.nokey = cpd.car
                            LEFT JOIN $db_mos.car_prodtype cp ON cp.prod_code = cpd.nokey
                                LEFT JOIN $db_mos.cost_perct cpt ON cpt.area = cp.nokey  
                            
                            LEFT JOIN $db_bais.cs_mhu cmh ON cmh.car = cl.nokey
                            LEFT JOIN $db_bais.cs_mp cmp ON cmp.prodarea = cp.nokey
                            LEFT JOIN $db_bais.cs_salary csl ON csl.dept = cc.nokey

                            WHERE cl.status='active' AND cc.nokey='$dept' AND cl.nokey='$cd_cars' AND cp.nokey='$cd_prcs' AND cmh.date='$dates' 
                            AND cmp.type ='1' AND cmp.gol ='3' AND csl.gol ='3'                                  
    ");
    $stl = mysqli_fetch_array($salaryTL);
    $salaryTotal = $stl['MHTotal'];

    $dvLoop = mysqli_fetch_array(mysqli_query($cnts,"SELECT (SUM(prd.a)+SUM(prd.b)) AS totalprod FROM $db_mos.production prd 
                                              WHERE prd.unit='$cd_cars' AND prd.date BETWEEN '$dates' AND '$datef'")); 
    $devider = $dvLoop['totalprod'];   

    $salaryCU =round(($devider!=0)?($salaryTotal/$devider):0);

    return $salaryCU;
  }     

//Labour Indirect Mix Line
function salaryRateIndirectDailyMix($cnts, $dept, $cd_cars, $cd_prcs, $dates, $datef, $db_mos, $db_bais){
    $dayOne = firstDay($dates);
    //$tlWorkDay = mysqli_fetch_array(mysqli_query($cnts,"SELECT totalday FROM cs_workingday WHERE date='$dayOne'"));
    $lastDay = TotalDays($datef);
    $runDay = date("d", strtotime($datef));
    $workDay = $runDay/$lastDay;
    $salaryTL3 = mysqli_query($cnts,"SELECT (cmp.total * csl.salaryrate * $workDay) AS MHTotal

                            FROM $db_mos.car_prod cpd
                            LEFT JOIN $db_mos.costcenter cc ON cc.nokey = cpd.dept
                                LEFT JOIN $db_mos.cost_type_car ctc ON ctc.costcenter = cc.cost_center
                            LEFT JOIN $db_mos.car_list cl ON cl.nokey = cpd.car
                            LEFT JOIN $db_mos.car_prodtype cp ON cp.prod_code = cpd.nokey
                                LEFT JOIN $db_mos.cost_perct cpt ON cpt.area = cp.nokey  
                            
                            LEFT JOIN $db_bais.cs_mhu cmh ON cmh.car = cl.nokey
                            LEFT JOIN $db_bais.cs_mp cmp ON cmp.prodarea = cp.nokey
                            LEFT JOIN $db_bais.cs_salary csl ON csl.dept = cc.nokey

                            WHERE cl.status='active' AND cc.nokey='$dept' AND cl.nokey='$cd_cars' AND cp.nokey='$cd_prcs' AND cmh.date='$dates' 
                            AND cmp.type ='2' AND cmp.gol ='3' AND csl.gol ='3'                                
    ");
    $stl3 = mysqli_fetch_array($salaryTL3);
    $salaryTotalGol3 = $stl3['MHTotal'];

    $salaryTL4 = mysqli_query($cnts,"SELECT (cmp.total * csl.salaryrate * $workDay) AS MHTotal

                            FROM $db_bais.cs_mp cmp
                            LEFT JOIN $db_bais.cs_salary csl ON cmp.dept = csl.dept

                            WHERE cmp.dept='$dept' AND cmp.date='$dates' 
                            AND cmp.type ='3' AND cmp.gol ='4' AND csl.gol ='4'                               
    ");
    $stl4 = mysqli_fetch_array($salaryTL4);
    $salaryTotalGol4 = $stl4['MHTotal'];    

    $devider = 0;
    $dvLoop = mysqli_query($cnts,"SELECT cmh.mhu,
                            (SELECT SUM(prd.a)+SUM(prd.b) FROM $db_mos.production prd WHERE prd.unit=cl.nokey AND prd.date BETWEEN '$dates' AND '$datef') AS totalunit

                            FROM $db_mos.car_prod cpd
                            LEFT JOIN $db_mos.costcenter cc ON cc.nokey = cpd.dept
                            LEFT JOIN $db_mos.car_list cl ON cl.nokey = cpd.car

                            LEFT JOIN $db_bais.cs_mhu cmh ON cmh.car = cl.nokey

                            WHERE cl.status='active' AND cc.nokey='$dept' AND cmh.date='$dates'                               
    "); 
    foreach($dvLoop as $dp){
        $kali = $dp['totalunit'];
        $devider = $devider + $kali;
    }    

    $salaryCU =round(($devider!=0)?(($salaryTotalGol3+$salaryTotalGol4)/$devider):0);

    return $salaryCU;
  }  
  
//Labour Indirect Shell Part
function salaryRateIndirectDailySpc($cnts, $dept, $cd_cars, $cd_prcs, $dates, $datef, $db_mos, $db_bais){
    $dayOne = firstDay($dates);
    //$tlWorkDay = mysqli_fetch_array(mysqli_query($cnts,"SELECT totalday FROM cs_workingday WHERE date='$dayOne'"));
    $lastDay = TotalDays($datef);
    $runDay = date("d", strtotime($datef));
    $workDay = $runDay/$lastDay;

    $salaryTL3 = mysqli_query($cnts,"SELECT (cmp.total * csl.salaryrate * $workDay) AS MHTotal

                            FROM $db_bais.cs_mp cmp
                            LEFT JOIN $db_bais.cs_salary csl ON cmp.dept = csl.dept

                            WHERE cmp.dept='$dept' AND cmp.car='$cd_cars' AND cmp.prodarea='$cd_prcs' AND cmp.date='$dates' 
                            AND cmp.type ='2' AND cmp.gol ='3' AND csl.gol ='3'                                
    ");
    $stl3 = mysqli_fetch_array($salaryTL3);
    $salaryTotalGol3 = $stl3['MHTotal'];    

    $dvLoop = mysqli_query($cnts,"SELECT cmh.mhu,
                            (SELECT SUM(prd.a)+SUM(prd.b) FROM $db_mos.production prd WHERE prd.unit=cl.nokey AND prd.date BETWEEN '$dates' AND '$datef') AS totalunit

                            FROM $db_mos.car_prod cpd
                            LEFT JOIN $db_mos.costcenter cc ON cc.nokey = cpd.dept
                            LEFT JOIN $db_mos.car_list cl ON cl.nokey = cpd.car

                            LEFT JOIN $db_bais.cs_mhu cmh ON cmh.car = cl.nokey

                            WHERE cl.status='active' AND cc.nokey='$dept' AND cl.nokey='$cd_cars' AND cmh.date='$dates'                               
    ");
    $dp = mysqli_fetch_array($dvLoop); 
    $devider = $dp['totalunit'];   

    $salaryCU =round(($devider!=0)?($salaryTotalGol3/$devider):0);

    return $salaryCU;
  }
//   target cost
function lbr_target($link, $type, $tgl){
    $tanggalAwal = firstDay($tgl);
    $qryTarget = mysqli_query($link, "SELECT * FROM lbr_target WHERE target_type = '$type' AND `date` = '$tanggalAwal' ")or die(mysqli_error($link));

    $sqlTarget = mysqli_fetch_assoc($qryTarget);
    $target = $sqlTarget['target']/1000;
    return $target;
}
  $dept = 5;//$_GET['d'];
  $cd_cars = 46;//$_GET['c'];
  $dates = '2021-08-01';//$_GET['s'];
  $datef = '2021-08-20';//$_GET['t'];
  $cd_prcs = '46';
  $type = 'overtime';

// echo salaryRateDirectDailyMix($cnts, $dept, $cd_cars, $cd_prcs, $dates, $datef, $db_mos, $db_bais);

// $tipeprod = 'shell';
// $car1 = 48;
// $car2 = 48;
// $tgl = '2021-08-31';
// $prod = 9;
// echo otcost($link, $cnt, $tgl, $car1, $car2, $prod, $tipeprod);
 