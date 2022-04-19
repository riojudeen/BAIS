<?php 
//////////////////////////////////////////////////////////////////////
include("../config/config.php");
//redirect ke halaman dashboard index jika sudah ada session

if(isset($_SESSION['user'])){
  if(isset($_POST['interaction'])){
      mysqli_query($link, "INSERT INTO user_interaction (user) VALUES ('$npkUser')");
  }

}

?>