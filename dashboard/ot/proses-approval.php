<?php
require_once("../../config/config.php");
require_once("../../config/approval_system.php");
require_once("../../config/schedule_system.php");
if(isset($_SESSION['user']) && $level >=1 && $level <=8){
    
    // proses satuan
    if(isset($_GET['approve'])){
        $data = $_GET['approve'];
        list($id, $npk, $date) = pecahID($data);
        $query = "UPDATE lembur SET status_approve = '50' , `status` = 'a' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
        $sql = mysqli_query($link, $query);
        if($sql){
            $response["message"] = "Diapprove";
            $response["info"] = "data berhasil diproses";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Kesalahan";
            $response["info"] = "terjadi kesalahan sistem (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
        
    }else if(isset($_GET['proses'])){
        $data = $_GET['proses'];
        list($id, $npk, $date) = pecahID($data);
        $query = "UPDATE lembur SET status_approve = '75' , `status` = 'a' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
        $sql = mysqli_query($link, $query);
        if($sql){
            $response["message"] = "Diproses";
            $response["info"] = "data berhasil diproses";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Approve";
            $response["info"] = "terjadi kesalahan sistem (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
        
    }else if(isset($_GET['return'])){
        $data = $_GET['return'];
        list($id, $npk, $date) = pecahID($data);
        $query = "UPDATE lembur SET status_approve = '100' , `status` = 'd' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
        $sql = mysqli_query($link, $query);
        if($sql){
            $response["message"] = "Dikembalikan";
            $response["info"] = "data telah dikembalikan untuk dicheck kembali oleh pimpinan area";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Approve";
            $response["info"] = "terjadi kesalahan sistem (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
        
    }else if(isset($_GET['stop'])){
        $data = $_GET['stop'];
        list($id, $npk, $date) = pecahID($data);
        $query = "UPDATE lembur SET status_approve = '100' , `status` = 'c' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
        $sql = mysqli_query($link, $query);
        if($sql){
            $response["message"] = "Dihentikan";
            $response["info"] = "data pengajuan telah dihentikan";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Kesalahan";
            $response["info"] = "terjadi kesalahan sistem (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
        
    }else if(isset($_GET['reject'])){
        $data = $_GET['reject'];
        list($id, $npk, $date) = pecahID($data);
        $query = "UPDATE lembur SET status_approve = '100' , `status` = 'b' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
        $sql = mysqli_query($link, $query);
        if($sql){
            $response["message"] = "Ditolak";
            $response["info"] = "data pengajuan telah ditolak";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Kesalahan";
            $response["info"] = "terjadi kesalahan sistem (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
        
    }else if(isset($_GET['del'])){
        $data = $_GET['del'];
        list($id, $npk, $date) = pecahID($data);
        $query = "DELETE FROM lembur WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
        $sql = mysqli_query($link, $query);
        if($sql){
            $response["message"] = "Dihapus";
            $response["info"] = "data pengajuan telah dihapus dan dapat diajukan kembali";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Kesalahan";
            $response["info"] = "terjadi kesalahan sistem (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
        
    }else if(isset($_GET['approve_multiple'])){
        $total = 0;
        foreach($_POST['checked'] AS $data){
            list($id, $npk, $date) = pecahID($data);
            $query = "UPDATE lembur SET status_approve = '50' , `status` = 'a' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
            $sql = mysqli_query($link, $query);
            $total++;
        }
        $total = $total;
        if($sql & $total > 0 ){
            $response["message"] = "Diapprove";
            $response["info"] = "$total data berhasil diproses";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Approve";
            $response["info"] = "$total data gagal diproses (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
    }else if(isset($_GET['reject_multiple'])){
        $total = 0;
        foreach($_POST['checked'] AS $data){
            list($id, $npk, $date) = pecahID($data);
            $query = "UPDATE lembur SET status_approve = '100' , `status` = 'b' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
            $sql = mysqli_query($link, $query);
            $total++;
        }
        $total = $total;
        if($sql & $total > 0 ){
            $response["message"] = "Rejected";
            $response["info"] = "$total data berhasil diproses";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Ditolak";
            $response["info"] = "$total data gagal diproses (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
    }else if(isset($_GET['proses_multiple'])){
        $total = 0;
        foreach($_POST['checked'] AS $data){
            list($id, $npk, $date) = pecahID($data);
            $query = "UPDATE lembur SET status_approve = '75' , `status` = 'a' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
            $sql = mysqli_query($link, $query);
            $total++;
        }
        $total = $total;
        if($sql & $total > 0 ){
            $response["message"] = "Diproses";
            $response["info"] = "$total data berhasil diproses";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Diproses";
            $response["info"] = "$total data gagal diproses (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
    }else if(isset($_GET['stop_multiple'])){
        $total = 0;
        foreach($_POST['checked'] AS $data){
            list($id, $npk, $date) = pecahID($data);
            $query = "UPDATE lembur SET status_approve = '100' , `status` = 'c' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
            $sql = mysqli_query($link, $query);
            $total++;
        }
        $total = $total;
        if($sql & $total > 0 ){
            $response["message"] = "Dihentikan";
            $response["info"] = "$total data berhasil diproses";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Dikembalikan";
            $response["info"] = "$total data gagal diproses (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
    }else if(isset($_GET['delete_multiple'])){
        $total = 0;
        foreach($_POST['checked'] AS $data){
            list($id, $npk, $date) = pecahID($data);
            $query = "DELETE FROM lembur WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
            $sql = mysqli_query($link, $query);
            $total++;
        }
        $total = $total;
        if($sql & $total > 0 ){
            $response["message"] = "Dihapus";
            $response["info"] = "$total data berhasil diproses";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Dihapus";
            $response["info"] = "$total data gagal diproses (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
    }else if(isset($_GET['return_multiple'])){
        $total = 0;
        foreach($_POST['checked'] AS $data){
            list($id, $npk, $date) = pecahID($data);
            $query = "UPDATE lembur SET status_approve = '100' , `status` = 'd' WHERE _id = '$id' AND npk = '$npk' AND work_date = '$date' ";
            $sql = mysqli_query($link, $query);
            $total++;
        }
        $total = $total;
        if($sql & $total > 0 ){
            $response["message"] = "Dikembalikan";
            $response["info"] = "$total data telah dikembalikan untuk dicek kembali oleh pimpinan area";
            $response["icon"] = "success";
            $response["data_query"] = $query;
            echo json_encode($response);
        }else {
            $response["message"]="Gagal Dihapus";
            $response["info"] = "$total data gagal diproses (".mysqli_error($link).")";
            $response["icon"] = "warning";
            $response["data_query"] = $query;
            echo json_encode($response);
        }
    }else{
        $response["message"]="Gagal Dihapus";
        $response["info"] = "$total data gagal diproses (Null Parameter)";
        $response["icon"] = "warning";
        $response["data_query"] = "";
        echo json_encode($response);
    }
}