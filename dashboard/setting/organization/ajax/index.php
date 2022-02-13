<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
    if(isset($_POST['id'])){
        $id = $_POST['id'];
        // echo $id;
        if($id == 'pos'){
            $qOrg = "SELECT 
                c.nama AS cord_name , 
                c.jabatan AS jabatan,
                a.id_post AS id ,
                a.nama_pos AS `name` ,
                a.npk_cord AS cord ,
                a.id_group AS id_parent,

                b.id_group AS parent ,
                b.nama_group AS parent_name 
                FROM pos_leader AS a
                LEFT JOIN groupfrm AS b ON a.id_group = b.id_group 
                LEFT JOIN karyawan AS c ON c.npk = a.npk_cord ";
                $nama_area = "Team";
                

        }else if($id == 'group'){
            $qOrg = "SELECT 
                c.nama AS cord_name , 
                c.jabatan AS jabatan,
                a.id_group AS id ,
                a.nama_group AS `name` ,
                a.npk_cord AS cord ,
                a.id_section AS id_parent,

                b.id_section AS parent ,
                b.section AS parent_name 
                FROM groupfrm AS a
                LEFT JOIN section AS b ON a.id_section = b.id_section
                LEFT JOIN karyawan AS c ON c.npk = a.npk_cord " ;
                $nama_area = "Group Process";
                

        }else if($id == 'section'){
            $qOrg = "SELECT 
                c.nama AS cord_name , 
                c.jabatan AS jabatan,
                a.id_section AS id ,
                a.section AS `name` ,
                a.npk_cord AS cord ,
                a.id_dept AS id_parent,

                b.id_dept AS parent ,
                b.dept AS parent_name 
                FROM section AS a
                LEFT JOIN department AS b ON a.id_dept = b.id_dept
                LEFT JOIN karyawan AS c ON c.npk = a.npk_cord ";
                $nama_area = "Section Area";
                

        }else if($id == 'dept'){
            $qOrg = "SELECT 
                c.nama AS cord_name , 
                c.jabatan AS jabatan,
                a.id_dept AS id ,
                a.dept AS `name` ,
                a.npk_cord AS cord ,
                a.id_div AS id_parent,

                b.id_div AS parent ,
                b.nama_divisi AS parent_name 
                FROM department AS a
                LEFT JOIN division AS b ON a.id_div = b.id_div
                LEFT JOIN karyawan AS c ON c.npk = a.npk_cord ";
                $nama_area = "Department Functional";
                
        }else if($id == 'deptacc'){
            $qOrg = "SELECT 
                c.nama AS cord_name , 
                c.jabatan AS jabatan,
                a.id_dept_account AS id ,
                a.department_account AS `name` ,
                a.npk_dept AS cord ,
                a.id_div AS id_parent,

                b.id_div AS parent ,
                b.nama_divisi AS parent_name 
                FROM dept_account AS a
                LEFT JOIN division AS b ON a.id_div = b.id_div
                LEFT JOIN karyawan AS c ON c.npk = a.npk_dept " ;
                $nama_area = "Department Account";
                
        }else if($id == 'division'){
            $qOrg = "SELECT 
                c.nama AS cord_name , 
                c.jabatan AS jabatan,
                a.id_div AS id ,
                a.nama_divisi AS `name` ,
                a.npk_cord AS cord ,
                a.id_company AS id_parent,

                b.id_company AS parent ,
                b.nama AS parent_name 
                FROM division AS a
                LEFT JOIN company AS b ON a.id_company = b.id_company
                LEFT JOIN karyawan AS c ON c.npk = a.npk_cord ";
                $nama_area = "Division";
        }
        // menghitung jumah data total
        $sOrg = mysqli_query($link, $qOrg)or die(mysqli_error($link));
        $jml = mysqli_num_rows($sOrg);
        // echo $jml;
        // echo $qOrg;
        // unset ($_SESSION['sort']);
        if(isset($_GET['sort'])){
            if($_GET['sort'] > $jml ){
                $batas = $jml;
            }else if($_GET['sort'] <= 0){
                $batas = 20;
            }else{
                $batas = $_GET['sort'];
            }
        }else{
            $batas = 20;
        }
        if($jml > 0){
            $jml_hal = ceil($jml / $batas);
        }else{
            $jml_hal = 0;
        }

        $hal = (@$_GET['hal'] > $jml_hal)? 1 : @$_GET['hal'];
        $cari = (@$_GET['cari'] != '') ? @$_GET['cari'] : "";
        
        // jika tidak ada get halaman
        if(empty($hal)){
            $_SESSION['tab'] = $id;
            $posisi = 0;
            $hal = 1;
            
        } else {
            // jika ada get halaman
            $_SESSION['tab'] = $id;
            $posisi = ($hal - 1) * $batas; 
        }
        
        // query data jika tidak ada pencarian
        if(empty($cari)){
            $_SESSION['tab'] = $id;
            // gunakan limitation
            $qOrg = $qOrg." LIMIT $posisi, $batas" ; 
            $sOrg = mysqli_query($link, $qOrg)or die(mysqli_error($link));
        }else{
            if($id == 'pos'){
                $nama_cord = 'c.nama';
                $namaArea = 'a.nama_pos';
                $npkCord = 'a.npk_cord' ;
                $namaParent =  'b.nama_group';
            }else if($id == 'group'){
                $nama_cord = 'c.nama';
                $namaArea = 'a.nama_group';
                $npkCord = 'a.npk_cord' ;
                $namaParent =  'b.section';
            }else if($id == 'section'){
                $nama_cord = 'c.nama';
                $namaArea = 'a.section';
                $npkCord = 'a.npk_cord' ;
                $namaParent =  'b.dept';
            }else if($id == 'dept'){
                $nama_cord = 'c.nama';
                $namaArea = 'a.dept';
                $npkCord = 'a.npk_cord' ;
                $namaParent =  'b.nama_divisi';
            }else if($id == 'deptacc'){
                $nama_cord = 'c.nama';
                $namaArea = 'a.department_account';
                $npkCord = 'a.npk_dept' ;
                $namaParent =  'b.nama_divisi';
            }else if($id == 'division'){
                $nama_cord = 'c.nama';
                $namaArea = 'a.nama_divisi';
                $npkCord = 'a.npk_cord' ;
                $namaParent =  'b.nama';
            }
            $_SESSION['tab'] = $id;
            $qOrg = $qOrg." WHERE $nama_cord LIKE '%$cari%' OR $namaArea LIKE '%$cari%' OR $npkCord LIKE '%$cari%' OR $namaParent LIKE '%$cari%'" ; 
            $sOrg = mysqli_query($link, $qOrg)or die(mysqli_error($link));
        }
        // echo $qOrg;
        // echo $batas."</br>";
        // echo $posisi."</br>";
        // 
        

        $index_hal = 2;
        $start = ($hal > $index_hal) ? $hal - $index_hal : 1;
        $next = $hal + 1;

        $end = ($hal < ($jml_hal - $index_hal)) ? $hal + $index_hal : $jml_hal;
        ?>
    <hr>
    <h5 class="title" id="page-<?=$id?>">Data Register <?=$nama_area?></h5>
    <?php
    require_once('../../../component/sorter.php');
    ?>
    <div class="table-responsive" >
        <table class="table table_org text-uppercase " id="datamonitoring" data-id="<?=$id?>" cellspacing="0" width="100%">
            <thead>
                <tr class="">
                    <th>#</th>
                    <th colspan="2">Area</th>
                    <th colspan="2">Kordinator Area</th>
                    <th>Induk Organsasi</th>
                    <th class="text-right">Action</th>
                    <th scope="col" class="text-right">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input checkall" type="checkbox" id="check-<?=$id?>" >
                            <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </th>
                </tr>
            </thead>
                <tbody>
                    <?php
                    $noOrg = 1;
                    if(mysqli_num_rows($sOrg) > 0){
                        while($dOrg = mysqli_fetch_assoc($sOrg)){
                        $qry_expat = mysqli_query($link, "SELECT * FROM expatriat WHERE npk = '$dOrg[cord]' ")or die(mysqli_error($link));
                        $expatcolor = (mysqli_num_rows($qry_expat) > 0 )? "table-info": "";
                        
                        if($id == 'pos'){
                            $subArea = mysqli_query($link, "SELECT id_post FROM pos WHERE id_pos_leader = '$dOrg[id]' ")or die(mysqli_error($link));
                            $sub = (mysqli_num_rows($subArea) > 0) ? mysqli_num_rows($subArea)." sub area" : "";
                        }else if($id == 'group'){
                            $subArea = mysqli_query($link, "SELECT id_post FROM pos_leader WHERE id_group = '$dOrg[id]' ")or die(mysqli_error($link));
                            $sub = (mysqli_num_rows($subArea) > 0) ? mysqli_num_rows($subArea)." sub area" : "";
                            
                        }else if($id == 'section'){
                            $subArea = mysqli_query($link, "SELECT id_group FROM groupfrm WHERE id_section = '$dOrg[id]' ")or die(mysqli_error($link));
                            $sub = (mysqli_num_rows($subArea) > 0) ? mysqli_num_rows($subArea)." sub area" : "";
                        }else if($id == 'dept'){
                            $subArea = mysqli_query($link, "SELECT id_section FROM section WHERE id_dept = '$dOrg[id]' ")or die(mysqli_error($link));
                            $sub = (mysqli_num_rows($subArea) > 0) ? mysqli_num_rows($subArea)." sub area" : "";
                        }else if($id == 'deptacc'){
                            $subArea = mysqli_query($link, "SELECT id_section FROM section WHERE id_dept = '$dOrg[id]' ")or die(mysqli_error($link));
                            $sub = (mysqli_num_rows($subArea) > 0) ? mysqli_num_rows($subArea)." sub area" : "";
                        }else if($id == 'division'){
                            $subArea = mysqli_query($link, "SELECT id_dept FROM department WHERE id_div = '$dOrg[id]' ")or die(mysqli_error($link));
                            $sub = (mysqli_num_rows($subArea) > 0) ? mysqli_num_rows($subArea)." sub area" : "";
                        }
                        // echo $dOrg['id'];
                        ?>
                        
                        <tr class="<?=$dOrg['id']?> <?=$expatcolor?>">
                            <td><?=$noOrg++?></td>
                            <td><?=$dOrg['name']?></td>
                            <td><span class="badge badge-pill badge-info"><?=$sub?></span></td>
                            <td><?=$dOrg['cord']?></td>
                            <td><?=$dOrg['cord_name']?></td>
                            <td><?=$dOrg['parent_name']?></td>
                            
                            <td class="text-right text-nowrap">
                            
                                <!-- <span class="dropdown">
                                    <button class="btn btn-success btn-sm btn-link btn-icon btn-round" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-user"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton">
                                        <div class="dropdown-header">Menu</div>
                                        <a class="dropdown-item" href="">View Employee</a>
                                        <a class="dropdown-item" href="">Add Employee</a>
                                    </div>
                                </span> -->
                                <a href="proses/edit.php?<?=$id?>[]=<?=$dOrg['id']?>" class="btn-round  btn-warning btn btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                <a href="proses/prosesOrg.php?del<?=$id?>=<?=$dOrg['id']?>" class="btn btn-round  btn-danger  btn-icon btn-sm remove"><i class="fas fa-eraser"></i></a>
                                
                            </td>
                            <td class="text-right">
                                <div class="form-check text-right">
                                    <label class="form-check-label">
                                        <input class="form-check-input check-<?=$id?> checkone" name="<?=$id?>[]" value="<?=$dOrg['id']?>" type="checkbox" data="<?=$id?>">
                                    <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <?php
                        }
                    }else{
                        ?>
                        <tr>
                            <td colspan="8" class="text-muted bg-light text-uppercase text-center">TIDAK ADA DATA DI DATABASE</td>
                        </tr>
                    <?php
                    }
                    ?>
                    
                </tbody>
            </table>
        </div>  
    </div>
    <?php
    if($jml > 0){
        $display = '';
    }else{
        $display = 'd-none';

    }
    ?>
    <div class="row <?=$display?>">
        <div class="col-md-6 text-left ">
            <ul class="pagination pagination-sm">
                <?php
                if($hal == 1){
                    ?>
                    <li class="page-item disabled"><a class="page-link btn-primary page" href="#mainpage" aria-label="Previous">FIRST</a></li>
                    <li class="page-item disabled"><a class="page-link btn-primary page" href="#mainpage" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span></a></li>
                    <?php
                } else{
                    $prev = ($hal > 1)? $hal - 1 : 1;
                    ?>
                    <li class="page-item"><a class="page-link btn-primary page" data-id="1" href="#mainpage" aria-label="Previous">FIRST</a></li>
                    <li class="page-item"><a class="page-link btn-primary page" data-id="<?=$prev?>" href="?hal=<?=$prev?>" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span></a></li>
                    <?php
                }
                for($i = $start; $i <= $end; $i++){
                    $link_active = ($hal == $i)? ' active' : '';
                    ?>
                    <li class="page-item <?=$link_active?>"><a href="?hal=<?=$i?>&sort=<?=$_GET['sort']?>#mainpage" data-id="<?=$i?>" class="page-link btn-primary btn-link page"><?=$i?></a></li>
                    <?php
                }
                if($hal == $jml_hal){
                    ?>
                    <li class="page-item disabled"><a class="page-link btn-primary btn-link page" data-id="#" href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                    <li class="page-item disabled"><a class="page-link btn-primary btn-link page" data-id="#" href="#">LAST</a></li>
                    <?php
                } else{
                    ?>
                    <li class="page-item"><a class="page-link btn-primary btn-link page" data-id="<?=$next?>" href="?hal=<?=$next?>&sort=<?=$_GET['sort']?>#mainpage"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                    <li class="page-item"><a class="page-link btn-primary btn-link page" data-id="<?=$jml_hal?>" href="?=<?=$jml_hal?>&sort=<?=$_GET['sort']?>#mainpage">LAST</a></li>
                    <?php
                }
                ///////////////////////////////////////////////////////////////
            ?>
            </ul>
        </div>
        <div class="col-md-6 text-right">
            <span class="badge badge-pill badge-primary">total data ditemukan : <?=$jml?></span>
        </div>
    </div>
        

    <script>
    $(document).ready(function(){
        $('.checkall').on('click', function(){
            var child = $(this).attr('id');
            // console.log(child);
            if(this.checked){
                $('.'+child).each(function() {
                    this.checked = true;
                })
            } else {
                $('.'+child).each(function() {
                    this.checked = false;
                })
            }
        });

        $('.checkone').on('click', function() {
            var parent = $(this).attr('data');
            if($('.check-'+parent+':checked').length == $('.check-'+parent).length){
                $('.checkall').prop('checked', true)
            } else {
                $('.checkall').prop('checked', false)
            }
        })
    })
    </script>
    <script>
    //konfirmasi delete

        $('.remove').on('click', function(e){
            e.preventDefault();
            var getLink = $(this).attr('href');
                
            Swal.fire({
            title: 'Anda Yakin ?',
            text: "Data Akan Dihapus Permanent",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF5733',
            cancelButtonColor: '#B2BABB',
            confirmButtonText: 'Yes, delete!'
            }).then((result) => {
                if (result.value) {
                    document.organization.action = getLink;
                    document.organization.submit();
                }
            })
            
        });
        
    </script>
    
<?php
    }else{
        // echo "gagal";
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
