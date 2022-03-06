<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
include("../../config/approval_system.php"); 

//redirect ke halaman dashboard index jika sudah ada session
$halaman = "My Profile";
if(isset($_SESSION['user'])){
	if(isset($_GET['profile'])){
		$npkUser = ($_GET['profile'] == 'me')?$npkUser:$_GET['profile'];
	}
		include("../header.php");
		$date = date('Y-m-d');
		$startDate = date('Y-m-01', strtotime($date));
		$endDate = date('Y-m-t', strtotime($date));
		// echo $data_value."<br>";
		// echo $npkUser;
		$npk_user = $npkUser;
		$sql_profile = mysqli_query($link, "SELECT * FROM view_organization
		WHERE npk = '$npk_user'")or die(mysqli_error($link));

		$data_profile = mysqli_fetch_assoc($sql_profile);
		// jabatan
		$query_jabatan = mysqli_query($link, "SELECT * FROM jabatan WHERE id_jabatan = '$data_profile[jabatan]' ")or die(mysqli_error($link));
		$data_jab = mysqli_fetch_assoc($query_jabatan);

		$nick_query = mysqli_query($link, "SELECT nama_depan FROM karyawan WHERE npk = '$data_profile[npk]'")or die(mysqli_error($link));
		$data_nick = mysqli_fetch_assoc($nick_query);
		$panggilan = ($data_nick['nama_depan'] === '')?$data_nick['nama_depan']:nick($data_profile['nama']);


		$query_akun = mysqli_query($link, "SELECT * FROM view_user WHERE npk = '$data_profile[npk]' ")or die(mysqli_error($link));
		$data_akun = mysqli_fetch_assoc($query_akun);

		$user_levQuery = mysqli_query($link, "SELECT role_name FROM user_role WHERE id_role = '$data_akun[level_user]' ")or die(mysqli_error($link));
		$data_userLevel = mysqli_fetch_assoc($user_levQuery);

?>
<div class="row ">
	<div class="col-md-4" id="sticker" >
		<div class="card card-user " id="">
			<div class="image">
				<img src="../../assets/img/bg/damir-bosnjak.jpg" alt="...">
			</div>
			<div class="card-body">
				<div class="author">
					<a href="#">
						<img class="avatar border-gray" src="<?=$base64?>" alt="...">
						<h5 class="title text-uppercase"><?=$data_profile['nama']?></h5>
					</a>
					<p class="description">
						<?=$data_jab['jabatan']?>
					</p>
				</div>
			</div>
			<div class="card-footer">
				<hr>
				<div class="button-container">
					<div class="row">
						<?php
						$query_absen = mysqli_query($link, "SELECT check_in , check_out FROM absensi WHERE npk = '$npk_user' AND `date` = '$date' ")or die(mysqli_error($link));
						$data_absen = mysqli_fetch_assoc($query_absen);
						// echo mysqli_num_rows($query_absen);
						$ci = (isset($data_absen['check_in']))?$data_absen['check_in']:"";
						$co = (isset($data_absen['check_out']))?$data_absen['check_out']:"";
						$check_in = ($ci == "00:00:00")?"-":jam($ci);
						$check_out = ($co == "00:00:00")?"-":jam($co);
						?>
						<div class="col-lg-6 d-none col-sm-12 col-md-6 ml-auto mr-auto">
							<h5><?=$check_in?><br><small>Check In</small></h5>
						</div>
						<div class="col-lg-6 d-none  col-sm-12 col-md-6  ml-auto mr-auto">
							<h5><?=$check_out?><br><small>Check Out</small></h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card d-none">
			<div class="card-body">
				<h5 class="text-uppercase">Sisa Cuti Tahunan</h5>
				<p class="description">
					- Hari
				</p>
			</div>
		</div>
		<div class="card d-none">
			<div class="card-body">
				<h5 class="text-uppercase">Sisa Cuti panjang</h5>
				<p class="description">
					- Hari
				</p>
			</div>
		</div>
		
		<div class="row">
            <div class="col-md-12" id="form_account">
                
            </div>
        </div>
		
	</div>
	<div class="col-md-8">
		
		<div class="card">
			<div class="card-header">
				<h5 class="title">Profile Karyawan</h5>
			</div>
			<div class="card-body">
			
				<form>
				<div class="card card-plain">
				<h6 class="title">Organization</h6>
					<div class="row">
						<div class="col-md-4 pr-1">
							<div class="form-group">
								<label>Division</label>
								<input type="hidden" id="data_npk" class="form-control" disabled="true" value="<?=$npkUser?>">
								<input type="text" class="form-control" disabled="true" value="<?=$data_profile['division']?>">
							</div>
						</div>
						<div class="col-md-4 px-1">
							<div class="form-group">
								<label>Department Account</label>
								<input type="text" class="form-control" disabled="true" placeholder="Body 2" value="<?=$data_profile['dept_account']?>">
							</div>
						</div>
						<div class="col-md-4 pl-1">
							<div class="form-group">
								<label for="exampleInputEmail1">Department</label>
								<input type="text" class="form-control" disabled="true"  value="<?=$data_profile['dept']?>">
							</div>
						</div>
						<div class="col-md-3 pr-1">
							<div class="form-group">
								<label>Section</label>
								<input type="text" class="form-control" disabled="true" value="<?=$data_profile['section']?>">
							</div>
						</div>
						<div class="col-md-3 px-1">
							<div class="form-group">
								<label>Group</label>
								<input type="text" class="form-control" disabled="true" placeholder="Body 2" value="<?=$data_profile['groupfrm']?>">
							</div>
						</div>
						<div class="col-md-3 px-1">
							<div class="form-group">
								<label for="exampleInputEmail1">Pos Kerja</label>
								<input type="text" class="form-control" disabled="true"  value="<?=$data_profile['pos']?>">
							</div>
						</div>
						<div class="col-md-3 pl-1">
							<div class="form-group">
								<label for="exampleInputEmail1">Shift</label>
								<input type="text" class="form-control" id="d_shift" disabled="true"  value="<?=$data_profile['shift']?>">
							</div>
						</div>
					</div>
				</div>
				<div class="card card-plain">
					<h6 class="title">Personal Data</h6>
					<div class="row">
					
						<div class="col-md-6 pr-1">
							<div class="form-group">
								<label>Nama Lengkap</label>
								<input type="text" disabled class="form-control" placeholder="Company" name="nama_profile" value="<?=$data_profile['nama']?>">
							</div>
						</div>
						<div class="col-md-6 pl-1">
							<div class="form-group">
								<label>Nama Panggilan</label>
								<input type="text" disabled class="form-control" placeholder="Nama Panggilan" value="<?=$panggilan?>">
							</div>
						</div>
						<div class="col-md-4 pr-1">
							<div class="form-group">
								<label>Status Karyawan</label>
								<input type="text" disabled class="form-control" placeholder="Company" name="nama_profile" value="<?=$data_profile['status']?>">
							</div>
						</div>
						<div class="col-md-4 px-1 ">
							<div class="form-group">
								<label>Tanggal Masuk</label>
								<input type="text" disabled class="form-control" placeholder="Nama Panggilan" value="<?=tgl_indo($data_profile['tgl_masuk'])?>">
							</div>
						</div>
						<div class="col-md-4 pl-1">
							<div class="form-group">
								<label>Masa Kerja</label>
								<input type="text" disabled class="form-control" placeholder="Company" name="nama_profile" value="<?=$data_profile['nama']?>">
							</div>
						</div>
						
						
					</div>
					<div class="row d-none" >
						<div class="col-md-6">
						<label>Tanggal Lahir</label>
							<div class="form-group">
								<input type="text" class="form-control datepicker" placeholder="">
							</div>
						</div>
						<div class="col-md-6">
						<label>No Telp / HP</label>
							<div class="input-group">
								
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1">+62</span>
								</div>
								<input type="number" class="form-control" placeholder="8788344xxxx">
							</div>
						</div>
					</div>
					<!-- <div class="row">
						<div class="col-md-4 pr-1">
							<div class="form-group">
								<label>Provinsi</label>
								<input type="text" class="form-control" placeholder="City" value="DKI Jakarta">
							</div>
						</div>
						<div class="col-md-4 px-1">
							<div class="form-group">
								<label>Kota</label>
								<input type="text" class="form-control" placeholder="Country" value="Australia">
							</div>
						</div>
						<div class="col-md-4 pl-1">
							<div class="form-group">
								<label>Kecamatan</label>
								<select type="number" class="form-control" placeholder="ZIP Code">
									
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Kelurahan / Blok</label>
								<textarea rows="4" cols="80" class="form-control textarea">Jl Swasembada Barat XVII</textarea>
							</div>
						</div>
					</div> -->

					<div class="row d-none">
						<div class="col-md-12">
							<div class="form-group">
								<label>Alamat Domisili</label>
								<textarea rows="4" cols="80" class="form-control textarea"></textarea>
							</div>
						</div>
					</div>
					<div class="row d-none">
						<div class="col-md-12 text-right">
							<div class="btn btn-sm btn-primary">update</div>

						</div>

					</div>
				</div>
				</form>
			</div>
		</div>
		<div class="row" id="sumary">
			
		</div>
		<div class="row">
			<div class="col-md-12 " >
				<div class="card " id="contoh2">
					<div class="card-header ">
						<h5 class="card-title">Monitoring Absensi</h5>
						<p class="card-category"></p>
					</div>
					<div class="card-body " >
						<div class="row">
							<div class="col-md-12">
								<div class="input-group no-border">
									<input type="date" class="form-control" name="start_date" id="start_date" value="<?=$startDate?>">
									<label for="" class="form-control text-center col-md-1">to</label>
									<input type="date" class="form-control form-col-4" name="end_date" id="end_date" value="<?=$endDate?>">
									<div class="input-group-append ">
										<span id="filterGo" class="btn btn-sm input-group-text text-sm px-2 py-0 m-0">go</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12" id="data-administratif"></div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<div class="info_"></div>

			
			
<?php
//footer
	include_once("../footer.php");
	?>
<script>
	
	$(document).ready(function(){
		$(document).on('click', '#filterGo', function(){
			dataAbsen()
			dataSumary();
		})
		dataAbsen()
		function dataAbsen(){
			var id = 'data-absen';
			var shift = $('#d_shift').val();
			var npk = $('#data_npk').val();
			var start = $('#start_date').val();
			var end = $('#end_date').val();
			$.ajax({
				url:"data-administratif.php",
				method:"GET",
				data:{shift:shift,id:id,npk:npk,start:start,end:end},
				success:function(data){
					$('#data-administratif').fadeOut('fast', function(){
						$(this).html(data).fadeIn('fast');
					});
				}
			})
		}
		dataSumary();
		function dataSumary(){
			var id = 'sumary';
			var shift = $('#d_shift').val();
			var npk = $('#data_npk').val();
			var start = $('#start_date').val();
			var end = $('#end_date').val();
			$.ajax({
				url:"data-administratif.php",
				method:"GET",
				data:{shift:shift,id:id,npk:npk,start:start,end:end},
				success:function(data){
					$('#sumary').fadeOut('fast', function(){
						$(this).html(data).fadeIn('fast');
					});
				}
			})
		}
		formAccount();
		function formAccount(){
			var npk = $('#data_npk').val();
			$.ajax({
				url:"form-account.php",
				method:"GET",
				data:{npk:npk},
				success:function(data){
					$('#form_account').fadeOut('fast', function(){
						$(this).html(data).fadeIn('fast');
					});
				}
			})
		}
		function submitAccount(submit){
			var old_pass = $('#old_pass').val()
			var new_pass = $('#new_pass').val()
			var update = $('#new_pass').val()
			var npk = $('#data_npk').val();
			if(old_pass == ''|| new_pass == ''){
				success('Data Kosong','Pastikan Semua Form telah diisi','')
			}else{
				// console.log(old_pass)
				$.ajax({
				url:"proses.php",
				method:"GET",
				data:{submit:submit,old_pass:old_pass,new_pass:new_pass,npk:npk},
				success:function(data){
					$('.info_').html(data);
				}
			})
			}
		}
		function success(data1,data2,icon){
            Swal.fire({
                title: data1,
                text: data2,
                timer: 2000,
                
                icon: icon,
                showCancelButton: false,
                showConfirmButton: false,
                confirmButtonColor: '#00B9FF',
                cancelButtonColor: '#B2BABB',
            })
        }
		$(document).on('click', '#submit_account', function(a){
			a.preventDefault();
			var data = $(this).attr('id');
			submitAccount(data)
		})
	})
</script>

<?php
	include_once("../endbody.php");


} else{
		echo "<script>window.location='".base_url('auth/login.php')."';</script>";
	}
	

?>