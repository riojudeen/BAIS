<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 
//redirect ke halaman dashboard index jika sudah ada session
if(isset($_SESSION['user'])){
    $data_category = $_GET['data'];
    $cari = (isset($_GET['cari']) && $_GET['cari'] != '')?" AND (nama LIKE '%$_GET[cari]%' OR alamat LIKE '%$_GET[cari]%' OR kota LIKE '%$_GET[cari]%')":"";
    $data_cat = $_GET['data_cat'];
    $query = " SELECT nama, alamat, kota, category FROM hospital WHERE category = '$data_cat' ".$cari;
    // $sql  = mysqli_query($link, $query)or die(mysqli_error($link));


    $sql_jml = mysqli_query($link, $query)or die(mysqli_error($link));
    $total_records= mysqli_num_rows($sql_jml);
    // echo $total_records;

    $page = (isset($_GET['page']) && ($_GET['page'] != 'undefined' OR $_GET['page'] != ''))? $_GET['page'] : 1;
    // echo $page;
    $limit = 50; 
    $limit_start = ($page - 1) * $limit;
    $no = $limit_start + 1;
    // echo $limit_start;
    $addOrder = " ORDER BY kota, nama, alamat ASC ";
    $addLimit = " LIMIT $limit_start, $limit";
    

    // pagin
    $jumlah_page = (ceil($total_records / $limit)<=0)?1:ceil($total_records / $limit);
    
    $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
    $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
    $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
    

    $sql = mysqli_query($link, $query.$addOrder.$addLimit)or die(mysqli_error($link));
    
    
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped text-uppercase ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Faskes</th>
                            <th>Nama Alamat</th>
                            <th>Kota</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(mysqli_num_rows($sql)>0){
                           
                           while($data = mysqli_fetch_assoc($sql)){
                               ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$data['nama']?></td>
                                    <td><?=$data['alamat']?></td>
                                    <td class="text-nowrap"><?=$data['kota']?></td>
                                    
                                </tr>
                               <?php
                           }
                        }else{
                            ?>
                            <tr>
                                <td colspan="5" class="text-center">Data Belum tersedia</td>
                            </tr>
                            <?php
                        }

                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 pull-rigt">
            <ul class="pagination ">
            <?php
            // echo $page."<br>";
            // echo $jumlah_page."<br>";
            // echo $jumlah_number."<br>";
            // echo $start_number."<br>";
            // echo $end_number."<br>";
            if($page == 1){
                echo '<li class="page-item disabled"><a class="page-link" >First</a></li>';
                echo '<li class="page-item disabled"><a class="page-link" ><span aria-hidden="true">&laquo;</span></a></li>';
            } else {
                $link_prev = ($page > 1)? $page - 1 : 1;
                echo '<li class="page-item halaman" id="1"><a class="page-link" >First</a></li>';
                echo '<li class="page-item halaman" id="'.$link_prev.'"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
            }

            for($i = $start_number; $i <= $end_number; $i++){
                $link_active = ($page == $i)? ' active page_active' : '';
                echo '<li class="page-item halaman '.$link_active.'" id="'.$i.'"><a class="page-link" >'.$i.'</a></li>';
            }

            if($page == $jumlah_page){
                echo '<li class="page-item disabled"><a class="page-link" ><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item disabled"><a class="page-link" >Last</a></li>';
            } else {
                $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
                echo '<li class="page-item halaman" id="'.$link_next.'"><a class="page-link" ><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item halaman" id="'.$jumlah_page.'"><a class="page-link" >Last</a></li>';
            }
            ?>
            </ul>
        </div>
    </div>
    <?php
} 
	

?>
 <!-- <script>
    $(document).ready(function(){
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            items:1,
            loop:true,
            margin:10,
            autoplay:false,
            autoplayTimeout:3000,
            autoplayHoverPause:true
        });
    });
</script> -->