<?php 
include '../back-end/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Manajemen Buku</title>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-950 to-cyan-900 text-white">

<!-- HEADER -->
<?php include '../layout/header_admin.html'; ?>

<main class="pt-24 px-4 sm:px-6 pb-16 max-w-6xl mx-auto">

    <h1 class="text-3xl sm:text-4xl font-extrabold mb-6 text-sky-300 drop-shadow-lg">
        Manajemen Buku
    </h1>

    <!-- WRAPPER GLASS -->
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 
                rounded-3xl shadow-[0_20px_60px_rgba(0,0,0,0.5)] p-6">

        <!-- TOMBOL TAMBAH (BUKA MODAL) -->
        <div class="flex justify-end mb-4">
            <button onclick="openAddModal()"
                class="px-4 py-2 rounded-xl bg-sky-400 text-slate-900 font-semibold shadow hover:bg-sky-300 transition">
                + Tambah Buku
            </button>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-white/10 text-sky-200">
                    <tr>
                        <th class="p-3">ID</th>
                        <th class="p-3">Nama Buku</th>
                        <th class="p-3">Jenis</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Gambar</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/10 text-slate-200">

                <?php
                $q = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku DESC");

                while ($b = mysqli_fetch_assoc($q)):
                ?>
                    <tr>
                        <td class="p-3"><?= $b['id_buku']; ?></td>
                        <td class="p-3"><?= $b['nama']; ?></td>
                        <td class="p-3"><?= $b['jenis']; ?></td>
                        <td class="p-3"><?= $b['tanggal']; ?></td>
                        <td class="p-3"><?= $b['gambar']; ?></td>
                        <td class="p-3"><?= $b['status']; ?></td>

                        <td class="p-3 text-center">
                            <a href="../back-end/crud/buku.php?edit=<?= $b['id_buku']; ?>"
                               class="px-3 py-1 rounded-xl bg-yellow-300 text-slate-900 font-semibold hover:bg-yellow-200 transition">
                               Edit
                            </a>

                            <a href="../back-end/crud/buku.php?hapus=<?= $b['id_buku']; ?>"
                               onclick="return confirm('Yakin hapus buku ini?')"
                               class="px-3 py-1 rounded-xl bg-red-400 text-slate-900 font-semibold hover:bg-red-300 transition ml-2">
                               Hapus
                            </a>
                        </td>
                    </tr>

                <?php endwhile; ?>

                </tbody>
            </table>
        </div>
    </div>
</main>



<!-- ========== MODAL TAMBAH BUKU ========== -->
<div id="add-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-center z-50">
    <div class="bg-white/10 border border-white/20 backdrop-blur-xl p-6 rounded-2xl w-[380px] text-white shadow-xl">

        <h2 class="text-xl font-bold mb-4">Tambah Buku</h2>

        <form action="../back-end/crud/buku.php" method="POST">

            <input type="text" name="nama" placeholder="Nama Buku"
                   class="w-full mb-3 p-2 bg-gray-800/60 rounded border border-white/20" required>

            <input type="text" name="jenis" placeholder="Jenis Buku"
                   class="w-full mb-3 p-2 bg-gray-800/60 rounded border border-white/20" required>

            <input type="date" name="tanggal"
                   class="w-full mb-3 p-2 bg-gray-800/60 rounded border border-white/20" required>

            <input type="text" name="gambar" placeholder="Nama File Gambar (optional)"
                   class="w-full mb-3 p-2 bg-gray-800/60 rounded border border-white/20">

            <select name="status"
                    class="w-full mb-4 p-2 bg-gray-800/60 rounded border border-white/20">
                <option value="Tersedia" class="text-black">Tersedia</option>
                <option value="Tidak Tersedia" class="text-black">Tidak Tersedia</option>
            </select>

            <button type="submit" name="tambah"
                class="w-full py-2 bg-sky-400 text-slate-900 font-semibold rounded-xl hover:bg-sky-300">
                Simpan
            </button>
        </form>

        <button onclick="closeAddModal()"
            class="w-full mt-3 py-2 bg-red-400 text-slate-900 font-semibold rounded-xl hover:bg-red-300">
            Batal
        </button>
    </div>
</div>


<!-- JS MODAL -->
<script>
function openAddModal() {
    document.getElementById("add-modal").classList.remove("hidden");
}
function closeAddModal() {
    document.getElementById("add-modal").classList.add("hidden");
}
</script>

</body>
</html>
