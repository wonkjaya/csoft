<?php
include('../Connections/lab.php');
if(!isset($_GET['id']))exit('Data Tidak Ada');
$id=mysql_escape_string($_GET['id']);

$tampil = "SELECT * FROM tabelpemeriksaan WHERE no = '$id'";

$con=mysql_connect("localhost", "root", "");
mysql_select_db("p_labmedis") or die(mysql_error());


//echo $tampil;exit;
$query = mysql_query($tampil,$con) or die(mysql_error());
//Menghitung jumlah data pada database				
$jml = mysql_num_rows($query);
$result = mysql_fetch_assoc($query);
//	$data[] = array(''=>'No RM:'.$no_rm );
foreach($result as $r=>$key):
	//print_r($r);
	$field=str_replace('_', ' ', str_replace(' ','',$r));
	if($field == 'jenis kelamin') $key=($key=='L')?"Laki-Laki":"Perempuan";
	if($field == 'tanggal') $key=date('d-M-Y',strtotime($key));
	if($field != "no"){
		$data[] = array('f1'=>('<b>'.strtoupper($field).'</b>') ,'f2'=>':'.$key);
	}
endforeach;
// print_r($data);
// exit;
include "pdf/class.ezpdf.php"; //class ezpdf yg di panggil
$pdf = new Cezpdf();

//Set margin dan font
$pdf->ezSetCmMargins(3, 3, 3, 3);
$pdf->selectFont('pdf/fonts/Courier.afm');

//Tampilkan gambar di dokumen PDF
$pdf->addJpegFromFile('logo.jpg',31,778,65);

//Teks di tengah atas untuk judul header
$pdf->addText(125, 800, 16,'<b>PUSKESMAS MOJOLANGU MALANG</b>');
$pdf->addText(125, 780, 14,'<b>Jl. Sudimoro No 17 Blimbing-Malang</b>');

//Garis atas untuk header
$pdf->line(31, 770, 565, 770);

//Garis bawah untuk footer
$pdf->line(31, 50, 565, 50);

//Teks kiri bawah
$pdf->addText(410,34,8,'Dicetak tgl:' . date( 'd-m-Y, H:i:s'));

// Baca input tanggal yang dikirimkan user
$dari = date('d-m-Y');
//echo "$mulai $selesai";exit;

//Menampilkan isi dari database
//Koneksi ke database dan tampilkan datanya
//echo $jml;exit;
if ($jml = 0) exit('Data Tidak Tersedia');
//print_r($data);exit;
//Tampilkan Dalam Bentuk Table
//exit;
$pdf->ezTable($data);

//$pdf->ezText("\nPeriode: $dari ");

// Penomoran halaman
$pdf->ezStartPageNumbers(564, 20, 8);
$pdf->ezStream();



?>