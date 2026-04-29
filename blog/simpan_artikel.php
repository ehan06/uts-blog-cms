<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id_penulis  = isset($_POST['id_penulis'])  ? (int)$_POST['id_penulis']  : 0;
$id_kategori = isset($_POST['id_kategori']) ? (int)$_POST['id_kategori'] : 0;
$judul       = trim($_POST['judul'] ?? '');
$isi         = trim($_POST['isi']   ?? '');

if (!$judul || !$isi || $id_penulis <= 0 || $id_kategori <= 0) {
    echo json_encode(['success' => false, 'message' => 'Semua field wajib diisi']);
    exit;
}

// Upload gambar wajib
if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Gambar artikel wajib diunggah']);
    exit;
}

$finfo   = new finfo(FILEINFO_MIME_TYPE);
$mime    = $finfo->file($_FILES['gambar']['tmp_name']);
$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

if (!in_array($mime, $allowed)) {
    echo json_encode(['success' => false, 'message' => 'Tipe file tidak diizinkan. Gunakan JPG, PNG, GIF, atau WEBP']);
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

// Generate hari_tanggal
date_default_timezone_set('Asia/Jakarta');
$hari   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulan  = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
           7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
$now    = new DateTime();
$nama_hari  = $hari[$now->format('w')];
$tanggal    = $now->format('j');
$nama_bulan = $bulan[(int)$now->format('n')];
$tahun      = $now->format('Y');
$jam        = $now->format('H:i');
$hari_tanggal = "$nama_hari, $tanggal $nama_bulan $tahun | $jam";

$stmt = $conn->prepare("INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param('iissss', $id_penulis, $id_kategori, $judul, $isi, $gambar, $hari_tanggal);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Artikel berhasil ditambahkan']);
} else {
    if (file_exists($target)) unlink($target);
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan artikel: ' . $conn->error]);
}

$stmt->close();
$conn->close();
