<?php

require_once("../../../config/config.php"); 
// $year = (isset($_SESSION['tahun']))?  $_SESSION['tahun'] : date('Y');
// echo $year;
if(isset($_POST['go'])){
    $_SESSION['tahun'] = $_POST['year'];
    $year = $_SESSION['tahun'];
}else{
    $year = date('Y');
}


?>
<div class="row">
    <div class="col-md-12">
        <div class="modal fade bd-example-modal-lg" id="datapreview" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="workingbreak/proses.php" method="POST" id="RangeValidation">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="nc-icon nc-simple-remove"></i>
                            </button>
                            <h5 class="title text-left">Data Preview</h5>
                        </div>
                        <div class="modal-body dataLoad col-md-12"></div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box pull-right">
    <a href="<?=base_url('/dashboard/wh/workingbreak')?>/add.php?add=breakshift" class="pull-right btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Tambah Data Master">
        <span class="btn-label">
            <i class="nc-icon nc-simple-add"></i> Tambah Data
        </span>
        
    </a>
</div>

<form method="post" name="proses" action="" >
    <div class="table-responsive">
        <table class="table table_org" id="datatable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Group Scheme</th>
                    <th>Shifting</th>
                    <th>Skema</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Effective Date</th>
                    
                </tr>
            </thead>
            <tbody class="text-uppercase">
            <?php
            $no = 1;
            $sqlHd = mysqli_query($link, "SELECT working_break_shift.id_working_day_shift AS `shift`,
            working_day_shift.name AS working_day,
            working_break_shift.id_working_break AS `id_break`,
            working_break_shift.break_group_id AS `break_group`,
            working_break_shift.effective_date AS `effective`
            FROM working_break_shift JOIN working_break ON working_break.id = working_break_shift.id_working_break 
            LEFT JOIN working_day_shift ON working_day_shift.id = working_break_shift.id_working_day_shift
            GROUP BY working_break_shift.break_group_id
            ")or die(mysqli_error($link));
            
            if(mysqli_num_rows($sqlHd) > 0){
                while($dataHd = mysqli_fetch_assoc($sqlHd)){
                    $queryBreak = mysqli_query($link, "SELECT working_break_shift.id_working_day_shift AS `shift`,
                        working_day_shift.name AS working_day,
                        working_break_shift.id_working_break AS `id_break`,
                        working_break_shift.effective_date AS `effective`,
                        working_break_shift.break_group_id AS `break_group`,
                        working_break.scheme_name AS `skema`,
                        working_break.start_time AS `start`,
                        working_break.end_time AS `end`
                        FROM working_break_shift JOIN working_break ON working_break.id = working_break_shift.id_working_break 
                        LEFT JOIN working_day_shift ON working_day_shift.id = working_break_shift.id_working_day_shift
                        WHERE working_break_shift.break_group_id = '$dataHd[break_group]'
                        ")or die(mysqli_error($link));
                    $totalData = mysqli_num_rows($queryBreak);
                    ?>
                    <tr class="stretched-link viewdetail <?=$dataHd['break_group']?> break" data-id="<?=$dataHd['break_group']?>" data-toggle="modal" data-target="#datapreview">
                        <td rowspan="<?=$totalData?>"><?=$no++?></td>
                        <td rowspan="<?=$totalData?>">Seting <?=$dataHd['break_group']?></td>
                    <?php
                    if(mysqli_num_rows($queryBreak)>0){
                        while($dataBreak = mysqli_fetch_assoc($queryBreak)){
                            ?>
                                <td class="<?=$dataHd['break_group']?> break" data-id="<?=$dataHd['break_group']?>" data-toggle="modal" data-target="#datapreview"><?=$dataBreak['working_day']?></td>
                                <td class="<?=$dataHd['break_group']?> break" data-id="<?=$dataHd['break_group']?>" data-toggle="modal" data-target="#datapreview"><?=$dataBreak['skema']?></td>
                                <td class="<?=$dataHd['break_group']?> break" data-id="<?=$dataHd['break_group']?>" data-toggle="modal" data-target="#datapreview"><?=$dataBreak['start']?></td>
                                <td class="<?=$dataHd['break_group']?> break" data-id="<?=$dataHd['break_group']?>" data-toggle="modal" data-target="#datapreview"><?=$dataBreak['end']?></td>
                                <td class="<?=$dataHd['break_group']?> break" data-id="<?=$dataHd['break_group']?>" data-toggle="modal" data-target="#datapreview"><?=tgl_indo($dataBreak['effective'])?></td>
                                
                            </tr>
                            <tr>
                            <?php
                        }
                    }
                    ?>
                    </tr>
                    <?php


            ?>
            
               
            <?php
                }
            }else{
                echo "<tr><td class=\"text-center\" colspan=\"6\">Tidak ditemukan data di database</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    
</form>
<script>
    $(document).ready(function(){
        $('.break').hover(function(){
            var id = $(this).attr('data-id')
            $('.break').removeClass('table-warning');
            $('.'+id).addClass('table-warning');
        })
        $('.break').click(function(){
            var id = $(this).attr('data-id')
            $(".dataLoad").load("workingbreak/ajax/detail.php?id="+id);
        })
    })
</script>
          