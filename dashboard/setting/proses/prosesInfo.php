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
            $path = "//adm-fs/BODY/BODY02/Body Plant/BAIS/INFO-SUPPORT/";
            
            if (file_exists($path)){
                // compress image
                $namaGambar     = sha1($id);
                $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt       = str_replace('.','',$ImageExt); // Extension
                $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                $NewImageName   = str_replace(' ', '', $namaGambar.'.'.$ImageExt);

                $newPath = "//adm-fs/BODY/BODY02/Body Plant/BAIS/INFO-SUPPORT/$NewImageName"; //direktori penyimpanan
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
            }

           
            // nama file baru
            $imageName = "'".$namaGambar.".$ImageExt"."'";

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
       
    }else if($_POST['delete_info']){

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
        <script>
            Swal.fire({
                title: 'Sukses',
                text: 'Informasi Telah Didelete',
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
?>
