<?php
require_once("../../../config/config.php"); 
?>



    <a href="<?=base_url('/dashboard/wh/shiftsettings')?>/add.php?add=ws" class="pull-right btn-sm btn  btn-success" data-toggle="tooltip" data-placement="bottom" title="Tambah Data Master">
        <i class="nc-icon nc-simple-add"></i> Tambah Data
    </a>
    <form method="post" name="proses" action="" >
        <div class="table-responsive" >
            <table id="datatable" class="table table-hover table_org" id="uangmakan" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Shift</th>
                        <th>Nama</th>
                        
                        <th class="text-right">Action</th>
                        
                    </tr>
                </thead>
                <tbody class="text-uppercase">
                <?php
                $no = 1;
                $q_working_shift = mysqli_query($link, "SELECT `id`,`name`,`req_date` FROM `working_day_shift`")or die(mysqli_error($link));
                
                
                if(mysqli_num_rows($q_working_shift) > 0){
                    while($dataWS = mysqli_fetch_assoc($q_working_shift)){
                ?>
                
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$dataWS['id']?></td>
                        <td><?=$dataWS['name']?></td>
                        <td class="text-right text-nowrap">
                            <a href="<?=base_url('dashboard/wh/shiftsettings')?>/edit.php?id=<?=$dataWS['id']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                            <a href="<?=base_url('dashboard/wh/shiftsettings')?>/proses.php?del=<?=$dataWS['id']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>
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
                    document.proses.action = getLink;
                    document.proses.submit();
                }
            })
            
        });
        
    </script>

