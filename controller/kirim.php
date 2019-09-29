<?php
	include '../connection.php';
	
	function generateCode($length = 32){
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',ceil($length/strlen($x)))),1,$length);
	}
	
	$security_code = generateCode();
	$no_rek_pengirim = $_POST['no_rek_pengirim'];
	$no_rek_penerima =$_POST['no_rek_penerima'];
	$nama =$_POST['nama'];
	$jumlah_kirim =$_POST['nominal'];
	$no_telepeon=$_POST['no_telp'];
	$tipe_warkat = $_POST['tipe_warkat'];
	$date = date_create()->format('Y-m-d H:i:s');
	
	echo $security_code."<br>";
	echo $no_rek_pengirim ."<br>";
	echo $no_rek_penerima ."<br>";
	echo $tipe_warkat ."<br>";
	echo $nama ."<br>";
	echo $jumlah_kirim ."<br>";
	echo $no_telepeon ."<br>";
	echo $date;
	
	$sql = "INSERT INTO tbl_transaksi_warkat(
			security_code,
			no_rek_pengirim,
			no_rek_penerima,
			tipe_warkat,
			jumlah_transfer,
			status,
			tgl_efektif,
			tgl_issue
		)
		VALUES
		(
			'$security_code',
			'$no_rek_pengirim',
			'$no_rek_penerima',
			'$tipe_warkat',
			'$jumlah_kirim',
			'Belum Dicairkan',
			'$date',
			'$date'
		)
	";
	
	if(mysqli_query($conn,$sql)){
		header('location: ../ui/dashboard_kirim.php?msg=ok');
	}
	else{
		header('location: ../ui/dashboard_kirim.php?msg=gagal');
		//echo mysqli_error($conn);
	}
	
	mysqli_close($conn);
?>