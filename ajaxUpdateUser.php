<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit();
}

include '../koneksi.php';

$id = $_POST['id'];
$field = $_POST['field'];
$value = $_POST['value'];

// Validasi field yang boleh diupdate via AJAX
$allowed_fields = ['status_aktif'];
if (!in_array($field, $allowed_fields)) {
    echo json_encode(['status' => 'error', 'message' => 'Field not allowed']);
    exit();
}

$stmt = $conn->prepare("UPDATE user SET $field = ? WHERE id_user = ?");
$stmt->execute([$value, $id]);

if ($stmt->rowCount() > 0) {
    echo json_encode(['status' => 'success', 'message' => 'Data updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update data']);
}
?>