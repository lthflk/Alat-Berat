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
$query_pekerja = "SELECT * FROM pekerja ORDER BY nmpekerja ASC";
$pekerja = mysql_query($query_pekerja, $koneksi) or die(mysql_error());
$row_pekerja = mysql_fetch_assoc($pekerja);
$totalRows_pekerja = mysql_num_rows($pekerja);

mysql_select_db($database_koneksi, $koneksi);
$query_proyek = "SELECT * FROM proyek ORDER BY nmproyek ASC";
$proyek = mysql_query($query_proyek, $koneksi) or die(mysql_error());
$row_proyek = mysql_fetch_assoc($proyek);
$totalRows_proyek = mysql_num_rows($proyek);

mysql_select_db($database_koneksi, $koneksi);
$query_jenis = "SELECT * FROM jenis ORDER BY nmjenis ASC";
$jenis = mysql_query($query_jenis, $koneksi) or die(mysql_error());
$row_jenis = mysql_fetch_assoc($jenis);
$totalRows_jenis = mysql_num_rows($jenis);

mysql_select_db($database_koneksi, $koneksi);
$query_data = "SELECT permohonan.*,proyek.nmproyek,pekerja.nmpekerja FROM permohonan inner join proyek on permohonan.id_proyek=proyek.id_proyek inner join pekerja on permohonan.id_pekerja=pekerja.id_pekerja ORDER BY permohonan.kd_permohonan ASC";
$data = mysql_query($query_data, $koneksi) or die(mysql_error());
$row_data = mysql_fetch_assoc($data);
$totalRows_data = mysql_num_rows($data);
?>
<h2>JENIS ALAT BERAT</h2>

<form action="proses.php" name="form1" method="POST">
  <table width="100%" border="0">
    <tr>
      <td width="25%">Kode Permohonan</td>
      <td width="75%"><label for="kd_permohonan"></label>
      <input name="kd_permohonan" type="text" id="kd_permohonan" size="100"></td>
    </tr>
    <tr>
      <td>Nama Pekerja</td>
      <td><label for="id_pekerja"></label>
        <select name="id_pekerja" size="1" id="select1">
          <option value="">Pilih Satu</option>
          <?php
do {  
?>
          <option value="<?php echo $row_pekerja['id_pekerja']?>"><?php echo $row_pekerja['nmpekerja']?></option>
          <?php
} while ($row_pekerja = mysql_fetch_assoc($pekerja));
  $rows = mysql_num_rows($pekerja);
  if($rows > 0) {
      mysql_data_seek($pekerja, 0);
	  $row_pekerja = mysql_fetch_assoc($pekerja);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Nama Proyek</td>
      <td><label for="id_proyek"></label>
        <select name="id_proyek" size="1" id="select2">
          <option value="">Pilih Satu</option>
          <?php
do {  
?>
          <option value="<?php echo $row_proyek['id_proyek']?>"><?php echo $row_proyek['nmproyek']?></option>
          <?php
} while ($row_proyek = mysql_fetch_assoc($proyek));
  $rows = mysql_num_rows($proyek);
  if($rows > 0) {
      mysql_data_seek($proyek, 0);
	  $row_proyek = mysql_fetch_assoc($proyek);
  }
?>
      </td>
    </tr>
        
  </table>
  <p>
  </p>
		<!-- Buat tombol untuk menabah form data -->
		<button type="button" id="btn-tambah-form">Tambah Jenis</button>
		<button type="button" id="btn-reset-form">Reset</button><br><br>
		
		<b>Data ke 1 :</b>
		<table border="0">
        <tr>
        	
            <td>Jenis</td>
            <td>Jumlah</td>
            <td>Jangka Waktu</td>
         </tr>
			<tr>
				
                <td><select name="jenis[]"  required>
                  <option value="">Pilih Satu </option>	
                    <?php
					do {
?>
                    <option value="<?php echo $row_jenis['kd_jenis']?>"><?php echo $row_jenis['nmjenis']?> </option>
                    <?php
  } while ($row_jenis = mysql_fetch_assoc($jenis));
  $rows = mysql_num_rows($jenis);
  if($rows > 0) {
      mysql_data_seek($jenis, 0);
	  $row_jenis = mysql_fetch_assoc($jenis);
  }
?>
                </select></td>
                <td><input type="text" name="jumlah[]" required></td>
                <td><input type="text" name="jangkawaktu[]" required></td>
			</tr>
		</table>
		<br><br>

		<div id="insert-form"></div>
		
		
		<input type="submit" value="Simpan">
	
	<!-- Kita buat textbox untuk menampung jumlah data form -->
	<input type="hidden" id="jumlah-form" value="1">
    <input name="trigger[]" type="hidden" value="0" />
    <input type="hidden" id="jumlah-form" value="1">
</form>
<hr>
<p>ISI</p>
<table width="100%" border="1">
  <tr>
    <th width="5%">No</th>
    <th width="15%">Kode Permohonan</th>
    <th width="15%">Pekerja</th>
    <th width="10%">Proyek</th>
    <th width="5%">Proses</th>
  </tr>
  <?php $no=1; do { ?>
  <tr>
    <td><?php echo $no++ ?> </td>
    <td><?php echo $row_data['kd_permohonan']; ?></td>
    <td><?php echo $row_data['nmpekerja']; ?></td>
    <td><?php echo $row_data['nmproyek']; ?></td>
    <td><a href="?page=l_permohonan&kd_permohonan=<?php echo $row_data['kd_permohonan']; ?>">Lihat</a></td>
  </tr>
  <?php } while ($row_data = mysql_fetch_assoc($data)); ?>
</table>
<p>&nbsp;</p>

<?php
mysql_free_result($pekerja);

mysql_free_result($proyek);

mysql_free_result($jenis);

mysql_free_result($data);
?>
<script>
	$(document).ready(function(){ // Ketika halaman sudah diload dan siap
		$("#btn-tambah-form").click(function(){ // Ketika tombol Tambah Data Form di klik
			var jumlah = parseInt($("#jumlah-form").val()); // Ambil jumlah data form pada textbox jumlah-form
			var nextform = jumlah + 1; // Tambah 1 untuk jumlah form nya
			
			// Kita akan menambahkan form dengan menggunakan append
			// pada sebuah tag div yg kita beri id insert-form
			$("#insert-form").append("<b>Data ke " + nextform + " :</b>" +
				"<table>" +
				"<tr>" +
				"<td>Jenis</td>" +
				"<td>Jumlah</td>" +
				"<td>Jangka Waktu</td>" +
				"</tr>" +
				"<tr>" +
				"<td>" +
				"<select name='jenis[]'  required> <option>Pilih Satu</option> " +
				<?php
					$query = "SELECT * FROM jenis ORDER by nmjenis";
					$hasil = mysql_query($query) or die ("Query gagal!");
					$x = 1 ;
					while($data = mysql_fetch_array($hasil))
{
				?>
				"<option value='<?php echo $data['kd_jenis']?>@<?php echo $row_jenis['harga']; ?>'><?php echo $data['nmjenis']?></option> " +
				
<?php
$x = $x + 1;
} ?>
				"</td>" +
				
				"<td><input type='text' name='jumlah[]' required></td>" +
				"<td><input type='text' name='jangkawaktu[]' required><input type='hidden' name='trigger[]' ></td>" +
				
				
				"</tr>" +
				"</table>" +
				"<br><br>");
			
			$("#jumlah-form").val(nextform); // Ubah value textbox jumlah-form dengan variabel nextform
		});
		
		// Buat fungsi untuk mereset form ke semula
		$("#btn-reset-form").click(function(){
			$("#insert-form").html(""); // Kita kosongkan isi dari div insert-form
			$("#jumlah-form").val("1"); // Ubah kembali value jumlah form menjadi 1
		});
	});
	</script>