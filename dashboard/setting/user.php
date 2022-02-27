<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "User Settings";
    include_once("../header.php");
    $_SESSION['tab'] = @$_GET['tab'];

?>
<!-- halaman utama -->
<div class="row ">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="pull-left">User Setting</h5>
                <div class="box pull-right">
                    <a href="proses/export.php?export=dataUser" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Export to Excel File">
                        <span class="btn-label">
                            <i class="nc-icon nc-cloud-upload-94"></i>
                        </span>
                        Export
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3 border-right">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
                                    <?php
                                    $s_role = mysqli_query($link, "SELECT * FROM user_role ORDER BY `level` ASC")or die(mysqli_error($link));
                                    $i = 0;
                                    while($user_role = mysqli_fetch_assoc($s_role)){
                                        //menampung id sebaga array tab
                                        $tab[$i] = $user_role['id_role'];
                                    
                                        $nama_role[$i] = $user_role['role_name'];
                                        //membuat tab active terbuka untuk pertama kali
                                        $setTab = (isset($_SESSION['tab']))? $_SESSION['tab'] : $tab[0];
                                        $tab_active = ($setTab == $tab[$i])? "active" :"";
                                    ?>
                                        <li class="nav-item">
                                            <a class="btn btn-sm btn-link btn-round btn-info <?=$tab_active?>" href="#<?=$user_role['id_role']?>" role="tab" data-toggle="tab"><?=$user_role['role_name']?></a>
                                        </li>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div id="my-tab-content" class="tab-content">
                            <?php
                            $i = 0;
                            $set_indexActive = (isset($_SESSION['tab']))? $_SESSION['tab'] : $tab[0];
                            foreach($tab as $id_role){
                                $tab = ($set_indexActive == $id_role)? "active" : "";
                            ?>
                            <div class="tab-pane <?=$tab?>" id="<?=$id_role?>">

                            <h6 class="text-title"><?=$nama_role[$i]?></h6>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="usersetting" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Npk</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Area</th>
                                            <th class="text-right">Action</th>
                                            <th scope="col" class="text-right">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input all checkall<?=$id_role?>" type="checkbox" id="<?=$id_role?>">
                                                    <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="">
                                            <?php
                                            $_user = mysqli_query($link, "SELECT data_user.npk AS npk_user,data_user.pass AS pass, data_user.username AS username, data_user.nama AS nama_user, data_user.level AS level_user, 
                                                karyawan.npk, karyawan.nama AS nama, karyawan.id_area AS id_area
                                                FROM data_user LEFT JOIN karyawan ON karyawan.npk = data_user.npk WHERE data_user.level = '$id_role' ")or die(mysqli_error($link));
                                            $noUser = 1;
                                            if(mysqli_num_rows($_user) > 0){
                                                while($dataUser = mysqli_fetch_assoc($_user)){
                                                    $cek = mysqli_query($link, "SELECT npk FROM karyawan WHERE npk = '$dataUser[npk_user]' ")or die(mysqli_error($link));
                                                    $cekKary = mysqli_num_rows($cek);
                                                    $mark = ($cekKary == 0 )? "background:rgba(255, 0, 0, 0.1)": "";
                                                    
                                                ?>
                                                <tr style="<?=$mark?>" id="<?=$dataUser['npk_user']?>">
                                                    <td><?=$noUser++?></td>
                                                    <td><?=$dataUser['npk_user']?></td>
                                                    <td><?=$dataUser['nama']?></td>
                                                    <td><?=$dataUser['username']?></td>
                                                    <?php
                                                    //UNION
                                                    $union_org = "SELECT id_div AS id , nama_divisi AS nama_org , npk_cord AS cord , id_company AS id_parent FROM division WHERE id_div = '$dataUser[id_area]'
                                                    UNION  SELECT id_dept AS id , dept AS nama_org , npk_cord AS cord , id_div AS id_parent  FROM department WHERE id_dept = '$dataUser[id_area]'
                                                    UNION  SELECT id_section AS id , section AS nama_org , npk_cord AS cord , id_dept AS id_parent FROM section WHERE id_section = '$dataUser[id_area]'
                                                    UNION  SELECT id_group AS id , nama_group AS nama_org , npk_cord AS cord , id_section AS id_parent FROM groupfrm WHERE id_group = '$dataUser[id_area]'
                                                    UNION  SELECT id_post AS id , nama_pos AS nama_org , npk_cord AS cord , id_group AS id_parent FROM pos_leader WHERE id_post = '$dataUser[id_area]'";

                                                    $s_org = mysqli_query($link, $union_org)or die(mysqli_error($link));
                                                    $countOrg = mysqli_num_rows($s_org);
                                                    $dataOrg = mysqli_fetch_assoc($s_org);

                                                    $data_area = (isset($dataUser['id_area']))? "[".$dataUser['id_area']."]" : "";

                                                    // $countOrg = mysqli_num_rows($union_org);
                                                    // echo $countOrg;
                                                    ?>
                                                    <td><?=$dataOrg['nama_org'].$data_area?></td>
                                                    <td class="text-right">
                                                        
                                                        <?php
                                                        
                                                        if($cekKary == 0){?>
                                                            <a href="proses/prosesUser.php?tab=<?=$id_role?>&del=<?=$dataUser['npk_user']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="nc-icon nc-simple-remove"></i></a>
                                                        <?php
                                                        }else{?>
                                                            <a href="edit_user.php?tab=<?=$id_role?>&edit=<?=$dataUser['npk_user']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="nc-icon nc-ruler-pencil"></i></a>
                                                        
                                                        <?php    
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php
                                                        if($cekKary != 0){?>
                                                            <div class="form-check ">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input checkuser user<?=$id_role?>" name="userchecked[]" type="checkbox" value="<?=$dataUser['npk']?>" data="<?=$id_role?>">
                                                                <span class="form-check-sign"></span>
                                                                </label>
                                                            </div>
                                                        
                                                        <?php    
                                                        }
                                                        ?>
                                                        
                                                    </td>
                                                </tr>
                                            <?php  
                                                }
                                                
                                            }else{
                                                echo "<td class=\"bg-light text-center\" colspan=\"9\">tidak ada data</td>";
                                            }
                                            ?>
                                        </tbody>
                                        
                                    </table>
                                </div>  
                                
                                <div class="pull-right" >
                                    
                                    <button class="btn btn-success editall" id="edit<?=$id_role?>">
                                        <span class="btn-label">
                                            <i class="nc-icon nc-ruler-pencil"></i>
                                        </span>
                                        Edit
                                    </button>
                                    
                                </div>
                            
                            </div>
                            
                            <?php
                            $i++;
                            }
                            ?>
                            
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>

<?php
include_once('information.php');
?>
    </div>
<?php

    include_once("../footer.php"); 
    //javascript disini
    ?>

    <script>
    $('.remove').on('click', function(e){
        e.preventDefault();
        var getLink = $(this).attr('href');
        var id = $(this).parents("tr").attr("id");
            
        Swal.fire({
        title: 'Anda Yakin ?',
        text: "Data User dengan NPK : " + id + " akan dihapus secara permanent",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF5733',
        cancelButtonColor: '#B2BABB',
        confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.value) {
                window.location.href = getLink;
            }
        })
        
    });
    </script>
    <script>
    $(document).ready(function(){
        $('.all').on('click', function(){
            var tab = $(this).attr('id');
            if(this.checked){
                $('.user'+tab).each(function() {
                    this.checked = true;
                })
            } else {
                $('.user'+tab).each(function() {
                    this.checked = false;
                })
            }
        });

        $('.checkuser').on('click', function() {
            var idTab = $(this).attr('data');
            if($('.user'+idTab+':checked').length == $('.user'+idTab).length){
                $('.checkall'+idTab).prop('checked', true)
            } else {
                $('.checkall'+idTab).prop('checked', false)
            }
        })
    })
    </script>
    <script>

    $('.editall').on('click', function(e){
        e.preventDefault();
        var getLink = 'mass_editMp.php';

        document.prosesmp.action = getLink;
        document.prosesmp.submit();
    }); 

    </script>

    <?php
    include_once("../endbody.php");
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

