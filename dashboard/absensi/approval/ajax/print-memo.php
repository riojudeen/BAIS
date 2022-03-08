<?php

//////////////////////////////////////////////////////////////////////
include("../../../../config/config.php");

require "../../../../_assets/vendor/autoload.php";
$mpdf = new \Mpdf\Mpdf();
if(isset($_SESSION['user'])){

    $tahun = date('Y');
    $today = date('Y-m-d');
    if($level >=6 && $level <=8){
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
        <p>Berikut Pengajuan shift Karyawan atas nama dan waktu sebagai berikut :</p>
        <table cellspacing="0" cellpadding="0" class="table  py-0" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NPK</th>
                    <th>Nama</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                </tr>
                    
            </thead>
            <tbody >
                <tr class="py-0">
                    <td class="text-center" style="border:1px solid #D6DBDF; width:20px;" class="m-0 p-0">
                        1
                    </td>
                    <td class="text-center"  style="border:1px solid #D6DBDF; text-align: center; "  >
                        44131
                    </td>
                    <td class="text-center"  style="border:1px solid #D6DBDF; text-align: center;"  >
                        Rio Setiawan Judin
                    </td>
                    <td class="text-center text-uppercase title"  style="border:1px solid #D6DBDF; width:100px ; text-align: center; ">
                        01 jan 2022
                    </td>
                    <td class="text-center text-uppercase title"  style="border:1px solid #D6DBDF; width:100px ; text-align: center; ">
                        01 jan 2022
                    </td>
                </tr>
                <tr class="py-0">
                    <td class="text-center" style="border:1px solid #D6DBDF; width:20px;" class="m-0 p-0">
                        2
                    </td>
                    <td class="text-center"  style="border:1px solid #D6DBDF; text-align: center; "  >
                        44131
                    </td>
                    <td class="text-center"  style="border:1px solid #D6DBDF; text-align: center;"  >
                        Rio Setiawan Judin
                    </td>
                    <td class="text-center text-uppercase title"  style="border:1px solid #D6DBDF; width:100px ; text-align: center; ">
                        01 jan 2022
                    </td>
                    <td class="text-center text-uppercase title"  style="border:1px solid #D6DBDF; width:100px ; text-align: center; ">
                        01 jan 2022
                    </td>
                </tr>
                <tr class="py-0">
                    <td class="text-center" style="border:1px solid #D6DBDF; width:20px;" class="m-0 p-0">
                        3
                    </td>
                    <td class="text-center"  style="border:1px solid #D6DBDF; text-align: center; "  >
                        44131
                    </td>
                    <td class="text-center"  style="border:1px solid #D6DBDF; text-align: center;"  >
                        Rio Setiawan Judin
                    </td>
                    <td class="text-center text-uppercase title"  style="border:1px solid #D6DBDF; width:100px ; text-align: center; ">
                        01 jan 2022
                    </td>
                    <td class="text-center text-uppercase title"  style="border:1px solid #D6DBDF; width:100px ; text-align: center; ">
                        01 jan 2022
                    </td>
                </tr>
                
                
                
            </tbody>
        </table>
        <p>Jakarta ,</p>
        <p style="margin-top:50px">(Supervisor)</p>
        <?php
        $nama_dokumen = "Tes";
        $html = ob_get_contents();
        ob_end_clean();
        ob_end_flush();
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($nama_dokumen.".pdf" ,'D');
        $db1->close();
    }else{
        include_once ("../../../no_access.php");
    }
} else{
    echo "<script>window.location='".base_url('auth/login.php')."';</script>";
}
?>