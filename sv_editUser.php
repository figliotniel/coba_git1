<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include '../koneksi.php';

$id_user = $_POST['id_user'];
$username = $_POST['username'];
$nama_lengkap = $_POST['nama_lengkap'];
$email = $_POST['email'];
$level = $_POST['level'];
$status_aktif = $_POST['status_aktif'];

// Cek apakah password diubah
if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE user SET username=?, password=?, nama_lengkap=?, 
                           email=?, level=?, status_aktif=? WHERE id_user=?");
    $stmt->execute([$username, $password, $nama_lengkap, $email, $level, $status_aktif, $id_user]);
} else {
    $stmt = $conn->prepare("UPDATE user SET username=?, nama_lengkap=?, 
                           email=?, level=?, status_aktif=? WHERE id_user=?");
    $stmt->execute([$username, $nama_lengkap, $email, $level, $status_aktif, $id_user]);
}

header("Location: index.php?pesan=Data user berhasil diperbarui");
exit();
?>