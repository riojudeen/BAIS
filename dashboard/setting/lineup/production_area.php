<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <h5 class="card-title pull-left col-md-6" id="lineup_model">
                        <?php
                        $q_model= mysqli_query($link, "SELECT * FROM `production_model` WHERE `id_model` = '$_SESSION[model]'")or die(mysqli_error($link));
                        
                        if(mysqli_num_rows($q_model) > 0){
                            while($data = mysqli_fetch_assoc($q_model)){
                                echo $data['alias']." - ".$data['name'];
                            }
                        }else{
                            echo "Tab Session Tidak Aktif / Salah";
                        }
                        ?>

                    </h5>
                    <div class="col-md-6 text-right">
                        <div class="dropdown dropleft">
                            <button class="btn btn-sm btn-primary btn-icon btn-round" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-header">Menu</div>
                                <a class="dropdown-item" href="proses/export.php?export=organization">Export Data</a>
                                <a class="dropdown-item" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Import Data</a>
                                <a class="dropdown-item" data-toggle="modal" data-target="#generate" >Tambah Area</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="view_data">
                    
                </div>
            </div>
            
        </div>
    </div>
</div>