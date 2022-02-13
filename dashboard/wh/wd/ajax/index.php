<?php

require_once("../../../../config/config.php"); 
if(isset($_GET['year'])){
    $year = $_GET['year'];
    $startdate = $_GET['startdate'];
    $enddate = $_GET['enddate'];
    $shift = $_GET['groupshift'];
}else{
    $year = date('Y');
    $startdate = date('m');
    $enddate = date('m');
    $shift = $_GET['A'];
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table_org" id="uangmakan" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Shift</th>
                        <th>Day / Night</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th class="">Keterangan</th>
                        
                    </tr>
                </thead>
                <tbody class="text-uppercase">
                <?php
                $no = 1;
                $sqlHd = mysqli_query($link, "SELECT working_days.date AS `date`,
                working_days.shift AS `shift`,
                working_days.id AS `id`,
                working_days.ket AS `operational`,
                working_hours.code_name AS `code_name`,
                working_hours.start AS `start_time`,
                working_hours.end AS `end_time`, 
                working_hours.ket AS `ket`,
                working_day_shift.name AS `name`
                FROM working_days LEFT JOIN working_hours ON working_hours.id = working_days.wh
                LEFT JOIN working_day_shift ON working_hours.code_name = working_day_shift.id
                WHERE (MONTH(working_days.date) BETWEEN '$startdate' AND '$enddate')AND (YEAR(working_days.date) = '$year') AND (working_days.shift = '$shift') ORDER BY working_days.date ASC")or die(mysqli_error($link));
                
                if(mysqli_num_rows($sqlHd) > 0){
                    while($dataHd = mysqli_fetch_assoc($sqlHd)){
                        $operational = ($dataHd['operational']== 'DOP')?"Daily Operational":"Holiday Operational";
                        $color = (hari($dataHd['date']) == "Sabtu" || hari($dataHd['date']) == "Minggu")?"table-warning":"";
                        $q = mysqli_query($link,"SELECT * FROM holidays WHERE `date` = '$dataHd[date]' ")or die(mysqli_error($link));
                        $oliday =mysqli_num_rows($q);

                        $text_color = ($oliday > 0)?"text-danger":"";
                ?>
                
                    <tr class="<?=$color?> <?=$text_color?>">
                        <td><?=$no++?></td>
                        <td>
                            
                            <?=hari($dataHd['date']).", ".tgl($dataHd['date'])?>
                        </td>
                        <td><?=$dataHd['shift']?></td>
                        <td><?=$dataHd['name']?></td>
                        <td><?=$dataHd['start_time']?></td>
                        <td><?=$dataHd['end_time']?></td>
                        
                        <td class=" text-nowrap">
                            <?=$operational?>
                        </td>
                        <td class="text-nowrap">
                            <a href="<?=base_url('dashboard/wh/wd')?>/editWorkDay.php?workday=<?=$dataHd['date']?>/<?=$dataHd['shift']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                            <a href="<?=base_url('dashboard/wh/wd')?>/proses.php?del=<?=$dataHd['date']?>&&<?=$dataHd['shift']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                <?php
                    }
                }else{
                    echo "<tr><td class=\"text-center\" colspan=\"6\">Tidak ditemukan data di database</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<script>
    $(document).ready(function(){
        $('.viewdetail').click(function(){
            var id = $(this).attr('data-id')
            // console.log(id);
            $(".dataLoad").load("wd/ajax/detail.php?id="+id);
        })
    })
</script>