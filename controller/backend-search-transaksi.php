<?php
	include '../connection.php';
	
	if(isset($_POST['param'])){
		$input = $_POST['param'];
		//echo "masuk sini ".$input;
		$sql = "
			SELECT tw.security_code, tw.no_rek_pengirim,tw.jumlah_transfer,tw.status, 
			(SELECT nama FROM tbl_data_nasabah dn 
			JOIN tbl_data_rekening dr ON dn.cif = dr.cif
			WHERE dr.no_rek = tw.no_rek_pengirim) AS nama_pengirim 
			FROM tbl_transaksi_warkat tw 
			JOIN tbl_data_rekening dr on tw.no_rek_pengirim = dr.no_rek
			JOIN tbl_data_nasabah dn on dr.cif = dn.cif
			WHERE tw.security_code='$input'
		";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result)) {
			while($row = mysqli_fetch_assoc($result)){
				$myObj = new \stdClass();
				$myObj->no_rek_pengirim = $row['no_rek_pengirim'];
				$myObj->nama_pengirim = $row['nama_pengirim'];
				$myObj->jumlah_transfer = $row['jumlah_transfer'];
				$myJSON = json_encode($myObj);
				echo $myJSON;
			}
		}
		else{
			
			$myObj = new \stdClass();
			$myObj->no_rek_pengirim = "";
				$myObj->nama_pengirim = "";
				$myObj->jumlah_transfer = "";

			$myJSON = json_encode($myObj);
			echo $myJSON;
		}
	}
	mysqli_close($conn);
	
?>