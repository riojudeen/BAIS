<?php
//////////////////////////////////////////////////////////////////////
require("../../../../config/config.php");
$id_role = $_GET['id'];
$query_role = mysqli_query($link, "SELECT * FROM user_role WHERE id_role = '$id_role' ")or die(mysqli_error($link));
$dataRrole = mysqli_fetch_assoc($query_role);
$role = $dataRrole['role_name'];
$pencarian = (isset($_GET['cari']))?$_GET['cari']:"";
if($pencarian != ''){
    $cari = " AND (npk LIKE '%$pencarian%' OR nama LIKE '%$pencarian%' )";
}else{
    $cari = '';
}
// echo $pencarian;
// echo $id_role;
?>
<div class="tab-pane " id="">
<?php
?>
    <div class="row">
        <h6 class="text-title col-md-8"><?=$role?></h6>
        
    </div>
    <form class="table-responsive" name="proses">
        <table class="table table-hover" id="usersetting" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Npk</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Dept</th>
                <th class="text-right">Action</th>
                <th scope="col" class="text-right">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input all check-all" type="checkbox" >
                        <span class="form-check-sign"></span>
                        </label>
                    </div>
                </th>
            </tr>
            </thead>
            <tbody class="">
                <?php
                $q_data = "SELECT * FROM view_user 
                WHERE `level_user` = '$id_role' ";
                $batas = 50;
                if(isset($_GET['hal'])){
                    $hal = $_GET['hal'];
                    $offset = ($hal - 1)* $batas;
                    $sql_data = mysqli_query($link, $q_data." LIMIT $offset, $batas")or die(mysqli_error($link));
                    // echo "yes";
                    // echo $batas;
                }else{
                    $hal = 1;
                    $offset = ($hal - 1)* $batas;
                    $sql_data = mysqli_query($link, $q_data." LIMIT $offset, $batas")or die(mysqli_error($link));
                    // echo "no";
                }

                if(isset($_GET['cari']) AND $_GET['cari'] != ''){
                    $sql_data = mysqli_query($link, $q_data.$cari." LIMIT $offset, $batas ")or die(mysqli_error($link));
                    $q_jml = mysqli_query($link, $q_data.$cari." LIMIT $offset, $batas ")or die(mysqli_error($link));
                    $jml = mysqli_num_rows($q_jml );
                    // echo "yes";
                }else{
                    $sql_data = $sql_data;
                    $_GET['cari'] = '';
                    $q_jml = mysqli_query($link, $q_data)or die(mysqli_error($link));
                    $jml = mysqli_num_rows($q_jml); 
                    // echo "no";
                }

              
                // $sql_data = mysqli_query($link, $q_data)or die(mysqli_error($link));
                if(mysqli_num_rows($sql_data)>0){
                    $no= $offset + 1;
                    while($data = mysqli_fetch_assoc($sql_data)){
                        ?>
                        <tr  id="<?=$data['npk']?>">
                            <td><?=$no++?></td>
                            <td><?=$data['npk']?></td>
                            <td><?=$data['nama']?></td>
                            <td><?=$data['username']?></td>
                            <td><?=$data['nama_dept']?></td>
                            <td class="text-right">
                                <input type="hidden" name="tab" value="<?=$id_role?>">
                                <a href="proses/proses.php?tab=<?=$id_role?>&reset=<?=$data['npk']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm reset"><i class="fas fa-undo-alt"></i></a>
                                <a href="edit_user.php?tab=<?=$id_role?>&edit=<?=$data['npk']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="nc-icon nc-ruler-pencil"></i></a>
                            </td>
                            <td class="text-right">
                                <div class="form-check ">
                                    <label class="form-check-label">
                                        <input class="form-check-input check user" name="userchecked[]" type="checkbox" value="<?=$data['npk']?>" data="">
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
                        <td class="bg-light text-center text-upercase" colspan="9">tidak ada data</td>
                    </tr>
                    <?php
                }
                ?>
            
                
                
            </tbody>
            
        </table>
    </form>  
    <div class="row">
        <div class="col-md-6">
            <p class="badge badge-warning badge-pill">total data ditemukan : <?=$jml?></p>
        </div>
        <div class="col-md-6 ">
            <ul class="pagination pagination-sm pull-right" id="pagination">
                <?php
                // $sOrg = mysqli_query($link, $qOrg)or die(mysqli_error($link));
                $jml_hal = ceil($jml / $batas);
                $cari = (@$_GET['cari'] != '') ? @$_GET['cari'] : "";
                $index_hal = 2;
                $start = ($hal > $index_hal) ? $hal - $index_hal : 1;
                $next = $hal + 1;
        
                $end = ($hal < ($jml_hal - $index_hal)) ? $hal + $index_hal : $jml_hal;
                if($jml > 0){
                    if($hal == 1){
                        ?>
                        <li class="page-item disabled"><a class="page-link btn-primary page" href="?cari=<?=$_GET['cari']?>&tab=<?=$id_role?>&hal=1#pagination"" aria-label="Previous">FIRST</a></li>
                        <li class="page-item disabled"><a class="page-link btn-primary page" href="#pagination" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span></a></li>
                        <?php
                    } else{
                        $prev = ($hal > 1)? $hal - 1 : 1;
                        ?>
                        <li class="page-item"><a class="page-link btn-primary page" data-id="1" href="?cari=<?=$_GET['cari']?>&tab=<?=$id_role?>&hal=1#pagination" aria-label="Previous">FIRST</a></li>
                        <li class="page-item"><a class="page-link btn-primary page" data-id="<?=$prev?>" href="?cari=<?=$_GET['cari']?>&tab=<?=$id_role?>&hal=<?=$prev?>" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span></a></li>
                        <?php
                    }
                    for($i = $start; $i <= $end; $i++){
                        $link_active = ($hal == $i)? ' active' : '';
                        ?>
                        <li class="page-item <?=$link_active?>"><a href="?cari=<?=$_GET['cari']?>&tab=<?=$id_role?>&hal=<?=$i?>#pagination" data-id="<?=$i?>" class="page-link btn-primary btn-link page"><?=$i?></a></li>
                        <?php
                    }
                    if($hal == $jml_hal){
                        ?>
                        <li class="page-item disabled"><a class="page-link btn-primary btn-link page" data-id="#" href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                        <li class="page-item disabled"><a class="page-link btn-primary btn-link page" data-id="#" href="#">LAST</a></li>
                        <?php
                    } else{
                        ?>
                        <li class="page-item"><a class="page-link btn-primary btn-link page" data-id="<?=$next?>" href="?cari=<?=$_GET['cari']?>&tab=<?=$id_role?>&hal=<?=$next?>#pagination"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                        <li class="page-item"><a class="page-link btn-primary btn-link page" data-id="<?=$jml_hal?>" href="?cari=<?=$_GET['cari']?>&tab=<?=$id_role?>&hal=<?=$jml_hal?>#pagination">LAST</a></li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="pull-right" >
        
        <button class="btn btn-sm btn-danger resetall" id="reset">
            <span class="btn-label">
                    <i class="fas fa-undo-alt"></i>
            </span>
            Reset Password
        </button>
        <button class="btn btn-sm btn-success editall" id="edit">
            <span class="btn-label">
                <i class="nc-icon nc-ruler-pencil"></i>
            </span>
            Edit
        </button>
        
    </div>

</div>
<script>
        $(document).ready(function(){
        $('.check-all').on('click', function(){
            if(this.checked){
                $('.check').each(function() {
                    this.checked = true;
                })
            } else {
                $('.check').each(function() {
                    this.checked = false;
                })
            }
        });
        $('.check').on('click', function() {
            if($('.check:checked').length == $('.check').length){
                $('.check-all').prop('checked', true)
            } else {
                $('.check-all').prop('checked', false)
            }
        })
    })
    </script>
    <script>
    $('.reset').on('click', function(e){
        e.preventDefault();
        var getLink = $(this).attr('href');
        var id = $(this).parents("tr").attr("id");
        Swal.fire({
        title: 'Anda Yakin ?',
        text: "Reset Data User dengan NPK : " + id + "",
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
    $('.resetall').on('click', function(e){
        e.preventDefault();
        var getLink = "proses/proses.php";
        document.proses.action = getLink;
            
        Swal.fire({
        title: 'Reset Password?',
        text: "Klik reset all untuk melanjutkan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF5733',
        cancelButtonColor: '#B2BABB',
        confirmButtonText: 'Reset All!'
        }).then((result) => {
            if (result.value) {
                document.proses.submit();
            }
        })
    });
    $('.editall').on('click', function(e){
        e.preventDefault();
        var getLink = "edit_user.php";
        document.proses.method = "POST";
        document.proses.action = getLink;
        Swal.fire({
        title: 'Anda Yakin ?',
        text: "Ingin melanjutkan edit data yang dipilih",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF5733',
        cancelButtonColor: '#B2BABB',
        confirmButtonText: 'Lanjutkan!'
        }).then((result) => {
            if (result.value) {
                document.proses.submit();
            }
        })
    });
    </script>
