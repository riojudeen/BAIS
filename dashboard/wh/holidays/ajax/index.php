<?php

require_once("../../../../config/config.php"); 
if(isset($_GET['year'])){
    $year = $_GET['year'];
    $startdate = $_GET['startdate'];
    $enddate = $_GET['enddate'];
}else{
    $year = date('Y');
    $startdate = date('m');
    $enddate = date('m');
}
?>
<form method="post" name="proses" action="" >
    <div class="table-responsive">

        <table class="table table-hover table_org" id="uangmakan" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Tipe</th>
                    <th>Keterangan</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-uppercase">
            <?php
            $no = 1;
            $sqlHd = mysqli_query($link, "SELECT * FROM holidays WHERE (MONTH(`date`) BETWEEN '$startdate' AND '$enddate') AND (YEAR(`date`) = '$year') ORDER BY `date` ASC")or die(mysqli_error($link));
            
            if(mysqli_num_rows($sqlHd) > 0){
                while($dataHd = mysqli_fetch_assoc($sqlHd)){
            ?>
            
                <tr>
                    <td><?=$no++?></td>
                    <td><?=tgl_indo($dataHd['date'])?></td>
                    <td><?=$dataHd['type']?></td>
                    <td><?=$dataHd['ket']?></td>
                    
                    <td class="text-right text-nowrap">
                        <a href="<?=base_url('dashboard/wh/holidays')?>/edit.php?id=<?=$dataHd['id']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                        <a href="<?=base_url('dashboard/wh/holidays')?>/proses.php?del=<?=$dataHd['id']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
            <?php
                }
            }else{
                echo "<tr><td class=\"text-center\" colspan=\"6\">Tidak ditemukan data di database</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</form>
<script>
    //untuk crud masal update department

$('.remove').on('click', function(e){
    e.preventDefault();
    var getLink = $(this).attr('href');
        
    Swal.fire({
    title: 'Anda Yakin ?',
    text: "Data Akan Dihapus Permanent",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#FF5733',
    cancelButtonColor: '#B2BABB',
    confirmButtonText: 'Yes, delete!'
    }).then((result) => {
        if (result.value) {
            document.location.href=getLink;
        }
    })
    
});
</script>