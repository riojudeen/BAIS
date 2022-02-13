<?php
include("../../../config/config.php"); 
require_once("../../../config/function_status_approve.php");
require_once("../../../config/function_access_query.php");
require_once("../../../config/function_filter.php");
list($clm_access, $area_access, $sub_area_access, $value_access) = access_area_jabatan($link, $jabatan, $npkUser);

if(isset($_SESSION['user'])){
    $org = (isset($_POST['org'])) ? $_POST['org'] : "";
    
    if(isset($_POST['shf'])){
        $shift = '' ;
        foreach($_POST['shf'] AS $shf){
            $shift .= "OR karyawan.shift = '$shf' ";
        }
    }else{
        $shift = "";
    }

    $shiftMp = ($shift != "")? 'AND ('.substr($shift, 2).')': "";
        
    // print_r($org);
    // echo $sub_area_access;
    // echo $levelJabatan;
    // echo $clm_access;
    // echo $_SESSION['ot_date'];
    // echo $shiftMp;

    ?>
    <div class="ini table-responsive " style="max-height:500px">
        <table class="table pilih table-bordered">
            <colgroup>
                <col style="width: 50px">
                <col style="width: 100px">
                <col style="width: 400px">
                <col style="width: 100px">
                <col style="width: 100px">
                <col style="width: 60px">
                <col style="width: 50px">
            </colgroup>
            <thead class="bg-warning">
                <th>#</th>
                <th>Npk</th>
                <th>Nama</th>
                <th>Area</th>
                <th>Shift</th>
                <th>Jbt</th>
                <th class="text-right">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="allmp"">
                            <span class="form-check-sign"></span>
                        </label>
                    </div>
                </th>
            </thead>
            <tbody style="overflow-y:auto">
            <?php
            if(isset($_POST['org'])){
                //jika ada area diselect
                $jml_select = count($_POST['org']);
                if($jml_select > 0){
                    $no_mp = 1;
                    foreach($_POST['org'] AS $org){
                        // echo $org;
                        $t = "org.".$org_access;
                            if($levelJabatan  >= 1 && $levelJabatan  <= 2){
                                $clm2 = "dept";
                                $clm3 = "id_dept";
                                $tbl2 = "department";
                            }else if($levelJabatan  >= 3 && $levelJabatan  <= 4){
                                $clm2 = "section";
                                $clm3 = "id_section";
                                $tbl2 = "section";
                                
                            }else if($levelJabatan  >= 5 && $levelJabatan  <= 6){
                                $clm2 = "nama_group";
                                $clm3 = "id_group";
                                $tbl2 = "groupfrm";
                                
                            }else if($levelJabatan  >= 7 && $levelJabatan  <= 8){
                                $clm2 = "nama_pos";
                                $clm3 = "id_post";
                                $tbl2 = "pos_leader";
                                
                            }else if($levelJabatan  >= 9 && $levelJabatan  <= 10){
                                $clm2 = "nama_pos";
                                $clm3 = "id_post";
                                $tbl2 = "pos_leader";
                                
                            }else if($levelJabatan  >= 11 ){
                                $clm2 = "nama_pos";
                                $clm3 = "id_post";
                                $tbl2 = "pos_leader";
                            }
                        $qryData = "SELECT req_absensi.id AS id_absen,  
                            req_absensi.npk AS npk_absen, 
                            req_absensi.shift AS shift_absen,
                            req_absensi.date AS tanggal,
                            req_absensi.date_in AS tanggal_masuk,
                            req_absensi.date_out AS tanggal_keluar,
                            req_absensi.check_in AS check_in,
                            req_absensi.check_out AS check_out,
                            req_absensi.keterangan AS keterangan,
                            req_absensi.requester AS requester,
                            req_absensi.status AS status_absen,
                            req_absensi.req_status AS req_status,
                            req_absensi.req_date AS req_date,

                            lembur._id AS id_lembur, 
                            lembur.kode_lembur AS kode_lembur, 
                            lembur.requester AS requester, 
                            lembur.npk AS npk_lembur, 
                            lembur.in_date AS inDate_lembur, 
                            lembur.out_date AS outDate_lembur, 
                            lembur.in_lembur AS in_lembur, 
                            lembur.out_lembur AS out_lembur, 
                            lembur.kode_job AS kode_job, 
                            lembur.aktifitas AS aktivity, 
                            lembur.status_approve AS status_approve, 
                            lembur.status AS status_lembur,

                            dept_account.id_dept_account AS idDeptAcc,
                            dept_account.department_account AS deptAcc,
                            dept_account.npk_dept AS mg, 
                            dept_account.id_div AS id_div,

                            groupfrm.id_group AS idGroup,
                            groupfrm.nama_group AS groupfrm,
                            groupfrm.npk_cord AS group_cord,
                            groupfrm.id_section AS id_sect,

                            org.npk AS npk_org,
                            org.sub_post AS sub_post,
                            org.post AS post,
                            org.grp AS grp,
                            org.sect AS sect,
                            org.dept AS dept,
                            org.dept_account AS dept_account,
                            org.division AS division,
                            org.plant AS plant,

                            karyawan.npk AS npk_,
                            karyawan.nama AS nama_,
                            karyawan.shift AS shift_,
                            karyawan.id_area AS id_area_,
                            karyawan.department AS department_

                            FROM karyawan
                            LEFT JOIN lembur ON karyawan.npk = lembur.npk
                            LEFT JOIN req_absensi ON karyawan.npk = req_absensi.npk
                            LEFT JOIN org ON org.npk = karyawan.npk
                            
                            LEFT JOIN dept_account ON dept_account.id_dept_account = org.dept_account
                            LEFT JOIN groupfrm ON groupfrm.id_group = org.grp WHERE lembur.npk IS NULL";

                        
                        $s_getmp = mysqli_query($link, "SELECT karyawan.nama AS nama,
                        karyawan.npk AS npk,
                        karyawan.shift AS shift,
                        karyawan.jabatan AS jabatan,

                        org.npk AS npk_org,
                        org.sub_post AS sub_post,
                        org.post AS post,
                        org.grp AS grp,
                        org.sect AS sect,
                        org.dept AS dept,
                        org.dept_account AS dept_account,
                        org.division AS division,
                        org.plant AS plant,

                        $tbl2.$clm2 AS area
                        
                        FROM karyawan
                        JOIN org ON org.npk = karyawan.npk 
                        JOIN $tbl2 ON $tbl2.$clm3 = $sub_area_access
                        WHERE $sub_area_access = '$org' AND $area_access = '$value_access' $shiftMp ")or die(mysqli_error($link));
                        
                        if($jml_getmp = mysqli_num_rows($s_getmp) > 0){
                            while($getmp = mysqli_fetch_assoc($s_getmp)){
                                $id = $getmp['npk'].dateToDB($_SESSION['ot_date']);

                                $check = mysqli_query($link, "SELECT * FROM lembur WHERE _id = '$id'");
                                $disable = (mysqli_num_rows($check) > 0)?"disabled":"";
                                $text_color = (mysqli_num_rows($check) > 0)?"text-success":"";
                                echo "<tr class=\"$text_color\">";
                                echo "<td>".$no_mp++."</td>";
                                echo "<td>$getmp[npk]</td>";
                                echo "<td>$getmp[nama]</td>";
                                echo "<td>$getmp[area]</td>";
                                echo "<td>$getmp[shift]</td>";
                                echo "<td>$getmp[jabatan]</td>";
                                ?>
                                
                                <?php
                                if(mysqli_num_rows($check) <= 0){
                                ?>
                                <td>
                                    <div class="form-check float-right  ">
                                        <label class="form-check-label">
                                            <input class="form-check-input check mp >"  name="npk[]" value="<?=$getmp['npk']?>" type="checkbox">
                                        <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </td>
                                <?php
                                }else{
                                    ?>
                                <td >
                                    <i class="nc-icon nc-check-2"></i>
                                </td>
                                    <?php
                                    
                                }
                                
                                echo "</tr>";
                            }
                        }else{
                            echo "<tr>";
                            echo "<td colspan=\"8\" class=\"text-center bg-light\">tidak ada data man power untuk area $org</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot class="bg-warning">
                        <th>#</th>
                        <th>Npk</th>
                        <th>Nama</th>
                        <th>Area</th>
                        <th>Shift</th>
                        <th>Jbt</th>
                        <th class="text-right">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input"  type="checkbox" id="all">
                                    <span class="form-check-sign"></span>
                                </label>
                            </div>
                        </th>
                    </tfoot>
                </table>
            </div>
            <br>
            <?php
        }else{
            ?>
            <tr>
                <td class="text-uppercase text-center" colspan="7">DATA TIDAK DITEMUKAN DI DATABASE</td>
            </tr>
            <?php
        }
    }else{
        ?>
         <tr>
            <td class="text-uppercase text-center" colspan="7">AREA BELUM DIPILIH</td>
        </tr>
        <?php
        $jml_select = 0;
    }
    ?>
    <script>
        $(document).ready(function(){
            $('#allmp').on('click', function() {
                if(this.checked){
                    $('.mp').each(function() {
                        this.checked = true;
                    })
                } else {
                    $('.mp').each(function() {
                        this.checked = false;
                    })
                }

            });
            $('#all').on('click', function() {
                if(this.checked){
                    $('.mp').each(function() {
                        this.checked = true;
                    })
                } else {
                    $('.mp').each(function() {
                        this.checked = false;
                    })
                }

            });

            $('.mp').on('click', function() {
                if($('.mp:checked').length == $('.mp').length){
                    $('#allmp').prop('checked', true)
                    $('#all').prop('checked', true)
                } else {
                    $('#allmp').prop('checked', false)
                    $('#all').prop('checked', false)
                }
            })
        })
    </script>
    <?php
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
  }
?>
