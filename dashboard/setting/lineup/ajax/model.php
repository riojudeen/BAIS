<style>

    .view {
    margin: auto;
    width: 600px;
    }
    tr:hover td
    { background: #F4F4F4;
    }
    .wrapper {
    position: relative;
    overflow: auto;
    border: 1px solid black;
    white-space: nowrap;
    }

    .sticky-col {
    position: -webkit-sticky;
    position: sticky;
    background-color: white;
    }

    .first-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    left: 0px;
    
    }

    .first-top-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    top: 0px;
    z-index: 600;
    }

    .second-col {
    width: 50px;
    min-width: 50px;
    max-width: 150px;
    left: 100px;
    }
    .second-top-col {
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    top: 0px;
    z-index: 600;
    }

    .third-col {
    width: 200px;
    min-width: 200px;
    max-width: 200px;
    left: 150px;
    }
    .third-top-col {
    width: 200px;
    min-width: 200px;
    max-width: 200px;
    top: 0px;
    z-index: 600;
    }
    .fourth-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    left: 350px;
    }
    .fourth-top-col {
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    top: 0px;
    z-index: 600;
    }

    .first-last-col {
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    right: 0px;
    }
    .first-last-top-col {
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    top: 0px;
    z-index: 600;
    }

    .second-last-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    right: 50px;
    }
    .second-last-top-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    top: 0px;
    z-index: 600;
    }
    th {
    background: white;
    position: sticky;
    top: 0;
    z-index: 500;
    }

</style>
<?php
require_once("../../../../config/config.php");
// $_GET['data_area'] = 'tes';
// $_GET['tab'] = 'model';
// $_GET['data_model'] = 'model';
// $_GET['stats'] = 'active';
// $_GET['alias'] = 'DDD';
// $_GET['data_group'] = "1-001-000-000-001";
// $_GET['lineData'] = "1";
// $_GET['typeData'] = "2";
// $_GET['data_shift'] = "A";
// $_GET['data_deptAcc'] = "tes";
// $_GET['modelData'] = "tes";

if(isset($_POST['data_model'])){
    $data = $_POST['data_model'];
    $stats = $_POST['stats'];
    $alias = $_POST['alias'];
    print_r($_FILES);
    // print_r($_FILES['upload_img']['tmp_name']);
    $id_model = idIncrement($link, "production_model","id_model");
    // echo $_FILES['upload_img']['tmp_name'];
    
    mysqli_query($link, "INSERT INTO production_model (`id_model`,`name`,`alias`,`stats`) VALUES ('$id_model','$data','$alias','$stats')")or die(mysqli_error($link));
}else if(isset($_GET['proses'])){
    if($_GET['proses']=='delete_model'){
        mysqli_query($link, "DELETE FROM production_model WHERE id_model = '$_GET[data]'")or die(mysqli_error($link));
    }else if($_GET['proses']=='delete_line'){
        mysqli_query($link, "DELETE FROM production_line WHERE id_line = '$_GET[data]'")or die(mysqli_error($link));
    }else if($_GET['proses']=='delete_area'){
        mysqli_query($link, "DELETE FROM production_area WHERE id_area = '$_GET[data]'")or die(mysqli_error($link));
    }else if($_GET['proses']=='delete_pos'){
        mysqli_query($link, "DELETE FROM pos WHERE id_post = '$_GET[data]'")or die(mysqli_error($link));
        $q_npk = mysqli_query($link, "SELECT npk FROM org WHERE sub_post = '$_GET[data]'")or die(mysqli_error($link));
        $dataNpk = mysqli_fetch_assoc($q_npk);
        mysqli_query($link, "UPDATE org SET sub_post = NULL WHERE npk = '$dataNpk[npk]'")or die(mysqli_error($link));
    }
}else if(isset($_GET['data_line'])){
    $data = $_GET['data_line'];
    $id_dept_account = $_GET['data_deptAcc'];
    $id_model = $_GET['modelData'];
    $id_line = idIncrement($link, "production_line","id_line");
    mysqli_query($link, "INSERT INTO production_line (`id_line`,`nama`,`id_dept_account`,`id_model`) VALUES ('$id_line','$data','$id_dept_account','$id_model')")or die(mysqli_error($link));
}else if(isset($_GET['data_area'])){
    $data = $_GET['data_area'];
    $group = $_GET['data_group'];
    $line = $_GET['lineData'];
    $type = $_GET['typeData'];
    $shift = $_GET['data_shift'];
    $id_area = idIncrement($link, "production_area","id_area");
    mysqli_query($link, "INSERT INTO production_area (`id_area`,`name`,`id_groupfrm`,`id_type`,`id_shift`, `id_line`) VALUES ('$id_area','$data','$group','$type','$shift','$line')")or die(mysqli_error($link));
}
?>

<?php
if(isset($_GET['tab'])){
    if($_GET['tab'] == "model"){
        ?>
        
        <div class="row">
            <div class="col-md-12">
                <h6>Data</h6>
                <div class="table-hover">
                    <table class="table">
                        <thead>
                            <th class="text-left">action</th>
                            <th>#</th>
                            <th>img</th>
                            <th>model</th>
                            <th>alias</th>
                            <th>stats</th>
                        </thead>
                        <tbody>
                            <?php
                            $q_model = mysqli_query($link, "SELECT * FROM production_model ORDER BY id_model DESC")or die(mysqli_error($link));
                            if(mysqli_num_rows($q_model)>0){
                                $no = 1;
                                while($data = mysqli_fetch_assoc($q_model)){
                                    $color = ($data['stats']=='active')?'warning':'default';
                                ?>
                                <tr id="<?=$data['id_model']?>">
                                    <td class="text-left">
                                        <a href="modal.php?editmodel=<?=$data['id_model']?>" data-id="<?=$data['id_model']?>" class="edit btn-warning btn btn-sm btn-icon btn-round ">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="proses/proses.php?del=<?=$data['id_model']?>" data-id="<?=$data['id_model']?>" class="btn-danger btn btn-sm btn-icon btn-round delete_model">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                    <td><?=$no++?></td>
                                    <td>
                                        <img src="<?=base_url()?>/assets/img/unit_model/<?=$data['alias']?>.png" alt="..." style="width:100px">
                                    </td>
                                    <td><?=$data['name']?></td>
                                    <td><?=$data['alias']?></td>
                                    <td>
                                        <div class="badge badge-<?=$color?> badge-pill">
                                            <?=$data['stats']?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                }
                            }else{
                                ?>
                                <tr>
                                    <td colspan="6" class="text-uppercase text-center">BELUM ADA DATA</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    }else if($_GET['tab'] == "line"){
        ?>
        
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <th class="text-left">action</th>
                            <th>#</th>
                            <th>LINE</th>
                            <th>unit produksi</th>
                            <th>department account</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            
                            <?php
                            $q_line = mysqli_query($link, "SELECT 
                            `id`,`nama_line`,`nama_model`,`alias_model`,`stats_model`,`id_dept_account`,`nama_dept`,`npk_cord`,`nama_cord`
                            FROM view_production_line")or die(mysqli_error($link));
                            
                            if(mysqli_num_rows($q_line)>0){
                                $no = 1;
                                while($data = mysqli_fetch_assoc($q_line)){
                                    $color = ($data['stats_model']=='active')?'warning':'default';
                                ?>
                                <tr>
                                    <td class="text-left">
                                        <a href="modal.php?editline=<?=$data['id']?>" data-id="<?=$data['id']?>"  class=" edit btn-warning btn btn-sm btn-icon btn-round">
                                        <i class="far fa-edit"></i>
                                        </a>
                                        <a href="proses/proses.php?del=<?=$data['id']?>" data-id="<?=$data['id']?> "class="btn-danger btn btn-sm btn-icon btn-round delete_line">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                    <td><?=$no++?></td>
                                    <td><?=$data['nama_line']?></td>
                                    <td><?=$data['nama_model']?></td>
                                    <td><?=$data['nama_dept']?></td>
                                    <td>
                                        <div class="badge badge-<?=$color?> badge-pill">
                                        <?=$data['stats_model']?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                }
                            }else{
                                ?>
                                <tr>
                                    <td colspan="6" class="text-uppercase text-center">BELUM ADA DATA</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }else if($_GET['tab'] == "area"){
        ?>
        
        <div class="row">
            
            <div class="col-md-12">
                <div class="table-responsive  text-uppercase">
                    <table class="table">
                        <thead>
                            <th class="text-left sticky-col first-col first-top-col">action</th>
                            <th class="sticky-col second-col second-top-col">#</th>
                            <th class="sticky-col third-col third-top-col">area</th>
                            <th class="sticky-col fourth-col fourth-top-col">tipe prod</th>
                            <th>group</th>
                            <th>shift</th>
                            <th>model </th>
                            <th>line </th>
                            <th>department</th>
                            <th>account</th>
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
                            $q_line = mysqli_query($link, "SELECT * FROM view_production_area ORDER BY id_model DESC")or die(mysqli_error($link));
                            
                            if(mysqli_num_rows($q_line)>0){
                                $no = 1;
                                while($data = mysqli_fetch_assoc($q_line)){
                                ?>
                                <tr>
                                    <td class="text-left sticky-col first-col">
                                        <a href="modal.php?editarea=<?=$data['id']?>" data-id="<?=$data['id']?>" class="edit btn-warning btn btn-sm btn-icon btn-round edit">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="proses/proses.php?del=<?=$data['id']?>" data-id="<?=$data['id']?>" class="btn-danger btn btn-sm btn-icon btn-round delete_pos">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                    <td class="sticky-col second-col"><?=$no++?></td>
                                    <td class="sticky-col third-col"><?=$data['prod_name']?></td>
                                    <td class="sticky-col fourth-col"><?=$data['prod_type']?></td>
                                    <td><?=$data['nama_group']?></td>
                                    <td><?=$data['shift']?></td>
                                    <td><?=$data['nama_model']?></td>
                                    <td><?=$data['nama_line']?></td>
                                    <td><?=$data['dept_functional']?></td>
                                    <td><?=$data['dept_account']?></td>
                                </tr>
                                <?php
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
            </div>
        </div>
        <?php
        
    }else if($_GET['tab'] == "pos"){
    //  $query =    "SELECT
    // `bais_db`.`karyawan`.`npk` AS `npk`,
    // `bais_db`.`karyawan`.`nama` AS `nama`,
    // `bais_db`.`karyawan`.`jabatan` AS `jabatan`,
    // `bais_db`.`pos`.`nama` AS `production_pos`,
    // `bais_db`.`pos_leader`.`nama_pos` AS `pos_leader`,
    // `bais_db`.`groupfrm`.`nama_group` AS `nama_group`,
    // `bais_db`.`production_area`.`name` AS `production_area`,
    // `bais_db`.`production_area`.`id_shift` AS `production_shift`,
    // `bais_db`.`production_type`.`name` AS `production_type`,
    // `bais_db`.`production_line`.`nama` AS `production_line`,
    // `bais_db`.`production_model`.`name` AS `unit_model`,
    // `bais_db`.`production_model`.`alias` AS `model_alias`,
    // `bais_db`.`production_model`.`stats` AS `production_stats`,
    // `bais_db`.`pos`.`id_post` AS `id_production_pos`,
    // `bais_db`.`production_area`.`id_area` AS `id_production_area`,
    // `bais_db`.`pos_leader`.`id_post` AS `id_pos_leader`,
    // `bais_db`.`groupfrm`.`id_group` AS `id_groupfrm`,
    // `bais_db`.`dept_account`.`department_account` AS `department`,
    // `bais_db`.`pos`.`employee_type` AS `id_labor_type`,
    // `bais_db`.`labour_type`.`type` AS `labor_type`,
    // `bais_db`.`pos`.`ct` AS `cycle_time`
    // FROM ((((((((((`bais_db`.`karyawan`
    // JOIN `bais_db`.`org` ON (`bais_db`.`org`.`npk` = `bais_db`.`karyawan`.`npk`))
    // LEFT JOIN `bais_db`.`pos` ON (`bais_db`.`org`.`sub_post` = `bais_db`.`pos`.`id_post`))
    // LEFT JOIN `bais_db`.`labour_type` ON (`bais_db`.`pos`.`employee_type` = `bais_db`.`labour_type`.`id_labour`))
    // LEFT JOIN `bais_db`.`pos_leader` ON (`bais_db`.`org`.`post` = `bais_db`.`pos_leader`.`id_post`))
    // LEFT JOIN `bais_db`.`groupfrm` ON (`bais_db`.`org`.`grp` = `bais_db`.`groupfrm`.`id_group`))
    // LEFT JOIN `bais_db`.`production_area` ON (`bais_db`.`production_area`.`id_area` = `bais_db`.`pos`.`id_prod_area`))
    // LEFT JOIN `bais_db`.`production_type` ON (`bais_db`.`production_type`.`id_type` = `bais_db`.`production_area`.`id_type`))
    // LEFT JOIN `bais_db`.`production_line` ON (`bais_db`.`production_line`.`id_line` = `bais_db`.`production_area`.`id_line`)) 
    // LEFT JOIN `bais_db`.`production_model` ON (`bais_db`.`production_model`.`id_model` = `bais_db`.`production_line`.`id_model`)) 
    // LEFT JOIN `bais_db`.`dept_account` ON (`bais_db`.`dept_account`.`id_dept_account` = `bais_db`.`production_line`.`id_dept_account`))";
    
    ?>
        <div class="row">
            <div class="col-md-4">
                <label for="">Pos Leader</label>
                <div class="form-group-sm">
                    <select required name="posPosLeader" id="posPosLeader" class="form-control posPosLeader">
                    <?php
                        $query = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'pos' ")or die(mysqli_error($ink));
                        if(mysqli_num_rows($query)>0){
                            while($data = mysqli_fetch_assoc($query)){
                                ?>
                                <option value="<?=$data['id']?>"><?=$data['nama_org']?></option>
                                <?php
                            }
                        }else{
                            ?>
                            <option disabled>Belum ada data</option>

                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive  text-uppercase">
                    <table class="table">
                        <thead>
                            <th class="text-left sticky-col first-col first-top-col">action</th>
                            <th class="">#</th>
                            <th class="">NPK</th>
                            <th class="">Nama</th>
                            <th>Nama Pos</th>
                            <th>Area</th>
                            <th>Team Leader</th>
                            <th>Group</th>
                            <th>DL/IDL</th>
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
                            $query = mysqli_query($link, "SELECT * FROM view_production_employee WHERE id_production_pos IS NOT NULL ORDER BY pos_leader ASC")or die(mysqli_error($link));
                            
                            if(mysqli_num_rows($query)>0){
                                $no = 1;
                                while($data = mysqli_fetch_assoc($query)){
                                ?>
                                <tr>
                                    <td class="text-left sticky-col first-col">
                                        <a href="modal.php?editpos=<?=$data['npk']?>" data-id="<?=$data['npk']?>" class="edit btn-warning btn btn-sm btn-icon btn-round edit">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="proses/proses.php?del=<?=$data['id_production_pos']?>&npkMP=<?=$data['npk']?>" id='<?=$data['npk']?>' data-id="<?=$data['id_production_pos']?>" class="btn-danger btn btn-sm btn-icon btn-round delete_pos">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                    <td class=""><?=$no++?></td>
                                    <td class=""><?=$data['npk']?></td>
                                    <td class=""><?=$data['nama']?></td>
                                    <td><?=$data['production_pos']?></td>
                                    <td><?=$data['production_area']?></td>
                                    <td><?=$data['pos_leader']?></td>
                                    <td><?=$data['nama_group']?></td>
                                    <td><?=$data['labor_type']?></td>
                                </tr>
                                <?php
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
            </div>
        </div>
        <?php
        
    }else{
        echo "tidak ada";
    }
}else{
    echo "tidak ada";
}
?>
<script>
    deleteData('.delete_model','../ajax/model.php','../ajax/model.php?tab=model','get','.data-model','delete_model');
    deleteData('.delete_line','../ajax/model.php','../ajax/model.php?tab=line','get','.data-line','delete_line');
    deleteData('.delete_area','../ajax/model.php','../ajax/model.php?tab=area','get','.data-area','delete_area');
    deleteData('.delete_pos','../ajax/model.php','../ajax/model.php?tab=pos','get','.data-pos','delete_pos');
    
    $('.edit').click(function(e){
        e.preventDefault();
        var link = $(this).attr('href')
        var data = $(this).attr('data-id');
        // console.log(link);
        $.ajax({
            url: link,
            type: 'POST',
            data: {data:data},
            success: function(resp){
                $('.modalEdit').load(link, function(){
                    $('#dataModal').modal('show'); 
                });
            }
        })
    })
    // // $('.delete_model').on('click', function(e){
    // //     e.preventDefault();
    // //     var id = $(this).attr('data-id');
    // //     console.log(id)
    // //     Swal.fire({
    // //     title: 'Anda Yakin ?',
    // //     text: "Semua data yang dicheck / centang akan dihapus permanent",
    // //     icon: 'warning',
    // //     showCancelButton: true,
    // //     confirmButtonColor: '#FF5733',
    // //     cancelButtonColor: '#B2BABB',
    // //     confirmButtonText: 'Yes, delete!'
        
    // //     }).then((result) => {
    // //         if (result.value) {
    // //             $.ajax({
    // //                 url: '../ajax/model.php',
    // //                 method: 'get',
    // //                 data: {delete_model:id},
    // //                 success:function(data){
    // //                     $('.data-model').fadeOut(100, function(){
    // //                         $(this).load( "../ajax/model.php?tab=model", function() {
    // //                             $(this).fadeIn(1000);
    // //                         });

    // //                     })
    // //                     // $('.data-model').load("../ajax/model.php?tab=model"),function() {
    // //                     //     $(this).fadeIn(1500);  // or another bigger number based on your load time
    // //                     // };
    // //                     // Swal.fire({
    // //                     //     icon: 'success',
    // //                     //     title: 'Sukses',
    // //                     //     text: 'data Berhasil',
    // //                     // })
                        
    // //                 }
    // //             })
    // //         }
    // //     })
        
    // });
</script>