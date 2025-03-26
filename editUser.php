<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include '../koneksi.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM user WHERE id_user = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data User</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/jquery.min.js"></script>
    <script src="cekDataKembarUser.php"></script>
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Data User</h2>
        <form action="sv_editUser.php" method="post">
            <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
            
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" 
                       value="<?= $user['username'] ?>" required>
                <small id="usernameHelp" class="form-text text-muted"></small>
            </div>
            
            <div class="form-group">
                <label for="password">Password (Kosongkan jika tidak diubah):</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap:</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" 
                       value="<?= $user['nama_lengkap'] ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?= $user['email'] ?>" required>
                <small id="emailHelp" class="form-text text-muted"></small>
            </div>
            
            <div class="form-group">
                <label for="level">Level Akses:</label>
                <select class="form-control" id="level" name="level">
                    <option value="admin" <?= $user['level'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="dosen" <?= $user['level'] == 'dosen' ? 'selected' : '' ?>>Dosen</option>
                    <option value="staff" <?= $user['level'] == 'staff' ? 'selected' : '' ?>>Staff</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="status_aktif">Status:</label>
                <select class="form-control" id="status_aktif" name="status_aktif">
                    <option value="1" <?= $user['status_aktif'] == 1 ? 'selected' : '' ?>>Aktif</option>
                    <option value="0" <?= $user['status_aktif'] == 0 ? 'selected' : '' ?>>Non-Aktif</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script>
    $(document).ready(function() {
        $('#username').on('blur', function() {
            var username = $(this).val();
            var id_user = <?= $user['id_user'] ?>;
            
            $.get('cekDataKembarUser.php', 
                  {field: 'username', value: username, id: id_user}, 
                  function(data) {
                if (data == 'exists') {
                    $('#usernameHelp').text('Username sudah digunakan').css('color', 'red');
                } else {
                    $('#usernameHelp').text('Username tersedia').css('color', 'green');
                }
            });
        });
        
        $('#email').on('blur', function() {
            var email = $(this).val();
            var id_user = <?= $user['id_user'] ?>;
            
            $.get('cekDataKembarUser.php', 
                  {field: 'email', value: email, id: id_user}, 
                  function(data) {
                if (data == 'exists') {
                    $('#emailHelp').text('Email sudah digunakan').css('color', 'red');
                } else {
                    $('#emailHelp').text('Email tersedia').css('color', 'green');
                }
            });
        });
    });
    </script>
</body>
</html>