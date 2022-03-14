
<?php

//////////////////////////////////////////////////////////////////////
include("../../../../config/config.php");
if(isset($_SESSION['user'])){
    if($level >=1 && $level <=8){
        require_once("../../../../config/approval_system.php");
        if(isset($_GET['summary_approval'])){
            $start = dateToDB($_GET['start']);
            $end = dateToDB($_GET['end']);
            
        }else{
            $start =$_GET['start'];
            $end = $_GET['end'];

        }
        // echo $start;s
        $filter = $_GET['filter'];
        $div_filter = $_GET['div'];
        // echo $div;
        $dept_filter = $_GET['dept'];
        // echo $dept_filter;
        $sect_filter = $_GET['sect'];
        // echo $sect_filter;
        $group_filter = $_GET['group'];
        // echo $group_filter;
        $deptAcc_filter = $_GET['deptAcc'];
        // echo $deptAcc_filter;
        $shift = $_GET['shift'];
        // echo $shift;
        $cari = (isset($_GET['cari']))?$_GET['cari']:'';
        $level = $level;
        $npk = $npkUser;
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
        $origin_query = "SELECT view_req_ot.id_ot,
            view_req_ot.npk,
            view_req_ot.nama,
            view_req_ot.shift,
            view_req_ot.ot_code,
            view_req_ot.requester,
            view_req_ot.in_date,
            view_req_ot.work_date,
            view_req_ot.start,
            view_req_ot.out_date,
            view_req_ot.end,
            view_req_ot.job_code,
            view_req_ot.activity,
            view_req_ot.status_approve,
            view_req_ot.status_progress,
            view_req_ot.post,
            view_req_ot.grp,
            view_req_ot.sect,
            view_req_ot.dept,
            view_req_ot.dept_account,
            view_req_ot.division,
            view_req_ot.plant, CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) AS `status`
            FROM view_req_ot ";
        $access_org = orgAccess($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        $add_filter = filterDataOt($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        
        $query_req_overtime = filtergenerator($link, $level, $generate, $origin_query, $access_org)." AND work_date BETWEEN '$start' AND '$end' ".$add_filter;
        
        $_SESSION['startD'] = (isset($_GET['start']))? $start : date('Y-m-01');
        $_SESSION['endD'] = (isset($_GET['end']))? $end : date('Y-m-d');

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

        
        $t = "org.".$org_access;
        
        //monitor progress
        $qryData = $query_req_overtime;
        // echo $qryData;
       
        // total pengajuan , tidak terhitung data yang dari upload migrasi
        $q_reqs = $qryData." AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) <> '100e' ";
        $s_reqs = mysqli_query($link, $q_reqs)or die(mysqli_error($link));
        $reqs = mysqli_num_rows($s_reqs);
        // pengajuan yang belum diproses spv
        $q_wait = $qryData." AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '25a' ";
        $s_wait = mysqli_query($link, $q_wait)or die(mysqli_error($link));
        $wait = mysqli_num_rows($s_wait);
        // pengajuan yang diapprove spv
        $q_apprv = $qryData." AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '50a' " ;
        $s_apprv = mysqli_query($link, $q_apprv)or die(mysqli_error($link));
        $apprv = mysqli_num_rows($s_apprv);
        // pengajuan yang diproses admin
        $q_prcss = $qryData." AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '75a' ";
        $s_prcss = mysqli_query($link, $q_prcss)or die(mysqli_error($link));
        $prcss = mysqli_num_rows($s_prcss);
        // pengajuan yang sudah selesai
        $q_scss = $qryData." AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '100a' ";
        $s_scss = mysqli_query($link, $q_scss)or die(mysqli_error($link));
        $scss = mysqli_num_rows($s_scss);
        // pengajuan yang ditolak spv
        $q_reject = $qryData." AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '100b'";
        $s_reject = mysqli_query($link, $q_reject)or die(mysqli_error($link));
        $reject = mysqli_num_rows($s_reject);
        // pengajuan yang dihentikan admin, misal jml pengajuan habis
        $q_stop = $qryData." AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '100c'";
        $s_stop = mysqli_query($link, $q_stop)or die(mysqli_error($link));
        $stop = mysqli_num_rows($s_stop);
        // pengajuan yang dikembalikan admin untuk dikonfirmasi tolak atau dihapus foreman
        $q_confirm = $qryData." AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '100d' ";
        $s_confirm = mysqli_query($link, $q_confirm)or die(mysqli_error($link));
        $confirm = mysqli_num_rows($s_confirm);
        // pengajuan yang masih dalam status approval online oleh dept head
        $q_onl = $qryData." AND CONCAT(view_req_ot.status_approve,view_req_ot.status_progress) = '100f' ";
        $s_onl = mysqli_query($link, $q_onl)or die(mysqli_error($link));
        $onl = mysqli_num_rows($s_onl);
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 col-sm-6"> 
                        <div class="card-plain card-stats bg-transparent h-100 my-0 border-right border-left">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-5 col-md-4">
                                        <div class="icon-big text-center icon-warning ">
                                        <i class="nc-icon nc-ruler-pencil text-warning "></i>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="owl-carousel">
                                            <div class="numbers ">
                                                <p class="card-category">Total</p>
                                                <p class="card-title"><?=$reqs?></p>
                                            </div>
                                            <div class="numbers ">
                                                <p class="card-category">Waiting</p>
                                                <p class="card-title"><?=$wait?></p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 ">
                        <div class="card-plain card-stats bg-transparent h-100 my-0 border-right border-left">
                            
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-5 col-md-4">
                                        <div class="icon-big text-center icon-warning ">
                                        <i class="nc-icon nc-paper text-danger "></i>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="owl-carousel">
                                            <div class="numbers ">
                                                <p class="card-category">Disetujui</p>
                                                <p class="card-title"><?=$apprv?><p>
                                            </div>
                                            <div class="numbers ">
                                                <p class="card-category">Ditolak</p>
                                                <p class="card-title"><?=$reject?><p>
                                            </div>
                                            

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card-plain card-stats bg-transparent h-100 my-0 border-right border-left">
                            <div class="card-body ">
                                <div class="row ">
                                    <div class="col-5 col-md-4">
                                        <div class="icon-big text-center icon-warning ">
                                        <i class="nc-icon nc-single-copy-04 text-primary "></i>
                                        </div>
                                    </div>
                                    <div class="col-7 text-right">
                                        <div class="owl-carousel">
                                            <div class="numbers ">
                                                <p class="card-category">Diproses</p>
                                                <p class="card-title"><?=$prcss?><p>
                                            </div>
                                            <div class="numbers ">
                                                <p class="card-category">Dihentikan</p>
                                                <p class="card-title"><?=$stop?><p>
                                            </div>
                                            <div class="numbers ">
                                                <p class="card-category">Dikembalikan</p>
                                                <p class="card-title"><?=$confirm?><p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card-plain card-stats bg-transparent h-100 my-0 border-right border-left">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-5 col-md-4">
                                        <div class="icon-big text-center icon-warning ">
                                        <i class="nc-icon nc-check-2 text-success "></i>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="owl-carousel">
                                            <div class="numbers ">
                                                <p class="card-category">Sukses</p>
                                                <p class="card-title"><?=$scss?><p>
                                            </div>
                                            <div class="numbers ">
                                                <p class="card-category">Aprove Online</p>
                                                <p class="card-title"><?=$onl?><p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        <script>
            $(document).ready(function(){
                var owl = $('.owl-carousel');
                owl.owlCarousel({
                    items:1,
                    loop:true,
                    margin:10,
                    autoplay:true,
                    autoplayTimeout:3000,
                    autoplayHoverPause:true
                });
                $('.play').on('click',function(){
                    owl.trigger('play.owl.autoplay',[1000])
                })
                $('.stop').on('click',function(){
                    owl.trigger('stop.owl.autoplay')
                })
            });
        </script>

        <?php
    }else{
        include_once ("../../../no_access.php");
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>