<?php
require_once("../../../config/config.php");
    if(isset($_POST['id'])){
        $i = $_POST['id'];
        $id_status = $_POST['val'];
        if($id_status == "TM"){
            ?>
            <select class="selectpicker status" data-size="7" name="status[]" data-style="btn btn-warning btn-link border bg-white" title="Status" data-width="100px" id="status<?=$i?>" data-id="<?=$i?>">
                <option disabled>Pilih Status</option>
                <?php
                $optStatus = mysqli_query($link, "SELECT * FROM status_mp ORDER BY `level` ASC")or die(Mysqli_error($link));
                while($dStatus = mysqli_fetch_assoc($optStatus)){
                    ?>
                    <option title="<?=$dStatus['id']?>" value="<?=$dStatus['id']?>"><?=$dStatus['status_mp']?></option>
                    <?php
                    
                }
                ?>
                </select>
                <?php
        }else{
            ?>
            <select class="selectpicker status" data-size="7" name="status[]" data-style="btn btn-warning btn-link border bg-white" title="Status" data-width="100px" id="status<?=$i?>" data-id="<?=$i?>">
                <option disabled>Pilih Status</option>
                <?php
                $optStatus = mysqli_query($link, "SELECT * FROM status_mp ORDER BY `level` ASC")or die(Mysqli_error($link));
                while($dStatus = mysqli_fetch_assoc($optStatus)){
                    if($dStatus['id'] != "P"){
                        $select = "disabled";
                    }else{
                        $select = "selected";
                    }
                    ?>
                    <option <?=$select?> title="<?=$dStatus['id']?>" value="<?=$dStatus['id']?>"><?=$dStatus['status_mp']?></option>
                    <?php
                    
                }
                ?>
            </select>
            <?php
        
        }
        
            
    }
    ?>
    <script>
        $(function () {
            $('.status').selectpicker();
            
        });
    </script>
