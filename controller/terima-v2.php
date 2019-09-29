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
	
	$saldo_pengirim = "";
	$result = mysqli_query($conn, "SELECT saldo from tbl_data_rekening WHERE no_rek='$no_rek_pengirim'");
	if(mysqli_num_rows($result)) {
		while($row = mysqli_fetch_assoc($result)){
			$saldo_pengirim = $row['saldo'];
		}
	}
	
	if($saldo_pengirim-$jumlah_kirim>=0){
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
	}
	else{
		$sql = "
			UPDATE tbl_transaksi_warkat
			SET status = 'Saldo Tidak Cukup'
			WHERE security_code = '$security_code'
		";
		
		if(mysqli_query($conn,$sql)){
			header('location: ../ui/dashboard_terima.php?msg=ok');
		}
		else{
			header('location: ../ui/dashboard_terima.php?msg=gagal');
			echo mysqli_error($conn);
		}
	}
	mysqli_close($conn);
?>