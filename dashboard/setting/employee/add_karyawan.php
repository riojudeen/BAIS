<?php
$_SESSION['user'] = '1';
//////////////////////////////////////////////////////////////////////
require_once("../../../config/config.php"); 
if(isset($_SESSION['user'])){
    $halaman = "Resource Account & Setting";
    include_once("../../header.php");
    include_once("ajax/modal.php");
    $_SESSION['tab'] = @$_GET['tab'];
    // mysqli_query($link,"DELETE FROM karyawan");
    // mysqli_query($link,"DELETE FROM org");
    // mysqli_query($link,"DELETE FROM data_user");
    
    ?>


<div class="row ">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header row">
                <h5 class="col-md-6 title">Resource Data (Karyawan & Management)</h5>
                <div class="col-md-6">
                    <a href="proses/export.php?export=mp" class="btn btn-sm btn-success pull-right" data-toggle="tooltip" data-placement="bottom" title="Export to Excel File">
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
                    <div class="col-md-3 card" style="box-shadow: rgb(223, 220, 220) -5px 0.0px 20px -13px inset;">
                        <div class="sticker">
                            <h6 class="">Resource Type</h6>
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
                                    <?php
                                    $s_employee = array('local', 'expatriat', 'layoff');
                                    $i = 0;
                                    foreach($s_employee AS $data){
                                        //membuat tab active terbuka untuk pertama kali
                                        $tab_active = ($data == 'local')? "active" :"";
                                    ?>
                                        <li class="nav-item" >
                                            <a class="btn btn-sm btn-link btn-round btn-info navigasi <?=$data?> <?=$tab_active?> tab-<?=$tab_active?> tab-<?=$data?> list-tab" href="#<?=$data?>" data-id="<?=$data?>" role="tab" data-toggle="tab"><?=$data?></a>
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
                        <div class="row tab-content">
                            <div class="col-md-12 tab-pane active" id="local">
                                <div class="collapse" id="layoff_input">
                                    <div class="row ">
                                        
                                        <div class="col-md-12">
                                            <form action="">
                                                <div class="card shadow-none border inputnpk " style="background:rgba(201, 201, 201, 0.2)" >
                                                    <div class="card-body  mt-2">
                                                        
                                                        <div class="form-group">
                                                            <textarea class="form-control " name="" id="text_input" cols="30" rows="10"></textarea>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <button type="reset" class="btn btn-sm btn-warning">Reset</button>
                                                            </div>
                                                            <div class="col-md-6 text-right">
                                                                <button type="submit" id="upload_npk" class="btn btn-sm btn-primary pull-right">Upload</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                include_once('colapse_add.php');
                                ?>
                                <div class="row">
                                    <div class="col-md-12 filter_data ">
                                        <div class="input-group no-border ">
                                            <select class="form-control" name="div" id="s_div">
                                                <option value="">Pilih Divisi</option>
                                            </select>
                                            
                                            <select class="form-control" name="deptacc" id="s_deptAcc">
                                                <option value="">Pilih Dept Administratif</option>
                                                <option disabled value="">Pilih Division terlebih dahulu</option>
                                                
                                            </select>
                                            <select class="form-control" name="shift" id="s_shift">
                                                <option value="">Pilih Shift</option>
                                                <?php
                                                    $query_shift = mysqli_query($link, "SELECT `id_shift`,`shift` FROM `shift` ")or die(mysqli_error($link));
                                                    if(mysqli_num_rows($query_shift)>0){
                                                        while($data = mysqli_fetch_assoc($query_shift)){
                                                            ?>
                                                            <option value="<?=$data['id_shift']?>"><?=$data['shift']?></option>
                                                            <?php
                                                        }
                                                    }else{
                                                        ?>
                                                        <option value="">Belum Ada Data Shift</option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                            <div class="input-group-append ">
                                                <span id="filterGo" class="btn btn-sm input-group-text text-sm px-2 py-0 m-0">go</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 filter_data">
                                        <div class="input-group no-border ">
                                            <select name="" id="jabatan_" class="form-control">
                                                <option value="">Pilih Jabatan</option>
                                                <?php
                                                $q_jab = mysqli_query($link, "SELECT * FROM jabatan ORDER BY `level` ASC")or die(mysqli_error($link));
                                                if(mysqli_num_rows($q_jab)>0){
                                                    while($dataJab = mysqli_fetch_assoc($q_jab)){
                                                        
                                                    ?>
                                                        <option value="<?=$dataJab['id_jabatan']?>"><?=$dataJab['jabatan']?></option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <select name="" id="status_" class="form-control">
                                                <option value="">Pilih Status</option>
                                                <?php
                                                $q_jab = mysqli_query($link, "SELECT * FROM status_mp ORDER BY `level` ASC")or die(mysqli_error($link));
                                                if(mysqli_num_rows($q_jab)>0){
                                                    while($dataJab = mysqli_fetch_assoc($q_jab)){
                                                        
                                                    ?>
                                                        <option value="<?=$dataJab['id']?>"><?=$dataJab['status_mp']?></option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <input type="text" name="cari" id="pencarian" class="form-control" placeholder="Cari NPK atau nama" value="">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <i class="nc-icon nc-zoom-split"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="data-karyawan">
                                    
                                </div>
                            </div>
                            
                        </div>
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

    include_once("../../footer.php"); 
    //javascript disini
    ?>
        <!-- untuk proses tombol edit & delete masal -->
    <script>
    //untuk crud masal update department
        
        $(document).on('click', '.del', function(e){
            e.preventDefault();
            var getLink = $(this).attr('href');
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
                    document.proses.action = getLink;
                    document.proses.submit();
                }
            })
            
        });
        $(document).on('click', '.delete', function(e){
            e.preventDefault();
            var getLink = 'proses/proses.php';
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
                    document.proses.action = getLink;
                    document.proses.submit();
                }
            })
            
        });
        $(document).on('click', '.editall', function(e){
            e.preventDefault();
            var getLink = 'proses/mass_editMp.php';
            document.proses.action = getLink;
            document.proses.submit();
        }); 
    </script>
    <script>
        $(document).ready(function(){
            function load_data(hal){
                var id = $('.tab-active').attr('data-id');
                var divisi = $('#s_div').val();
                var deptAcc = $('#s_deptAcc').val();
                var shift = $('#s_shift').val();
                var cari = $('#pencarian').val();
                var jab = $('#jabatan_').val();
                var stat = $('#status_').val();
                var page = $('.page_active').attr('id');
                var text_input = $('textarea#text_input').val();
                // console.log(page);
                $.ajax({
                    url: 'data_karyawan.php',
                    method: 'GET',
                    data:{input:text_input,page:hal,id:id,shift:shift,divisi:divisi,deptAcc:deptAcc,cari:cari,jab:jab,stat:stat},
                    success:function(msg){
                        $('#data-karyawan').fadeOut('fast', function(){
                            $(this).html(msg).fadeIn('fast');
                        });
                    }
                });
            }

            load_data();
            $(document).on('click', '.layoff_btn', function(){
                var data = $(this).attr('data-id');
                var npk = $(this).attr('id');
                console.log(npk)
                $.ajax({
                    url: 'ajax/proses_layoff.php',
                    method: 'POST',
                    data:{data:data,npk:npk},
                    success:function(){
                        load_data();
                    }
                });
                // load_data();
            })
            $('.navigasi').click(function(){
                var id = $(this).attr('id');
                $('.list-tab').removeClass('tab-active');
                $(this).addClass('tab-active');
                load_data();
            });
            function getDiv(){
                var data = $('#s_div').val()
                $.ajax({
                    url: 'ajax/get_div.php',
                    method: 'GET',
                    data: {data:data},		
                    success:function(data){
                        $('#s_div').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                        
                    }
                });
            }
            
            function getDept(){
                var data = $('#s_div').val()
                $.ajax({
                    url: 'ajax/get_dept.php',	
                    method: 'GET',
                    data: {data:data},
                    success:function(data){
                        $('#s_deptAcc').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                        
                    }
                });
            }
            $('#s_div').on('change', function(){
                getDept()
            })
            $('#jabatan_').on('change', function(){
                load_data();
            })
            $('#status_').on('change', function(){
                load_data();
            })
            $('#pencarian').on('keyup', function(){
                load_data();
            })
            $(document).on('click','#filterGo', function(){
                load_data();
            })
            getDiv()
            $(document).on('click', '.halaman', function(){
                var hal = $(this).attr("id");
                load_data(hal);
            });
            $(document).on('click', '#upload_npk', function(a){
                a.preventDefault();
                load_data();
            });
            
            



            function get_data(kelas,linktujuan,kelastujuan){
                var tag_kelas = kelas;
                var value = $(tag_kelas).val();
                $.ajax({
                    url: linktujuan,
                    method: 'get',
                    success:function(msg){
                        $(kelastujuan).html(msg);
                    }
                });
            }
            $('.data-dept').on('change', function(){
                var value = $(this).val();
                var link_tujuan = "ajax/get_section.php?id="+value;
                // console.log(link_tujuan)
                get_data('.data-section',link_tujuan,'.data-section');
            })
            $('.data-section').on('change',function(){
                var value = $(this).val();
                var link_tujuan = "ajax/get_group.php?id="+value;
                // console.log(link_tujuan)
                get_data('.data-section',link_tujuan,'.data-group');
            })
            $('.data-group').on('change',function(){
                var value = $(this).val();
                var link_tujuan = "ajax/get_pos.php?id="+value;
                // console.log(link_tujuan)
                get_data('.data-group',link_tujuan,'.data-pos');
            })
            // menangkap data ketika element target diklik
            $('.data-section').click(function(e){
                var value = $('.data-dept').val();
                var link_tujuan = "ajax/get_section.php?id="+value;
                // console.log(link_tujuan)
                get_data('.data-dept',link_tujuan,'.data-section');
            })
            $('.data-group').click(function(){
                
                var value = $('.data-section').val();
                var link_tujuan = "ajax/get_group.php?id="+value;
                // console.log(value)
                get_data('.data-section',link_tujuan,'.data-group');
            })
            $('.data-pos').click(function(){
                
                var value = $('.data-group').val();
                var link_tujuan = "ajax/get_pos.php?id="+value;
                // console.log(link_tujuan)
                get_data('.data-group',link_tujuan,'.data-pos');
            })
            $('.mata1').mousedown(function(){
                $('.mata2').removeClass('d-none')
                $('.mata1').addClass('d-none')
                $('.passw').removeAttr('type')
                $('.passw').attr('type','text')
            })
            $('.mata2').mouseup(function(){
                $('.mata1').removeClass('d-none')
                $('.mata2').addClass('d-none')
                $('.passw').removeAttr('type')
                $('.passw').attr('type','password')
            })
            $('.default-pass').click(function(){
                var value = $(this).prop('checked')
                if($(this).prop('checked') === true){
                    // console.log(value)
                    $(".passw").prop('disabled', true);
                }else{
                    $(".passw").prop('disabled',false);
                }
            })
            
        })
    </script>
    <script>
        $(document).on('click', '#allmp', function(){
            if(this.checked){
                $('.mp').each(function() {
                    this.checked = true;
                })
            } else {
                $('.mp').each(function() {
                    this.checked = false;
                })
            }

        });

        $(document).on('click', '.mp', function() {
            if($('.mp:checked').length == $('.mp').length){
                $('#allmp').prop('checked', true)
            } else {
                $('#allmp').prop('checked', false)
            }
        })
    </script>
    <script>
        $(document).ready(function(){
            $(document).on('click', '.tab-expatriat', function(){
                $('.filter_data').fadeOut('fast', function(){
                    $(this).addClass('d-none');
                    $('.tambah').removeClass('show');
                });
                
                
            })
            $(document).on('click', '.tab-local', function(){
                $('.filter_data').removeClass('d-none').fadeIn('fast');
                // $('.filter_data').removeClass('d-none');
                
            })
            $(document).on('click', '.tab-layoff', function(){
                $('.filter_data').removeClass('d-none').fadeIn('fast');
                // $('.filter_data').removeClass('d-none');
                
            })

        })
    </script>
    <!-- upload ajax -->
    <!-- <script>
        $(document).ready(function(){
            $('.load-data').on('click', function() {
                var file_data = $('#file_export').prop('files')[0];   
                var form_data = new FormData();
                var groupshift = $('#groupshift').val();
                var jab = $('#jabatan').val();
                var stats = $('#status').val();
                var deptacc = $('#deptacc').val();
                var roleuser = $('#roleuser').val();
                var pass = $('#password').val();
                var d_pass =[];
                $('#defaultpass').each(function(){
                    if($(this).is(":checked")){
						d_pass.push($(this).val());
					}
                });
                var dept = $('#department').val();
                var sect = $('#section').val();
                var group = $('#group').val();
                var posleader = $('#posleader').val();
                var doc_cek = [];
                $('#documentcek').each(function(){
                    if($(this).is(":checked")){
						doc_cek.push($(this).val());
					}
                });
                form_data.append('file-excel', file_data);
                // alert(form_data);                             
                $.ajax({
                    url: 'ajax/import.php?groupshift='+groupshift+'&jab='+jab+'&stats='+stats+'&deptacc='+deptacc+'&role='+roleuser+'&pass='+pass+'&dpass='+d_pass+'&dept='+dept+'&sect='+sect+'&group='+group+'&pos='+posleader+'&doccek='+doc_cek, // <-- point to server-side PHP script 
                    dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                    // encode: 'true',  // <-- what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function(resp){
                        
                        // var cek = Object.keys(file_data).length
                        // console.log(file_data)
                        if(file_data !== undefined){
                            $('#datapreview').modal('show');
                            $(".data_load").html(resp);
                        }else{
                            Swal.fire('Dokumen Belum dipilih')
                        }
                    }
                });
            });
        })
    </script> -->
    <script>
        $(document).ready(function(){
            $('.load-data').on('click', function() {
                var file_data = $('#file_export').prop('files')[0];   
                var form_data = new FormData();
                var groupshift = $('#groupshift').val();
                var jab = $('#jabatan').val();
                var stats = $('#status').val();
                
                var roleuser = $('#roleuser').val();
                var pass = $('#password').val();
                var d_pass =[];
                $('#defaultpass').each(function(){
                    if($(this).is(":checked")){
						d_pass.push($(this).val());
					}
                });
                var doc_cek = [];
                $('#documentcek').each(function(){
                    if($(this).is(":checked")){
						doc_cek.push($(this).val());
					}
                });
                var url = 'ajax/preview-import.php?groupshift='+groupshift+'&jab='+jab+'&stats='+stats+'&role='+roleuser+'&pass='+pass+'&dpass='+d_pass+'&dok='+doc_cek;
                // console.log(file_data);
                
                // console.log(groupshift);
                // console.log(jab);
                // console.log(stats);
                // console.log(roleuser);
                // console.log(pass);
                // console.log(d_pass);
                // console.log(url);
                
                form_data.append('file-excel', file_data);
                // console.log(form_data);
                // alert(form_data);                             
                $.ajax({
                    url: url, // <-- point to server-side PHP script 
                    dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                    // encode: 'true',  // <-- what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function(resp){
                        
                        // var cek = Object.keys(file_data).length
                        // console.log(file_data)
                        if(file_data !== undefined){
                            $('#datapreview').modal('show');
                            $(".data_load").html(resp);
                        }else{
                            Swal.fire('Dokumen Belum dipilih')
                        }
                    }
                });
            });
        })
    </script>
    <script>
        $( document ).ajaxStart( function() {
            $( "#ajax-wait" ).css({
                left: ( $( window ).width() - 32 ) / 2 + "px", // 32 = lebar gambar
                top: ( $( window ).height() - 32 ) / 2 + "px", // 32 = tinggi gambar
                display: "block"
            })
        }).ajaxComplete( function() {
            $( "#ajax-wait" ).fadeOut();
        });
    </script>
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
            }else{
                $('.check-all').prop('checked', false)
            }
        })
    })
    </script>
    <?php
    include_once("../../endbody.php");
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

