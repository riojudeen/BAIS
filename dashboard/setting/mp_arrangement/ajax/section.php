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
                        <a class="btn btn-sm btn-link btn-round btn-info sect-<?=$active_tab?> datasect <?=$data_active?> <?=$active_tab?>" href="#info" role="tab" data-id="<?=$data['id']?>" id="<?=$data['id']?>" data-toggle="tab"><?=$data['nama_org']?></a>
                    </li>

                    <?php
                }
                ?>
            </ul>
            </div>
            <script>
                $(document).ready(function(){
                    if($(".section-active")[0]){
                        var id = $('.section-active').attr('id');
                        var dept = $('.data-active').attr('id')
                        $('.tampil-data').load("ajax/index.php?section="+id+"&dept="+dept);
                    }else{
                        var dept = $('.data-active').attr('id')
                        $('.tampil-data').load("ajax/index.php?section=none&dept="+dept);
                    }
                    $('.datasect').click(function(){
                        var id = $(this).attr('data-id');
                        var dept = $('.data-active').attr('id')
                        $('.tampil-data').load("ajax/index.php?section="+id+"&dept="+dept);
                    })
                })
            </script>
        <?php
    }else{
        ?>
        <script>
            $(document).ready(function(){
                var dept = $('.data-active').attr('id')
                $('.tampil-data').load("ajax/index.php?section=none&dept="+dept);
            })
            
            // if($(".section-active")[0]){
            //     $('.tampil-data').load("ajax/index.php?section="+id);
            // }else{
                
            // }
        </script>
        <?php
    }
}
?>
