<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Attendance Efficiency";
if(!isset($_SESSION['user'])){
    $level = 10;
    $npkUser = 0;
}
    $start_date = date('Y-m-1');
    $end_date = date('Y-m-t');
    $start = DBtoForm($start_date);
    $end = DBtoForm($end_date);
    include_once("../header.php");
    
?>
<div class="row">
    <div class="col-md-2">
        <div class="form-group-sm pr-1">
            <select name="show_dept" id="show_dept" class="form-control">
                <option value="deptAcc">Departmen Administratif</option>
            </select>
        </div>
    </div>
    <label class="col-md-1 col-form-label ">Date :</label>
    <div class="col-md-2">
        <div class="form-group-sm px-0">
            <input type="text" id="start_date" value="<?=$start?>" class="form-control datepicker" data-date-format="DD/MM/YYYY">
        </div>
    </div>
    <div class="col-md-2 px-0">
        <div class="form-group-sm">
            <input type="text" class="form-control datepicker" id="end_date" value="<?=$end?>" data-date-format="DD/MM/YYYY">
        </div>
    </div>
    <label class="col-md-1 col-form-label text-right">Shift :</label>
    <div class="col-md-2">
        <div class="form-group-sm pr-1">
            <select name="shift" id="shift" class="form-control">
                <option value="">Pilih Shift</option>
                <?php
                $q_shift = mysqli_query($link, "SELECT * FROM shift ")or die(mysqli_error($link));
                if(mysqli_num_rows($q_shift) > 0){
                    while($data = mysqli_fetch_assoc($q_shift)){
                        ?>
                        <option value="<?=$data['id_shift']?>"><?=$data['shift']?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="col-md-2 text-right">
        <div class="row ">
            <span class=" col-md-6 btn-outline-primary btn-link btn btn-sm btn-primary my-auto mx-2  px-2" id="loadData">load</span>
            <span class=" col-md-2 nav-link active btn-magnify mt-0 mx-0 px-2"><i class="fas fa-th-list"></i></span>
            <span class=" col-md-2 nav-link text-danger btn-magnify mt-0 mx-0 px-2"> <i class="fas fa-th-large"></i></span>
        </div>
    </div>
</div>
<hr class="my-1">
<div class="row">
    <div class="col-md-12 spinner_load " style="display:none">
        <div class="card shadow-none">
            <div class="card-body " style="background-image: linear-gradient(to right, rgb(244,243,239) , rgb(255,255,255) , rgb(244,243,239));">
                <div class="text-center" >
                    <img id="img-spinner" src="../../assets/img/loading/load.gif" style="height:50px">
                    <label class="label">please wait downloading resources...</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class=" row data-eff"></div>
<div class="row">
    <div class="col-md-12 spinner_load_eff_dept" >
        <div class="card shadow-none">
            <div class="card-body " style="background-image: linear-gradient(to right, rgb(244,243,239) , rgb(255,255,255) , rgb(244,243,239));">
                <div class=" text-center" style="display:block">
                    <img id="img-spinner" src="../../assets/img/loading/load.gif" style="height:50px">
                    <label class="label">please wait downloading resources...</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row data-dept-eff"></div>
<?php
    include_once("../footer.php");
    ?>

    
    <script>
        $(document).ready(function(){
            function load_data(){
                var start = $('#start_date').val()
                var end = $('#end_date').val()
                var shift = $('#shift').val()
                $.ajax({
                    url: 'chart_view/eff.php',
                    method: 'get',
                    data: {start:start,end:end,shift:shift},
                    beforeSend:function(){$(".spinner_load").css("display","block").fadeIn('slow');},
                    success:function(data){
                       
                        $('.data-eff').fadeOut('slow', function(){
                            $(".spinner_load").css("display","none")
                            $(this).html(data).fadeIn('slow');
                            
                        });
                    }
                })
            }
            <?php
            if(isset($_GET['dept'])){
                ?>
                load_data2();
                <?php
            }else{
                ?>
                load_data();
                <?php
            }
            ?>
            
            function load_data2(){
                var start = $('#start_date').val()
                var end = $('#end_date').val()
                var shift = $('#shift').val()
                $.ajax({
                    url: 'chart_view/eff-dept.php',
                    method: 'get',
                    data: {start:start,end:end,shift:shift},
                    beforeSend:function(){$(".spinner_load_eff_dept").css("display","block").fadeIn('slow');},
                    success:function(data){
                        $('.data-dept-eff').fadeOut('fast', function(){
                            $(".spinner_load_eff_dept").css("display","none")
                            $(this).html(data).fadeIn('fast');
                        });
                        
                    }
                })
            }
            // // load_data2();
            $(document).on('click', '#loadData' , function(){
                <?php
                if(isset($_GET['dept'])){
                    ?>
                    load_data2();
                    <?php
                }else{
                    ?>
                    load_data();
                    <?php
                }
                ?>
            })
            
            var autoRefresh;
            // window.onload = resetTimer;
            window.onmousemove = resetTimeInterval;
            window.onmousedown = resetTimeInterval; // catches touchscreen presses
            window.onclick = resetTimeInterval;     // catches touchpad clicks
            window.onscroll = resetTimeInterval;    // catches scrolling with arrow keys
            window.onkeypress = resetTimeInterval;
    
            function refresh() {
                <?php
                if(isset($_GET['dept'])){
                    ?>
                    load_data2();
                    <?php
                }else{
                    ?>
                    load_data();
                    <?php
                }
                ?>
            }
            
            function resetTimeInterval() {
                clearInterval(autoRefresh);
                autoRefresh = setInterval(refresh, 20000);  // time is in milliseconds
            }
            

        })
    </script>
    <!-- dummy -->
    
    <?php
    include_once("../endbody.php"); 

  

?>