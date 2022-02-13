<?php
require_once("../../../config/config.php");
require_once("../../../config/error.php");
require "../../../_assets/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 
    if(isset($_FILES['file_import']['name']) && in_array($_FILES['file_import']['type'], $file_mimes)) {
    
        $arr_file = explode('.', $_FILES['file_import']['name']);
        $extension = end($arr_file);
    
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        
        $spreadsheet = $reader->load($_FILES['file_import']['tmp_name']);
        $sql = "REPLACE INTO karyawan (npk ,nama_depan , nama , tgl_masuk , jabatan , shift , `status` , department , id_area ) VALUES ";
        $max = mysqli_fetch_assoc(mysqli_query($link, "SELECT max(id_user) AS id FROM data_user"));

        $sqlUser = "REPLACE INTO data_user (`id_user`, `username`, `npk`, `nama`, `pass`, `level`) VALUES ";
        $sqlOrg = "REPLACE INTO `org`(`npk`, `sub_post`, `post`, `grp`, `sect`, `dept`, `dept_account`, `division`, `plant`) VALUES ";

        // $dataUser = "INSERT INTO data_user (npk ,username , nama , pass , `level`, id_user) VALUES ";
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        
        $maxNo = $max['id'];
        for($i = 1;$i < count($sheetData);$i++){
            $npk = $sheetData[$i]['0'];
            $nama = $sheetData[$i]['1'];
            $tgl_msk = $sheetData[$i]['2'];
            $jbtn = $sheetData[$i]['3'];
            $deptA = $sheetData[$i]['4'];
            $shift = $sheetData[$i]['5'];
            $stts = $sheetData[$i]['6'];
            $pos = $sheetData[$i]['7'];
            $group = $sheetData[$i]['8'];
            $sect = $sheetData[$i]['9'];
            $dept = $sheetData[$i]['10'];
            $div = $sheetData[$i]['11'];
            $plant = $sheetData[$i]['12'];
            $idArea = $sheetData[$i]['13'];
            $dt_levelUser = $sheetData[$i]['14'];
            $dt_passUser = $sheetData[$i]['15'];
            $d_idUser = $maxNo+$i;
            $nickpecah = explode(" ",$nama);
            $nick = $nickpecah['0'];
            
            
            if($dt_levelUser == ""){
                $sql_div = mysqli_query($link, "SELECT `id_div`, `nama_divisi`, `npk_cord`, `id_company`, `part` FROM `division` WHERE npk_cord = '$npk'");
                $sql_dept = mysqli_query($link, "SELECT `id_dept`, `dept`, `npk_cord`, `id_div`, `part` FROM `department` WHERE  npk_cord = '$npk'");
                $sql_sect = mysqli_query($link, "SELECT `id_section`, `section`, `npk_cord`, `id_dept`, `part` FROM `section` WHERE npk_cord = '$npk'");
                $sql_grp = mysqli_query($link, "SELECT `id_group`, `nama_group`, `npk_cord`, `id_section`, `part` FROM `groupfrm` WHERE npk_cord = '$npk'");
                if(mysqli_num_rows($sql_div) > 0 || mysqli_num_rows($sql_dept) > 0){
                    $d_levelUser = 'mg';
                }else if(mysqli_num_rows($sql_sect) > 0){
                    $d_levelUser = 'sh';
                }else if(mysqli_num_rows($sql_grp) > 0){
                    $d_levelUser = 'fr';
                }else{
                    $d_levelUser = 'gu';
                }
            }else{
                $d_levelUser = $dt_levelUser;
            }

            if($dt_passUser == ""){
                $passD = explode("-", $tgl_msk);
                $pass = sha1($passD['2'].$passD['1'].$passD['0']);
            }else{
                $pass = $dt_passUser ;
            }
            // $stringUser = substr($pass, 0, 4);
            // $qlevel = union($npk);
            // $level = "gu"; //default
            $userName = "BODY".$npk;
            $sql .= " ('$npk','$nick','$nama','$tgl_msk','$jbtn','$shift','$stts','$deptA','$idArea'),";
            $sqlUser .= " ('$d_idUser','$userName','$npk','$nama','$pass','$d_levelUser'),";
            $sqlOrg .= " ('$npk','','$pos','$group','$sect','$dept','$deptA','$div','$plant'),";
            // $cekUser = mysqli_num_rows(mysqli_query($link, "SELECT * FROM data_user WHERE npk = '$npk'"));
            // if($cekUser == 0){
            //     $maxNo++;
            //     $dataUser .= " ('$npk', '$userName', '$nama', '$pass', '$level','$maxNo'),";
            // }
            

        }
        $sql = substr($sql, 0 , -1); //untuk trim koma terakhir
        $sqlUser = substr($sqlUser, 0 , -1); //untuk trim koma terakhir
        $sqlOrg = substr($sqlOrg, 0 , -1); //untuk trim koma terakhir
        // $sqlUser = substr($dataUser, 0 , -1); //untuk trim koma terakhir
        $total = count($sheetData) - 1;
        $data = mysqli_query($link, $sql);
        $data_user = mysqli_query($link, $sqlUser);
        $data_org = mysqli_query($link, $sqlOrg);
        // echo $sql;
        
        // echo $sqlUser;
        if($data && $data_user && $data_org){
          
            // mysqli_query($link, $sqlUser)or die(mysqli_error($link));
            $_SESSION['info'] = "Disimpan";
            $_SESSION['pesan'] = "$total";
            header("Location: ../manpower.php"); 
        }else{
            $_SESSION['info'] = "Import Gagal";
            
            $_SESSION['pesan'] = error(mysqli_errno($link),mysqli_error($link), "karyawan") ;
            header("Location: ../manpower.php");
        }
    }else{
        // $_SESSION['info'] = "Kosong";
        // header("Location: ../manpower.php");
    }
?>