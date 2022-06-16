<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
include("../../config/approval_system.php"); 

//redirect ke halaman dashboard index jika sudah ada session
$halaman = "My Profile";
if(isset($_SESSION['user'])){
	if(isset($_GET['profile'])){
		include("../header.php");
		$npkUser = ($_GET['profile'] == 'me')?$npkUser:$_GET['profile'];
		$base64 = ($_GET['profile'] == 'me')?$base64:getFoto($_GET['profile']);
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
		if($_GET['profile'] != 'me'){
			
			?>
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-danger alert-with-icon alert-dismissible fade show" data-notify="container">
						<button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
							<i class="nc-icon nc-simple-remove"></i>
						</button>
						<span data-notify="icon" class="nc-icon nc-satisfied"></span>
						<span data-notify="message">Anda Bisa Menambahkan dan memperbaharui data profile karyawan</span>
					</div>
				</div>
			</div>
			<?php
		}
		?>
		
		
		<div class="row">
			<div class="modal fade" id="modalProfile" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
				<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header justify-content-center">
						
						<h4 class="title title-up">Ganti Foto Profil</h4>
					</div>
					<div class="modal-body">
						<div class="form-group border rounded py-auto text-center upload-ft d-none">
							<div class="fileinput fileinput-new text-center " data-provides="fileinput" >
								<div class="fileinput-new thumbnail">
									
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail mt-4   mx-0 shadow-none" style="width:300px;min-width:300px">
									<input type="text"  class="form-control mx-0">
								</div>
								<div>
									<span class="btn btn-outline-default btn-round btn-rose btn-file">
									<span class="fileinput-new ">Select Image</span>
									<span class="fileinput-exists">Change</span>
										<input type="file"  name="file_import" id="file_import" accept="image/jpg"/>
									</span>
									<a href="javascript:;" class="btn btn-danger btn-outline-danger btn-icon btn-round btn-rose btn-file fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
								</div>
								<p class="category">pastikan gambar berformat .JPG</p>
							</div>
						</div>
						<div id="my_camera" class="border rounded " >
							<img src="<?=$base64?>" alt="">
						</div>
						<div id="results" class="border rounded d-none">
							
						</div>
						
					</div>
					<div class="modal-footer">
					<div class="row">
						<div class="col-md-12 text-center">
							<!-- <input type="button" class="btn btn-sm btn-warning submit-foto" value="Sumbit Foto"> -->
							<input type="button" class="btn btn-sm btn-warning upload-foto" value="Upload Foto">
							<input type="button" class="btn btn-sm btn-primary load-webcam" value="Gunakan WebCam" onClick="configure()">
							<input type="button" class="btn btn-sm btn-info take-snap d-none" disabled value="Take Snapshot" onClick="take_snapshot()">
							<input type="button" class="btn btn-sm btn-success save-snap d-none" disabled value="Save Snapshot" onClick="saveSnap()">
							<input type="button" class="btn btn-sm btn-danger cancel-upload-foto d-none" value="Cancel">
							<input type="button" class="btn btn-sm btn-danger cancel-load-webcam d-none" value="Cancel">
						</div>
					</div>
					</div>
				</div>
				</div>
			</div>
		</div>
		<div class="row ">
			<div class="col-md-4" id="sticker" >
				<div class="card card-user " id="">
					<div class="image">
						<img src="../../assets/img/bg/damir-bosnjak.jpg" alt="..." >
					</div>
					<div class="card-body">
						<div class="author">
							<a data-toggle="modal" data-target="#modalProfile" >
								<img class="avatar border-gray" src="<?=$base64?>" alt="..." style="background:#0000">
								<h5 class="title text-uppercase"><?=$data_profile['nama']?></h5>
								
							</a>
							<div class="description desc">
								<?=$data_jab['jabatan']?>
							</div>
							<div class="description middle d-none" >
								<i class="nc-icon nc-album-2"></i> Ganti Foto Profile
							</div>
							
						</div>
						
					</div>
					<!-- <div class="card-footer">
						<hr>
						<div class="button-container">
							<div class="row">
								
							</div>
						</div>
					</div> -->
				</div>
				<!-- <div class="card ">
					<div class="card-body">
						<h5 class="text-uppercase">Sisa Cuti Tahunan</h5>
						<p class="description">
							- Hari
						</p>
					</div>
				</div>
				<div class="card ">
					<div class="card-body">
						<h5 class="text-uppercase">Sisa Cuti panjang</h5>
						<p class="description">
							- Hari
						</p>
					</div>
				</div> -->
				
				<div class="row">
					<div class="col-md-12" id="form_account">
						
					</div>
				</div>
				
			</div>
			<div class="col-md-8">
				
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-md-6">
								<h5 class="title">Profile Karyawan</h5>

							</div>
							<div class="col-md-6 text-right">
								<?php
								if($_GET['profile'] != 'me'){
									?>
									<a href="<?=base_url()?>/dashboard/pages/mp_update.php" class="btn btn-default">Kembali</a>
									<?php
								}
								?>
							</div>
						</div>
					</div>
					<div class="card-body">
					
						<form action="proses.php" method="POST">
						<div class="card card-plain">
						<h6 class="title">Organization</h6>
							<div class="row">
								<div class="col-md-4 pr-1">
									<div class="form-group">
										<label>Division</label>
										<input type="hidden" id="data_npk" name="data_npk" class="form-control"  value="<?=$npkUser?>">
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
										<input type="text" class="form-control" disabled="true" value="<?=$data_profile['groupfrm']?>">
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
							<div class="row " >
								<div class="col-md-6">
								<label>Tanggal Lahir</label>
									<div class="form-group">
										<input type="text" name="birth" class="form-control datepicker" data-date-format="DD/MM/YYYY"  value="<?=DBtoForm($data_akun['birth'])?>">
									</div>
								</div>
								<div class="col-md-6">
								<label>No Telp / HP</label>
									<div class="input-group">
										
										<div class="input-group-prepend">
											<span class="input-group-text category" id="basic-addon1">+62</span>
										</div>
										<input type="number" name="handphone" class="form-control" placeholder="8788344xxxx" value="<?=$data_akun['handphone']?>">
									</div>
								</div>
							</div>

							<div class="row ">
								<div class="col-md-12">
									<div class="form-group">
										<label>Alamat Domisili</label>
										<textarea rows="4" cols="80" name="domisili" class="form-control textarea"><?=$data_akun['domisili']?></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 text-right">
									<input type="submit" class="btn btn-sm btn-primary" value="Update">

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
								<h5 class="card-title">Monitoring Absensi & Overtime</h5>
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
				$('.upload-foto').click( function(){
					$('.load-webcam').addClass('d-none')
					$(this).addClass('d-none')
					$('.cancel-upload-foto').removeClass('d-none')
					$('.upload-ft').removeClass('d-none')
					$('#my_camera').addClass('d-none')
					
				})
				$('.load-webcam').on('click', function(){
					
					$('.upload-foto').addClass('d-none')
					$('#my_camera').removeClass('d-none')
					$('#results').addClass('d-none')
					$('.cancel-load-webcam').removeClass('d-none')
					$('.take-snap').prop('disabled', false)
					$('.take-snap').removeClass('d-none')
					$('.save-snap').prop('disabled', true)
					$('.save-snap').addClass('d-none')
				})

				$('.cancel-load-webcam').on('click', function(){
					$(this).addClass('d-none')
					$('.upload-foto').prop('disabled', false)
					$('.upload-foto').removeClass('d-none')
					$('.load-webcam').removeClass('d-none')
					$('.take-snap').prop('disabled', true)
					$('.take-snap').addClass('d-none')
					$('.save-snap').addClass('d-none')
				})
				$('.cancel-upload-foto').on('click', function(){
					$('.load-webcam').removeClass('d-none')
					$('.upload-foto').removeClass('d-none')
					$(this).addClass('d-none')
					$('#my_camera').removeClass('d-none')
					$('.upload-ft').addClass('d-none')
				})
				$('.take-snap').on('click', function(){
					$('#my_camera').addClass('d-none')
					$('#results').removeClass('d-none')
					$('.save-snap').prop('disabled', false)
					$('.save-snap').removeClass('d-none')
					$(this).addClass('d-none')
					
				})
				// $('.submit-foto').click(function(){
				// 	const file_import = $('#file_import').prop('files')[0];
				// 	if($file_import == '' ){

				// 	}else{
				// 		let formData = new FormData();
				// 		formData.append('file_import', file_import);
						
				// 		$.ajax({
				// 			type: 'POST',
				// 			url: "upload/upload.php?ganti_foto=<?=$npk_user?>",
				// 			data: formData,
				// 			cache: false,
				// 			processData: false,
				// 			contentType: false,
				// 			success: function (msg) {
								
				// 				location.reload();
				// 			},
				// 			error: function () {
				// 				alert("Data Gagal Diupload");
				// 			}
				// 		});
				// 	}
					
				// })
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
		<script>
			$(document).ready(function(){
				$('.avatar').mouseenter(function(){
					$('.middle').removeClass('d-none');
					$('.desc').addClass('d-none');
				})
				$('.avatar').mouseleave(function(){
					$('.desc').removeClass('d-none');
					$('.middle').addClass('d-none');
				})
				
			})
		</script>
		<script type="text/javascript" src="upload/webcamjs/webcam.min.js"></script>

<!-- Code to handle taking the snapshot and displaying it locally -->
		<script language="JavaScript">
			
			// Configure a few settings and attach camera
			function configure(){
				$('.upload-foto').prop('disabled', true)
				Webcam.set({
					
					height: 300,
					image_format: 'jpg',
					jpeg_quality: 90
				});
				Webcam.attach( '#my_camera' );
			}
			// A button for taking snaps
			

			// preload shutter audio clip
			var shutter = new Audio();
			shutter.autoplay = false;
			shutter.src = navigator.userAgent.match(/Firefox/) ? 'upload/shutter.ogg' : 'upload/shutter.mp3';

			function take_snapshot() {
				// play sound effect
				shutter.play();

				// take snapshot and get image data
				Webcam.snap( function(data_uri) {
					// display results in page
					document.getElementById('results').innerHTML = 
						'<img id="imageprev" src="'+data_uri+'"/>';
				} );

				Webcam.reset();
			}

			function saveSnap(){
				// Get base64 value from <img id='imageprev'> source
				var base64image =  document.getElementById("imageprev").src;

				Webcam.upload( base64image, 'upload/upload.php?npk=<?=$npk_user?>', function(code, text) {
					Swal.fire({
						title: "Update Foto Berhasil",
						text: "Foto Profile Telah Diganti",
						timer: 2000,
						
						icon: "success",
						showCancelButton: false,
						showConfirmButton: true,
						confirmButtonColor: '#00B9FF',
						cancelButtonColor: '#B2BABB',
					}).then((result) => {
                    if (result.value) {
                        location.reload();
                    }
                })
					
					//console.log(text);
				});

			}
		</script>
		<?php
			include_once("../endbody.php");

	}else{
		echo "<script>window.location='".base_url('auth/login.php')."';</script>";
	}
} else{
	echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
		

	?>