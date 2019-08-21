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
  $insertSQL = sprintf("INSERT INTO jenis (kd_jenis, nmjenis,harga) VALUES (%s, %s,%s)",
                       GetSQLValueString($_POST['kd_jenis'], "text"),
					   GetSQLValueString($_POST['nmjenis'], "text"),
                       GetSQLValueString($_POST['harga'], "text"));

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
$query_jn = "SELECT * FROM jenis ORDER BY kd_jenis ASC";
$jn = mysql_query($query_jn, $koneksi) or die(mysql_error());
$row_jn = mysql_fetch_assoc($jn);
$totalRows_jn = mysql_num_rows($jn);
?>
<h2>JENIS ALAT BERAT</h2>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table width="50%" border="1">
    <tr>
      <td width="30%">Kode Jenis</td>
      <td width="90%"><label for="kd_jenis"></label>
      <input name="kd_jenis" type="text" id="kd_jenis" size="20"></td>
    </tr>
    <tr>
      <td>Nama Jenis</td>
      <td><input name="nmjenis" type="text" id="nmjenis" size="30" /></td>
    </tr>
    <tr>
      <td>Harga</td>
      <td><label for="harga"></label>
      <input type="text" name="harga" id="harga" />        
      <label for="nmjenis"></label></td>
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
    <th>Harga</th>
    <th>Proses </th>
  </tr>
  
    <?php $no=1; do { ?>
      <tr>
        <td width="4%"><div align="center"> <?php echo $no++; ?></div> </td>
       <td width="20%"><div align="center"> <?php echo $row_jn['kd_jenis']; ?></td>
         <td width="20%"><div align="center"> <?php echo $row_jn['nmjenis']; ?></td>
        <td width="20%"><?php echo $row_jn['harga']; ?></td>
        <td width="20%"><div align="center">
        <a href="?page=e_jenis&amp;kd_jenis=<?php echo $row_jn['kd_jenis']; ?>"> Edit</a> - <a href="h_jenis.php?kd_jenis=<?php echo $row_jn['kd_jenis']; ?>">Hapus</a></td>
      </tr>
      <?php } while ($row_jn = mysql_fetch_assoc($jn)); ?>

</table>
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($jn);
?>
