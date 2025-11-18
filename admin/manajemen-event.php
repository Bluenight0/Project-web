<?php include '../layout/header_admin.html'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Event</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">

    <main class="p-6">
        <h1 class="text-2xl font-semibold mb-6">Manajemen Event</h1>

        <!-- Table -->
        <div class="bg-white rounded shadow p-4 overflow-x-auto">
            <table class="min-w-full border">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Judul</th>
                        <th class="p-2 border">Tanggal</th>
                        <th class="p-2 border">Deskripsi</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="event-table"></tbody>
            </table>
        </div>

        <!-- Modal -->
        <div id="event-modal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
            <div class="bg-white p-6 rounded w-96 shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Edit Event</h2>

                <input type="hidden" id="edit-id">

                <label class="block mb-2">
                    <span class="text-sm">Judul</span>
                    <input id="edit-judul" class="w-full border p-2 rounded" type="text">
                </label>

                <label class="block mb-2">
                    <span class="text-sm">Tanggal</span>
                    <input id="edit-tanggal" class="w-full border p-2 rounded" type="date">
                </label>

                <label class="block mb-4">
                    <span class="text-sm">Deskripsi</span>
                    <textarea id="edit-deskripsi" class="w-full border p-2 rounded h-24"></textarea>
                </label>

                <div class="flex justify-end gap-2">
                    <button onclick="closeEventModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                    <button onclick="saveEvent()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </div>
        </div>

    </main>

    <script>
        async function loadEvents() {
            try {
                const response = await fetch("api/get-events.php");
                const data = await response.json();

                const tbody = document.getElementById("event-table");
                tbody.innerHTML = "";

                data.forEach(event => {
                    const tr = document.createElement("tr");

                    tr.innerHTML = `
                        <td class="border p-2">${event.id}</td>
                        <td class="border p-2">${event.judul}</td>
                        <td class="border p-2">${event.tanggal}</td>
                        <td class="border p-2">${event.deskripsi}</td>
                        <td class="border p-2 text-center">
                            <button class="px-3 py-1 bg-yellow-400 rounded hover:bg-yellow-500"
                                onclick='openEventEdit(${JSON.stringify(event)})'>
                                Edit
                            </button>
                        </td>
                    `;

                    tbody.appendChild(tr);
                });
            } catch (error) {
                console.error("Gagal memuat event:", error);
            }
        }

        function openEventEdit(ev) {
            document.getElementById("edit-id").value = ev.id;
            document.getElementById("edit-judul").value = ev.judul;
            document.getElementById("edit-tanggal").value = ev.tanggal;
            document.getElementById("edit-deskripsi").value = ev.deskripsi;

            document.getElementById("event-modal").classList.remove("hidden");
        }

        function closeEventModal() {
            document.getElementById("event-modal").classList.add("hidden");
        }

        async function saveEvent() {
            const formData = new FormData();
            formData.append("id", document.getElementById("edit-id").value);
            formData.append("judul", document.getElementById("edit-judul").value);
            formData.append("tanggal", document.getElementById("edit-tanggal").value);
            formData.append("deskripsi", document.getElementById("edit-deskripsi").value);

            try {
                const response = await fetch("api/update-event.php", {
                    method: "POST",
                    body: formData
                });

                const result = await response.text();
                console.log(result);

                closeEventModal();
                loadEvents();
            } catch (error) {
                console.error("Error update event:", error);
            }
        }

        document.addEventListener("DOMContentLoaded", loadEvents);
    </script>

</body>
</html>
