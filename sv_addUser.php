<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include '../koneksi.php';

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$nama_lengkap = $_POST['nama_lengkap'];
$email = $_POST['email'];
$level = $_POST['level'];

// Cek apakah username sudah ada
$stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
$stmt->execute([$username]);

if ($stmt->rowCount() > 0) {
    header("Location: addUser.php?pesan=Username sudah digunakan");
    exit();
}

// Tambahkan user baru
$stmt = $conn->prepare("INSERT INTO user (username, password, nama_lengkap, email, level, status_aktif) 
                        VALUES (?, ?, ?, ?, ?, 1)");
$stmt->execute([$username, $password, $nama_lengkap, $email, $level]);

header("Location: index.php?pesan=User baru berhasil ditambahkan");
exit();
?>