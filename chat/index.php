<?php include 'header.php'; ?>

<div class="container">

	<div class="row">
		<div class="col-lg-4 mx-auto">

			<div class="pt-4 pb-3">

				<center>
					<a href="index.php"><img src="../assets/img/img/logo.png" style="width:auto; height: 150px;"></a>
				</center>

				<br>
				<center><h5>Login Akun</h5></center>

				<?php 
				if(isset($_GET['alert'])){
					if($_GET['alert'] == "registered"){
						?>
						<div class="alert alert-success text-center">
							<span class="font-weight-bold">Anda berhasil mendaftar.</span>
							<br>
							<small class="font-weight-light">Selanjutnya silahkan login.</small>
						</div>
						<?php
					}elseif($_GET['alert'] == "logout"){
						?>
						<div class="alert alert-success text-center">
							<span class="font-weight-bold">Anda telah logout.</span>
						</div>
						<?php
					}elseif($_GET['alert'] == "login-dulu"){
						?>
						<div class="alert alert-warning text-center font-weight-bold">Silahkan login untuk melanjutkan.</div>
						<?php
					}elseif($_GET['alert'] == "gagal"){
						?>
						<div class="alert alert-danger text-center">
							<span class="font-weight-bold">Login Gagal!</span>
							<br>
							<small class="font-weight-light">Email & password tidak sesuai.</small>
						</div>
						<?php
					}
				}
				?>

				<form action="login_aksi.php" method="post">

					<div class="form-group">
						<label>NPK</label>
						<input type="number" name="email" class="form-control" required='required' autocomplete="off" placeholder="Masukkan email ..">
					</div>

					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" class="form-control" required='required' placeholder="Masukkan password ..">
					</div>

					<input type="submit" class="btn btn-primary btn-block mt-4" value="LOGIN">

					<p class="text-center mt-3">
						Belum punya akun? 
						<br>
						<div class="text-center"><a href="daftar.php">Daftar Sekarang</a></div>
					</p>

				</form>


			</div>

		</div>

	</div>

</div>
<?php include 'footer.php'; ?>