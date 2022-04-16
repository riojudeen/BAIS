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
    <input type="hidden" id="link_go" value="?org=1&id=<?=$id_area?>&part=<?=$part_area?>">
    <div class="row">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-header">
                    <div class="row">
                        <h5 class="title pull-left col-md-6" id="mainpage">Update Organization</h5>
                        <?php
                        if($level >= 3 && $level <= 5){
                            ?>
                            <div class="col-md-6 text-right">
                                <a href="../../pages/mp_update.php" class="btn">Kembali</a>
                            </div>
                            <?php
                        }else{
                            ?>
                            <div class="col-md-6 text-right">
                                <a href="index.php" class="btn">Kembali</a>
                            </div>
                            <?php
                        }
                        ?>
                        
                    </div>
                    <?php
                    if($part_area == 'pos'){
                        $q_cord = mysqli_query($link,"SELECT cord FROM view_daftar_area WHERE id = '$id_area' AND part = '$part_area' ")or die(mysqli_error($link));
                        $kolom_org = 'post';
                        
                    }else if($part_area == 'group'){
                        $q_cord = mysqli_query($link,"SELECT cord FROM view_daftar_area WHERE id = '$id_area' AND part = '$part_area' ")or die(mysqli_error($link));
                        $kolom_org = 'grp';
                    }else if($part_area == 'section'){
                        $q_cord = mysqli_query($link,"SELECT cord FROM view_daftar_area WHERE id = '$id_area' AND part = '$part_area' ")or die(mysqli_error($link));
                        $kolom_org = 'sect';
                    }else if($part_area == 'dept'){
                        $q_cord = mysqli_query($link,"SELECT cord FROM view_daftar_area WHERE id = '$id_area' AND part = '$part_area' ")or die(mysqli_error($link));
                        $kolom_org = 'dept';
                    }else if($part_area == 'deptacc'){
                        $q_cord = mysqli_query($link,"SELECT cord FROM view_daftar_area WHERE id = '$id_area' AND part = 'deptAcc' ")or die(mysqli_error($link));
                        $kolom_org = 'dept_account';
                    }else if($part_area == 'division'){
                        $q_cord = mysqli_query($link,"SELECT cord FROM view_daftar_area WHERE id = '$id_area' AND part = '$part_area' ")or die(mysqli_error($link));
                        $kolom_org = 'division';
                    }
                    $data_cord = mysqli_fetch_assoc($q_cord);
                    $npk_cord = (isset($data_cord['cord']))?$data_cord['cord']:'';
                    $cek_mp = mysqli_query($link, "SELECT $kolom_org FROM org WHERE npk = '$npk_cord'")or die(mysqli_error($link));
                    $data_cek = mysqli_fetch_assoc($cek_mp);
                    $fill_text_area = ($data_cek[$kolom_org] != '')?'':$npk_cord;

                    list($pos,$group,$section,$dept,$division,$plant,$dept_account)=strukturOrg($link, $part_area, $id_area);

                    // echo $group;
                    // echo $id_area;
                    // echo  $pos." - ".$group." - ".$section." - ".$dept." - ".$division." - ".$plant."<br>";
                    $pos_name = (getOrgName($link, $pos, 'pos')!= '')?getOrgName($link, $pos, 'pos'):'-';
                    $group_name = (getOrgName($link, $group, 'group') != '')?getOrgName($link, $group, 'group'):'-';
                    $section_name = (getOrgName($link, $section, 'section') != '')?getOrgName($link, $section, 'section'):'-';
                    $dept_name = (getOrgName($link, $dept, 'dept') != '')?getOrgName($link, $dept, 'dept'):'-';
                    $div_name = (getOrgName($link, $division, 'division') != '')?getOrgName($link, $division, 'division'):'-';
                    $q_deptAccount = mysqli_query($link, "SELECT department_account AS `name` FROM dept_account WHERE id_dept_account = '$dept_account' ")or die(mysqli_error($link));
                    $data_dept_account = mysqli_fetch_assoc($q_deptAccount);
                    $deptAcc_name = (isset($data_dept_account['name']))?$data_dept_account['name']:'-';
                    ?>
                    
                </div>
                <hr>
                <form action="proses/prosesOrg.php" method="POST" name="organization" id="organization" class="card-body ">
                    <div class="card card-plain">
                        <div class="card-body border rounded-lg">
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
                    </div>
                    
                    <hr class="">
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
                                            <a class=" btn btn-sm btn-link btn-round btn-info tab-active active list-tab"  data-toggle="tab" data-id="mp" id="mp" href="#mp" role="tab" data-name="Data Karyawan" aria-expanded="true">Employee Data</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class=" btn btn-sm btn-link btn-round btn-info  list-tab"  data-toggle="tab" data-id="add_mp" id="add_mp" href="#add_mp" role="tab" data-name="Add Karyawan" aria-expanded="true">Posting Data</a>
                                        </li>
                                            
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

                            <?php
                            require_once('collapse.php');
                            ?>
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
                // console.log(text_area);
                
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
                // console.log(hal)
            });
            $(document).on('click', '#add_mp', function(){
                $('#collapsePlot').addClass('show').fadeIn('fast');
            });
            $(document).on('click', '#mp', function(){
                $('#collapsePlot').removeClass('show').fadeOut('fast');
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

            
            $(document).on('click','.check-all', function(){
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
            $(document).on('click', '.check', function() {
                if($('.check:checked').length == $('.check').length){
                    $('.check-all').prop('checked', true)
                } else {
                    $('.check-all').prop('checked', false)
                }
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
        $(document).on('click', '.editall', function(e){
            e.preventDefault();
            var linkGo = $('#link_go').val()
            var getLink = '../employee/proses/mass_editMp.php'+linkGo;

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

