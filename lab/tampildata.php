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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "pemeriksaan")) {
  $insertSQL = sprintf("INSERT INTO tabelpemeriksaan 
    (no_rm, nama, umur, alamat, jenis_kelamin, jenis_pasien, dokter, kategori, 
    sub_kategori, pemeriksaan, pembayaran, tanggal, hasil) 
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
     GetSQLValueString($_POST['no_rm'], "text"),
     GetSQLValueString($_POST['nama'], "text"),
     GetSQLValueString($_POST['umur'], "int"),
     GetSQLValueString($_POST['alamat'], "text"),
     GetSQLValueString($_POST['jenis_kelamin'], "text"),
     GetSQLValueString($_POST['jenis_pasien'], "text"),
     GetSQLValueString($_POST['dokter'], "text"),
     GetSQLValueString($_POST['kategori'], "text"),
     GetSQLValueString($_POST['sub_kategori'], "text"),
     GetSQLValueString($_POST['pemeriksaan'], "text"),
     GetSQLValueString($_POST['pembayaran'], "text"),
     GetSQLValueString($_POST['tgl'], "text"),
     GetSQLValueString($_POST['hasil'], "text"));

  mysql_select_db($database_lab, $lab);
  $Result1 = mysql_query($insertSQL, $lab) or die(mysql_error());
  echo "<script>alert('Berhasil'); </script>";
  echo "<script> document.location.href='tampildata.php'; </script>";
}

mysql_select_db($database_lab, $lab);
if(isset($_GET['q'])){
  $where = ' no_rm = ' . $_GET['q'];
}else{
  $where = ' 1';
}
$query_Recordset1 = "SELECT * FROM tabelpemeriksaan WHERE ". $where;
$Recordset1 = mysql_query($query_Recordset1, $lab) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
<!DOCTYPE HTML>
<!-- Website Template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Services - Laboratory Website Template</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">

  <link href="delete_data.php" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="header">
		<a href="index.html" class="logo"><img src="images/logo.png" alt=""></a>
		<ul>
			<li>
				<a href="pendaftaran.php">PENDAFTARAN</a>			</li>
			<li class="selected">
				<a href="tampildata.php">PEMERIKSAAN</a>			</li>
			<li>
				<a href="pencarian.php">PENCARIAN</a>			</li>
			<li>
				<a href="<?php echo $logoutAction ?>" onClick="return confirm('Apakah anda yakin keluar dari Aplikasi Register ?')">KELUAR</a></li>
		</ul>
	</div>
<?php
mysql_select_db($database_lab, $lab);
$carikode = mysql_query("SELECT max(no) FROM tabelpemeriksaan", $lab) or die(mysql_error());
$datakode=mysql_fetch_array($carikode);
if($datakode){
$hasilkode=$datakode[0]+1;
}else{
$hasilkode=1;
}
?>
	<div id="body">
	  <div align="left">
	    <h1 align="center" class="style2">Pemeriksaan Pasien </h1>
	    <form name="pemeriksaan" method="POST" action="<?php echo $editFormAction; ?>">
	      <table width="373" align="center" bgcolor="#94ACB3" class="style1">
            <tr>
              <td>No. Rekam Medis </td>
              <td><strong>:</strong></td>
              <td colspan="2"><input name="no_rm" type="text" id="no_rm" maxlength="6"></td>
            </tr>
            <tr>
              <td>Nama</td>
              <td><strong>:</strong></td>
              <td colspan="2"><input name="nama" type="text" id="nama" maxlength="50"></td>
            </tr>
            <tr>
              <td>Umur</td>
              <td><strong>:</strong></td>
              <td colspan="2"><input name="umur" type="text" id="umur" size="5" maxlength="3"></td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td><strong>:</strong></td>
              <td colspan="2"><textarea name="alamat" id="alamat"></textarea></td>
            </tr>
            <tr>
              <td>Jenis Kelamin </td>
              <td><strong>:</strong></td>
              <td colspan="2"><strong>
                <label>
                <select name="jenis_kelamin" id="jenis_kelamin" required>
                  <option value="L">LAKI-LAKI</option>
                  <option value="P">PEREMPUAN</option>
                </select>
                </label>
              </strong></td>
            </tr>
            <tr>
              <td>Jenis Pasien </td>
              <td><strong>:</strong></td>
              <td colspan="2"><strong>
                <select name="jenis_pasien" size="1" id="jenis_pasien" required>
                  <option>BPJS</option>
                  <option>UMUM</option>
                </select>
                <label></label>
              </strong></td>
            </tr>
            <tr>
              <td>Dokter Pengirim </td>
              <td><strong>:</strong></td>
              <td colspan="2"><strong>
                <label>
                <input name="dokter" type="text" id="dokter" maxlength="100">
                </label>
              </strong></td>
            </tr>
            <tr>
              <td>Kategori</td>
              <td><strong>:</strong></td>
              <td colspan="2"><strong>
                <select name="kategori" size="1" id="kategori" required>
                  <option>NONE</option>
                  <option>HEMATOLOGI</option>
                  <option>URINALISA</option>
                </select>
                <label></label>
              </strong></td>
            </tr>
            <tr>
              <td>Sub Kategori </td>
              <td><strong>:</strong></td>
              <td colspan="2"><strong> </strong>
                  <select name="sub_kategori" size="1" id="sub_kategori" required>
                    <option>NONE</option>
                    <option>DARAH LENGKAP</option>
                  </select>
                  <strong>
                    <label></label>
                </strong></td>
            </tr>
            <tr>
              <td>Nama Pemeriksaan </td>
              <td><strong>:</strong></td>
              <td colspan="2"><select name="pemeriksaan" size="1" id="pemeriksaan" required>
                  <option>NONE</option>
                  <option>LEUKOSIT</option>
                  <option>HEMOGLOBIN</option>
                  <option>LED</option>
                  <option>TROMBOSIT</option>
                  <option>HEMATROKIT</option>
                  <option>ERITROSIT</option>
                  <option>WARNA</option>
                </select>              </td>
            </tr>
            <tr>
              <td>Biaya</td>
              <td><strong>:</strong></td>
              <td colspan="2"><strong>
                <label>
                <input name="pembayaran" type="text" id="pembayaran" maxlength="15">
                </label>
              </strong></td>
            </tr>
            <tr>
              <td height="19">Tanggal</td>
              <td><strong>:</strong></td>
              <td colspan="2"><?php $tanggal=date("l, d/m/Y H:i:s"); echo $tanggal; ?></td>
			  <input type="hidden" id="tgl" name="tgl" value="<?php echo $tanggal; ?>">
            </tr>
            <tr>
              <td height="19">Hasil</td>
              <td><strong>:</strong></td>
              <td colspan="2"><textarea name="hasil" id="hasil"></textarea></td>
            </tr>
            <tr>
              <td height="19">&nbsp;</td>
              <td>&nbsp;</td>
              <td><input type="reset" name="Submit3" value="Hapus"></td>
              <td><input type="submit" name="Submit" value="Simpan"></td>
            </tr>
          </table>
	      <input type="hidden" name="MM_insert" value="pemeriksaan">
	    </form>
	    <p>&nbsp;</p>
      </div>
      <style type="text/css">
        .pencarian{
          text-decoration: none;
        }
      </style>
	  <ul><li>
	    <h1 class="style3">Hasil Pemeriksaan <?php if(isset($_GET['q'])) echo '<a class="pencarian" href="pencarian.php?default='.$_GET['q'].'">Pencarian</a>' ?></h1>
	    <form name="hasil" method="post" action="">
	      <table width="989" align="center" bgcolor="#CCCCCC">
            <tr>
              <td width="35" bgcolor="#94ACB3"><p align="center"><strong>No.</strong></p></td>
              <td width="52" bgcolor="#94ACB3"><p align="center"><strong>No RM </strong></p></td>
              <td width="74" bgcolor="#94ACB3"><div align="center"><strong>Nama</strong></div></td>
              <td width="98" bgcolor="#94ACB3"><p align="center"><strong>Kategori</strong></p></td>
              <td width="115" bgcolor="#94ACB3"><p align="center"><strong>Sub Kategori </strong></p></td>
              <td width="140" bgcolor="#94ACB3"><p align="center"><strong>Nama Pemeriksaan </strong></p></td>
              <td width="84" bgcolor="#94ACB3"><p align="center"><strong>Hasil</strong></p></td>
              <td width="164" bgcolor="#94ACB3"><div align="center"><strong>Harga/Biaya</strong></div></td>
              <td width="169" bgcolor="#94ACB3"><p align="center"><strong>Aksi</strong></p></td>
            </tr>
			<?php 
      $no = 1;
      if ($row_Recordset1 > 0){ do { ?>
            <tr>
              <td bgcolor="#FFFFFF"><div align="center"><?php echo $no; ?></div></td>
              <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_Recordset1['no_rm']; ?></div></td>
              <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_Recordset1['nama']; ?></div></td>
              <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_Recordset1['kategori']; ?></div></td>
              <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_Recordset1['sub_kategori']; ?></div></td>
              <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_Recordset1['pemeriksaan']; ?></div></td>
              <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_Recordset1['hasil']; ?></div></td>
              <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_Recordset1['pembayaran']; ?></div></td>
              <td bgcolor="#FFFFFF">
                <div align="center">
                  <a href="cetak/cetak_data.php?id=<?php echo $row_Recordset1['no']; ?>" style="margin-right:10px">
                    <button>cetak</button>
                  </a> 
                  <a href="edit_data.php?id=<?php echo $row_Recordset1['no']; ?>">
                    <img src="b_edit.png">
                  </a> 
                  <a href="delete_data.php?id=<?php echo $row_Recordset1['no']; ?>" onClick="return confirm('Apakah anda yakin akan menghapus data pasien tersebut?')">
                    <img src="b_drop.png">
                  </a>
                </div>
              </td>
            </tr>
			<?php $no++; } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); }elseif($_GET['q']==""){ echo '<td colspan="9"><div align="center"><h3>TIDAK ADA DATA</h3></div></td>'; }else{echo '<td colspan="9"><div align="center"><h3>TIDAK ADA DATA YANG DICARI</h3></div></td>';} ?>
          </table>
        </form>
	    <p></p>
	  </li>
	  </ul>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>