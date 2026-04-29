<?php
include 'koneksi.php';

$penulis = $conn->query("SELECT id, nama_depan FROM penulis");
$kategori = $conn->query("SELECT id, nama_kategori FROM kategori_artikel");

$data = [
    "penulis" => [],
    "kategori" => []
];

while ($p = $penulis->fetch_assoc()) {
    $data["penulis"][] = $p;
}

while ($k = $kategori->fetch_assoc()) {
    $data["kategori"][] = $k;
}

echo json_encode($data);
?>