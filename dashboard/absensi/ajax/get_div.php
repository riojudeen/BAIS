<?php

//////////////////////////////////////////////////////////////////////
include("../../../config/config.php");
if(isset($_SESSION['user'])){
    if($level >=1 && $level <=8){
        require_once("../../../config/approval_system.php");
        $level = $level;
        $npk = $npkUser;
        list($npk, $sub_post, $post, $group, $sect,$dept,$dept_account,$div,$plant) = dataOrg($link,$npk);
        
        $access_org = orgAccess($level);
        $data_access = generateAccess($link,$level,$npk);
        $table = partAccess($level, "table");
        $field_request = partAccess($level, "field_request");
        $table_field1 = partAccess($level, "table_field1");
        $table_field2 = partAccess($level, "table_field2");
        $part = partAccess($level, "part");
        $generate = queryGenerator($level, $table, $field_request, $table_field1, $table_field2, $part, $npk, $data_access);
        
        ?>
        <option value="">Pilih Division</option>
        <?php
        if($access_org == 'division'){
            $query = $generate;
            $sql = mysqli_query($link, $query)or die(mysqli_error($link));
            if(mysqli_num_rows($sql)>0){
                while($data = mysqli_fetch_assoc($sql)){
                    $query_org = mysqli_query($link, "SELECT nama_org, id FROM view_daftar_area WHERE id = '$data[data]' AND part = 'division' ")or die(mysqli_error($link));
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
            $query_org = mysqli_query($link, "SELECT nama_org, id FROM view_daftar_area WHERE id = '$div' AND part = 'division' ")or die(mysqli_error($link));
            
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