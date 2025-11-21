<?php
include "../back-end/koneksi.php";
date_default_timezone_set("Asia/Jakarta");

// =====================
// 1. PENGUNJUNG HARI INI (RANDOM REALISTIS)
// =====================
$hour = (int) date("H");

if ($hour >= 5 && $hour < 11) {
  $pengunjung = rand(200, 800);
} elseif ($hour >= 11 && $hour < 14) {
  $pengunjung = rand(800, 1800);
} elseif ($hour >= 14 && $hour < 18) {
  $pengunjung = rand(1500, 3000);
} else {
  $pengunjung = rand(2000, 4500);
}

// =====================
// 2. SAPAAN HARI INI
// =====================
if ($hour >= 5 && $hour < 11)
  $salam = "Selamat pagi";
else if ($hour >= 11 && $hour < 15)
  $salam = "Selamat siang";
else if ($hour >= 15 && $hour < 18)
  $salam = "Selamat sore";
else
  $salam = "Selamat malam";

$admin_nama = "Adit";

// =====================
// EVENT — CARA PALING SIMPLE (TANPA FILTER)
// =====================

$eventNotif = [];

$qEvent = mysqli_query($koneksi, "
    SELECT judul, tanggal_mulai, tanggal_selesai
    FROM event_perpus
");

$today = date("Y-m-d");
$todayTime = strtotime($today);

if (mysqli_num_rows($qEvent) > 0) {
  while ($row = mysqli_fetch_assoc($qEvent)) {

    $start = strtotime($row['tanggal_mulai']);
    $end = strtotime($row['tanggal_selesai']);

    // Hitung selisih hari
    $selisihMulai = floor(($start - $todayTime) / 86400);
    $selisihSelesai = floor(($todayTime - $end) / 86400);

    // Format teks rentang
    if ($todayTime >= $start && $todayTime <= $end) {
      // Event sedang berlangsung
      $rentang = "Hari ini";
    } else if ($todayTime < $start) {
      // Event akan datang
      $rentang = $selisihMulai . " hari lagi";
    } else {
      // Event sudah selesai
      $rentang = $selisihSelesai . " hari yang lalu";
    }

    // Gabungkan teks final
    $eventNotif[] = "📘 <b>{$row['judul']}</b> — {$rentang}";
  }
} else {
  $eventNotif[] = "Tidak ada event.";
}



?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <title>Dashboard Admin</title>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-950 to-sky-900 text-white overflow-x-hidden">

  <?php include '../layout/header_admin.html'; ?>

  <!-- HERO -->
  <main class="pt-24">
    <div class="relative w-full h-[260px] sm:h-[320px] md:h-[360px] overflow-hidden rounded-b-3xl shadow-2xl">
      <img src="../assets/libarry.jpg" alt="Library" class="w-full h-full object-cover scale-110 origin-center" />

      <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent"></div>

      <div class="absolute left-6 sm:left-12 top-1/3 space-y-2 drop-shadow-lg">
        <p class="text-xs uppercase tracking-[0.2em] text-sky-300/90">admin panel</p>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight">
          Pekanbaru<span class="text-sky-300"> libarry</span>
        </h1>
        <p class="mt-1 text-sm md:text-base text-slate-100/80">
          Open today <span class="font-semibold text-sky-200">09:00 – 21:00</span>
        </p>
      </div>
    </div>
  </main>

  <!-- KONTEN -->
  <section class="w-full mt-6 px-4 sm:px-6 pb-10">
    <div class="flex flex-col lg:flex-row justify-center items-start gap-8 max-w-6xl mx-auto">

      <!-- KALENDER -->
      <div class="w-full sm:w-[320px] md:w-[360px]
                    bg-white/10 border border-white/20 backdrop-blur-xl
                    rounded-3xl shadow-[0_20px_60px_rgba(15,23,42,0.7)]
                    flex flex-col items-center p-4">
        <p id="bulanSekarang" class="w-full text-center py-2 rounded-2xl
                      font-semibold tracking-wide
                      bg-gradient-to-r from-sky-400/80 to-cyan-300/80
                      text-slate-900 shadow-md"></p>

        <div id="tanggal" class="mt-4 grid grid-cols-7 gap-1.5 text-center text-sm text-slate-100 w-full"></div>
      </div>

      <!-- KANAN -->
      <div class="flex-1 space-y-4">

        <!-- JUMLAH PENGUNJUNG -->
        <div class="bg-white/10 border border-white/15 backdrop-blur-xl
                        rounded-3xl shadow-[0_20px_60px_rgba(15,23,42,0.7)]
                        p-4 sm:p-5">
          <h2 class="text-lg font-semibold mb-2">Jumlah Pengunjung Hari Ini</h2>
          <p class="text-3xl font-bold text-sky-300">
            <?= number_format($pengunjung, 0, ',', '.') ?> Orang
          </p>
        </div>

        <!-- SAPAAN & EVENT -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

          <!-- SAPAAN -->
          <div class="bg-white/10 border border-white/15 backdrop-blur-xl
                            rounded-3xl shadow-[0_18px_50px_rgba(15,23,42,0.65)]
                            p-4">
            <h3 class="font-semibold mb-1">Sapaan Hari Ini</h3>
            <p class="text-sm">
              <?= $salam ?>, <span class="font-semibold"><?= htmlspecialchars($admin_nama) ?></span> ✦
            </p>
          </div>

          <!-- EVENT -->
          <div class="bg-gradient-to-br from-amber-300/90 via-amber-400/90 to-amber-500/90
            text-slate-900 rounded-3xl shadow-[0_18px_50px_rgba(251,191,36,0.6)] p-4">
            <h3 class="font-semibold mb-1">Event Aktif Hari Ini</h3>

            <?php foreach ($eventNotif as $notif): ?>
            <?php endforeach; ?>
            <p class="text-sm mb-1"><?= $notif ?></p>
          </div>


        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="border-t border-white/10 bg-black/30 backdrop-blur-xl
               py-3 px-4 flex flex-wrap items-center justify-center gap-3 text-xs sm:text-sm text-slate-200">
    <span class="font-semibold tracking-wide">Library.esk</span>
    <span class="w-px h-4 bg-slate-400/40 hidden sm:inline-block"></span>
    <span>Jl. Contoh Perpustakaan No. 01</span>
    <span class="w-px h-4 bg-slate-400/40 hidden sm:inline-block"></span>
    <span>Admin Panel</span>
  </footer>

  <script>
    // kalender
    const tanggalContainer = document.getElementById("tanggal");
    const bulanSekarang = document.getElementById("bulanSekarang");
    const today = new Date();

    const monthNames = [
      "Januari", "Februari", "Maret", "April", "Mei", "Juni",
      "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    bulanSekarang.textContent = monthNames[today.getMonth()] + " " + today.getFullYear();

    const totalDays = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate();

    for (let i = 1; i <= totalDays; i++) {
      const div = document.createElement("div");
      div.className = "py-1.5 rounded-xl transition duration-300 cursor-pointer text-xs sm:text-sm";
      div.innerHTML = `<span>${i}</span>`;

      if (i === today.getDate()) {
        div.classList.add("bg-sky-400", "font-bold", "text-slate-900", "shadow-lg", "scale-105");
      } else {
        div.classList.add("hover:bg-white/10", "text-slate-100/80");
      }

      tanggalContainer.appendChild(div);
    }
  </script>

</body>

</html>