<?php
//////////////////////////////////////////////////////////////////////
require_once("../../../../config/config.php");
// mencari data department
if(isset($_POST['save'])){

}else if(isset($_POST['del'])){
    
}
$sub_pos = $_POST['sub_pos'];
$pos = $_POST['pos'];
$group = $_POST['group'];
$sect = $_POST['sect'];
$npk = $_POST['npk'];
// echo $sub_pos;

$q_org = "SELECT section.id_section AS `id_section`,
department.id_dept AS `id_dept`,
division.id_div AS `id_div`,
company.id_company AS `id_plant`
FROM section JOIN department ON department.id_dept = section.id_dept
JOIN division ON division.id_div = department.id_div 
JOIN company ON company.id_company = division.id_company WHERE section.id_section = '$sect'";
$sql = mysqli_query($link, $q_org)or die(mysqli_error($link));
$data = mysqli_fetch_assoc($sql);
$dept = $data['id_dept'];
$div = $data['id_div'];
$plant = $data['id_plant'];

$q_addpos = "REPLACE INTO pos (`npk_cord`,`nama`,`id_pos_leader`,`part`) VALUES('$npk','$sub_pos','$pos','subpos')";
mysqli_query($link, $q_addpos)or die(mysqli_error($link));
mysqli_query($link, "INSERT INTO org (`npk`,`sect`,`grp`,`dept`,`division`,`plant`) VALUES('$npk','$sect','$group','$dept','$div','$plant')")or die(mysqli_error($link));
?>