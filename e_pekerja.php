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
  $updateSQL = sprintf("UPDATE pekerja SET nmpekerja=%s, kd_jabatan=%s, jk=%s WHERE id_pekerja=%s",
                       GetSQLValueString($_POST['nmpekerja'], "text"),
                       GetSQLValueString($_POST['kd_jabatan'], "text"),
                       GetSQLValueString($_POST['jk'], "text"),
                       GetSQLValueString($_POST['id_pekerja'], "text"));

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
<meta http-equiv="refresh" content="0;url=index.php?page=pekerja"/>
<?php

}

$colname_pj = "-1";
if (isset($_GET['id_pekerja'])) {
  $colname_pj = $_GET['id_pekerja'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_pj = sprintf("SELECT * FROM pekerja WHERE id_pekerja = %s", GetSQLValueString($colname_pj, "text"));
$pj = mysql_query($query_pj, $koneksi) or die(mysql_error());
$row_pj = mysql_fetch_assoc($pj);
$totalRows_pj = mysql_num_rows($pj);

mysql_select_db($database_koneksi, $koneksi);
$query_jabatan = "SELECT * FROM jabatan";
$jabatan = mysql_query($query_jabatan, $koneksi) or die(mysql_error());
$row_jabatan = mysql_fetch_assoc($jabatan);
$totalRows_jabatan = mysql_num_rows($jabatan);
?>

<h2>JENIS ALAT BERAT</h2>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table width="80%" border="0">
   <tr>
      <td width="15%">Id Pekeja</td>
      <td><label for="id_pekerja"></label>
      <input name="id_pekerja" type="text" id="id_pekerja" value="<?php echo $row_pj['id_pekerja']; ?>" size="40" /></td>
    </tr>
    <tr>
      <td width="15%">Nama Pekerja</td>
      <td><label for="nmpekerja"></label>
      <input name="nmpekerja" type="text" id="nmpekerja" value="<?php echo $row_pj['nmpekerja']; ?>" size="60" /></td>
    </tr>
    <tr>
      <td width="15%">Jabatan</td>
      <td><label for="jabatan"></label>
        <label for="kd_jabatan"></label>
        <select name="kd_jabatan" id="kd_jabatan">
          <?php
do {  
?>
          <option value="<?php echo $row_jabatan['kd_jabatan']?>"><?php echo $row_jabatan['ket']?></option>
          <?php
} while ($row_jabatan = mysql_fetch_assoc($jabatan));
  $rows = mysql_num_rows($jabatan);
  if($rows > 0) {
      mysql_data_seek($jabatan, 0);
	  $row_jabatan = mysql_fetch_assoc($jabatan);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td width="15%">Jenis Kelamin</td>
      <td>
        <input type="radio" name="jk" value="Pria" <?php if ($row_pj['jk']=="Pria") {echo "checked";}?> id="radio2"/>
      <label for="radio">Pria</label>
      <input type="radio" name="jk"  value="Wanita" <?php if ($row_pj['jk']=="Wanita") {echo "checked";}?> id="radio1" />
      <label for="radio">Wanita</label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="Submit" id="button" value="Update Data" />
      <input type="reset" name="button2" id="button2" value="Hapus" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<?php
mysql_free_result($pj);

mysql_free_result($jabatan);
?>
