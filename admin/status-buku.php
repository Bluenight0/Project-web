<?php include '../layout/header_admin.html'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Buku</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">

    <main class="p-6">
        <h1 class="text-2xl font-semibold mb-6">Status Peminjaman Buku</h1>

        <!-- Table -->
        <div class="bg-white rounded shadow p-4 overflow-x-auto">
            <table class="min-w-full border">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nama Peminjam</th>
                        <th class="p-2 border">Judul Buku</th>
                        <th class="p-2 border">Tanggal Pinjam</th>
                        <th class="p-2 border">Tanggal Kembali</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>

                <tbody id="status-table"></tbody>
            </table>
        </div>

        <!-- Modal -->
        <div id="status-modal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
            <div class="bg-white p-6 rounded w-96 shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Ubah Status</h2>

                <input type="hidden" id="edit-id">

                <label class="block mb-4">
                    <span class="text-sm">Status</span>
                    <select id="edit-status" class="w-full border p-2 rounded">
                        <option value="dipinjam">Dipinjam</option>
                        <option value="dikembalikan">Dikembalikan</option>
                        <option value="telat">Telat</option>
                    </select>
                </label>

                <div class="flex justify-end gap-2">
                    <button onclick="closeStatusModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                    <button onclick="saveStatus()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </div>
        </div>

    </main>

    <script>
        async function loadStatus() {
            try {
                const response = await fetch("api/get-status.php");
                const data = await response.json();

                const tbody = document.getElementById("status-table");
                tbody.innerHTML = "";

                data.forEach(st => {
                    const tr = document.createElement("tr");

                    tr.innerHTML = `
                        <td class="border p-2">${st.id}</td>
                        <td class="border p-2">${st.nama}</td>
                        <td class="border p-2">${st.judul}</td>
                        <td class="border p-2">${st.tgl_pinjam}</td>
                        <td class="border p-2">${st.tgl_kembali ?? "-"}</td>
                        <td class="border p-2 capitalize">${st.status}</td>
                        <td class="border p-2 text-center">
                            <button class="px-3 py-1 bg-yellow-400 rounded hover:bg-yellow-500"
                                onclick='openStatusEdit(${JSON.stringify(st)})'>
                                Edit
                            </button>
                        </td>
                    `;

                    tbody.appendChild(tr);
                });
            } catch (err) {
                console.error("Gagal memuat status:", err);
            }
        }

        function openStatusEdit(st) {
            document.getElementById("edit-id").value = st.id;
            document.getElementById("edit-status").value = st.status;
            document.getElementById("status-modal").classList.remove("hidden");
        }

        function closeStatusModal() {
            document.getElementById("status-modal").classList.add("hidden");
        }

        async function saveStatus() {
            const formData = new FormData();
            formData.append("id", document.getElementById("edit-id").value);
            formData.append("status", document.getElementById("edit-status").value);

            try {
                const response = await fetch("api/update-status.php", {
                    method: "POST",
                    body: formData
                });

                const result = await response.text();
                console.log(result);

                closeStatusModal();
                loadStatus();
            } catch (err) {
                console.error("Error update status:", err);
            }
        }

        document.addEventListener("DOMContentLoaded", loadStatus);
    </script>

</body>
</html>
