<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id          = isset($_POST['id'])          ? (int)$_POST['id']          : 0;
$id_penulis  = isset($_POST['id_penulis'])  ? (int)$_POST['id_penulis']  : 0;
$id_kategori = isset($_POST['id_kategori']) ? (int)$_POST['id_kategori'] : 0;
$judul       = trim($_POST['judul'] ?? '');
$isi         = trim($_POST['isi']   ?? '');

if ($id <= 0 || !$judul || !$isi || $id_penulis <= 0 || $id_kategori <= 0) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

// Ambil data lama
$stmtOld = $conn->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmtOld->bind_param('i', $id);
$stmtOld->execute();
$old = $stmtOld->get_result()->fetch_assoc();
$stmtOld->close();

if (!$old) {
    echo json_encode(['success' => false, 'message' => 'Artikel tidak ditemukan']);
    exit;
}

$gambar = $old['gambar'];

// Handle gambar baru jika diupload
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $finfo   = new finfo(FILEINFO_MIME_TYPE);
    $mime    = $finfo->file($_FILES['gambar']['tmp_name']);
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (!in_array($mime, $allowed)) {
        echo json_encode(['success' => false, 'message' => 'Tipe file tidak diizinkan']);
        exit;
    }

    if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
        echo json_encode(['success' => false, 'message' => 'Ukuran file maksimal 2 MB']);
        exit;
    }

    $ext    = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $gambar = uniqid('artikel_') . '.' . strtolower($ext);
    $target = __DIR__ . '/uploads_artikel/' . $gambar;

    if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan gambar']);
        exit;
    }

    // Hapus gambar lama
    if (file_exists(__DIR__ . '/uploads_artikel/' . $old['gambar'])) {
        unlink(__DIR__ . '/uploads_artikel/' . $old['gambar']);
    }
}

$stmt = $conn->prepare("UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?");
$stmt->bind_param('iisssi', $id_penulis, $id_kategori, $judul, $isi, $gambar, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Artikel berhasil diperbarui']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal memperbarui artikel: ' . $conn->error]);
}

$stmt->close();
$conn->close();
