<html>
	<head>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<script src="../js/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<title>Kirim Warkat</title>
	</head>
	<body>
		<?php
			/*if(isset($_GET['msg'])){
				$msg = $_GET['msg'];
				if($msg == "ok"){
					echo "<script>
						alert('Berhasil mengajukan warkat non kliring');
					</script>";
				}
				else{
					echo "<script>
						alert('Gagal mengajukan warkat non kliring');
					</script>";
				}
			}*/
		?>
		<div class="container my-4">
			<h1>Dashboard Kirim Warkat Nasabah</h1>
			<a href="../index.php">Back</a>
			<?php
				include '../connection.php';
				session_start();


				if(!isset($_SESSION['username'])){
					header('location: ../login.php');
				}
				else{
					$cif = $_SESSION['cif'];
					$sql = "SELECT * FROM tbl_data_nasabah dn JOIN tbl_data_rekening dr ON dn.cif = dr.cif WHERE dn.cif = '$cif'";
					$result = mysqli_query($conn, $sql);
					if(mysqli_num_rows($result)) {
						$row = mysqli_fetch_assoc($result);
						$no_rek = $row['no_rek'];
						$saldo = $row['saldo'];
						$nama = $row['nama'];
						$cabang = $row['cabang'];
						$no_hp = $row['no_hp'];
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
					<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#kirimWarkatModal">Kirim Warkat</button></td>
				</tr>
				<tr>
					<td>Cabang</td>
					<td><?php echo $cabang ?></td>
				</tr>
			</table>

			<br>
			<table class="table">
				<tr>
					<th>No Rekening Tujuan</th>
					<th>Nama Penerima</th>
					<th>Nominal</th>
					<th>Status</th>
				</tr>
				<?php
					$sql = "SELECT tw.no_rek_penerima,tw.jumlah_transfer,tw.status,
							(SELECT nama FROM tbl_data_nasabah dn
							JOIN tbl_data_rekening dr ON dn.cif = dr.cif
							WHERE dr.no_rek = tw.no_rek_penerima) AS nama_penerima
							FROM tbl_transaksi_warkat tw
							JOIN tbl_data_rekening dr on tw.no_rek_pengirim = dr.no_rek
							JOIN tbl_data_nasabah dn on dr.cif = dn.cif
							WHERE tw.no_rek_pengirim='$no_rek'
							ORDER BY tw.tgl_issue DESC";
					$result = mysqli_query($conn, $sql);
					if(mysqli_num_rows($result)) {
						while($row = mysqli_fetch_assoc($result)){
							echo "<tr>
								<td>". $row['no_rek_penerima'] ."</td>
								<td>". $row['nama_penerima'] ."</td>
								<td>Rp ". number_format($row['jumlah_transfer']) ."</td>
								<td>". $row['status'] ."</td>
							</tr>";
						}
					}
				?>
			</table>

			<!-- Modal -->
			<div class="modal fade" id="kirimWarkatModal" tabindex="-1" role="dialog" aria-labelledby="kirimWarkatModalTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="kirimWarkatModalTitle">Pengajuan Warkat Non Kliring</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					  <form action="../controller/kirim.php" method="post">
							<table cellpadding="5">
								<tr>
									<td>Rekening Tujuan</td>
									<td>
										<input type="text" id="rek-tujuan" name="no_rek_penerima" class="form-control" required>
									</td>
									<td><button type="button" id="btnCheck" class="btn btn-secondary">Check</button>
									</td>
								</tr>
								<tr><td>Nama</td><td colspan="2"><input type="text" id="tag-nama" name="nama" class="form-control" readonly></td></tr>
								<tr><td>No Telepon</td><td colspan="2"><input type="text" id="tag-telepon" name="no_telp" class="form-control" readonly></td></tr>
								<tr>
									<td>Jenis Warkat</td>
									<td colspan="2">
											<select name="tipe_warkat" class="form-control">
												<option value="Cek">Cek</option>
												<option value="Bilyet Giro">Bilyet Giro</option>
											</select>
									</td>
								</tr>
								<tr><td>Nominal (Rupiah)</td><td colspan="2"><input type="text" name="nominal" class="form-control" required></td></tr>
								<input type="hidden" name="no_rek_pengirim" value="<?php echo $no_rek ?>">

							</table>
						  </div>
						  <div class="modal-footer">
							<input type="submit" class="btn btn-primary" value="Submit">
							<!--<button type="button" class="btn btn-primary" data-dismiss="modal" data-target="#otpModal">Submit</button>!-->
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						  </div>
					  </form>
				</div>
			  </div>
			</div>
				<?php }} ?>

			<!-- Modal -->
			<div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="otpModalTitle">Autentikasi OTP</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<table cellpadding="5">
						<tr>
							<td>Masukkan OTP yang telah dikirimkan ke nomor <?php echo $no_hp ?></td>
							<td>
								<input type="text" class="form-control" required>
							</td>
						</tr>
					</table>
				  </div>
				  <div class="modal-footer">
					<input type="submit" class="btn btn-primary" value="Submit">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				  </div>
				</div>
			  </div>
			</div>


			<script>
			$(document).ready(function(){
			  $("#btnCheck").click(function(){
				var rek_tujuan = $('#rek-tujuan').val();
				console.log("isi: "+rek_tujuan);
				$.ajax(
					{
						url: "../controller/backend-search-rekening.php",
						type: "POST",
						data: {
							param : rek_tujuan
						},
						success: function(data) {
							var myObject = JSON.parse(data);
							if(myObject.no_rek==""){
								alert("Data tidak ditemukan");
							}
							$('#tag-nama').val(myObject.nama);
							$('#tag-telepon').val(myObject.no_hp);
							console.log(data);

						}
					}
				);
			  });
			});
			</script>
		</div>

	</body>
</html>
