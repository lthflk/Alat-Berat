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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "#";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_koneksi, $koneksi);
  
  $LoginRS__query=sprintf("SELECT username, password FROM login WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $koneksi) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Disposisi Surat</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	
	<!-- bagian header template -->
	
	<!-- akhir bagian header template -->
	
	<div class="wrap">
    <header>
		<h1 class="judul">APLIKASI DISPOSISI SURAT MASUK PADA PT. XYZ</h1>
		
	</header>
		<!-- bagian menu		 -->
		<nav class="menu">
			<ul>
           
				<li><a href="#">Dashboard</a></li>
                <li><a href="#">Profil</a></li>
                <li><a href="#">Struktur Organisasi</a></li>
                <li><a href="#">Visi & Misi</a></li>
			</ul>
		</nav>
		<!-- akhir bagian menu -->
 
		<!-- bagian sidebar website -->
		<aside class="sidebar">
		  <div class="widget">
			<h2>LOGIN Sistem</h2>
		    <form name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
		      <p>Username<br>
		        <label for="username"></label>
		      <input name="username" type="text" id="username" size="30">
		      </p>
		      <p>Password<br>
		        <label for="password"></label>
		        <input name="password" type="password" id="password" size="30">
		      </p>
		      <p>
		        <input type="submit" name="button" id="button" value="Login">
		        <input type="reset" name="button2" id="button2" value="Reset">
		      </p>
		    </form>
		  </div>
		  <div class="widget">
			<h2>Programmer</h2>
			  <p>NIM : <br>
		      200701030271</p>
				<p> Nama : <br>
			    Widodo Saputra </p>
				<p>E-mail : <br>
			    widodosaputra01@gmail.com</p>
		  </div>
		</aside>
		<!-- akhir bagian sidebar website -->
 
		<!-- bagian konten Blog -->
		<div class="blog">
		  <div class="conteudo">
							
				<strong>Silahkan Login Terlebih Dahulu Untuk Masuk Ke Sistem</strong>
				<hr>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
		  </div>
		</div>
		<!-- akhir bagian konten Blog -->
	</div>
 
</body>
</html>
