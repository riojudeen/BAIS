<?php
//////////////////////////////////////////////////////////////////////
require("../../../../config/config.php");

if(isset($_GET['proses'])){
    if($_GET['proses']=='add'){
        mysqli_query($link, "INSERT INTO expatriat SET npk = '$_GET[npk]' ")or die(mysqli_error($link));
    }
    if($_GET['proses']=='delete'){
        mysqli_query($link, "DELETE FROM expatriat  WHERE npk = '$_GET[npk]' ")or die(mysqli_error($link));
        $_SESSION['info'] = 'Dihapus';
        session_start();
    }
}
if(isset($_GET['delete'])){
    
}
?>
<table class="table table-hover">
    <thead>
        <th class="text-right first-top-col first-col sticky-col">
            
        </th>
        <th class="text-nowrap sticky-col second-col second-top-col">#</th>
        <th class="text-nowrap sticky-col third-col third-top-col">Npk</th>
        <th class="text-nowrap sticky-col fourth-col fourth-top-col">Nama</th>
        <th class="text-nowrap">Tanggal Masuk</th>
        <th class="text-nowrap">Jabatan</th>
        <th class="text-nowrap">Status</th>
        <th class="text-nowrap">Shift</th>
        <th class="text-nowrap">Dept Account</th>
        <th class="text-nowrap">Atasan</th>
    </thead>
    <tbody class="text-nowrap">
        <?php
        $q_dataKaryawan = "SELECT view_organization.npk  AS `npk`,view_organization.nama AS `nama`,view_organization.tgl_masuk AS `tgl_masuk`,
        view_organization.jabatan AS `jabatan`,
        view_organization.shift AS `shift`, view_organization.status AS `status`,view_organization.subpos AS `subpos`,
        view_organization.pos AS `pos`,view_organization.groupfrm AS `groupfrm`, view_organization.section AS `section`,
        view_organization.dept AS `dept`,
        view_organization.dept_account AS `dept_account`, view_organization.division AS `division`,view_organization.plant AS `plant`,
        view_organization.id_sub_pos AS `id_sub_pos`, view_organization.id_post_leader AS `id_post_leader`,
        view_organization.id_grp AS `id_grp`,view_organization.id_sect AS `id_sect`,view_organization.id_dept AS `id_dept`,
        view_organization.id_dept_account AS `id_dept_account`,
        view_organization.id_division AS `id_division`,
        view_organization.id_plant AS `id_plant`,
        view_organization.id_area AS `id_area` FROM `view_organization`
        JOIN expatriat ON expatriat.npk = view_organization.npk WHERE view_organization.id_area IS NOT NULL";
        
        $sql_dataKaryawan = mysqli_query($link, $q_dataKaryawan)or die(mysqli_error($link));
        if(mysqli_num_rows($sql_dataKaryawan)>0){
            $no = 1 ;
            while($dataKaryawan = mysqli_fetch_assoc($sql_dataKaryawan)){
                $q_atasan = mysqli_query($link, "SELECT id, nama_cord FROM view_cord_area WHERE id = '$dataKaryawan[id_area]' ");
                $s_atasan = mysqli_fetch_assoc($q_atasan);
                $dataAtasan = (mysqli_num_rows($q_atasan)>0)?$s_atasan['nama_cord']:'';
                ?>
                <tr>
                    <td class="sticky-col first-col">
                        <a href="" data-id="<?=$dataKaryawan['npk']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm hapus"><i class="fas fa-trash"></i></a>
                    </td>
                    <td class="sticky-col second-col"><?=$no++?></td>
                    <td class="sticky-col third-col"><?=$dataKaryawan['npk']?></td>
                    <td class="sticky-col fourth-col"><?=$dataKaryawan['nama']?></td>
                    <td><?=DBtoForm($dataKaryawan['tgl_masuk'])?></td>
                    <td><?=$dataKaryawan['jabatan']?></td>
                    <td><?=$dataKaryawan['status']?></td>
                    <td><?=$dataKaryawan['shift']?></td>
                    <td><?=$dataKaryawan['dept_account']?></td>
                    <td><?=$dataAtasan?></td>
                </tr>
                <?php
            }
        }else{
            ?>
            <tr>
                <td colspan="10" class="text-uppercase text-center sticky-col first-col">belum ada data</td>
            </tr>
            <?php
        }
        ?>
        
    </tbody>
</table>
<script>
    $('.hapus').on('click', function(e){
        e.preventDefault();
        var npk = $(this).attr('data-id');
        Swal.fire({
        title: 'Anda Yakin ?',
        text: "Semua data yang dicheck / centang akan dihapus permanent",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF5733',
        cancelButtonColor: '#B2BABB',
        confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'ajax/data-expatriat.php',
                    method: 'get',
                    data: {proses:"delete", npk:npk},
                    success:function(data){
                        $('.data-expatriat').load("ajax/data-expatriat.php");
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'data Berhasil',
                        })
                    }
                })
            }
        })
        
    });
</script>