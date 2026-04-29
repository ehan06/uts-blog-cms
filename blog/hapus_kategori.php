<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
    exit;
}

// Cek apakah kategori masih punya artikel
$stmtCek = $conn->prepare("SELECT COUNT(*) AS jumlah FROM artikel WHERE id_kategori = ?");
$stmtCek->bind_param('i', $id);
$stmtCek->execute();
$cek = $stmtCek->get_result()->fetch_assoc();
$stmtCek->close();

if ($cek['jumlah'] > 0) {
    echo json_encode(['success' => false, 'message' => 'Kategori tidak dapat dihapus karena masih memiliki artikel']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM kategori_artikel WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Kategori berhasil dihapus']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus kategori']);
}

$stmt->close();
$conn->close();
