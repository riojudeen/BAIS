<?php


// menit dan hasil unit
$qryCostUnit = mysqli_query($link, "SELECT unit_type.id_unit AS id_unit,
unit_type.model_name AS model,
unit_type.model_alias AS alias,
unit_type.id_dept AS id_dept
FROM unit_type ")or die(mysqli_error($link));
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
