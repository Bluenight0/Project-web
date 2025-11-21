<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <title>Status Peminjaman Buku</title>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-950 to-teal-900 text-white">

  <?php include '../layout/header_admin.html'; ?>

  <main class="pt-24 px-4 sm:px-6 pb-16 max-w-7xl mx-auto">

    <h1 class="text-3xl sm:text-4xl font-extrabold mb-6 text-teal-300 drop-shadow-lg">
      Status Peminjaman Buku
    </h1>

    <!-- FILTER STATUS -->
    <div class="w-full flex justify-end mb-4 px-4">
      <select id="filter-status" class="
            bg-gray-900/60 text-teal-200 border border-white/20
            backdrop-blur-xl rounded-xl px-4 py-2
            shadow-[0_0_10px_rgba(0,0,0,0.4)]
            focus:outline-none focus:ring-2 focus:ring-teal-400
        ">
        <option value="">Semua Status</option>
        <option value="dipinjam" class="text-black">Dipinjam</option>
        <option value="dikembalikan" class="text-black">Dikembalikan</option>
        <option value="terlambat" class="text-black">Terlambat</option>
      </select>
    </div>

    <!-- TABEL STATUS -->
    <div class="overflow-x-auto px-4">
      <table class="min-w-full text-sm text-white">
        <thead>
          <tr class="bg-gray-800/70 backdrop-blur-md">
            <th class="p-3 text-left">ID</th>
            <th class="p-3 text-left">Peminjam</th>
            <th class="p-3 text-left">Judul</th>
            <th class="p-3 text-left">Tgl Pinjam</th>
            <th class="p-3 text-left">Jatuh Tempo</th>
            <th class="p-3 text-left">Status</th>
            <th class="p-3 text-center">Aksi</th>
          </tr>
        </thead>

        <tbody id="status-table"></tbody>
      </table>
    </div>

    <script>
      // Warna label status
      const statusClass = {
        dipinjam: "bg-blue-400 text-slate-900",
        dikembalikan: "bg-green-400 text-slate-900",
        terlambat: "bg-red-400 text-slate-900",
      };

      // Load status peminjaman
      async function loadStatus() {
        const res = await fetch("../back-end/crud/get-status.php");
        const data = await res.json();

        const filter = document.getElementById("filter-status").value;

        const filtered = filter
          ? data.filter(i => i.status.toLowerCase() === filter)
          : data;

        document.getElementById("status-table").innerHTML = filtered.map(s => {
          const key = s.status.toLowerCase();
          return `
            <tr class="border-b border-white/10">
                <td class="p-3">${s.id}</td>
                <td class="p-3">${s.nama_peminjam}</td>
                <td class="p-3">${s.judul}</td>
                <td class="p-3">${s.tgl_pinjam}</td>
                <td class="p-3">${s.jatuh_tempo}</td>

                <td class="p-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold ${statusClass[key] || 'bg-white/20'}">
                        ${s.status}
                    </span>
                </td>

                <td class="p-3 text-center">
                    <button 
                      onclick='openUpdateModal(${JSON.stringify(s)})'
                      class="px-3 py-1 rounded-xl bg-yellow-300 text-slate-900 font-semibold hover:bg-yellow-200 transition">
                      Update
                    </button>
                </td>
            </tr>
        `;
        }).join('');
      }

      // reload saat filter berubah
      document.getElementById("filter-status").addEventListener("change", loadStatus);

      // jalankan pertama kali
      document.addEventListener("DOMContentLoaded", loadStatus);
    </script>

</body>
</html>
