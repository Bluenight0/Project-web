<?php
include "../back-end/koneksi.php";
date_default_timezone_set("Asia/Jakarta");

// =====================
// 1. PENGUNJUNG (RANDOM REALISTIS)
// =====================
$hour = (int) date("H");

if ($hour >= 5 && $hour < 11)      $pengunjung = rand(200, 800);
else if ($hour < 14)               $pengunjung = rand(800, 1800);
else if ($hour < 18)               $pengunjung = rand(1500, 3000);
else                               $pengunjung = rand(2000, 4500);

// =====================
// 2. SAPAAN
// =====================
if ($hour >= 5 && $hour < 11)      $salam = "Selamat pagi";
else if ($hour < 15)               $salam = "Selamat siang";
else if ($hour < 18)               $salam = "Selamat sore";
else                               $salam = "Selamat malam";

$admin_nama = "";

// =====================
// 3. EVENT (FORMAT: judul — X hari lagi / hari ini / X hari lalu)
// =====================
$eventNotif = [];

$qEvent = mysqli_query($koneksi, "
    SELECT judul, tanggal_mulai, tanggal_selesai
    FROM event_perpus
");

$today = date("Y-m-d");
$todayStamp = strtotime($today);

if ($qEvent && mysqli_num_rows($qEvent) > 0) {
    while ($ev = mysqli_fetch_assoc($qEvent)) {

        $start = strtotime($ev['tanggal_mulai']);
        $end   = strtotime($ev['tanggal_selesai']);

        if ($todayStamp >= $start && $todayStamp <= $end) {
            $range = "Hari ini";
        }
        elseif ($todayStamp < $start) {
            $range = floor(($start - $todayStamp) / 86400) . " hari lagi";
        }
        else {
            $range = floor(($todayStamp - $end) / 86400) . " hari yang lalu";
        }

        $eventNotif[] = "📘 <b>{$ev['judul']}</b> — {$range}";
    }
} else {
    $eventNotif[] = "Tidak ada event.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="shortcut icon" href="../assets/favicon_io/favicon.ico" />
  <title>Dashboard User</title>
</head>

<body class="min-h-screen bg-gray-600 overflow-x-hidden">

  <!-- HEADER USER -->
  <?php include '../layout/header_user.html'; ?>

  <!-- MAIN HERO -->
  <main class="pt-[70px]">
    <div class="relative w-full h-[300px] sm:h-[380px] md:h-[420px] overflow-hidden">
      <img src="../assets/libarry.jpg" alt="Library" class="w-full h-full object-cover scale-110 origin-bottom" />
      <div class="absolute top-1/3 left-6 sm:left-12 text-white drop-shadow-lg">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold leading-tight">Pekanbaru Library</h1>
        <p class="mt-2 text-sm md:text-lg">Open today 9:00 am - 9:00 pm</p>
      </div>
    </div>
  </main>

  <!-- SECTION CONTENT -->
  <section class="w-full mt-4 px-4 sm:px-6 pb-10">
    <div class="flex flex-col lg:flex-row justify-center items-start gap-8 max-w-6xl mx-auto">

      <!-- Kalender -->
      <div class="ring-2 ring-white rounded-lg shadow-lg flex flex-col items-center w-full sm:w-[300px] md:w-[350px] bg-gray-700/50 p-3">
        <p id="bulanSekarang" class="text-white py-1 rounded-md font-semibold mb-3 text-center w-full"></p>
        <div id="tanggal" class="grid grid-cols-7 gap-1 p-1 rounded text-center text-white w-full"></div>
      </div>

      <!-- CARD INFORMASI -->
      <div class="grid grid-cols-1 gap-4 w-full sm:w-[420px]">

        <!-- Pengunjung -->
        <div class="bg-white/90 p-4 rounded-xl shadow">
          <h3 class="font-semibold text-gray-800 mb-1">Jumlah Pengunjung Hari Ini</h3>
          <p class="text-3xl font-bold text-blue-600">
            <?= number_format($pengunjung) ?> Orang
          </p>
        </div>

        <!-- Sapaan -->
        <div class="bg-white/90 p-4 rounded-xl shadow">
          <h3 class="font-semibold text-gray-800 mb-1">Sapaan Hari Ini</h3>
          <p class="text-lg text-gray-700">
            <?= $salam ?>, <b><?= $admin_nama ?></b> ✦
          </p>
        </div>

        <!-- Event -->
        <div class="bg-yellow-300/90 text-gray-900 p-4 rounded-xl shadow">
          <h3 class="font-semibold mb-1">Event Hari Ini</h3>

          <?php foreach ($eventNotif as $e): ?>
            <p class="text-sm mb-1"><?= $e ?></p>
          <?php endforeach; ?>
        </div>

      </div>

    </div>
  </section>

  <!-- KALENDER SCRIPT -->
  <script>
    const tanggalContainer = document.getElementById("tanggal");
    const bulanSekarang = document.getElementById("bulanSekarang");
    const today = new Date();

    const monthNames = [
      "Januari", "Februari", "Februari", "Maret",
      "April", "Mei", "Juni", "Juli",
      "Agustus", "September", "Oktober",
      "November", "Desember"
    ];

    bulanSekarang.textContent = `${monthNames[today.getMonth()]} ${today.getFullYear()}`;

    const totalDays = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate();

    for (let i = 1; i <= totalDays; i++) {
      const div = document.createElement("div");
      div.className = "p-2 rounded-md transition duration-300 hover:bg-gray-500 cursor-pointer";
      div.innerHTML = `<span>${i}</span>`;

      if (i === today.getDate()) {
        div.classList.add("bg-blue-500", "font-bold", "text-white", "shadow-md", "scale-105");
      }

      tanggalContainer.appendChild(div);
    }
  </script>

</body>
</html>
