<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <title>Profil | Perpustakaan</title>
</head>
<body class="bg-gradient-to-br from-gray-800 to-gray-900 min-h-screen text-white font-sans">

  
  <?php
  include '../layout/header_user.html';
  ?>

  <!-- Main Content -->
  <main class="pt-28 px-6 sm:px-12 max-w-7xl mx-auto space-y-8">

    <h1 class="text-3xl sm:text-4xl font-bold mb-6 drop-shadow-lg text-center sm:text-left">Profil Pengguna</h1>

    <!-- Grid Profil & Identitas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      
     <!-- Foto Profil -->
<div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 shadow-lg flex flex-col items-center hover:shadow-2xl transition">
  <!-- Bagian Foto & Nama -->
  <div class="flex flex-col items-center">
    <div class="w-32 h-32 bg-gray-300 rounded-full overflow-hidden mb-4">
      <img src="../assets/profile-default.png" alt="Foto Profil" class="w-full h-full object-cover" />
    </div>
    <h2 class="text-xl font-semibold mb-1"><?php echo htmlspecialchars($user['nama'] ?? 'Nama Pengguna'); ?></h2>
    <p class="text-white/70 text-sm mb-3">ID: <?php echo htmlspecialchars($user['id_user'] ?? '#USR001'); ?></p>
    <button class="mt-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded-xl font-semibold shadow transition">
      Ganti Foto
    </button>
  </div>

  <!-- Garis pemisah -->
  <hr class="my-5 w-full border-white/20" />

  <!-- Bagian Identitas (Form) -->
  <div class="w-full text-left">
    <h2 class="text-xl font-semibold mb-4">Identitas Lengkap</h2>

    <form action="../back-end/update_profil.php" method="POST" class="space-y-4">
      <div>
        <label class="block text-sm mb-1">Nama Lengkap</label>
        <input
          type="text"
          name="nama"
          class="w-full p-2 rounded-md text-gray-800"
          value="<?php echo htmlspecialchars($user['nama'] ?? ''); ?>"
          required
        />
      </div>

      <div>
        <label class="block text-sm mb-1">Email</label>
        <input
          type="email"
          name="email"
          class="w-full p-2 rounded-md text-gray-800"
          value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
          required
        />
      </div>

      <div>
        <label class="block text-sm mb-1">No. HP</label>
        <input
          type="text"
          name="no_hp"
          class="w-full p-2 rounded-md text-gray-800"
          value="<?php echo htmlspecialchars($user['nomor_hp'] ?? ''); ?>"
        />
      </div>

      <div>
        <label class="block text-sm mb-1">Alamat</label>
        <textarea
          name="alamat"
          class="w-full p-2 rounded-md text-gray-800"
          rows="3"
        ><?php echo htmlspecialchars($user['alamat'] ?? ''); ?></textarea>
      </div>

      <div class="flex justify-end">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl font-semibold shadow transition">
          Konfirmasi
        </button>
      </div>
    </form>
  </div>
</div>


 
        
       


    <!-- Status & Riwayat -->
    <div class="space-y-6">

      <!-- Status Akun -->
      <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 shadow-lg hover:shadow-2xl transition">
        <h3 class="text-xl font-semibold mb-3">Status Akun</h3>
        <p class="text-white/80">Status: <span class="text-green-400 font-semibold">Aktif</span></p>
        <p class="text-white/60 text-sm mt-1">Terakhir login: 2025-11-06</p>
      </div>

      <!-- Buku yang Dipinjam -->
      <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 shadow-lg hover:shadow-2xl transition">
        <h3 class="text-xl font-semibold mb-3">Buku yang Dipinjam</h3>
        <table class="w-full text-left text-white/80 border-collapse">
          <thead class="border-b border-white/30">
            <tr>
              <th class="py-2">Judul Buku</th>
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

      <!-- Event yang Diikuti -->
      <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 shadow-lg hover:shadow-2xl transition">
        <h3 class="text-xl font-semibold mb-3">Event yang Diikuti</h3>
        <ul class="list-disc list-inside text-white/80 space-y-1">
          <li>Contoh Event Literasi Buku</li>
        </ul>
      </div>
    </div>

  </main>
</body>
</html>
