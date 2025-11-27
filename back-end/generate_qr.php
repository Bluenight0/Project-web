<?php
// back-end/generate_qr.php
header("Content-Type: text/html; charset=utf-8");

// sesuaikan path koneksi & qrlib
include "koneksi.php";

// path ke phpqrcode lib (ambil dari vendor / library yang kamu pakai).
// Contoh: project/library/phpqrcode/qrlib.php
$qrLibPath = __DIR__ . "/../library/phpqrcode/qrlib.php";
if (!file_exists($qrLibPath)) {
    echo "<h3>Library phpqrcode tidak ditemukan.</h3>";
    echo "<p>Pastikan file <code>library/phpqrcode/qrlib.php</code> ada.</p>";
    exit;
}
require_once $qrLibPath;

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "ID peminjaman tidak valid.";
    exit;
}

// ambil data peminjaman
$q = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id = $id LIMIT 1");
if (!$q || mysqli_num_rows($q) === 0) {
    echo "Data peminjaman tidak ditemukan.";
    exit;
}
$data = mysqli_fetch_assoc($q);

// bangun teks untuk QR
$text = "ID Peminjaman: " . ($data['id'] ?? '') . "\n";
$text .= "Nama Buku: " . ($data['nama_buku'] ?? '') . "\n";
$text .= "Peminjam: " . ($data['nama_peminjam'] ?? '') . "\n";
$text .= "Tanggal Pinjam: " . ($data['tgl_pinjam'] ?? '') . "\n";

// generate QR ke output buffer, lalu embed base64 ke halaman HTML
ob_start();
QRcode::png($text, null, QR_ECLEVEL_L, 4);
$imageString = ob_get_clean();
$base64 = base64_encode($imageString);

// tampilkan halaman sederhana
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>QR Peminjaman #<?= htmlspecialchars($data['id']) ?></title>
  <style>
    body { font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; background:#f3f4f6; color:#111827; display:flex; align-items:center; justify-content:center; height:100vh; margin:0; }
    .card { background:#111827; color:white; padding:20px; border-radius:12px; box-shadow:0 8px 30px rgba(2,6,23,0.6); text-align:center; width:320px; }
    img { width:220px; height:220px; display:block; margin:0 auto 12px; }
    small { color: #9ca3af; display:block; margin-top:8px; font-size:12px; }
  </style>
</head>
<body>
  <div class="card">
    <h2 style="margin:0 0 8px;font-size:18px">QR Peminjaman</h2>
    <img src="data:image/png;base64,<?= $base64 ?>" alt="QR Peminjaman" />
    <div style="text-align:left; font-size:13px; margin-top:8px">
      <strong>ID:</strong> <?= htmlspecialchars($data['id']) ?><br>
      <strong>Buku:</strong> <?= htmlspecialchars($data['nama_buku']) ?><br>
      <strong>Peminjam:</strong> <?= htmlspecialchars($data['nama_peminjam']) ?><br>
      <strong>Tgl:</strong> <?= htmlspecialchars($data['tgl_pinjam']) ?>
    </div>
    <small>Tunjukkan QR ini ke petugas perpustakaan untuk verifikasi.</small>
  </div>
</body>
</html>
