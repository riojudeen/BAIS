<?php
?>
    <div class="row">
        <h5 class="card-title text-left text-uppercase col-md-6" id="mainpage"><i class="fas fa-car "></i> Line Up Production</h5>
        <div class="col-md-6 text-right">
            <div class="dropleft ">
                <button class="btn btn-sm btn-link btn-default btn-outline-default btn-icon btn-round" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow-lg">
                    <div class="dropdown-header">Menu</div>
                    <a class="dropdown-item" href="proses/export.php?export=organization">Export Data</a>                    
                    <a class="dropdown-item" href="add/index.php" >Data Setting</a>
                    <a class="dropdown-item" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Record Hasil Produksi</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        $q_productionModel = "SELECT 
            production_model.id_model AS `id`, 
            production_model.name AS `name`, 
            production_model.alias AS `alias`,
            production_model.stats AS `status`, 
            
            -- production_line.id_dept_account AS `id_dept_account`, 
            -- production_line.id_model AS `id_model`, 
            production_line.nama AS `nama_line`, 
            -- production_line.alias 'alias',

            -- dept_account.id_dept_account AS `id_dept_account`, 
            dept_account.department_account AS `nama_dept`, 
            dept_account.npk_dept AS `npk_cord`,
            dept_account.id_div AS `id_div`
        
        FROM production_line JOIN `dept_account` ON production_line.id_dept_account = dept_account.id_dept_account 
        JOIN production_model ON production_model.id_model = production_line.id_model WHERE production_model.stats = 'active' ";

        $s_productionModel = mysqli_query($link, $q_productionModel)or die(mysqli_error($link));
        if(mysqli_num_rows($s_productionModel) > 0){
            $index = 0;
            $no = 0;
            while($dataModel =mysqli_fetch_assoc($s_productionModel)){
                if($index == $no++){
                    $tab_active = "bg-warning";
                    $active = "data-active";
                }else{
                    $tab_active = "bg-transparent";
                    $active = "";
                }
                ?>
                <div class="col-md-6 col-lg-3 col-sm-12 datamodel " ">
                    <div class="card <?=$tab_active?> shadow-none card-body model card-plain rounded-lg" style="max-width: 540px;" id="card<?=$dataModel['id']?>">
                        <div class="row no-gutters " >
                            <div class="col-md-4">
                                <img src="../../../assets/img/unit_model/<?=$dataModel['alias']?>.png" alt="...">
                            </div>
                            <div class="col-md-8 ">
                                <div class="card-body my-0 py-0">
                                    <h5 class="card-title text-uppercase py-0 my-0"><?=$dataModel['alias']?></h5>
                                    <p class="card-text py-0 my-0 badge badge-sm badge-pill badge-info"><?=$dataModel['name']?></p>

                                    <p class="card-text"><?=$dataModel['nama_dept']?></p>
                                </div>
                            </div>
                            <a  class="mb-0 stretched-link card-category text-right text-white mb-3 model view_data model<?=$dataModel['id']?> <?=$active?>" data-id="<?=$dataModel['alias']?> (<?=$dataModel['name']?>)" id="<?=$dataModel['id']?>"></a>
                        </div>
                        
                    </div>
                </div>
                <?php

            }
        }else{
            ?>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card card-plain" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="../../../assets/img/unit_model/none.png" alt="...">
                        </div>
                        <div class="col-md-8 ">
                            <div class="card-body my-0 py-0">
                                <h5 class="card-title py-0 my-0">N/A</h5>
                                <p class="card-text py-0 my-0 badge badge-sm badge-pill badge-info">belum ada data</p>
                                <p class="card-text">belum ada data</p>
                            </div>
                        </div>
                        <a href="../lineup/" class="mb-0 stretched-link card-category text-right text-white mb-3"></a>
                    </div>
                    
                </div>
            </div>
            <?php
        }
        ?>
        
    </div>