<DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Belajar Database</title>
        <?php
            include("con_karyawan.php");

        ?>
    </head>
    <body>
        <table border="1px">
        <tr>
        <?php
            $data_MP = mysql_query ("SELECT * FROM karyawan where tanggal_masuk>'2002-01-01' && tanggal_masuk<'2006-01-01'");


            while ($data = mysql_fetch_array($data_MP)){
                $nama=$data["nama"];
                echo "<td>".$nama."</td>";

                $nama<=3;
            }
            echo "</tr>"
           

        ?>
        
       </table>

    </body>

    
    
    
    </html>
