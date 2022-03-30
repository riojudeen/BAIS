<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "User Data Management";
    include_once("../../header.php");
    $_SESSION['tab'] = @$_GET['tab'];
?>


<div class="row ">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header row">
                <h5 class="col-md-6 title">User Data Setting</h5>
                <div class="col-md-6">
                    <a href="proses/export.php?export=dataUser" class="btn btn-sm btn-success pull-right" data-toggle="tooltip" data-placement="bottom" title="Export to Excel File">
                        <span class="btn-label">
                            <i class="far fa-file-excel"></i>
                        </span>
                        Export
                    </a>

                </div>
            </div>
            <hr>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3  ">
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
                                            <a class="btn btn-sm btn-link btn-round btn-info <?=$tab_active?> tab-<?=$tab_active?> list-tab" href="#<?=$user_role['id_role']?>" id="<?=$user_role['id_role']?>" data-name="<?=$user_role['role_name']?>" role="tab" data-toggle="tab"><?=$user_role['role_name']?></a>
                                        </li>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 border-left">
                        <div class="row">
                            <h6 class="text-title col-md-8 content-title"></h6>
                            <div class="col-md-4 text-right">
                                <div class="input-group no-border">
                                    <input type="text" name="cari" id="pencarian" class="form-control cari" placeholder="Cari NPK atau nama" >
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="nc-icon nc-zoom-split"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            function load_data(hal){
                var id = $('.tab-active').attr('id');
                var name = $('.tab-active').attr('data-name');
                var cari = $('.cari').val();
                // console.log(name);
                $('.content-title').text(name);
                $.ajax({
                    url: 'ajax/index.php',
                    method: 'GET',
                    data:{page:hal,id:id,cari:cari},
                    success:function(msg){
                        $('.data-view').fadeOut('fast', function(){
                            $(this).html(msg).fadeIn('fast');
                            
                        });
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
            $(document).on('click', '.halaman', function(){
                var hal = $(this).attr("id");
                load_data(hal);
            });
            load_data();
            
            
            
        })
    </script>
    <?php
    include_once("../../endbody.php");
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

