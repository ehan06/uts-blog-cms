<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
    exit;
}

// Ambil nama gambar sebelum dihapus
$stmtGambar = $conn->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmtGambar->bind_param('i', $id);
$stmtGambar->execute();
$row = $stmtGambar->get_result()->fetch_assoc();
$stmtGambar->close();

if (!$row) {
    echo json_encode(['success' => false, 'message' => 'Artikel tidak ditemukan']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM artikel WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Hapus file gambar dari server
    $filePath = __DIR__ . '/uploads_artikel/' . $row['gambar'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
    echo json_encode(['success' => true, 'message' => 'Artikel berhasil dihapus']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus artikel']);
}

$stmt->close();
$conn->close();
