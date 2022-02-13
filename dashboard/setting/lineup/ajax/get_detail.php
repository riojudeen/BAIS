<?php
require_once("../../../../config/config.php"); 
$id = $_GET['id'];
$_SESSION['model'] = $id;
?>
<div class="row">
    <div class="col-md-6">
        <!-- <h5 class="card-title">Production</h5> -->
        <p class="badge badge-pill badge-warning">result</p>
        <div class="card shadow-none">
            <div class="card-body">

                
            </div>
        </div>
    </div>
    <div class="col-md-6">
        
        <p class="badge badge-pill badge-warning">production inline area</p>
        <div class="table-responsive">
            <table class="table text-uppercase">
                <thead>
                    <th>#</th>
                    <th>Area</th>
                    <th>Tipe</th>
                    <th>Shift</th>
                    <th>LINE</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php
                    $model_prod = @$_GET['model'];
                    $type_prod = @$_GET['type'];

                    $q_productionArea = "SELECT 
                    -- production_area.id_groupfrm AS `id_group`,
                    -- production_area.id_type AS `id_type`, 
                    production_area.name AS `name_area`,
                    production_area.id_shift AS `shift`,
                    -- production_area.id_line AS `id_line`,

                    -- production_type.id_type AS prod_id_type, 
                    production_type.name AS  `prod_type_name`,
                    -- production_line.id_line AS `id_line`
                    -- production_line.id_dept_account AS `id_dept_account`,
                    -- production_line.id_model AS `id_model`, 
                    production_line.nama AS `line_name`,

                    -- groupfrm.id_group AS `id_group`,
                    groupfrm.nama_group AS `nama_group`,

                    -- production_model.id_model AS `id_model`, 
                    production_model.name AS `model_name`, 
                    production_model.alias AS `model_alias`, 
                    -- production_model.stats AS `stats`
                    
                    -- dept_account.id_dept_account AS `id_dept_account`, 
                    dept_account.department_account AS nama_dept_account, 
                    dept_account.npk_dept AS  `npk_cord`
                    
                    FROM production_area JOIN groupfrm ON groupfrm.id_group = production_area.id_groupfrm
                    JOIN production_type ON production_type.id_type = production_area.id_type
                    JOIN production_line ON production_line.id_line = production_area.id_line
                    JOIN production_model ON production_line.id_line = production_model.id_model
                    JOIN dept_account ON dept_account.id_dept_account = production_line.id_dept_account WHERE production_model.stats IS NULL AND production_area.id_type = '$id'
                    ";
                    
                    // cari shif
                    $q_shift = "SELECT * FROM shift WHERE production = '1' ORDER BY id_shift ASC";
                    $sql_shift = mysqli_query($link, $q_shift)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql_shift) > 0){
                        while($data_shift = mysqli_fetch_assoc($sql_shift)){
                            // ambil data area produksi
                            ?>
                            <tr>
                                <td colspan="6" class="table-warning"><?=$data_shift['shift']?></td>
                            </tr>
                            <?php
                            $s_productionArea = mysqli_query($link, $q_productionArea." AND production_area.id_shift = '$data_shift[id_shift]' ")or die(mysqli_error($link));
                            if(mysqli_num_rows($s_productionArea) > 0){
                                $i= 1 ;

                                while($d_productionArea = mysqli_fetch_assoc($s_productionArea)){
                                    ?>
                                    
                                    <tr>
                                        <td><?=$i++?></td>
                                        <td><?=$d_productionArea['name_area']?></td>
                                        <td><?=$d_productionArea['prod_type_name']?> LINE</td>
                                        <td><?=$d_productionArea['shift']?></td>
                                        <td><?=$d_productionArea['nama_dept_account']?></td>
                                        <td>
                                            <div class="dropdown dropleft">
                                                <button class="btn btn-sm btn-light btn-link btn-icon btn-round" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <!-- <div class="dropdown-header">Action</div> -->
                                                    <a class="dropdown-item" href="proses/export.php?export=organization">Edit</a>
                                                    <a class="dropdown-item" href="file/Format_Register_Area.xlsx" >Delete</a>
                                                    <a class="dropdown-item" href="file/Format_Register_Area.xlsx" >Detail</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }else{
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center">belum ada data</td>
                                </tr>
                                <?php
                            }
                            // end data area produksi
                        }
                    }else{
                        echo "tidak ada shift produksi";
                    }
                    
                    ?>
                </tbody>
            </table>
        </div>
        <!-- <div class="row">
            <div class="col-md-12 box pull-right text-right">
                <button class="btn btn-warning editall" id="edit">
                    <span class="btn-label">
                        <i class="nc-icon nc-ruler-pencil"></i>
                    </span>
                    edit
                </button>
                <button class="btn btn-danger deleteall" id="hapus">
                    <span class="btn-label">
                        <i class="nc-icon nc-simple-remove"></i>
                    </span>
                    delete
                </button>
            </div>
        </div> -->
    </div>
</div>
