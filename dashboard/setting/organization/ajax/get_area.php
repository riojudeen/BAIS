<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php"); 
require_once("../../../../config/approval_system.php"); 
if(isset($_SESSION['user'])){
    $data = (isset($_POST['data']))?$_POST['data']:'';
    $part = (isset($_POST['part']))?$_POST['part']:'';
    if($part == 'division'){
        $subpart = 'dept';
    }else if($part == 'dept'){
        $subpart = 'section';
    }else if($part == 'section'){
        $subpart = 'group';
    }else if($part == 'group'){
        $subpart = 'pos';
    }
    // echo $data;
    $area = getOrgName($link, $data, $part);
    $q_area = mysqli_query($link, "SELECT `nama_org` , `cord`, `nama_cord` FROM view_cord_area WHERE id = '$data' AND part = '$part' ")or die(mysqli_error($link));
    $dataArea = mysqli_fetch_assoc($q_area);

    ?>
    <div class="form-group">
        <input type="text" disabled class="form-control text-center" name="name" value="<?=$dataArea['nama_org']?>" >
        <input type="hidden" class="form-control" name="part" value="<?=$subpart?>" >
        <input type="hidden" class="form-control" name="id_parent" value="<?=$_POST['data']?>" >
    </div>
    <div class="table-full-width">
        
                <?php
                $queryArea = mysqli_query($link, "SELECT `nama_org` , `cord`, `nama_cord` FROM view_cord_area WHERE id_parent = '$data' AND part = '$subpart' ")or die(mysqli_error($link));
                if(mysqli_num_rows($queryArea)> 0){
                    ?>
                    <table class="table text-uppercase">
                        <thead>
                            <tr>
                                <th colspan="4">Sub Area</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    $no = 1;
                    while($dataArea = mysqli_fetch_assoc($queryArea)){
                        $namaArea = (isset($dataArea['nama_org']))?$dataArea['nama_org']:'';
                        $cord = (isset($dataArea['cord']))?$dataArea['cord']:'';
                        $nama_cord = (isset($dataArea['nama_cord']))?' - '.$dataArea['nama_cord']:'N/A data Coord';
                        $color = (isset($dataArea['nama_cord']))?'success':'warning';
                        ?>
                        
                        <tr>
                            <td><?=$no++?></td>
                            <td><?=$namaArea?> <label class="badge badge-sm badge-<?=$color?> badge-pill badge-round"><?=$nama_cord?></label></td>
                            <td>
                                <a href="" class="btn btn-success btn-sm btn-round btn-icon"><i class="nc-icon nc-simple-add"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                    <?php
                }else{
                    ?>
                    
                    <?php
                }
                ?>
                
            
    </div>
    <hr>
    
    <!--  -->

    <?php
}else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}