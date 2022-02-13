<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header ">
                <h5 class="card-title">Organization<li class="nc-icon nc-circle-10 pull-right"></li>    
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover text-uppercase">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Area</th>
                                    <th>DH</th>
                                    <th>MNG</th>
                                    <th>SPV</th>
                                    <th>FRM</th>
                                    <th>TL</th>
                                    <th>TM</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                $no = 1;
                                if($level == 8){
                                    $s_sumaryArea = mysqli_query($link, "SELECT
                                    division.id_div AS id_area,
                                    division.nama_divisi AS nama_area,
                                    division.npk_cord AS cordinator,
                                    division.id_company AS id_parent FROM division WHERE id_company = '1' GROUP BY id_div")or die(mysqli_error($link));
                                    echo mysqli_num_rows($s_sumaryArea);
                                    while($dataDivision = mysqli_fetch_assoc($s_sumaryArea)){
                                        $q_karyawan = "SELECT karyawan.npk AS npk,
                                        karyawan.nama AS nama,
                                        karyawan.jabatan AS jabatan,
                                        karyawan.shift AS shift,
                                        karyawan.status AS status_karyawan,
                                        org.npk AS npk_org 
                                        FROM org JOIN karyawan ON karyawan.npk = org.npk ";
                                        $divHead = mysqli_query($link, $q_karyawan."WHERE (jabatan = 'DH' OR jabatan = 'ADH') AND org.division = '$dataDivision[id_area]' ")or die(mysqli_error($link));
                                        
                                        $jmlDh = mysqli_num_rows($divHead);
                                        $jmlfrm = 0;
                                        $jmldh = $jmlDh;
                                        $jmldpt = 0;
                                        $jmlsct = 0;
                                        $jmltl = 0;
                                        $jmltm = 0;
                                        $tot = $jmldh+$jmldpt+$jmlsct+$jmltl+$jmlfrm+$jmltm+$total;
                                        ?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$dataDivision['nama_area']?></td>
                                            <td><?=$jmldh?></td>
                                            <td><?=$jmldpt?></td>
                                            <td><?=$jmlsct?></td>
                                            <td><?=$jmlfrm?></td>
                                            <td><?=$jmltl?></td>
                                            <td><?=$jmltm?></td>
                                            <td><?=$tot?></td>
                                        </tr>
                                        <?php
                                        $s_sumaryDept = mysqli_query($link, "SELECT department.id_dept AS id_area,
                                        department.dept AS nama_area,
                                        department.npk_cord AS cordinator,
                                        department.id_div AS id_parent FROM department WHERE id_div = '$dataDivision[id_area]' GROUP BY id_dept")or die(mysqli_error($link));
                                        
                                        while($dataDept = mysqli_fetch_assoc($s_sumaryDept)){
                                            $deptHead = mysqli_query($link, $q_karyawan."WHERE (jabatan = 'MNG' OR jabatan = 'AMNG') AND org.dept = '$dataDept[id_area]' ")or die(mysqli_error($link));
                                        
                                            $jmlDepth = mysqli_num_rows($deptHead);
                                            $jmlfrm = 0;
                                            $jmldh = 0;
                                            $jmldpt = $jmlDepth;
                                            $jmlsct = 0;
                                            $jmltl = 0;
                                            $jmltm = 0;
                                            $tot = $jmldh+$jmldpt+$jmlsct+$jmltl+$jmlfrm+$jmltm+$total;
                                            ?>
                                            <tr>
                                                <td><?=$no++?></td>
                                                <td><?=$dataDept['nama_area']?></td>
                                                <td><?=$jmldh?></td>
                                                <td><?=$jmldpt?></td>
                                                <td><?=$jmlsct?></td>
                                                <td><?=$jmlfrm?></td>
                                                <td><?=$jmltl?></td>
                                                <td><?=$jmltm?></td>
                                                <td><?=$tot?></td>
                                            </tr>
                                            <?php
                                            $s_sumarySect = mysqli_query($link, "SELECT section.id_section AS id_area,
                                            section.section AS nama_area,
                                            section.npk_cord AS cordinator,
                                            section.id_dept AS id_parent FROM section WHERE id_dept = '$dataDept[id_area]' GROUP BY id_section")or die(mysqli_error($link));
                                            while($dataSect = mysqli_fetch_assoc($s_sumarySect)){
                                                $sectHead = mysqli_query($link, $q_karyawan."WHERE (jabatan = 'SPV' OR jabatan = 'ASPV') AND org.sect = '$dataSect[id_area]' ")or die(mysqli_error($link));
                                                $jmlSecth = mysqli_num_rows($sectHead);

                                                $jmlfrm = 0;
                                                $jmldh = 0;
                                                $jmldpt = 0;
                                                $jmlsct = $jmlSecth;
                                                $jmltl = 0;
                                                $jmltm = 0;
                                                $tot = $jmldh+$jmldpt+$jmlsct+$jmltl+$jmlfrm+$jmltm+$total;
                                                ?>
                                                <tr>
                                                    <td><?=$no++?></td>
                                                    <td><?=$dataSect['nama_area']?></td>
                                                    <td><?=$jmldpt?></td>
                                                    <td><?=$jmldh?></td>
                                                    <td><?=$jmlsct?></td>
                                                    <td><?=$jmlfrm?></td>
                                                    <td><?=$jmltl?></td>
                                                    <td><?=$jmltm?></td>
                                                    <td><?=$tot?></td>
                                                </tr>
                                                <?php
                                                $s_sumaryGrp = mysqli_query($link, "SELECT groupfrm.id_group AS id_area,
                                                groupfrm.nama_group AS nama_area,
                                                groupfrm.npk_cord AS cordinator,
                                                groupfrm.id_section AS id_parent FROM groupfrm WHERE id_section = '$dataSect[id_area]' ")or die(mysqli_error($link));
                                                while($dataGrp = mysqli_fetch_assoc($s_sumaryGrp)){
                                                    $frm = mysqli_query($link, $q_karyawan."WHERE (jabatan = 'FRM' OR jabatan = 'AFRM') AND org.grp = '$dataGrp[id_area]' ")or die(mysqli_error($link));
                                                    $jmlfrm = mysqli_num_rows($frm);
                                                    $jmldh = 0;
                                                    $jmldpt = 0;
                                                    $jmlsct = 0;
                                                    $jmltl = 0;
                                                    $jmltm = 0;
                                                    $tot = $jmldh+$jmldpt+$jmlsct+$jmltl+$jmlfrm+$jmltm+$total;
                                                    ?>
                                                    <tr>
                                                        <td><?=$no++?></td>
                                                        <td><?=$dataGrp['nama_area']?></td>
                                                        <td><?=$jmldh?></td>
                                                        <td><?=$jmldpt?></td>
                                                        <td><?=$jmlsct?></td>
                                                        <td><?=$jmlfrm?></td>
                                                        <td><?=$jmltl?></td>
                                                        <td><?=$jmltm?></td>
                                                        <td><?=$tot?></td>
                                                    </tr>
                                                    <?php
                                                    $s_sumaryPost = mysqli_query($link, "SELECT pos_leader.id_post AS id_area,
                                                    pos_leader.nama_pos AS nama_area,
                                                    pos_leader.npk_cord AS cordinator,
                                                    pos_leader.id_group AS id_parent FROM pos_leader WHERE id_group = '$dataGrp[id_area]'")or die(mysqli_error($link));
                                                    while($dataPost = mysqli_fetch_assoc($s_sumaryPost)){
                                                        $datafrm = mysqli_query($link, $q_karyawan."WHERE (jabatan = 'FRM' OR jabatan = 'AFRM') AND org.post = '$dataPost[id_area]' ")or die(mysqli_error($link));
                                                        $datasct = mysqli_query($link, $q_karyawan."WHERE (jabatan = 'SPV' OR jabatan = 'ASPV') AND org.post = '$dataPost[id_area]' ")or die(mysqli_error($link));
                                                        $datadpt = mysqli_query($link, $q_karyawan."WHERE (jabatan = 'MNG' OR jabatan = 'AMNG') AND org.post = '$dataPost[id_area]' ")or die(mysqli_error($link));
                                                        $datadh = mysqli_query($link, $q_karyawan."WHERE (jabatan = 'DH' OR jabatan = 'ADH') AND org.post = '$dataPost[id_area]' ")or die(mysqli_error($link));
                                                        $datatl = mysqli_query($link, $q_karyawan."WHERE (jabatan = 'TL' OR jabatan = 'ATL') AND org.post = '$dataPost[id_area]' ")or die(mysqli_error($link));
                                                        $datatm = mysqli_query($link, $q_karyawan."WHERE (jabatan = 'TM') AND org.post = '$dataPost[id_area]' ")or die(mysqli_error($link));
                                                        
                                                        $jmlfrm = mysqli_num_rows($datafrm);
                                                        $jmlsct = mysqli_num_rows($datasct);
                                                        $jmldpt = mysqli_num_rows($datadpt);
                                                        $jmldh = mysqli_num_rows($datadh);
                                                        $jmltl = mysqli_num_rows($datatl);
                                                        $jmltm = mysqli_num_rows($datatm);
                                                        $tot = $jmldh+$jmldpt+$jmlsct+$jmltl+$jmlfrm+$jmltm+$total;
                                                        ?>
                                                        <tr>
                                                            <td><?=$no++?></td>
                                                            <td><?=$dataPost['nama_area']?></td>
                                                            <td><?=$jmldh?></td>
                                                            <td><?=$jmldpt?></td>
                                                            <td><?=$jmlsct?></td>
                                                            <td><?=$jmlfrm?></td>
                                                            <td><?=$jmltl?></td>
                                                            <td><?=$jmltm?></td>
                                                            <td><?=$tot?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            }

                                        }
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">total</th>
                                    <th >total</th>
                                    <th >total</th>
                                    <th >total</th>
                                    <th >total</th>
                                    <th >total</th>
                                    <th >total</th>
                                    <th >total</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- <div class="col-md-7">
                        <canvas id="chartareaorg"></canvas>
                    </div> -->
                </div>
                
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>