<?php
include '../koneksi.php';

$field = $_GET['field'];
$value = $_GET['value'];
$id = isset($_GET['id']) ? $_GET['id'] : null;

$query = "SELECT * FROM user WHERE $field = ?";
$params = [$value];

if ($id) {
    $query .= " AND id_user != ?";
    $params[] = $id;
}

$stmt = $conn->prepare($query);
$stmt->execute($params);

if ($stmt->rowCount() > 0) {
    echo "exists";
} else {
    echo "available";
}
?>