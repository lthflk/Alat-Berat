<?php
require_once('Connections/koneksi.php');
$array="1";
$array++;
$kd_jenis = $_POST['jenis'];
$sql = mysql_query("SELECT * FROM jenis WHERE kd_jenis='".$kd_jenis."'");

while($data = mysql_fetch_array($sql)){ 
	$html = "<option value='".$data['harga']."'>".$data['harga']."</option>"; 
}

$callback = array('data_total'=>$html); 

echo json_encode($callback); 
?>
