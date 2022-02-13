<?php

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
                <h5 class="col-md-6 title">Resource Data (Karyawan & Management)</h5>
                <div class="col-md-6">
                    <a href="user.php" class="btn btn-sm btn-primary pull-right" data-toggle="tooltip" data-placement="bottom" title="Export to Excel File">
                        <span class="btn-label">
                            <i class="fa fa-plus"></i>
                        </span>
                        Setting User
                    </a>
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
                                    $s_employee = array('local','expatriat');
                                    $i = 0;
                                    foreach($s_employee AS $data){
                                        //membuat tab active terbuka untuk pertama kali
                                        $tab_active = ($data == 'local')? "active" :"";
                                    ?>
                                        <li class="nav-item" >
                                            <a class="btn btn-sm btn-link btn-round btn-info <?=$data?> <?=$tab_active?> tab-<?=$tab_active?> list-tab" href="#<?=$data?>"  role="tab" data-toggle="tab"><?=$data?></a>
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
                                <?php
                                include_once('colapse.php');
                                include_once('data_karyawan.php');
                                ?>
                            </div>
                            <div class="col-md-12 tab-pane" id="expatriat">
                            <?php
                                include_once('colapse.php');
                                include_once('data_expatriat.php');
                                ?>
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
        $('.delete').on('click', function(e){
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
        $('.editall').on('click', function(e){
            e.preventDefault();
            var getLink = 'proses/mass_editMp.php';
            document.proses.action = getLink;
            document.proses.submit();
        }); 
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
                $.ajax({
                    url: 'ajax/index.php?id='+id,
                    method: 'get',
                    success:function(msg){
                        $('.data-view').html(msg);
                    }
                });
            }
            load_data();
            $('.list-tab').click(function(){
                var id = $(this).attr('id');
                $('.list-tab').removeClass('tab-active');
                $(this).addClass('tab-active');
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
    <!-- upload ajax -->
    <script>
        $(document).ready(function(e){
            e.preventDefault
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

