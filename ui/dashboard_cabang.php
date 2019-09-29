<html>
	<head>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<script src="../js/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<title>Cabang</title>
	</head>
	<body>
		<div class="container my-4">
			<h1>Dashboard Cabang</h1>
			<a href="../logout.php">Logout</a>
			<?php
				include '../connection.php';
				session_start();

				if(!isset($_SESSION['username'])){
					header('location: ../login.php');
				}
				else{
					// if($_SESSION['role'] != "Cabang")
					// {
					// 	header('location: ../index.php');
					// }

			?>

			<table cellpadding="10">
				<tr>
					<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#approvalModal">Approval</button></td>
				</tr>

			</table>

			<br>
			<table class="table">
				<tr>
					<th>Security Code</th>
					<th>No Rekening Pengirim</th>
					<th>No Rekening Penerima</th>
					<th>Nominal</th>
					<th>Status</th>
				</tr>
				<?php
					if(!isset($_SESSION['username'])){
					header('location: ../login.php');
					}
					else{
						$sql = "SELECT * FROM tbl_transaksi_warkat ORDER BY tgl_issue DESC";
						$result = mysqli_query($conn, $sql);
						if(mysqli_num_rows($result)) {
							while($row = mysqli_fetch_assoc($result)){
								echo "
								<tr>
									<td>".$row['security_code']."</td>
									<td>".$row['no_rek_pengirim']."</td>
									<td>".$row['no_rek_penerima']."</td>
									<td>Rp ".number_format($row['jumlah_transfer'],2)."</td>
									<td>".$row['status']."</td>
								</tr>";
							}
						}
					}
				?>
			</table>

			<!-- Modal -->
			<div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="approvalModalTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="approvalModalTitle">Approval Transaksi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					  <form action="../controller/approve.php" method="post">
							<table cellpadding="5">
								<tr>
									<td>Kode Warkat</td>
									<td>
										<select class="form-control" id="code" name="security_code">
											<option>-------Security Code-------</option>
											<?php
												$sql = "SELECT * FROM tbl_transaksi_warkat WHERE status='Siap Dijalankan'";
												$result = mysqli_query($conn, $sql);
												if(mysqli_num_rows($result)) {
													while($row = mysqli_fetch_assoc($result)){
														echo "
															<option value='". $row['security_code'] ."'>". $row['security_code'] ."</option>
														";
													}
												}
											?>
										</select>
									</td>
									<td><button type="button" class="btn btn-secondary" id="btnCheck">Check</button></td>
								</tr>
								<tr>
									<td>No Rekening Pengirim</td>
									<td>
										<input type="text" class="form-control" name="no_rek_pengirim" id="tag-rek-pengirim" readonly>
									</td>
								</tr>
								<tr>
									<td>Nama Pengirim</td>
									<td>
										<input type="text" class="form-control" name="nama_pengirim" id="tag-nama-pengirim" readonly>
									</td>
								</tr>
								<tr>
									<td>No Rekening Penerima</td>
									<td>
										<input type="text" class="form-control" name="no_rek_penerima" id="tag-rek-penerima" readonly>
									</td>
								</tr>
								<tr>
									<td>Nama Penerima</td>
									<td>
										<input type="text" class="form-control" name="nama_penerima" id="tag-nama-penerima" readonly>
									</td>
								</tr>
								<tr>
									<td>Nominal</td>
									<td>
										<input type="text" class="form-control" name="nominal" id="tag-nominal" readonly>
									</td>
								</tr>
							</table>
						  </div>
						  <div class="modal-footer">
							<input type="submit" class="btn btn-primary" value="Approve">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						  </div>
					  </form>
				</div>
			  </div>
			</div>
			<?php

				}
			?>


		<script>
			$(document).ready(function(){
			  $("#btnCheck").click(function(){
				var code = $('#code').val();
				console.log("isi: "+code);
				$.ajax(
					{
						url: "../controller/backend-search-approval.php",
						type: "POST",
						data: {
							param : code
						},
						success: function(data) {
							var myObject = JSON.parse(data);
							if(myObject.no_rek_pengirim==""){
								alert("Data tidak ditemukan");
							}
							$('#tag-rek-pengirim').val(myObject.no_rek_pengirim);
							$('#tag-nama-pengirim').val(myObject.nama_pengirim);
							$('#tag-rek-penerima').val(myObject.no_rek_penerima);
							$('#tag-nama-penerima').val(myObject.nama_penerima);
							$('#tag-nominal').val(myObject.jumlah_transfer);
							console.log(data);
						}
					}
				);
			  });
			});
		</script>

	</body>
</html>
