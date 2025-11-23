<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="shortcut icon" href="../assets/favicon_io/favicon.ico" />
  <title>Event | Perpustakaan</title>

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

<body class="min-h-screen bg-gradient-to-b from-gray-700 via-gray-650 to-gray-600 font-sans">

  <?php include '../layout/header_user.html'; ?>

  <main class="pt-28 px-6 sm:px-12 max-w-7xl mx-auto space-y-8">

    <!-- Judul -->
    <h1 class="text-3xl sm:text-4xl font-bold text-white drop-shadow-lg flex items-center gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-300" fill="none" viewBox="0 0 24 24"
        stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M8 7V3m8 4V3M3 11h18M3 21h18m-9-10v10" />
      </svg>
      Event Perpustakaan
    </h1>

    <!-- Statistik -->
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div class="bg-gray-700/50 backdrop-blur-lg border border-white/10 rounded-xl p-4 shadow flex flex-col">
        <span class="text-sm text-gray-300">Total Event</span>
        <span id="totalEvt" class="text-2xl font-bold text-white">0</span>
      </div>

      <div class="bg-gray-700/50 backdrop-blur-lg border border-white/10 rounded-xl p-4 shadow flex flex-col">
        <span class="text-sm text-gray-300">Akan Datang</span>
        <span id="upcomingEvt" class="text-2xl font-bold text-blue-300">0</span>
      </div>

      <div class="bg-gray-700/50 backdrop-blur-lg border border-white/10 rounded-xl p-4 shadow flex flex-col">
        <span class="text-sm text-gray-300">Sedang Berlangsung</span>
        <span id="activeEvt" class="text-2xl font-bold text-emerald-300">0</span>
      </div>
    </section>

    <!-- Daftar Event -->
    <div id="event-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"></div>

  </main>

  <!-- MODAL DETAIL EVENT -->
  <div id="eventModal"
    class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-gray-800 border border-white/10 rounded-2xl p-6 w-11/12 sm:w-[450px] shadow-xl relative">

      <button id="closeModal" class="absolute top-3 right-3 text-gray-300 hover:text-white text-xl">&times;</button>

      <h2 id="modalNama" class="text-2xl font-semibold text-white mb-2"></h2>
      <p id="modalTanggal" class="text-gray-300 mb-1"></p>
      <p id="modalLokasi" class="text-gray-300 mb-4"></p>

      <p class="text-sm text-gray-200/90">
        Tidak ada deskripsi tambahan dari backend, tetapi modal ini siap menampilkan informasi lebih detail bila senpai
        menambah kolom deskripsi di database.
      </p>

      <button id="modalIkut"
        class="mt-5 w-full bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl shadow font-semibold">Ikuti Event</button>

    </div>
  </div>
  <script src="../assets/event-user.js"></script>
 
</body>

</html>
