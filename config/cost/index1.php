<?php

require_once("../config.php");
require_once("date.php");
require_once("otDL.php");
require_once("otIDL.php");
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
// var_dump($array_prod);
// echo "<br>";
// echo "<br>";
// //direct labour
// var_dump($array_menit);
// echo "<br>";
// echo "<br>";
// var_dump($array_prodMix);
// echo "<br>";
// echo "<br>";
// var_dump($array_MH);
// echo "<br>";
// echo "<br>";
// var_dump($array_model);
// echo "<br>";
// echo "<br>";
// var_dump($array_area);
// echo "<br>";
// echo "<br>";
// var_dump($sum_prod);
// echo "<br>";
// echo "<br>";
// var_dump($sum_prodMix);
// echo "<br>";
// echo "<br>";
// var_dump($sum_unitIDR);
// echo "<br>";
// echo "<br>";
var_dump($sum_menitIDR);
echo "<br>";
echo "<br>";
var_dump($sum_menit);
echo "<br>";
echo "<br>";


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
            
            foreach($array_area as $area){
                switch($area){
                    case 43 :
                        $area2 = 44;
                        $nama = "MIX LINE D12L";
                        break;
                    case 44 :
                        $area2 = 43;
                        $nama = "MIX LINE D14L";
                        break;
                    case 45 :
                        $area2 = 45;
                        $nama = "MIX LINE D26A";
                        break;
                    case 46 :
                        $area2 = 47;
                        $nama = "SHELL PART D12L";
                        break;
                    case 47 :
                        $area2 = 46;
                        $nama = "SHELL PART D14L";
                        break;
                    case 48 :
                        $area2 = 48;
                        $nama = "SHELL PART D26A";
                        break;
                    case 49 :
                        $area2 = 49;
                        $nama = "D40D";
                        break;
                }
                ?>
                <tr>
                    <td rowspan="4"><?=$nama?></td>
                    <td>menit</td>
                <?php
                
                foreach($array_tgl as $dt){
                    
                    ?>
                    <td><?=$array_menit[$area.'-'.$dt]/60?></td>
                    <?php
                }
                ?>
                <tr>
                    <td>unit</td>
                
                <?php
                
                foreach($array_tgl as $dt){
                    ?>
                    <td><?=$array_prodMix[$area.'-'.$dt]?></td>
                    <?php
                }
                ?>
                    <tr>
                    <td>MHU</td>
                
                <?php
                foreach($array_tgl as $dt){

                    ?>
                    <td><?=$array_MH[$area.'-'.$dt]?></td>
                    <?php
                }
                ?>
                    <tr>
                    <td>Cost / Unit</td>
                
                <?php
                $index = 0;
                $jmlHari = count($array_tgl);
                
                // echo $jmlHari;
                
                foreach($array_tgl as $dt){
                    if($area == 43 || $area == 44 || $area == 45){
                        if($array_prodMix[$area.'-'.$dt] > 0){
                            $cost = ($array_MH[$area.'-'.$dt]*($array_menit[$area.'-'.$dt]/60)*$otRate)/(($array_MH[$area.'-'.$dt]*$array_prodMix[$area.'-'.$dt])+($array_MH[$area2.'-'.$dt]*$array_prodMix[$area2.'-'.$dt]));
                        }else{
                            $cost = 0;
                        }
                        
                    }else{
                        if($array_prodMix[$area.'-'.$dt] > 0){
                            $cost = (($array_menit[$area.'-'.$dt]/60) * $otRate)/($array_prodMix[$area.'-'.$dt]);
                        }else{
                            $cost = 0;
                        }
                    }
                    // 
                    if($area == 43 || $area == 44 || $area == 45){
                        if($sum_prodMix[$area.'-'.$dt] > 0){
                            $sum_cost = ($array_MH[$area.'-'.$dt]*($sum_menit[$area.'-'.$dt]/60)*$otRate)/(($array_MH[$area.'-'.$dt]*$sum_prodMix[$area.'-'.$dt])+($array_MH[$area2.'-'.$dt]*$sum_prodMix[$area2.'-'.$dt]));
                        }else{
                            $sum_cost = 0;
                        }
                        
                    }else{
                        if($sum_prodMix[$area.'-'.$dt] > 0){
                            $sum_cost = (($sum_menit[$area.'-'.$dt]/60) * $otRate)/($sum_prodMix[$area.'-'.$dt]);
                        }else{
                            $sum_cost = 0;
                        }
                    }
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