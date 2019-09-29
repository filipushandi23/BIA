<html>
	<head>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<script src="../js/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<title>Terima</title>
	</head>
	<body>
		<div class="container my-4">
			<h1>Dashboard Terima Warkat Nasabah</h1>
			<a href="../index.php">Back</a>
			<?php
				include '../connection.php';
				session_start();

				$cif = $_SESSION['cif'];

				if(!isset($_SESSION['username']) && $_SESSION['role'] != "Nasabah"){
					header('location: ../login.php');
				}
				else{
					$sql = "SELECT * FROM tbl_data_nasabah dn JOIN tbl_data_rekening dr ON dn.cif = dr.cif WHERE dn.cif = '$cif'";
					$result = mysqli_query($conn, $sql);
					if(mysqli_num_rows($result)) {
						$row = mysqli_fetch_assoc($result);
						$no_rek = $row['no_rek'];
						$saldo = $row['saldo'];
						$nama = $row['nama'];
						$cabang = $row['cabang'];
			?>
			<table cellpadding="10">
				<tr>
					<td>No Rekening</td>
					<td><?php echo $no_rek ?></td>
					<td>Saldo</td>
					<td>Rp <?php echo number_format($saldo,2) ?></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td><?php echo $nama ?></td>
					<td rowspan="2"><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalCenter">Pencairan Warkat</button></td>
				</tr>
				<tr>
					<td>Cabang</td>
					<td><?php echo $cabang ?></td>
				</tr>
			</table>
				<?php }} ?>
			<br>
			<table class="table">
				<tr>
					<th>Kode</th>
					<th>No Rekening Pengirim</th>
					<th>Nama Penerima</th>
					<th>Nominal</th>
					<th>Status</th>
				</tr>
				<?php
					$sql = "SELECT tw.security_code, tw.no_rek_pengirim,tw.jumlah_transfer,tw.status,
							(SELECT nama FROM tbl_data_nasabah dn
							JOIN tbl_data_rekening dr ON dn.cif = dr.cif
							WHERE dr.no_rek = tw.no_rek_pengirim) AS nama_pengirim
							FROM tbl_transaksi_warkat tw
							JOIN tbl_data_rekening dr on tw.no_rek_pengirim = dr.no_rek
							JOIN tbl_data_nasabah dn on dr.cif = dn.cif
							WHERE tw.no_rek_penerima='$no_rek'
							ORDER BY tw.tgl_issue DESC";
					$result = mysqli_query($conn, $sql);
					if(mysqli_num_rows($result)) {
						while($row = mysqli_fetch_assoc($result)){
							echo "<tr>
								<td>". $row['security_code'] ."</td>
								<td>". $row['no_rek_pengirim'] ."</td>
								<td>". $row['nama_pengirim'] ."</td>
								<td>Rp ". number_format($row['jumlah_transfer']) ."</td>
								<td>". $row['status'] ."</td>
							</tr>";
						}
					}
				?>
			</table>

			<!-- Modal -->
			<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenterTitle">Pencairan Warkat</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <form action="../controller/terima.php" method="post">
					  <div class="modal-body">
						<table cellpadding="5">

							<tr>
								<td>Kode Warkat</td>
								<td>
									<select class="form-control" id="code" name="security_code">
										<option>-------Security Code-------</option>
										<?php
											$sql = "SELECT * from tbl_transaksi_warkat
													WHERE no_rek_penerima='$no_rek' AND status='Belum Dicairkan'";
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
								<td><button type="button" id="btnCheck" class="btn btn-secondary">Check</button></td>
							</tr>
							<tr><td>No Rekening Pengirim</td><td colspan="2"><input type="text" class="form-control" name="no_rek_pengirim" id="tag-rekening" readonly></td></tr>
							<tr><td>Nama</td><td colspan="2"><input type="text" class="form-control" name="nama" id="tag-nama" readonly></td></tr>
							<tr><td>Nominal</td><td colspan="2"><input type="text" class="form-control" name="nominal" id="tag-nominal" readonly></td></tr>
						</table>
					  </div>
					  <div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Cairkan">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					  </div>
				  </form>
				</div>
			  </div>
			</div>

		</div>
		<script>
			$(document).ready(function(){
			  $("#btnCheck").click(function(){
				var code = $('#code').val();
				console.log("isi: "+code);
				$.ajax(
					{

						url: "../controller/backend-search-transaksi.php",
						type: "POST",
						data: {
							param : code
						},
						success: function(data) {
							var myObject = JSON.parse(data);
							if(myObject.no_rek_pengirim==""){
								alert("Data tidak ditemukan");
							}
							$('#tag-rekening').val(myObject.no_rek_pengirim);
							$('#tag-nama').val(myObject.nama_pengirim);
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
