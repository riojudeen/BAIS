
<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Application Control";
if(isset($_SESSION['user'])){
    include_once("../header.php");
    ?>


<?php
    
    $queryDB = "SELECT table_schema as 'database', SUM(data_length + index_length) / 1024 / 1024 as 'MB',  COUNT(data_length) AS 'total_table' FROM information_schema.tables   
    WHERE table_schema = 'bais_db' GROUP BY table_schema   ORDER BY SUM(data_length + index_length) DESC  ; ";

        $sqlDB = mysqli_query($link, $queryDB)or die(mysqli_error($link));
        $dataDB = mysqli_fetch_assoc($sqlDB);
        $DBsize = Round($dataDB['MB'], 2);
        // echo $DBsize."<br>";
    $query = "SELECT table_name as 'table', engine as 'Engine', table_rows as 'rows',  data_length / 1024 / 1024 as 'size'   
        FROM information_schema.tables   
        where table_schema = 'bais_db'   
        order by data_length desc, table_rows";
    $queryTbAbsensi = " SELECT table_name as 'table', engine as 'Engine', table_rows as 'rows', data_length / 1024 / 1024 as 'size'   
        FROM information_schema.tables   
        where table_schema = 'bais_db' AND table_name = 'absensi' 
        order by data_length desc, table_rows";
    $sqlAbsen = mysqli_query($link, $queryTbAbsensi)or die(mysqli_error($link));
    $tbAbsen = mysqli_fetch_assoc($sqlAbsen);
    $queryTbAbsensiReq = " SELECT table_name as 'table', engine as 'Engine', table_rows as 'rows', data_length / 1024 / 1024 as 'size'   
        FROM information_schema.tables   
        where table_schema = 'bais_db' AND table_name = 'req_absensi' 
        order by data_length desc, table_rows";
    $sqlAbsenReq = mysqli_query($link, $queryTbAbsensiReq)or die(mysqli_error($link));
    $tbAbsenReq = mysqli_fetch_assoc($sqlAbsenReq);
    $queryOt = " SELECT table_name as 'table', engine as 'Engine', table_rows as 'rows', data_length / 1024 / 1024 as 'size'   
        FROM information_schema.tables   
        where table_schema = 'bais_db' AND table_name = 'hr_lembur' 
        order by data_length desc, table_rows";
    $sqlOt = mysqli_query($link, $queryOt)or die(mysqli_error($link));
    $tbOt = mysqli_fetch_assoc($sqlOt);
    $queryOtReq = " SELECT table_name as 'table', engine as 'Engine', table_rows as 'rows', data_length / 1024 / 1024 as 'size'   
        FROM information_schema.tables   
        where table_schema = 'bais_db' AND table_name = 'lembur' 
        order by data_length desc, table_rows";
    $sqlOtReq = mysqli_query($link, $queryOtReq)or die(mysqli_error($link));
    $tbOtReq = mysqli_fetch_assoc($sqlOtReq);
    // echo $tbAbsenReq['table'];
    $queryInt = "SELECT hour , (SELECT count(waktu) FROM user_interaction WHERE EXTRACT(HOUR FROM waktu) = hour ) tot_jam , (SELECT count(user) FROM user_interaction )AS total_click  FROM 
    (SELECT user, EXTRACT(HOUR FROM waktu) AS hour FROM user_interaction GROUP BY hour) AS interaction ORDER BY tot_jam DESC LIMIT 1";
    $sql_Int = mysqli_query($link, $queryInt)or die(mysqli_error($link));
    $Data_Int = mysqli_fetch_assoc($sql_Int);
    $totalInt = $Data_Int['total_click'];
    $hour = ($Data_Int['hour'] != '')?$Data_Int['hour']."h":"-";
    // echo $hour;
    


    $q_user = mysqli_query($link, "SELECT user_role.role_name AS role_name, view_user.npk,view_user.level_user, view_user.nama, view_organization.groupfrm AS grp, view_organization.section AS sect, view_organization.dept AS dept, view_organization.dept_account AS dept_account FROM view_user LEFT JOIN view_organization ON view_organization.npk = view_user.npk 
                LEFT JOIN user_role ON user_role.id_role = view_user.level_user")or die(mysqli_error($link));
                $totUser = mysqli_num_rows($q_user);

    $queryUser = "SELECT npk FROM view_user";
    $queryAct = "SELECT COUNT(id) FROM user_interaction";
    $sql_Act = mysqli_query($link, $queryAct)or die(mysqli_error($link));
    $totalAct = mysqli_num_rows($sql_Act);


    $avg = ($totUser > 0)?$totalInt/$totUser:0;
    // $totalAct = $Data_Act['tot_active'];
    // echo $Data_Int['hour'];
    // echo ceil(Round($tbAbsenReq['size']));
        $sql = mysqli_query($link, $query)or die(mysqli_error($link));
        $total_table = mysqli_num_rows($sql);
        $array_table = array();
        $array_table_size = array();
        $array_table_row = array();
        if(mysqli_num_rows($sql)>0){
            $total_row = 0;
            while($data = mysqli_fetch_assoc($sql)){
                array_push($array_table, $data['table']);
                array_push($array_table_size, Round($data['size'], 2));
                array_push($array_table_row, $data['rows']);
                $total_row += (int)$data['rows'];

                // echo $data['table']." :".$data['size']." :".$data['rows']."<br>";
            }
        }
        // print_r($array_table_size)
        // echo $total_row;
    ?>
<div class="row">
    <div class="col-md-12">
        <h5 class="card-title mb-0"> User Interactions</h5>
        <p class="card-category mt-0"></p>
        <hr class="mt-0">
        <div class="card card-stats shadow-none" style="border-radius:20px; background-color:rgba(255,253,168, 0.5);
background: linear-gradient(180deg, rgba(255,253,168, 1) 0%, rgba(255,253,168, 0.0) 100%, rgba(255,253,168, 0.0) 100%);">
            <div class="card-body " id="4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-5 col-md-4">
                                        <div class="icon-big text-center icon-white">
                                        <span class="fa-stack" >
                                                <i class="far fa-circle fa-stack-2x text-light mt-1 pb-3"></i>
                                                <p class="title text-secondary" style="margin-top:-20px; font-size:25px"><?=$totalInt?>
                                                <p class="category label bold text-uppercase "style="margin-top:-70px;font-size:10px" >
                                                <i class="fas fa-mouse"></i> <strong>hits</strong></p>
                                                </p>
                                                <!-- <i class="fas fa-car fa-stack-1x fa-inverse mt-1"></i> -->
                                                <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                                <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-7 col-md-8 ">
                                        <div class="numbers text-left pl-3">
                                            <p class="card-title text-secondary ">Total<p>
                                            <p class="card-category  text-secondary mb-3"> Interaction</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-5 col-md-4">
                                        <div class="icon-big text-center icon-white">
                                        <span class="fa-stack" >
                                                <i class="far fa-circle fa-stack-2x text-light mt-1 pb-3"></i>
                                                <p class="title text-secondary" style="margin-top:-20px; font-size:25px"><?=$hour?>
                                                <p class="category label bold text-uppercase "style="margin-top:-70px;font-size:10px" >
                                                <i class="fas fa-history"></i> <strong>WIB</strong></p>
                                                </p>
                                                <!-- <i class="fas fa-car fa-stack-1x fa-inverse mt-1"></i> -->
                                                <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                                <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-7 col-md-8 ">
                                        <div class="numbers text-left pl-3">
                                            <p class="card-title text-secondary ">Critical<p>
                                            <p class="card-category  text-secondary mb-3"> Hour</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-5 col-md-4">
                                        <div class="icon-big text-center icon-white">
                                        <span class="fa-stack" >
                                                <i class="far fa-circle fa-stack-2x text-light mt-1 pb-3"></i>
                                                <p class="title text-secondary" style="margin-top:-20px; font-size:25px"><?=Round($avg,2)?>
                                                <p class="category label bold text-uppercase "style="margin-top:-70px;font-size:10px" >
                                                <i class="fas fa-stopwatch-20"></i> <strong>times</strong></p>
                                                </p>
                                                <!-- <i class="fas fa-car fa-stack-1x fa-inverse mt-1"></i> -->
                                                <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                                <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-7 col-md-8 ">
                                        <div class="numbers text-left pl-3">
                                            <p class="card-title text-secondary ">Avg<p>
                                            <p class="card-category  text-secondary mb-3"> hits / User</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-5 col-md-4">
                                        <?php
                                        $q_user = mysqli_query($link, "SELECT user_role.role_name AS role_name, view_user.npk,view_user.level_user, view_user.nama, view_organization.groupfrm AS grp, view_organization.section AS sect, view_organization.dept AS dept, view_organization.dept_account AS dept_account FROM view_user LEFT JOIN view_organization ON view_organization.npk = view_user.npk 
                                        LEFT JOIN user_role ON user_role.id_role = view_user.level_user WHERE stats = '1'")or die(mysqli_error($link));
                                        $totUserActive = mysqli_num_rows($q_user);
                                        ?>
                                        <div class="icon-big text-center icon-white">
                                        <span class="fa-stack" >
                                                <i class="far fa-circle fa-stack-2x text-light mt-1 pb-3"></i>
                                                <p class="title text-secondary" style="margin-top:-20px; font-size:25px"><?=$totUserActive?> 
                                                <p class="category label bold text-uppercase "style="margin-top:-70px;font-size:10px" >
                                                <i class="fas fa-user"></i> <strong>users</strong></p>
                                                </p>
                                                <!-- <i class="fas fa-car fa-stack-1x fa-inverse mt-1"></i> -->
                                                <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                                <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-7 col-md-8 ">
                                        <div class="numbers text-left  pl-3">
                                            <p class="card-title text-secondary ">Active<p>
                                            <p class="card-category  text-secondary mb-3"> of <?=$totUser?> users</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 px-2 text-right" >
                        
                        <?php
                        // include_once('heatmap.php');
                        include_once('cal-heatmap.php');
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="card-category">Active User</h5>
                        <div class="row">
                            <div class="col-md-12 table-full-width text-uppercase">
                                <div class="" >
                                    <table class="table-sm" width="100%">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>#</th>
                                                <th>Npk</th>
                                                <th>Name</th>
                                                <th>Group</th>
                                                <th>Section</th>
                                                <th>Dept</th>
                                                <th>Dept Adm</th>
                                                <th>Level User</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            if(mysqli_num_rows($q_user)>0){
                                                $no = 1;
                                                while($data_active = mysqli_fetch_assoc($q_user)){
                                                    ?>
                                                    <tr>
                                                        <td><?=$no++?></td>
                                                        <td><?=$data_active['npk']?></td>
                                                        <td><?=$data_active['nama']?></td>
                                                        <td><?=$data_active['grp']?></td>
                                                        <td><?=$data_active['sect']?></td>
                                                        <td><?=$data_active['dept']?></td>
                                                        <td><?=$data_active['dept_account']?></td>
                                                        <td><?=$data_active['role_name']?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }


                                            ?>
                                        </tbody>
                                    </table>
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
</div>
<div class="row">
    <div class="col-md-12">
    <h5 class="card-title">DB Statistics</h5>
    <p class="card-category mt-0">Measure DB Performances</p>
    <hr class="mt-0">
        <div class="card card-plain">
            <div class="card-body">
                
                <div class="row " >
                    <div class="col-md-12">
                            <div class="row rounded flex-row flex-nowrap overflow-auto img_holder" id="b">
                                <div class="col-md-12">
                                    <div class="owl-carousel owl-theme">
                                        <div class="card card-stats  item">
                                            <div class="card-body " id="4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-5 col-md-4">
                                                                        <div class="icon-big text-center icon-danger">
                                                                            <span class="fa-stack" >
                                                                                <i class="far fa-circle fa-stack-2x fa-inverse mt-1 pb-3 text-info"></i>
                                                                                <p class="text-info title " style="margin-top:-20px; font-size:25px"><?=Round($tbOt['size'],2)?>
                                                                                <p class="category label bold text-uppercase text-info"style="margin-top:-70px;font-size:10px" >
                                                                                <i class="fas fa-save"></i> <strong>mb</strong></p>
                                                                                </p>
                                                                                <!-- <i class="fas fa-car fa-stack-1x fa-inverse mt-1"></i> -->
                                                                                <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                                                                <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-7 col-md-8 ">
                                                                        <div class="numbers text-left border-left pl-3">
                                                                            <p class="card-title text-info">Overtime<p>
                                                                            <p class="card-category  text-info mb-3"> HR Record</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-5 col-md-4">
                                                                        <div class="icon-big text-center icon-info">
                                                                        <span class="fa-stack" >
                                                                                <i class="far fa-circle fa-stack-2x fa-inverse mt-1 pb-3 text-info"></i>
                                                                                <p class="text-info title " style="margin-top:-20px; font-size:25px"><?=Round($tbOtReq['size'],2)?>
                                                                                <p class="category label bold text-uppercase text-info"style="margin-top:-70px;font-size:10px" >
                                                                                <i class="fas fa-save"></i> <strong>mb</strong></p>
                                                                                </p>
                                                                                <!-- <i class="fas fa-car fa-stack-1x fa-inverse mt-1"></i> -->
                                                                                <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                                                                <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-7 col-md-8 ">
                                                                        <div class="numbers text-left border-left pl-3">
                                                                            <p class="card-title text-info">Overtime<p>
                                                                            <p class="card-category  text-info mb-3"> Request Record</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-stats item">
                                            <div class="card-body " id="4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-5 col-md-4">
                                                                        <div class="icon-big text-center icon-info">
                                                                        <span class="fa-stack" >
                                                                                <i class="far fa-circle fa-stack-2x fa-inverse mt-1 pb-3 text-info"></i>
                                                                                <p class="text-info title " style="margin-top:-20px; font-size:25px"><?=Round($tbAbsen['size'],2)?>
                                                                                <p class="category label bold text-uppercase text-info"style="margin-top:-70px;font-size:10px" >
                                                                                <i class="fas fa-save"></i> <strong>mb</strong></p>
                                                                                </p>
                                                                                <!-- <i class="fas fa-car fa-stack-1x fa-inverse mt-1"></i> -->
                                                                                <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                                                                <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-7 col-md-8 ">
                                                                        <div class="numbers text-left border-left pl-3">
                                                                            <p class="card-title text-info ">Attendance<p>
                                                                            <p class="card-category  text-info mb-3"> HR Record</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-5 col-md-4">
                                                                        <div class="icon-big text-center icon-info">
                                                                        <span class="fa-stack" >
                                                                                <i class="far fa-circle fa-stack-2x fa-inverse mt-1 pb-3 text-info"></i>
                                                                                <p class="text-info title " style="margin-top:-20px; font-size:25px"><?=Round($tbAbsenReq['size'],2)?>
                                                                                <p class="category label bold text-uppercase text-info"style="margin-top:-70px;font-size:10px" >
                                                                                <i class="fas fa-save"></i> <strong>mb</strong></p>
                                                                                </p>
                                                                                <!-- <i class="fas fa-car fa-stack-1x fa-inverse mt-1"></i> -->
                                                                                <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                                                                <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-7 col-md-8 ">
                                                                        <div class="numbers text-left border-left pl-3">
                                                                            <p class="card-title text-info">Leave<p>
                                                                            <p class="card-category text-info mb-3"> Request Record</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- </div> -->

                                    </div>
                                </div>
                                
                            </div>
                    </div>
                    <div class="col-md-3 " style="border-radius:20px; background-color:rgba(232, 230, 222, 0.5);
background: linear-gradient(180deg, rgba(232, 230, 222, 1) 0%, rgba(232, 230, 222, 0.0) 100%, rgba(232, 230, 222, 0.0) 100%);">
                        <div class="row">
                            <div class="col-md-12 " >
                                <div class="card card-plain" >
                                    <div class="card-header ">
                                        <p class="card-category">Total Size in Database</p>
                                    </div>
                                    <div class="card-body ">
                                        <canvas id="chartDB" class="ct-chart ct-perfect-fourth" width="456" height="400"></canvas>
                                        <div class="legend text-info">
                                        <i class="fa fa-circle "></i> size
                                        </div>
                                        <hr class="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="text-secndary" >
                                                    <li>total table : 
                                                        <span class="badge badge-sm badge-pill badge-round badge-primary text-right"><?=$total_table?> Tables</span>
                                                        <hr class="my-1">
                                                    </li>
                                                    <li>total rows : 
                                                        <span class="badge badge-sm badge-pill badge-round badge-primary text-right"><?=$total_row?> rows</span>
                                                        <hr class="my-1">
                                                    </li>
                                                    <li>avg size / table : 
                                                        <?php
                                                        $avg = ($DBsize>0)?$DBsize/$total_table:'-';
                                                        $avg_row = ($total_table>0)?$total_row/$total_table:'-';
                                                        $avg_size_row = ($total_row>0)?($DBsize*1024*1024)/$total_row:'-';
                                                        ?>
                                                        <span class="badge badge-sm badge-pill badge-round badge-primary text-right"><?=round($avg,2)?> MB</span>
                                                        <hr class="my-1">
                                                    </li>
                                                    <li>avg size / rows :
                                                        <span class="badge badge-sm badge-pill badge-round badge-primary text-right"><?=round($avg_size_row, 2)?> B</span>
                                                        <hr class="my-1">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <hr class="">
                                    </div>
                                </div>
                        
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">

                        

                        <!-- <script>
                            var scroller = {};
                            scroller.e = document.getElementById("b");

                            if (scroller.e.addEventListener) {
                                scroller.e.addEventListener("mousewheel", MouseWheelHandler, false);
                                scroller.e.addEventListener("DOMMouseScroll", MouseWheelHandler, false);
                                scroller.e.addEventListener("mousemove", MouseWheelHandler, false);
                            } else scroller.e.attachEvent("onmousewheel", MouseWheelHandler);

                            function MouseWheelHandler(e) {

                                // cross-browser wheel delta
                                var e = window.event || e;
                                var delta = - 30 * (Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail))));

                                var pst = $('#b').scrollLeft() + delta;

                                if (pst < 0) {
                                    pst = 0;
                                } else if (pst > $('.img_holder').width()) {
                                    pst = $('.img_holder').width();
                                }

                                $('#b').scrollLeft(pst);

                                return false;
                            }
                        </script> -->
                        <script>
                            $(document).ready(function(){
                            var owl = $('.owl-carousel');
                                owl.owlCarousel({
                                    items:1,
                                    loop:true,
                                    margin:30,
                                    // nav:true,
                                    autoplay:true,
                                    autoplayTimeout:3000,
                                    autoplayHoverPause:true
                                });
                                owl.on('mousewheel', '.owl-stage', function (e) {
                                    if (e.deltaY>0) {
                                        owl.trigger('next.owl');
                                    } else {
                                        owl.trigger('prev.owl');
                                    }
                                    e.preventDefault();
                                });
                            });
                        </script>
                        <div class="card shadow-none" style="border-radius:20px; background-color:rgba(255,255,255, 0.5);
background: linear-gradient(180deg, rgba(255,255,255, 1) 0%, rgba(255,255,255, 0.0) 100%, rgba(255,255,255, 0.0) 100%);">
                            <div class="card-header ">
                                <p class="card-category">Size on disk</p>
                                
                            </div>
                            <div class="card-body ">
                                <canvas id="chartTable" class="ct-chart ct-perfect-fourth" width="456" height="150" ></canvas>
                            </div>
                            
                        </div>
                        <hr>
                        <div class="card shadow-none" style="border-radius:20px; background-color:rgba(255,255,255, 0.5);
background: linear-gradient(180deg, rgba(255,255,255, 1) 0%, rgba(255,255,255, 0.0) 100%, rgba(255,255,255, 0.0) 100%);">
                            <div class="card-header ">
                                <p class="card-category">Rows on Table</p>
                            </div>
                            <div class="card-body ">
                                <canvas id="chartTableRow" class="ct-chart ct-perfect-fourth" width="456" height="150"></canvas>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
</div>
<div class="row">
<div class="col-md-12">
    <h5 class="card-title ">External Directory</h5>
    <p class="card-category mt-0">Root folder of external database </p>
    <hr class="mt-0">
    <div class="card ">
        <div class="card-body text-uppercase">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Root Directory</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $q_ext = "SELECT * FROM external_directory";
                        $sql_ext = mysqli_query($link, $q_ext)or die(mysqli_error($link));
                        if(mysqli_num_rows($sql_ext)>0){
                            $no = 1;
                            while($data_ext = mysqli_fetch_assoc($sql_ext)){
                                ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$data_ext['root']?></td>
                                    <td><?=$data_ext['keterangan']?></td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php
    include_once("../footer.php");
    ?>
    <script>
    // CHARTS
    chartColor = "#FFFFFF";
    
    ctx = document.getElementById('chartTable').getContext("2d");

    gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#80b6f4');
    gradientStroke.addColorStop(1, chartColor);

    gradientFill = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill.addColorStop(0, "rgba(52, 152, 219, 1)");
    gradientFill.addColorStop(1, "rgba(52, 152, 219, 0.3)");

    gradientFill2 = ctx.createLinearGradient(0, 50, 1, 150);
    gradientFill2.addColorStop(0, "rgba(255, 199, 51, 0.5)");
    gradientFill2.addColorStop(1, "rgba(255, 199, 51, 0.0)");

    gradientFill3 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill3.addColorStop(0, "rgba(241, 196, 15, 1)");
    gradientFill3.addColorStop(1, "rgba(241, 196, 15, 0.5)");


    gradientFill4 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill4.addColorStop(0, "rgba(248, 196, 113, 1)");
    gradientFill4.addColorStop(1, "rgba(248, 196, 113, 0.5)");

    gradientFill5 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill5.addColorStop(0, "rgba(247, 220, 111, 1)");
    gradientFill5.addColorStop(1, "rgba(247, 220, 111, 0.5)");

    myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [
            <?php
                $index = 1;
                $total = count($array_table);
                // echo $total;
                foreach($array_table AS $tb){
                    echo "'".$tb."'" ;
                    if($index < $total){
                        echo ",";
                    }
                    $index++;
                }
            ?>
        ],
        datasets: [
          {
            label: "Size",
            yAxisID: 'A',
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [ 
                <?php
                    $index = 0;
                    $total = count($array_table_size);
                    foreach($array_table_size AS $sizeMB){
                        echo $sizeMB ;
                        if($index < $total){
                            echo ",";
                        }
                        $index++;
                    }
                ?>
            ],
          },
        ]
      },
      options: {
        
        tooltips: {
          tooltipFillColor: "rgba(0,0,0,0.5)",
          tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
          tooltipFontSize: 14,
          tooltipFontStyle: "normal",
          tooltipFontColor: "#fff",
          tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
          tooltipTitleFontSize: 14,
          tooltipTitleFontStyle: "bold",
          tooltipTitleFontColor: "#fff",
          tooltipYPadding: 6,
          tooltipXPadding: 6,
          tooltipCaretSize: 8,
          tooltipCornerRadius: 6,
          tooltipXOffset: 10,
        },


        legend: {

          display: false
        },
        scales: {

          yAxes: [{
            id: 'A',
            position: 'left',
            stacked: true,
            ticks: {
              fontColor: "#9f9f9f",
              fontStyle: "bold",
              beginAtZero: true,
              maxTicksLimit: 5,
              padding: 10,
              steps: 10,
              stepValue: 5,
              max: <?=ceil(max($array_table_size))?>
            },
            gridLines: {
              zeroLineColor: "transparent",
              display: false,
              drawBorder: false,
              color: '#9f9f9f',
            }

          }],
          xAxes: [{
            stacked: true,
            barPercentage: 0.9,
            barThickness: 6,  // number (pixels) or 'flex'
            maxBarThickness: 6, // number (pixels)
            
            gridLines: {
              zeroLineColor: "white",
              display: false,

              drawBorder: false,
              color: 'transparent',
            },
            ticks: {
                padding: 10,
                fontColor: "#9f9f9f",
                fontStyle: "bold",
                
            }
          }]
        }
      }
    });
    </script> 
    <script>
    // CHARTS
    chartColor = "#FFFFFF";
    
    ctx = document.getElementById('chartTableRow').getContext("2d");

    gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#80b6f4');
    gradientStroke.addColorStop(1, chartColor);

    gradientFill = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill.addColorStop(0, "rgba(52, 152, 219, 1)");
    gradientFill.addColorStop(1, "rgba(52, 152, 219, 0.3)");

    gradientFill2 = ctx.createLinearGradient(0, 50, 1, 150);
    gradientFill2.addColorStop(0, "rgba(255, 199, 51, 0.5)");
    gradientFill2.addColorStop(1, "rgba(255, 199, 51, 0.0)");

    gradientFill3 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill3.addColorStop(0, "rgba(241, 196, 15, 1)");
    gradientFill3.addColorStop(1, "rgba(241, 196, 15, 0.5)");


    gradientFill4 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill4.addColorStop(0, "rgba(248, 196, 113, 1)");
    gradientFill4.addColorStop(1, "rgba(248, 196, 113, 0.5)");

    gradientFill5 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill5.addColorStop(0, "rgba(247, 220, 111, 1)");
    gradientFill5.addColorStop(1, "rgba(247, 220, 111, 0.5)");

    myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [
            <?php
                $index = 1;
                $total = count($array_table);
                // echo $total;
                foreach($array_table AS $tb){
                    echo "'".$tb."'" ;
                    if($index < $total){
                        echo ",";
                    }
                    $index++;
                }
            ?>
        ],
        datasets: [
          {
            label: "Rows",
            yAxisID: 'A',
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [ 
                <?php
                    $index = 0;
                    $total = count($array_table_row);
                    foreach($array_table_row AS $row){
                        echo $row ;
                        if($index < $total){
                            echo ",";
                        }
                        $index++;
                    }
                ?>
            ],
          }
        ]
      },
      options: {
        
        tooltips: {
          tooltipFillColor: "rgba(0,0,0,0.5)",
          tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
          tooltipFontSize: 14,
          tooltipFontStyle: "normal",
          tooltipFontColor: "#fff",
          tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
          tooltipTitleFontSize: 14,
          tooltipTitleFontStyle: "bold",
          tooltipTitleFontColor: "#fff",
          tooltipYPadding: 6,
          tooltipXPadding: 6,
          tooltipCaretSize: 8,
          tooltipCornerRadius: 6,
          tooltipXOffset: 10,
        },


        legend: {

          display: false
        },
        scales: {

          yAxes: [{
            id: 'A',
            position: 'left',
            stacked: true,
            ticks: {
              fontColor: "#9f9f9f",
              fontStyle: "bold",
              beginAtZero: true,
              maxTicksLimit: 5,
              padding: 10,
              steps: 10,
              stepValue: 5,
              max: <?=ceil(max($array_table_row))?>
            },
            gridLines: {
              zeroLineColor: "transparent",
              display: false,
              drawBorder: false,
              color: '#9f9f9f',
            }

          }],
          xAxes: [{
            stacked: true,
            barPercentage: 0.9,
            barThickness: 6,  // number (pixels) or 'flex'
            maxBarThickness: 6, // number (pixels)
            gridLines: {
              zeroLineColor: "white",
              display: false,

              drawBorder: false,
              color: 'transparent',
            },
            ticks: {
              padding: 10,
              fontColor: "#9f9f9f",
              fontStyle: "bold"
            }
          }]
        }
      }
    });
    </script> 
    <script>
        $(document).ready(function(){
            Chart.pluginService.register({
            beforeDraw: function(chart) {
                if (chart.config.options.elements.center) {
                //Get ctx from string
                var ctx = chart.chart.ctx;

                //Get options from the center object in options
                var centerConfig = chart.config.options.elements.center;
                var fontStyle = centerConfig.fontStyle || 'Arial';
                var txt = centerConfig.text;
                var color = centerConfig.color || '#000';
                var sidePadding = centerConfig.sidePadding || 20;
                var sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 2)
                //Start with a base font of 30px
                ctx.font = "30px " + fontStyle;

                //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
                var stringWidth = ctx.measureText(txt).width;
                var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

                // Find out how much the font can grow in width.
                var widthRatio = elementWidth / stringWidth;
                var newFontSize = Math.floor(30 * widthRatio);
                var elementHeight = (chart.innerRadius * 2);

                // Pick a new font size so it will not be larger than the height of label.
                var fontSizeToUse = Math.min(newFontSize, elementHeight);

                //Set font settings to draw it correctly.
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
                var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
                ctx.font = fontSizeToUse + "px " + fontStyle;
                ctx.fillStyle = color;

                //Draw text in center
                ctx.fillText(txt, centerX, centerY);
                }
            }
            });
            ctx = document.getElementById('chartDB').getContext("2d");

            myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Size DB'],
                datasets: [{
                label: "BAIS DB",
                pointRadius: 0,
                pointHoverRadius: 0,
                backgroundColor: ['rgba(52, 152, 219, 1)', 'rgba(26, 188, 156, 1)', 'rgba(241, 196, 15, 1)','rgba(248, 196, 113, 1)','rgba(247, 220, 111, 0.5)'],
                borderWidth: 0,
                data: [<?=$DBsize?>]
                }]
            },
            options: {
                elements: {
                center: {
                    text: '<?=$DBsize?> MB',
                    color: '#66615c', // Default is #000000
                    fontStyle: 'Arial', // Default is Arial
                    sidePadding: 60 // Defualt is 20 (as a percentage)
                }
                },
                cutoutPercentage: 80,
                legend: {

                display: false
                },

                tooltips: {
                enabled: true
                },

                scales: {
                yAxes: [{

                    ticks: {
                    display: false
                    },
                    gridLines: {
                    drawBorder: true,
                    zeroLineColor: "transparent",
                    color: 'rgba(255,255,255,0.05)'
                    }

                }],

                xAxes: [{
                    barPercentage: 1.6,
                    gridLines: {
                    drawBorder: false,
                    color: 'rgba(255,255,255,0.1)',
                    zeroLineColor: "transparent"
                    },
                    ticks: {
                    display: false,
                    }
                }]
                },
            }
            });
        })
    </script>
    <!-- user -->
    <script>
    // CHARTS
    chartColor = "#FFFFFF";
    
    ctx = document.getElementById('chartUser').getContext("2d");

    gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#80b6f4');
    gradientStroke.addColorStop(1, chartColor);

    gradientFill = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill.addColorStop(0, "rgba(52, 152, 219, 1)");
    gradientFill.addColorStop(1, "rgba(52, 152, 219, 0.3)");

    gradientFill2 = ctx.createLinearGradient(0, 50, 1, 150);
    gradientFill2.addColorStop(0, "rgba(255, 199, 51, 0.5)");
    gradientFill2.addColorStop(1, "rgba(255, 199, 51, 0.0)");

    gradientFill3 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill3.addColorStop(0, "rgba(241, 196, 15, 1)");
    gradientFill3.addColorStop(1, "rgba(241, 196, 15, 0.5)");


    gradientFill4 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill4.addColorStop(0, "rgba(248, 196, 113, 1)");
    gradientFill4.addColorStop(1, "rgba(248, 196, 113, 0.5)");

    gradientFill5 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill5.addColorStop(0, "rgba(247, 220, 111, 1)");
    gradientFill5.addColorStop(1, "rgba(247, 220, 111, 0.5)");

    myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [
            <?php
                $index = 1;
                $total = count($array_jam);
                // echo $total;
                foreach($array_jam AS $jam){
                    echo "'".$jam."'" ;
                    if($index < $total){
                        echo ",";
                    }
                    $index++;
                }
            ?>
        ],
        datasets: [
          {
            label: "Size",
            yAxisID: 'A',
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [ 
                <?php
                    $index = 0;
                    $total = count($array_table_size);
                    foreach($array_table_size AS $sizeMB){
                        echo $sizeMB ;
                        if($index < $total){
                            echo ",";
                        }
                        $index++;
                    }
                ?>
            ],
          },
        ]
      },
      options: {
        
        tooltips: {
          tooltipFillColor: "rgba(0,0,0,0.5)",
          tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
          tooltipFontSize: 14,
          tooltipFontStyle: "normal",
          tooltipFontColor: "#fff",
          tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
          tooltipTitleFontSize: 14,
          tooltipTitleFontStyle: "bold",
          tooltipTitleFontColor: "#fff",
          tooltipYPadding: 6,
          tooltipXPadding: 6,
          tooltipCaretSize: 8,
          tooltipCornerRadius: 6,
          tooltipXOffset: 10,
        },


        legend: {

          display: false
        },
        scales: {

          yAxes: [{
            id: 'A',
            position: 'left',
            stacked: true,
            ticks: {
              fontColor: "#9f9f9f",
              fontStyle: "bold",
              beginAtZero: true,
              maxTicksLimit: 5,
              padding: 10,
              steps: 10,
              stepValue: 5,
              max: <?=ceil(max($array_table_size))?>
            },
            gridLines: {
              zeroLineColor: "transparent",
              display: false,
              drawBorder: false,
              color: '#9f9f9f',
            }

          }],
          xAxes: [{
            stacked: true,
            barPercentage: 0.9,
            barThickness: 6,  // number (pixels) or 'flex'
            maxBarThickness: 6, // number (pixels)
            gridLines: {
              zeroLineColor: "white",
              display: false,

              drawBorder: false,
              color: 'transparent',
            },
            ticks: {
              padding: 10,
              fontColor: "#9f9f9f",
              fontStyle: "bold"
            }
          }]
        }
      }
    });
    </script> 
    <?php
    include_once("../endbody.php"); 
}else{
    header('location:../../auth/login.php');
}
   
    

  

?>