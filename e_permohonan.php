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
  $updateSQL = sprintf("UPDATE permohonan SET id_pekerja=%s, id_proyek=%s, kd_jenis=%s, jumlah=%s, harga=%s, total=%s, jangkawaktu=%s WHERE kd_permohonan=%s",
                       GetSQLValueString($_POST['id_pekerja'], "text"),
                       GetSQLValueString($_POST['id_proyek'], "text"),
                       GetSQLValueString($_POST['kd_jenis'], "text"),
                       GetSQLValueString($_POST['jumlah'], "text"),
                       GetSQLValueString($_POST['harga'], "text"),
                       GetSQLValueString($_POST['total'], "text"),
                       GetSQLValueString($_POST['jangkawaktu'], "text"),
                       GetSQLValueString($_POST['kd_permohonan'], "text"));

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
<meta http-equiv="refresh" content="0;url=index.php?page=permohonan" />
<?php
}

mysql_select_db($database_koneksi, $koneksi);
$query_pk = "SELECT * FROM pekerja ORDER BY id_pekerja ASC";
$pk = mysql_query($query_pk, $koneksi) or die(mysql_error());
$row_pk = mysql_fetch_assoc($pk);
$totalRows_pk = mysql_num_rows($pk);

mysql_select_db($database_koneksi, $koneksi);
$query_pr = "SELECT * FROM proyek ORDER BY id_proyek ASC";
$pr = mysql_query($query_pr, $koneksi) or die(mysql_error());
$row_pr = mysql_fetch_assoc($pr);
$totalRows_pr = mysql_num_rows($pr);

mysql_select_db($database_koneksi, $koneksi);
$query_jn = "SELECT * FROM jenis ORDER BY kd_jenis ASC";
$jn = mysql_query($query_jn, $koneksi) or die(mysql_error());
$row_jn = mysql_fetch_assoc($jn);
$totalRows_jn = mysql_num_rows($jn);

mysql_select_db($database_koneksi, $koneksi);
$query_permohonan = "SELECT * FROM permohonan ORDER BY kd_permohonan ASC";
$permohonan = mysql_query($query_permohonan, $koneksi) or die(mysql_error());
$row_permohonan = mysql_fetch_assoc($permohonan);
$totalRows_permohonan = mysql_num_rows($permohonan);
?>
<h2>JENIS ALAT BERAT</h2>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table width="100%" border="1">
    <tr>
      <td width="25%">Kode Permohonan</td>
      <td width="75%"><label for="kd_permohonan"></label>
      <input name="kd_permohonan" type="text" id="kd_permohonan" value="<?php echo $row_permohonan['kd_permohonan']; ?>" size="100"></td>
    </tr>
    <tr>
      <td>Id Pekerja</td>
      <td><label for="id_pekerja"></label>
        <select name="id_pekerja" size="1" id="select1">
          <option value="<?php echo $row_permohonan['id_pekerja']; ?>"><?php echo $row_permohonan['id_pekerja']; ?></option>
          <?php
do {  
?>
          <option value="<?php echo $row_pk['id_pekerja']?>"><?php echo $row_pk['nmpekerja']?></option>
          <?php
} while ($row_pk = mysql_fetch_assoc($pk));
  $rows = mysql_num_rows($pk);
  if($rows > 0) {
      mysql_data_seek($pk, 0);
	  $row_pk = mysql_fetch_assoc($pk);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Id Proyek</td>
      <td><label for="id_proyek"></label>
        <select name="id_proyek" size="1" id="select2">
          <option value="<?php echo $row_permohonan['id_proyek']; ?>"><?php echo $row_permohonan['id_proyek']; ?></option>
          <?php
do {  
?>
          <option value="<?php echo $row_pr['id_proyek']?>"><?php echo $row_pr['nmproyek']?></option>
          <?php
} while ($row_pr = mysql_fetch_assoc($pr));
  $rows = mysql_num_rows($pr);
  if($rows > 0) {
      mysql_data_seek($pr, 0);
	  $row_pr = mysql_fetch_assoc($pr);
  }
?>
      </select>        <label for="jumlah"></label></td>
    </tr>
    <tr>
      <td>Kode Jenis</td>
      <td><label for="kd_jenis"></label>
   
        <select name="kd_jenis" size="1" id="select3">
          <option value="<?php echo $row_permohonan['kd_jenis']; ?>"><?php echo $row_permohonan['kd_jenis']; ?></option>
          <?php
do {  
?>
          <option value="<?php echo $row_jn['kd_jenis']?>"><?php echo $row_jn['nmjenis']?></option>
          <?php
} while ($row_jn = mysql_fetch_assoc($jn));
  $rows = mysql_num_rows($jn);
  if($rows > 0) {
      mysql_data_seek($jn, 0);
	  $row_jn = mysql_fetch_assoc($jn);
  }
?>
        </select>
<label for="jumlah"></label></td>
    </tr>
    <tr>
      <td>Jumlah</td>
      <td><label for="jumlah"></label>
      <input name="jumlah" type="text" id="jumlah" value="<?php echo $row_permohonan['jumlah']; ?>" size="100" /></td>
    </tr>
      <tr>
      <td>Harga</td>
      <td><label for="harga"></label>
      <input name="harga" type="text" id="harga" value="<?php echo $row_permohonan['harga']; ?>" size="100" /></td>
    </tr>
      
    
      <tr>
      <td>Jangka Waktu</td>
      <td><label for="jangkawaktu"></label>
      <input name="jangkawaktu" type="text" id="jangkawaktu" value="<?php echo $row_permohonan['jangkawaktu']; ?>" size="100" /></td></tr>
      <tr>
      <td>&nbsp;</td>
      <td><label for="total"></label></td>
    </tr>
      <tr><td></td>
      <td><input type="submit" name="button" id="button" value="Submit" />&nbsp;&nbsp;
        <input type="reset" name="button2" id="button2" value="Reset" /></td></tr>
        
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>

<?php
mysql_free_result($pk);

mysql_free_result($pr);

mysql_free_result($jn);

mysql_free_result($permohonan);
?>
