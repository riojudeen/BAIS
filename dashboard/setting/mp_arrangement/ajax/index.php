<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
// $_GET['section'] = '1-001-001-001';
if(isset($_SESSION['user'])  ){
    if(isset($_GET['section']) && isset($_GET['dept']) && $_GET['section'] !== "none"){
        $id = $_GET['section'];
        // echo "$id";
        $query = "SELECT * FROM view_employee_sumary WHERE parent = '$id'";
        $queryJml = "SELECT * FROM view_employee_sumary WHERE parent = '$id' GROUP BY id";
        $sql_jml = mysqli_query($link, $queryJml)or die(mysqli_error($link));
        $jmlGroup = mysqli_num_rows($sql_jml);
        $sql = mysqli_query($link, $query)or die(mysqli_error($link));
        $data = mysqli_fetch_assoc($sql);
        $dataIdl = $data['mp'];
        $dataDl = $data['dl'];
        // fhfjfjkjgj
        ?>

        <div class="card shadow-none border ">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Group</label>
                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                            <select name="filterGroup" id="filterGroup" class="form-control filterGroup text-uppercase">
                                <?php
                                $query_Group = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'group' AND id_parent = '$id' ")or die(mysqli_error($link));
                                if(mysqli_num_rows($query_Group) > 0){
                                    while($dataGroup = mysqli_fetch_assoc($query_Group)){
                                        ?>
                                        <option value="<?=$dataGroup['id']?>"><?=$dataGroup['nama_org']?></option>
                                        <?php
                                    }
                                    ?>
                                    <option value="0" selected>Tampilkan Semua</option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="0" selected >Tampilkan Semua</option>
                                    <option disabled >belum ada data</option>
                                    <?php
                                }
                                ?>
                        </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">Department Administratif</label>
                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                            <select name="filterDeptAcc" id="filterDeptAcc" class="form-control filterDeptAcc text-uppercase">
                                <?php
                                $query_deptAcc = mysqli_query($link, "SELECT * FROM view_daftar_area WHERE part = 'deptAcc' ")or die(mysqli_error($link));
                                if(mysqli_num_rows($query_deptAcc) > 0){
                                    while($dataDeptAcc = mysqli_fetch_assoc($query_deptAcc)){
                                        ?>
                                        <option value="<?=$dataDeptAcc['id']?>"><?=$dataDeptAcc['nama_org']?></option>
                                        <?php
                                    }
                                    ?>
                                    <option value="0" selected>Tampilkan Semua</option>
                                    <?php
                                }else{
                                    ?>
                                    <option disabled >belum ada data</option>
                                    <?php
                                }
                                ?>
                        </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">Shift</label>
                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                            <select name="filterShift" id="filterShift" class="form-control filterShift text-uppercase">
                                <?php
                                $query_shift = mysqli_query($link, "SELECT * FROM shift ")or die(mysqli_error($link));
                                if(mysqli_num_rows( $query_shift) > 0){
                                    while($dataShift = mysqli_fetch_assoc( $query_shift)){
                                        ?>
                                        <option value="<?=$dataShift['id_shift']?>"><?=$dataShift['shift']?></option>
                                        <?php
                                    }
                                    ?>
                                    <option value="0" selected>Tampilkan Semua</option>
                                    <?php
                                }else{
                                    ?>
                                    <option disabled >belum ada data</option>
                                    <?php
                                }
                                ?>
                        </select>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                    <p class="card-title text-primary "><?=$jmlGroup?><p>
                                    <p class="card-category text-right text-primary mb-3">Group</p>
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
                                    <p class="card-title text-primary "><?=$dataDl?><p>
                                    <p class="card-category text-right text-primary mb-3">Direct Labour</p>
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
                                    <p class="card-title text-primary "><?=$dataIdl?><p>
                                    <p class="card-category text-right text-primary mb-3">Indirect Labour</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="graph" >
                    
                    <canvas class="" id="dataArr" width="456" height="150" ></canvas>
                </div>
            </div>
        </div>
        <hr>
   
        <div class="row">
            <div class="col-md-12" id="data-mp">
                <div class="row">
                    <h6 class="card-title col-md-6 pull-left text-uppercase" >Summary man power</h6>
                </div>
                <?php
                $q_section = mysqli_query($link, "SELECT * FROM section WHERE id_section = '$id' ")or die(mysqli_error($link));
                if(mysqli_num_rows($q_section) > 0){
                    while($data_section = mysqli_fetch_assoc($q_section)){
                        ?>
                        <div class="">
                            <table class="table table-hover table-bordered">
                                <thead class="table-info">
                                    <th >#</th>
                                    <th width="250">Group</th>
                                    <th width="70">FRM</th>
                                    <th width="70">TL</th>
                                    <th width="70">TM K1</th>
                                    <th width="70">TM K2</th>
                                    <th width="70">TM P</th>
                                    <th width="70">Σ MP</th>
                                    <th class="">action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $q_groupfrm = mysqli_query($link,"SELECT * FROM groupfrm WHERE id_section = '$data_section[id_section]' ")or die(mysqli_error($link));
                                    if(mysqli_num_rows($q_groupfrm) > 0){
                                        $no = 1;
                                        while($data_group = mysqli_fetch_assoc($q_groupfrm)){
                                            $q_total = mysqli_query($link, "SELECT npk FROM org WHERE grp = '$data_group[id_group]' GROUP BY npk")or die(mysqli_error($link));
                                            $total = mysqli_num_rows($q_total);
                                            // $q_frm = mysqli_query($link, "SELECT npk FROM org WHERE grp = '$data_group[id_group]' GROUP BY npk")or die(mysqli_error($link));
                                            // $q_teamleader = mysqli_query($link, "SELECT post FROM org WHERE grp = '$data_group[id_group]' GROUP BY npk")or die(mysqli_error($link));
                                            $q_tm = "SELECT sub_post, `status` FROM org 
                                            JOIN karyawan ON karyawan.npk = org.npk ";
                                            $sql_k1 = mysqli_query($link, $q_tm."  WHERE `status` = 'C1' AND karyawan.jabatan = 'TM' AND org.grp = '$data_group[id_group]' GROUP BY org.npk")or die(mysqli_error($link));
                                            $sql_k2 = mysqli_query($link, $q_tm."  WHERE `status` = 'C2' AND karyawan.jabatan = 'TM' AND org.grp = '$data_group[id_group]' GROUP BY org.npk")or die(mysqli_error($link));
                                            $sql_p = mysqli_query($link, $q_tm."  WHERE `status` = 'P' AND karyawan.jabatan = 'TM' AND org.grp = '$data_group[id_group]' GROUP BY org.npk")or die(mysqli_error($link));
                                            $sql_tl = mysqli_query($link, $q_tm."  WHERE (karyawan.jabatan = 'TL' OR  karyawan.jabatan = 'ATL') AND org.grp = '$data_group[id_group]' GROUP BY org.npk")or die(mysqli_error($link));
                                            $sql_frm = mysqli_query($link, $q_tm."  WHERE (karyawan.jabatan = 'FRM' OR  karyawan.jabatan = 'AFRM') AND org.grp = '$data_group[id_group]' GROUP BY org.npk")or die(mysqli_error($link));
                                            
                                            $q_team_member = mysqli_query($link, "SELECT npk, sub_post FROM org WHERE post = '$data_group[id_group]' GROUP BY npk")or die(mysqli_error($link));
                                            
                                            $jml_tm = (mysqli_num_rows($q_team_member) != 0 )? mysqli_num_rows($q_team_member) : 0;
                                            $jml_tm1 = (mysqli_num_rows($sql_k1) !=0)?mysqli_num_rows($sql_k1):"";
                                            $jml_tm2 = (mysqli_num_rows($sql_k2) != 0)?mysqli_num_rows($sql_k2):"";
                                            $jml_p = (mysqli_num_rows($sql_p) != 0)?mysqli_num_rows($sql_p):"";
                                            $jml_tl = (mysqli_num_rows($sql_tl) != 0)?mysqli_num_rows($sql_tl):"";
                                            $jml_frm = (mysqli_num_rows($sql_frm) != 0)?mysqli_num_rows($sql_frm):"";
                                            
                                            ?>
                                            <tr>
                                                <td><?=$no++?></td>
                                                <td><?=$data_group['nama_group']?></td>
                                                <td><?=$jml_frm?></td>
                                                <td><?=$jml_tl?></td>
                                                <td><?=$jml_tm1?></td>
                                                <td><?=$jml_tm2?></td>
                                                <td><?=$jml_p?></td>
                                                <td><?=$total?></td>
                                                <td class="text-right">
                                                    <div class="btn btn-sm btn-success">detail</div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }else{
                                        ?>
                                        <tr>
                                            <td class="text-uppercase text-center" colspan="10">
                                                Belum ada register group untuk section ini
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
        
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="card-title col-md-6 pull-left text-uppercase" >Data Man Power</h6>
                </div>
                <div class="table-responsive text-uppercase">
                    <table class="table-hover table text-nowrap">
                        <thead>
                            <th>#</th>
                            <th>NPK</th>
                            <th>NAMA</th>
                            <th>Jabatan</th>
                            <th>shift</th>
                            <th>Status</th>
                            <th>POS</th>
                            <th>TEAM</th>
                            <th>GROUP</th>
                            <th>SECTION</th>
                            <th>DEPT ADMINISTRATIF</th>
                        </thead>
                        <tbody>
                            <?php
                            $query_mp = mysqli_query($link, "SELECT * FROM view_organization WHERE id_sect = '$id' ")or die(mysqli_error($link));
                            if(mysqli_num_rows($query_mp)>0){
                                $no =1;
                                while($dataMp = mysqli_fetch_assoc($query_mp)){
                                    ?>
                                    <tr>
                                        
                                        <td><?=$no++?></td>
                                        <td><?=$dataMp['npk']?></td>
                                        <td><?=$dataMp['nama']?></td>
                                        <td><?=$dataMp['jabatan']?></td>
                                        <td><?=$dataMp['shift']?></td>
                                        <td><?=$dataMp['status']?></td>
                                        <td><?=$dataMp['subpos']?></td>
                                        <td><?=$dataMp['pos']?></td>
                                        <td><?=$dataMp['groupfrm']?></td>
                                        <td><?=$dataMp['section']?></td>
                                        <td><?=$dataMp['dept_account']?></td>
                                    </tr>
                                    <?php
                                }
                            }else{
                                ?>
                                <tr>
                                    <td colspan="12" class="text-center">Belum ada arrangement man power</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
    // CHARTS
    chartColor = "#FFFFFF";
    
    ctx = document.getElementById('dataArr').getContext("2d");

    gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#80b6f4');
    gradientStroke.addColorStop(1, chartColor);

    gradientFill = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill.addColorStop(0, "rgba(74, 161, 253, 1)");
    gradientFill.addColorStop(1, "rgba(74, 161, 253, 1)");

    gradientFill2 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill2.addColorStop(0, "rgba(195, 255, 194, 1)");
    gradientFill2.addColorStop(1, "rgba(195, 255, 194, 1)");

    gradientFill3 = ctx.createLinearGradient(0, 50, 1, 200);
    gradientFill3.addColorStop(0, "rgba(253, 210, 48, 1)");
    gradientFill3.addColorStop(1, "rgba(253, 210, 48, 1)");

    myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [
            <?php
             $query = "SELECT * FROM view_employee_sumary WHERE parent = '$id'";
             $sql = mysqli_query($link,$query)or die(mysqli_error($link));

             if(mysqli_num_rows($sql)>0){
                 $dataGroup = '';
                while($data = mysqli_fetch_assoc($sql)){
                        $dataGroup .= "'$data[nama]',";
                    }
                    $dt = substr($dataGroup, 0, -1);
                    echo $dt;
                
             }
            //  "SELECT DISTINCT view_daftar_area.id AS `id_area`,
            //  view_daftar_area.nama_org AS `nama_area`,
            //  view_daftar_area.part AS `part_area`,
            //  view_daftar_area.id_parent AS `id_parent`,
            //  jabatan.jabatan AS `jab`,
            //  jabatan.id_jabatan AS `id_jab`,
            //  (SELECT count(org.npk) FROM org JOIN karyawan on karyawan.npk = org.npk 
            //      WHERE org.division = view_daftar_area.id AND jabatan.id_jabatan = karyawan.jabatan) AS total_mp 
            //  FROM view_daftar_area LEFT JOIN org ON org.division = view_daftar_area.id 
            //  LEFT JOIN karyawan ON karyawan.npk = org.npk  
            //  LEFT JOIN jabatan ON jabatan.id_jabatan = karyawan.jabatan 
            //     WHERE view_daftar_area.part ='division' 
            //  UNION ALL 
            //  SELECT DISTINCT view_daftar_area.id AS `id_area`,
            //  view_daftar_area.nama_org AS `nama_area`,
            //  view_daftar_area.part AS `part_area`,
            //  view_daftar_area.id_parent AS `id_parent`,
            //  jabatan.jabatan AS `jab`,
            //  jabatan.id_jabatan AS `id_jab`,
            //  (SELECT count(org.npk) FROM org JOIN karyawan on karyawan.npk = org.npk 
            //      WHERE org.dept_account = view_daftar_area.id AND jabatan.id_jabatan = karyawan.jabatan) AS total_mp 
            //  FROM view_daftar_area LEFT JOIN org ON org.dept_account = view_daftar_area.id 
            //  LEFT JOIN karyawan ON karyawan.npk = org.npk  
            //  LEFT JOIN jabatan ON jabatan.id_jabatan = karyawan.jabatan 
            //     WHERE view_daftar_area.part ='deptAcc' 
            //  UNION ALL 
            //  SELECT DISTINCT view_daftar_area.id AS `id_area`,
            //  view_daftar_area.nama_org AS `nama_area`,
            //  view_daftar_area.part AS `part_area`,
            //  view_daftar_area.id_parent AS `id_parent`,
            //  jabatan.jabatan AS `jab`,
            //  jabatan.id_jabatan AS `id_jab`,
            //  (SELECT count(org.npk) FROM org JOIN karyawan on karyawan.npk = org.npk 
            //      WHERE org.dept = view_daftar_area.id AND jabatan.id_jabatan = karyawan.jabatan) AS total_mp 
            //  FROM view_daftar_area LEFT JOIN org ON org.dept = view_daftar_area.id 
            //  LEFT JOIN karyawan ON karyawan.npk = org.npk  
            //  LEFT JOIN jabatan ON jabatan.id_jabatan = karyawan.jabatan 
            //     WHERE view_daftar_area.part ='dept' 
            //  UNION ALL 
            //  SELECT DISTINCT view_daftar_area.id AS `id_area`,
            //  view_daftar_area.nama_org AS `nama_area`,
            //  view_daftar_area.part AS `part_area`,
            //  view_daftar_area.id_parent AS `id_parent`,
            //  jabatan.jabatan AS `jab`,
            //  jabatan.id_jabatan AS `id_jab`,
            //  (SELECT count(org.npk) FROM org JOIN karyawan on karyawan.npk = org.npk 
            //      WHERE org.sect = view_daftar_area.id AND jabatan.id_jabatan = karyawan.jabatan) AS total_mp 
            //  FROM view_daftar_area LEFT JOIN org ON org.sect = view_daftar_area.id 
            //  LEFT JOIN karyawan ON karyawan.npk = org.npk  
            //  LEFT JOIN jabatan ON jabatan.id_jabatan = karyawan.jabatan 
            //     WHERE view_daftar_area.part ='section' 
            //  UNION ALL 
            //  SELECT DISTINCT view_daftar_area.id AS `id_area`,
            //  view_daftar_area.nama_org AS `nama_area`,
            //  view_daftar_area.part AS `part_area`,
            //  view_daftar_area.id_parent AS `id_parent`,
            //  jabatan.jabatan AS `jab`,
            //  jabatan.id_jabatan AS `id_jab`,
            //  (SELECT count(org.npk) FROM org JOIN karyawan on karyawan.npk = org.npk 
            //      WHERE org.grp = view_daftar_area.id AND jabatan.id_jabatan = karyawan.jabatan) AS total_mp 
            //  FROM view_daftar_area LEFT JOIN org ON org.grp = view_daftar_area.id 
            //  LEFT JOIN karyawan ON karyawan.npk = org.npk  
            //  LEFT JOIN jabatan ON jabatan.id_jabatan = karyawan.jabatan 
            //     WHERE view_daftar_area.part ='group' 
            //  UNION ALL 
            //  SELECT DISTINCT view_daftar_area.id AS `id_area`,
            //  view_daftar_area.nama_org AS `nama_area`,
            //  view_daftar_area.part AS `part_area`,
            //  view_daftar_area.id_parent AS `id_parent`,
            //  jabatan.jabatan AS `jab`,
            //  jabatan.id_jabatan AS `id_jab`,
            //  (SELECT count(org.npk) FROM org JOIN karyawan on karyawan.npk = org.npk 
            //      WHERE org.post = view_daftar_area.id AND jabatan.id_jabatan = karyawan.jabatan) AS total_mp 
            //  FROM view_daftar_area LEFT JOIN org ON org.post = view_daftar_area.id 
            //  LEFT JOIN karyawan ON karyawan.npk = org.npk  
            //  LEFT JOIN jabatan ON jabatan.id_jabatan = karyawan.jabatan 
            //     WHERE view_daftar_area.part ='pos'
            //  ";

            // "SELECT DISTINCT view_daftar_area.id AS id_area,
            // view_daftar_area.nama_org AS nama_area,
            // view_daftar_area.part AS part_area,
            // view_daftar_area.id_parent AS `id_parent`,
            // status_mp.id AS id_status,
            // status_mp.status_mp AS status_karyawan,
            // (SELECT count(org.npk) 
            // FROM org JOIN karyawan ON karyawan.npk = org.npk
            //      WHERE org.division = view_daftar_area.id AND status_mp.id = karyawan.status) AS total_mp
            // FROM view_daftar_area 
            // LEFT JOIN org ON org.division = view_daftar_area.id 
            // LEFT JOIN karyawan ON karyawan.npk = org.npk 
            // LEFT JOIN status_mp ON status_mp.id = karyawan.status 
            //     WHERE view_daftar_area.part = 'division' 
            // UNION ALL 
            // SELECT DISTINCT view_daftar_area.id AS id_area,
            // view_daftar_area.nama_org AS nama_area,
            // view_daftar_area.part AS part_area,
            // view_daftar_area.id_parent AS `id_parent`,
            // status_mp.id AS id_status,
            // status_mp.status_mp AS status_karyawan,
            // (SELECT count(org.npk) 
            // FROM org JOIN karyawan ON karyawan.npk = org.npk
            //      WHERE org.division = view_daftar_area.id AND status_mp.id = karyawan.status) AS total_mp
            // FROM view_daftar_area 
            // LEFT JOIN org ON org.dept_account = view_daftar_area.id 
            // LEFT JOIN karyawan ON karyawan.npk = org.npk 
            // LEFT JOIN status_mp ON status_mp.id = karyawan.status 
            //     WHERE view_daftar_area.part = 'deptAcc' 
            // UNION ALL
            // SELECT DISTINCT view_daftar_area.id AS id_area,
            // view_daftar_area.nama_org AS nama_area,
            // view_daftar_area.part AS part_area,
            // view_daftar_area.id_parent AS `id_parent`,
            // status_mp.id AS id_status,
            // status_mp.status_mp AS status_karyawan,
            // (SELECT count(org.npk) 
            // FROM org JOIN karyawan ON karyawan.npk = org.npk
            //      WHERE org.division = view_daftar_area.id AND status_mp.id = karyawan.status) AS total_mp
            // FROM view_daftar_area 
            // LEFT JOIN org ON org.dept = view_daftar_area.id 
            // LEFT JOIN karyawan ON karyawan.npk = org.npk 
            // LEFT JOIN status_mp ON status_mp.id = karyawan.status 
            //     WHERE view_daftar_area.part = 'dept' 
            // UNION ALL
            // SELECT DISTINCT view_daftar_area.id AS id_area,
            // view_daftar_area.nama_org AS nama_area,
            // view_daftar_area.part AS part_area,
            // view_daftar_area.id_parent AS `id_parent`,
            // status_mp.id AS id_status,
            // status_mp.status_mp AS status_karyawan,
            // (SELECT count(org.npk) 
            // FROM org JOIN karyawan ON karyawan.npk = org.npk
            //      WHERE org.division = view_daftar_area.id AND status_mp.id = karyawan.status) AS total_mp
            // FROM view_daftar_area 
            // LEFT JOIN org ON org.sect = view_daftar_area.id 
            // LEFT JOIN karyawan ON karyawan.npk = org.npk 
            // LEFT JOIN status_mp ON status_mp.id = karyawan.status 
            //     WHERE view_daftar_area.part = 'section' 
            // UNION ALL
            // SELECT DISTINCT view_daftar_area.id AS id_area,
            // view_daftar_area.nama_org AS nama_area,
            // view_daftar_area.part AS part_area,
            // view_daftar_area.id_parent AS `id_parent`,
            // status_mp.id AS id_status,
            // status_mp.status_mp AS status_karyawan,
            // (SELECT count(org.npk) 
            // FROM org JOIN karyawan ON karyawan.npk = org.npk
            //      WHERE org.division = view_daftar_area.id AND status_mp.id = karyawan.status) AS total_mp
            // FROM view_daftar_area 
            // LEFT JOIN org ON org.grp = view_daftar_area.id 
            // LEFT JOIN karyawan ON karyawan.npk = org.npk 
            // LEFT JOIN status_mp ON status_mp.id = karyawan.status 
            //     WHERE view_daftar_area.part = 'group' 
            // UNION ALL
            // SELECT DISTINCT view_daftar_area.id AS id_area,
            // view_daftar_area.nama_org AS nama_area,
            // view_daftar_area.part AS part_area,
            // view_daftar_area.id_parent AS `id_parent`,
            // status_mp.id AS id_status,
            // status_mp.status_mp AS status_karyawan,
            // (SELECT count(org.npk) 
            // FROM org JOIN karyawan ON karyawan.npk = org.npk
            //      WHERE org.division = view_daftar_area.id AND status_mp.id = karyawan.status) AS total_mp
            // FROM view_daftar_area 
            // LEFT JOIN org ON org.post = view_daftar_area.id 
            // LEFT JOIN karyawan ON karyawan.npk = org.npk 
            // LEFT JOIN status_mp ON status_mp.id = karyawan.status 
            //     WHERE view_daftar_area.part = 'pos'
            // " ;
          ?>
        ],
        datasets: [
          {
            label: "Foreman",
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
                <?php
                $query = "SELECT * FROM view_employee_sumary WHERE parent = '$id'";
                $sql = mysqli_query($link,$query)or die(mysqli_error($link));

                if(mysqli_num_rows($sql)>0){
                    
                    $dataGroup = '';
                    while($data = mysqli_fetch_assoc($sql)){
                            $id_group = $data['id'];
                            $query = "SELECT total_mp FROM view_organization_sumary WHERE id_parent = '$id_group' AND (id_jab = 'FRM' OR id_jab = 'AFRM') ";
                            $sqlGroup = mysqli_query($link, $query)or die(mysqli_error($link));
                            $dataTotal = mysqli_fetch_assoc($sqlGroup);
                            $total = $dataTotal['total_mp'];
                            $dataGroup .= "$total,";
                        }
                        $dt = substr($dataGroup, 0, -1);
                        echo $dt;
                    
                }
             ?>
            ],
          },{
            label: "Team Leader",
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill2,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
                <?php
                $query = "SELECT * FROM view_employee_sumary WHERE parent = '$id'";
                $sql = mysqli_query($link,$query)or die(mysqli_error($link));

                if(mysqli_num_rows($sql)>0){
                    
                    $dataGroup = '';
                    while($data = mysqli_fetch_assoc($sql)){
                            $id_group = $data['id'];
                            $query = "SELECT total_mp FROM view_organization_sumary WHERE id_parent = '$id_group' AND (id_jab = 'TL' OR id_jab = 'ATL') ";
                            $sqlGroup = mysqli_query($link, $query)or die(mysqli_error($link));
                            $dataTotal = mysqli_fetch_assoc($sqlGroup);
                            $total = $dataTotal['total_mp'];
                            $dataGroup .= "$total,";
                        }
                        $dt = substr($dataGroup, 0, -1);
                        echo $dt;
                    
                }
                ?>
            ],
          },{
            label: "Team Member",
            borderColor: '#fcc468',
            fill: true,
            backgroundColor: gradientFill3,
            hoverBorderColor: '#fcc468',
            borderWidth: 0,
            data: [
                <?php
                $query = "SELECT * FROM view_employee_sumary WHERE parent = '$id'";
                $sql = mysqli_query($link,$query)or die(mysqli_error($link));

                if(mysqli_num_rows($sql)>0){
                    
                    $dataGroup = '';
                    while($data = mysqli_fetch_assoc($sql)){
                            $id_group = $data['id'];
                            $query = "SELECT total_mp FROM view_organization_sumary WHERE id_parent = '$id_group' AND id_jab = 'TM' ";
                            $sqlGroup = mysqli_query($link, $query)or die(mysqli_error($link));
                            $dataTotal = mysqli_fetch_assoc($sqlGroup);
                            $total = $dataTotal['total_mp'];
                            $dataGroup .= "$total,";
                        }
                        $dt = substr($dataGroup, 0, -1);
                        echo $dt;
                    
                }
                ?>
            ],
          },
        ]
      },
      options: {
        
        tooltips: {
          tooltipFillColor: "rgba(0,0,0,0.5)",
          tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
          tooltipFontSize: 14,
          tooltipFontStyle: "normal",
          tooltipFontColor: "#fff",
          tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
          tooltipTitleFontSize: 14,
          tooltipTitleFontStyle: "bold",
          tooltipTitleFontColor: "#fff",
          tooltipYPadding: 6,
          tooltipXPadding: 6,
          tooltipCaretSize: 8,
          tooltipCornerRadius: 6,
          tooltipXOffset: 10,
        },


        legend: {

          display: false
        },
        scales: {

          yAxes: [{
            stacked: true,
            ticks: {
              fontColor: "#9f9f9f",
              fontStyle: "bold",
              beginAtZero: true,
              maxTicksLimit: 5,
              padding: 20,
              steps: 10,
              stepValue: 5,
              max: 10
            },
            gridLines: {
              zeroLineColor: "transparent",
              display: false,
              drawBorder: false,
              color: '#9f9f9f',
            }

          }],
          xAxes: [{
            stacked: true,
            barPercentage: 0.4,
            barThickness: 50,  // number (pixels) or 'flex'
            maxBarThickness: 50, // number (pixels)
            gridLines: {
              zeroLineColor: "white",
              display: false,

              drawBorder: false,
              color: 'transparent',
            },
            ticks: {
              padding: 20,
              fontColor: "#9f9f9f",
              fontStyle: "bold"
            }
          }]
        }
      }
    });
    </script> 

        <?php
    }else{
        echo "DATA BELUM TERSEDIA";
    }
}else{
    
}
    ?>
    