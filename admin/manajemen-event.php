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

    <!-- TITLE -->
    <h1 class="text-3xl sm:text-4xl font-extrabold mb-6 text-cyan-300 drop-shadow-lg">
        Manajemen Event Perpustakaan
    </h1>

    <!-- CARD WRAPPER GLASS -->
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 
                rounded-3xl shadow-[0_20px_60px_rgba(0,0,0,0.5)] p-6">

        <!-- TOMBOL TAMBAH -->
        <div class="flex justify-end mb-4">
            <button onclick="openAddModal()"
                class="px-4 py-2 rounded-xl bg-cyan-400 text-slate-900 font-semibold shadow hover:bg-cyan-300 transition">
                + Tambah Event
            </button>
        </div>

        <!-- TABEL EVENT -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-white/10 text-cyan-200">
                    <tr>
                        <th class="p-3">ID</th>
                        <th class="p-3">Nama Event</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Lokasi</th>
                        <th class="p-3">Keterangan</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="event-table" class="divide-y divide-white/10 text-slate-200">
                    <!-- Data dari JS -->
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- MODAL ADD/EDIT -->
<div id="event-modal"
     class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">

    <div class="bg-white/10 backdrop-blur-xl border border-white/20 
                rounded-3xl p-6 w-full max-w-md 
                shadow-[0_20px_60px_rgba(0,0,0,0.6)]">

        <h2 id="modal-title" class="text-xl font-bold text-cyan-300 mb-4"></h2>

        <div class="space-y-3">
            <input id="edit-id" type="hidden">

            <div>
                <label class="text-sm text-cyan-200">Nama Event</label>
                <input id="edit-nama"
                       class="w-full bg-white/20 border border-white/30 rounded-xl p-2 text-white outline-none">
            </div>

            <div>
                <label class="text-sm text-cyan-200">Tanggal</label>
                <input id="edit-tanggal" type="date"
                       class="w-full bg-white/20 border border-white/30 rounded-xl p-2 text-white outline-none">
            </div>

            <div>
                <label class="text-sm text-cyan-200">Lokasi</label>
                <input id="edit-lokasi"
                       class="w-full bg-white/20 border border-white/30 rounded-xl p-2 text-white outline-none">
            </div>

            <div>
                <label class="text-sm text-cyan-200">Keterangan</label>
                <textarea id="edit-keterangan"
                          class="w-full bg-white/20 border border-white/30 rounded-xl p-2 text-white h-24 outline-none"></textarea>
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
    const response = await fetch("api/get-events.php");
    const events = await response.json();

    document.getElementById("event-table").innerHTML = events.map(e => `
        <tr>
            <td class="p-3">${e.id}</td>
            <td class="p-3">${e.nama}</td>
            <td class="p-3">${e.tanggal}</td>
            <td class="p-3">${e.lokasi}</td>
            <td class="p-3">${e.keterangan}</td>
            <td class="p-3 text-center">
                <button onclick='openEdit(${JSON.stringify(e)})'
                    class="px-3 py-1 rounded-xl bg-yellow-300 text-slate-900 font-semibold hover:bg-yellow-200 transition">
                    Edit
                </button>
            </td>
        </tr>
    `).join('');
}

// ======================
// OPEN MODAL
// ======================
function openAddModal() {
    document.getElementById("modal-title").textContent = "Tambah Event";
    document.getElementById("edit-id").value = "";
    document.getElementById("event-modal").classList.remove("hidden");

    ["nama","tanggal","lokasi","keterangan"].forEach(v => {
        document.getElementById(`edit-${v}`).value = "";
    });
}

function openEdit(ev) {
    document.getElementById("modal-title").textContent = "Edit Event";
    document.getElementById("event-modal").classList.remove("hidden");

    document.getElementById("edit-id").value        = ev.id;
    document.getElementById("edit-nama").value      = ev.nama;
    document.getElementById("edit-tanggal").value   = ev.tanggal;
    document.getElementById("edit-lokasi").value    = ev.lokasi;
    document.getElementById("edit-keterangan").value= ev.keterangan;
}

// ======================
// CLOSE MODAL
// ======================
function closeModal() {
    document.getElementById("event-modal").classList.add("hidden");
}

// ======================
// SAVE EVENT
// ======================
async function saveEvent() {
    const fd = new FormData();

    ["id","nama","tanggal","lokasi","keterangan"].forEach(k => {
        fd.append(k, document.getElementById(`edit-${k}`).value);
    });

    await fetch("api/update-event.php", {
        method: "POST",
        body: fd
    });

    closeModal();
    loadEvents();
}

document.addEventListener("DOMContentLoaded", loadEvents);
</script>

</body>
</html>
