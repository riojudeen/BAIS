<?php
//////////////////////////////////////////////////////////////////////
require("../../../../config/config.php");
// if(isset($_GET['id'])){
    $q_data = mysqli_query($link, "SELECT id, nama_org, cord , nama_cord, id_parent FROM view_cord_area WHERE part = 'division' ")or die(mysqli_error($link));
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
        <option value="-" <?=$dis_division?>>Pilih Division</option>
        <?php
        while($data = mysqli_fetch_assoc($q_data)){
            if($_GET['value'] == $data['id']){
                $selected = "selected";
            }else{
                $selected = "";
            }
            ?>
            <option <?=$selected?> <?=$dis_division?> value="<?=$data['id']?>"><?=$data['nama_org']?> - <?=$data['nama_cord']?></option>
            <?php
        }
    ?>
    <option value="-" <?=$dis_division?> >-</option>
    <?php
    }else{
        ?>
        <option value="-">-</option>
        <?php
    }
   

// }else{
    // echo "<script>window.location='".base_url('auth/login.php')."';</script>";
// }
?>