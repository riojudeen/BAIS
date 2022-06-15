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
        
        $pass_before = $data_akun['pass']; //password lama
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
    }else if($_POST['data_npk']){
        $npk = $_POST['data_npk'];
        if($npk == $npkUser){
            $back = 'me';
        }else{
            $back = $npk;
        }
        $domisili = $_POST['domisili'];
        $hp = $_POST['handphone'];
        $birth = dateToDB($_POST['birth']);
        echo $npk;
        $cek = mysqli_query($link,"SELECT npk FROM karyawan_profile WHERE npk = '$npk' ")or die(mysqli_error($link));
        if(mysqli_num_rows($cek)>0){
            $sql = mysqli_query($link, "UPDATE karyawan_profile SET birth = '$birth', handphone = '$hp' , domisili = '$domisili' WHERE npk = '$npk' ")or die(mysqli_error($link));
        }else{
            $sql = mysqli_query($link, "INSERT INTO karyawan_profile (`npk`, `birth`, `handphone`, `domisili`) VALUES ('$npk', '$birth', '$hp', '$domisili' )")or die(mysqli_error($link));
        }
        if($sql){
            $_SESSION['info'] = "Disimpan";
            header("location:index.php?profile=$back");
        }else{
            $_SESSION['info'] = "Gagal Disimpan";
            header("location:index.php?profile=$back");
        }
    }
	
} else{
    ?>

    <?php
}
	

?>