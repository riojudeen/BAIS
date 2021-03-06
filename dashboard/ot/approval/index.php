<?php

//////////////////////////////////////////////////////////////////////
include("../../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Approval Overtime";
if(isset($_SESSION['user'])){

    include_once("../../header.php");
    include("../../../config/approval_system.php");
    
    // cari data karyawa dari organisasi
    
    // echo $query_org."<br>";
    if($level >=1 && $level <=8){
        $_SESSION['startD'] = (isset($_GET['start']))? dateToDB($_GET['start']) : date('Y-m-01');
        $_SESSION['endD'] = (isset($_GET['end']))? dateToDB($_GET['end']) : date('Y-m-d');

        $sD = $_SESSION['startD'];
        $eD = $_SESSION['endD'];
    
        $tanggalAwal = date('Y-m-d', strtotime($sD));
        // echo "tanggal awal : ".$tanggalAwal."<br>";
        $tanggalAkhir = date('Y-m-d', strtotime($eD));
        // echo "tanggal akhir : ". $tanggalAkhir."<br>";

        $count_awal = date_create($tanggalAwal);
        $count_akhir = date_create($tanggalAkhir);

        if($sD <= $eD){
            $hari = date_diff($count_awal,$count_akhir)->days +1;
        }else{
            $hari = 0;
        }

        $awal = $blnAwal = strtotime($tanggalAwal); // merubah tanggal awal menjadi format timestamp agar bisa dijumlahkan;
        $akhir =  strtotime($tanggalAkhir); // merubah tanggal akhir menjadi format timestamp agar bisa dijumlahkan;

        $bln = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","Sepember","Oktober","November","Desember");
        $totalBln = count($bln);

    ?>
    <div class="row">
        <div class="col-md-12">
            <div id="sumary"></div>
        </div>
    </div>

    <form action="proses.php" method="GET">
        <div class="modal fade bd-example-modal-lg"  data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="myView">
            <div class="modal-dialog modal-lg" role="document">
                <div id="view_data"></div>
            </div>
        </div>
    </form>
        
    <br>
    <form method="GET">
    <div class="row">
        <div class="col-md-12" >
            <div class="card bg-transparent" >
                <div class="card-body bg-transparent">
                    <div class="row">
                        <div class="col-md-5 border-2">
                            <div class="input-group border-2 bg-transparent no-border">
                                <div class="input-group-prepend ">
                                    <div class="input-group-text bg-transparent">
                                        <i class="nc-icon nc-calendar-60"></i>
                                    </div>
                                </div>
                                <!-- <input  type="text" name="tahun" class=" form-control datepicker" data-date-format="MM-YYYY"> -->
                                <input type="text" name="start" id="start_date" class="form-control bg-transparent datepicker" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tanggalAwal)?>">
                                    
                                <div class="input-group-prepend ml-0 bg-transparent">
                                    <div class="input-group-text px-2 bg-transparent">
                                        <i>to</i>
                                    </div>
                                </div>
                                <input type="text" name="end"  id="end_date" class="form-control bg-transparent datepicker" data-date-format="DD/MM/YYYY" value="<?=DBtoForm($tanggalAkhir)?>">
                                
                                <input type="submit" name="sort" class="btn-icon btn btn-round p-0 ml-2 my-auto " value="go" >
                                
                            </div>
                        </div>
                        <div class="col-md-7 border-2 ">
                            <!-- <p class="float-right mr-2">
                                <a href="../req_absensi.php" class="btn btn-default">Leave & Permit Request</a>
                            </p> -->
                            <!-- <div class="col-4">
                                <input class="btn btn-icon btn-round" name="sort" value="go">
                            </div> -->
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    </form>
    <?php
        include('monitor.php');
    }else{
        include_once ("../../no_access.php");
    }
    include_once("../../footer.php");
    ?>
    
   

    <script>
    $(document).ready(function(){
        load_data();
        function load_data(page){
            var div_id = $('#s_div').val();
            var dept_id = $('#s_dept').val();
            var section_id = $('#s_section').val();
            var group_id = $('#s_goupfrm').val();
            var deptAcc_id = $('#s_deptAcc').val();
            var shift = $('#s_shift').val();
            var cari = $('#cari').val();
            var start = $('#start_date').val();
            var end = $('#end_date').val();
            var att_type = $('#att_type').val();
            var prog = $('#att_progress').val();
            $.ajax({
                url:"ajax/index.php",
                method:"GET",
                data:{page:page,start:start,end:end,div:div_id,dept:dept_id,sect:section_id,group:group_id,deptAcc:deptAcc_id,shift:shift,cari:cari,att_type:att_type,prog:prog,filter:'yes'},
                success:function(data){
                    $('#data-monitoring').fadeOut('fast', function(){
                        $(this).html(data).fadeIn('fast');
                    });
                    // $('#data-monitoring').html(data)
                }
            })
        }
        $(document).on('click', '.halaman', function(){
            var page = $(this).attr("id");
            load_data(page);
        });

        function success(data1,data2){
            Swal.fire({
                title: data1,
                text: data2,
                timer: 2000,
                
                icon: 'success',
                showCancelButton: false,
                showConfirmButton: false,
                confirmButtonColor: '#00B9FF',
                cancelButtonColor: '#B2BABB',
                
            })
        }
        $(document).on('click', '.approve', function(e){
            e.preventDefault();
            var getLink = $(this).attr('href');
            var data = $(this).attr('data-id')
            var page = $('.page_active').attr('id')
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "pengajuan ini akan disetujui",
                icon: false,
                showCancelButton: true,
                confirmButtonColor: '#2980B9',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Approve!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:getLink,
                        method:"GET",
                        data:{approve:data},
                        success:function(data){
                            var d = $.parseJSON(data);
                                // console.log(d.info);
                            load_data(page)
                            getSumary()
                            Swal.fire({
                                title: d.message,
                                text: d.info,
                                timer: 2000,
                                
                                icon: d.icon,
                                showCancelButton: false,
                                showConfirmButton: false,
                                confirmButtonColor: '#00B9FF',
                                cancelButtonColor: '#B2BABB',
                                
                            })              
                        }
                    })
                }
            })
                
        });
        $(document).on('click', '.reject', function(e){
            e.preventDefault();
            var getLink = $(this).attr('href');
            var data = $(this).attr('data-id')
            var page = $('.page_active').attr('id')
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "pengajuan ini akan diproses",
                
                icon: false,
                showCancelButton: true,
                confirmButtonColor: '#922B21',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Reject!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:getLink,
                        method:"GET",
                        data:{reject:data},
                        success:function(data){
                            var d = $.parseJSON(data);
                                console.log(data);
                            load_data(page)
                            getSumary()
                            Swal.fire({
                                title: d.message,
                                text: d.info,
                                timer: 2000,
                                
                                icon: d.icon,
                                showCancelButton: false,
                                showConfirmButton: false,
                                confirmButtonColor: '#00B9FF',
                                cancelButtonColor: '#B2BABB',
                                
                            })    
                        }
                    })
                }
            })
                
        });
        $(document).on('click', '.proses', function(e){
            e.preventDefault();
            var getLink = $(this).attr('href');
            var data = $(this).attr('data-id')
            var page = $('.page_active').attr('id')
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "pengajuan ini akan diproses",
                icon: false,
                showCancelButton: true,
                confirmButtonColor: '#2980B9',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Proses!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:getLink,
                        method:"GET",
                        data:{proses:data},
                        success:function(data){
                            var d = $.parseJSON(data);
                                console.log(data);
                            load_data(page)
                            getSumary()
                            Swal.fire({
                                title: d.message,
                                text: d.info,
                                timer: 2000,
                                
                                icon: d.icon,
                                showCancelButton: false,
                                showConfirmButton: false,
                                confirmButtonColor: '#00B9FF',
                                cancelButtonColor: '#B2BABB',
                                
                            })              
                        }
                    })
                }
            })
                
        });
        
        $(document).on('click', '.stop', function(e){
            e.preventDefault();
            var getLink = $(this).attr('href');
            var data = $(this).attr('data-id')
            var page = $('.page_active').attr('id')
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "pengajuan ini akan diproses",
                icon: false,
                showCancelButton: true,
                confirmButtonColor: '#922B21',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Stop!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:getLink,
                        method:"GET",
                        data:{stop:data},
                        success:function(data){
                            var d = $.parseJSON(data);
                                console.log(data);
                            load_data(page)
                            getSumary()
                            Swal.fire({
                                title: d.message,
                                text: d.info,
                                timer: 2000,
                                
                                icon: d.icon,
                                showCancelButton: false,
                                showConfirmButton: false,
                                confirmButtonColor: '#00B9FF',
                                cancelButtonColor: '#B2BABB',
                                
                            })   
                        }
                    })
                }
            })
                
        });
        $(document).on('click', '.remove', function(e){
            e.preventDefault();
            var getLink = $(this).attr('href');
            var data = $(this).attr('data-id')
            var page = $('.page_active').attr('id')
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "pengajuan ini akan dihapus permanent",
                icon: false,
                showCancelButton: true,
                confirmButtonColor: '#CB4335',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Delete!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:getLink,
                        method:"GET",
                        data:{del:data},
                        success:function(data){
                            var d = $.parseJSON(data);
                                console.log(data);
                            load_data(page)
                            getSumary()
                            Swal.fire({
                                title: d.message,
                                text: d.info,
                                timer: 2000,
                                
                                icon: d.icon,
                                showCancelButton: false,
                                showConfirmButton: false,
                                confirmButtonColor: '#00B9FF',
                                cancelButtonColor: '#B2BABB',
                                
                            })   
                        }
                    })
                }
            })
                
        });
        $(document).on('click', '.return', function(e){
            e.preventDefault();
            var getLink = $(this).attr('href');
            var data = $(this).attr('data-id')
            var page = $('.page_active').attr('id')
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "pengajuan ini akan diproses",
                icon: false,
                showCancelButton: true,
                confirmButtonColor: '#F4D03F',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Kembalikan!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:getLink,
                        method:"GET",
                        data:{return:data},
                        success:function(data){
                            var d = $.parseJSON(data);
                                console.log(data);
                            load_data(page)
                            getSumary()
                            Swal.fire({
                                title: d.message,
                                text: d.info,
                                timer: 2000,
                                
                                icon: d.icon,
                                showCancelButton: false,
                                showConfirmButton: false,
                                confirmButtonColor: '#00B9FF',
                                cancelButtonColor: '#B2BABB',
                                
                            })   
                        }
                    })
                }
            })
                
        });
        $(document).on('click', '.request', function(e){
            e.preventDefault();
            var getLink = $(this).attr('href');
            var data = $(this).attr('data-id')
            var page = $('.page_active').attr('id')
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "pengajuan ini akan diproses",
                icon: false,
                showCancelButton: true,
                confirmButtonColor: '#27AE60',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Request!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:getLink,
                        method:"GET",
                        data:{request:data},
                        success:function(){
                            var d = $.parseJSON(data);
                                console.log(data);
                            load_data(page)
                            getSumary()
                            Swal.fire({
                                title: d.message,
                                text: d.info,
                                timer: 2000,
                                
                                icon: d.icon,
                                showCancelButton: false,
                                showConfirmButton: false,
                                confirmButtonColor: '#00B9FF',
                                cancelButtonColor: '#B2BABB',
                                
                            })   
                        }
                    })
                }
            })
                
        });
        $('#filterGo').on('click', function(){
            load_data()
            getSumary()
        })
        $('#cari').on('blur', function(){
            load_data()
            getSumary()
        
        });
        $('#att_type').on('change', function(){
            load_data()
            getSumary()
        });
        $('#att_progress').on('change', function(){
            load_data()
        })
            
        function getSumary(){
            
            var id = 'leave';
            var div_id = $('#s_div').val();
            var dept_id = $('#s_dept').val();
            var section_id = $('#s_section').val();
            var group_id = $('#s_goupfrm').val();
            var deptAcc_id = $('#s_deptAcc').val();
            var shift = $('#s_shift').val();
            var cari = $('#cari').val();
            var start = $('#start_date').val();
            var end = $('#end_date').val();
            var att_type = $('#att_type').val();
            var prog = $('#att_progress').val();
            $.ajax({
                url: 'ajax/sumary.php',	
                method: 'GET',
                data:{summary_approval:"",id:id,start:start,end:end,div:div_id,dept:dept_id,sect:section_id,group:group_id,deptAcc:deptAcc_id,shift:shift,cari:cari,att_type:att_type,prog:prog,filter:'yes'},		
                success:function(data){
                    $('#sumary').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    
                }
            });
        }
        getSumary()
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
                    $('#s_dept').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    
                }
            });
        }
        function getSect(){
            var data = $('#s_dept').val()
            $.ajax({
                url: 'ajax/get_sect.php',	
                method: 'GET',
                data: {data:data},		
                success:function(data){
                    $('#s_section').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    
                }
            });
        }
        function getGroup(){
            var data = $('#s_section').val()
            $.ajax({
                url: 'ajax/get_group.php',
                method: 'GET',
                data: {data:data},
                success:function(data){
                    $('#s_goupfrm').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                    
                }
            });
        }
        
        getDiv()
        $('#s_div').on('change', function(){
            getDept()
            getSect()
            getGroup()
        })
        $('#s_dept').on('change', function(){
            getSect()
            getGroup()
        })
        $('#s_section').on('change', function(){
            getGroup()
        })
        

        $('.requestall').on('click', function(e){
            e.preventDefault();
            var getLink = 'mass_req.php';

            document.proses.action = getLink;
            document.proses.submit();
        });
        function totalCheck(check) {
            var total = $(check).length;
            return total;
        }
        
        // proses
        $(document).on('click','.prosesAll', function(){
            var page = $('.page_active').attr('id')
            var getLink = '../proses-approval.php?proses_multiple=';
                
                Swal.fire({
                title: 'Pengajuan Diproses?',
                text: "Semua data yang dicheck / centang akan diproses secara administratif",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3498DB',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Ya, Proses!'
            }).then((result) => {
                if (result.value) {
                    if(totalCheck('.mp:checked') > 0){
                        var form = $("#formAbsensi").serialize()
                        // console.log(form);
                        $.ajax({
                            
                            url:getLink,
                            method:"POST",
                            data:form,
                            success:function(data){
                                var d = $.parseJSON(data);
                                // console.log(d.info);
                                load_data(page)
                                getSumary()
                                Swal.fire({
                                    title: d.message,
                                    text: d.info,
                                    timer: 2000,
                                    
                                    icon: d.icon,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    confirmButtonColor: '#00B9FF',
                                    cancelButtonColor: '#B2BABB',
                                    
                                })
                            }
                        })
                        
                    }else{
                        Swal.fire({
                            title: "Gagal",
                            text: "tidak ada data yang dipilih",
                            // icon: "danger",
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            confirmButtonColor: '#00B9FF',
                            cancelButtonColor: '#B2BABB',
                            
                        })
                    }
                
                }
            })
            
        });
        // return
        $(document).on('click', '.downloadAll', function(e){
            e.preventDefault();
            var getLink = '../proses-approval.php?ot_download=1';
            var page = $('.page_active').attr('id')
            Swal.fire({
                title: 'Dowload Data ?',
                text: "download draft pengajuan?",
                icon: false,
                showCancelButton: true,
                confirmButtonColor: '#1ABC9C',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Download Sekarang!'
            }).then((result) => {
                if (result.value) {
                    document.proses.action = getLink;
                    document.proses.submit();
                    // $.ajax({
                    //     url:getLink,
                    //     method:"POST",
                    //     data:form,
                    //     success:function(data){
                    //         $('.notifikasi').html(data);
                    //         draft_Active(page)
                    //     }
                    // })
                }
            })
        
        });
        $(document).on('click','.returnAll', function(){
            var page = $('.page_active').attr('id')
            var getLink = '../proses-approval.php?return_multiple=';
                
                Swal.fire({
                title: 'Pengajuan Ingin Dikembalikan?',
                text: "Semua data yang dicheck / centang akan dikembalikan untuk dicek kembali oleh foreman",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F1C40F',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Ya, Kembalikan!'
            }).then((result) => {
                if (result.value) {
                    if(totalCheck('.mp:checked') > 0){
                        var form = $("#formAbsensi").serialize()
                        $.ajax({
                            
                            url:getLink,
                            method:"POST",
                            data:form,
                            success:function(data){
                                var d = $.parseJSON(data);
                                // console.log(d.info);
                                load_data(page)
                                getSumary()
                                Swal.fire({
                                    title: d.message,
                                    text: d.info,
                                    timer: 2000,
                                    
                                    icon: d.icon,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    confirmButtonColor: '#00B9FF',
                                    cancelButtonColor: '#B2BABB',
                                    
                                })
                            }
                        })
                        
                    }else{
                        Swal.fire({
                            title: "Gagal",
                            text: "tidak ada data yang dipilih",
                            // icon: "danger",
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            confirmButtonColor: '#00B9FF',
                            cancelButtonColor: '#B2BABB',
                            
                        })
                    }
                
                }
            })
            
        });
        // stop
        $(document).on('click','.stopAll', function(){
            var page = $('.page_active').attr('id')
            var getLink = '../proses-approval.php?stop_multiple=';
                
                Swal.fire({
                title: 'Pengajuan Dihentikan ?',
                text: "Semua data yang dicheck / centang akan dihentikan dan pengajuan tidak bisa dibuat lagi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FF5733',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Ya, Hentikan!'
            }).then((result) => {
                if (result.value) {
                    if(totalCheck('.mp:checked') > 0){
                        var form = $("#formAbsensi").serialize()
                        $.ajax({
                            
                            url:getLink,
                            method:"POST",
                            data:form,
                            success:function(data){
                                var d = $.parseJSON(data);
                                // console.log(d.info);
                                load_data(page)
                                getSumary()
                                Swal.fire({
                                    title: d.message,
                                    text: d.info,
                                    timer: 2000,
                                    
                                    icon: d.icon,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    confirmButtonColor: '#00B9FF',
                                    cancelButtonColor: '#B2BABB',
                                    
                                })
                            }
                        })
                        
                    }else{
                        Swal.fire({
                            title: "Gagal",
                            text: "tidak ada data yang dipilih",
                            // icon: "danger",
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            confirmButtonColor: '#00B9FF',
                            cancelButtonColor: '#B2BABB',
                            
                        })
                    }
                
                }
            })
            
        });
        // approve SPV
        $(document).on('click','.approveAll', function(){
            var page = $('.page_active').attr('id')
            var getLink = '../proses-approval.php?approve_multiple=';
                
                Swal.fire({
                title: 'Pengajuan Disetujui?',
                text: "Semua data yang dicheck / centang akan disetujui untuk diproses admin",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3498DB',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Yes, Setujui!'
            }).then((result) => {
                if (result.value) {
                    if(totalCheck('.mp:checked') > 0){
                        var form = $("#formAbsensi").serialize()
                        $.ajax({
                            
                            url:getLink,
                            method:"POST",
                            data:form,
                            success:function(data){
                                
                                var d = $.parseJSON(data);
                                // console.log(d.info);
                                load_data(page)
                                getSumary()
                                Swal.fire({
                                    title: d.message,
                                    text: d.info,
                                    timer: 2000,
                                    
                                    icon: d.icon,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    confirmButtonColor: '#00B9FF',
                                    cancelButtonColor: '#B2BABB',
                                    
                                })
                            }
                        })
                        
                    }else{
                        Swal.fire({
                            title: "Gagal",
                            text: "tidak ada data yang dipilih",
                            // icon: "danger",
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            confirmButtonColor: '#00B9FF',
                            cancelButtonColor: '#B2BABB',
                            
                        })
                    }
                
                }
            })
            
        });
        // reject SPV
        $(document).on('click','.rejectAll', function(){
            var page = $('.page_active').attr('id')
            var getLink = '../proses-approval.php?reject_multiple=';
                
                Swal.fire({
                title: 'Pengajuan Ditolak?',
                text: "Semua data yang dicheck / centang akan ditolak dan tidak akan diteruskan ke admin untuk diproses serta pengajuan yang sama tidak dapat dibuat kembali",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FF5733',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Yes, Tolak Pengajuan!'
            }).then((result) => {
                if (result.value) {
                    if(totalCheck('.mp:checked') > 0){
                        var form = $("#formAbsensi").serialize()
                        $.ajax({
                            
                            url:getLink,
                            method:"POST",
                            data:form,
                            success:function(data){
                                var d = $.parseJSON(data);
                                // console.log(d.info);
                                load_data(page)
                                getSumary()
                                Swal.fire({
                                    title: d.message,
                                    text: d.info,
                                    timer: 2000,
                                    
                                    icon: d.icon,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    confirmButtonColor: '#00B9FF',
                                    cancelButtonColor: '#B2BABB',
                                    
                                })
                            }
                        })
                        
                    }else{
                        Swal.fire({
                            title: "Gagal",
                            text: "tidak ada data yang dipilih",
                            // icon: "danger",
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            confirmButtonColor: '#00B9FF',
                            cancelButtonColor: '#B2BABB',
                            
                        })
                    }
                
                }
            })
            
        });
        // reject SPV
        $(document).on('click','.deleteAll', function(){
            var page = $('.page_active').attr('id')
            var getLink = '../proses-approval.php?delete_multiple=';
                
                Swal.fire({
                title: 'Delete Data Pengajuan?',
                text: "Semua data yang dicheck / centang akan dihapus secara permanent dari database",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FF5733',
                cancelButtonColor: '#B2BABB',
                confirmButtonText: 'Yes, proses!'
            }).then((result) => {
                if (result.value) {
                    if(totalCheck('.mp:checked') > 0){
                        var form = $("#formAbsensi").serialize()
                        $.ajax({
                            
                            url:getLink,
                            method:"POST",
                            data:form,
                            success:function(data){
                                var d = $.parseJSON(data);
                                // console.log(d.info);
                                load_data(page)
                                getSumary()
                                Swal.fire({
                                    title: d.message,
                                    text: d.info,
                                    timer: 2000,
                                    
                                    icon: d.icon,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    confirmButtonColor: '#00B9FF',
                                    cancelButtonColor: '#B2BABB',
                                    
                                })
                            }
                        })
                        
                    }else{
                        Swal.fire({
                            title: "Gagal",
                            text: "tidak ada data yang dipilih",
                            // icon: "danger",
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            confirmButtonColor: '#00B9FF',
                            cancelButtonColor: '#B2BABB',
                            
                        })
                    }
                
                }
            })
            
        });

    })
    
    </script>
    <script>
        $(document).ready(function(){
            
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
        })
    </script>
    <!-- <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('click', '.view_data', function(){
                var id = $(this).parents("tr").attr("id");
                
                $.ajax({
                    url: '../ajax/view.php',	
                    method: 'post',
                    data: {id:id},		
                    success:function(data){
                        $('#view_data').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                        $('#myView').modal("show");	// menampilkan dialog modal nya
                    }
                });
            });
            $(document).on('click', '.td', function(){
                var id = $(this).parent('tr').attr("id");
                
                
                $.ajax({
                    url: '../ajax/view.php',	
                    method: 'post',
                    data: {id:id},		
                    success:function(data){
                        $('#view_data').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
                        $('#myView').modal("show");	// menampilkan dialog modal nya
                    }
                });
            });
        });
        
    </script> -->

    
    
<?php
    include_once("../../endbody.php");
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>