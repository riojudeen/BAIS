<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
if(isset($_GET['id']) && ($_GET['id'] != "-")){
    $id = $_GET['id'];
    $sect = $_GET['name'];
    ?>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-stats border border-info">
                <div class="card-body " id="2">
                    <div class="row">
                        <div class="col-5 col-md-4 ">
                            <div class="icon-big text-center icon-info">
                                <span class="fa-stack text-primary" >
                                    <i class="fas fa-sitemap fa-stack-1x fa-inverse mt-1 text-primary"></i>
                                
                                    <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                    <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                </span>
                        
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers ">
                                <p class="card-title text-primary ">53<p>
                                <p class="card-category text-right text-primary mb-3">Group Area</p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-stats border border-info">
                <div class="card-body " id="2">
                    <div class="row">
                        <div class="col-5 col-md-4 ">
                            <div class="icon-big text-center icon-info">
                                <span class="fa-stack text-primary" >
                                    <i class="fas fa-hard-hat fa-stack-1x fa-inverse mt-1 text-primary"></i>
                                
                                    <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                    <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                </span>
                        
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers ">
                                <p class="card-title text-primary ">53<p>
                                <p class="card-category text-right text-primary mb-3">Foreman</p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-stats border border-info">
                <div class="card-body " id="2">
                    <div class="row">
                        <div class="col-5 col-md-4 ">
                            <div class="icon-big text-center icon-info">
                                <span class="fa-stack text-primary" >
                                    <i class="fas fa-hard-hat fa-stack-1x fa-inverse mt-1 text-primary"></i>
                                
                                    <!-- <i class="far fa-circle fa-stack-2x fa-inverse mt-1"></i>
                                    <i class="fas fa-cogs fa-stack-1x fa-inverse mt-1"></i> -->
                                </span>
                        
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers ">
                                <p class="card-title text-primary ">53<p>
                                <p class="card-category text-right text-primary mb-3">Team Leader</p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="data-mp">
            <div class="row">
                <h6 class="card-title col-md-6 pull-left text-uppercase" >arrangement man power</h6>
            </div>
            <hr>
            <?php
            $q_section = mysqli_query($link, "SELECT * FROM section WHERE id_section = '$id' ")or die(mysqli_error($link));
            if(mysqli_num_rows($q_section) > 0){
                while($data_section = mysqli_fetch_assoc($q_section)){
                    ?>
                    <div class=" table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <th rowspan="2">#</th>
                                <th rowspan="2">Group</th>
                                <th rowspan="2">FRM</th>
                                <th rowspan="2">TL</th>
                                <th >Σ TM</th>
                                <th>K1</th>
                                <th>K2</th>
                                <th>P</th>
                                <th>Σ MP</th>
                                <th rowspan="2" class="text-right">action</th>
                            </thead>
                            <tbody>
                                <?php
                            
                                $q_groupfrm = mysqli_query($link,"SELECT * FROM groupfrm WHERE id_section = '$data_section[id_section]' ")or die(mysqli_error($link));
                                if(mysqli_num_rows($q_groupfrm) > 0){
                                    $no = 1;
                                    while($data_group = mysqli_fetch_assoc($q_groupfrm)){
                                        $q_total = mysqli_query($link, "SELECT npk FROM org WHERE grp = '$data_group[id_group]' GROUP BY npk")or die(mysqli_error($link));
                                        $total = mysqli_num_rows($q_total);
                                        $q_frm = mysqli_query($link, "SELECT npk FROM org WHERE grp = '$data_group[id_group]' GROUP BY npk")or die(mysqli_error($link));
                                        $q_teamleader = mysqli_query($link, "SELECT post FROM org WHERE grp = '$data_group[id_group]' GROUP BY post")or die(mysqli_error($link));
                                        $q_tm = "SELECT sub_post, `status` FROM org 
                                        JOIN karyawan ON karyawan.npk = org.npk ";
                                        $sql_k1 = mysqli_query($link, $q_tm."  WHERE `status` = 'K1' AND karyawan.jabatan = 'TM' AND org.grp = '$data_group[id_group]' GROUP BY org.npk")or die(mysqli_error($link));
                                        $sql_k2 = mysqli_query($link, $q_tm."  WHERE `status` = 'K2' AND karyawan.jabatan = 'TM' AND org.grp = '$data_group[id_group]' GROUP BY org.npk")or die(mysqli_error($link));
                                        $sql_p = mysqli_query($link, $q_tm."  WHERE `status` = 'P' AND karyawan.jabatan = 'TM' AND org.grp = '$data_group[id_group]' GROUP BY org.npk")or die(mysqli_error($link));
                                        
                                        $q_team_member = mysqli_query($link, "SELECT npk, sub_post FROM org WHERE post = '$data_group[id_group]' GROUP BY npk")or die(mysqli_error($link));
                                        
                                        $jml_tm = (mysqli_num_rows($q_team_member) != 0 )? mysqli_num_rows($q_team_member) : 0;
                                        $jml_tm1 = (mysqli_num_rows($sql_k1) !=0)?mysqli_num_rows($sql_k1):0;
                                        $jml_tm2 = (mysqli_num_rows($sql_k2) != 0)?mysqli_num_rows($sql_k2):0;
                                        $jml_p = (mysqli_num_rows($sql_p) != 0)?mysqli_num_rows($sql_p):0;
                                        $jml_tl = (mysqli_num_rows($q_teamleader) != 0)?mysqli_num_rows($q_teamleader):0;
                                        $jml_frm = (mysqli_num_rows($q_frm) != 0)?mysqli_num_rows($q_frm):0;
                                        
                                        ?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$data_group['nama_group']?></td>
                                            <td><?=$jml_frm?></td>
                                            <td><?=$jml_tl?></td>
                                            <td><?=$jml_tm?></td>
                                            <td><?=$jml_tm1?></td>
                                            <td><?=$jml_tm2?></td>
                                            <td><?=$jml_p?></td>
                                            <td><?=$total?></td>
                                            <td class="text-right">
                                                <span class="btn btn-sm btn-success btn-icon btn-round viewdetail" data-id="<?=$data_group['id_group']?>" data-toggle="modal" data-target="#detail">
                                                    <i class="fas fa-user"></i> 
                                                </span>
                                                <span class="dropdown dropleft text-right">
                                                    <button class="btn btn-sm btn-light btn-link btn-icon btn-round" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <!-- <div class="dropdown-header">Action</div> -->
                                                        <a class="dropdown-item" href="proses/export.php?export=organization">Edit</a>
                                                        <a class="dropdown-item" href="file/Format_Register_Area.xlsx" >Delete</a>
                                                        <a class="dropdown-item" href="file/Format_Register_Area.xlsx" >Detail</a>
                                                    </div>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }else{
                                    ?>
                                    <tr>
                                        <td class="text-uppercase text-center" colspan="10">
                                            Belum ada register group untuk section <?=$sect?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

<?php
}
?>