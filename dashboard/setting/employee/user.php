<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Resource Account & Setting";
    include_once("../../header.php");
    $_SESSION['tab'] = @$_GET['tab'];
?>
<!-- halaman utama -->
<!-- <div class="row">
    <div class="col-md-6 text-right">
        <div class="dropdown dropleft">
            <button class="btn btn-sm bg-transparent btn-icon btn-round text-default" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header">Menu</div>
                <a class="dropdown-item" href="proses/export.php?export=organization">Export Data</a>
                <a class="dropdown-item" href="file/Format_Register_Area.xlsx" >Download Format</a>
                <a class="dropdown-item" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Import Data</a>
                <a class="dropdown-item" data-toggle="modal" data-target="#generate" >Add</a>
            </div>
        </div>
    </div>
</div> -->

<div class="row ">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header row">
                <h5 class="col-md-6 title">User Setting</h5>
                <div class="col-md-6">
                    <a href="add_karyawan.php" class="btn btn-sm btn-primary pull-right" data-toggle="tooltip" data-placement="bottom" title="Export to Excel File">
                        <span class="btn-label">
                            <i class="fa fa-plus"></i>
                        </span>
                        Resource Data
                    </a>

                </div>
            </div>
            <hr>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 card"style="box-shadow: rgb(223, 220, 220) -5px 0.0px 20px -13px inset;">
                        <div class="sticker">
                            <h6 class="pull-left">Role User</h6>
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
                                            <a class="btn btn-sm btn-link btn-round btn-info <?=$tab_active?> tab-<?=$tab_active?> list-tab" href="#<?=$user_role['id_role']?>" id="<?=$user_role['id_role']?>" role="tab" data-toggle="tab"><?=$user_role['role_name']?></a>
                                        </li>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <form class="col-md-4 pull-right" method="get" action="">
                            <div class="input-group no-border">
                                <input type="text" name="cari" id="pencarian" class="form-control cari" placeholder="Cari NPK atau nama" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="nc-icon nc-zoom-split"></i>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="data-view"></div>
                    </div>
                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
<?php
// include_once('../information.php');
?>
</div>
<?php
$hal = (isset($_GET['hal']))?$_GET['hal']:1;
    include_once("../../footer.php"); 
    //javascript disini
    ?>

    
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
    <script>
        $(document).ready(function(){
            function load_data(){
                var id = $('.tab-active').attr('id');
                var cari = $('.cari').val();
                $.ajax({
                    url: 'ajax/index.php?id='+id+'&cari='+cari+'&hal=<?=$hal?>',
                    method: 'get',
                    success:function(msg){
                        $('.data-view').html(msg);
                    }
                });
            }
            load_data();
            $('.cari').keyup(function(){
                load_data();
            })
            $('.list-tab').click(function(){
                var id = $(this).attr('id');
                $('.list-tab').removeClass('tab-active');
                $(this).addClass('tab-active');
                load_data();
            });
            
        })
    </script>
    <?php
    include_once("../../endbody.php");
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

