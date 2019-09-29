<html>
	<head>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
		<title>Login</title>
	</head>
	<body>
		<?php
			session_start();
			include 'connection.php';

			if($_SERVER["REQUEST_METHOD"] == "POST") {
			  // username and password sent from form

			  $username = $_POST['username'];
			  $password = $_POST['password'];

			  $sql = "SELECT * FROM tbl_user WHERE username = '$username' and password = '$password'";
			  $result = mysqli_query($conn,$sql);
			  // If result matched $myusername and $mypassword, table row must be 1 row


			  if(mysqli_num_rows($result)) {
					$row = mysqli_fetch_assoc($result);
					$user_id = $row['user_id'];
					$_SESSION['username'] = $row['username'];
					$_SESSION['role'] = $row['role'];

					$sql_data_nasabah = "SELECT * FROM tbl_data_nasabah WHERE user_id = '$user_id'";
				  $result_data_nasabah = mysqli_query($conn,$sql_data_nasabah);
					if(mysqli_num_rows($result_data_nasabah)){
						$row = mysqli_fetch_assoc($result_data_nasabah);
						$_SESSION['cif']= $row['cif'];
						if($_SESSION['role'] == "Cabang"){
							header("location: ui/dashboard_cabang.php");
						}
						else{
							header("location: index.php");
						}
					}
			  }
				else
				{
					echo "<script>
						alert('Invalid username or password')
					 </script>";
				 }
		   }

			mysqli_close($conn);
		?>
		<div class="h-100 d-flex justify-content-center align-items-center">
			<center>
				<div class="card" style="width: 30rem;">
				  <div class="card-body">
					<h5 class="card-title">Login</h5>
					<table cellpadding="5">
						<form action = "" method = "post">
							  <tr><td>Username  :</td><td><input type = "text" name = "username" class = "form-control"/></td></tr>
							  <tr><td>Password  :</td><td><input type = "password" name = "password" class = "form-control" /></td></tr>
							  <tr><td><input type = "submit" value = " Submit " class="btn btn-primary"/></td></td>
						</form>
					</table>
				  </div>
				</div>
			</center>
		</div>

	</body>
</html>
