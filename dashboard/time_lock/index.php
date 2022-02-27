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
        <div class="row">
            <div class="col-md-12">
                <div class="card card-plain">
                    <div class="card-body">
                        <div class="jam_analog_malasngoding">
                            <div class="xxx">
                                <div class="jarum jarum_detik"></div>
                                <div class="jarum jarum_menit"></div>
                                <div class="jarum jarum_jam"></div>
                                <div class="lingkaran_tengah"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12 " >
                <div class="card" >
                    <div class="card-body ">
                        <center>
                            <h5 style="font-size: 50px; font-family: arial;" id="jam"></h5>
                        </center>
                        <?php
                        
                        ?>
                        <h6 class="title text-uppercase">Tambah Pengaturan</h6>
                        <form action="" method="POST">
                            <div class="form-group">
                                <input name="nama" id="nama_skema" required type="text" class="form-control text-uppercase"  autocomplete="off" placeholder="nama" >
                            </div>
                            <div class="form-group">
                                <input name="start" type="text" id="start_skema" required class="form-control datepicker" placeholder="start off"  autocomplete="off" data-date-format="HH:mm:ss">
                            </div>
                            <div class="form-group">
                                <input  name="end" type="text" id="end_skema" required class="form-control datepicker" placeholder="end off"  autocomplete="off" data-date-format="HH:mm:ss">
                            </div>
                            <div class="form-group">
                                <!-- <input type="text" class="form-control datepicker" placeholder="end off" data-date-format="HH:mm:ss"> -->
                                <select name="type" id="type_skema" class="form-control text-uppercase" id="">
                                    <option value="">Type</option>
                                    <option value="ot">overtime</option>
                                    <option value="at">attendance</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <!-- <input type="text" class="form-control datepicker" placeholder="end off" data-date-format="HH:mm:ss"> -->
                                <select name="period" id="period_skema" class="form-control text-uppercase" id="">
                                    <option value="">Period</option>
                                    <option value="y">year</option>
                                    <option value="d">day</option>
                                </select>
                            </div>
                            <input  class="btn btn-sm btn-primary" name="add" id="add_setting" type="submit" value="tambah data">
                            <button  class="btn btn-sm btn-warning" type="reset" >Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
    <div class="col-md-8" id="view_setting">
        
    </div>
    
    
</div>


			
			
<?php
//footer
		include_once("../footer.php");
        ?>
        
<script>
    $(document).ready(function(){
    $('.datepicker').datetimepicker();

    })
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
    
    <script>
        $(document).ready(function(){

            
            function view_setting(){
                $.ajax({
                    url:"view_setting.php",
                    method:"GET",
                    data:{},
                    success:function(data){
                        $('#view_setting').fadeOut('fast', function(){
                            $(this).html(data).fadeIn('fast');
                        });
                    }
                })
            }
            view_setting()
            function add_data(){
                var add = "1";
                var nama = $('#nama_skema').val();
                var start = $('#start_skema').val();
                var end = $('#end_skema').val();
                var type = $('#type_skema').val();
                var period = $('#period_skema').val();
                if(nama == '' || start == '' || end == '' || type == '' || period == ''){
                    Swal.fire({
                        title: 'Data Belum Lengkap',
                        text: "isi seluruh data seting terlebih dahulu !",
                        timer: 2000,
                        
                        icon: 'warning',
                        showCancelButton: false,
                        showConfirmButton: false,
                        confirmButtonColor: '#00B9FF',
                        cancelButtonColor: '#B2BABB',
                        
                    })
                }else{
                    $.ajax({
                        url:"tambah_setting.php",
                        method:"POST",
                        data:{add:add,nama:nama,start:start,end:end,type:type,period:period},
                        success:function(data){
                            view_setting()
                            Swal.fire({
                                title: 'Suksess',
                                text: "seting sudah ditambahkan",
                                timer: 2000,
                                
                                icon: 'success',
                                showCancelButton: false,
                                showConfirmButton: false,
                                confirmButtonColor: '#00B9FF',
                                cancelButtonColor: '#B2BABB',
                                
                            })
                            // console.log(add);
                        }
                    })
                }
                
            }
            $(document).on('click', '#add_setting', function(a){
                a.preventDefault();
                add_data();
            })
            function update_sm(){
                var data = $('#status_sm').val()
                console.log(data)
                $.ajax({
                    url:"proses.php",
                    method:"GET",
                    data:{data_sm:data},
                    success:function(data){
                        view_setting()
                    }
                })
            }
            $(document).on('click', '#status_sm', function(){
                update_sm();
            })
            function update_daily(){
                var form = $('#form_daily');
                $.ajax({
                    url:"proses.php",
                    method:"GET",
                    data: form.serialize(),
                    success:function(data){
                        view_setting()
                        // console.log(data);
                    }
                })
            }
            function update_yearly(){
                var form = $('#yearly_update');
                $.ajax({
                    url:"proses.php",
                    method:"GET",
                    data: form.serialize(),
                    success:function(data){
                        view_setting()
                        // console.log(data);
                    }
                })
            }
            $(document).on('click', "#update_daily", function(){
                update_daily()
            })
            $(document).on('click', "#update_yearly", function(){
                update_yearly()
            })
            
        })
        

        
    </script>
        <?php
		include_once("../endbody.php");

} else{
		echo "<script>window.location='".base_url('auth/login.php')."';</script>";
	}
	

?>