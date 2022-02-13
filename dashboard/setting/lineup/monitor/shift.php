<?php

//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
?>
<ul id="tabs" class="nav nav-tabs flex-column nav-stacked text-left" role="tablist">
<?php
    $q_prodArea = mysqli_query($link, "SELECT * FROM view_production_area WHERE id_model = '$_GET[model]' GROUP BY shift ORDER BY shift ASC")or die(mysqli_error($link));
    // $queryShift = mysqli_query($link,"SELECT * FROM shift WHERE production = '1'")or die(mysqli_error($Link));
    if(mysqli_num_rows($q_prodArea)>0){
        $index = 0;
        $no = 0;
        while($dataShiftProd = mysqli_fetch_assoc($q_prodArea)){
            if($index == $no++){
                $active = "active";
                $tab_active = "shift-active";
            }else{
                $active = "";
                $tab_active = "";
            }
            ?>
            <li class="nav-item  ">
                <a class="btn btn-sm btn-link btn-round btn-info navigasi_data shift <?=$tab_active?> <?=$active?>"  data-toggle="tab" data-id="<?=$dataShiftProd['shift']?>" href="#model" role="tab" aria-expanded="true">shift <?=$dataShiftProd['shift']?></a>
            </li>
            <?php
        }
    }

    ?>
    </ul>


<?php
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
<script>
    $(document).ready(function(){
        $('.shift').click(function(){
            var id = $('.data-active').attr('id');
            var dataShift = $(this).attr('data-id');
            // console.log(id)
            $('.data-monitor').load("monitor/index.php?shift="+dataShift+"&model="+id);
        })
    })
    
</script>
<script>
    $(document).ready(function(){
        if($(".data-active")[0]){
            var id = $('.data-active').attr('id');
            var dataShift = $('.shift-active').attr('data-id');
            // console.log(id);
            $('.data-monitor').load("monitor/index.php?shift="+dataShift+"&model="+id);
        }
    })
</script>