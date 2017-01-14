<?php require_once('Connections/lab.php'); ?>
<?php
mysql_select_db($database_lab, $lab);
$query_Recordset1 = "SELECT * FROM login";
$Recordset1 = mysql_query($query_Recordset1, $lab) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?><!DOCTYPE HTML>
<!-- Website Template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Laboratory Website Template</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
    </style>
</head>
<body>
	<div id="header">
		<a href="index.html" class="logo"><img src="images/logo.png" alt=""></a>
		<ul>
			<li><strong>
			  <a href="home.php">home</a></strong></li>
			<li>
				<a href="index.php"><strong>Login</strong></a></li>
		</ul>
	</div>
	<div id="section">
		<div>
			<div>
				<h1 align="center"><strong>Puskesmas mojolangu malang</strong></h1>
				<h3 align="center">Jl. Sudimoro No.17 - Malang,  Telp. (0341) 482905, Kode Pos 65142.</h3>
		  </div>
		</div>
	</div>
	<div id="featured" >
	  <div>
	    <div class="article">
				<h2 align="center" class="style1"><strong>&quot;Ma'af kata Sandi yang anda masukan salah&quot; </strong></h2>
				<h2 align="center" class="style1"><span class="style1"><strong><a href="index.php">coba lagi</a></strong></span></h2>
				<p>&nbsp;</p>
	    </div>
	  </div>
</div>
<div id="footer"></div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>