<?php

//////////////////////////////////////////////////////////////////////
include("../../../../config/config.php");
$tahun = date('Y');
$today = date('Y-m-d');
require "../../../../_assets/vendor/autoload.php";
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
$mpdf->SetHTMLHeader('
<div style="text-align: right; ">
    <p style="font-size:8px;"> Document id :<em>'.md5($today).'</em> </p> 
</div>');
$mpdf->SetHTMLFooter('
<table width="100%">
    <tr>
        <td width="33%">{DATE j-m-Y}</td>
        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
        <td width="33%" style="text-align: right; font-style: italic">Generated in BAIS</td>
    </tr>
</table>');

if(isset($_SESSION['user'])){

    
    ob_start();
    if($level >=6 && $level <=8){
        if(isset($_POST['checked'])){
            $no =1;
            $date = '';
            $id_req = '';
            foreach($_POST['checked'] AS $data){
                $pecah = explode('&&', $data);
                
                $id = $pecah[0];
                $ket = $pecah[1];
                $shift_req = $pecah[2];
                $id_req .= " id_absensi = '$id' OR";
            }
        }
        ?>
        <table cellspacing="0" cellpadding="0" class="table  py-0" style="width:100%">
            <tbody >
                <tr class="py-0">
                    <td class="text-center" style="border:1px solid #D6DBDF; width:20px;" class="m-0 p-0">
                        <img src="../../../../assets/img/logo_daihatsu.png" alt="" style="width:100px ; margin: 0px; padding:1px">
                    </td>
                    <td class="text-center"  style="border:1px solid #D6DBDF; text-align: center; font-size:20px"  >
                        <h5 class="text-uppercase " >MEMO PERPINDAHAN SHIFT</h5>
                    </td>
                    
                    <td class="text-center text-uppercase title"  style="border:1px solid #D6DBDF; width:100px ; text-align: center; font-size:20px">
                        <h5 class="title"><?=$tahun?></h5>
                    </td>
                </tr>
                
            </tbody>
        </table>
        <p style="margin-top: 5%">Berikut Pengajuan shift Karyawan atas nama dan waktu sebagai berikut :</p>
        <table cellspacing="0" cellpadding="0" class="table  py-0" style="width:100%;">
            <thead>
                <tr style="background:#D6DBDF;">
                    <th style="border:1px solid #D6DBDF; width:20px;text-align: center; padding:2px">#</th>
                    <th style="border:1px solid #D6DBDF; width:20px;text-align: center; padding:2px">NPK</th>
                    <th style="border:1px solid #D6DBDF; width:20px;text-align: center; padding:2px">Nama</th>
                    <th style="border:1px solid #D6DBDF; width:20px;text-align: center; padding:2px">Mulai</th>
                    <th style="border:1px solid #D6DBDF; width:20px;text-align: center; padding:2px">Selesai</th>
                    <th style="border:1px solid #D6DBDF; width:20px;text-align: center; padding:2px">Shift Asal</th>
                    <th style="border:1px solid #D6DBDF; width:20px;text-align: center; padding:2px">Shift Tujuan</th>
                </tr>
                    
            </thead>
            <tbody >
                <?php
                    
                        $filter_id = ($id_req != '')?" AND (".substr($id_req, 0, -2).")":'';
                        $query = mysqli_query($link, "SELECT MIN(`req_work_date`) AS mulai, MAX(`req_work_date`) AS selesai, req_work_date, npk, nama, req_shift, employee_shift FROM view_absen_req WHERE shift_req = '1' AND req_code = 'SHIFT'  $filter_id GROUP BY nama, npk, req_shift")or die(mysqli_error($link));
                        while($data = mysqli_fetch_assoc($query)){
                            $npk = $data['npk'];
                            $nama = $data['nama'];
                            $start = $data['mulai'];
                            $end = $data['selesai'];
                            ?>

                            <tr class="py-0">
                                <td style="border:1px solid #D6DBDF; width:20px;text-align: center; padding:2px" >
                                    <?=$no++?>
                                </td>
                                <td style="border:1px solid #D6DBDF; width:20px;text-align: center; padding:2px" >
                                    <?=$npk?>
                                </td>
                                <td style="border:1px solid #D6DBDF; width:100px;text-align: center; padding:2px"  >
                                    <?=$nama?>
                                </td>
                                <td  style="border:1px solid #D6DBDF; width:20px;text-align: center; padding:2px">
                                <?=tgl($start)?>
                                </td>
                                <td  style="border:1px solid #D6DBDF; width:20px;text-align: center; padding:2px">
                                <?=tgl($end)?>
                                </td>
                                <td  style="border:1px solid #D6DBDF; width:20px;text-align: center; padding:2px">
                                <?=$data['employee_shift']?>
                                </td>
                                <td  style="border:1px solid #D6DBDF; width:20px;text-align: center; padding:2px">
                                <?=$data['req_shift']?>
                                </td>
                            </tr>
                            <?php
                        }
                ?>
            </tbody>
        </table>
        
        <p style="width:60%; margin-top:100px">Jakarta , <?=tgl($today)?></p>
        <table cellspacing="0" cellpadding="0" class="table  py-0" style="width:60%; ">
            <tbody >
                <tr class="py-0">
                    <td class="text-center" style="padding-bottom:100px; width:50%;">
                        Diketahui
                    </td>
                    <td>    </td>
                    <td class="text-center"  style="padding-bottom:100px; width:50%"  >
                        Disetujui
                    </td>
                    
                </tr>
                <tr class="py-0">
                    <td style="border-top: 1px dotted black; padding-top:10px; font-style: italic;"  >
                    (Section Head)
                    </td>
                    <td style="padding-left:50px">   </td>
                    <td style="border-top: 1px dotted black; padding-top:10px; font-style: italic;"  >
                        (Department Head)
                    </td>
                    
                </tr>
                
            </tbody>
        </table>
        <?php
        $nama_dokumen = "Memo_Perubahan_Shift_";
       
        $html = ob_get_contents();
        ob_end_clean();
        // ob_end_flush();
        $mpdf->AddPage('P');
        // $mpdf->setFooter('{PAGENO}');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($nama_dokumen.$today.".pdf" ,'D');
        $db1->close();
    }else{
        include_once ("../../../no_access.php");
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>