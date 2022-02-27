<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
// echo $_GET['data'];
if($_GET['data'] != "0"){
    $id = $_GET['data'];
    // echo $_GET['data'];
    $q_group = mysqli_query($link, "SELECT nama_group FROM groupfrm WHERE id_group = '$_GET[data]' ")or die(mysqli_error($link));
    $sql_group = mysqli_fetch_assoc($q_group);
    $dataGroup = $sql_group['nama_group']
    // $q_data = mysqli_query()
?>
<div class="row">
    <div class="col-md-12">
        <h6>Man Power <?=$dataGroup?></h6>
        <div class="table-responsive">
            <table class="table table-hover text-uppercase">
                <thead>
                    <th>#</th>
                    <th>NPK</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th>pos</th>
                    <th>Group</th>
                    <th></th>
                    <th></th>
                    <th class="text-right">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input checkall" type="checkbox" id="check-" >
                            <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </th>
                </thead>
                <tbody>
                    <?php
                    $q_org = "SELECT org.npk AS `npk`,
                    karyawan.nama AS `nama`,
                    karyawan.jabatan AS `jabatan`,
                    karyawan.status AS `status`,
                    pos.nama AS `nama_pos`,
                    pos.npk_cord AS `cord_tl`,
                    pos_leader.nama_pos AS `nama_pos_leader`,
                    pos_leader.npk_cord AS `cord_pos`,
                    groupfrm.nama_group AS `nama_group`,
                    groupfrm.npk_cord AS `cord_grp`,
                    section.section AS `nama_section`,
                    section.npk_cord AS `cord_section`,
                    department.npk_cord AS `cord_dept`,
                    department.dept AS `dept_functional`,
                    division.nama_divisi AS `nama_division`,
                    division.npk_cord AS `cord_div`,
                    dept_account.npk_dept AS `cord_account`,
                    dept_account.department_account AS `id_account`
                    FROM org JOIN karyawan ON karyawan.npk = org.npk
                    LEFT JOIN pos ON pos.id_post = org.sub_post
                    LEFT JOIN pos_leader ON pos_leader.id_post = org.post
                    LEFT JOIN groupfrm ON groupfrm.id_group = org.grp
                    LEFT JOIN section ON section.id_section = org.sect
                    LEFT JOIN department ON department.id_dept = org.dept
                    LEFT JOIN division ON division.id_div = org.division
                    LEFT JOIN dept_account ON dept_account.id_dept_account = org.dept_account
                    WHERE org.grp = '$id' ";
                    $sql_org = mysqli_query($link, $q_org)or die(mysqli_error($link));
                    if(mysqli_num_rows($sql_org)>0){
                        $no = 1;
                        while($data = mysqli_fetch_assoc($sql_org)){
                            ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=$data['npk']?></td>
                                <td><?=$data['nama']?></td>
                                <td><?=$data['jabatan']?></td>
                                <td><?=$data['status']?></td>
                                <td><?=$data['nama_pos_leader']?></td>
                                <td><?=$data['nama_group']?></td>
                                
                                <td>
                                    <div class="badge badge-sm badge-info badge-pill">
                                        Koordinator
                                    </div>
                                </td>
                                <td class="text-right">
                                    <a href="" class="btn-round  btn-warning btn-info btn btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                    <a href="" class="btn btn-round  btn-danger  btn-icon btn-sm remove"><i class="fas fa-eraser"></i></a>
                                </td>
                                <td class="text-right">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input checkall" type="checkbox" id="check-" >
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
                            <td colspan="10" class="text-center">Belum ada data</td>
                        </tr>
                        <?php
                    }
                    ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
}
?>