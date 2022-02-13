<?php
//////////////////////////////////////////////////////////////////////
require_once("../config/config.php"); 

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?=base_url()?>/dashboard/img/logo.png" type="image/png">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>BAIS | 404 Page Not Found</title>
	<style>
    @font-face {
        font-family: hotel_de_paris;
        src: url('<?=base_url()?>/assets/font/hotel_de_paris.ttf') format('truetype');
    }

    </style>
  
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="<?=base_url('assets/css/stylefonts.css?family=Montserrat:400,700,200')?>" rel="stylesheet"/>

	<!-- Google font -->
	<!-- <link href="https://fonts.googleapis.com/css?family=Montserrat:300,700" rel="stylesheet"> -->

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="css/style.css" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body>

	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1>4<span></span>4</h1>
			</div>
			<h2>Oops! Page Not Be Found</h2>
			<p>Maaf, sepertinya halaman yang ada cari tidak tersedia. Namanya ganti atau kayaknya kamu salah ketik, deh!</p>
			<a href="<?=base_url()?>/dashboard/">Back to homepage</a>
		</div>
	</div>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
