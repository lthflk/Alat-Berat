<?php require_once('Connections/koneksi.php'); ?>
<?php
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

$colname_data = "-1";
if (isset($_GET['kd_permohonan'])) {
  $colname_data = $_GET['kd_permohonan'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_data = sprintf("SELECT detail_permohonan.*,permohonan.*,jenis.* FROM detail_permohonan inner join permohonan on detail_permohonan.kd_permohonan=permohonan.kd_permohonan inner join jenis on detail_permohonan.kd_jenis=jenis.kd_jenis WHERE detail_permohonan.kd_permohonan = %s", GetSQLValueString($colname_data, "text"));
$data = mysql_query($query_data, $koneksi) or die(mysql_error());
$row_data = mysql_fetch_assoc($data);
$totalRows_data = mysql_num_rows($data);
?>
<h2>Detail Permohonan</h2>
<table width="100%">
<tr><td>
<p>Kode Permohonan : <?php echo $row_data['kd_permohonan']; ?> </p>
<p>Kode Proyek : <?php echo $row_data['id_proyek']; ?></p>
<p>Kode Pekerja : <?php echo $row_data['id_pekerja']; ?></p></td></tr>
</table>
<br /><br />
<table width="100%" border="1">
  <tr>
    <th>No</th>
    <th>Kode Permohonan</th>
    <th>Jenis</th>
    <th>Jumlah</th>
    <th>Harga</th>
    <th>Jangka Waktu</th>
    <th>Total</th>
    <th>Proses</th>
  </tr>
  <?php $no=1; do { ?>
  <tr>
    <td><?php echo $no++ ?> </td>
    <td><?php echo $row_data['kd_permohonan']; ?></td>
    <td><?php echo $row_data['kd_jenis']; ?></td>
    <td><?php echo $row_data['jumlah']; ?></td>
    <td><?php echo $row_data['harga']; ?></td>
    <td><?php echo $row_data['jangkawaktu']; ?></td>
    <td><?php $total=$row_data['jumlah']*$row_data['harga']*$row_data['jangkawaktu'];echo $total; ?></td>
    <td><a href="?page=l_permohonan">Hapus</a></td>
  </tr>
  <?php } while ($row_data = mysql_fetch_assoc($data)); ?>
</table>
<p>&nbsp;</p>

<?php
mysql_free_result($data);
?>
