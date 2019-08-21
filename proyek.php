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
  $insertSQL = sprintf("INSERT INTO proyek (id_proyek, nmproyek, alamat) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id_proyek'], "text"),
                       GetSQLValueString($_POST['nmproyek'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"));

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
$query_pr = "SELECT * FROM proyek ORDER BY id_proyek ASC";
$pr = mysql_query($query_pr, $koneksi) or die(mysql_error());
$row_pr = mysql_fetch_assoc($pr);
$totalRows_pr = mysql_num_rows($pr);
?>
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="90%" border="0">
    <tr>
      <td width="15%">Id Proyek</td>
      <td width="85%"><label for="id_proyek"></label>
      <input name="id_proyek" type="text" id="tid_proyek" size="50" /></td>
    </tr>
    <tr>
      <td>Nama Proyek</td>
      <td><label for="nmproyek"></label>
      <input name="nmproyek" type="text" id="nmproyek" size="70" /></td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td><label for="alamat"></label>
      <textarea name="alamat" id="alamat" cols="45" rows="5"></textarea>        
      <label for="alamat"></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Submit" />
      <input type="reset" name="button2" id="button2" value="Reset" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<p>Isi Data</p>
<form id="form2" name="form2" method="post" action="">
  <table width="100%" border="4">
    <tr>
      <th>No</th>
      <th>Id Proyek</th>
      <th>Nama Proyek</th>
      <th>Alamat</th>
      <th>Proses</th>
    </tr>

    <?php $no=1; do { ?>
      <tr>
        <td><?php echo $no++; ?> </td>
        <td><?php echo $row_pr['id_proyek']; ?></td>
        <td><?php echo $row_pr['nmproyek']; ?></td>
        <td><?php echo $row_pr['alamat']; ?></td>
        <td><a href="?page=e_proyek&id_proyek=<?php echo $row_pr['id_proyek']; ?>">Edit</a> -<a href="h_proyek.php?id_proyek=<?php echo $row_pr['id_proyek']; ?>">Hapus</a></td>
      </tr>
      <?php } while ($row_pr = mysql_fetch_assoc($pr)); ?>

  </table>
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($pr);
?>
