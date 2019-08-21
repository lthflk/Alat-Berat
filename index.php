<?php require_once('Connections/koneksi.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

$colname_log = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_log = $_SESSION['MM_Username'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_log = sprintf("SELECT * FROM login WHERE username = %s", GetSQLValueString($colname_log, "text"));
$log = mysql_query($query_log, $koneksi) or die(mysql_error());
$row_log = mysql_fetch_assoc($log);
$totalRows_log = mysql_num_rows($log);
?>
 
<html>
<head>
	<title>Aplikasi Pengajuan Permohonan Penyediaan Alat Berat</title>
	<link rel="stylesheet" type="text/css" href="style.css">
    <script src="jquery.min.js"></script>
</head>
<body>
	
	<!-- bagian header template -->
	
	<!-- akhir bagian header template -->
	
	<div class="wrap">
    <header>
		<h1 class="judul">APLIKASI PENGAJUAN PERMOHONAN PENYEDIAAN ALAT BERAT</h1>
		
	</header>
    <!-- bagian menu		 -->
		<nav class="menu">
			<ul>
				<li><a href="index.php">Beranda</a></li>
                <li><a href="?page=jenis">Jenis Alat Berat</a></li>
                <li><a href="?page=proyek">Proyek</a></li>
                <li><a href="?page=pekerja">Pekerja</a></li>
                 <li><a href="?page=jabatan">Jabatan</a></li>
                <li><a href="?page=permohonan">Permohonan</a></li>
                <li><a href="?page=laporan">Laporan Permohonan</a></li>
			</ul>
		</nav>
		<!-- akhir bagian menu -->
 
		<!-- bagian sidebar website -->
		<aside class="sidebar">
		  <div class="widget">
			<h2>KElolah Sistem		  </h2>
			<p>selamat datang, <?php echo $row_log['username']; ?><strong></strong></p>
			<p>Kelola User</p>
			<p>&nbsp;</p>
			<p><a href="<?php echo $logoutAction ?>">Keluar</a></p>
		  </div>
		  <div class="widget">
			<h2>Programmer</h2>
			  <p>NIM : <br>
		      201601030018</p>
				<p> Nama : <br>
			    Indah Suhada</p>
				<p>E-mail : <br>
			    indahsuhada08@gmail.com</p>
		  </div>
		</aside>
		<!-- akhir bagian sidebar website -->
 
		<!-- bagian konten Blog -->
		<div class="blog">
		  <div class="conteudo"><strong>Anda Telah Berada Di Halaman Administrator</strong>
			  <hr>
			  <p><span class="deskripsi">
              <?php
			  if(isset($_GET['page']))
			     include"$_GET[page].php";
				 else
				include "beranda.php"; 
			  ?>
              </span></p>
			  <p>&nbsp;</p>
		  </div>
		</div>
		<!-- akhir bagian konten Blog -->
	</div>
 
</body>
</html>
<?php
mysql_free_result($log);
?>
