<?php

require_once("../../../config/config.php"); 
// $year = (isset($_SESSION['tahun']))?  $_SESSION['tahun'] : date('Y');
// echo $year;
if(isset($_POST['go'])){
    $_SESSION['tahun'] = $_POST['year'];
    $year = $_SESSION['tahun'];
}else{
    $year = date('Y');
}


?>



<div class="box pull-right">
    <a href="<?=base_url('/dashboard/wh/workingbreak')?>/add.php?add=break" class="pull-right btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Tambah Data Master">
        <span class="btn-label">  
            <i class="nc-icon nc-simple-add"></i> Tambah Data
        </span>
        
    </a>
</div>

<form method="post" name="proses" action="" >
    <div class="table-responsive">
        <table id="datatable" class="table table-striped table_org"  cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Skema</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Effective Date</th>
                    <th class="text-right">Action</th>
                    
                </tr>
            </thead>
            <tbody class="text-uppercase">
            <?php
            $no = 1;
            $sqlHd = mysqli_query($link, "SELECT * FROM working_break
            ")or die(mysqli_error($link));
            
            if(mysqli_num_rows($sqlHd) > 0){
                $no = 1;
                while($dataBreak = mysqli_fetch_assoc($sqlHd)){
                    
                ?>
                <tr>
                    <td><?=$no++?></td>
                    <td><?=$dataBreak['scheme_name']?></td>
                    <td><?=$dataBreak['start_time']?></td>
                    <td><?=$dataBreak['end_time']?></td>
                    <td><?=tgl_indo($dataBreak['effective_date'])?></td>
                    <td class="text-right text-nowrap">
                        
                        <a href="workingbreak/edit.php?id=<?=$dataBreak['id']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                        <a href="workingbreak/proses.php?del=<?=$dataBreak['id']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm hapus"><i class="fa fa-times"></i></a>
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
    $(document).ready(function() {
        $('#datatable').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
            [5, 10, 15, -1],
            [5, 10, 15, "All"]
            ],
            responsive: true,
            language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
            }

        });

    
    });
</script>
<script>
    //untuk crud masal update department

    $('.hapus').on('click', function(e){
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
                // document.proses.method = "get";
                document.proses.action = getLink;
                document.proses.submit()
                
               
            }
        })
        
    });
        
</script>
            