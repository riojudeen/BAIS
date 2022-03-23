<?php
$a = $a;
$b = $b;
$c = $c;
?>

<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats " <?=$a?>>
            <div class="card-body py-2 my-2">
                <div class="row ">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center">
                            <i class="nc-icon nc-paper"></i>
                            
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-title"> Manual
                            <p>
                            <p class="card-category ">migrasi data manual</p>
                        </div>
                    </div>
                </div>
            </div>
            <a href="<?=base_url()?>/dashboard/setting/portAtt.php" class="stretched-link " ></a> 
        </div>
    </div>
    
    
    
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats " <?=$b?>>
            <div class="card-body py-2 my-2" >
                <div class="row ">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center">
                            <!-- <i class="nc-icon nc-paper"></i> -->
                            <i class="fab fa-microsoft"></i>
                            
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-title"> Macro CiCo
                            <p>
                            <p class="card-category ">portal migrasi otomatis</p>
                        </div>
                    </div>
                </div>
            </div>
            <a href="<?=base_url()?>/dashboard/setting/cico/index.php" class="stretched-link " ></a> 
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats " <?=$c?>>
            <div class="card-body py-2 my-2">
                <div class="row ">
                    <div class="col-5 col-md-4">
                        <div class="icon-big text-center">
                            <i class="fas fa-exchange-alt"></i>
                            
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-title">Historian
                            <p>
                            <p class="card-category ">migrasi data cuti</p>
                            
                        </div>
                    </div>
                </div>
            </div>
            <a href="<?=base_url()?>/dashboard/setting/leave_alloc/index.php" class="stretched-link " ></a> 
        </div>
    </div>
    
    
</div>