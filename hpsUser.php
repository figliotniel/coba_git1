<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include '../koneksi.php';

$id = $_GET['id'];

// Hapus data user
$stmt = $conn->prepare("DELETE FROM user WHERE id_user = ?");
$stmt->execute([$id]);

header("Location: index.php?pesan=Data user berhasil dihapus");
exit();
?>