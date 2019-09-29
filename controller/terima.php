<?php
	include '../connection.php';
	
	$security_code = $_POST['security_code'];
	$no_rek_pengirim = $_POST['no_rek_pengirim'];
	$nama =$_POST['nama'];
	$jumlah_kirim =$_POST['nominal'];
	
	echo $security_code ."<br>";
	echo $no_rek_pengirim ."<br>";
	echo $nama ."<br>";
	echo $jumlah_kirim ."<br>";
	
	$sql = "
		UPDATE tbl_transaksi_warkat
		SET status = 'Siap Dijalankan'
		WHERE security_code = '$security_code'
	";
	
	if(mysqli_query($conn,$sql)){
		header('location: ../ui/dashboard_terima.php?msg=ok');
	}
	else{
		header('location: ../ui/dashboard_terima.php?msg=gagal');
		echo mysqli_error($conn);
	}
	
	mysqli_close($conn);
?>