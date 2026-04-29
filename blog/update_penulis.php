<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id            = isset($_POST['id'])            ? (int)trim($_POST['id'])            : 0;
$nama_depan    = trim($_POST['nama_depan']    ?? '');
$nama_belakang = trim($_POST['nama_belakang'] ?? '');
$user_name     = trim($_POST['user_name']     ?? '');
$password      = trim($_POST['password']      ?? '');

if ($id <= 0 || !$nama_depan || !$nama_belakang || !$user_name) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

// Ambil data lama
$stmtOld = $conn->prepare("SELECT foto, password FROM penulis WHERE id = ?");
$stmtOld->bind_param('i', $id);
$stmtOld->execute();
$old = $stmtOld->get_result()->fetch_assoc();
$stmtOld->close();

if (!$old) {
    echo json_encode(['success' => false, 'message' => 'Penulis tidak ditemukan']);
    exit;
}

$foto = $old['foto'];

// Handle foto baru jika diupload
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $finfo   = new finfo(FILEINFO_MIME_TYPE);
    $mime    = $finfo->file($_FILES['foto']['tmp_name']);
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (!in_array($mime, $allowed)) {
        echo json_encode(['success' => false, 'message' => 'Tipe file tidak diizinkan']);
        exit;
    }

    if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
        echo json_encode(['success' => false, 'message' => 'Ukuran file maksimal 2 MB']);
        exit;
    }

    $ext    = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto   = uniqid('penulis_') . '.' . strtolower($ext);
    $target = __DIR__ . '/uploads_penulis/' . $foto;

    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan foto']);
        exit;
    }

    // Hapus foto lama jika bukan default
    if ($old['foto'] !== 'default.png' && file_exists(__DIR__ . '/uploads_penulis/' . $old['foto'])) {
        unlink(__DIR__ . '/uploads_penulis/' . $old['foto']);
    }
}

// Password: update jika diisi, pakai lama jika kosong
if ($password !== '') {
    $hashed = password_hash($password, PASSWORD_BCRYPT);
} else {
    $hashed = $old['password'];
}

$stmt = $conn->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?");
$stmt->bind_param('sssssi', $nama_depan, $nama_belakang, $user_name, $hashed, $foto, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Penulis berhasil diperbarui']);
} else {
    $errMsg = ($conn->errno === 1062)
        ? 'Username sudah digunakan'
        : 'Gagal memperbarui data: ' . $conn->error;
    echo json_encode(['success' => false, 'message' => $errMsg]);
}

$stmt->close();
$conn->close();
