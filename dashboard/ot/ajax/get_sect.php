<?php

//////////////////////////////////////////////////////////////////////
include("../../../config/config.php");
if(isset($_SESSION['user'])){
    if($level >=1 && $level <=8){
        require_once("../../../config/approval_system.php");
        $level = $level;
        $npk = $npkUser;
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
        // echo $level."<br>";
        // echo $npk."<br>";
        // echo $sub_post."<br>";
        // echo $post."<br>";
        // echo $group."<br>";
        // echo $sect."<br>";
        // echo $dept."<br>";
        // echo $dept_account."<br>";
        // echo $plant."<br>";
        $access_org = orgAccess($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        // $add_filter = filterData($div_filter , $dept_filter, $sect_filter, $group_filter, $deptAcc_filter, $shift, $cari);
        
        ?>
        <option value="">Pilih Section</option>
        <?php
        if($access_org == 'sect'){
            $query = $generate;
            $sql = mysqli_query($link, $query)or die(mysqli_error($link));
            if(mysqli_num_rows($sql)>0){
                while($data = mysqli_fetch_assoc($sql)){
                    $query_org = mysqli_query($link, "SELECT nama_org, id FROM view_daftar_area WHERE id = '$data[data]' AND part = 'section' ")or die(mysqli_error($link));
                    $data_org = mysqli_fetch_assoc($query_org);
                ?>
                <option value="<?=$data_org['id']?>"><?=$data_org['nama_org']?></option>
                <?php
                }
            }else{
                ?>
                <option value=""><?=noData()?></option>
                <?php
            }
        }else{
            
            if($access_org == 'dept' || $access_org == 'division' ){
                $query_org = mysqli_query($link, "SELECT nama_org, id FROM view_daftar_area WHERE part = 'section' AND id_parent = '$_GET[data]' ")or die(mysqli_error($link));
            }else{
                $query_org = mysqli_query($link, "SELECT nama_org, id FROM view_daftar_area WHERE id = '$sect' AND part = 'section' ")or die(mysqli_error($link));
            }
            if(mysqli_num_rows($query_org)>0){
                while($data = mysqli_fetch_assoc($query_org)){
                ?>
                <option value="<?=$data['id']?>"><?=$data['nama_org']?></option>
                <?php
                }
            }else{
                ?>
                <option value=""><?=noData()?></option>
                <?php
            }
        }
        

    }else{
        include_once ("../../no_access.php");
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>