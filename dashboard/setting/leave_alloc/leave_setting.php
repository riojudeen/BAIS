<?php

//////////////////////////////////////////////////////////////////////
// include("../../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Leave Allocation Settings";
if(isset($_SESSION['user'])){
?>
<div class="row ">
    <div class="col-md-12">
        <div class="pull-left ">
            <h5 class="title text-uppercase">Leave Allocation Setting</h5>
        </div>
        <div class="box pull-right">
            
            <a href="add.php" class="btn btn-sm btn-default" >
                <span class="btn-label">
                    <i class="nc-icon nc-simple-add"></i>
                </span>
            Add Settings
            </a>
            
        </div>

        <form method="post" name="proses" action="" >
        <div class="table-responsive">
            <table class="table table-striped table_org" id="uangmakan" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Cuti</th>
                        <th>Jenis Cuti</th>
                        <th>Allocation</th>
                        <th>Tanggal Effective</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                if(mysqli_num_rows($qry_leave) > 0){
                    while($leave_aloc = mysqli_fetch_assoc($qry_leave)){
                        ?>
                        <tr>
                            <td><?=$no++?></td>
                            <td><?=$leave_aloc['id_leave']?></td>
                            <td><?=$leave_aloc['jenis_cuti']?></td>
                            <td><?=$leave_aloc['alocation']?></td>
                            <td><?=DBtoForm($leave_aloc['eff_date'])?></td>
                            <td class="text-right text-nowrap">
                                <span>
                                    <a href="edit.php?edit=<?=$leave_aloc['id_aloc']?>&kode=<?=$leave_aloc['id_leave']?>" class="btn-round btn-outline-warning btn btn-warning btn-link btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                </span>
                                <span>
                                    <a href="proses.php?del=<?=$leave_aloc['id_aloc']?>" class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove"><i class="fa fa-times"></i></a>
                                </span>

                            </td>
                        </tr>

                        <?php
                        }
                }else{
                    echo "<tr><td class=\"text-center\" colspan=\"10\">Tidak ditemukan data di database</td></tr>";
                }
                ?>
                </tbody>
                
            </table>
        </div>

        <hr>
        
        </form>
    </div>
    
    
         
</div>
<?php
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>