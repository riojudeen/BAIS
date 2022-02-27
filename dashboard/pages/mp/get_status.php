<?php

include("../../../config/config.php"); 

$jbtn = $_POST['jabatan'];

if ($jbtn == "TM" ){
    echo "<option value=\"C1\">Kontrak 1</option><option value=\"C2\">Kontrak 2</option><option value=\"P\">Permanent</option>";

} else {
    echo "<option value=\"P\">Permanent</option>";
}

                                      ?>
