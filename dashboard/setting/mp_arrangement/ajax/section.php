<?php

//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $q_section = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'section' AND id_parent = '$id' ")or die(mysqli_error($link));

    ?>
    <?php
    if(mysqli_num_rows($q_section) > 0){
        ?>
            <div class="nav-tabs-wrapper list_section">
                <ul class="nav nav-tabs flex-column nav-stacked" role="tablist">
                <?php
                $index = 1;
                while($data = mysqli_fetch_assoc($q_section)){
                    $active_tab = ($index == 1)?"active":"";
                    $data_active = ($index == 1)?"section-active":"";
                    $index++;
                    ?>
                    
                    <li class="nav-item ">
                        <a class="btn btn-sm btn-link btn-round btn-warning  sect-<?=$active_tab?> datasect <?=$data_active?> <?=$active_tab?>" href="#info" role="tab" data-id="<?=$data['id']?>" data-name="<?=$data['nama_org']?>" id="<?=$data['id']?>" data-toggle="tab"><?=$data['nama_org']?></a>
                        <ul class="nav nav-tabs  flex-column nav-stacked d-none group group<?=$data['id']?> mt-0 ml-3 pt-0" role="tablist">
                            <?php
                                $q_group = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'group' AND id_parent = '$data[id]' ")or die(mysqli_error($link));
                                if(mysqli_num_rows($q_group)>0){
                                    while($data_group = mysqli_fetch_assoc($q_group)){
                                        ?>
                                        <li class="nav-item ">
                                            <a class="btn btn-sm btn-link btn-round btn-primary  datagroup " href="#info" role="tab" data-id="<?=$data_group['id']?>" id="<?=$data_group['id']?>" data-toggle="tab" data-name="<?=$data_group['nama_org']?>">- <?=$data_group['nama_org']?></a>
                                        </li>
                                        <?php
                                    }
                                }else{
                                    ?>
                                    <li class="nav-item ">
                                        <a class="btn btn-sm btn-link btn-round btn-danger" href="#info" role="tab" data-id="" id="" data-toggle="tab">- tidak ada -</a>
                                    </li>
                                    <?php
                                }
                            ?>
                            
                        </ul>
                    </li>

                    <?php
                }
                ?>
            </ul>
            </div>
            
        <?php
    }
}
?>
