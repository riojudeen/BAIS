<?php
//////////////////////////////////////////////////////////////////////
require("../../../../config/config.php");
if(isset($_GET['value']) || isset($_GET['parent']) ){
    
    $q_data = mysqli_query($link, "SELECT id, nama_org, cord, nama_cord, id_parent FROM view_cord_area WHERE part = 'dept'AND id_parent = '$_GET[parent]' ")or die(mysqli_error($link));
    if($_GET['transfer']){

        switch($level){
            case "8":
                $dis_division = "";
                $dis_dept_acc = "";
                $dis_dept= "";
                $dis_sect = "";
                $dis_group = "";
                $dis_pos = "";
                break;
            case "7":
                $dis_division = "";
                $dis_dept_acc = "";
                $dis_dept= "";
                $dis_sect = "";
                $dis_group = "";
                $dis_pos = "";
                break;
            case "6":
                $dis_division = "";
                $dis_dept_acc = "";
                $dis_dept= "";
                $dis_sect = "";
                $dis_group = "";
                $dis_pos = "";
                break;
            case "5":
                $dis_division = "disabled";
                $dis_dept_acc = "disabled";
                $dis_dept= "";
                $dis_sect = "";
                $dis_group = "";
                $dis_pos = "";
                break;
            
            case "4":
                $dis_division = "disabled";
                $dis_dept_acc = "disabled";
                $dis_dept = "";
                $dis_sect = "";
                $dis_group = "";
                $dis_pos = "";
                break;
            case "3":
                $dis_division = "disabled";
                $dis_dept_acc = "disabled";
                $dis_dept= "disabled";
                $dis_sect = "";
                $dis_group = "";
                $dis_pos = "";
                break;
            case "2":
                $dis_division = "disabled";
                $dis_dept_acc = "disabled";
                $dis_dept= "disabled";
                $dis_sect = "disabled";
                $dis_group = "disabled";
                $dis_pos = "disabled";
                break;
            case "1":
                $dis_division = "disabled";
                $dis_dept_acc = "disabled";
                $dis_dept= "disabled";
                $dis_sect = "disabled";
                $dis_group = "disabled";
                $dis_pos = "disabled";
                break;
        }
    }else{
        $dis_division = "";
        $dis_dept_acc = "";
        $dis_dept= "";
        $dis_sect = "";
        $dis_group = "";
        $dis_pos = "";
    }
    if(mysqli_num_rows($q_data)>0){
        ?>
        <option <?=$dis_dept?> value="-">-</option>
        <?php
        while($data = mysqli_fetch_assoc($q_data)){
            if($_GET['value'] == $data['id']){
                $selected = "selected";
            }else{
                $selected = "";
            }
            ?>
            <option <?=$selected?> <?=$dis_dept?> value="<?=$data['id']?>"><?=$data['nama_org']?> - <?=$data['nama_cord']?> </option>
            <?php
        }
    ?>
    
    <?php
    }else{
        ?>
        <option value="-" <?=$dis_dept?>>-</option>
        <?php
    }
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>