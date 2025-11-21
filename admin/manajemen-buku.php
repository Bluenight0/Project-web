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

<?php include '../layout/header_admin.html'; ?>

<main class="pt-24 px-4 sm:px-6 pb-16 max-w-6xl mx-auto">

    <h1 class="text-3xl sm:text-4xl font-extrabold mb-6 text-sky-300 drop-shadow-lg">
        Manajemen Buku
    </h1>

    <div class="bg-white/10 backdrop-blur-xl border border-white/20 
                rounded-3xl shadow-[0_20px_60px_rgba(0,0,0,0.5)] p-6">

        <div class="flex justify-end mb-4">
            <button onclick="openAddModal()"
                class="px-4 py-2 rounded-xl bg-sky-400 text-slate-900 font-semibold shadow hover:bg-sky-300 transition">
                + Tambah Buku
            </button>
        </div>

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

                        <td class="p-3">
                            <?php if ($b['gambar']): ?>
                                <img src="<?= $b['gambar'] ?>" alt="" class="w-14 h-20 object-cover rounded">
                            <?php else: ?>
                                <span class="text-gray-400">-</span>
                            <?php endif; ?>
                        </td>

                        <td class="p-3"><?= $b['status']; ?></td>

                        <td class="p-3 text-center">

                            <button onclick="openEditModal(
                                <?= $b['id_buku']; ?>,
                                `<?= htmlspecialchars($b['nama']); ?>`,
                                `<?= htmlspecialchars($b['jenis']); ?>`,
                                `<?= $b['tanggal']; ?>`,
                                `<?= htmlspecialchars($b['gambar']); ?>`,
                                `<?= $b['status']; ?>`
                            )"
                            class="px-3 py-1 rounded-xl bg-yellow-300 text-slate-900 font-semibold hover:bg-yellow-200 transition">
                                Edit
                            </button>

                            <button onclick="hapusBuku(<?= $b['id_buku']; ?>)"
                               class="px-3 py-1 rounded-xl bg-red-400 text-slate-900 font-semibold hover:bg-red-300 transition ml-2">
                               Hapus
                            </button>

                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>


<!-- ===========================
     MODAL (ADD + EDIT)
=========================== -->
<div id="add-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-center z-50">
    <div class="bg-white/10 border border-white/20 p-6 rounded-2xl w-[380px] text-white shadow-xl">

        <h2 id="modalTitle" class="text-xl font-bold mb-4">Tambah Buku</h2>

        <form onsubmit="return false;">

            <!-- Search Google Books -->
            <input type="text" id="searchGoogle" placeholder="Cari buku (Google Books)"
                   class="w-full mb-3 p-2 bg-gray-800/60 rounded border border-white/20">

            <button type="button" onclick="searchGoogleBooks()"
                    class="w-full mb-4 py-2 bg-yellow-400 text-slate-900 font-semibold rounded-xl hover:bg-yellow-300">
                Cari di Google Buku
            </button>

            <div id="googleResults" class="max-h-40 overflow-y-auto mb-3 hidden"></div>

            <!-- Form data -->
            <input type="text" id="nama" placeholder="Nama Buku"
                   class="w-full mb-3 p-2 bg-gray-800/60 rounded border border-white/20" required>

            <input type="text" id="jenis" placeholder="Jenis Buku / Kategori"
                   class="w-full mb-3 p-2 bg-gray-800/60 rounded border border-white/20" required>

            <input type="date" id="tanggal"
                   class="w-full mb-3 p-2 bg-gray-800/60 rounded border border-white/20" required>

            <input type="text" id="gambar" placeholder="URL Gambar Buku"
                   class="w-full mb-3 p-2 bg-gray-800/60 rounded border border-white/20">

            <select id="status"
                    class="w-full mb-4 p-2 bg-gray-800/60 rounded border border-white/20">
                <option value="Tersedia" class="text-black">Tersedia</option>
                <option value="Tidak Tersedia" class="text-black">Tidak Tersedia</option>
            </select>

            <button type="button" id="saveBtn"
                class="w-full py-2 bg-sky-400 text-slate-900 font-semibold rounded-xl hover:bg-sky-300"
                onclick="tambahBuku()">
                Simpan
            </button>
        </form>

        <button onclick="closeAddModal()"
            class="w-full mt-3 py-2 bg-red-400 text-slate-900 font-semibold rounded-xl hover:bg-red-300">
            Batal
        </button>
    </div>
</div>


<!-- ===========================
     JAVASCRIPT
=========================== -->
<script>

/* ==========================
    VARIABEL UTAMA
========================== */
const modal = document.getElementById("add-modal");
const title = document.getElementById("modalTitle");
const saveBtn = document.getElementById("saveBtn");
const googleBox = document.getElementById("googleResults");

const input = {
    nama: document.getElementById("nama"),
    jenis: document.getElementById("jenis"),
    tanggal: document.getElementById("tanggal"),
    gambar: document.getElementById("gambar"),
    status: document.getElementById("status"),
    search: document.getElementById("searchGoogle")
};

let editID = null;


/* ==========================
    OPEN / CLOSE MODAL
========================== */
function openAddModal(isEdit = false, data = null) {
    modal.classList.remove("hidden");

    if (isEdit && data) {
        title.innerText = "Edit Buku";
        saveBtn.innerText = "Update Buku";
        editID = data.id;

        input.nama.value = data.nama;
        input.jenis.value = data.jenis;
        input.tanggal.value = data.tanggal;
        input.gambar.value = data.gambar;
        input.status.value = data.status;

        saveBtn.onclick = submitForm;
    } else {
        title.innerText = "Tambah Buku";
        saveBtn.innerText = "Simpan";
        editID = null;

        input.nama.value = "";
        input.jenis.value = "";
        input.tanggal.value = "";
        input.gambar.value = "";
        input.status.value = "Tersedia";

        saveBtn.onclick = submitForm;
    }
}

function closeAddModal() {
    modal.classList.add("hidden");
    googleBox.classList.add("hidden");
}


/* ==========================
    FETCH WRAPPER (OPTIMAL)
========================== */
async function apiRequest(method, body = null) {
    const options = {
        method,
        headers: { "Content-Type": "application/json" },
    };

    if (body) options.body = JSON.stringify(body);

    const res = await fetch("../back-end/crud/buku.php", options);
    return await res.json();
}


/* ==========================
    SUBMIT (ADD & EDIT)
========================== */
async function submitForm() {
    const data = {
        nama: input.nama.value,
        jenis: input.jenis.value,
        tanggal: input.tanggal.value,
        gambar: input.gambar.value,
        status: input.status.value,
    };

    // mode edit
    if (editID) {
        data.id_buku = editID;
        const json = await apiRequest("PUT", data);

        if (json.status === "success") {
            alert("Buku berhasil diperbarui!");
            location.reload();
        } else alert("Update gagal.");
        return;
    }

    // mode tambah
    const json = await apiRequest("POST", data);

    if (json.status === "success") {
        alert("Buku berhasil ditambahkan!");
        location.reload();
    } else {
        alert("Gagal menambah buku.\n" + (json.sql_error ?? ""));
    }
}


/* ==========================
    HAPUS BUKU
========================== */
async function hapusBuku(id) {
    if (!confirm("Yakin ingin menghapus buku ini?")) return;

    const json = await apiRequest("DELETE", { id_buku: id });

    if (json.status === "success") {
        alert("Buku dihapus.");
        location.reload();
    } else alert("Gagal menghapus.");
}


/* ==========================
    GOOGLE BOOKS (DISIMPATKAN)
========================== */
async function searchGoogleBooks() {
    const q = input.search.value.trim();
    if (!q) return alert("Masukkan judul dulu ya senpai…");

    const url = `https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(q)}`;
    const res = await fetch(url);
    const data = await res.json();

    googleBox.innerHTML = "";
    googleBox.classList.remove("hidden");

    if (!data.items) {
        googleBox.innerHTML = `<p class='p-2 text-red-300'>Tidak ditemukan.</p>`;
        return;
    }

    data.items.slice(0, 10).forEach(item => {
        const info = item.volumeInfo;

        const title = info.title || "Tidak ada judul";
        const author = info.authors?.join(", ") || "-";
        const date = info.publishedDate || "2000-01-01";
        const thumb = info.imageLinks?.thumbnail || "";
        const category = info.categories?.[0] || "Umum";

        const div = document.createElement("div");
        div.className = "p-2 bg-gray-800/50 mb-2 cursor-pointer hover:bg-gray-700 rounded";
        div.innerHTML = `<b>${title}</b><br><small>${author}</small>`;

        div.onclick = () => {
            input.nama.value = title;
            input.jenis.value = category;
            input.tanggal.value = date.length >= 10 ? date : "2000-01-01";
            input.gambar.value = thumb;
            googleBox.classList.add("hidden");
        };

        googleBox.appendChild(div);
    });
}



</script>

</body>
</html>
