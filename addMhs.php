<!DOCTYPE html>
<html>
	<head>
		<title>Sistem Informasi Akademik::Tambah Data Mahasiswa</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/styleku.css">
		<link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
		<script src="bootstrap-5.3.3-dist/js/bootstrap.js"></script>
		<script src="bootstrap-5.3.3-dist/jquery/jquery-3.3.1.js"></script>

		<style>
			.error {
				color: red;
				font-size: 0.9em;
				display: none;
			}

			#nim {
				width: 150px;
			}

			#ajaxResponse {
				margin-top: 15px;
			}
		</style>

		<script>
			$(document).ready(function() {
				//fungsi untuk mengecek NIM di database
				function checkNIMExists(nim) {
					$.ajax({
						url: 'check_nim.php',
						type: 'POST',
						data: {
							nim: nim
						},
						success: function(response) {
							if (response === 'exists') {
								showError("* Data sudah ada, silahkan isikan yang lain");
								$("#nim").val("").focus();
								return false;
							} else {
								hideError();
								$("#nama").focus();
							}
						}
					});
				}

				function validateNIM() {
					var nim = $("#nim").val();
					var errorMsg = "";

					// Cek apakah NIM kosong
					if (nim.trim() === "") {
						errorMsg = "* NIM tidak boleh kosong!";
						showError(errorMsg);
						return false;
					}
					// Cek panjang NIM
					else if (nim.length !== 14) {
						errorMsg = "* NIM harus terdiri dari 14 karakter (contoh: A12.2023.12345)";
						showError(errorMsg);
						return false;
					}
					// Cek format NIM
					else if (!/^[A-Z]\d{2}\.\d{4}\.\d{5}$/.test(nim)) {
						errorMsg = "* Format NIM tidak sesuai. Gunakan format: A12.2023.12345";
						showError(errorMsg);
						return false;
					}

					return true;
				}
			}
		</script>
	</head>
	<body>
		<?php
			require "head.html";
		?>
		<div class="utama">		
			<br><br><br>		
			<h3>TAMBAH DATA MAHASISWA</h3>
			<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			</div>	
			<form method="post" action="sv_addMhs.php" enctype="multipart/form-data">
				<div class="form-group">
					<label for="nim">NIM:</label>
					<input class="form-control" type="text" name="nim" id="nim" required>
				</div>
				<div class="form-group">
					<label for="nama">Nama:</label>
					<input class="form-control" type="text" name="nama" id="nama">
				</div>
				<div class="form-group">
					<label for="email">Email:</label>
					<input class="form-control" type="email" name="email" id="email">
				</div>
				<div class="form-group">
					<label for="foto">Foto</label> 
					<input class="form-control" type="file" name="foto" id="foto">
				</div>
				<div>		
					<button type="submit" class="btn btn-primary" value="Simpan">Simpan</button>
				</div>
			</form>
		</div>
	</body>
</html>