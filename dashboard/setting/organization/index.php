<?php
$_SESSION['tab'] = 'pos';
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Organization Settings";
    include_once("../../header.php");
    
    if(isset($_SESSION['tab'])){
        if($_SESSION['tab'] == 'pos'){
            $tab_division = "";
            $tab_pos = "active";
            $tab_group = "";
            $tab_section = "";
            $tab_dept = "";
            $tab_deptacc = "";
        }else if($_SESSION['tab'] == 'group' ){
            $tab_division = "";
            $tab_pos = "";
            $tab_group = "active";
            $tab_section = "";
            $tab_dept = "";
            $tab_deptacc = "";
        }else if($_SESSION['tab'] == 'section' ){
            $tab_division = 
            $tab_pos = "";
            $tab_group = "";
            $tab_section = "active";
            $tab_dept = "";
            $tab_deptacc = "";
        }else if($_SESSION['tab'] == 'dept' ){
            $tab_division = "";
            $tab_pos = "";
            $tab_group = 
            $tab_section = "";
            $tab_dept = "active";
            $tab_deptacc = "";
        }else if($_SESSION['tab'] == 'deptacc' ){
            $tab_division = "";
            $tab_pos = "";
            $tab_group = "";
            $tab_section = "";
            $tab_dept = "";
            $tab_deptacc = "active";
        }else if($_SESSION['tab'] == 'division' ){
            $tab_division = "active";
            $tab_pos = "";
            $tab_group = "";
            $tab_section = "";
            $tab_dept = "";
            $tab_deptacc = "";
        }else{
            $tab_division = "active";
            $tab_pos = "";
            $tab_group = "";
            $tab_section = "";
            $tab_dept = "";
            $tab_deptacc = "";
        }
    }else{
        $tab_division = "active";
        $tab_pos = "";
        $tab_group = "";
        $tab_section = "";
        $tab_dept = "";
        $tab_deptacc = "";
    }

    $listOrg = array(
        array("Division","division", "$tab_division"),
        array("Department Account","deptacc", "$tab_deptacc"),
        array("Department","dept", "$tab_dept"),
        array("Section","section", "$tab_section"),
        array("Group","group", "$tab_group"),
        array("Team","pos","$tab_pos")
    );
    ?>
   
    <?php
    require_once('card.php');
    require_once('modal.php');
?>
<!-- modal & collapse -->

<form method="POST">
<div class="row">
    <div class="col-md-12" >
        <div class="card bg-transparent" >
            <div class="card-body bg-transparent">
            </div>
        </div>
    </div>
</div>
</form>
<!-- halaman utama end -->
<div class="row">
    <div class="col-md-12">
        <div class="card" >
            <div class="card-header">
                <div class="row">
                    <h5 class="title pull-left col-md-6" id="mainpage"><i class="fas fa-network-wired "></i> Data Register Organization</h5>
                    <div class="col-md-6 text-right">
                        <div class="dropleft" >
                            <button class="btn btn-sm btn-link btn-default btn-outline-default btn-icon btn-round" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right shadow-lg">
                                <div class="dropdown-header">Menu</div>
                                <a class="dropdown-item" href="../employee/proses/export.php?export=organization">Export Data</a>
                                <!-- <a class="dropdown-item" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Import Data</a> -->
                                <a class="dropdown-item" data-toggle="modal" data-target="#generate" >Tambah Data</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <form name="organization" method="POST" class="card-body">
                <!-- <div class="nav-tabs-navigation "> -->
                <div class="row">
                    <div class="col-md-3 card" style="box-shadow: rgb(223, 220, 220) -5px 0.0px 20px -13px inset;">
                        <div class="sticker" >
                            <h6>Data Organisasi</h6>
                            <div class="nav-tabs-wrapper">
                            
                                <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
                                    <!--  -->
                                    <?php
                                    foreach($listOrg as $list){
                                        
                                        ?>
                                        <li class="nav-item ">
                                            <a class=" btn btn-sm btn-link btn-round btn-info tab-<?=$list['2']?> <?=$list['2']?> list-tab"  data-toggle="tab" data-id="<?=$list['1']?>" id="<?=$list['1']?>" href="#<?=$list['1']?>" role="tab" data-name="<?=$list['0']?>" aria-expanded="true"><?=$list['0']?></a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-9">
                        
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
                        <hr class="my-0">
                        <div id="monitor"></div>
                        
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>
<?php
   
    include_once("../../footer.php");
    //javascript
    ?>
    <script>
        $(document).ready(function(){
            function getActive(hal){
                var active = $(".tab-active").attr('data-id');
                var name = $(".tab-active").attr('data-name');
                var cari = $('.cari').val();
                $('.content-title').text(name);
                // var sort = $('')

                
                $.ajax({
                    type: 'POST',
                    url: "ajax/index.php",
                    data:{page:hal,id:active,cari:cari},
                    success: function(msg){
                        
                        $("#monitor").fadeOut('fast', function(){
                            $(this).html(msg).fadeIn('fast');
                            
                        });
                    }
                });
            }
            getActive();
            $('#pencarian').keyup(function(){
                getActive();
            })
            $('.list-tab').click(function(){
                var id = $(this).attr('id');
                $('.list-tab').removeClass('tab-active');
                $(this).addClass('tab-active');
                getActive();
            });
            
            $(document).on('click', '.halaman', function(){
                var hal = $(this).attr("id");
                getActive(hal);
                // console.log(hal)
            });
            $('.inputnpk').blur(function(){
                var active = $(".tab-active").attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: "ajax/tes.php",
                    data:{id:active},
                    success: function(msg){
                        
                        $("#monitor").fadeOut('fast', function(){
                            $(this).html(msg).fadeIn('fast');
                            
                        });
                    }
                });
            })
            
            
        })
    </script>
    <script>
    //untuk crud masal update department

        $(document).on('click', '.deleteall', function(e){
            e.preventDefault();
            var getLink = 'proses/mass_del.php';
            Swal.fire({
            title: 'Anda Yakin ?',
            text: "Semua data yang dicheck / centang akan dihapus permanent",
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
        // $('.editall').on('click', function(e){
        //     e.preventDefault();
        //     var getLink = 'proses/editOrg.php';

        //     document.organization.action = getLink;
        //     document.organization.submit();
        // }); 
    </script>
    <script>
        $(document).ready(function(){
            $(document).on('click', '#preview_sub', function(a){
                a.preventDefault();
                
                var data = $(this).attr('data-id');
                var part = $(this).attr('data-name');
                $.ajax({
                    type: 'POST',
                    url: "ajax/get_area.php",
                    data: {data : data, part:part },
                    success: function(msg){
                        
                        $('#sub_area_preview').html(msg)
                        $('#data_sub').modal('show');
                        
                    }
                })
            })
            // $('body').on('hidden.bs.modal', function(){
            //     $(this).find('#sub_area_preview').empty();
            // })

        })  
    </script>
    <?php
    include_once("../../endbody.php"); 
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>