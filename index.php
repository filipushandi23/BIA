<html>
	<head>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<title>Index</title>
		<script src="js/jquery.min.js"></script>
	</head>
	<body>
		<?php
			session_start();
			if(!isset($_SESSION['username'])){
		?>
		<div class="container my-4">
			<center>
				<img src="assets/logo.png"><br>
				Click <a href='login.php'>HERE</a> to login<br>
				Click <a href='ui/form_register.php'>HERE</a> to register
			</center>
		</div>
		<?php
			}
			else{
				if($_SESSION['role'] == "Nasabah"){
		?>
			<div class="container my-4">
				<h1> Welcome <?php echo $_SESSION['username']?></h1><a href="logout.php">Logout</a>
				<hr>
				Pilih salah satu menu berikut ini:
				<ul>
					<li><a href='ui/dashboard_kirim.php'>Kirim Warkat</a></li>
					<li><a href='ui/dashboard_terima.php'>Terima Warkat</a></li>
					<li><a href='#'>Daftar Rekening</a></li>
				<ul>
			</div>

		<?php
				}
				else{
					header("location: ui/dashboard_cabang.php");
				}
			}
		?>
	</body>
</html>
