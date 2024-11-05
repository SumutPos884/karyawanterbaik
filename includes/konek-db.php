<?php 
$koneksi = mysqli_connect("localhost","root","","saw_dbkaryawan4");
 
// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}

?>
 