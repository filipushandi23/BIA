<?php
	include '../connection.php';
	
	$security_code = $_POST['security_code'];
	$no_rek_pengirim = $_POST['no_rek_pengirim'];
	$nama_pengirim =$_POST['nama_pengirim'];
	$no_rek_penerima = $_POST['no_rek_penerima'];
	$nama_penerima =$_POST['nama_penerima'];
	$jumlah_kirim =$_POST['nominal'];
	
	echo $security_code ."<br>";
	echo $no_rek_pengirim ."<br>";
	echo $nama_pengirim ."<br>";
	echo $no_rek_penerima ."<br>";
	echo $nama_penerima ."<br>";
	echo $jumlah_kirim ."<br>";
	
	$saldo_pengirim = "";
	$saldo_penerima = "";
	
	$result = mysqli_query($conn, "SELECT saldo from tbl_data_rekening WHERE no_rek='$no_rek_pengirim'");
	if(mysqli_num_rows($result)) {
		while($row = mysqli_fetch_assoc($result)){
			$saldo_pengirim = $row['saldo'];
		}
	}
		
	//echo "Si $nama_pengirim dengan rekening $no_rek_pengirim memiliki saldo Rp ".number_format($saldo_pengirim)." ingin kirim duit sebesar Rp ".number_format($jumlah_kirim)."\n";
	//echo "Si $nama_penerima dengan rekening $no_rek_penerima memiliki saldo Rp ".number_format($saldo_penerima)."";
	
	$sql_kirim = "
		UPDATE tbl_data_rekening
		SET saldo = saldo - $jumlah_kirim
		WHERE no_rek = '$no_rek_pengirim'
	";
	if(mysqli_query($conn,$sql_kirim)){
		$sql_terima = "
			UPDATE tbl_data_rekening
			SET saldo = saldo + $jumlah_kirim
			WHERE no_rek = '$no_rek_penerima'
		";
		if(mysqli_query($conn,$sql_terima)){
			echo "berhasil kirim duit, duit telah berpindah";

			$sql = "
				UPDATE tbl_transaksi_warkat
				SET status = 'Selesai'
				WHERE security_code = '$security_code'
			";
			
			if(mysqli_query($conn,$sql)){
				header('location: ../ui/dashboard_cabang.php?msg=ok');
			}
			else{
				header('location: ../ui/dashboard_cabang.php?msg=gagal');
				echo mysqli_error($conn);
			}	
		}
		else{
			echo mysqli_error($conn);
		}
	}
	else{
		echo mysqli_error($conn);
	}
	
	mysqli_close($conn);
?>