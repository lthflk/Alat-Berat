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
  $updateSQL = sprintf("UPDATE proyek SET nmproyek=%s, alamat=%s WHERE id_proyek=%s",
                       GetSQLValueString($_POST['nmproyek'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['id_proyek'], "text"));

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
<meta http-equiv="refresh" content="0;url=index.php?page=proyek" />
<?php
}

$colname_Recordset1 = "-1";
if (isset($_GET['id_proyek'])) {
  $colname_Recordset1 = $_GET['id_proyek'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_Recordset1 = sprintf("SELECT * FROM proyek WHERE id_proyek = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $koneksi) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<p>DATA PROYEK</p>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="100%" border="1">
    <tr>
      <td width="15%">Id Proyek</td>
      <td width="85%"><label for="id_proyek"></label>
      <input name="id_proyek" type="text" id="tid_proyek" value="<?php echo $row_Recordset1['id_proyek']; ?>" size="100" /></td>
    </tr>
    <tr>
      <td>Nama Proyek</td>
      <td><label for="nmproyek"></label>
      <input name="nmproyek" type="text" id="nmproyek" value="<?php echo $row_Recordset1['nmproyek']; ?>" size="100" /></td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td><label for="alamat"></label>
      <input name="alamat" type="text" id="alamat" value="<?php echo $row_Recordset1['alamat']; ?>" size="100" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Submit" />
      <input type="reset" name="button2" id="button2" value="Reset" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<?php
mysql_free_result($Recordset1);
?>
