<style type="text/css">
 
	
 
	.jam_analog_malasngoding {
		background: #e7f2f7;
		position: relative;
		width: 240px;
		height: 240px;
		border: 16px solid #52b6f0;
		border-radius: 50%;
		padding: 20px;
		margin:20px auto;
	}
 
	.xxx {
		height: 100%;
		width: 100%;
		position: relative;
	}
 
	.jarum {
		position: absolute;
		width: 50%;
		background: #232323;
		top: 50%;
		transform: rotate(90deg);
		transform-origin: 100%;
		transition: all 0.05s cubic-bezier(0.1, 2.7, 0.58, 1);
	}
 
	.lingkaran_tengah {
		width: 24px;
		height: 24px;
		background: #232323;
		border: 4px solid #52b6f0;
		position: absolute;
		top: 50%;
		left: 50%;
		margin-left: -14px;
		margin-top: -14px;
		border-radius: 50%;
	}
 
	.jarum_detik {
		height: 2px;
		border-radius: 1px;
		background: #F0C952;
	}
 
	.jarum_menit {
		height: 4px;
		border-radius: 4px;
	}
 
	.jarum_jam {
		height: 8px;
		border-radius: 4px;
		width: 35%;
		left: 15%;
	}
</style>
<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 

//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Time Lock Management";
if(isset($_SESSION['user'])){

		include("../header.php");
        $query = "SELECT * FROM system_lock";
        $ot_lock = " WHERE type = 'ot' ";
        $at_lock = " WHERE type = 'at' ";
        $s_lock = " WHERE type = 'sm' ";
        $period_d = " AND periodic = 'd' ";
        $period_y = " AND periodic = 'y' ";

        $daily_ot = mysqli_query($link,$query.$ot_lock.$period_d)or die(mysqli_error($link));
        $daily_at = mysqli_query($link,$query.$at_lock.$period_d)or die(mysqli_error($link));
        $y_ot = mysqli_query($link,$query.$ot_lock.$period_y)or die(mysqli_error($link));
        $y_at = mysqli_query($link,$query.$at_lock.$period_y)or die(mysqli_error($link));
        $sm = mysqli_query($link,$query.$at_lock.$period_y)or die(mysqli_error($link));
		

?>

<div class="row ">
    <div class="col-md-4 ">  
        <div class="jam_analog_malasngoding">
            <div class="xxx">
                <div class="jarum jarum_detik"></div>
                <div class="jarum jarum_menit"></div>
                <div class="jarum jarum_jam"></div>
                <div class="lingkaran_tengah"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <center>
                            <h5 style="font-size: 50px; font-family: arial;" id="jam"></h5>
                        </center>
                        <h6 class="title text-uppercase">Tambah Pengaturan</h6>
                        <form action="">
                            <div class="form-group">
                                <input type="text" class="form-control " placeholder="nama" >
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control datepicker" placeholder="start off" data-date-format="HH:mm:ss">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control datepicker" placeholder="end off" data-date-format="HH:mm:ss">
                            </div>
                            <div class="form-group">
                                <!-- <input type="text" class="form-control datepicker" placeholder="end off" data-date-format="HH:mm:ss"> -->
                                <select name="" class="form-control" id="">
                                    <option value="">Type</option>
                                    <option value="">overtime</option>
                                    <option value="">attendance</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <!-- <input type="text" class="form-control datepicker" placeholder="end off" data-date-format="HH:mm:ss"> -->
                                <select name="" class="form-control" id="">
                                    <option value="">Period</option>
                                    <option value="">year</option>
                                    <option value="">day</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn btn-sm btn-primary">tambah data</div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6  my-0 py-2">
                                <h5 class="title ">
                                    System Maintenance
                                </h5>
                                <p class="category">System off</p>

                            </div>
                            <div class="col-md-6 text-right my-0 py-2">
                            <?php
                            if(mysqli_num_rows($sm)>0){
                                $data_sm = mysqli_fetch_assoc($sm);
                                $active = $data_sm['status'];
                                $checked = ($data_sm['status'] == 1)?"checked":'';
                                ?>
                                <input class="bootstrap-switch " type="checkbox" data-toggle="switch" name="status_sm" <?=$checked?> value="<?=$active?>" data-on-color="warning" data-off-color="warning" data-on-label="ON" data-off-label="OFF">
                                <?php
                            }
                            ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6  my-0 py-2">
                                <h5 class="title ">
                                    Daily Lock System
                                </h5>
                                <p class="category">System off</p>
    
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="btn btn-sm btn-success">Update</div>
                            </div>

                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <form method="get" action="/" class="form-horizontal">
                        <?php
                            if(mysqli_num_rows($daily_ot)>0){
                                
                                ?>
                                <div class="table-full-width text-uppercase">
                                    <table class="table-sm text-nowrap text-truncate" width="100%">
                                        <thead>
                                            <tr class="py-1">
                                                <th></th>
                                                    <th >Scheme</th>
                                                    <th >Start</th>
                                                    <th >End</th>
                                                    <th colspan="2">Type</th>
                                                <th ></th>
                                            </tr>
                                            
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            while($data = mysqli_fetch_assoc($daily_ot)){
                                                $type = ($data['type'] == 'ot')?'overtime':(($data['type'] == 'at')?'attendance':'system');
                                                ?>
                                                <tr>
                                                    <td>#<?=$no++?></td>
                                                    <td><?=$data['system_name']?></td>
                                                    
                                                    <td>
                                                        <div class="form-group-sm" auto-complete="off">
                                                            <input type="text" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="hh:mm:ss" value="<?=$data['off_start']?>">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group-sm" auto-complete="off">
                                                            <input type="text" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="hh:mm:ss" value="<?=$data['off_end']?>">
                                                        </div>
                                                    </td>
                                                    <td>
                                                    <?=$type?>
                                                    </td>
                                                    
                                                    <td>
                                                        <?php
                                                        
                                                        $active = $data['status'];
                                                        $checked = ($data['status'] == 1)?"checked":'';
                                                        ?>
                                                        <input class="bootstrap-switch " type="checkbox" data-toggle="switch" name="status_sm" <?=$checked?> value="<?=$active?>" data-on-color="warning" data-off-color="warning" data-on-label="ON" data-off-label="OFF">
                                                        
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            $no = 1;
                                            while($data = mysqli_fetch_assoc($daily_at)){
                                                $type = ($data['type'] == 'ot')?'overtime':(($data['type'] == 'at')?'attendance':'system');
                                                ?>
                                                <tr>
                                                    <td>#<?=$no++?></td>
                                                    <td><?=$data['system_name']?></td>
                                                    
                                                    <td>
                                                        <div class="form-group-sm" auto-complete="off">
                                                            <input type="text" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="hh:mm:ss" value="<?=$data['off_start']?>">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group-sm" auto-complete="off">
                                                            <input type="text" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="hh:mm:ss" value="<?=$data['off_end']?>">
                                                        </div>
                                                    </td>
                                                    <td>
                                                    <?=$type?>
                                                    </td>
                                                    
                                                    <td>
                                                        <?php
                                                            
                                                        $active = $data['status'];
                                                        $checked = ($data['status'] == 1)?"checked":'';
                                                        ?>
                                                        <input class="bootstrap-switch " type="checkbox" data-toggle="switch" name="status_sm" <?=$checked?> value="<?=$active?>" data-on-color="warning" data-off-color="warning" data-on-label="ON" data-off-label="OFF">
                                                        
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                            }
                            ?>
                                
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6  my-0 py-2">
                                <h5 class="title ">
                                    End Year Close Lock System
                                </h5>
                                <p class="category">System off</p>

                            </div>
                            <div class="col-md-6 text-right">
                                <div class="btn btn-sm btn-success">Update</div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <form method="get" action="/" class="form-horizontal">
                        <?php
                            if(mysqli_num_rows($daily_ot)>0){
                                
                                ?>
                                <div class="table-full-width text-uppercase">
                                    <table class="table-sm text-nowrap text-truncate" width="100%">
                                        <thead>
                                            <tr class="py-1">
                                                <th></th>
                                                    <th >Scheme</th>
                                                    <th >Start</th>
                                                    <th >End</th>
                                                    <th colspan="2">Type</th>
                                                <th ></th>
                                            </tr>
                                            
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            while($data = mysqli_fetch_assoc($y_ot)){
                                                $type = ($data['type'] == 'ot')?'overtime':(($data['type'] == 'at')?'attendance':'system');
                                                ?>
                                                <tr>
                                                    <td>#<?=$no++?></td>
                                                    <td><?=$data['system_name']?></td>
                                                    
                                                    <td>
                                                        <div class="form-group-sm" auto-complete="off">
                                                            <input type="text" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="HH:mm:ss" value="<?=$data['off_start']?>">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group-sm" auto-complete="off">
                                                            <input type="text" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="HH:mm:ss" value="<?=$data['off_end']?>">
                                                        </div>
                                                    </td>
                                                    <td>
                                                    <?=$type?>
                                                    </td>
                                                    
                                                    <td>
                                                        <?php
                                                            
                                                        $active = $data['status'];
                                                        $checked = ($data['status'] == 1)?"checked":'';
                                                        ?>
                                                        <input class="bootstrap-switch " type="checkbox" data-toggle="switch" name="status_sm" <?=$checked?> value="<?=$active?>" data-on-color="warning" data-off-color="warning" data-on-label="ON" data-off-label="OFF">
                                                        
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            $no = 1;
                                            while($data = mysqli_fetch_assoc($y_at)){
                                                $type = ($data['type'] == 'ot')?'overtime':(($data['type'] == 'at')?'attendance':'system');
                                                ?>
                                                <tr>
                                                    <td>#<?=$no++?></td>
                                                    <td><?=$data['system_name']?></td>
                                                    
                                                    <td>
                                                        <div class="form-group-sm" auto-complete="off">
                                                            <input type="text" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="HH:mm:ss" value="<?=$data['off_start']?>">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group-sm" auto-complete="off">
                                                            <input type="text" class="form-control datepicker border-0 bg-transparent px-0" data-date-format="HH:mm:ss" value="<?=$data['off_end']?>">
                                                        </div>
                                                    </td>
                                                    <td>
                                                    <?=$type?>
                                                    </td>
                                                    
                                                    <td>
                                                        <?php
                                                        
                                                        $active = $data['status'];
                                                        $checked = ($data['status'] == 1)?"checked":'';
                                                        ?>
                                                        <input class="bootstrap-switch " type="checkbox" data-toggle="switch" name="status_sm" <?=$checked?> value="<?=$active?>" data-on-color="warning" data-off-color="warning" data-on-label="ON" data-off-label="OFF">
                                                    
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                            }
                            ?>
                                
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
</div>


			
			
<?php
//footer
		include_once("../footer.php");
        ?>
        <script>
        $(document).ready(function(){
            // 
            function load_monitor(){
                var date = $('#date_').val()
                var dept = $('#show_dept').val()
                var shift = $('#shift').val()
                var get_group = $('#data_total').text();
                console.log(get_group)
                $.ajax({
                    url: 'chart_view/index.php',
                    method: 'GET',
                    data: {index:get_group,monitor_date:date,dept_account:dept,shift:shift},
                    success:function(data){
                        $('#data-monitor').fadeOut('fast', function(){
                            $(this).html(data).fadeIn('fast');
                        });
                    }
                })
            }
            load_monitor()
            $('#date_').on('blur', function(){
                load_monitor()
            })
            $('#show_dept').on('change', function(){
                load_monitor()
            })
            $('#shift').on('change', function(){
                load_monitor()
                
            })
            
            var autoRefresh;
            // window.onload = resetTimer;
            window.onmousemove = resetTimeInterval;
            window.onmousedown = resetTimeInterval; // catches touchscreen presses
            window.onclick = resetTimeInterval;     // catches touchpad clicks
            window.onscroll = resetTimeInterval;    // catches scrolling with arrow keys
            window.onkeypress = resetTimeInterval;
    
            // function refresh() {
            //     load_monitor()
            // }
            
            // function resetTimeInterval() {
            //     clearInterval(autoRefresh);
                
            //     autoRefresh = setInterval(refresh, 10000);  // time is in milliseconds
            // }

            
            var link = document.getElementsByClassName('data_load');
            var load = 0;
            var int = 0;
            var total = Number($('#data_total').attr('data-id'));

            function resetTimeInterval(){
                clearInterval(autoRefresh);

                autoRefresh = setInterval(function ()
                    {
                        // console.log(int);
                        // console.log(total);
                        int++;
                        if(int == 10){
                            // console.log("load data"+load);
                            int = 0;
                            load++;
                            $('#data_total').text(load)
                            // load_data();
                            load_monitor()
                        }
                        if(load == total){
                            load = 0;
                        }
                    }, 1000 // refresh every 10000 milliseconds
                );  

                
            }
            
            $(document).on('click', 'td.data-karyawan', function(a){
                a.preventDefault();
                loadModal()
            })
            function loadModal(){
                $('#modal_cico').modal('show');
                var data = $('td.data-karyawan').attr('id');
                // console.log(data)
                    $.ajax({
                        url: 'chart_view/preview.php',
                        method: 'GET',
                        data: {data:data},
                        success:function(data){
                            $('.modal-body').html(data);
                        }
                    
                });
            }
            

        })
    </script>
    <script type="text/javascript">
        const secondHand = document.querySelector('.jarum_detik');
        const minuteHand = document.querySelector('.jarum_menit');
        const jarum_jam = document.querySelector('.jarum_jam');
    
        function setDate(){
            const now = new Date();
    
            const seconds = now.getSeconds();
            const secondsDegrees = ((seconds / 60) * 360) + 90;
            secondHand.style.transform = `rotate(${secondsDegrees}deg)`;
            if (secondsDegrees === 90) {
                secondHand.style.transition = 'none';
            } else if (secondsDegrees >= 91) {
                secondHand.style.transition = 'all 0.05s cubic-bezier(0.1, 2.7, 0.58, 1)'
            }
    
            const minutes = now.getMinutes();
            const minutesDegrees = ((minutes / 60) * 360) + 90;
            minuteHand.style.transform = `rotate(${minutesDegrees}deg)`;
    
            const hours = now.getHours();
            const hoursDegrees = ((hours / 12) * 360) + 90;
            jarum_jam.style.transform = `rotate(${hoursDegrees}deg)`;
        }
    
        setInterval(setDate, 1000)
    </script>
    <script type="text/javascript">
         
         jam()
        function jam() {
        var e = document.getElementById('jam'),
        d = new Date(), h, m, s;
        h = d.getHours();
        m = set(d.getMinutes());
        s = set(d.getSeconds());
    
        e.innerHTML = h +':'+ m +':'+ s;
    
        setTimeout('jam()', 1000);
        }
    
        function set(e) {
        e = e < 10 ? '0'+ e : e;
        return e;
        }
    </script>
        <?php
		include_once("../endbody.php");

} else{
		echo "<script>window.location='".base_url('auth/login.php')."';</script>";
	}
	

?>