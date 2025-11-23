<?php
session_start();

// ambil identitas user dari session login (silakan sesuaikan nama key)
$namaUser = $_SESSION['nama_anggota'] ?? 'User';
$idUser   = $_SESSION['id_anggota'] ?? null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="shortcut icon" href="../assets/favicon_io/favicon.ico" />
  <title>Peminjaman Buku | Perpustakaan</title>

  <style>
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(10px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body class="bg-gradient-to-b from-gray-700 via-gray-650 to-gray-600 min-h-screen text-white font-sans">

  <?php include '../layout/header_user.html'; ?>

  <!-- expose user ke JS -->
  <script>
    window.CURRENT_USER_ID   = <?= json_encode($idUser) ?>;
    window.CURRENT_USER_NAME = <?= json_encode($namaUser) ?>;
  </script>

  <!-- MAIN CONTENT -->
  <main class="pt-28 px-6 sm:px-10 pb-16 max-w-7xl mx-auto">

    <!-- TITLE -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
      <h1 class="text-3xl sm:text-4xl font-bold drop-shadow-lg flex items-center gap-3">
        <!-- ikon buku elegan -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-300" fill="none"
             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 5a2 2 0 012-2h11a4 4 0 014 4v12a1 1 0 01-1 1H7a4 4 0 01-4-4V5z" />
        </svg>
        Peminjaman Buku
      </h1>

      <p class="text-sm text-gray-200/80">
        Halo, <span class="font-semibold text-blue-200"><?= htmlspecialchars($namaUser) ?></span> ✦
      </p>
    </div>

    <!-- WRAPPER GLASS -->
    <div class="bg-gray-700/40 backdrop-blur-lg border border-white/10 rounded-2xl shadow-2xl p-6 sm:p-8 space-y-8">

      <!-- BANNER SANKSI -->
      <div id="sanksiBanner"
           class="hidden bg-red-600/80 border border-red-300/70 backdrop-blur-md text-white text-center py-3 px-4 rounded-2xl font-semibold shadow-lg flex items-center justify-center gap-2">
        <span class="text-lg">⛔</span>
        <span>Kamu sedang dalam masa sanksi. Sisa hari: <span id="sisaHari" class="font-bold">3</span></span>
      </div>

      <!-- SEARCH + INFO -->
      <div class="flex flex-col md:flex-row gap-4 md:items-center md:justify-between">
        <div class="flex-1">
          <input
            id="searchInput"
            type="text"
            placeholder="Cari buku berdasarkan judul..."
            class="w-full px-4 py-3 rounded-xl bg-white/15 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-inner"
          />
        </div>

        <div class="text-xs sm:text-sm text-gray-200/80 bg-white/5 px-4 py-3 rounded-xl border border-white/10">
          <p>Aturan singkat:</p>
          <ul class="list-disc list-inside mt-1 space-y-0.5">
            <li>Masa pinjam buku: 3 hari.</li>
            <li>Keterlambatan akan memicu sanksi otomatis.</li>
            <li>Sanksi: tidak bisa meminjam selama 3 hari.</li>
          </ul>
        </div>
      </div>

      <!-- GRID BUKU -->
      <section>
        <h2 class="text-xl font-semibold mb-3 flex items-center gap-2">
          <span class="w-1.5 h-6 bg-blue-400 rounded-full"></span>
          Pilih Buku
        </h2>

        <div id="bookList" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          <!-- diisi via JS -->
        </div>

        <!-- Loading -->
        <p id="loadingBooks" class="text-center text-gray-300 mt-4 animate-pulse">
          Memuat daftar buku...
        </p>
      </section>

      <!-- STATUS PEMINJAMAN -->
      <section class="pt-4 border-t border-white/10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
          <h2 class="text-xl sm:text-2xl font-semibold drop-shadow-lg flex items-center gap-2">
            <span class="w-1.5 h-6 bg-emerald-400 rounded-full"></span>
            Status Peminjaman
          </h2>
          <p class="text-xs text-gray-300">
            Status real-time, termasuk keterlambatan & pengembalian.
          </p>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-white/10 bg-gray-700/40 backdrop-blur-md shadow-xl">
          <table class="min-w-full text-sm sm:text-base">
            <thead class="bg-white/10 text-gray-100">
              <tr>
                <th class="px-4 py-2 text-left">Judul</th>
                <th class="px-4 py-2 text-left">Tanggal Pinjam</th>
                <th class="px-4 py-2 text-left">Batas Waktu</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Aksi</th>
              </tr>
            </thead>
            <tbody id="loanTable" class="divide-y divide-white/5">
              <!-- isi via JS -->
            </tbody>
          </table>
        </div>
      </section>

    </div> <!-- /wrapper glass -->

  </main>

  <!-- MODAL DETAIL BUKU -->
  <div id="modalDetail"
       class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center px-4">
    <div class="bg-gray-800 text-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden border border-white/10">
      <div class="flex justify-between items-center px-5 py-3 bg-gray-900/80 border-b border-white/10">
        <h3 id="modalTitle" class="text-lg font-semibold">Detail Buku</h3>
        <button onclick="window.closeDetailModal()"
                class="text-gray-300 hover:text-white text-xl leading-none">&times;</button>
      </div>

      <div class="p-5 flex flex-col sm:flex-row gap-4">
        <div class="w-full sm:w-40 h-52 bg-gray-700 rounded-xl overflow-hidden flex-shrink-0">
          <img id="modalImage" src="" alt="Cover Buku" class="w-full h-full object-cover" />
        </div>
        <div class="flex-1 space-y-2 text-sm">
          <p><span class="font-semibold text-gray-100">Judul:</span>
            <span id="modalNama"></span>
          </p>
          <p><span class="font-semibold text-gray-100">Kategori:</span>
            <span id="modalJenis"></span>
          </p>
          <p><span class="font-semibold text-gray-100">Tanggal Input:</span>
            <span id="modalTanggal"></span>
          </p>
          <p><span class="font-semibold text-gray-100">Status:</span>
            <span id="modalStatus" class="font-semibold"></span>
          </p>
          <p class="mt-2 text-gray-200/85 text-xs leading-relaxed">
            <span class="font-semibold">Catatan:</span>
            <span id="modalDeskripsi">Belum ada catatan khusus untuk buku ini.</span>
          </p>
        </div>
      </div>

      <div class="px-5 pb-4 flex justify-end gap-3">
        <button onclick="window.closeDetailModal()"
                class="px-4 py-2 rounded-xl bg-gray-600 hover:bg-gray-700 text-sm">
          Tutup
        </button>
        <button id="modalPinjamBtn"
                class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-sm font-semibold">
          Pinjam Buku Ini
        </button>
      </div>
    </div>
  </div>

  <!-- JS PEMINJAMAN USER -->
  <script src="../assets/peminjaman-user.js"></script>
</body>
</html>
