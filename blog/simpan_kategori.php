<?php
require 'koneksi.php';
header('Content-Type: application/json');

$nama_kategori = trim($_POST['nama_kategori'] ?? '');
$keterangan    = trim($_POST['keterangan']    ?? '');

if (!$nama_kategori) {
    echo json_encode(['success' => false, 'message' => 'Nama kategori wajib diisi']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES (?, ?)");
$stmt->bind_param('ss', $nama_kategori, $keterangan);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Kategori berhasil ditambahkan']);
} else {
    $errMsg = ($conn->errno === 1062)
        ? 'Nama kategori sudah ada'
        : 'Gagal menyimpan data';
    echo json_encode(['success' => false, 'message' => $errMsg]);
}

$stmt->close();
$conn->close();
