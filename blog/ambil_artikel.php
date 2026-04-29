<?php
require 'koneksi.php';
header('Content-Type: application/json');

$sql = "SELECT a.id, a.judul, a.gambar, a.hari_tanggal, a.isi,
               p.nama_depan, p.nama_belakang,
               k.nama_kategori
        FROM artikel a
        JOIN penulis p ON a.id_penulis = p.id
        JOIN kategori_artikel k ON a.id_kategori = k.id
        ORDER BY a.id DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['success' => true, 'data' => $data]);
$stmt->close();
$conn->close();
