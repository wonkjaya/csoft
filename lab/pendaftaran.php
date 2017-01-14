<?php require_once('Connections/lab.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "gagal.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "pendaftaran")) {
  $insertSQL = sprintf("INSERT INTO login (username, password) VALUES (%s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"));

  mysql_select_db($database_lab, $lab);
  $Result1 = mysql_query($insertSQL, $lab) or die(mysql_error());
}

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
	<title>Location - Laboratory Website Template</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
	<div id="header">
		<a href="index.html" class="logo"><img src="images/logo.png" alt=""></a>
		<ul>
			<li class="selected">
				<a href="pendaftaran.php">PENDAFTARAN</a>			</li>
			<li>
				<a href="tampildata.php">PEMERIKSAAN</a>			</li>
			<li>
				<a href="pencarian.php">PENCARIAN</a>			</li>
			<li>
				<a href="<?php echo $logoutAction ?>" onClick="return confirm('Apakah anda yakin keluar dari Aplikasi Register ?')">KELUAR</a>			</li>
		</ul>
	</div>
<?php
mysql_select_db($database_lab, $lab);
$carikode = mysql_query("SELECT max(no) FROM login", $lab) or die(mysql_error());
$datakode=mysql_fetch_array($carikode);
if($datakode){
$hasilkode=$datakode[0]+1;
}else{
$hasilkode=1;
}
?>
<div id="body">
		<div class="content">
		  <h2 align="center"><strong>pendaftaran Admin</strong></h2>
		  <form action="<?php echo $editFormAction; ?>" method="POST" name="pendaftaran" id="pendaftaran">
		    <div align="center">
		      <table width="200" border="0" bgcolor="#94ACB3">
		        <tr>
		          <td>No.</td>
		          <td colspan="2"><input name="textfield" type="text" size="10" maxlength="10"></td>
	            </tr>
		        <tr>
		          <td>Username </td>
                  <td colspan="2"><input name="username" type="text" id="username" maxlength="20"></td>
                </tr>
		        <tr>
		          <td>Password</td>
                  <td colspan="2"><input name="password" type="text" id="password" maxlength="20"></td>
                </tr>
		        <tr>
		          <td>&nbsp;</td>
                  <td><input type="reset" name="Reset" value="Hapus"></td>
                  <td><input type="submit" name="Submit2" value="Simpan"></td>
                </tr>
	          </table>
		      <input type="hidden" name="MM_insert" value="pendaftaran">
            </div>
		  </form>
		  <p align="left">&nbsp;</p>
		  <table width="495" border="1" align="center">
            <tr>
              <td width="96" bgcolor="#94ACB3"><div align="center"><strong>No.</strong></div></td>
              <td width="160" bgcolor="#94ACB3"><div align="center"><strong>Username</strong></div></td>
              <td width="160" bgcolor="#94ACB3"><div align="center"><strong>Password</strong></div></td>
              <td width="51" bgcolor="#94ACB3"><div align="center"><strong>Aksi</strong></div></td>
            </tr>
			<?php if ($row_Recordset1 > 0){ do { ?>
            <tr>
              <td><div align="center"><?php echo $row_Recordset1['no']; ?></div></td>
              <td><div align="center"><?php echo $row_Recordset1['username']; ?></div></td>
              <td><div align="center"><?php echo $row_Recordset1['password']; ?></div></td>
              <td><div align="center"><a href="delete_pendaftaran.php?id=<?php echo $row_Recordset1['no']; ?>" onClick="return confirm('Apakah anda yakin akan menghapus data pasien tersebut?')"><img src="b_drop.png" border="0"></a></div></td>
            </tr>
			<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); }elseif($_GET['search']==""){ echo '<td colspan="9"><div align="center"><h3>TIDAK ADA DATA</h3></div></td>'; }else{echo '<td colspan="9"><div align="center"><h3>TIDAK ADA DATA YANG DICARI</h3></div></td>';} ?>
          </table>
		  <p align="left">&nbsp; </p>
		  <p>&nbsp;</p>
  </div>
		<div class="sidebar">
          <h3>MENU</h3>
		  <ul>
            <li><span class="address">PEMERIKSAAN</span></li>
		    <li><span class="phone">TAMPIL DATA</span></li>
		    <li><span class="email">CARI DATA</span></li>
	      </ul>
  </div>
</div>
	<div id="footer"></div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>