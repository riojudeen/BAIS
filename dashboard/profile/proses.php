<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
include("../../config/approval_system.php"); 

//redirect ke halaman dashboard index jika sudah ada session
if(isset($_SESSION['user'])){
    if(isset($_GET['submit']) && $_GET['submit'] == 'submit_account' ){
        $npkUser = $_GET['npk'];
        $query_akun = mysqli_query($link, "SELECT * FROM view_user WHERE npk = '$npkUser' ")or die(mysqli_error($link));
		$data_akun = mysqli_fetch_assoc($query_akun);
        $pass = sha1($_GET['old_pass'] );
		$user_levQuery = mysqli_query($link, "SELECT role_name FROM user_role WHERE id_role = '$data_akun[level_user]' ")or die(mysqli_error($link));
		// $data_userLevel = mysqli_fetch_assoc($user_levQuery);
        $new_pass = sha1($_GET['new_pass']);
        $pass_before = $data_akun['pass'];
        $cekPass = mysqli_num_rows($user_levQuery);
        if($pass == $data_akun['pass']){
            
            mysqli_query($link, "UPDATE data_user SET pass = '$new_pass' WHERE npk = '$npkUser' ");
            ?>
            <script>
                Swal.fire({
                    title: 'Sukses',
                    text: 'Password sudah diganti',
                    timer: 2000,
                    
                    icon: 'success',
                    showCancelButton: false,
                    showConfirmButton: false,
                    confirmButtonColor: '#00B9FF',
                    cancelButtonColor: '#B2BABB',
                    
                })
            </script>
            <?php
        }else{
            ?>
            <script>
                Swal.fire({
                    title: 'Password Salah',
                    text: 'Pastikan password lama anda sudah benar',
                    // timer: 2000,
                    
                    icon: 'warning',
                    showCancelButton: false,
                    showConfirmButton: false,
                    confirmButtonColor: '#00B9FF',
                    cancelButtonColor: '#B2BABB',
                    
                })
            </script>
            <?php
        }
    }
	
} else{
    ?>

    <?php
}
	

?>