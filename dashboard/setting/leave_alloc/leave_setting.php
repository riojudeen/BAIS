<?php

//////////////////////////////////////////////////////////////////////
include("../../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session

if(isset($_SESSION['user'])){
    $start = $_GET['start'];
        $end = $_GET['end'];
        // echo $start;
        // echo $end;
    //query database
    // mysqli_query($link, "DELETE FROM req_absensi");
    $qry = "SELECT leave_alocation.id AS id_aloc,
    leave_alocation.effective_date AS eff_date,
    leave_alocation.end AS `end`,
    leave_alocation.type AS `type`,
    leave_alocation.id_leave AS id_leave,
    leave_alocation.alocation AS alocation,
    attendance_code.kode AS leave_code,
    attendance_code.attachment AS attachment,
    attendance_code.keterangan AS jenis_cuti,
    attendance_code.addition AS addition

    FROM leave_alocation 
    JOIN attendance_code ON leave_alocation.id_leave = attendance_code.kode 
    WHERE (leave_alocation.effective_date BETWEEN '$start' AND '$end') OR (leave_alocation.end BETWEEN '$start' AND '$end')
    ORDER BY `type` DESC, `effective_date` ASC, `end` ASC , id_leave ASC
    ";
    $qry_leave = mysqli_query($link, $qry)or die(mysqli_error($link));
// echo $qry;
// echo mysqli_num_rows($qry_leave);
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
            <table class="table table-striped table_org text-uppercase" id="uangmakan" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Cuti</th>
                        <th>Jenis Cuti</th>
                        <th>Alloc</th>
                        <th>Add</th>
                        <th>Eff</th>
                        <th>End</th>
                        <th>Type</th>
                        <th>Attach</th>
                        
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                if(mysqli_num_rows($qry_leave) > 0){
                    while($leave_aloc = mysqli_fetch_assoc($qry_leave)){
                        $attachment = (isset($leave_aloc))?(($leave_aloc['attachment']==0)?"NO":"YES"):"NO";
                        $attachment_color = (isset($leave_aloc))?(($leave_aloc['attachment']==0)?"":"title"):"";
                        ?>
                        <tr class="<?=$attachment_color?>">
                            <td><?=$no++?></td>
                            <td><?=$leave_aloc['id_leave']?></td>
                            <td><?=$leave_aloc['jenis_cuti']?></td>
                            <td><?=$leave_aloc['alocation']?></td>
                            <td><?=$leave_aloc['addition']?></td>
                            <td><?=tgl($leave_aloc['eff_date'])?></td>
                            <td><?=tgl($leave_aloc['end'])?></td>
                            <td><?=$leave_aloc['type']?></td>
                            <td>
                                <label for="" class="category <?=$attachment_color?>">
                                <i class="fa fa-paperclip"></i>
                                <?=$attachment?>
                                </label>
                                
                            </td>
                            <td class="text-right text-nowrap">
                                <button class="btn btn-sm btn-round btn-icon btn-attach btn-primary edit-attach "  data-name="<?=$leave_aloc['jenis_cuti']?>" data-id="<?=$leave_aloc['id_leave']?>" >
                                <i class="fas fa-cog"></i>
                                </button>
                                <span>
                                    <a href="edit.php?edit=<?=$leave_aloc['id_aloc']?>&kode=<?=$leave_aloc['id_leave']?>" class="btn-round  btn btn-warning  btn-icon btn-sm edit"><i class="fa fa-edit"></i></a>
                                </span>
                                <span>
                                    <a href="proses.php?del=<?=$leave_aloc['id_aloc']?>" class="btn-round  btn btn-danger  btn-icon btn-sm remove"><i class="fa fa-times"></i></a>
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
} 
  

?>

