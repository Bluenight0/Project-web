<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Manajemen Event</title>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-950 to-cyan-900 text-white">

    <?php include '../layout/header_admin.html'; ?>

    <main class="pt-24 px-4 sm:px-6 pb-16 max-w-6xl mx-auto">

        <h1 class="text-3xl sm:text-4xl font-extrabold mb-6 text-cyan-300 drop-shadow-lg">
            Manajemen Event Perpustakaan
        </h1>

        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow p-6">

            <div class="flex justify-end mb-4">
                <button onclick="openAddModal()"
                    class="px-4 py-2 rounded-xl bg-cyan-400 text-slate-900 font-semibold shadow hover:bg-cyan-300 transition">
                    + Tambah Event
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-white/10 text-cyan-200">
                        <tr>
                            <th class="p-3">ID</th>
                            <th class="p-3">Judul</th>
                            <th class="p-3">Mulai</th>
                            <th class="p-3">Selesai</th>
                            <th class="p-3">Lokasi</th>
                            <th class="p-3">Deskripsi</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="event-table" class="divide-y divide-white/10 text-slate-200"></tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- MODAL -->
    <div id="event-modal"
        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">

        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-6 w-full max-w-md shadow">

            <h2 id="modal-title" class="text-xl font-bold text-cyan-300 mb-4"></h2>

            <input id="edit-id_event" type="hidden">

            <div class="space-y-3">

                <div>
                    <label class="text-sm text-cyan-200">Judul Event</label>
                    <input id="edit-judul" class="w-full bg-white/20 border border-white/30 rounded-xl p-2 text-white">
                </div>

                <div>
                    <label class="text-sm text-cyan-200">Tanggal Mulai</label>
                    <input id="edit-tanggal_mulai" type="date"
                        class="w-full bg-white/20 border border-white/30 rounded-xl p-2 text-white">
                </div>

                <div>
                    <label class="text-sm text-cyan-200">Tanggal Selesai</label>
                    <input id="edit-tanggal_selesai" type="date"
                        class="w-full bg-white/20 border border-white/30 rounded-xl p-2 text-white">
                </div>

                <div>
                    <label class="text-sm text-cyan-200">Lokasi</label>
                    <input id="edit-lokasi" class="w-full bg-white/20 border border-white/30 rounded-xl p-2 text-white">
                </div>

                <div>
                    <label class="text-sm text-cyan-200">Deskripsi</label>
                    <textarea id="edit-deskripsi"
                        class="w-full bg-white/20 border border-white/30 rounded-xl p-2 text-white h-24"></textarea>
                </div>

                <div>
                    <label class="text-sm text-cyan-200">Link Event (opsional)</label>
                    <input id="edit-link_event"
                        class="w-full bg-white/20 border border-white/30 rounded-xl p-2 text-white">
                </div>

            </div>

            <div class="flex justify-end gap-3 mt-5">
                <button onclick="closeModal()"
                    class="px-4 py-2 rounded-xl bg-red-400 text-slate-900 font-semibold hover:bg-red-300 transition">
                    Batal
                </button>

                <button onclick="saveEvent()"
                    class="px-4 py-2 rounded-xl bg-cyan-400 text-slate-900 font-semibold hover:bg-cyan-300 transition">
                    Simpan
                </button>
            </div>

        </div>
    </div>

    <script>
        // ======================
        // LOAD EVENT LIST
        // ======================
        async function loadEvents() {
            const res = await fetch("../back-end/crud/event.php");
            const events = await res.json();

            document.getElementById("event-table").innerHTML = events.map(e => `
        <tr>
            <td class="p-3">${e.id_event}</td>
            <td class="p-3">${e.judul}</td>
            <td class="p-3">${e.tanggal_mulai}</td>
            <td class="p-3">${e.tanggal_selesai}</td>
            <td class="p-3">${e.lokasi}</td>
            <td class="p-3">${e.deskripsi}</td>

            <td class="p-3 text-center flex justify-center gap-2">
                
                <!-- EDIT -->
                <button onclick='openEdit(${JSON.stringify(e)})'
                    class="px-3 py-1 rounded-xl bg-yellow-300 text-slate-900 font-semibold hover:bg-yellow-200 transition">
                    Edit
                </button>

                <!-- HAPUS -->
                <button onclick='deleteEvent(${e.id_event})'
                    class="px-3 py-1 rounded-xl bg-red-400 text-slate-900 font-semibold hover:bg-red-300 transition">
                    Hapus
                </button>

            </td>
        </tr>
    `).join('');
        }

        // ======================
        // OPEN ADD MODAL
        // ======================
        function openAddModal() {
            document.getElementById("modal-title").textContent = "Tambah Event";
            document.getElementById("event-modal").classList.remove("hidden");

            // kosongkan semua input
            [
                "id_event",
                "judul",
                "tanggal_mulai",
                "tanggal_selesai",
                "lokasi",
                "deskripsi",
                "link_event"
            ].forEach(k => {
                const el = document.getElementById(`edit-${k}`);
                if (el) el.value = "";
            });
        }

        // ======================
        // OPEN EDIT MODAL
        // ======================
        function openEdit(ev) {
            document.getElementById("modal-title").textContent = "Edit Event";
            document.getElementById("event-modal").classList.remove("hidden");

            for (const key in ev) {
                const el = document.getElementById(`edit-${key}`);
                if (el) el.value = ev[key];
            }
        }

        // ======================
        // CLOSE MODAL
        // ======================
        function closeModal() {
            document.getElementById("event-modal").classList.add("hidden");
        }

        // ======================
        // SAVE (INSERT / UPDATE)
        // ======================
        async function saveEvent() {
            const fd = new FormData();

            [
                "id_event",
                "judul",
                "tanggal_mulai",
                "tanggal_selesai",
                "lokasi",
                "deskripsi",
                "link_event"
            ].forEach(k => {
                fd.append(k, document.getElementById(`edit-${k}`).value);
            });

            await fetch("../back-end/crud/event.php", {
                method: "POST",
                body: fd
            });

            closeModal();
            loadEvents();
        }

        // ======================
        // DELETE EVENT
        // ======================
        async function deleteEvent(id) {
            if (!confirm("Yakin hapus event ini?")) return;

            const fd = new FormData();
            fd.append("delete", "1");
            fd.append("id_event", id);

            await fetch("../back-end/crud/event.php", {
                method: "POST",
                body: fd
            });

            loadEvents();
        }

        // ======================
        // AUTO LOAD KETIKA PAGE DIBUKA
        // ======================
        document.addEventListener("DOMContentLoaded", loadEvents);

    </script>

</body>

</html>