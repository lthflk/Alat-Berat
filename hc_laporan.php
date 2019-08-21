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

mysql_select_db($database_koneksi, $koneksi);
$query_lprn = "SELECT permohonan.*,pekerja.*,proyek.*, jenis.* FROM permohonan inner join pekerja on permohonan.id_pekerja=pekerja.id_pekerja inner join proyek on permohonan.id_proyek=proyek.id_proyek inner join jenis on permohonan.kd_jenis=jenis.kd_jenis";
$lprn = mysql_query($query_lprn, $koneksi) or die(mysql_error());
$row_lprn = mysql_fetch_assoc($lprn);
$totalRows_lprn = mysql_num_rows($lprn);

mysql_select_db($database_koneksi, $koneksi);
$query_vpermohonan = "SELECT permohonan.kd_permohonan as 'Kode Permohonan', proyek.nmproyek as 'Nama Proyek', pekerja.nmpekerja as 'Nama Pekerja' from permohonan inner join proyek on permohonan.id_proyek=proyek.id_proyek inner join pekerja on permohonan.id_pekerja=pekerja.id_pekerja";
$vpermohonan = mysql_query($query_vpermohonan, $koneksi) or die(mysql_error());
$row_vpermohonan = mysql_fetch_assoc($vpermohonan);
$totalRows_vpermohonan = mysql_num_rows($vpermohonan);

mysql_select_db($database_koneksi, $koneksi);
$query_v_permohonan2 = "SELECT detail_permohonan.kd_permohonan as 'Kode Permohonan', jenis.nmjenis as 'Nama Jenis',  detail_permohonan.harga, detail_permohonan.jumlah, detail_permohonan.jangkawaktu from jenis inner join detail_permohonan on detail_permohonan.kd_jenis=jenis.kd_jenis";
$v_permohonan2 = mysql_query($query_v_permohonan2, $koneksi) or die(mysql_error());
$row_v_permohonan2 = mysql_fetch_assoc($v_permohonan2);
$totalRows_v_permohonan2 = mysql_num_rows($v_permohonan2);
?>
<body onLoad="print()">
  <table width="70%" border="0" align="center">
  <tr>
    <td height="359" align="right" valign="top" scope="col"><table width="100%" border="0">
      <tr>
        
        <td width="86%" align="center" valign="top" scope="col">FORMULIR PENGAJUAN PERMOHONAN PENYEDIAAN ALAT BERAT PT. WIRA KARYA CIPTA MANDIRI LESTARI<br>
          Komplek Todak Permai Indah Blok B No. 06 Pekanbaru – Riau<br>
          Email: knc.wkcm@gmail.com</td>
      </tr>
    </table>
        <hr />
      <table width="100%" border="0">
          <tr>
            <td><p>Kode Permohonan : <?php echo $row_lprn['kd_permohonan']; ?></p>
            <p>Nama Proyek : <?php echo $row_lprn['nmproyek']; ?></p>
            <p>Nama Pekerja : <?php echo $row_lprn['nmpekerja']; ?></p>
            <table width="100%" border="0">
              <tr>
                <td width="10%">No</td>
                <td width="16%">Nama Alat Berat</td>
                <td width="13%">Jumlah</td>
                <td width="10%">Harga</td>
                <td width="20%">Jangka Waktu</td>
                <td width="20%">Total</td>
              </tr>
              <?php $no=1; do { ?>
                <tr>
                  <td><?php echo $no++ ?></td>
                  <td><?php echo $row_lprn['nmjenis']; ?></td>
                  <td><?php echo $row_lprn['jumlah']; ?></td>
                  <td><?php echo $row_lprn['harga']; ?></td>
                  <td><?php echo $row_lprn['jangkawaktu']; ?></td>
                  <td><?php echo $row_lprn['total']; ?></td>
                </tr>
                <?php } while ($row_lprn = mysql_fetch_assoc($lprn)); ?>
            </table></td>
          </tr>
          
        </table>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
        <p>Pematangsiantar, <?php echo date('d M Y'); ?></p>
        <p>Direktur</p>
        <p>&nbsp;</p>
        <p><br />
          Nama </p></td>
  </tr>
</table>
<?php
mysql_free_result($lprn);

mysql_free_result($vpermohonan);

mysql_free_result($v_permohonan2);
?>
