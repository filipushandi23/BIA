<?php
	
	include '../connection.php';
	
	//data diri
	$nik = $_POST['nik'];
	$nama = $_POST['nama'];
	$alamat = $_POST['alamat'];
	$no_hp = $_POST['no_hp'];
	/*$no_rek = $_POST['no_rek'];
	$tipe_rekening = $_POST['tipe_rekening'];*/
	
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	
	/*$pin = $_POST['pin'];
	$confirm_pin = $_POST['confirm_pin'];*/
	
	/*$myObj = new \stdClass();
	$myObj->nama = $nama;
	$myObj->alamat = $alamat;
	$myObj->no_hp = $no_hp;
	$myObj->no_rek = $no_rek;
	$myObj->tipe_rekening = $tipe_rekening;
	$myObj->username = $username;
	$myObj->password = $password;

	$myJSON = json_encode($myObj);
	echo $myJSON;*/
	
	if($password == $confirm_password && strlen($password)>=6){
		$sql_user = "
			INSERT INTO tbl_user (username,password,role)
			VALUES('$username','$password','Nasabah')
		";
		if(mysqli_query($conn,$sql_user)){
			$id = mysqli_insert_id($conn);
			$cif = generateCIF();
			$sql_data_nasabah = "
				INSERT INTO tbl_data_nasabah (cif,user_id,nik,nama,alamat,no_hp)
				VALUES('$cif','$id','$nik','$nama','$alamat','$no_hp')
			";
			if(mysqli_query($conn,$sql_data_nasabah)){
				echo "data berhasil masuk";
			}
			else{
				echo mysqli_error($conn);
			}
		}
		else{
			echo mysqli_error($conn);
		}
	}
	else{
		echo "password tdak sama";
	}
	
	function generateCIF($length = 8){
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',ceil($length/strlen($x)))),1,$length);
	}
	
?>