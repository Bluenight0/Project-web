<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="shortcut icon" href="../assets/favicon_io/favicon.ico" />
  <title>Koleksi Buku | Perpustakaan</title>

  <style>
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body class="bg-gradient-to-b from-gray-700 via-gray-600 to-gray-500 min-h-screen text-white font-sans">

  <?php include '../layout/header_user.html'; ?>

  <main class="pt-28 px-6 max-w-7xl mx-auto space-y-6">

    <!-- Judul + subtext -->
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
      <h1 class="text-3xl sm:text-4xl font-bold drop-shadow-lg flex items-center gap-3">
        <!-- Ikon buku elegan -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-300" fill="none" viewBox="0 0 24 24"
          stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 5a2 2 0 012-2h11a4 4 0 014 4v12a1 1 0 01-1 1H7a4 4 0 01-4-4V5z" />
        </svg>
        Koleksi Buku Perpustakaan
      </h1>

      <p class="text-sm text-gray-200/80 max-w-md">
        Jelajahi koleksi buku perpustakaan. Pilih kategori, lihat detail, dan rencanakan bacaanmu dengan nyaman.
      </p>
    </div>

    <!-- Toolbar: search + filter -->
    <section
      class="bg-gray-800/40 backdrop-blur-lg border border-white/10 rounded-2xl px-4 py-3 sm:px-5 sm:py-4 shadow-lg flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
      <div class="flex items-center gap-2 w-full sm:w-1/2">
        <input id="searchInput" type="text" placeholder="Cari judul buku..."
          class="w-full px-4 py-2 rounded-xl bg-white/10 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm" />
      </div>

      <div class="flex flex-wrap gap-2 text-sm">
        <button data-filter="all"
          class="filter-pill px-3 py-1 rounded-full bg-blue-500/80 hover:bg-blue-500 shadow text-white">
          Semua
        </button>

        <button data-filter="Novel"
          class="filter-pill px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 border border-white/10">
          Novel
        </button>

        <button data-filter="Komik"
          class="filter-pill px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 border border-white/10">
          Komik
        </button>

        <button data-filter="Makalah"
          class="filter-pill px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 border border-white/10">
          Makalah
        </button>

        <button data-filter="Sejarah"
          class="filter-pill px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 border border-white/10">
          Sejarah
        </button>

        <button data-filter="Filosofi"
          class="filter-pill px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 border border-white/10">
          Filosofi
        </button>
      </div>

    </section>

    <!-- Statistik kecil -->
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div
        class="bg-gray-700/50 backdrop-blur-lg border border-white/10 rounded-2xl px-4 py-3 shadow-md flex flex-col gap-1">
        <span class="text-xs text-gray-300/80">Total Buku</span>
        <span id="statTotal" class="text-2xl font-semibold text-blue-300">0</span>
      </div>
      <div
        class="bg-gray-700/50 backdrop-blur-lg border border-white/10 rounded-2xl px-4 py-3 shadow-md flex flex-col gap-1">
        <span class="text-xs text-gray-300/80">Tersedia</span>
        <span id="statAvailable" class="text-2xl font-semibold text-emerald-300">0</span>
      </div>

    </section>

    <!-- Grid Buku -->
    <section>
      <div id="bookGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-7"></div>
      <!-- Loading -->
      <p id="loading" class="text-center text-gray-300 mt-6 animate-pulse">
        Memuat data buku...
      </p>
    </section>

  </main>

  <!-- MODAL DETAIL BUKU -->
  <div id="detailModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-11/12 p-5 sm:p-6 border border-white/10 relative">

      <button id="closeModal"
        class="absolute top-3 right-3 text-gray-300 hover:text-white text-xl leading-none">&times;</button>

      <div class="flex flex-col sm:flex-row gap-4">
        <div class="sm:w-1/3">
          <img id="modalImage" src="../assets/default-book.jpg" alt="Cover Buku"
            class="w-full h-44 object-cover rounded-xl shadow-md">
        </div>

        <div class="sm:w-2/3 space-y-1">
          <h2 id="modalTitle" class="text-xl font-semibold text-white"></h2>
          <p id="modalCategory" class="text-sm text-blue-200"></p>
          <p id="modalDate" class="text-xs text-gray-300"></p>

          
          <div class="flex items-center gap-2 mt-2">
            <span id="modalStatusBadge"
              class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-green-600/90">
              Status
            </span>
          </div>
          <p id="modalDescription" class="text-sm text-gray-200/90 mt-3">
            Deskripsi singkat belum tersedia.
          </p>
        </div>
      </div>
      <div class="mt-4 flex justify-end">
      <button id="readNowBtn"
        class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-sm font-semibold shadow-md">
        Baca Sekarang
        </div>
        </button>
    


    </div>
  </div>


  <script src="../assets/data-buku-user.js"></script>


</body>

</html>