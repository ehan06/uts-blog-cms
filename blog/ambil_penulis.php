<?php
require 'koneksi.php';
header('Content-Type: application/json');

$stmt = $conn->prepare("SELECT id, nama_depan, nama_belakang, user_name, password, foto FROM penulis ORDER BY id ASC");
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['success' => true, 'data' => $data]);
$stmt->close();
$conn->close();
