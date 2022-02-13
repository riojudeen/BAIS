<?php
require_once("../../../config/config.php"); 
?>
<div class="row ">

	<div class="col-md-12 ">

		<div class="card" id="ws">
			<div class="card-header">
				<h5 class="title pull-left">Working Scheme</h5>
                <div class="box pull-right">
                    <a href="<?=base_url('/dashboard/wh/workingScheme')?>/add.php?add=ws" class="pull-right btn btn-icon btn-round btn-success" data-toggle="tooltip" data-placement="bottom" title="Tambah Data Master">
                        <span class="btn-label">
                            <i class="nc-icon nc-simple-add"></i>
                        </span>
                        
                    </a>
                </div>
			</div>
            
			<div class="card-body">
                <form method="post" name="proses" action="" >
                <div class="table-responsive">
                    <table class="table table-striped table_org" id="uangmakan" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Group Shift</th>
                                <th>DAY / NIGHT</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Perpindahan Shift</th>
                                <th>Keterangan</th>
                                <th>Tanggal Effective</th>
                                <th class="text-right">Action</th>
                                
                            </tr>
                        </thead>
                        <tbody class="text-uppercase">
                        <?php
                        $no = 1;
                        $sqlWS = mysqli_query($link, "SELECT working_hours.id AS id_WH,
                        working_hours.code_name AS code_WH,
                        working_hours.start AS start_WH,
                        working_hours.end AS end_WH,
                        working_hours.ket AS ket,
                        working_scheme.id AS id_WS,
                        working_scheme.working_hours AS WH_WS,
                        working_scheme.shift AS shift_WS,
                        working_scheme.shifting AS shifting_WS,
                        working_scheme.effective_date AS eff_WS,
                        shifting.id AS id_shifting,
                        shifting.name_code AS code_shifting,
                        shifting.count_day AS countday,
                        shift.id_shift AS id_shift,
                        shift.shift AS shift_shift
                        
                        FROM working_scheme 
                        LEFT JOIN working_hours ON working_hours.id = working_scheme.working_hours
                        LEFT JOIN shifting ON shifting.id = working_scheme.shifting
                        LEFT JOIN shift ON shift.id_shift = working_scheme.shift
                        ORDER BY working_scheme.shift ASC
                         ")or die(mysqli_error($link));
                        
                        if(mysqli_num_rows($sqlWS) > 0){
                            while($dataWS = mysqli_fetch_assoc($sqlWS)){
                                $friday = ($dataWS['ket'] == "friday")?"text-danger":"";
                        ?>
                        
                            <tr class="<?=$friday?>">
                                <td><?=$no++?></td>
                                <td><?=$dataWS['shift_shift']?></td>
                                <td><?=$dataWS['code_WH']?></td>
                                <td><?=$dataWS['start_WH']?></td>
                                <td><?=$dataWS['end_WH']?></td>
                                <td>Every <?=$dataWS['code_shifting']?></td>
                                <td><?=$dataWS['ket']?></td>
                                <td><?=hari($dataWS['eff_WS']).", ".tgl_indo($dataWS['eff_WS'])?></td>
                                <td class="text-right text-nowrap">
                                    <a href="<?=base_url('dashboard/wh/workingScheme')?>/edit.php?id=<?=$dataWS['id_WS']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                    <a href="<?=base_url('dashboard/wh/workingScheme')?>/proses.php?del=<?=$dataWS['id_WS']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>
                                </td>

                                
                            </tr>
                        <?php
                            }
                        }else{
                            echo "<tr><td class=\"text-center\" colspan=\"9\">Tidak ditemukan data di database</td></tr>";
                        }
                        ?>
                        </tbody>
                        
                    </table>
                </div>
            
                
                </form>
            </div>
            <div class="card-footer">
                
            </div>
		</div>
	</div>
</div>