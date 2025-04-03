<?php
session_start();
require "fungsi.php";

	
	if (isset($_SESSION['username'])) {
		//header("location:homeAdmin.php");
		//exit();
	}

	if ($_SERVER["REQUEST_METHOD"]=="POST") {
		$username = trim($_POST['username']);
		$password = trim($_POST['password']); // Ambil password tanpa di-hash!
		if (!empty($username) && !empty($password)) {
			$sql1 = "SELECT * FROM user WHERE username = ?";
			$stmt = $koneksi->prepare($sql1);
			$stmt->bind_param('s',$username);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows==1) {
				$user1 = $result->fetch_assoc();

				if (password_verify($password, $user1['password'])) {
					//session_start();
					$_SESSION['username'] = $username;
					 // Simpan session user 

					header("location:homeAdmin.php");
					exit();
				}
				else {
					echo '<script> window.alert("LOGIN GAGAL!");</script>';
				}
			}
			else {
				echo "User tidak ditemukan.";
			}

			$stmt->close();
		}

		$koneksi->close();
	}
	else {

		echo '<script>
                window.alert(":)");
             </script>';
	}
	?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Sistem</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
	<script src="bootstrap4/js/bootstrap.js"></script>
	<script src="bootstrap4/jquery/jquery-3.7.1.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="w-50 mx-auto text-center mt-5">
			<div class="card bg-dark text-light">
				<div class="card-body">
				<h2 class="card-title">LOGIN</h2>	
				<form method="post" action="">
					<div class="form-group">
						<label for="username">Username</label>
						<input class="form-control" type="text" name="username" id="username" autofocus required>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input class="form-control" type="password" name="password" id="password" required>
					</div>			
					<div>		
						<button class="btn btn-info" type="submit">Login</button>
					</div>
				</form>
				</div>
			</div>
		</div>	
	</div>
</body>
</html>