<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
    exit;
}

// Cek apakah penulis masih punya artikel
$stmtCek = $conn->prepare("SELECT COUNT(*) AS jumlah FROM artikel WHERE id_penulis = ?");
$stmtCek->bind_param('i', $id);
$stmtCek->execute();
$cek = $stmtCek->get_result()->fetch_assoc();
$stmtCek->close();

if ($cek['jumlah'] > 0) {
    echo json_encode(['success' => false, 'message' => 'Penulis tidak dapat dihapus karena masih memiliki artikel']);
    exit;
}

// Ambil nama foto
$stmtFoto = $conn->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmtFoto->bind_param('i', $id);
$stmtFoto->execute();
$row = $stmtFoto->get_result()->fetch_assoc();
$stmtFoto->close();

if (!$row) {
    echo json_encode(['success' => false, 'message' => 'Penulis tidak ditemukan']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Hapus foto dari server jika bukan default
    if ($row['foto'] !== 'default.png' && file_exists(__DIR__ . '/uploads_penulis/' . $row['foto'])) {
        unlink(__DIR__ . '/uploads_penulis/' . $row['foto']);
    }
    echo json_encode(['success' => true, 'message' => 'Penulis berhasil dihapus']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus penulis']);
}

$stmt->close();
$conn->close();
