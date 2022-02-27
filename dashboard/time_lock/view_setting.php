<?php
//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
// echo $_GET['data_sm'];
// mysqli_query($link, "DELETE FROM system_lock");
$query = "SELECT * FROM system_lock";
        $ot_lock = " WHERE type = 'ot' ";
        $at_lock = " WHERE type = 'at' ";
        $s_lock = " WHERE type = 'sm' ";
        $period_d = " AND periodic = 'd' ";
        $period_y = " AND periodic = 'y' ";

        $daily_ot = mysqli_query($link,$query.$ot_lock.$period_d)or die(mysqli_error($link));
        $daily_at = mysqli_query($link,$query.$at_lock.$period_d)or die(mysqli_error($link));
        $y_ot = mysqli_query($link,$query.$ot_lock.$period_y)or die(mysqli_error($link));
        $y_at = mysqli_query($link,$query.$at_lock.$period_y)or die(mysqli_error($link));
        $sm = mysqli_query($link,$query.$s_lock.$period_d)or die(mysqli_error($link));
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6  my-0 py-2">
                        <h5 class="title ">
                            System Maintenance
                        </h5>
                        <p class="category">System off</p>

                    </div>
                    <div class="col-md-6 text-right my-0 py-2">
                    <?php
                    if(mysqli_num_rows($sm)>0){
                        $data_sm = mysqli_fetch_assoc($sm);
                        $active = $data_sm['status'];
                        // echo $data_sm['status'];
                        $checked = ($data_sm['status'] == 1)?"checked":'';
                        ?>
                        <input id="status_sm" class="bootstrap-switch" type="checkbox" data-toggle="switch" name="status_sm" <?=$checked?>  value="<?=$active?>" data-on-color="warning" data-off-color="warning" data-on-label="ON" data-off-label="OFF">
                        <?php
                    }
                    ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<div class="row" >
    <div class="col-md-12">
                    
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6  my-0 py-2">
                        <h5 class="title ">
                            Daily Lock System
                        </h5>
                        <p class="category">Setting Lock System Harian</p>

                    </div>
                    <div class="col-md-6 text-right">
                        <div class="btn btn-sm btn-success" id="update_daily">Update</div>
                    </div>

                </div>
            </div>
            <hr class="my-0">
            <div class="card-body">
                <form method="get" id="form_daily" action="/" class="form-horizontal">
                <div class="row">
                        <div class="col-md-12  bg-info ">
                            <h6 class="title my-2 text-white">overtime</h6>
                        </div>
                    </div>
                <?php
                    if(mysqli_num_rows($daily_ot)>0){
                        ?>
                        <div class="table-full-width ">
                            <table class="table-sm text-nowrap text-truncate " width="100%">
                                <thead>
                                    <tr class="py-1">
                                        <th >Scheme</th>
                                        <th >Start</th>
                                        <th >End</th>
                                        <th colspan="2">Status</th>
                                    </tr>
                                    
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    while($data = mysqli_fetch_assoc($daily_ot)){
                                        $type = ($data['type'] == 'ot')?'overtime':(($data['type'] == 'at')?'attendance':'system');
                                        ?>
                                        <tr>
                                            
                                            <td class="text-uppercase">
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="hidden" name="id_skema[]" readonly class="form-control  text-uppercase border-0 bg-transparent px-0" value="<?=$data['id']?>">
                                                    <input type="text" name="nama_skema[]"  class="form-control  text-uppercase border-0 bg-transparent px-0" value="<?=$data['system_name']?>">
                                                </div>

                                            </td>
                                            
                                            <td>
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="text" name="start_off[]" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="HH:mm:ss" value="<?=$data['off_start']?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="text" name="end_off[]" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="HH:mm:ss" value="<?=$data['off_end']?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="hidden" name="type_skema[]" class="form-control border-0 bg-transparent px-0"  value="<?=$data['type']?>">
                                                </div>
                                                <?php
                                                
                                                $active = $data['status'];
                                                $stats = ($data['status'] == '1')?"active":"in-active";
                                                $clr = ($data['status'] == '1')?"info":"warning";
                                                $checked = ($data['status'] == 1)?"checked":'';
                                                
                                                ?>
                                                <span class="badge badge-sm badge-<?=$clr?> badge-pill"><?=$stats?></span>
                                            
                                            </td>
                                            
                                            <td>
                                                
                                                <input class="bootstrap-switch " type="checkbox" data-toggle="switch" name="status-<?=$no?>" <?=$checked?> value="<?=$active?>" data-on-color="warning" data-off-color="warning" data-on-label="ON" data-off-label="OFF">
                                                
                                            </td>
                                        </tr>
                                        <?php
                                        $no ++;
                                    }
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                        
                
                    <div class="row">
                        <div class="col-md-12  bg-info ">

                            <h6 class="title my-2 text-white">Absensi</h6>
                        </div>
                    </div>
                <?php
                    if(mysqli_num_rows($daily_at)>0){
                        ?>
                        <div class="table-full-width text-uppercase">
                            <table class="table-sm text-nowrap text-truncate" width="100%">
                                
                                <tbody>
                                    <?php
                                    while($data = mysqli_fetch_assoc($daily_at)){
                                        $type = ($data['type'] == 'ot')?'overtime':(($data['type'] == 'at')?'attendance':'system');
                                        ?>
                                        <tr>
                                            
                                            <td class="text-uppercase">
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="hidden" name="id_skema[]" readonly class="form-control text-uppercase  border-0 bg-transparent px-0" value="<?=$data['id']?>">
                                                    <input type="text" name="nama_skema[]"  class="form-control text-uppercase  border-0 bg-transparent px-0" value="<?=$data['system_name']?>">
                                                </div>

                                            </td>
                                            
                                            <td>
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="text" name="start_off[]" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="HH:mm:ss"  value="<?=$data['off_start']?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="text" name="end_off[]" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="HH:mm:ss"  value="<?=$data['off_end']?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="hidden" name="type_skema[]" class="form-control border-0 bg-transparent px-0"  value="<?=$data['type']?>">
                                                </div>
                                                <?php
                                                
                                                $active = $data['status'];
                                                $stats = ($data['status'] == '1')?"active":"in-active";
                                                $clr = ($data['status'] == '1')?"info":"warning";
                                                $checked = ($data['status'] == 1)?"checked":'';
                                                
                                                ?>
                                                <span class="badge badge-sm badge-<?=$clr?> badge-pill"><?=$stats?></span>
                                            
                                            </td>
                                            
                                            <td>
                                                
                                                <input class="bootstrap-switch " type="checkbox" data-toggle="switch" name="status-<?=$no++?>" <?=$checked?> value="<?=$active?>" data-on-color="warning" data-off-color="warning" data-on-label="ON" data-off-label="OFF">
                                                
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                        
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12">
    
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6  my-0 py-2">
                        <h5 class="title ">
                        End Year Close Lock System
                        </h5>
                        <p class="category">Setting Lock Tutup Buku Tahunan</p>

                    </div>
                    <div class="col-md-6 text-right">
                        <div class="btn btn-sm btn-success" id="update_yearly">Update</div>
                    </div>

                </div>
            </div>
            <hr class="my-0">
            <div class="card-body">
                <form method="get" action="" id="yearly_update" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-12  bg-info ">
                            <h6 class="title my-2 text-white">overtime</h6>
                        </div>
                    </div>
                    <?php
                    if(mysqli_num_rows($y_ot)>0){
                        ?>
                        <div class="table-full-width ">
                            <table class="table-sm text-nowrap text-truncate " width="100%">
                                <thead>
                                    <tr class="py-1">
                                        <th >Scheme</th>
                                        <th >Start</th>
                                        <th >End</th>
                                        <th colspan="2">Status</th>
                                    </tr>
                                    
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    while($data = mysqli_fetch_assoc($y_ot)){
                                        $type = ($data['type'] == 'ot')?'overtime':(($data['type'] == 'at')?'attendance':'system');
                                        ?>
                                        <tr>
                                            
                                            <td class="text-uppercase">
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="hidden" name="id_skema[]" readonly class="form-control  text-uppercase border-0 bg-transparent px-0" value="<?=$data['id']?>">
                                                    <input type="text" name="nama_skema[]"  class="form-control  text-uppercase border-0 bg-transparent px-0" value="<?=$data['system_name']?>">
                                                </div>

                                            </td>
                                            
                                            <td>
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="text" name="start_off[]" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="HH:mm:ss" value="<?=$data['off_start']?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="text" name="end_off[]" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="HH:mm:ss" value="<?=$data['off_end']?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="hidden" name="type_skema[]" class="form-control border-0 bg-transparent px-0"  value="<?=$data['type']?>">
                                                </div>
                                                <?php
                                                
                                                $active = $data['status'];
                                                $stats = ($data['status'] == '1')?"active":"in-active";
                                                $clr = ($data['status'] == '1')?"info":"warning";
                                                $checked = ($data['status'] == 1)?"checked":'';
                                                
                                                ?>
                                                <span class="badge badge-sm badge-<?=$clr?> badge-pill"><?=$stats?></span>
                                            
                                            </td>
                                            
                                            <td>
                                                
                                                <input class="bootstrap-switch " type="checkbox" data-toggle="switch" name="status-<?=$no?>" <?=$checked?> value="<?=$active?>" data-on-color="warning" data-off-color="warning" data-on-label="ON" data-off-label="OFF">
                                                
                                            </td>
                                        </tr>
                                        <?php
                                        $no ++;
                                    }
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                        
                
                    <div class="row">
                        <div class="col-md-12  bg-info ">

                            <h6 class="title my-2 text-white">Absensi</h6>
                        </div>
                    </div>
                <?php
                    if(mysqli_num_rows($y_at)>0){
                        ?>
                        <div class="table-full-width text-uppercase">
                            <table class="table-sm text-nowrap text-truncate" width="100%">
                                
                                <tbody>
                                    <?php
                                    while($data = mysqli_fetch_assoc($y_at)){
                                        $type = ($data['type'] == 'ot')?'overtime':(($data['type'] == 'at')?'attendance':'system');
                                        ?>
                                        <tr>
                                            
                                            <td class="text-uppercase">
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="hidden" name="id_skema[]" readonly class="form-control text-uppercase  border-0 bg-transparent px-0" value="<?=$data['id']?>">
                                                    <input type="text" name="nama_skema[]"  class="form-control text-uppercase  border-0 bg-transparent px-0" value="<?=$data['system_name']?>">
                                                </div>

                                            </td>
                                            
                                            <td>
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="text" name="start_off[]" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="HH:mm:ss"  value="<?=$data['off_start']?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="text" name="end_off[]" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="HH:mm:ss"  value="<?=$data['off_end']?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group-sm" auto-complete="off">
                                                    <input type="hidden" name="type_skema[]" class="form-control border-0 bg-transparent px-0"  value="<?=$data['type']?>">
                                                </div>
                                                <?php
                                                
                                                $active = $data['status'];
                                                $stats = ($data['status'] == '1')?"active":"in-active";
                                                $clr = ($data['status'] == '1')?"info":"warning";
                                                $checked = ($data['status'] == 1)?"checked":'';
                                                
                                                ?>
                                                <span class="badge badge-sm badge-<?=$clr?> badge-pill"><?=$stats?></span>
                                            
                                            </td>
                                            
                                            <td>
                                                
                                                <input class="bootstrap-switch " type="checkbox" data-toggle="switch" name="status-<?=$no++?>" <?=$checked?> value="<?=$active?>" data-on-color="warning" data-off-color="warning" data-on-label="ON" data-off-label="OFF">
                                                
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                        
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
    $('.datepicker').datetimepicker();
    

    })
</script>