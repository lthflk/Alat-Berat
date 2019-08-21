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
  $updateSQL = sprintf("UPDATE jenis SET nmjenis=%s WHERE kd_jenis=%s",
                       GetSQLValueString($_POST['nmjenis'], "text"),
                       GetSQLValueString($_POST['kd_jenis'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
 ?>
<script>
alert('Data Berhasil DiUpdate');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=jenis" />
<?php
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE jenis SET nmjenis=%s WHERE kd_jenis=%s",
                       GetSQLValueString($_POST['nmjenis'], "text"),
                       GetSQLValueString($_POST['kd_jenis'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
?>
<script>
alert('Data Berhasil DiUpdate');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=jenis" />
<?php

}

$colname_jn = "-1";
if (isset($_GET['kd_jenis'])) {
  $colname_jn = $_GET['kd_jenis'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_jn = sprintf("SELECT * FROM jenis WHERE kd_jenis = %s", GetSQLValueString($colname_jn, "text"));
$jn = mysql_query($query_jn, $koneksi) or die(mysql_error());
$row_jn = mysql_fetch_assoc($jn);
$totalRows_jn = mysql_num_rows($jn);
?>

<h2>JENIS ALAT BERAT</h2>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table width="50%" border="0">
    <tr>
      <td width="30%">Kode Jenis</td>
      <td width="90%"><label for="kd_jenis"></label>
      <input name="kd_jenis" type="text" id="kd_jenis" value="<?php echo $row_jn['kd_jenis']; ?>" size="20"></td>
    </tr>
    <tr>
      <td>Nama Jenis</td>
      <td>
        <label for="nmjenis"></label>
      <input name="nmjenis" type="text" id="nmjenis" value="<?php echo $row_jn['nmjenis']; ?>" size="30" /></td>
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
mysql_free_result($jn);
?>
