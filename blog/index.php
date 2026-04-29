<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Manajemen Blog</title>
<style>
  /* ===== RESET & BASE ===== */
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --primary: #1a56db;
    --primary-dark: #1342b0;
    --primary-light: #e8f0fe;
    --danger: #e02424;
    --danger-light: #fde8e8;
    --success: #057a55;
    --success-light: #def7ec;
    --warning: #c27803;
    --warning-light: #fdf6b2;
    --bg: #f3f4f6;
    --card: #ffffff;
    --border: #e5e7eb;
    --text: #111827;
    --text-muted: #6b7280;
    --sidebar-bg: #1e2a3a;
    --sidebar-text: #cbd5e1;
    --sidebar-active: #1a56db;
    --header-bg: #1a56db;
    --radius: 10px;
    --shadow: 0 2px 8px rgba(0,0,0,0.08);
    --shadow-lg: 0 8px 30px rgba(0,0,0,0.15);
  }

  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }

  /* ===== HEADER ===== */
  header {
    background: var(--header-bg);
    color: #fff;
    padding: 0 24px;
    height: 60px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 2px 8px rgba(26,86,219,0.3);
    position: sticky;
    top: 0;
    z-index: 100;
  }
  header .logo-icon {
    width: 36px; height: 36px;
    background: rgba(255,255,255,0.2);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
  }
  header h1 { font-size: 1.2rem; font-weight: 700; letter-spacing: 0.02em; }
  header span { font-size: 0.8rem; opacity: 0.75; margin-left: auto; }

  /* ===== LAYOUT ===== */
  .app-body { display: flex; flex: 1; min-height: 0; }

  /* ===== SIDEBAR ===== */
  aside {
    width: 220px;
    background: var(--sidebar-bg);
    padding: 20px 0;
    flex-shrink: 0;
    min-height: calc(100vh - 60px);
  }
  aside .nav-label {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #4b6080;
    padding: 0 20px 8px;
  }
  aside nav a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 20px;
    color: var(--sidebar-text);
    text-decoration: none;
    font-size: 0.92rem;
    transition: all 0.2s;
    border-left: 3px solid transparent;
  }
  aside nav a:hover { background: rgba(255,255,255,0.06); color: #fff; }
  aside nav a.active {
    background: rgba(26,86,219,0.2);
    color: #fff;
    border-left-color: var(--primary);
    font-weight: 600;
  }
  aside nav a .nav-icon { font-size: 1.1rem; width: 20px; text-align: center; }

  /* ===== MAIN CONTENT ===== */
  main {
    flex: 1;
    padding: 28px;
    overflow-y: auto;
    min-width: 0;
  }

  /* ===== PAGE SECTION ===== */
  .page-section { display: none; }
  .page-section.active { display: block; }

  .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
  }
  .section-header h2 {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text);
  }
  .section-header p { font-size: 0.85rem; color: var(--text-muted); margin-top: 2px; }

  /* ===== BUTTONS ===== */
  .btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 16px;
    border: none; border-radius: 7px;
    font-size: 0.875rem; font-weight: 500;
    cursor: pointer; transition: all 0.2s;
    text-decoration: none;
  }
  .btn-primary { background: var(--primary); color: #fff; }
  .btn-primary:hover { background: var(--primary-dark); }
  .btn-danger  { background: var(--danger);  color: #fff; }
  .btn-danger:hover  { background: #b91c1c; }
  .btn-warning { background: #f59e0b; color: #fff; }
  .btn-warning:hover { background: #d97706; }
  .btn-secondary { background: #e5e7eb; color: var(--text); }
  .btn-secondary:hover { background: #d1d5db; }
  .btn-sm { padding: 5px 10px; font-size: 0.8rem; }

  /* ===== TABLE ===== */
  .table-card {
    background: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
  }
  thead th {
    background: #f8fafc;
    padding: 12px 16px;
    text-align: left;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-muted);
    border-bottom: 1px solid var(--border);
  }
  tbody td {
    padding: 13px 16px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
  }
  tbody tr:last-child td { border-bottom: none; }
  tbody tr:hover { background: #f9fafb; }

  .foto-thumb {
    width: 44px; height: 44px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid var(--border);
  }
  .artikel-thumb {
    width: 60px; height: 44px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid var(--border);
  }
  .badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    background: var(--primary-light);
    color: var(--primary);
  }
  .password-mask { font-family: monospace; letter-spacing: 2px; color: var(--text-muted); }
  .actions { display: flex; gap: 6px; }

  /* ===== EMPTY STATE ===== */
  .empty-state {
    text-align: center;
    padding: 50px 20px;
    color: var(--text-muted);
  }
  .empty-state .empty-icon { font-size: 3rem; margin-bottom: 12px; }
  .empty-state p { font-size: 0.95rem; }

  /* ===== MODAL ===== */
  .modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(3px);
    z-index: 999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }
  .modal-overlay.show { display: flex; }

  .modal {
    background: var(--card);
    border-radius: 14px;
    box-shadow: var(--shadow-lg);
    width: 100%;
    max-width: 520px;
    max-height: 90vh;
    overflow-y: auto;
    animation: modalIn 0.25s ease;
  }
  @keyframes modalIn {
    from { transform: scale(0.93) translateY(-10px); opacity: 0; }
    to   { transform: scale(1) translateY(0);        opacity: 1; }
  }
  .modal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 22px;
    border-bottom: 1px solid var(--border);
  }
  .modal-header h3 { font-size: 1.05rem; font-weight: 700; }
  .modal-close {
    width: 30px; height: 30px;
    border: none; background: var(--bg); border-radius: 6px;
    cursor: pointer; font-size: 1.1rem;
    display: flex; align-items: center; justify-content: center;
    color: var(--text-muted); transition: all 0.2s;
  }
  .modal-close:hover { background: var(--border); color: var(--text); }
  .modal-body { padding: 22px; }
  .modal-footer {
    padding: 16px 22px;
    border-top: 1px solid var(--border);
    display: flex; justify-content: flex-end; gap: 10px;
  }

  /* ===== FORM ===== */
  .form-group { margin-bottom: 16px; }
  .form-group label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 6px;
    color: var(--text);
  }
  .form-group label .required { color: var(--danger); margin-left: 2px; }
  .form-control {
    width: 100%;
    padding: 9px 12px;
    border: 1.5px solid var(--border);
    border-radius: 7px;
    font-size: 0.9rem;
    font-family: inherit;
    color: var(--text);
    background: #fff;
    transition: border-color 0.2s;
    outline: none;
  }
  .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(26,86,219,0.1); }
  textarea.form-control { resize: vertical; min-height: 90px; }
  select.form-control { cursor: pointer; }
  .form-hint { font-size: 0.78rem; color: var(--text-muted); margin-top: 4px; }

  .preview-foto {
    width: 80px; height: 80px;
    object-fit: cover; border-radius: 50%;
    border: 2px solid var(--border);
    margin-bottom: 8px;
    display: block;
  }
  .preview-gambar {
    width: 120px; height: 80px;
    object-fit: cover; border-radius: 7px;
    border: 2px solid var(--border);
    margin-bottom: 8px;
    display: block;
  }

  /* ===== CONFIRM MODAL ===== */
  .confirm-modal { max-width: 420px; }
  .confirm-icon {
    width: 56px; height: 56px;
    border-radius: 50%;
    background: var(--danger-light);
    color: var(--danger);
    font-size: 1.6rem;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
  }
  .confirm-body { text-align: center; padding: 24px 22px; }
  .confirm-body h3 { font-size: 1.1rem; margin-bottom: 8px; }
  .confirm-body p { font-size: 0.9rem; color: var(--text-muted); }

  /* ===== TOAST ===== */
  #toast-container {
    position: fixed; top: 20px; right: 20px;
    z-index: 9999;
    display: flex; flex-direction: column; gap: 8px;
  }
  .toast {
    padding: 12px 18px;
    border-radius: 8px;
    font-size: 0.88rem;
    font-weight: 500;
    color: #fff;
    box-shadow: var(--shadow-lg);
    animation: toastIn 0.3s ease;
    display: flex; align-items: center; gap: 8px;
    min-width: 260px; max-width: 380px;
  }
  .toast.success { background: var(--success); }
  .toast.error   { background: var(--danger);  }
  .toast.warning { background: var(--warning); }
  @keyframes toastIn {
    from { transform: translateX(40px); opacity: 0; }
    to   { transform: translateX(0);    opacity: 1; }
  }

  /* ===== LOADING ===== */
  .loading-row td {
    text-align: center;
    padding: 40px;
    color: var(--text-muted);
  }
  .spinner {
    display: inline-block;
    width: 20px; height: 20px;
    border: 2.5px solid var(--border);
    border-top-color: var(--primary);
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
    vertical-align: middle;
    margin-right: 8px;
  }
  @keyframes spin { to { transform: rotate(360deg); } }
</style>
</head>
<body>

<!-- HEADER -->
<header>
  <div class="logo-icon">✍️</div>
  <h1>Sistem Manajemen Blog</h1>
  <span>CMS &mdash; Pemrograman Web</span>
</header>

<div class="app-body">

  <!-- SIDEBAR -->
  <aside>
    <div class="nav-label">Menu</div>
    <nav>
      <a href="#" class="active" data-section="penulis">
        <span class="nav-icon">👤</span> Kelola Penulis
      </a>
      <a href="#" data-section="artikel">
        <span class="nav-icon">📄</span> Kelola Artikel
      </a>
      <a href="#" data-section="kategori">
        <span class="nav-icon">🏷️</span> Kelola Kategori
      </a>
    </nav>
  </aside>

  <!-- MAIN -->
  <main>

    <!-- ========== KELOLA PENULIS ========== -->
    <section class="page-section active" id="section-penulis">
      <div class="section-header">
        <div>
          <h2>Kelola Penulis</h2>
          <p>Manajemen data penulis blog</p>
        </div>
        <button class="btn btn-primary" onclick="openModalTambahPenulis()">
          ➕ Tambah Penulis
        </button>
      </div>
      <div class="table-card">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Foto</th>
              <th>Nama</th>
              <th>Username</th>
              <th>Password</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tbody-penulis">
            <tr class="loading-row">
              <td colspan="6"><span class="spinner"></span> Memuat data...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- ========== KELOLA ARTIKEL ========== -->
    <section class="page-section" id="section-artikel">
      <div class="section-header">
        <div>
          <h2>Kelola Artikel</h2>
          <p>Manajemen data artikel blog</p>
        </div>
        <button class="btn btn-primary" onclick="openModalTambahArtikel()">
          ➕ Tambah Artikel
        </button>
      </div>
      <div class="table-card">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Gambar</th>
              <th>Judul</th>
              <th>Kategori</th>
              <th>Penulis</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tbody-artikel">
            <tr class="loading-row">
              <td colspan="7"><span class="spinner"></span> Memuat data...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- ========== KELOLA KATEGORI ========== -->
    <section class="page-section" id="section-kategori">
      <div class="section-header">
        <div>
          <h2>Kelola Kategori Artikel</h2>
          <p>Manajemen kategori artikel blog</p>
        </div>
        <button class="btn btn-primary" onclick="openModalTambahKategori()">
          ➕ Tambah Kategori
        </button>
      </div>
      <div class="table-card">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Kategori</th>
              <th>Keterangan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tbody-kategori">
            <tr class="loading-row">
              <td colspan="4"><span class="spinner"></span> Memuat data...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

  </main>
</div>

<!-- =================== MODAL PENULIS =================== -->
<div class="modal-overlay" id="modal-penulis">
  <div class="modal">
    <div class="modal-header">
      <h3 id="modal-penulis-title">Tambah Penulis</h3>
      <button class="modal-close" onclick="closeModal('modal-penulis')">✕</button>
    </div>
    <div class="modal-body">
      <form id="form-penulis" enctype="multipart/form-data">
        <input type="hidden" id="penulis-id" name="id">

        <div class="form-group">
          <label>Foto Profil</label>
          <img id="preview-foto-penulis" src="uploads_penulis/default.png"
               class="preview-foto" alt="Preview" onerror="this.src='uploads_penulis/default.png'">
          <input type="file" class="form-control" id="penulis-foto" name="foto"
                 accept="image/jpeg,image/png,image/gif,image/webp"
                 onchange="previewImage(this,'preview-foto-penulis')">
          <div class="form-hint">Maks. 2MB. Format: JPG, PNG, GIF, WEBP. Kosongkan jika tidak diubah.</div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
          <div class="form-group">
            <label>Nama Depan <span class="required">*</span></label>
            <input type="text" class="form-control" id="penulis-nama-depan" name="nama_depan" required>
          </div>
          <div class="form-group">
            <label>Nama Belakang <span class="required">*</span></label>
            <input type="text" class="form-control" id="penulis-nama-belakang" name="nama_belakang" required>
          </div>
        </div>

        <div class="form-group">
          <label>Username <span class="required">*</span></label>
          <input type="text" class="form-control" id="penulis-username" name="user_name" required>
        </div>

        <div class="form-group">
          <label>Password <span class="required" id="password-required">*</span></label>
          <input type="password" class="form-control" id="penulis-password" name="password">
          <div class="form-hint" id="password-hint">Minimal 6 karakter.</div>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeModal('modal-penulis')">Batal</button>
      <button class="btn btn-primary" onclick="submitPenulis()">💾 Simpan</button>
    </div>
  </div>
</div>

<!-- =================== MODAL ARTIKEL =================== -->
<div class="modal-overlay" id="modal-artikel">
  <div class="modal" style="max-width:580px">
    <div class="modal-header">
      <h3 id="modal-artikel-title">Tambah Artikel</h3>
      <button class="modal-close" onclick="closeModal('modal-artikel')">✕</button>
    </div>
    <div class="modal-body">
      <form id="form-artikel" enctype="multipart/form-data">
        <input type="hidden" id="artikel-id" name="id">

        <div class="form-group">
          <label>Gambar Artikel <span class="required" id="gambar-required">*</span></label>
          <img id="preview-gambar-artikel" src="" class="preview-gambar" alt="Preview"
               style="display:none">
          <input type="file" class="form-control" id="artikel-gambar" name="gambar"
                 accept="image/jpeg,image/png,image/gif,image/webp"
                 onchange="previewImageArtikel(this)">
          <div class="form-hint">Maks. 2MB. Format: JPG, PNG, GIF, WEBP.</div>
        </div>

        <div class="form-group">
          <label>Judul Artikel <span class="required">*</span></label>
          <input type="text" class="form-control" id="artikel-judul" name="judul" required>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
          <div class="form-group">
            <label>Penulis <span class="required">*</span></label>
            <select class="form-control" id="artikel-penulis" name="id_penulis" required>
              <option value="">-- Pilih Penulis --</option>
            </select>
          </div>
          <div class="form-group">
            <label>Kategori <span class="required">*</span></label>
            <select class="form-control" id="artikel-kategori" name="id_kategori" required>
              <option value="">-- Pilih Kategori --</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Isi Artikel <span class="required">*</span></label>
          <textarea class="form-control" id="artikel-isi" name="isi" rows="5" required></textarea>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeModal('modal-artikel')">Batal</button>
      <button class="btn btn-primary" onclick="submitArtikel()">💾 Simpan</button>
    </div>
  </div>
</div>

<!-- =================== MODAL KATEGORI =================== -->
<div class="modal-overlay" id="modal-kategori">
  <div class="modal">
    <div class="modal-header">
      <h3 id="modal-kategori-title">Tambah Kategori</h3>
      <button class="modal-close" onclick="closeModal('modal-kategori')">✕</button>
    </div>
    <div class="modal-body">
      <form id="form-kategori">
        <input type="hidden" id="kategori-id" name="id">
        <div class="form-group">
          <label>Nama Kategori <span class="required">*</span></label>
          <input type="text" class="form-control" id="kategori-nama" name="nama_kategori" required>
        </div>
        <div class="form-group">
          <label>Keterangan</label>
          <textarea class="form-control" id="kategori-keterangan" name="keterangan" rows="3"></textarea>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeModal('modal-kategori')">Batal</button>
      <button class="btn btn-primary" onclick="submitKategori()">💾 Simpan</button>
    </div>
  </div>
</div>

<!-- =================== MODAL KONFIRMASI HAPUS =================== -->
<div class="modal-overlay" id="modal-konfirmasi">
  <div class="modal confirm-modal">
    <div class="confirm-body">
      <div class="confirm-icon">🗑️</div>
      <h3>Konfirmasi Hapus</h3>
      <p id="konfirmasi-text">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
    </div>
    <div class="modal-footer" style="justify-content:center; gap:12px">
      <button class="btn btn-secondary" onclick="closeModal('modal-konfirmasi')">Batal</button>
      <button class="btn btn-danger" id="btn-konfirmasi-hapus">🗑️ Ya, Hapus</button>
    </div>
  </div>
</div>

<!-- TOAST CONTAINER -->
<div id="toast-container"></div>

<script>
// ===========================
//  NAVIGASI
// ===========================
document.querySelectorAll('aside nav a').forEach(link => {
  link.addEventListener('click', function(e) {
    e.preventDefault();
    const section = this.dataset.section;

    document.querySelectorAll('aside nav a').forEach(a => a.classList.remove('active'));
    this.classList.add('active');

    document.querySelectorAll('.page-section').forEach(s => s.classList.remove('active'));
    document.getElementById('section-' + section).classList.add('active');

    // Load data saat pertama diklik
    if (section === 'penulis')  loadPenulis();
    if (section === 'artikel')  loadArtikel();
    if (section === 'kategori') loadKategori();
  });
});

// ===========================
//  UTILS
// ===========================
function esc(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

function showToast(msg, type = 'success') {
  const icons = { success: '✅', error: '❌', warning: '⚠️' };
  const div = document.createElement('div');
  div.className = 'toast ' + type;
  div.innerHTML = `<span>${icons[type] || '✅'}</span> ${esc(msg)}`;
  document.getElementById('toast-container').appendChild(div);
  setTimeout(() => div.remove(), 3500);
}

function openModal(id)  { document.getElementById(id).classList.add('show'); }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }

// Tutup modal saat klik overlay
document.querySelectorAll('.modal-overlay').forEach(ov => {
  ov.addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('show');
  });
});

function previewImage(input, imgId) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      document.getElementById(imgId).src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function previewImageArtikel(input) {
  const preview = document.getElementById('preview-gambar-artikel');
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      preview.src = e.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  }
}

// ===========================
//  PENULIS
// ===========================
function loadPenulis() {
  const tbody = document.getElementById('tbody-penulis');
  tbody.innerHTML = '<tr class="loading-row"><td colspan="6"><span class="spinner"></span> Memuat data...</td></tr>';
  fetch('ambil_penulis.php')
    .then(r => r.json())
    .then(res => {
      if (!res.success || res.data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6"><div class="empty-state"><div class="empty-icon">👤</div><p>Belum ada data penulis</p></div></td></tr>`;
        return;
      }
      tbody.innerHTML = res.data.map((p, i) => `
        <tr>
          <td>${i + 1}</td>
          <td><img src="uploads_penulis/${esc(p.foto)}" class="foto-thumb" alt="${esc(p.nama_depan)}"
               onerror="this.src='uploads_penulis/default.png'"></td>
          <td>${esc(p.nama_depan)} ${esc(p.nama_belakang)}</td>
          <td>${esc(p.user_name)}</td>
          <td><span class="password-mask">••••••••</span></td>
          <td>
            <div class="actions">
              <button class="btn btn-warning btn-sm" onclick="openEditPenulis(${p.id})">✏️ Edit</button>
              <button class="btn btn-danger btn-sm" onclick="konfirmasiHapusPenulis(${p.id}, '${esc(p.nama_depan)} ${esc(p.nama_belakang)}')">🗑️ Hapus</button>
            </div>
          </td>
        </tr>
      `).join('');
    })
    .catch(() => showToast('Gagal memuat data penulis', 'error'));
}

function openModalTambahPenulis() {
  document.getElementById('modal-penulis-title').textContent = 'Tambah Penulis';
  document.getElementById('form-penulis').reset();
  document.getElementById('penulis-id').value = '';
  document.getElementById('preview-foto-penulis').src = 'uploads_penulis/default.png';
  document.getElementById('password-required').style.display = 'inline';
  document.getElementById('password-hint').textContent = 'Minimal 6 karakter.';
  document.getElementById('penulis-password').required = true;
  openModal('modal-penulis');
}

function openEditPenulis(id) {
  fetch('ambil_satu_penulis.php?id=' + id)
    .then(r => r.json())
    .then(res => {
      if (!res.success) { showToast(res.message, 'error'); return; }
      const p = res.data;
      document.getElementById('modal-penulis-title').textContent = 'Edit Penulis';
      document.getElementById('penulis-id').value          = p.id;
      document.getElementById('penulis-nama-depan').value  = p.nama_depan;
      document.getElementById('penulis-nama-belakang').value = p.nama_belakang;
      document.getElementById('penulis-username').value    = p.user_name;
      document.getElementById('penulis-password').value    = '';
      document.getElementById('preview-foto-penulis').src  = 'uploads_penulis/' + p.foto;
      document.getElementById('password-required').style.display = 'none';
      document.getElementById('password-hint').textContent = 'Kosongkan jika tidak ingin mengubah password.';
      document.getElementById('penulis-password').required = false;
      openModal('modal-penulis');
    })
    .catch(() => showToast('Gagal mengambil data', 'error'));
}

function submitPenulis() {
  const id    = document.getElementById('penulis-id').value;
  const isEdit = !!id;
  const url   = isEdit ? 'update_penulis.php' : 'simpan_penulis.php';
  const formData = new FormData(document.getElementById('form-penulis'));

  fetch(url, { method: 'POST', body: formData })
    .then(r => r.json())
    .then(res => {
      if (res.success) {
        showToast(res.message, 'success');
        closeModal('modal-penulis');
        loadPenulis();
      } else {
        showToast(res.message, 'error');
      }
    })
    .catch(() => showToast('Terjadi kesalahan', 'error'));
}

function konfirmasiHapusPenulis(id, nama) {
  document.getElementById('konfirmasi-text').textContent =
    `Hapus penulis "${nama}"? Tindakan ini tidak dapat dibatalkan.`;
  const btn = document.getElementById('btn-konfirmasi-hapus');
  btn.onclick = function() {
    const fd = new FormData();
    fd.append('id', id);
    fetch('hapus_penulis.php', { method: 'POST', body: fd })
      .then(r => r.json())
      .then(res => {
        closeModal('modal-konfirmasi');
        showToast(res.message, res.success ? 'success' : 'error');
        if (res.success) loadPenulis();
      })
      .catch(() => showToast('Terjadi kesalahan', 'error'));
  };
  openModal('modal-konfirmasi');
}

// ===========================
//  ARTIKEL
// ===========================
function loadArtikel() {
  const tbody = document.getElementById('tbody-artikel');
  tbody.innerHTML = '<tr class="loading-row"><td colspan="7"><span class="spinner"></span> Memuat data...</td></tr>';
  fetch('ambil_artikel.php')
    .then(r => r.json())
    .then(res => {
      if (!res.success || res.data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7"><div class="empty-state"><div class="empty-icon">📄</div><p>Belum ada data artikel</p></div></td></tr>`;
        return;
      }
      tbody.innerHTML = res.data.map((a, i) => `
        <tr>
          <td>${i + 1}</td>
          <td><img src="uploads_artikel/${esc(a.gambar)}" class="artikel-thumb" alt="${esc(a.judul)}"
               onerror="this.src=''"></td>
          <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${esc(a.judul)}</td>
          <td><span class="badge">${esc(a.nama_kategori)}</span></td>
          <td>${esc(a.nama_depan)} ${esc(a.nama_belakang)}</td>
          <td style="font-size:0.8rem;color:var(--text-muted)">${esc(a.hari_tanggal)}</td>
          <td>
            <div class="actions">
              <button class="btn btn-warning btn-sm" onclick="openEditArtikel(${a.id})">✏️ Edit</button>
              <button class="btn btn-danger btn-sm" onclick="konfirmasiHapusArtikel(${a.id}, '${esc(a.judul)}')">🗑️ Hapus</button>
            </div>
          </td>
        </tr>
      `).join('');
    })
    .catch(() => showToast('Gagal memuat data artikel', 'error'));
}

function loadDropdownPenulisKategori(selectedPenulis = '', selectedKategori = '') {
  fetch('ambil_penulis.php')
    .then(r => r.json())
    .then(res => {
      const sel = document.getElementById('artikel-penulis');
      sel.innerHTML = '<option value="">-- Pilih Penulis --</option>' +
        (res.data || []).map(p =>
          `<option value="${p.id}" ${p.id == selectedPenulis ? 'selected' : ''}>
            ${esc(p.nama_depan)} ${esc(p.nama_belakang)}
           </option>`
        ).join('');
    });

  fetch('ambil_kategori.php')
    .then(r => r.json())
    .then(res => {
      const sel = document.getElementById('artikel-kategori');
      sel.innerHTML = '<option value="">-- Pilih Kategori --</option>' +
        (res.data || []).map(k =>
          `<option value="${k.id}" ${k.id == selectedKategori ? 'selected' : ''}>
            ${esc(k.nama_kategori)}
           </option>`
        ).join('');
    });
}

function openModalTambahArtikel() {
  document.getElementById('modal-artikel-title').textContent = 'Tambah Artikel';
  document.getElementById('form-artikel').reset();
  document.getElementById('artikel-id').value = '';
  document.getElementById('preview-gambar-artikel').style.display = 'none';
  document.getElementById('gambar-required').style.display = 'inline';
  document.getElementById('artikel-gambar').required = true;
  loadDropdownPenulisKategori();
  openModal('modal-artikel');
}

function openEditArtikel(id) {
  fetch('ambil_satu_artikel.php?id=' + id)
    .then(r => r.json())
    .then(res => {
      if (!res.success) { showToast(res.message, 'error'); return; }
      const a = res.data;
      document.getElementById('modal-artikel-title').textContent = 'Edit Artikel';
      document.getElementById('artikel-id').value    = a.id;
      document.getElementById('artikel-judul').value = a.judul;
      document.getElementById('artikel-isi').value   = a.isi;
      const preview = document.getElementById('preview-gambar-artikel');
      preview.src   = 'uploads_artikel/' + a.gambar;
      preview.style.display = 'block';
      document.getElementById('gambar-required').style.display = 'none';
      document.getElementById('artikel-gambar').required = false;
      loadDropdownPenulisKategori(a.id_penulis, a.id_kategori);
      openModal('modal-artikel');
    })
    .catch(() => showToast('Gagal mengambil data', 'error'));
}

function submitArtikel() {
  const id    = document.getElementById('artikel-id').value;
  const isEdit = !!id;
  const url   = isEdit ? 'update_artikel.php' : 'simpan_artikel.php';
  const formData = new FormData(document.getElementById('form-artikel'));

  fetch(url, { method: 'POST', body: formData })
    .then(r => r.json())
    .then(res => {
      if (res.success) {
        showToast(res.message, 'success');
        closeModal('modal-artikel');
        loadArtikel();
      } else {
        showToast(res.message, 'error');
      }
    })
    .catch(() => showToast('Terjadi kesalahan', 'error'));
}

function konfirmasiHapusArtikel(id, judul) {
  document.getElementById('konfirmasi-text').textContent =
    `Hapus artikel "${judul}"? Gambar juga akan dihapus dari server.`;
  const btn = document.getElementById('btn-konfirmasi-hapus');
  btn.onclick = function() {
    const fd = new FormData();
    fd.append('id', id);
    fetch('hapus_artikel.php', { method: 'POST', body: fd })
      .then(r => r.json())
      .then(res => {
        closeModal('modal-konfirmasi');
        showToast(res.message, res.success ? 'success' : 'error');
        if (res.success) loadArtikel();
      })
      .catch(() => showToast('Terjadi kesalahan', 'error'));
  };
  openModal('modal-konfirmasi');
}

// ===========================
//  KATEGORI
// ===========================
function loadKategori() {
  const tbody = document.getElementById('tbody-kategori');
  tbody.innerHTML = '<tr class="loading-row"><td colspan="4"><span class="spinner"></span> Memuat data...</td></tr>';
  fetch('ambil_kategori.php')
    .then(r => r.json())
    .then(res => {
      if (!res.success || res.data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="4"><div class="empty-state"><div class="empty-icon">🏷️</div><p>Belum ada data kategori</p></div></td></tr>`;
        return;
      }
      tbody.innerHTML = res.data.map((k, i) => `
        <tr>
          <td>${i + 1}</td>
          <td><strong>${esc(k.nama_kategori)}</strong></td>
          <td style="color:var(--text-muted)">${esc(k.keterangan) || '<em>-</em>'}</td>
          <td>
            <div class="actions">
              <button class="btn btn-warning btn-sm" onclick="openEditKategori(${k.id})">✏️ Edit</button>
              <button class="btn btn-danger btn-sm" onclick="konfirmasiHapusKategori(${k.id}, '${esc(k.nama_kategori)}')">🗑️ Hapus</button>
            </div>
          </td>
        </tr>
      `).join('');
    })
    .catch(() => showToast('Gagal memuat data kategori', 'error'));
}

function openModalTambahKategori() {
  document.getElementById('modal-kategori-title').textContent = 'Tambah Kategori';
  document.getElementById('form-kategori').reset();
  document.getElementById('kategori-id').value = '';
  openModal('modal-kategori');
}

function openEditKategori(id) {
  fetch('ambil_satu_kategori.php?id=' + id)
    .then(r => r.json())
    .then(res => {
      if (!res.success) { showToast(res.message, 'error'); return; }
      const k = res.data;
      document.getElementById('modal-kategori-title').textContent = 'Edit Kategori';
      document.getElementById('kategori-id').value          = k.id;
      document.getElementById('kategori-nama').value        = k.nama_kategori;
      document.getElementById('kategori-keterangan').value  = k.keterangan || '';
      openModal('modal-kategori');
    })
    .catch(() => showToast('Gagal mengambil data', 'error'));
}

function submitKategori() {
  const id    = document.getElementById('kategori-id').value;
  const isEdit = !!id;
  const url   = isEdit ? 'update_kategori.php' : 'simpan_kategori.php';
  const formData = new FormData(document.getElementById('form-kategori'));

  fetch(url, { method: 'POST', body: formData })
    .then(r => r.json())
    .then(res => {
      if (res.success) {
        showToast(res.message, 'success');
        closeModal('modal-kategori');
        loadKategori();
      } else {
        showToast(res.message, 'error');
      }
    })
    .catch(() => showToast('Terjadi kesalahan', 'error'));
}

function konfirmasiHapusKategori(id, nama) {
  document.getElementById('konfirmasi-text').textContent =
    `Hapus kategori "${nama}"? Tindakan ini tidak dapat dibatalkan.`;
  const btn = document.getElementById('btn-konfirmasi-hapus');
  btn.onclick = function() {
    const fd = new FormData();
    fd.append('id', id);
    fetch('hapus_kategori.php', { method: 'POST', body: fd })
      .then(r => r.json())
      .then(res => {
        closeModal('modal-konfirmasi');
        showToast(res.message, res.success ? 'success' : 'error');
        if (res.success) loadKategori();
      })
      .catch(() => showToast('Terjadi kesalahan', 'error'));
  };
  openModal('modal-konfirmasi');
}

// ===========================
//  INIT — load halaman awal
// ===========================
loadPenulis();
</script>
</body>
</html>
