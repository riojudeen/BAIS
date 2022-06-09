<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
include("../../config/approval_system.php"); 

//redirect ke halaman dashboard index jika sudah ada session
if(isset($_SESSION['user'])){
	if(isset($_GET['npk'])){
        if($_GET['npk'] == $npkUser){
            $npkUser = $_GET['npk'];
            $query_akun = mysqli_query($link, "SELECT * FROM view_user WHERE npk = '$npkUser' ")or die(mysqli_error($link));
            $data_akun = mysqli_fetch_assoc($query_akun);

            $user_levQuery = mysqli_query($link, "SELECT role_name FROM user_role WHERE id_role = '$data_akun[level_user]' ")or die(mysqli_error($link));
            $data_userLevel = mysqli_fetch_assoc($user_levQuery);

            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <h5 class="text-uppercase col-md-6">account info</h5>
                                <div class="col-md-6 text-right">
                                    <a class="btn btn-sm btn-info" data-toggle="collapse" href="#change_password" role="button" aria-expanded="true" aria-controls="collapseExample">Change Password</a>
                                </div>

                            </div>
                        </div>
                        <hr>
                        <form class="card-body" action="" method="POST">
                            <div class="col-md-12 px-1">
                            <label>NPK</label>
                                <div class="input-group no-border">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text  px-2" id="npkUser">
                                            <i class="nc-icon nc-single-02"></i>
                                        </span>
                                    </div>
                                    <input type="number" readonly class="form-control" placeholder="8788344xxxx" value="<?=$data_akun['npk']?>">
                                </div>
                            </div>
                            <div class="col-md-12 px-1">
                            <div class="col-md-12 px-1">
                                <label>User Level</label>
                                <div class="input-group no-border">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text  px-2" id="basic-addon1">
                                            <i class="nc-icon nc-single-02"></i>
                                        </span>
                                    </div>
                                    <input type="text" readonly class="form-control" value="<?=$data_userLevel['role_name']?>">
                                </div>
                            </div>
                            <div class="collapse collapse-view" id="change_password">
                                <div class="col-md-12 px-1">
                                    <label>Password</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text px-2" id="pass">
                                                <i class="nc-icon nc-lock-circle-open"></i>
                                            </span>
                                        </div>
                                        <input type="password" id="new_pass"  required class="form-control" placeholder="password baru" value="" autocomplete="off">
                                    </div>
                                    </div>

                                    <label>Password Lama</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text px-2" id="basic-addon1">
                                                <i class="nc-icon nc-lock-circle-open"></i>
                                            </span>
                                        </div>
                                        <input type="password" id="old_pass" required  class="form-control" placeholder="password Lama">
                                    </div>
                                    <p class="category">konfirmasi password lamu untuk ubah password</p>
                                    <div class="row">
                                        <div class="col-md-6 ">
                                            <button type="button" class="btn btn-sm  btn-link btn-danger" data-toggle="collapse" href="#change_password" role="button" aria-expanded="true" aria-controls="collapseExample">cancel</button>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="reset" class="btn btn-sm btn-warning">reset</button>
                                            <button type="submit" id="submit_account" class="btn btn-sm btn-primary">change</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <?php
        }
		
	}
		
} else{
		echo "<script>window.location='".base_url('auth/login.php')."';</script>";
	}
	

?>