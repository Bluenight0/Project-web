<?php include '../layout/header_admin.html'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Buku</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">

    <main class="p-6">
        <h1 class="text-2xl font-semibold mb-6">Manajemen Buku</h1>

        <!-- Table -->
        <div class="bg-white rounded shadow p-4 overflow-x-auto">
            <table class="min-w-full border">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Judul</th>
                        <th class="p-2 border">Penulis</th>
                        <th class="p-2 border">Kategori</th>
                        <th class="p-2 border">Stok</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="book-table"></tbody>
            </table>
        </div>

        <!-- Modal -->
        <div id="edit-modal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
            <div class="bg-white p-6 rounded w-96 shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Edit Buku</h2>

                <input type="hidden" id="edit-id">

                <label class="block mb-2">
                    <span class="text-sm">Judul</span>
                    <input id="edit-judul" class="w-full border p-2 rounded" type="text">
                </label>

                <label class="block mb-2">
                    <span class="text-sm">Penulis</span>
                    <input id="edit-penulis" class="w-full border p-2 rounded" type="text">
                </label>

                <label class="block mb-2">
                    <span class="text-sm">Kategori</span>
                    <input id="edit-kategori" class="w-full border p-2 rounded" type="text">
                </label>

                <label class="block mb-4">
                    <span class="text-sm">Stok</span>
                    <input id="edit-stok" class="w-full border p-2 rounded" type="number">
                </label>

                <div class="flex justify-end gap-2">
                    <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                    <button onclick="saveEdit()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </div>
        </div>

    </main>

    <script>
        async function loadBooks() {
            try {
                const response = await fetch("api/get-books.php");
                const data = await response.json();

                const tbody = document.getElementById("book-table");
                tbody.innerHTML = "";

                data.forEach(book => {
                    const tr = document.createElement("tr");

                    tr.innerHTML = `
                        <td class="border p-2">${book.id}</td>
                        <td class="border p-2">${book.judul}</td>
                        <td class="border p-2">${book.penulis}</td>
                        <td class="border p-2">${book.kategori}</td>
                        <td class="border p-2">${book.stok}</td>
                        <td class="border p-2 text-center">
                            <button class="px-3 py-1 bg-yellow-400 rounded hover:bg-yellow-500"
                                onclick='openEdit(${JSON.stringify(book)})'>
                                Edit
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } catch (err) {
                console.error("Gagal memuat data:", err);
            }
        }

        function openEdit(book) {
            document.getElementById("edit-id").value = book.id;
            document.getElementById("edit-judul").value = book.judul;
            document.getElementById("edit-penulis").value = book.penulis;
            document.getElementById("edit-kategori").value = book.kategori;
            document.getElementById("edit-stok").value = book.stok;

            document.getElementById("edit-modal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("edit-modal").classList.add("hidden");
        }

        async function saveEdit() {
            const formData = new FormData();
            formData.append("id", document.getElementById("edit-id").value);
            formData.append("judul", document.getElementById("edit-judul").value);
            formData.append("penulis", document.getElementById("edit-penulis").value);
            formData.append("kategori", document.getElementById("edit-kategori").value);
            formData.append("stok", document.getElementById("edit-stok").value);

            try {
                const response = await fetch("api/update-book.php", {
                    method: "POST",
                    body: formData
                });

                const result = await response.text();
                console.log(result);

                closeModal();
                loadBooks();
            } catch (err) {
                console.error("Error update:", err);
            }
        }

        document.addEventListener("DOMContentLoaded", loadBooks);
    </script>

</body>
</html>
