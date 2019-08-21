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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE jabatan SET ket=%s WHERE kd_jabatan=%s",
                       GetSQLValueString($_POST['ket'], "text"),
                       GetSQLValueString($_POST['kd_jabatan'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
?>
<script>
alert('Data Berhasil Diubah');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=jabatan"/>
<?php
}

$colname_jb = "-1";
if (isset($_GET['kd_jabatan'])) {
  $colname_jb = $_GET['kd_jabatan'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_jb = sprintf("SELECT * FROM jabatan WHERE kd_jabatan = %s", GetSQLValueString($colname_jb, "text"));
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
      <input name="kd_jabatan" type="text" id="kd_jabatan" value="<?php echo $row_jb['kd_jabatan']; ?>" size="20"></td>
    </tr>
    <tr>
      <td>Keterangan</td>
      <td><input name="ket" type="text" id="ket" value="<?php echo $row_jb['ket']; ?>" size="30" /></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Simpan">
      <input type="reset" name="button2" id="button2" value="Batal"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<?php
mysql_free_result($jb);
?>
