<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Dashboard Admin</title>
  </head>

  <body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-950 to-sky-900 text-white overflow-x-hidden">

    <?php include '../layout/header_admin.html'; ?>

    <!-- HERO / BANNER ATAS -->
    <main class="pt-24">
      <div class="relative w-full h-[260px] sm:h-[320px] md:h-[360px] overflow-hidden rounded-b-3xl shadow-2xl">
        <img
          src="../assets/libarry.jpg"
          alt="Library"
          class="w-full h-full object-cover scale-110 origin-center"
        />
        <!-- Overlay gelap -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent"></div>

        <!-- Teks di atas gambar -->
        <div class="absolute left-6 sm:left-12 top-1/3 space-y-2 drop-shadow-lg">
          <p class="text-xs uppercase tracking-[0.2em] text-sky-300/90">
            admin panel
          </p>
          <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight">
            Library<span class="text-sky-300">.esk</span>
          </h1>
          <p class="mt-1 text-sm md:text-base text-slate-100/80">
            Open today <span class="font-semibold text-sky-200">09:00 – 21:00</span>
          </p>
        </div>
      </div>
    </main>

    <!-- SECTION KONTEN -->
    <section class="w-full mt-6 px-4 sm:px-6 pb-10">
      <div
        class="flex flex-col lg:flex-row justify-center items-start gap-8 max-w-6xl mx-auto"
      >
        <!-- KALENDER (GLASS CARD) -->
        <div
          class="w-full sm:w-[320px] md:w-[360px]
                 bg-white/10 border border-white/20 backdrop-blur-xl
                 rounded-3xl shadow-[0_20px_60px_rgba(15,23,42,0.7)]
                 flex flex-col items-center p-4"
        >
          <p
            id="bulanSekarang"
            class="w-full text-center py-2 rounded-2xl
                   font-semibold tracking-wide
                   bg-gradient-to-r from-sky-400/80 to-cyan-300/80
                   text-slate-900 shadow-md"
          ></p>

          <div
            id="tanggal"
            class="mt-4 grid grid-cols-7 gap-1.5 text-center text-sm text-slate-100 w-full"
          ></div>
        </div>

        <!-- CARD KETERANGAN (GLASS SECTION) -->
        <div class="flex-1 space-y-4">
          <!-- Info atas -->
          <div
            class="bg-white/10 border border-white/15 backdrop-blur-xl
                   rounded-3xl shadow-[0_20px_60px_rgba(15,23,42,0.7)]
                   p-4 sm:p-5"
          >
            <h2 class="text-lg font-semibold mb-2 flex items-center gap-2">
              <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
              Status Sistem
            </h2>
            <p class="text-sm sm:text-base text-slate-100/80">
              Pantau aktivitas perpustakaan dengan lebih mudah.
              Di panel ini admin bisa mengelola buku, event, dan peminjaman
              dengan cepat tanpa meninggalkan halaman utama.
            </p>
          </div>

          <!-- Dua card kecil -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div
              class="bg-white/10 border border-white/15 backdrop-blur-xl
                     rounded-3xl shadow-[0_18px_50px_rgba(15,23,42,0.65)]
                     p-4"
            >
              <h3 class="font-semibold mb-1">Ringkasan Hari Ini</h3>
              <p class="text-sm text-slate-100/80">
                Cek jumlah peminjaman aktif, buku yang akan jatuh tempo,
                dan event yang sedang berjalan.
              </p>
            </div>
            <div
              class="bg-gradient-to-br from-amber-300/90 via-amber-400/90 to-amber-500/90
                     text-slate-900 rounded-3xl shadow-[0_18px_50px_rgba(251,191,36,0.6)]
                     p-4"
            >
              <h3 class="font-semibold mb-1">Catatan Admin</h3>
              <p class="text-sm">
                Gunakan menu <span class="font-semibold">Status Buku</span> untuk
                melihat keterlambatan, dan <span class="font-semibold">Data Events</span>
                untuk mengatur kegiatan literasi.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FOOTER -->
    <footer
      class="border-t border-white/10 bg-black/30 backdrop-blur-xl
             py-3 px-4 flex flex-wrap items-center justify-center gap-3 text-xs sm:text-sm text-slate-200"
    >
      <span class="font-semibold tracking-wide">Library.esk</span>
      <span class="w-px h-4 bg-slate-400/40 hidden sm:inline-block"></span>
      <span>Jl. Contoh Perpustakaan No. 01</span>
      <span class="w-px h-4 bg-slate-400/40 hidden sm:inline-block"></span>
      <span>Admin Panel</span>
    </footer>

    <script>
      // ==========================
      // Kalender sederhana
      // ==========================
      const tanggalContainer = document.getElementById("tanggal");
      const bulanSekarang = document.getElementById("bulanSekarang");
      const today = new Date();

      const monthNames = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
      ];

      bulanSekarang.textContent =
        monthNames[today.getMonth()] + " " + today.getFullYear();

      const totalDays = new Date(
        today.getFullYear(),
        today.getMonth() + 1,
        0
      ).getDate();

      for (let i = 1; i <= totalDays; i++) {
        const div = document.createElement("div");
        div.className =
          "py-1.5 rounded-xl transition duration-300 cursor-pointer text-xs sm:text-sm";

        div.innerHTML = `<span>${i}</span>`;

        if (i === today.getDate()) {
          div.classList.add(
            "bg-sky-400",
            "font-bold",
            "text-slate-900",
            "shadow-lg",
            "scale-105"
          );
        } else {
          div.classList.add(
            "hover:bg-white/10",
            "text-slate-100/80"
          );
        }

        tanggalContainer.appendChild(div);
      }
    </script>
  </body>
</html>
