<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 

//redirect ke halaman dashboard index jika sudah ada session
$halaman = "My Profile";
if(isset($_SESSION['user'])){

		include("../header.php");
		$date = date('Y-m-d');
		// echo $data_value."<br>";
		// echo $npkUser;
		$npk_user = $_SESSION['user'];
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
						$check_in = ($data_absen['check_in'] == "00:00:00")?"-":jam($data_absen['check_in']);
						$check_out = ($data_absen['check_out'] == "00:00:00")?"-":jam($data_absen['check_out']);
						?>
						<div class="col-lg-6 col-sm-12 col-md-6 ml-auto mr-auto">
							<h5><?=$check_in?><br><small>Check In</small></h5>
						</div>
						<div class="col-lg-6 col-sm-12 col-md-6  ml-auto mr-auto">
							<h5><?=$check_out?><br><small>Check Out</small></h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<h5 class="text-uppercase">Sisa Cuti Tahunan</h5>
				<p class="description">
					- Hari
				</p>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<h5 class="text-uppercase">Sisa Cuti panjang</h5>
				<p class="description">
					- Hari
				</p>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="title">Pengajuan Surat Pemberitahuan</h5>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="btn btn-sm">Kembali</div>
                    </div>
                </div>
			</div>
			<div class="card-body">
			
				<form>
				<div class="card card-plain">
				<h6 class="title">Data Organisasi</h6>
					<div class="row">
						<div class="col-md-4 pr-1">
							<div class="form-group">
								<label>Division</label>
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
								<input type="text" class="form-control" disabled="true"  value="<?=$data_profile['shift']?>">
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
					<div class="row">
						<div class="col-md-6">
						<label>Tanggal Lahir</label>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="">
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
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Alamat Domisili</label>
								<textarea rows="4" cols="80" class="form-control textarea"></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-right">
							<div class="btn btn-sm btn-primary">update</div>

						</div>

					</div>
				</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 " >
				<div class="card " id="contoh2">
					<div class="card-header ">
						<h5 class="card-title">Monitoring Absensi</h5>
						<p class="card-category"></p>
					</div>
					<div class="card-body ">
					<div class="box pull-left">
						<form class="form-inline" action="" method="post">
						
							<div class="border-1 input-group">
								<div class="input-group-prepend">
									<span class="input-group-text text-white pr-2 bg-secondary"><i class="nc-icon nc-calendar-60"></i></span>
									
								</div>
								<input style="background: #EAECEE;" type="text" name="awal" class="form-control border-right-0 datepicker" data-date-format="DD/MM/YYYY" placeholder="tanggal mulai" date-format="yyyy-mm-dd" id="datetimepicker6" value="<">
								<div class="input-group-prepend" style="margin-left: -3px">
									<span type="text" class="input-group-text px-3" style="font-size: 12px">to</span>
								</div>
								<input style="background: #EAECEE;" type="text" name="akhir" class="form-control datepicker" data-date-format="DD/MM/YYYY" placeholder="tanggal akhir" date-format="yyyy-mm-dd" id="datetimepicker7" value="">
								
							</div>
							
							<div class="input-group ">
								<button type="submit" class="btn btn-danger " aria-hidden="true">SORT</button>
							</div>
							
							
						</form>
					</div>
					
					
							
							
						<div class="table-responsive" style="height:200">
							<table class="table  table-hover" >
								<thead>
									<tr>
										<th scope="col">No</th>
										<th scope="col">Hari</th>
										<th scope="col">Tanggal</th>                  
										<th scope="col" colspan="2">Check In</th>
										<th scope="col" colspan="2">Check Out</th>
										<th scope="col">KET</th>
										
										
									</tr>
								</thead>
								<tbody class="text-nowrap">
									<?php
									$lembur = mysqli_query($link, "SELECT * FROM absensi WHERE npk = '$npk_user'")or die(mysqli_error($link));
									$no = 1;
									

									while($data_spl = mysqli_fetch_assoc($lembur)){
										$hari = hari($data_spl['date_in']);
										
										?>                        

									
									<tr>
									
										<td><?=$no++?></td>
										<td><?=$hari?></td>
										<td><?=tgl_indo($data_spl['date_in'])?></td>
										<td><?=$data_spl['date_in']?></td>
										<td><?=$data_spl['check_in']?></td>
										<td><?=$data_spl['date_out']?></td>
										<td><?=$data_spl['check_out']?></td>
										<td><?=$data_spl['ket']?></td>
										<td></td>                                							
									</tr>
									
									<?php
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						
						<h5 class="text-uppercase">Koordinator</h5>
						<?php
						foreach($array_area_kordinator As $part){
							$query = mysqli_query($link,"SELECT `nama_org`,`id` FROM view_cord_area WHERE cord = '$npkUser' AND part = '$part' ")or die(mysqli_error($link));
							
							if($part)
							?>
							<p class="description">
								<?=partCode($part, "nama")?>
								</br>
								<?php
								while($data = mysqli_fetch_assoc($query)){
									?>
									<?=$data['nama_org']?>
									</br>
									<?php
								}

								?>
							</p>
							<?php
						}
						?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

			
			
<?php
//footer
		include_once("../footer.php");

} else{
		echo "<script>window.location='".base_url('auth/login.php')."';</script>";
	}
	

?>