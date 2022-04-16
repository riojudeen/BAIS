<?php
require_once("../../../../config/config.php");
require_once("../../../../config/error.php");
require_once("../../../../config/user_system.php");
if(isset($_SESSION['user'])){
    if(isset($_POST['update'])){
        // update data karyawan 
        // $npk = $_POST['npk'];
        $query = "REPLACE INTO karyawan (`npk`,`nama`,`nama_depan`, `tgl_masuk`,`jabatan`,`shift`,`status`) VALUES ";
        $queryUser = '';
        $queryOrg = '';
        
        if(isset($_POST['index'])){
            // echo count($_POST['index']);
            $total = count($_POST['index']);
            
            for($i = 0 ; $i < $total ;$i++){
                // $npk = $_POST['npk'];
                // $nama = $_POST['name'];
                $index =$_POST['index'][$i];
                $npk = $_POST['npk-'.$index];
                $nama = preg_replace("[']", "", $_POST['name-'.$index]);
                $nick = nick("$nama");
                $tgl_masuk = $_POST['tgl_masuk-'.$index];
                $status = $_POST['status-'.$index];
                $jabatan = $_POST['jabatan-'.$index];
                $shift = $_POST['shift-'.$index];
                
                $username = $_POST['username-'.$index];
                $pass = $_POST['pass-'.$index];
                $levelUser = $_POST['role-'.$index];
                
                $query .= "('$npk','$nama', '$nick', '$tgl_masuk', '$jabatan','$shift','$status'),";


                // $q_cekMp  = mysqli_query($link, "SELECT npk FROM karyawan WHERE npk = '$npk' ")or die(mysqli_errno($link));
                $q_cekUser  = mysqli_query($link, "SELECT npk FROM data_user WHERE npk = '$npk' ")or die(mysqli_errno($link));
                $q_cekOrg  = mysqli_query($link, "SELECT npk FROM org WHERE npk = '$npk' ")or die(mysqli_errno($link));
                
                // cek apakah data user sudah dibuat sebelumnya
                if(mysqli_num_rows($q_cekUser) <= 0 ){
                    //jika belum ada , cek apakah ybs menjadi koordinator area
                    $cek_cord = mysqli_query($link, "SELECT part FROM view_cord_area WHERE cord = '$npk' ")or die(mysqli_error($link));
                    
                    if(mysqli_num_rows($cek_cord) > 0){
                        // jika iya assign level user baru sesuai dengan koordinator area
                        $data_user = mysqli_fetch_assoc($cek_cord);
                        $role_ = $data_user['part'];
                        $level = assign_role($role_);
                        $levelUser = $level;
                        // echo $npk."-".$level."<br>";
                    }else{
                        //jika belum gunakan default
                        $levelUser = $levelUser;
                    }
                    // jika data user belum ada , buat data baru
                    $q_User = mysqli_query($link, "INSERT INTO data_user (`username`,`npk`,`pass`,`level`) VALUES ('$username', '$npk', '$pass','$levelUser')");
                }

                if(mysqli_num_rows($q_cekOrg) <= 0 ){
                    // jika belum ada tambahkan data
                    $q_Org = mysqli_query($link, "INSERT INTO org (`npk`,`plant`) VALUES ('$npk','1')");
                }
                
            }
            $sql = substr($query, 0 , -1); //untuk trim koma terakhir
            
            
            if($_POST['total_update'] > 0){
               // echo $sql;
               mysqli_query($link, "DELETE FROM karyawan ")or die(mysqli_error($link));
               $s_karyawan = mysqli_query($link, $sql);
               if($s_karyawan){
                   // echo "berhasil update";
                   $query_delete_user = "DELETE data_user
                       FROM data_user
                       LEFT OUTER JOIN karyawan ON karyawan.npk = data_user.npk WHERE karyawan.npk IS NULL";
                   $query_delete_org = "DELETE org
                       FROM org
                       LEFT OUTER JOIN karyawan ON karyawan.npk = org.npk WHERE karyawan.npk IS NULL";
                   mysqli_query($link, $query_delete_org)or die(mysqli_error($link));
                   mysqli_query($link, $query_delete_user)or die(mysqli_error($link));
                   $_SESSION['info'] = 'Disimpan';
                   $_SESSION['pesan'] = 'Seluruh Data Karyawan, Organisasi & User Berhasil Dibuat';
                   header('location:../add_karyawan.php');
                   

               }else{
                   $_SESSION['info'] = 'Gagal Disimpan';
                   $_SESSION['pesan'] = 'Data';
                   header('location:../add_karyawan.php');
               }
            }else{
                
                $s_karyawan = mysqli_query($link, $sql);
                // echo $sql;
                if($s_karyawan){
                    $_SESSION['info'] = 'Disimpan';
                    $_SESSION['pesan'] = 'Seluruh Data Karyawan, Organisasi & User Berhasil Dibuat';
                    echo "<script>document.location.href='../add_karyawan.php'</script>";

                }else{
                    $_SESSION['info'] = 'Gagal Disimpan';
                    $_SESSION['pesan'] = 'Data';
                    echo "<script>document.location.href='../add_karyawan.php'</script>";

                }
            }
            
            
        }else{
                $_SESSION['info'] = "Kosong";
                echo "<script>document.location.href='../add_karyawan.php'</script>";
        }
        ?> 
        <?php
    }else if(isset($_POST['edit'])){
        $total = count($_POST['npk']);
        $query = "REPLACE INTO karyawan (`npk`,`nama`,`tgl_masuk`,`jabatan`,`shift`,`status`,`department`,`id_area`) VALUES ";
        $queryOrg = "REPLACE INTO org (`npk`,`sub_post`,`post`,`grp`,`sect`,`dept`,`dept_account`,`division`,`plant`) VALUES ";
        for ($i=0; $i<$total;$i++){
            $npk = $_POST['npk'][$i];
            $nama = $_POST['nama'][$i];
            $tgl_masuk = dateToDB2($_POST['tgl_masuk'][$i]);
            $jabatan = $_POST['jabatan'][$i];
            $shift = $_POST['shift'][$i];
            $status = $_POST['status'][$i];
            $deptAcc = $_POST['deptAcc'][$i];
            $nick = $_POST['nick'][$i];
            $plant = $_POST['plant'][$i];
            $division = $_POST['division'][$i];
            $dept = $_POST['dept'][$i];
            $sect = $_POST['sect'][$i];
            $group = $_POST['group'][$i];
            $pos = $_POST['pos'][$i];
            // echo $plant;
            // echo "$npk<br />";
            // echo "$nama<br />";
            // echo "$nick<br />";
            // echo "$tgl_masuk<br />";
            // echo "$shift<br />";
            // echo "$jabatan<br />";
            // echo "$status<br />";
            // echo "$division<br />";
            // echo "plant:$plant<br />";
            // echo "deptAcc:$deptAcc<br />";
            // echo "dept:$dept<br />";
            // echo "section:$sect<br />";
            // echo "group:$group<br />";
            // echo "pos:$pos<br />";
            $pos = data_area($link, "pos",$pos, "id");
            $group = data_area($link, "group",$group, "id");
            $section = data_area($link, "section",$sect, "id");
            $dept = data_area($link, "dept",$dept, "id");
            $deptAcc = data_area($link, "deptAcc",$deptAcc, "id");
            $division = data_area($link, "division",$division, "id");
            $plant = data_area($link, "plant",$plant, "id");
            $id_area = cariID_area($pos,$group,$section,$dept,$division,$plant);
            $id_sub_post = cekSubPost($link, $npk);

            $pass = getPass(dateToDB2($tgl_masuk));
            $levelUser = "gu";
            // echo "datapos:".$id_sub_post."<br>";
            // echo "datapos:".$pos."<br>";
            // echo "datagroup:".$group."<br>";
            // echo "datasect:".$section."<br>";
            // echo "datadept:".$dept."<br>";
            // echo "datadeptAcc:".$deptAcc."<br>";
            // echo "datadiv:".$division."<br>";
            // echo "dataplant:".$plant."<br>";
            // echo "idarea:".cariID_area("",$group,$section,$dept,$division,$plant)."<br>";
            // echo "totaldata:$total<br />---------<br />";
            
            
            $query .= "('$npk','$nama', '$tgl_masuk', '$jabatan','$shift','$status','$deptAcc','$id_area'),";
            $queryOrg .= "('$npk','$id_sub_post','$pos', '$group', '$section','$dept','$deptAcc','$division','$plant'),";
            
            // $sqMp = mysqli_query($link, "UPDATE karyawan SET nama = '$nama' , nama_depan = '$nick', tgl_masuk = '$tgl_masuk' , shift = '$shift' , 
            // jabatan = '$jabatan' , `status` = '$status' , id_area = '$dept' WHERE npk = '$npk'") or die(mysqli_error($link));
            
        }
        $sql = substr($query, 0 , -1); //untuk trim koma terakhir
        $sqlOrg = substr($queryOrg, 0 , -1); //untuk trim koma terakhir
        // echo $sqlOrg;
        // $sqlUser = substr($queryUser, 0 , -1); //untuk trim koma terakhir
        $s_karyawan = mysqli_query($link, $sql)or die(mysqli_error($link));
        if($s_karyawan){
            $s_org = mysqli_query($link, $sqlOrg)or die(mysqli_error($link));
            if($s_org){
                $_SESSION['info'] = 'Disimpan';
                $_SESSION['pesan'] = 'Seluruh';
                if(isset($_POST['redirect'])){
                    $link = $_POST['redirect'];
                    echo "<script>document.location.href='$link'</script>";
                }else{
                    echo "<script>document.location.href='../add_karyawan.php'</script>";
                }
            }else{
                $_SESSION['info'] = 'Gagakl Disimpan';
                $_SESSION['pesan'] = 'Organization';
                if(isset($_POST['redirect'])){
                    $link = $_POST['redirect'];
                    echo "<script>document.location.href='$link'</script>";
                }else{
                    echo "<script>document.location.href='../add_karyawan.php'</script>";
                }
            }
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
            $_SESSION['pesan'] = 'Resource';
            if(isset($_POST['redirect'])){
                $link = $_POST['redirect'];
                echo "<script>document.location.href='$link'</script>";
            }else{
                echo "<script>document.location.href='../add_karyawan.php'</script>";
            }
        }
    }else if(isset($_GET['del'])){
        $npk = $_GET['del'];
        $sqlmp = mysqli_query($link, "DELETE FROM karyawan WHERE npk = '$npk'") or die(mysqli_error($link));
        if($sqlmp){
            $sqluser = mysqli_query($link, "DELETE FROM data_user WHERE npk = '$npk'") or die(mysqli_error($link));
            $sqlexpat = mysqli_query($link, "DELETE FROM expatriat WHERE npk = '$npk'") or die(mysqli_error($link));
            $sqluser = mysqli_query($link, "DELETE FROM data_user WHERE npk = '$npk'") or die(mysqli_error($link));
            $sqlOrg = mysqli_query($link, "DELETE FROM org WHERE npk = '$npk'") or die(mysqli_error($link));
            $_SESSION['info'] = 'Dihapus';
            echo "<script>document.location.href='../add_karyawan.php'</script>";
        }else{
            $_SESSION['info'] = 'Gagal Dihapus';
            echo "<script>document.location.href='../add_karyawan.php'</script>";
        }
    }else if(isset($_POST['index'])){
        // echo "berhasil";
        
        foreach($_POST['index'] as $npk){
            $sqlmp = mysqli_query($link, "DELETE FROM karyawan WHERE npk = '$npk'") or die(mysqli_error($link));
            $sqlexpat = mysqli_query($link, "DELETE FROM expatriat WHERE npk = '$npk'") or die(mysqli_error($link));
            $sqluser = mysqli_query($link, "DELETE FROM data_user WHERE npk = '$npk'") or die(mysqli_error($link));
            $sqlOrg = mysqli_query($link, "DELETE FROM org WHERE npk = '$npk'") or die(mysqli_error($link));
        }
        if($sqlmp){
            $_SESSION['info'] = 'Dihapus';
            echo "<script>document.location.href='../add_karyawan.php'</script>";
        }else{
            $_SESSION['info'] = 'Gagal Dihapus';
            echo "<script>document.location.href='../add_karyawan.php'</script>";
        }

    }else if(isset($_POST['edituser'])){
            $totalData = count($_POST['npk']);
            for($i = 0 ; $i < $totalData ; $i++){
                $npk = $_POST['npk'][$i];
                $nama = $_POST['nama'][$i];
                $role = $_POST['level'][$i];
                $passOld = trim(mysqli_real_escape_string($link, $_POST['pass1'][$i]));
                $passNew = sha1(trim(mysqli_real_escape_string($link, $_POST['pass2'][$i])));
                $pass = ($_POST['passactive'][$i] == 'new')? $passNew : $passOld;
                $query = mysqli_query($link, "UPDATE data_user SET pass = '$pass', `level` = '$role' WHERE npk = '$npk' ")or die(mysqli_error($link));
                // echo $npk."<br>";
                // echo $nama."<br>";
                // echo $role."<br>";
                // echo $passOld."<br>";
                // echo $npk."<br>";
                // echo $pass."<br>";
            }
            if($query){
                
                $_SESSION['info'] = 'Disimpan';
                echo "<script>document.location.href='../user.php?tab=$role'</script>";
            }else{
                $_SESSION['info'] = 'Gagal Disimpan';
                echo "<script>document.location.href='../user.php?tab=$role'</script>";
            }
    }else if(isset($_POST['edituser_mass'])){
        $total = count($_POST['npk']);
        // echo $_POST['tab']."<br>";
        for($i=0; $i<$total;$i++){
            $no =$i+1;
            // echo "password lama :".$_POST['pass1'][$i]."<br>";
            // echo $_POST['pass2'][$i]."<br>";
            // echo $_POST['npk'][$i]."<br>";
            // echo $_POST['passactive'."$no"]['0'] ."<br>";
            $npk = $_POST['npk'][$i];
            // echo $_POST['level'][$i];
            $active = $_POST['passactive'."$no"]['0'];
            if($active == "old"){
                $pass = $_POST['pass1'][$i];
            }else{
                $pass = sha1($_POST['pass2'][$i]);
            }
            $level = $_POST['level'][$i];
            mysqli_query($link, "UPDATE data_user SET pass = '$pass', `level` = '$level' WHERE npk = '$npk' ")or die(mysqli_error($link));
        }
        // echo "<br>";
        // if($query){
            
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../user.php?tab=$role'</script>";
        // }else{
        //     $_SESSION['info'] = 'Gagal Disimpan';
        //     echo "<script>document.location.href='../user.php?tab=$role'</script>";
        // }
    }else if(isset($_GET['reset'])){
        // get tanggal masuk
        $role = $_GET['tab'];
        // echo $_GET['tab'];
        $q_karyawan = mysqli_query($link, "SELECT tgl_masuk FROM karyawan WHERE npk = '$_GET[reset]'")or die(mysqli_error($link));
        $sql_karyawan = mysqli_fetch_assoc($q_karyawan);
        $pass = default_password($sql_karyawan['tgl_masuk']);
        $query = mysqli_query($link, "UPDATE data_user SET pass = '$pass'  WHERE npk = '$_GET[reset]'")or die(mysqli_error($link));
        if($query){
            
            $_SESSION['info'] = 'Disimpan';
            echo "<script>document.location.href='../user.php?tab=$role'</script>";
        }else{
            $_SESSION['info'] = 'Gagal Disimpan';
            echo "<script>document.location.href='../user.php?tab=$role'</script>";
        }
    }else if(isset($_GET['userchecked'])){
        // get tanggal masuk
        foreach($_GET['userchecked'] AS $npk){
            $role = $_GET['tab'];
            $q_karyawan = mysqli_query($link, "SELECT tgl_masuk FROM karyawan WHERE npk = '$npk'")or die(mysqli_error($link));
            $sql_karyawan = mysqli_fetch_assoc($q_karyawan);
            $pass = default_password($sql_karyawan['tgl_masuk']);
            $query = mysqli_query($link, "UPDATE data_user SET pass = '$pass'  WHERE npk = '$npk'")or die(mysqli_error($link));
            // echo $npk;
        }
        $_SESSION['info'] = 'Disimpan';
        echo "<script>document.location.href='../user.php?tab=$role'</script>";
        
    }else{
        $_SESSION['info'] = "Kosong";
        header("Location: ../add_karyawan.php");
        echo "<script>window.location='../user.php';</script>";
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>