<?php
require_once("../../../../config/config.php");
?>
<div class="table-striped">
    <table class="table">
        <thead class="table-info">
            <th>Waktu Kerja</th>
            <th>Start</th>
            <th>End</th>
        </thead>
        <tbody>
            <?php
            $queryWh = mysqli_query($link, "SELECT * FROM working_hours WHERE id = '$_GET[wh]' ")or die(mysqli_error($link));
            if(mysqli_num_rows($queryWh)>0){
                while($dataWh = mysqli_fetch_assoc($queryWh)){
                    ?>
                    <tr>
                        <td><?=$dataWh['code_name']?></td>
                        <td><?=$dataWh['start']?></td>
                        <td><?=$dataWh['end']?></td>
                    </tr>
                    <?php
                }
            }else{
                ?>
                <tr>
                    <td colspan="3">Belum Ada Data</td>
                </tr>
                <?php
            }
            ?>
            
        </tbody>
    </table>
</div>
