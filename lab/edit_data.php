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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "pemeriksaan")) {
		 echo $insertSQL = "UPDATE tabelpemeriksaan SET 
      no_rm='".$_POST['no_rm']."',
      nama='".$_POST['nama']."', 
      umur='".$_POST['umur']."', 
      alamat='".$_POST['alamat']."', 
      jenis_kelamin='".$_POST['jenis_kelamin']."', 
      jenis_pasien='".$_POST['jenis_pasien']."', 
      dokter='".$_POST['dokter']."', 
      kategori='".$_POST['kategori']."', 
      sub_kategori='".$_POST['sub_kategori']."', 
      pemeriksaan='".$_POST['pemeriksaan']."', 
      nilai_tes='".$_POST['nilai_tes']."', 
      pembayaran='".$_POST['pembayaran']."', 
      tanggal='".$_POST['tanggal']."', 
      hasil='".$_POST['hasil']."'
    WHERE no = '". $_GET['id'] ."'
		";
	
  mysql_select_db($database_lab, $lab);
  $Result1 = mysql_query($insertSQL, $lab) or die(mysql_error());
  echo"<script>
        alert('Berhasil'); location.href='tampildata.php'</script>";
}

mysql_select_db($database_lab, $lab);
$query_Recordset1 = "SELECT * FROM tabelpemeriksaan";
$Recordset1 = mysql_query($query_Recordset1, $lab) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$show = "SELECT * FROM tabelpemeriksaan where no='".$_GET['id']."'";
$query = mysql_query($show, $lab) or die(mysql_error());
while ($row=mysql_fetch_array($query))
		{
			// $no=$row['no'];
			$no_rm=$row['no_rm'];
			$nama=$row['nama'];
			$umur=$row['umur'];
			$alamat=$row['alamat'];
			$jenis_kelamin=$row['jenis_kelamin'];
			$jenis_pasien=$row['jenis_pasien'];
			$dokter=$row['dokter'];
			$kategori=$row['kategori'];
			$sub_kategori=$row['sub_kategori'];
			$pemeriksaan=$row['pemeriksaan'];
			$nilai_tes=$row['nilai_tes'];
			$pembayaran=$row['pembayaran'];
			$tanggal=$row['tanggal'];
			$hasil=$row['hasil'];
			if($jenis_kelamin=='L'){
				$jk='selected="selected"';
				$jk1='';
			}elseif($jenis_kelamin=='P'){
				$jk='';
				$jk1='selected="selected"';
			}
			if($jenis_pasien=='BPJS'){
				$jp='selected="selected"';
				$jp1='';
			}elseif($jenis_pasien=='UMUM'){
				$jp='';
				$jp1='selected="selected"';
			}
			if($kategori=='-'){
				$kt='selected="selected"';
				$kt1='';
				$kt2='';
			}elseif($kategori=='HEMATOLOGI'){
				$kt='';
				$kt1='selected="selected"';
				$kt2='';
			}elseif($kategori=='URINALISA'){
				$kt='';
				$kt1='';
				$kt2='selected="selected"';
			}
			if($sub_kategori=='-'){
				$sk='selected="selected"';
				$sk1='';
			}elseif($sub_kategori=='DARAH LENGKAP'){
				$sk='';
				$sk1='selected="selected"';
			}
			if($pemeriksaan=='-'){
				$np='selected="selected"';
				$np1='';
				$np2='';
				$np3='';
				$np4='';
				$np5='';
				$np6='';
				$np7='';
			}elseif($pemeriksaan=='LEUKOSIT'){
				$np='';
				$np1='selected="selected"';
				$np2='';
				$np3='';
				$np4='';
				$np5='';
				$np6='';
				$np7='';
			}elseif($pemeriksaan=='HEMOGLOBIN'){
				$np='';
				$np1='';
				$np2='selected="selected"';
				$np3='';
				$np4='';
				$np5='';
				$np6='';
				$np7='';
			}elseif($pemeriksaan=='LED'){
				$np='';
				$np1='';
				$np2='';
				$np3='selected="selected"';
				$np4='';
				$np5='';
				$np6='';
				$np7='';
			}elseif($pemeriksaan=='TROMBOSIT'){
				$np='';
				$np1='';
				$np2='';
				$np3='';
				$np4='selected="selected"';
				$np5='';
				$np6='';
				$np7='';
			}elseif($pemeriksaan=='HEMATROKIT'){
				$np='';
				$np1='';
				$np2='';
				$np3='';
				$np4='';
				$np5='selected="selected"';
				$np6='';
				$np7='';
			}elseif($pemeriksaan=='ERITROSIT'){
				$np='';
				$np1='';
				$np2='';
				$np3='';
				$np4='';
				$np5='';
				$np6='selected="selected"';
				$np7='';
			}elseif($pemeriksaan=='WARNA'){
				$np='';
				$np1='';
				$np2='';
				$np3='';
				$np4='';
				$np5='';
				$np6='';
				$np7='selected="selected"';
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
    <style type="text/css">
<!--
.style1 {font-family: Arial, Helvetica, sans-serif}
.style2 {color: #97aeb3}
.style3 {
	color: #97AEB3;
	font-weight: bold;
}
-->
    </style>
    <link href="delete_data.php" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="header">
		<a href="index.html" class="logo"><img src="images/logo.png" alt=""></a>
		<ul>
			<li>
				<a href="pendaftaran.php">PENDAFTARAN</a>
			</li>
			<li class="selected">
				<a href="tampildata.php">PEMERIKSAAN</a>
			</li>
			<li>
				<a href="pencarian.php">PENCARIAN</a>
			</li>
			<li>
				<a href="<?php echo $logoutAction ?>" onClick="return confirm('Apakah anda yakin keluar dari Aplikasi Register ?')">KELUAR</a></li>
		</ul>
	</div>
	<div id="body">
	  <div align="left">
	    <h1 align="center" class="style2">Pemeriksaan Pasien </h1>
	    <form name="pemeriksaan" method="POST" action="<?php echo $editFormAction; ?>">
	      <table width="574" align="center" bgcolor="#94ACB3" class="style1">
            
            <tr>
              <td>No. Rekam Medis </td>
              <td><strong>:</strong></td>
              <td colspan="2"><input name="no_rm" type="text" id="no_rm" maxlength="6" value="<?php echo $no_rm;?>"></td>
            </tr>
            <tr>
              <td>Nama</td>
              <td><strong>:</strong></td>
              <td colspan="2"><input name="nama" type="text" id="nama" value="<?php echo $nama;?>"></td>
            </tr>
            <tr>
              <td>Umur</td>
              <td><strong>:</strong></td>
              <td colspan="2"><input name="umur" type="text" id="umur" maxlength="3" value="<?php echo $umur;?>"></td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td><strong>:</strong></td>
              <td colspan="2"><textarea name="alamat" id="alamat" required><?php echo $alamat; ?></textarea></td>
            </tr>
            <tr>
              <td>Jenis Kelamin </td>
              <td><strong>:</strong></td>
              <td colspan="2"><strong>
                <label>
                <select name="jenis_kelamin" id="jenis_kelamin" required>
                  <option value="L" >LAKI-LAKI</option>
                  <option value="P" >PEREMPUAN</option>
                </select>
                </label>
              </strong></td>
            </tr>
            <tr>
              <td>Jenis Pasien </td>
              <td><strong>:</strong></td>
              <td colspan="2"><strong>
                <select name="jenis_pasien" size="1" id="jenis_pasien" required>
                  <option >BPJS</option>
                  <option >UMUM</option>
                </select>
                <label></label>
              </strong></td>
            </tr>
            <tr>
              <td>Dokter Pengirim </td>
              <td><strong>:</strong></td>
              <td colspan="2"><strong>
                <label>
                <input name="dokter" type="text" id="dokter" value="<?php echo $dokter;?>">
                </label>
              </strong></td>
            </tr>
            <tr>
              <td>Kategori</td>
              <td><strong>:</strong></td>
              <td colspan="2"><strong>
                <select name="kategori" size="1" id="kategori" required>
				  <option value="-" <?php echo $kt; ?>>NONE</option>
                  <option <?php echo $kt1; ?>>HEMATOLOGI</option>
                  <option <?php echo $kt2; ?>>URINALISA</option>
                </select>
                <label></label>
              </strong></td>
            </tr>
            <tr>
              <td>Sub Kategori </td>
              <td><strong>:</strong></td>
              <td colspan="2">
                  <select name="sub_kategori" size="1" id="sub_kategori" required>
                    <option>NONE</option>
                    <option>DARAH LENGKAP</option>
                  </select>		</td>
            </tr>
            <tr>
              <td>Nama Pemeriksaan </td>
              <td><strong>:</strong></td>
              <td colspan="2"><select name="pemeriksaan" size="1" id="pemeriksaan" required>
                  <option value="-" <?php echo $np; ?>>NONE</option>
                  <option <?php echo $np1; ?>>LEUKOSIT</option>
                  <option <?php echo $np2; ?>>HEMOGLOBIN</option>
                  <option <?php echo $np3; ?>>LED</option>
                  <option <?php echo $np4; ?>>TROMBOSIT</option>
                  <option <?php echo $np5; ?>>HEMATROKIT</option>
                  <option <?php echo $np6; ?>>ERITROSIT</option>
                  <option <?php echo $np7; ?>>WARNA</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Nilai Tes </td>
              <td><strong>:</strong></td>
              <td colspan="2">
                <input type="number" name="nilai_tes" value="<?=$nilai_tes?>">
              </td>
            </tr>
            <tr>
              <td>Pembayaran</td>
              <td><strong>:</strong></td>
              <td colspan="2"><strong>
                <label>
                <input name="pembayaran" type="text" id="pembayaran" value="<?php echo $pembayaran;?>">
                </label>
              </strong></td>
            </tr>
            <tr>
              <td height="19">Tanggal</td>
              <td><strong>:</strong></td>
              <td colspan="2"><input type="date" id="tgl" name="tanggal" value="<?php echo $tanggal; ?>"></td>
			  
            </tr>
            <tr>
              <td height="19">Hasil</td>
              <td><strong>:</strong></td>
              <td colspan="2"><textarea name="hasil" id="hasil" required><?php echo $hasil; ?></textarea></td>
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
	    </div>
	  </div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>