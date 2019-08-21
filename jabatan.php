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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jabatan (kd_jabatan, ket) VALUES (%s, %s)",
                       GetSQLValueString($_POST['kd_jabatan'], "text"),
                       GetSQLValueString($_POST['ket'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jenis (kd_jabatan, ket) VALUES (%s, %s)",
                       GetSQLValueString($_POST['kd_jabatan'], "text"),
					 
                       GetSQLValueString($_POST['ket'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
   ?>
<script>
alert('Data Berhasil Disimpan');
</script>
<?php
}

mysql_select_db($database_koneksi, $koneksi);
$query_jb = "SELECT * FROM jabatan ORDER BY kd_jabatan ASC";
$jb = mysql_query($query_jb, $koneksi) or die(mysql_error());
$row_jb = mysql_fetch_assoc($jb);
$totalRows_jb = mysql_num_rows($jb);
?>
<h2>JENIS ALAT BERAT</h2>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table width="50%" border="1">
    <tr>
      <td width="30%">Kode Jabatan</td>
      <td width="90%"><label for="kd_jabatan"></label>
      <input name="kd_jabatan" type="text" id="kd_jabatan" size="20"></td>
    </tr>
    <tr>
      <td>Keterangan</td>
      <td><input name="ket" type="text" id="ket" size="30" /></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Simpan">
      <input type="reset" name="button2" id="button2" value="Batal"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>isi</p>
<table width="100%" border="3">
  <tr>
   <th>No</th>
    <th>Kode Jenis</th>
    <th>Nama Jenis</th>
    <th>Proses </th>
  </tr>
  
    <?php $no=1; do { ?>
      <tr>
        <td width="4%"><div align="center"> <?php echo $no++; ?></div> </td>
       <td width="20%"><div align="center"> <?php echo $row_jb['kd_jabatan']; ?></td>
         <td width="20%"><div align="center">
         <?php echo $row_jb['ket']; ?></td>
        <td width="20%"><div align="center">
        <a href="?page=e_jabatan&kd_jabatan=<?php echo $row_jb['kd_jabatan']; ?>">Edit</a> - Hapus</td>
      </tr>
      <?php } while ($row_jb = mysql_fetch_assoc($jb)); ?>

</table>
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($jb);
?>
