<?php
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    // jika import dokumen
    if(isset($_GET['loadData'])){
        ?>
        <form action="proses_area.php" id="form-modalLoadArea" method="post">
            <div class="modal-header">
                <button type="button" class="close mb-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title text-left text-uppercase" id="staticBackdropLabel">Data Man Power <?=$_GET['idGroup']?></h5>
                <p class="badge badge-pill"><?=""?></p>
            </div>
            <div class="table-responsive  text-uppercase">
                <table class="table">
                    <thead>
                        <th class="">#</th>
                        <th class="">NPK</th>
                        <th class="">Nama</th>
                        <th>Group</th>
                        <th>Area Produksi</th>
                        <th>Team</th>
                        <th>Nama Pos</th>
                        <th>Labor type</th>
                    </thead>
                    <tbody>
                        
                        <?php
                        // $q_line = mysqli_query($link, "SELECT 
                        // production_area.id_area AS `id`, 
                        // production_area.name AS `prod_name`,
                        // production_type.name AS `prod_type`,
                        // production_model.name AS `nama_model`,
                        // groupfrm.nama_group AS `nama_group`,
                        // production_area.id_shift AS shift, 
                        // production_line.nama AS `nama_line`,
                        // department.dept AS `dept_functional`,
                        // dept_account.department_account AS `dept_account`,
                        // production_area.id_type AS `id_prod_type`,
                        // production_area.id_line AS `id_line`,
                        // production_line.id_model AS `id_model`,
                        // production_area.id_groupfrm AS `id_group`,
                        // production_line.id_dept_account AS `id_dept_account`,
                        // department.id_dept AS `id_dept`

                        // FROM production_area 
                        // JOIN groupfrm ON groupfrm.id_group = production_area.id_groupfrm
                        // JOIN section ON section.id_section = groupfrm.id_section
                        // JOIN department ON department.id_dept = section.id_dept
                        // JOIN production_type ON production_type.id_type = production_area.id_type
                        // JOIN production_line ON production_area.id_line = production_line.id_line
                        // JOIN production_model ON production_model.id_model = production_line.id_model
                        // JOIN dept_account ON dept_account.id_dept_account = production_line.id_dept_account
                        // ")or die(mysqli_error($link));
                        $query = mysqli_query($link, "SELECT * FROM view_production_employee WHERE id_groupfrm = '$_GET[idGroup]' AND (id_production_pos IS NULL OR id_production_pos = '' )  ORDER BY pos_leader ASC")or die(mysqli_error($link));
                        $tot = mysqli_num_rows($query);
                        ?>
                        <input type="hidden" name="totalData" value="<?=$tot?>"/>
                        <?php
               
                        if(mysqli_num_rows($query)>0){
                            $no = 1;
                            while($data = mysqli_fetch_assoc($query)){
                            ?>
                            <tr>
                                <td class=""><?=$no?></td>
                                <td class=""><?=$data['npk']?></td>
                                <td class=""><?=$data['npk']?></td>
                                <td class=""><?=$data['nama']?></td>
                                <td>
                                    <?=$data['nama_group']?>
                                </td>
                                
                                <td>
                                        <?php
                                        $queryArea = mysqli_query($link, "SELECT * FROM production_area WHERE id_groupfrm = '$_GET[idGroup]' AND id_area = '$_GET[loadData]' ")or die(mysqli_error($link));
                                        $data_area= mysqli_fetch_assoc($queryArea);
                                        $dataArea = $data_area['name'];
                                        echo $dataArea;
                                        ?>
                                    
                                </td>
                                <td>
                                    <div class="form-group-sm border-none ">
                                        <select name="inputDataPosLeader-<?=$no?>" required id="inputDataPosLeader-<?=$no?>" class="form-control inputDataArea">
                                            <?php
                                            $queryPosLeader= mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'pos' AND id_parent = '$_GET[idGroup]' ")or die(mysqli_error($link));
                                            if(mysqli_num_rows($queryPosLeader) > 0){
                                                
                                                while($dataPosLeader = mysqli_fetch_assoc($queryPosLeader)){
                                                    $select = ($_GET['idGroup'] == $dataPosLeader['id'])?"selected":""
                                                    ?>
                                                    <option <?=$select?> value="<?=$dataPosLeader['id']?>"><?=$dataPosLeader['nama_org']?></option>
                                                    <?php
                                                }
                                            }else{
                                                ?>
                                                <option disabled >belum ada data</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group-sm border-none ">
                                       <input type="text" required name="inputDataPos-<?=$no?>"class="inputDataPos form-control" id="inputDataPos-<?=$no?>">
                                       <input type="hidden" name="inputDataGroup-<?=$no?>"class="inputDataGroup form-control" id="inputDataGroup-<?=$no?>" value="<?=$_GET['idGroup']?>">
                                       <input type="hidden" name="inputDataNpk-<?=$no?>"class="inputDataNpk form-control" id="inputDataNpk-<?=$no?>" value="<?=$data['npk']?>">
                                       <input type="hidden" name="inputDataArea-<?=$no?>"class="inputDataArea form-control" id="inputDataArea-<?=$no?>" value="<?=$_GET['loadData']?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group-sm border-none ">
                                        <select name="inputDataLabor-<?=$no?>" required id="inputDataLabor-<?=$no?>" class="form-control inputDataArea">
                                            <?php
                                            $queryLabor = mysqli_query($link, "SELECT * FROM labour_type")or die(mysqli_error($link));
                                            if(mysqli_num_rows($queryLabor) > 0){
                                                
                                                while($dataLabor = mysqli_fetch_assoc($queryLabor)){
                                                    ?>
                                                    <option value="<?=$dataLabor['id_labour']?>"><?=$dataLabor['alias']?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                                
                            </tr>
                            <?php
                            $no++;
                            }
                        }else{
                            ?>
                            <tr>
                                <td colspan="10" class="text-uppercase text-center">BELUM ADA DATA</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-center">
                <div class="col-md-12">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Cancel</button>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="updatePosArea">
                            <button type="submit" class="btn btn-info btn-link" >Submit</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
        
        
        <?php
    }else if(isset($_GET['import'])){
    // jika update manual
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
<script>
    $('#form-modalLoadArea').submit(function(e){
        e.preventDefault();
        var form = $(this)[0];
        var data = new FormData(form);
        console.log(data);
        $.ajax({
            url: 'proses_area.php',
            type: 'post',
            enctype: 'multipart/form-data',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                
                $('#modalLoadDataArea').modal('hide')
                $('#modalLoadDataArea').on('hidden.bs.modal', function(){
                    $('.data-pos').load("../ajax/model.php?tab=pos");
                });
                
            },
            error:function(error){
                console.log('error');
            }
        });
    })
</script>