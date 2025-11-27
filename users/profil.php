<?php
include '../back-end/koneksi.php';
session_start();

// Ambil ID user dari SESSION login
$id = $_SESSION['id_anggota'] ?? null;

// Ambil data user jika ID ada
if ($id) {
  $sql = "SELECT * FROM anggota_perpus WHERE id_anggota = '$id'";
  $result = mysqli_query($koneksi, $sql);
  $user = mysqli_fetch_assoc($result);
} else {
  $user = [];
}

// Foto profil
$fotoFolder = "../back-end/uploads/foto_anggota/";
$fotoDefault = "../assets/profile-default.png";

$fotoProfil = $fotoDefault;
foreach (['jpg', 'png', 'webp'] as $ext) {
  $cek = $fotoFolder . $id . "." . $ext;
  if (file_exists($cek)) {
    $fotoProfil = $cek;
    break;
  }
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <title>Profil | Perpustakaan</title>

  <style>
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(10px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body class="bg-gradient-to-b from-gray-700 via-gray-650 to-gray-600 min-h-screen text-white font-sans">

  <?php include '../layout/header_user.html'; ?>

  <main class="pt-28 px-6 sm:px-12 max-w-7xl mx-auto space-y-12">

    <!-- Judul Halaman -->
    <h1 class="text-3xl sm:text-4xl font-bold drop-shadow-lg flex items-center gap-3 animate-[fadeInUp_.5s_ease]">
      <svg class="w-9 h-9 text-blue-300" fill="none" stroke="currentColor" stroke-width="2"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M5.121 17.804A10 10 0 1119 12v1a7 7 0 01-7 7H6a1 1 0 01-.879-1.48z" />
      </svg>
      Profil Pengguna
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

      <!-- KARTU PROFIL -->
      <div class="bg-gray-700/40 backdrop-blur-lg border border-white/10 rounded-2xl p-8 shadow-2xl 
                  hover:shadow-blue-900/20 transition animate-[fadeInUp_.6s_ease]">

        <!-- Foto + Nama -->
        <div class="flex flex-col items-center mb-8">
          <div class="w-36 h-36 rounded-full overflow-hidden shadow-xl ring-4 ring-white/20">
            <img src="<?= $fotoProfil ?>" class="w-full h-full object-cover">
          </div>

          <h2 class="text-2xl font-semibold mt-5">
            <?= htmlspecialchars($user['nama'] ?? '') ?>
          </h2>

          <p class="text-white/70 text-sm">
            ID: <?= htmlspecialchars($user['id_anggota'] ?? '') ?>
          </p>

          <button onclick="document.getElementById('modalFoto').classList.remove('hidden')"
            class="mt-4 bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-xl shadow-md transition">
            Ganti Foto Profil
          </button>
        </div>

        <!-- FORM IDENTITAS -->
        <hr class="border-white/10 my-6">

        <h3 class="text-xl font-semibold mb-4">Data Identitas</h3>

        <form action="update_profil.php" method="POST" class="space-y-4">

          <div>
            <label class="block text-sm mb-1">Nama Lengkap</label>
            <input type="text" name="nama"
              class="w-full bg-gray-800/40 border border-white/10 p-3 rounded-xl focus:ring-2 focus:ring-blue-300"
              value="<?= htmlspecialchars($user['nama'] ?? '') ?>">
          </div>

          <div>
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email"
              class="w-full bg-gray-800/40 border border-white/10 p-3 rounded-xl focus:ring-2 focus:ring-blue-300"
              value="<?= htmlspecialchars($user['email'] ?? '') ?>">
          </div>

          <div>
            <label class="block text-sm mb-1">No. HP</label>
            <input type="text" name="no_hp"
              class="w-full bg-gray-800/40 border border-white/10 p-3 rounded-xl focus:ring-2 focus:ring-blue-300"
              value="<?= htmlspecialchars($user['no_hp'] ?? '') ?>">
          </div>

          <div>
            <label class="block text-sm mb-1">Alamat</label>
            <textarea name="alamat"
              class="w-full bg-gray-800/40 border border-white/10 p-3 rounded-xl focus:ring-2 focus:ring-blue-300"
              rows="3"><?= htmlspecialchars($user['alamat'] ?? '') ?></textarea>
          </div>

          <div class="flex justify-end gap-3 pt-3">
            <button class="bg-green-600 hover:bg-green-700 px-6 py-2 rounded-xl shadow-md">
              Simpan Perubahan
            </button>

            <a href="../back-end/download_kartu.php?id=<?= $id; ?>"
              class="bg-purple-600 hover:bg-purple-700 px-6 py-2 rounded-xl shadow-md">
              Download Kartu Anggota
            </a>
          </div>

        </form>
      </div>

      <!-- KARTU KANAN -->
      <div class="space-y-6">

        <!-- Status Akun -->
        <div
          class="bg-gray-700/40 backdrop-blur-lg border border-white/10 rounded-2xl p-6 shadow-2xl animate-[fadeInUp_.7s_ease]">
          <h3 class="text-xl font-semibold mb-2">Status Akun</h3>
          <p class="text-white/80">Status: <span class="text-green-400 font-semibold">Aktif</span></p>
          <p class="text-white/60 text-sm mt-1">Terakhir login: 2025-11-06</p>
        </div>

        <!-- Peminjaman -->
        <div
          class="bg-gray-700/40 backdrop-blur-lg border border-white/10 rounded-2xl p-6 shadow-2xl animate-[fadeInUp_.8s_ease]">
          <h3 class="text-xl font-semibold mb-4">Buku yang Dipinjam</h3>
          <table class="w-full text-left text-white/80">
            <thead class="border-b border-white/20">
              <tr>
                <th class="py-2">Judul</th>
                <th class="py-2">Status</th>
                <th class="py-2">Waktu</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b border-white/10">
                <td class="py-2">Contoh Buku A</td>
                <td class="py-2">Dipinjam</td>
                <td class="py-2">3 Hari Lagi</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Event -->
        <div
          class="bg-gray-700/40 backdrop-blur-lg border border-white/10 rounded-2xl p-6 shadow-2xl animate-[fadeInUp_.9s_ease]">
          <h3 class="text-xl font-semibold mb-3">Event yang Diikuti</h3>
          <ul class="list-disc list-inside text-white/80 space-y-1">
            <li>Contoh Event Literasi Buku</li>
          </ul>
        </div>

      </div>
    </div>

    <!-- Modal Upload Foto -->
    <div id="modalFoto"
      class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 animate-[fadeInUp_.3s_ease]">
      <div class="bg-white text-black rounded-xl p-6 w-80 shadow-2xl">
        <h2 class="text-lg font-bold mb-4">Ganti Foto Profil</h2>

        <form action="upload_foto.php" method="POST" enctype="multipart/form-data">
          <input type="file" name="foto" accept="image/*"
            class="w-full mb-4 p-2 border rounded-lg" required>

          <div class="flex justify-end gap-3">
            <button type="button"
              onclick="document.getElementById('modalFoto').classList.add('hidden')"
              class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Upload</button>
          </div>
        </form>

      </div>
    </div>

  </main>

</body>
</html>
