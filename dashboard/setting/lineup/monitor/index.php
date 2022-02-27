<?php

//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php"); 
if(isset($_SESSION['user'])){
?>

<div class="table-hover table-responsive text-nowrap" >
    <table class="table" id="datatable" cellspacing="0" width="100%">
        <thead>
            <th>ACTION</th>
            <th>#</th>
            <th>AREA</th>
            <th>TIPE</th>
            <th>SHIFT</th>
            <th>LINE</th>
            <th>Group</th>
            <th>SECTION</th>
            <th>Σ MP</th>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($link, "SELECT * FROM view_area_sumary WHERE id_prod_model = '$_GET[model]' AND shift_area = '$_GET[shift]'
            ")or die(mysqli_error($link));
            
            
            // $sql_data = mysqli_query($link, $query)or die(mysqli_error($link));
            if(mysqli_num_rows($query)>0){
                $no = 1;
                while($data = mysqli_fetch_assoc($query)){
                    ?>
                    <tr>
                        <td>
                            <div class="btn btn-sm btn-success">detail mp</div>
                        </td>
                        <td><?=$no++?></td>
                        <td><?=$data['area_name']?></td>
                        <td><?=$data['type_area']?></td>
                        <td><?=$data['shift_area']?></td>
                        <td><?=$data['line_name']?></td>
                        <td><?=$data['group_area']?></td>
                        <td></td>
                        <td><?=$data['total_mp']?></td>
                        
                    </tr>
                    <?php
                }
            }else{
                ?>
                <tr>
                    <td colspan="9" class="text-uppercase text-center">belum ada data</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
<script>
    $(document).ready(function() {
      $('#datatable').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        responsive: false,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        }
      });

      var table = $('#datatable').DataTable();

      // Edit record
      table.on('click', '.edit', function() {
        $tr = $(this).closest('tr');

        var data = table.row($tr).data();
        alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
      });

      // Delete a record
      table.on('click', '.remove', function(e) {
        $tr = $(this).closest('tr');
        table.row($tr).remove().draw();
        e.preventDefault();
      });

      //Like record
      table.on('click', '.like', function() {
        alert('You clicked on Like button');
      });
    });
  </script>