<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id            = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$nama_kategori = trim($_POST['nama_kategori'] ?? '');
$keterangan    = trim($_POST['keterangan']    ?? '');

if ($id <= 0 || !$nama_kategori) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

$stmt = $conn->prepare("UPDATE kategori_artikel SET nama_kategori=?, keterangan=? WHERE id=?");
$stmt->bind_param('ssi', $nama_kategori, $keterangan, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Kategori berhasil diperbarui']);
} else {
    $errMsg = ($conn->errno === 1062)
        ? 'Nama kategori sudah ada'
        : 'Gagal memperbarui data';
    echo json_encode(['success' => false, 'message' => $errMsg]);
}

$stmt->close();
$conn->close();
