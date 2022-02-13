<?php
$show = (isset($_POST['cari']))? "collapse show" : "collapse";
?>

<form method="POST">
<div class="<?=$show?> " id="data">
    <?php
        include_once('index.php');
    ?>
</div>
<div class="row">
    <div class="col-md-12" id="monitor">
        <div class="card " >
            <div class="card-header ">
                
                <div class="pull-left ">
                   
                    <h4 class="card-title " >Monitor Request Transfer In / Out Man Power</h4>
                    <p class="card-category ">Periode : <?=tgl($tanggalAwal)." s.d. ".tgl($tanggalAkhir)?></p>
                </div>
                <p class="box pull-right ">
                
                    <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#data" aria-expanded="false" aria-controls="data">
                    <i class="nc-icon nc-simple-add "></i> Add Request
                    </button>
                </p>
             
            </div>
            
                <div class="col-5">
                    <div class="input-group border-1">
                        <div class="input-group-prepend ">
                            <div class="input-group-text">
                                <i class="nc-icon nc-calendar-60"></i>
                            </div>
                        </div>
                        <!-- <input  type="text" name="tahun" class=" form-control datepicker" data-date-format="MM-YYYY"> -->
                        <select type="date" name="start" class="form-control " >
                            <option Disabled>Pilih Bulan</option>
                            <?php
                            
                            $i =0;
                            foreach($bln AS $namaBln){
                                $i++;
                                $selectBln = ($i == $sM)?"selected":"";
                                
                                echo "<option  $selectBln value=\"$i\">$namaBln</option>";
                            }
                            ?>
                        </select>
                        <div class="input-group-prepend ml-0">
                            <div class="input-group-text px-2">
                                <i>to</i>
                            </div>
                        </div>
                        <select type="date" name="end" class="form-control " >
                            <option Disabled>Pilih Bulan</option>
                            <?php
                            
                            $i =0;
                            foreach($bln AS $namaBln){
                                $i++;
                                $selectBln = ($i == $eM)?"selected":"";
                                
                                echo "<option  $selectBln value=\"$i\">$namaBln</option>";
                            }
                            ?>
                        </select>
                        <select type="text" name="tahun" class=" form-control ">
                        <option Disabled>Tahun</option>
                        <?php
                        $thnPertama = 2021;
                        for($i=date("Y"); $i>=$thnPertama; $i--){
                            $selectThn = ($i == $tahun)?"selected":"";
                            echo "<option $selectThn value=\"$i\">$i</option>";
                        }
                        ?>
                        </select>
                        <input type="submit" name="sort" class="btn-icon btn btn-round p-0 ml-2 my-auto" value="go" >
                        
                    </div>
                    
                    <!-- <div class="col-4">
                        <input class="btn btn-icon btn-round" name="sort" value="go">
                    </div> -->
                </div>
            
           
            <hr>
            <div class="card-body " >
                <div class="row">
                    <div class="col">
                        <div class="table-responsive" >
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NPK</th>
                                        <th>Nama</th>
                                        <th>Shift</th>
                                        
                                        <th>Transfer</th>
                                        <th>Asal Area / Atasan</th>
                                        <th>Area Tujuan / Atasan</th>
                                        
                                        <th>Progress</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-uppercase">
                                    
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</form>
