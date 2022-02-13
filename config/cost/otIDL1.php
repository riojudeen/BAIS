<?php

$otRate = 72600;
// menit dan hasil unit
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
$in = 0;
$qry_prod = mysqli_query($link, "SELECT * FROM unit_prod")or die(mysqli_error($link));
while($data_prod = mysqli_fetch_assoc($qry_prod)){
    $array_area[$in++] = $data_prod['id_prod'];
}
// var_dump($array_dept);

foreach($array_tgl as $t){
    $awal = date('Y-m-01', strtotime($t));
    $akhir = date('Y-m-d', strtotime($t));

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
            $sumUnit = 0;
            $qryUnit = mysqli_query($link, "SELECT * FROM unit_type WHERE id_dept = '$id_dept'")or die(mysqli_error($cnt));
            while($dataUnit = mysqli_fetch_assoc($qryUnit)){
                $qryUnitResult = mysqli_query($cnt, "SELECT SUM(a)  AS `a`,SUM(b)  AS `b` FROM production  WHERE unit = '$dataUnit[id_unit]' AND (`date` BETWEEN '$awal' AND '$akhir' ) ")or die(mysqli_error($cnt));
                $result = mysqli_fetch_assoc($qryUnitResult);
                $prod_result = $result['a']+$result['b'];
                $sumUnit = $sumUnit + $prod_result;
                // echo $totUnit;

            }
            $sum_unitIDR[$idr_dept['id'].'-'.$t] = $sumUnit;
            
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

            $qrySum = mysqli_query($link, "SELECT SUM(overtime) AS ot FROM ot_cost WHERE id_prodarea = '$idr_dept[id]' AND (`date` BETWEEN '$awal' AND '$akhir' )")or die(mysqli_error($link));
            $totalMenit = mysqli_fetch_assoc($qrySum);
            $sum_menit = ($totalMenit['ot'] == 0)?0:$totalMenit['ot'];
            $sum_menitIDR[$idr_dept['id'].'-'.$t] = $sum_menit;
        }
    }
}

