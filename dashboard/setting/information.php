<?php
//////////////////////////////////////////////////////////////////////
require_once("../../config/config.php"); 
require_once("../../config/approval_system.php"); 
if(isset($_SESSION['user'])){
    ?>
    <form action="" name="proses" method="POST">
        <div class="table-full-width table-striped ">
            <table class="table ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Information</th>
                        <th>Publisher</th>
                        <th>Reported Date</th>
                        <th>Solved Date</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th class="text-right">Action</th>
                        <th class="text-right">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="allcek">
                                <span class="form-check-sign"></span>
                                </label>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $noInfo = 1;
                    $sqlInfo = mysqli_query($link, "SELECT * FROM info ORDER BY id DESC")or die(mysqli_error($link));
                    if(mysqli_num_rows($sqlInfo)>0){
                        while($dataInfo = mysqli_fetch_assoc($sqlInfo)){
                            $clr = (isset($dataInfo['stats']) && $dataInfo['stats'] == 0)?"muted":"success";
                            $text = (isset($dataInfo['stats']) && $dataInfo['stats'] == 0)?"Not-active":"active";
                            $image = (isset($dataInfo['image']))?$dataInfo['image']:"";
                            $path = "//adm-fs/BODY/BODY02/Body Plant/BAIS/INFO-SUPPORT/$image";
                            $start = (isset($dataInfo['date_start']))?tgl($dataInfo['date_start']):"";
                            $end = (isset($dataInfo['date_end']))?tgl($dataInfo['date_end']):"";
                            
                            if(file_exists($path)){
        
                                $type = pathinfo($path, PATHINFO_EXTENSION);
                                $dataImage = file_get_contents($path);
                                $image = 'data:image/' . $type . ';base64,' . base64_encode($dataImage);
                                $imageSupport = ($image)? $image : "";
                            }else{
                                $imageSupport = base_url()."/assets/img/loading/loading-x.gif";
                            }
                            ?>
                            <tr>
                                <td><?=$noInfo++?></td>
                                <td class="text-nowrap">
                                    <img src="<?=$imageSupport?>" alt="" style="width:50px; height:50px; overflow:hidden">
                                </td>
                                <td class="text-nowrap"><?=$dataInfo['title']?></td>
                                
                                <td><?=$dataInfo['info']?></td>
                                <td class="text-nowrap"><?=$dataInfo['publisher']?></td>
                                <td class="text-nowrap"><?=$start?></td>
                                <td class="text-nowrap"><?=$end?></td>
                                <td class="text-nowrap"><?=$dataInfo['category']?></td>
                                <td class="text-nowrap">
                                    <div class="legend card-category">
                                        <i class="fa fa-circle text-<?=$clr?>"></i>
                                        <span class="category"><?=$text?></span>
                                        
                                    </div>
                                    
                                </td>
                                <td class="text-right text-nowrap">
                                    <a href="proses/prosesInfo.php?del=<?=$dataInfo['id']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>
                                </td>
                                <td class="text-right">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input cek" name="mpchecked[]" type="checkbox" value="<?=$data[$i]['npk']?>">
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    }else{
                        ?>
                        <tr>
                            <td colspan="11" class="text-uppercase text-center">Tiket Problem / Informasi Tidak Ditemukan</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="box pull-right">
            <button  class="btn btn-sm btn-success  activeAll" >
                <span class="btn-label">
                    <i class="nc-icon nc-simple-remove" ></i>
                </span>    
                Active All
            </button>
            <button  class="btn btn-sm btn-warning  activeAll" >
                <span class="btn-label">
                    <i class="nc-icon nc-simple-remove" ></i>
                </span>    
                Solved All
            </button>
        </div>
    </form>
    <?php
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>

