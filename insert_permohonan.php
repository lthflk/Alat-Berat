<?php
include('file:///C|/xampp/htdocs/History/pkl2/Connections\koneksi.php'); 
$tanggaltransaksi=$_POST['tgl']." ".$_POST['bln']." ".$_POST['thn'];
/* $query="SELECT hargasatuan FROM barang";
$hasil= mysql_query($query) or die ("Query gagal!");
while ($data = mysql_fetch_array($hasil)){
$v[]=$data['hargasatuan'];} */
	
for($x=1; $x<=20;$x++)
{
$a="jlh$x";
$b[]="$_POST[$a]";}

for($y=1; $y<=20;$y++)
{
$c="jlh$y";
$d[]="$_POST[$c]";}

for($z=1; $z<=20;$z++)
{
$e="jlh$x";
$f[]="$_POST[$f]";}



/* $totalpembayaran=($a[0]*$v[0])+($a[1]*$v[1])+($a[2]*$v[2])+($a[3]*$v[3]); */
$total = ( $a[0]*$h[0]*$jw[0]);
$query2="INSERT INTO permohonan VALUES ('" . $_POST['kd_permohonan'] . "','" . $_POST['id_pekerja'] . "','" . $_POST['id_proyek'] . "','" . $total ."')";
mysql_query($query2) or die ("Query gagal!");


if($_POST['jlh1']==""){ $xx="0";}
else
{
$query3="INSERT INTO daftar values ('" . $_POST['idpermintaan'] . "','" . $_POST['idkantor'] . "','" . $tanggaltransaksi . "','" . $_POST['kdbpm1'] . "','" . $_POST['jlh1'] . "')";
mysql_query($query3) or die ("Query gagal1!");
}

if($_POST['jlh2']==""){ $xx="0";}
else
{
$query3="INSERT INTO daftar values ('" . $_POST['idpermintaan'] . "','" . $_POST['idkantor'] . "','" . $tanggaltransaksi . "','" . $_POST['kdbpm2'] . "','" . $_POST['jlh2'] . "')";
mysql_query($query3) or die ("Query gagal1!");
}
if($_POST['jlh3']==""){ $xx="0";}
else
{
$query3="INSERT INTO daftar values ('" . $_POST['idpermintaan'] . "','" . $_POST['idkantor'] . "','" . $tanggaltransaksi . "','" . $_POST['kdbpm3'] . "','" . $_POST['jlh3'] . "')";
mysql_query($query3) or die ("Query gagal1!");
}
if($_POST['jlh4']==""){ $xx="0";}
else
{
$query3="INSERT INTO daftar values ('" . $_POST['idpermintaan'] . "','" . $_POST['idkantor'] . "','" . $tanggaltransaksi . "','" . $_POST['kdbpm4'] . "','" . $_POST['jlh4'] . "')";
mysql_query($query3) or die ("Query gagal1!");
}
if($_POST['jlh5']==""){ $xx="0";}
else
{
$query3="INSERT INTO daftar values ('" . $_POST['idpermintaan'] . "','" . $_POST['idkantor'] . "','" . $tanggaltransaksi . "','" . $_POST['kdbpm4'] . "','" . $_POST['jlh5'] . "')";
mysql_query($query3) or die ("Query gagal1!");
}

header ("location: index.php?p=pemesanan");
?>