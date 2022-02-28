<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Attendance Efficiency";
if(isset($_SESSION['user'])){
    $start_date = date('Y-m-1');
    $end_date = date('Y-m-t');
    $start = DBtoForm($start_date);
    $end = DBtoForm($end_date);
    include_once("../header.php");
?>
<div class="row">
    <!-- <div class="col-md-5">  
        <h5 class="title">Department Performance</h5>
    </div> -->
    <div class="col-md-7 ">
        <div class="row">
            <div class="col-md-7">
                <div class="row">
                    <label class="col-md-2 col-form-label text-right">Date :</label>
                    <div class="col-md-5">
                        <div class="form-group-sm pr-1">
                            <input type="text" id="start_date" value="<?=$start?>" class="form-control datepicker" data-date-format="DD/MM/YYYY">
                        </div>
                    </div>
                    <div class="col-md-5 pl-1">
                        <div class="form-group-sm">
                            <input type="text" class="form-control datepicker" id="end_date" value="<?=$end?>" data-date-format="DD/MM/YYYY">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <label class="col-md-3 col-form-label text-right">Shift :</label>
                    <div class="col-md-9">
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
                </div>
            </div>
            <div class="col-md-2 text-right">
                <div class="row ">
                    <div class="nav-link active btn-magnify mt-0"><i class="fas fa-th-list"></i></div>
                    <div class="nav-link text-danger btn-magnify mt-0"><i class="fas fa-th-large"></i></div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class=" row data-eff"></div>
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
                    success:function(data){
                        $('.data-eff').fadeOut('fast', function(){
                            $(this).html(data).fadeIn('fast');
                        });
                    }
                })
            }
            load_data();
            function load_data2(){
                var start = $('#start_date').val()
                var end = $('#end_date').val()
                var shift = $('#shift').val()
                $.ajax({
                    url: 'chart_view/eff-dept.php',
                    method: 'get',
                    data: {start:start,end:end,shift:shift},
                    success:function(data){
                        $('.data-dept-eff').fadeOut('fast', function(){
                            $(this).html(data).fadeIn('fast');
                        });
                        
                    }
                })
            }
            load_data2();
            $(document).on('blur', '#start_date' , function(){
                load_data2();
                load_data();
            })
            $(document).on('blur', '#end_date' , function(){
                load_data2();
                load_data();
                console.log("1")
            })
            $(document).on('change', '#shift' , function(){
                load_data2();
                load_data();
            })
            var autoRefresh;
            // window.onload = resetTimer;
            window.onmousemove = resetTimeInterval;
            window.onmousedown = resetTimeInterval; // catches touchscreen presses
            window.onclick = resetTimeInterval;     // catches touchpad clicks
            window.onscroll = resetTimeInterval;    // catches scrolling with arrow keys
            window.onkeypress = resetTimeInterval;
    
            function refresh() {
                load_data2();
                load_data()
            }
            
            function resetTimeInterval() {
                clearInterval(autoRefresh);
                autoRefresh = setInterval(refresh, 10000);  // time is in milliseconds
            }
            

        })
    </script>
    <!-- dummy -->
    
    <?php
    include_once("../endbody.php"); 

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
  

?>