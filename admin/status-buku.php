<?php
include '../back-end/koneksi.php'; // sesuaikan path koneksinya
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="shortcut icon" href="../assets/favicon_io/favicon.ico" />
  <title>Status Buku</title>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800">
  <!-- Header -->
  <header class="fixed top-0 left-0 w-full bg-gray-700/80 backdrop-blur-md z-20 shadow-lg">
    <nav class="flex flex-wrap justify-between items-center p-3 max-w-6xl mx-auto">
      <a href="dashboard.html" class="bg-white/10 text-white rounded-2xl px-3 py-1 hover:bg-gray-400 transition font-semibold shadow-lg">Admin</a>
      <div class="flex flex-wrap gap-3 mt-2 sm:mt-0">
        <a href="status-buku.php" class="bg-white/10 text-white/80 rounded-2xl px-3 py-1 hover:bg-gray-400 transition font-semibold shadow-lg">Status Buku</a>
        <a href="manajemen-buku.html" class="bg-white/10 text-white/80 rounded-2xl px-3 py-1 hover:bg-gray-400 transition font-semibold shadow-lg">Data Buku</a>
        <a href="manajemen-event.html" class="bg-white/10 text-white/80 rounded-2xl px-3 py-1 hover:bg-gray-400 transition font-semibold shadow-lg">Data events</a>
        <a href="../login.html" class="bg-white/10 text-white/80 rounded-2xl px-3 py-1 hover:bg-gray-400 transition font-semibold shadow-lg">Login</a>
      </div>
    </nav>
  </header>

  <!-- Main Content -->
  <main class="pt-24 px-6 flex flex-col items-center">
    <section class="w-full max-w-5xl bg-white rounded-2xl shadow-md p-6">
      <h1 class="text-2xl font-bold text-gray-700 mb-4">Status Peminjaman Buku</h1>

      <!-- Form Pencarian -->
      <form method="GET" class="flex flex-col md:flex-row justify-between mb-6 gap-3">
        <input
          type="text"
          name="search"
          placeholder="Cari nama buku atau pengguna..."
          class="w-full md:w-2/3 border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300"
          value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
        />
        <button
          type="submit"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold"
        >
          Cari
        </button>
      </form>

      <!-- Tabel Status Buku -->
      <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
          <thead class="bg-gray-700 text-white">
            <tr>
              <th class="px-4 py-2 text-left">Nama Buku</th>
              <th class="px-4 py-2 text-left">Peminjam</th>
              <th class="px-4 py-2 text-left">Tanggal Pinjam</th>
              <th class="px-4 py-2 text-left">Tanggal Kembali</th>
              <th class="px-4 py-2 text-left">Batas Waktu</th>
              <th class="px-4 py-2 text-left">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
            $query = "SELECT * FROM peminjaman";
            if ($search) {
              $query .= " WHERE nama_buku LIKE '%$search%' OR nama_peminjam LIKE '%$search%'";
            }
            $query .= " ORDER BY tgl_pinjam DESC";

            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $statusClass = match ($row['status']) {
                  'Dipinjam' => 'bg-yellow-500',
                  'Dikembalikan' => 'bg-green-500',
                  'Terlambat' => 'bg-red-500',
                  default => 'bg-gray-400'
                };
                echo "
                <tr class='hover:bg-gray-100'>
                  <td class='px-4 py-2 border-t'>{$row['nama_buku']}</td>
                  <td class='px-4 py-2 border-t'>{$row['nama_peminjam']}</td>
                  <td class='px-4 py-2 border-t'>{$row['tgl_pinjam']}</td>
                  <td class='px-4 py-2 border-t'>".($row['tgl_kembali'] ?: '-')."</td>
                  <td class='px-4 py-2 border-t'>{$row['batas_waktu']} Hari</td>
                  <td class='px-4 py-2 border-t'>
                    <span class='text-white px-3 py-1 rounded-lg $statusClass'>{$row['status']}</span>
                  </td>
                </tr>";
              }
            } else {
              echo "
              <tr>
                <td colspan='6' class='text-center py-4 text-gray-500'>
                  Tidak ada data peminjaman ditemukan.
                </td>
              </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</body>
</html>
