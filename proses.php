<?php
include "Connections/koneksi.php";
error_reporting(E_ALL);
// Ambil data yang dikirim dari form
$permohonan = $_POST['kd_permohonan']; // Ambil data nis dan masukkan ke variabel nis
$pekerja = $_POST['id_pekerja']; // Ambil data nama dan masukkan ke variabel nama
$proyek = $_POST['id_proyek']; // Ambil data telp dan masukkan ke variabel telp
$jenis = $_POST['jenis']; // Ambil data alamat dan masukkan ke variabel alamat
$jumlah = $_POST['jumlah'];
$jangkawaktu = $_POST['jangkawaktu'];
$trigger=$_POST['trigger'];
$query1="INSERT INTO permohonan values ('$permohonan','$pekerja','$proyek') ";
try {
	mysql_query($query1, $koneksi);
} catch (Exception $e) {
	echo "error di query pertama";
	mysql_error();
	echo $e;
}

// Proses simpan ke Database
$query = "INSERT INTO detail_permohonan (kd_permohonan, kd_jenis, jumlah, jangkawaktu) values";

$index = 0; // Set index array awal dengan 0
foreach($trigger as $datanis){ // Kita buat perulangan berdasarkan nis sampai data terakhir
	$query .= "('$permohonan','$jenis[$index]','$jumlah[$index]','$jangkawaktu[$index]'),";
	$index++;
}

// Kita hilangkan tanda koma di akhir query
// sehingga kalau di echo $query nya akan sepert ini : (contoh ada 2 data siswa)
// INSERT INTO siswa VALUES('1011001','Rizaldi','Laki-laki','089288277372','Bandung'),('1011002','Siska','Perempuan','085266255121','Jakarta');
$query = substr($query, 0, strlen($query) - 1).";";

// Eksekusi $query
// echo $query;
try {
mysql_query($query, $koneksi);
	// echo "berhasil";
	header("location:index.php?page=permohonan");
} catch (Exception $e) {
	echo "error di query ke dua";
	echo mysql_error();
}
// echo $query;
// Buat sebuah alert sukses, dan redirect ke halaman awal (index.php)
?>

