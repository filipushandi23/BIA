<html>
	<head>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<script src="../js/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<title>Register GCW</title>
	</head>
	<body>
		<div class="container my-4">
			<h1>Form Register Aplikasi Generate Code Warkat</h1>
			<h4>Data Diri</h4>
			<form action="../controller/register.php" method="post">
				<table cellpadding="10">
					<tr><td>NIK</td><td><input type="text" class="form-control" name="nik" required></td></tr>
					<tr><td>Nama</td><td><input type="text" class="form-control" name="nama" required></td></tr>
					<tr><td>Alamat</td><td><input type="text" class="form-control" name="alamat" required></td></tr>
					<tr><td>No HP</td><td><input type="text" class="form-control" name="no_hp" required></td></tr>
					<tr><td>No Rekening</td><td><input type="text" class="form-control" name="no_rek" required></td></tr>
					<tr><td>Tipe Rekening</td>
						<td>
							<select class="form-control" name="tipe_rekening">
								<option value="Tahapan">Tahapan</option>
								<option value="Giro">Giro</option>
							</select>
						</td>
					</tr>
				</table>
				<hr>
				<h4>User Credential</h4>
				<table cellpadding="10">
					<tr><td>Username</td><td><input type="text" class="form-control" name="username" required></td></tr>
					<tr><td>Password</td><td><input type="password" class="form-control" name="password" required></td></tr>
					<tr><td>Confirm Password</td><td><input type="password" class="form-control" name="confirm_password" required></td></tr>
					<!--<tr><td>PIN</td><td><input type="password" class="form-control"></td></tr>
					<tr><td>Confirm PIN</td><td><input type="password" class="form-control"></td></tr>-->
					<tr><td colspan="2"><input type="submit" class="btn btn-primary" value="Register"></td></td>
				</table>
			</form>
		</div> 
	</body>
</html>