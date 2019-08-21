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
  $insertSQL = sprintf("INSERT INTO pekerja (id_pekerja, nmpekerja, kd_jabatan, jk) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_pekerja'], "text"),
                       GetSQLValueString($_POST['nmpekerja'], "text"),
                       GetSQLValueString($_POST['kd_jabatan'], "text"),
                       GetSQLValueString($_POST['jk'], "text"));

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
$query_pj = "SELECT pekerja.*, jabatan.* FROM pekerja inner join jabatan on pekerja.kd_jabatan=jabatan.kd_jabatan ORDER BY id_pekerja ASC";
$pj = mysql_query($query_pj, $koneksi) or die(mysql_error());
$row_pj = mysql_fetch_assoc($pj);
$totalRows_pj = mysql_num_rows($pj);

mysql_select_db($database_koneksi, $koneksi);
$query_jb = "SELECT * FROM jabatan";
$jb = mysql_query($query_jb, $koneksi) or die(mysql_error());
$row_jb = mysql_fetch_assoc($jb);
$totalRows_jb = mysql_num_rows($jb);
?>
<h2>JENIS ALAT BERAT</h2>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table width="80%" border="0">
   <tr>
      <td >Id Pekeja</td>
      <td ><label for="id_pekerja"></label>
      <input name="id_pekerja" type="text" id="id_pekerja" size="40" /></td>
    </tr>
    <tr>
      <td >Nama Pekerja</td>
      <td ><label for="nmpekerja"></label>
      <input name="nmpekerja" type="text" id="nmpekerja" size="70" /></td>
    </tr>
    <tr>
      <td >Jabatan</td>
      <td ><label for="jabatan"></label>
        <label for="kd_jabatan"></label>
        <select name="kd_jabatan" id="kd_jabatan">
          <?php
do {  
?>
          <option value="<?php echo $row_jb['kd_jabatan']?>"><?php echo $row_jb['ket']?></option>
          <?php
} while ($row_jb = mysql_fetch_assoc($jb));
  $rows = mysql_num_rows($jb);
  if($rows > 0) {
      mysql_data_seek($jb, 0);
	  $row_jb = mysql_fetch_assoc($jb);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td >Jenis Kelamin</td>
      <td ><label for="jk"></label>
        <input type="radio" name="jk" id="radio1" value="Pria" />
      <label for="radio">Pria</label>
      <input type="radio" name="jk" id="radio2" value="Wanita" />
      <label for="radio">Wanita</label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="Submit" id="button" value="Submit" />
        <input type="reset" name="button2" id="button2" value="Hapus" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<p>Daftar Nama Pekerja</p>

<table width="100%" border="4">
    <tr>
      <th>No</td>
      <th>Id Pekerja</th>
      <th>Nama Pekerja</th>
      <th>Jabatan</th>
      <th>Jenis Kelamin</th>
      <th>Proses</th>
    </tr>
     
      <?php $no=1; do { ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td align="center"><?php echo $row_pj['id_pekerja']; ?></td>
            <td align="center"><?php echo $row_pj['nmpekerja']; ?></td>
            <td align="center"><?php echo $row_pj['ket']; ?></td>
            <td align="center"><?php echo $row_pj['jk']; ?></td>
            <td align="center"><a href="?page=e_pekerja&amp;id_pekerja=<?php echo $row_pj['id_pekerja']; ?>">Edit</a> - <a href="?page=h_pekerja&amp;id_pekerja=<?php echo $row_pj['id_pekerja']; ?>">Hapus</a></td>
          </tr>
          <?php } while ($row_pj = mysql_fetch_assoc($pj)); ?>
 
  </table>
<p>&nbsp;</p>
<?php
mysql_free_result($pj);

mysql_free_result($jb);
?>
