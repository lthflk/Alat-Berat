<?php require_once('Connections/koneksi.php'); ?>
<?php
error_reporting(0);
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
}

if ($_POST){
	$cbocari=$_POST['cbocari'];
	$txtcari=$_POST['txtcari'];
mysql_select_db($database_koneksi, $koneksi);
$query_carper = "SELECT 
permohonan.*
,pekerja.*
,proyek.*
-- , jenis.* 
FROM permohonan 
inner join pekerja on permohonan.id_pekerja=pekerja.id_pekerja 
inner join proyek on permohonan.id_proyek=proyek.id_proyek 
-- inner join jenis on permohonan.kd_jenis=jenis.kd_jenis 
WHERE $cbocari LIKE '%$txtcari%'";
$carper = mysql_query($query_carper, $koneksi) or die(mysql_error());
$row_carper = mysql_fetch_assoc($carper);
$totalRows_carper = mysql_num_rows($carper);
}
?>
<h2>Data Pengajuan Permohonan Penyediaan Alat Berat</h2>
<form id="form1" name="form1" method="post" action="">
  Cari Data Berdasarkan 
  <label for="cbocari"></label>
  <select name="cbocari" id="cbocari">
    <option value="permohonan.kd_permohonan">Kode Permohonan</option>
    <option value="pekerja.id_pekerja">Id Pekerja</option>
    <option value="proyek.id_proyek">Id Proyek</option>

  </select>
  <label for="txtcari"></label>
  <input type="text" name="txtcari" id="txtcari" />
  <input type="submit" name="button" id="button" value="Cari Data" />
</form>
<table width="100%" border="1">
  <tr>
    <th>No</th>
    <th>Kode Permohonan</th>
    <th>Id Pekerja</th>
    <th>Id Proyek</th>
    <th>Proses</th>
  </tr>
  <?php $no=1;do { ?>
    <tr>
      <td scope="row"><?php echo $no++; ?></td>
      <td><?php echo $row_carper['kd_permohonan']; ?></td>
      <td><?php echo $row_carper['id_pekerja']; ?></td>
      <td><?php echo $row_carper['id_proyek']; ?></td>
      <td> <a href="hc_laporan.php?kd_permohonan=<?php echo $row_carper['kd_permohonan']; ?>">Cetak</a></td>
      
    </tr>
    <?php } while ($row_carper = mysql_fetch_assoc($carper)); ?>
</table>
<p>
  <?php
mysql_free_result($carper);
?>