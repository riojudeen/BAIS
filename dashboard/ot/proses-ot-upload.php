<?php
require_once("../../config/config.php");
require_once("../../config/approval_system.php");
require_once("../../config/schedule_system.php");
if(isset($_SESSION['user']) && $level >=1 && $level <=8){
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    if(isset($_FILES['file_ot']['name']) && in_array($_FILES['file_ot']['type'], $file_mimes)) {
    //    echo $_POST['group_ot_name'];
    //    echo $_POST['tanggal_kerja_ot'];
    //    echo $_POST['group_ot'];
    //    echo $_POST['shift_ot'];
    //    echo $_POST['name_requester'];
    $query = mysqli_query($link, "SELECT `root` FROM external_directory WHERE keterangan = 'SPL' ")or die(mysqli_error($link));
    $sql = mysqli_fetch_assoc($query);
    $root_path = $sql['root'];
        $date = $_POST['tanggal_kerja_ot'];
        $temp_path = $_FILES['file_ot']['tmp_name'];
        $ext = pathinfo($_FILES['file_ot']['name'], PATHINFO_EXTENSION);
        $fileName = "SPL-".$_POST['name_requester']."_".$_POST['group_ot_name']."-".$_POST['shift_ot']."_".$_POST['tanggal_kerja_ot'].".$ext";
        // echo $fileName;
       $tahun = date('Y', strtotime($date));
       $bulan = date('m', strtotime($date));
       
       $pathTujuan = "$root_path"."$tahun/";
       $pathTujuan1 = "$root_path"."$tahun/$bulan/";
    //    echo $pathTujuan ;
       if(mysqli_num_rows($query)>0){

            if(file_exists($root_path)){
                if(!file_exists($pathTujuan)){
                    mkdir($pathTujuan);
                }
                    // echo "ada";
                    // echo $pathTujuan ;
                    // chmod($pathTujuan, 0755);
                if(file_exists($pathTujuan1)){
                    if(file_exists($pathTujuan1.$fileName)){
                            // echo "data sudah ada";
                            ?>
                            <script>
                                Swal.fire({
                                    title: 'Gagal Dikirim',
                                    text: 'Dokumen SPL Sudah Pernah Dikirim Sebelumnya',
                                    timer: 2000,
                                    
                                    icon: 'error',
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    confirmButtonColor: '#00B9FF',
                                    cancelButtonColor: '#B2BABB',
                                    
                                })
                            </script>
                            <?php
                        }else{
                            move_uploaded_file($temp_path, $pathTujuan1.$fileName);
                            ?>
                            <script>
                                Swal.fire({
                                    title: 'Berhasil Dikirim',
                                    text: 'Dokumen SPL berhasil Dikirim',
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
                        // echo $pathTujuan1 ;
                        // chmod($pathTujuan1, 0755);
                        
                }else{
                    
                    mkdir($pathTujuan1);
                    if(file_exists($pathTujuan1.$fileName)){
                        // echo "data sudah ada";
                        ?>
                        <script>
                            Swal.fire({
                                title: 'Gagal Dikirim',
                                text: 'Dokumen SPL Sudah Pernah Dikirim Sebelumnya',
                                timer: 2000,
                                
                                icon: 'error',
                                showCancelButton: false,
                                showConfirmButton: false,
                                confirmButtonColor: '#00B9FF',
                                cancelButtonColor: '#B2BABB',
                                
                            })
                        </script>
                        <?php
                    }else{
                        move_uploaded_file($temp_path, $pathTujuan1.$fileName);
                        ?>
                        <script>
                            Swal.fire({
                                title: 'Berhasil Dikirim',
                                text: 'Dokumen SPL berhasil Dikirim',
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
                    // echo $pathTujuan1 ;
                    // chmod($pathTujuan1, 0755);
                    //    chmod($pathTujuan1, 0755);
                }
            }else{
                ?>
                <script>
                    Swal.fire({
                        title: 'Fitur Belum Didukung',
                        text: 'mohon maaf , fitur ini belum didukung',
                        timer: 2000,
                        
                        icon: 'error',
                        showCancelButton: false,
                        showConfirmButton: false,
                        confirmButtonColor: '#00B9FF',
                        cancelButtonColor: '#B2BABB',
                        
                    })
                </script>
                <?php
            }
        }else{
            //    echo "folder tidak ada";
            // mkdir($pathTujuan);
            ?>
            <script>
                Swal.fire({
                    title: 'Direktory Salah Atau Belum Didukung',
                    text: 'pastikan direktori folder benar atau terhubung ke intranet',
                    timer: 2000,
                    
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    confirmButtonColor: '#00B9FF',
                    cancelButtonColor: '#B2BABB',
                    
                })
            </script>
            <?php
            
            //    chmod($pathTujuan, 0755);
        }
    }else{
        ?>
        <script>
            Swal.fire({
                title: 'Data Kosong',
                text: 'Pastikan Dokumen SPL Sudah dipilih',
                timer: 2000,
                
                icon: 'warning',
                showCancelButton: false,
                showConfirmButton: false,
                confirmButtonColor: '#00B9FF',
                cancelButtonColor: '#B2BABB',
                
            })
        </script>
        <?php
    }
    /*
    if(isset($_POST['request'])){
        if(isset($_GET['del_req'])){
            // document upload
            $shift_req = 0;
            $query = $query = "INSERT req_absensi (`id` , `npk`, `date` , `shift` , `date_in`, `date_out`, `check_in`, `check_out`, `keterangan` , `requester`,`status`, `req_status`, `req_date`, `note`, `shift_req`, `id_absensi` ) 
                 VALUES ";
            $npk = $_POST['npk'];
            $shift = $_POST['shift'][0];
            $type = $_POST['code'];
            $alasan = $_POST['note'];
            $i = 0;
            $reqStats = 'a';
            $status = '25';
            $total_tgl = count($_POST['sd']);
            $tot_tgl = sprintf("%07d", $total_tgl);
            $id_image = $npk.dateToDB($_POST['sd'][0]);
            // simpan file upload
            $file_mimes = array('image/jpeg','image/jpg','image/png');
            if(isset($_FILES['attach-upload']['name']) && in_array($_FILES['attach-upload']['type'], $file_mimes)) {
                $ImageName       = $_FILES['attach-upload']['name'];
                $image = $_FILES['attach-upload']['name'];
                $dir = $_FILES['attach-upload']['tmp_name']; //file upload
                // $path = "//adm-fs/BODY/BODY02/Body Plant/BAIS/INFO-SUPPORT/";
                $path = "image_attachment/";
                if (file_exists($path)){
                    // compress image
                    $namaGambar     = $id_image."_".$tot_tgl."_".$type;
                    $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
                    $ImageExt       = str_replace('.','',$ImageExt); // Extension
                    $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                    $NewImageName   = str_replace(' ', '', $namaGambar.'.'.$ImageExt);
    
                    $newPath = $path.$NewImageName; //direktori penyimpanan
                    // echo $newPath;
                    $source =  $dir;
                    // echo $source;
                    $imgInfo = getimagesize($source); 
                    $mime = $imgInfo['mime'];  
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
                    $imageName = "'".$namaGambar.".$ImageExt"."'";
                }else{
                    $imageName = "'NULL'";
                }
                $image_judge = 1;
            }else{
                $image_judge = 0;
                $imageName = "'NULL'";
            }
            foreach($_POST['sd'] AS $tgl){
                $tgl = dateToDB($tgl);
                $id_absensi = $npk.$tgl;
                $id = $npk.$tgl;
                $ci = (isset($_POST['ci']) && $_POST['ci'][$i] != '')?$_POST['ci'][$i]:'00:00:00';
                $co = (isset($_POST['ci']) &&  $_POST['co'][$i] != '')?$_POST['co'][$i]:'00:00:00';
                $end_date = end_date($tgl,$link,$shift);
                $start_date = $tgl;
    
                $req_date = date('Y-m-d');
                $query .= "('$id', '$npk' , '$tgl', '$shift', '$start_date', '$end_date' , '$co' , '$ci' , '$type', '$npkUser', '$status', '$reqStats', '$req_date' , '$alasan', '$shift_req', $imageName ),";
                $i++;
            }
            // cek apakah pengajuan butuh lampiran atau tidak
            $cek_attendance_attachement = mysqli_query($link,"SELECT attachment FROM attendance_code WHERE kode = '$type' ")or die(mysqli_error($link));
            $data_attachment = mysqli_fetch_assoc($cek_attendance_attachement);
            $query = substr($query, 0, -1);
            if(isset($data_attachment['attachment']) && $data_attachment['attachment'] == 1 ){
                if($image_judge == 1){
                    $sql = mysqli_query($link, $query);
                    if($sql){
                        $_SESSION['info'] = 'Disimpan';
                        header('location: req_absensi.php');
                    }else{
                        $_SESSION['info'] = 'Gagal Disimpan';
                        $_SESSION['pesan'] = "( ".mysqli_error($link)." )";
                        header('location: req_absensi.php');
                    }
                }else{
                    $_SESSION['info'] = 'Gagal Disimpan';
                    $_SESSION['pesan'] = "( Silakan Ulangi Pengajuan dan Pastikan Lampiran diupload dengan format gambar )";
                    header('location: req_absensi.php');
                }
            }else{
                if($image_judge == 0){
                    $sql = mysqli_query($link, $query);
                    if($sql){
                        // echo "gambar tidak ada untuk pengajuan yang tidak membutuhkan lampiran";
                        $_SESSION['info'] = 'Disimpan';
                        header('location: req_absensi.php');
                    }else{
                        $_SESSION['info'] = 'Gagal Disimpan';
                        $_SESSION['pesan'] = "( ".mysqli_error($link)." )";
                        header('location: req_absensi.php');
                    }
                }else{
                    $_SESSION['info'] = 'Gagal Disimpan';
                    $_SESSION['pesan'] = "( pengajuan tidak mebutuhkan lampiran )";
                    header('location: req_absensi.php');
                }
            }
            // end document upload




            foreach($_POST['request'] AS $data){
                list($id , $npk, $work_date) = pecahID($data);
                mysqli_query($link, "DELETE FROM lembur WHERE _id = '$id' AND npk = '$npk' AND work_date = '$work_date' ")or die(mysqli_error($link));
            }
            ?>
            <script>
                Swal.fire({
                    title: 'Dihapus',
                    text: 'Draft Pengajuan Telah Dihapus',
                    timer: 2000,
                    
                    icon: 'success',
                    showCancelButton: false,
                    showConfirmButton: false,
                    confirmButtonColor: '#00B9FF',
                    cancelButtonColor: '#B2BABB',
                    
                })
            </script>
            <?php
        }else if(isset($_GET['ot_req'])){
            foreach($_POST['request'] AS $data){
                list($id , $npk, $work_date) = pecahID($data);
                mysqli_query($link, "UPDATE lembur SET `status` = 'a' , status_approve = '25' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$work_date' ")or die(mysqli_error($link));
            }
            ?>
            <script>
                Swal.fire({
                    title: 'Diajukan',
                    text: 'Draft Pengajuan Telah Diajukan',
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
    <?php
    }else{
        
        ?>
        <script>
            Swal.fire({
                title: 'Data Kosong',
                text: 'Pilih Data Pengajuan Yang ingin Diproses',
                timer: 2000,
                
                icon: 'warning',
                showCancelButton: false,
                showConfirmButton: false,
                confirmButtonColor: '#00B9FF',
                cancelButtonColor: '#B2BABB',
                
            })
        </script>
        <?php
        
    }
    */
    
}