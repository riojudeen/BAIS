<?php
require_once("../../../config/config.php");
require_once("../../../config/error.php");
    if(isset($_POST['desc_info'])){
        $query = "INSERT INTO info (`id`, `title`, `info`, `image`, `category` , `stats`, `date_start`, `date_end`, `publisher`) VALUES";
        $file_mimes = array('image/jpeg','image/jpg','image/png');
        $title = $_POST['title_info'];
        $category = $_POST['cat_info'];
        $desc = $_POST['desc_info'];
        
        $id = idIncrement($link, "info","id");
        if(isset($_FILES['file_import']['name']) && in_array($_FILES['file_import']['type'], $file_mimes)) {
            $ImageName       = $_FILES['file_import']['name'];
            $image = $_FILES['file_import']['name'];

            $dir = $_FILES['file_import']['tmp_name']; //file upload

            $query_dir = mysqli_query($link, "SELECT `root` FROM external_directory WHERE keterangan = 'INFO' ")or die(mysqli_error($link));
            $sql_dir = mysqli_fetch_assoc($query_dir);
            $root_path = $sql_dir['root'];
            $path = "$root_path";
            
            if (file_exists($path)){
                // compress image
                $namaGambar     = sha1($id);
                $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt       = str_replace('.','',$ImageExt); // Extension
                $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                $NewImageName   = str_replace(' ', '', $namaGambar.'.'.$ImageExt);

                $newPath = "$root_path/$NewImageName"; //direktori penyimpanan
                $source =  $dir;
                $imgInfo = getimagesize($source); 
                $mime = $imgInfo['mime'];  
                $destination = $newPath;
                $quality = 20;
                // membuat image baru
                switch($mime){ 
                // proses kode memilih tipe tipe image 
                    case 'image/jpeg': 
                        $image = imagecreatefromjpeg($source); 
                        break; 
                    case 'image/jpg': 
                        $image = imagecreatefromjpeg($source); 
                        break; 
                    case 'image/png': 
                        $image = imagecreatefrompng($source); 
                        break; 
                    default: 
                        $image = imagecreatefromjpeg($source); 
                } 
                
                imagejpeg($image, $newPath, $quality); 
                // nama file baru
                $imageName = "'".$namaGambar.".$ImageExt"."'";
            }else{
                $imageName = "'NULL'";
            }

        }else{
            $imageName = "'NULL'";
        }
        $today = date('Y-m-d');
        $publisher = $npkUser;
        $query .= " ('$id','$title','$desc', $imageName ,'$category','1', '$today' , NULL , '$publisher')";
        // echo $query;
        $sql = mysqli_query($link, $query);
        if($sql){
            ?>
            <script>
                Swal.fire({
                    title: 'Sukses',
                    text: 'Informasi Telah Disimpan',
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
                    title: 'Gagal',
                    text: "Informasi Gagal Disimpan (Kode Error: <?=mysqli_error($link)?>)",
                    // timer: 2000,
                    
                    icon: 'danger',
                    showCancelButton: false,
                    showConfirmButton: false,
                    confirmButtonColor: '#00B9FF',
                    cancelButtonColor: '#B2BABB',
                    
                })
            </script>
            <?php
        }
       
    }else if(isset($_POST['delete_info'])){

        $data = $_GET['del'];
        $cek_data = mysqli_query($link, "SELECT `image` FROM info WHERE id = '$data' ")or die(mysqli_error($link));
        $sql = mysqli_fetch_assoc($cek_data);
        $image = $sql['image'];
        $newPath = "//adm-fs/BODY/BODY02/Body Plant/BAIS/INFO-SUPPORT/$image";
       
        $sql = mysqli_query($link, "DELETE FROM info WHERE id = '$data' ");


        
        if($sql){
            if (file_exists($newPath)){
                unlink($newPath);
            }
            ?>
            <script>
                Swal.fire({
                    title: 'Sukses',
                    text: 'Informasi Telah Dihapus',
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
                    title: 'Gagal',
                    text: "Informasi Gagal Dihapus (Kode Error: <?=mysqli_error($link)?>)",
                    timer: 2000,
                    
                    icon: 'danger',
                    showCancelButton: false,
                    showConfirmButton: false,
                    confirmButtonColor: '#00B9FF',
                    cancelButtonColor: '#B2BABB',
                })
            </script>
            <?php
        }
        ?>
        
        <?php
    }else if(isset($_POST['update_info'])){
        $today = date('Y-m-d');
        $data = $_POST['update_info'];
        $cek_data = mysqli_query($link, "SELECT * FROM info WHERE id = '$data' ")or die(mysqli_error($link));
        $sql = mysqli_fetch_assoc($cek_data);
        $stats = $sql['stats'];
        $cat = $sql['category'];
        switch($_POST['id']){
            case "nav-general":
                
                $text_publish = "0";
                
                break;
            case "nav-support":
                $text_publish = "1";
                break;
            case "nav-notif":
                $text_publish = "0";
                break;
            case "nav-holiday":
                $text_publish = "0";
                break;
        }
        if($stats == 0){
            $stats = 1;
        }else{
            $stats = 0;
        }
        $queryStats = " UPDATE info SET stats = '$stats', date_end = '$today' WHERE id = '$data' ";
        $sql = mysqli_query($link, $queryStats);
        // echo $queryStats;
        if($sql){
            if($stats == 0 && $text_publish == "1"){
                ?>
                <script>
                    Swal.fire({
                        title: 'Problem Solved',
                        text: 'Informasi Telah Diperbarui',
                        timer: 2000,
                        
                        icon: 'success',
                        showCancelButton: false,
                        showConfirmButton: false,
                        confirmButtonColor: '#00B9FF',
                        cancelButtonColor: '#B2BABB',
                        
                    })
                </script>
                <?php
            }
            
        }else{
            ?>
            <script>
                Swal.fire({
                    title: 'Gagal',
                    text: "Informasi Gagal Dihapus (Kode Error: <?=mysqli_error($link)?>)",
                    timer: 2000,
                    
                    icon: 'danger',
                    showCancelButton: false,
                    showConfirmButton: false,
                    confirmButtonColor: '#00B9FF',
                    cancelButtonColor: '#B2BABB',
                })
            </script>
            <?php
        }
        
    }
?>
