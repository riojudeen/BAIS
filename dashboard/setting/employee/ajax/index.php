<?php
//////////////////////////////////////////////////////////////////////
require("../../../../config/config.php");
$id_role = $_GET['id'];
$query_role = mysqli_query($link, "SELECT * FROM user_role WHERE id_role = '$id_role' ")or die(mysqli_error($link));
$dataRrole = mysqli_fetch_assoc($query_role);
$role = $dataRrole['role_name'];
$cari = (isset($_GET['cari']))?$_GET['cari']:"";


$q_data = "SELECT * FROM view_user 
        WHERE `level_user` = '$id_role' ";

$page = (isset($_GET['page']) && $_GET['page'] != 'undefined')? $_GET['page'] : 1;
// echo $page;
$limit = 100; 
$limit_start = ($page - 1) * $limit;
$no = $limit_start + 1;
// echo $limit_start;
$filter_cari = ($cari != '')?"AND ( npk LIKE '%$cari%' OR nama LIKE '%$cari%' )":'';

$filter_gabung = $filter_cari;
$filter = ($filter_gabung != '' )?" ". $filter_gabung :"";


$addLimit = " LIMIT $limit_start, $limit";

$total_dataKaryawan = $q_data;
$jml = mysqli_query($link, $total_dataKaryawan)or die(mysqli_error($link));
$j_dataKaryawan = $q_data.$filter;


$q_data .= $filter.$addLimit;
// echo $filter;
$total_records= mysqli_num_rows($jml);

// echo $total_records;
// pagin
$jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
                
$jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
$start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
$end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
    
$sql_data = mysqli_query($link, $q_data)or die(mysqli_error($link));

// echo $pencarian;
// echo $id_role;
?>
<div class="tab-pane " id="">
<?php
?>
    
    <form class="table-full-width text-uppercase " name="proses">
        <table class="table table-hover" id="usersetting" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Npk</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Status</th>
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
                
              
                // $sql_data = mysqli_query($link, $q_data)or die(mysqli_error($link));
                if(mysqli_num_rows($sql_data)>0){
                    
                    while($data = mysqli_fetch_assoc($sql_data)){
                        $stats = (isset($data['stats']) && ($data['stats'] == '0'))?"offline":"online";
                        $stats_color = (isset($data['stats']) && ($data['stats'] == '0'))?"text-muted":"text-primary font-weight-bold";
                        
                        ?>
                        <tr  id="<?=$data['npk']?>" class="<?=$stats_color?>">
                            <td ><?=$no++?></td>
                            <td ><?=$data['npk']?></td>
                            <td><?=$data['nama']?></td>
                            <td><?=$data['username']?></td>
                            <td >
                                <div class="legend card-category <?=$stats_color?>">
                                    <i class="fa fa-circle <?=$stats_color?>"></i>
                                    <span class="category"><?=$stats?></span>
                                    
                                </div>
                            </td>
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
                        <td class="bg-light text-center text-upercase " colspan="9">tidak ada data</td>
                    </tr>
                    <?php
                }
                ?>
            
                
                
            </tbody>
            
        </table>
    </form>  
    <div class="row mt-2">
        <div class="col-md-6 ">
            <ul class="pagination ">
            <?php
            // echo $page."<br>";
            // echo $jumlah_page."<br>";
            // echo $jumlah_number."<br>";
            // echo $start_number."<br>";
            // echo $end_number."<br>";
            if($page == 1){
                echo '<li class="page-item disabled"><a class="page-link" >First</a></li>';
                echo '<li class="page-item disabled"><a class="page-link" ><span aria-hidden="true">&laquo;</span></a></li>';
            } else {
                $link_prev = ($page > 1)? $page - 1 : 1;
                echo '<li class="page-item halaman" id="1"><a class="page-link" >First</a></li>';
                echo '<li class="page-item halaman" id="'.$link_prev.'"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
            }

            for($i = $start_number; $i <= $end_number; $i++){
                $link_active = ($page == $i)? ' active page_active' : '';
                echo '<li class="page-item halaman '.$link_active.'" id="'.$i.'"><a class="page-link" >'.$i.'</a></li>';
            }

            if($page == $jumlah_page){
                echo '<li class="page-item disabled"><a class="page-link" ><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item disabled"><a class="page-link" >Last</a></li>';
            } else {
                $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
                echo '<li class="page-item halaman" id="'.$link_next.'"><a class="page-link" ><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item halaman" id="'.$jumlah_page.'"><a class="page-link" >Last</a></li>';
            }
            ?>
            </ul>
        </div>
        <div class="col-md-6 text-right" >
            
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
