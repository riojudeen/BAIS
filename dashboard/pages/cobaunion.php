<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 

//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Man Power";
if(isset($_SESSION['user'])){

    include("../header.php");

//query


?>
    
    <div class="row">
        <div class="col-md-12">
            
                <div class="card " style='border: 1px solid #FFB32E; color:#FFB32E; background:#FFF9D1;'>
                    <div class="card-header ">
                        <a href="pos/generate.php" type="button" class="btn btn-md btn-default btn-round btn-icon pull-right"><i class="fa fa-plus"></i></a>
                        <h5 class="card-title">Data Join</li>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="height:200">                    
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Area</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php
                                        $no = 1;
                                        $query = "SELECT * FROM karyawan";
                                        $sqlmp = mysqli_query($link, $query)or die(mysqli_error($link));

                                        while($data = mysqli_fetch_assoc($sqlmp)){
                                            $jabatan = $data['jabatan'];
                                            if($jabatan == "TM"){
                                                $table_set = "pos_leader";
                                                $id = "id_post";
                                                $npk = $data['npk'];
                                                $join = mysqli_query($link,"SELECT * FROM karyawan LEFT JOIN 
                                                        $table_set ON karyawan.id_area = $table_set.$id WHERE karyawan.npk = $npk")or die(mysqli_error($link));
                                                $datajoin = mysqli_fetch_assoc($join);
                                                $jmldata = mysqli_num_rows($join);
                                            }
                                            
                                                echo "<tr><td>".$no++."<td>".$datajoin['nama']."</td><td>".$datajoin['jabatan']."</td><td>".$npk."<tr>";
                                            
                                            
                                            
                                            
                                            
    
                                        }
                                        

                                        ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer ">
                        
                        
                            <div style="float:left;">
                                
                            </div>
                                    
                            <div style="float:right">
                                <ul class="pagination pagination-sm">
                                
                                    
                                
                                </ul>
                            </div>
                            
                            
                            
                            <div class="stats">
                            
                            
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    //untuk crud masal update department
        function edit() {
            document.prosesdept.action = 'dept/edit.php';
            document.prosesdept.submit();
        }
        function hapus() {            
            var conf = confirm('yakin ingin menghapus data? ');
            if (conf) {
                document.prosesdept.action ='dept/delete.php';
                document.prosesdept.submit();
            }        
        }
    </script>
    <script>
//untuk data tables
/*
    $(document).ready(function(){
        $('#table_mp').DataTable({
            
            columnDefs: [
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": [0, ,9, 10]
                }
            ],
            "order": [1,"asc"]
        });
    })
    */
</script>
<script>
		$(document).ready(function() {
		  $('#searching').on('shown.bs.modal', function() {
			$('#focusInput').trigger('focus');
		  });
		});	
	</script>
    <?php

    ///////////////////////////////////////
    

    // tutup koneksi dengan database mysql
    mysqli_close($link);

    ?>

    <?php
    //footer
        include_once("../footer.php");

} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
  

?>