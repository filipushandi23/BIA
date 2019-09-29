<?php
	include '../connection.php';
	
	if(isset($_POST['param'])){
		$input = $_POST['param'];
		//echo $input;
		$sql = "SELECT * from tbl_data_rekening dr JOIN tbl_data_nasabah dn ON dr.cif = dn.cif WHERE dr.no_rek = '$input'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result)) {
			while($row = mysqli_fetch_assoc($result)){
				//echo "<p>". $row['nama'] . " - ". $row['no_rek'] ."</p>";
				$myObj = new \stdClass();
				$myObj->nama = $row['nama'];
				$myObj->no_rek = $row['no_rek'];
				$myObj->no_hp = $row['no_hp'];

				$myJSON = json_encode($myObj);
				echo $myJSON;
			}
		}
		else{
			$myObj = new \stdClass();
			$myObj->nama = "";
			$myObj->no_rek = "";
			$myObj->no_hp = "";

			$myJSON = json_encode($myObj);
			echo $myJSON;
		}
	}
	mysqli_close($conn);
	
?>