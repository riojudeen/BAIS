<?php
$_SESSION['tab'] = 'pos';
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
require_once("../../../config/approval_system.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Organization Settings";
    $id_area = $_GET['id'];
    $part_area = $_GET['part'];

    include_once("../../header.php");
    ?>
    
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
                                    <a class="dropdown-item" href="proses/export.php?export=organization">Export Data</a>
                                    <!-- <a class="dropdown-item" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Import Data</a> -->
                                    <a class="dropdown-item" data-toggle="modal" data-target="#generate" >Tambah Data</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    list($pos,$group,$section,$dept,$division,$plant,$dept_account)=strukturOrg($link, $part_area, $id_area);
                
                    // echo $part_area;
                    // echo $id_area;
                    // echo  $pos." - ".$group." - ".$section." - ".$dept." - ".$division." - ".$plant."<br>";
                    $pos_name = (getOrgName($link, $pos, 'pos')!= '')?getOrgName($link, $pos, 'pos'):'-';
                    $group_name = (getOrgName($link, $group, 'group') != '')?getOrgName($link, $pos, 'pos'):'-';
                    $section_name = (getOrgName($link, $section, 'section') != '')?getOrgName($link, $section, 'section'):'-';
                    $dept_name = (getOrgName($link, $dept, 'dept') != '')?getOrgName($link, $dept, 'dept'):'-';
                    $div_name = (getOrgName($link, $division, 'division') != '')?getOrgName($link, $division, 'division'):'-';
                    $q_deptAccount = mysqli_query($link, "SELECT department_account AS `name` FROM dept_account WHERE id_dept_account = '$dept_account' ")or die(mysqli_error($link));
                    $data_dept_account = mysqli_fetch_assoc($q_deptAccount);
                    $deptAcc_name = (isset($data_dept_account['name']))?$data_dept_account['name']:'-';
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2 pr-1 no-border">
                                    <div class="form-group">
                                        <label for="">Division:</label>
                                        <input disabled type="text" class="form-control" id="s_div" value="<?=$div_name?>">
                                    </div>
                                </div>
                                <div class="col-md-2 px-1 no-border">
                                    <div class="form-group">
                                        <label for="">Dept:</label>
                                        <input disabled type="text" class="form-control" id="s_dept" value="<?=$dept_name?>">
                                    </div>
                                </div>
                                <div class="col-md-2 px-1 no-border">
                                    <div class="form-group">
                                        <label for="">Section:</label>
                                        <input disabled type="text" class="form-control" id="s_section" value="<?=$section_name?>">
                                        
                                    </div>
                                </div>
                                <div class="col-md-2 px-1 no-border">
                                    <div class="form-group">
                                        <label for="">Group:</label>
                                        <input disabled type="text" class="form-control" id="s_goupfrm" value="<?=$group_name?>">
                                    </div>
                                </div>
                                <div class="col-md-2 pl-1 no-border">
                                    <div class="form-group">
                                        <label for="">Team:</label>
                                        <input disabled type="text" class="form-control" id="s_pos" value="<?=$pos_name?>">
                                    </div>
                                </div>
                                <div class="col-md-2 pl-1 no-border">
                                    <div class="form-group">
                                        <label for="">Dept Administratif:</label>
                                        <input disabled type="text" class="form-control" id="s_dept_account" value="<?=$deptAcc_name?>">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <form action="proses/prosesOrg.php" method="POST" class="card-body">
                    <!-- <div class="nav-tabs-navigation "> -->
                    <input type="hidden" name="id_area_posting" id="id_area" value="<?=$_GET['id']?>">
                    <input type="hidden" name="part_area_posting" id="part_area" value="<?=$_GET['part']?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="sticker" >
                                <h6>Data Karyawan</h6>
                                <div class="nav-tabs-wrapper">
                                
                                    <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
                                        
                                        <li class="nav-item ">
                                            <a class=" btn btn-sm btn-link btn-round btn-info tab-active active list-tab"  data-toggle="tab" data-id="mp" id="mp" href="#mp" role="tab" data-name="Data Karyawan" aria-expanded="true">Data Karyawan</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class=" btn btn-sm btn-link btn-round btn-info  list-tab"  data-toggle="tab" data-id="add_mp" id="add_mp" href="#add_mp" role="tab" data-name="Data Karyawan" aria-expanded="true">Tambah Karyawan</a>
                                        </li>
                                            
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-9">
                            
                            <?php
                            require_once('collapse.php');
                            ?>
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
                var id_area = $("#id_area").val();
                var part_area = $("#part_area").val();
                var cari = $('.cari').val();
                var text_area = $('textarea#text_input').val()
                $('.content-title').text(name);
                // var sort = $('')
                console.log(text_area);
                
                $.ajax({
                    type: 'POST',
                    url: "ajax/data.php",
                    data:{input:text_area,page:hal,id:active,cari:cari,part_area:part_area,id_area:id_area},
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
            $('#upload_npk').click(function(a){
                a.preventDefault();
                getActive();
            })
            $('.list-tab').click(function(){
                var id = $(this).attr('id');
                $('.list-tab').removeClass('tab-active');
                // $('.inputnpk').addClass('d-none');
                $(this).addClass('tab-active');
                getActive();
            });
            $(document).on('click', '.halaman', function(){
                var hal = $(this).attr("id");
                getActive(hal);
                console.log(hal)
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

        $('.deleteall').on('click', function(e){
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
        $('.editall').on('click', function(e){
            e.preventDefault();
            var getLink = 'proses/editOrg.php';

            document.organization.action = getLink;
            document.organization.submit();
        }); 
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

