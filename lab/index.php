<?php require_once('Connections/lab.php'); ?>
<?php
mysql_select_db($database_lab, $lab);
$query_Recordset1 = "SELECT * FROM login";
$Recordset1 = mysql_query($query_Recordset1, $lab) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "password";
  $MM_redirectLoginSuccess = "berhasil.php";
  $MM_redirectLoginFailed = "gagal.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_lab, $lab);
  	
  $LoginRS__query=sprintf("SELECT username, password, password FROM login WHERE username='%s' AND password='%s'",
  get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $lab) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'password');
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE HTML>
<!-- Website Template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Laboratory Website Template</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
    <style type="text/css">
<!--
.style1 {font-weight: bold}
-->
    </style>
</head>
<body>
	<div id="header">
		<a href="index.html" class="logo"><img src="images/logo.png" alt=""></a>
		<ul>
			<li><strong>
			  <a href="home.php">home</a></strong></li>
			  <li class="selected">
				<a href="index.php"><strong>Login</strong></a>	</li>
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
				<h2 align="center"><strong>Halaman Login</strong></h2>
			    <form name="login" method="post" action="<?php echo $loginFormAction; ?>">
			      <table width="300" align="center">
                    <tr>
                      <td width="91"><strong>Username : </strong></td>
                      <td colspan="2"><input name="username" type="text" id="username" class="style1"></td>
                    </tr>
                    <tr>
                      <td><strong>Password : </strong></td>
                      <td colspan="2"><input name="password" type="password" id="password" class="style1"></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td width="79"><input name="Submit2" type="reset" class="style1" value="Batal">                      </td>
                      <td width="114"><input name="Submit" type="submit" value="Masuk" class="style1"></td>
                    </tr>
                  </table>
          </form>
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