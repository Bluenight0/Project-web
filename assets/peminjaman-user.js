// =========================
//  PEMINJAMAN USER – FRONTEND
//  Terhubung ke backend via:
//    - ../back-end/crud/buku.php       (GET daftar buku)
//    - ../back-end/peminjaman.php      (GET/POST/PUT data peminjaman)
//    - ../back-end/user_sanksi.php     (GET status sanksi user)
// =========================

const bookList      = document.getElementById("bookList");
const loadingBooks  = document.getElementById("loadingBooks");
const searchInput   = document.getElementById("searchInput");
const loanTable     = document.getElementById("loanTable");
const sanksiBanner  = document.getElementById("sanksiBanner");
const sisaHariSpan  = document.getElementById("sisaHari");

// modal elemen
const modalDetail   = document.getElementById("modalDetail");
const modalImage    = document.getElementById("modalImage");
const modalNama     = document.getElementById("modalNama");
const modalJenis    = document.getElementById("modalJenis");
const modalTanggal  = document.getElementById("modalTanggal");
const modalStatus   = document.getElementById("modalStatus");
const modalDeskripsi= document.getElementById("modalDeskripsi");
const modalPinjamBtn= document.getElementById("modalPinjamBtn");

let semuaBuku   = [];
let peminjaman  = [];
let sedangDihukum = false;
let waktuHukum    = null;

// ambil user dari PHP (dipasang di peminjaman.php)
const CURRENT_USER_ID   = window.CURRENT_USER_ID;
const CURRENT_USER_NAME = window.CURRENT_USER_NAME || "user";

// ======================
//  HELPER TANGGAL
// ======================
function formatTanggalIndo(dateStr) {
  const d = new Date(dateStr);
  if (isNaN(d)) return dateStr || "-";

  const options = { day: "2-digit", month: "short", year: "numeric" };
  return d.toLocaleDateString("id-ID", options);
}

// ======================
//  LOAD BUKU
// ======================
async function loadBooks() {
  try {
    // BACKEND: ambil data buku dari PHP
    const res = await fetch("../back-end/crud/buku.php");
    const data = await res.json();

    semuaBuku = Array.isArray(data) ? data : [];
    renderBooks(semuaBuku);
    loadingBooks.style.display = "none";
  } catch (err) {
    console.error("Gagal load buku:", err);
    loadingBooks.textContent = "Gagal memuat data buku 😢";
  }
}

function renderBooks(books) {
  bookList.innerHTML = "";

  if (!Array.isArray(books) || books.length === 0) {
    bookList.innerHTML =
      `<p class="col-span-full text-center text-gray-300">Belum ada buku tersedia.</p>`;
    return;
  }

  books.forEach((book, i) => {
    const available = (book.status || "").toLowerCase() === "tersedia";

    const card = document.createElement("div");
    card.style.animation = `fadeInUp .4s ease ${i * 0.07}s both`;
    card.className =
      "bg-gray-700/40 backdrop-blur-lg border border-white/10 rounded-2xl p-4 shadow-xl flex flex-col transition transform hover:scale-[1.04] hover:bg-gray-700/55";

    card.innerHTML = `
      <div class="relative mb-3">
        <img src="${book.gambar || '../assets/default-book.jpg'}"
             alt="${book.nama || 'Buku'}"
             class="rounded-xl w-full h-48 object-cover shadow-md ${available ? '' : 'grayscale opacity-60'}">
        ${
          available
            ? `<span class="absolute top-2 right-2 bg-green-600/90 px-2 py-1 text-xs rounded-xl">Tersedia</span>`
            : `<span class="absolute top-2 right-2 bg-red-600/90 px-2 py-1 text-xs rounded-xl">Dipinjam</span>`
        }
      </div>

      <h2 class="text-lg font-semibold line-clamp-2">${book.nama || '-'}</h2>
      <p class="text-sm text-blue-200/90 mt-1">${book.jenis || 'Umum'}</p>
      <p class="text-xs text-gray-300 mt-1">Tanggal input: ${book.tanggal || '-'}</p>

      <div class="mt-4 flex gap-2">
        <button
          class="flex-1 bg-blue-600 hover:bg-blue-700 py-2 rounded-xl text-sm shadow font-semibold"
          data-role="detail"
          data-id="${book.id}">
          Detail
        </button>

        <button
          class="flex-1 ${available ? 'bg-emerald-500 hover:bg-emerald-600' : 'bg-gray-500 cursor-not-allowed'} py-2 rounded-xl text-sm shadow font-semibold"
          data-role="pinjam"
          data-id="${book.id}"
          ${available ? '' : 'disabled'}>
          Pinjam
        </button>
      </div>
    `;

    // event untuk tombol
    card.querySelector('[data-role="detail"]').addEventListener("click", () => {
      bukaDetailBuku(book);
    });

    const pinjamBtn = card.querySelector('[data-role="pinjam"]');
    if (available) {
      pinjamBtn.addEventListener("click", () => {
        pinjamBuku(book);
      });
    }

    bookList.appendChild(card);
  });
}

// ======================
//  MODAL DETAIL BUKU
// ======================
function bukaDetailBuku(book) {
  if (!book) return;

  modalNama.textContent   = book.nama || "-";
  modalJenis.textContent  = book.jenis || "Umum";
  modalTanggal.textContent= book.tanggal || "-";
  modalImage.src          = book.gambar || "../assets/default-book.jpg";

  const stat = (book.status || "").toLowerCase();
  modalStatus.textContent = book.status || "-";
  modalStatus.className   = "";
  modalStatus.classList.add(
    stat === "tersedia"    ? "text-emerald-400" :
    stat === "dipinjam"    ? "text-yellow-400" :
    "text-red-400"
  );

  modalDeskripsi.textContent =
    book.deskripsi && book.deskripsi.trim() !== ""
      ? book.deskripsi
      : "Belum ada catatan khusus untuk buku ini.";

  // tombol pinjam dalam modal
  modalPinjamBtn.onclick = () => {
    pinjamBuku(book);
  };

  modalDetail.classList.remove("hidden");
}

window.closeDetailModal = function () {
  modalDetail.classList.add("hidden");
};

// klik di luar modal untuk tutup
modalDetail?.addEventListener("click", (e) => {
  if (e.target === modalDetail) {
    closeDetailModal();
  }
});

// ======================
//  PINJAM BUKU
// ======================
async function pinjamBuku(book) {
  if (!book) return;

  if (!CURRENT_USER_ID) {
    alert("Kamu harus login sebagai anggota untuk meminjam buku.");
    return;
  }

  // cek sanksi aktif
  if (sedangDihukum && waktuHukum) {
    const now = new Date();
    const selisih = Math.floor((now - waktuHukum) / (1000 * 60 * 60 * 24));
    if (selisih < 3) {
      alert(`⚠️ Kamu masih dalam masa sanksi (${3 - selisih} hari tersisa).`);
      return;
    } else {
      sedangDihukum = false;
      waktuHukum = null;
      sanksiBanner.classList.add("hidden");
    }
  }

  const yakin = confirm(`Apakah kamu yakin ingin meminjam "${book.nama}"?`);
  if (!yakin) return;

  // batas waktu 3 hari dari hari ini (untuk tampilan frontend)
  const batas = new Date();
  batas.setDate(batas.getDate() + 3);

  // BACKEND: simpan peminjaman ke PHP
  try {
    const res = await fetch("../back-end/peminjaman.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        nama_buku:   book.nama,
        id_buku:     book.id,
        id_anggota:  CURRENT_USER_ID,
        nama_peminjam: CURRENT_USER_NAME
      }),
    });

    const result = await res.json();
    if (result.status === "success") {
      alert("✅ Buku berhasil dipinjam!");
      await loadPeminjaman();
      await loadBooks(); // refresh status buku
    } else {
      alert("❌ Gagal meminjam buku: " + (result.message || "Terjadi kesalahan."));
    }
  } catch (err) {
    console.error("Error pinjam:", err);
    alert("❌ Gagal menghubungi server peminjaman.");
  }
}

// ======================
//  LOAD PEMINJAMAN
// ======================
async function loadPeminjaman() {
  try {
    // BACKEND: ambil semua peminjaman
    const res = await fetch("../back-end/peminjaman.php");
    const data = await res.json();

    // filter berdasarkan user yang login
    peminjaman = Array.isArray(data)
      ? data.filter((d) =>
          String(d.id_anggota || d.nama_peminjam) === String(CURRENT_USER_ID || CURRENT_USER_NAME)
        )
      : [];

    renderTabel();
  } catch (err) {
    console.error("Gagal load peminjaman:", err);
  }
}

function renderTabel() {
  loanTable.innerHTML = "";

  if (!peminjaman.length) {
    loanTable.innerHTML = `
      <tr>
        <td colspan="5" class="px-4 py-3 text-center text-gray-300">
          Belum ada riwayat peminjaman.
        </td>
      </tr>`;
    return;
  }

  peminjaman.forEach((p) => {
    const tr = document.createElement("tr");

    const tglPinjam = p.tgl_pinjam || p.tanggal_pinjam || "";
    const batasHari = parseInt(p.batas_waktu || 3, 10);

    const mulai = new Date(tglPinjam);
    if (isNaN(mulai)) {
      // fallback: jika format dari backend tidak jelas
      mulai.setTime(Date.now());
    }
    const batas = new Date(mulai);
    batas.setDate(mulai.getDate() + batasHari);

    let terlambat = false;
    const now = new Date();
    if (now > batas && p.status === "Dipinjam") {
      terlambat = true;
    }

    // jika terlambat → update status dan sanksi
    if (terlambat) {
      updateStatus(p.id, "Terlambat");
      sedangDihukum = true;
      waktuHukum = new Date(); // bisa diganti data dari backend kalau disimpan
      tampilkanSanksi();
    }

    const statusClass =
      p.status === "Dikembalikan"
        ? "text-emerald-400"
        : terlambat
        ? "text-red-400"
        : "text-yellow-300";

    tr.innerHTML = `
      <td class="px-4 py-2">${p.nama_buku || "-"}</td>
      <td class="px-4 py-2">${formatTanggalIndo(tglPinjam)}</td>
      <td class="px-4 py-2">${formatTanggalIndo(batas.toISOString())}</td>
      <td class="px-4 py-2 font-semibold ${statusClass}">${terlambat ? "Terlambat" : p.status}</td>
      <td class="px-4 py-2">
        ${
          p.status === "Dipinjam"
            ? `<button class="bg-emerald-500 hover:bg-emerald-600 px-3 py-1 rounded-xl text-white text-xs sm:text-sm"
                       data-aksi="kembalikan"
                       data-id="${p.id}">
                 Kembalikan
               </button>`
            : "-"
        }
      </td>
    `;

    const btn = tr.querySelector("[data-aksi='kembalikan']");
    if (btn) {
      btn.addEventListener("click", () => kembalikanBuku(p.id));
    }

    loanTable.appendChild(tr);
  });
}

// ======================
//  KEMBALIKAN BUKU
// ======================
async function kembalikanBuku(id) {
  const yakin = confirm("Kembalikan buku ini sekarang?");
  if (!yakin) return;

  try {
    // BACKEND: update status jadi Dikembalikan
    const res = await fetch("../back-end/peminjaman.php", {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id, status: "Dikembalikan" }),
    });

    const result = await res.json();
    if (result.status === "success") {
      alert("✅ Buku berhasil dikembalikan!");
      await loadPeminjaman();
      await loadBooks();
    } else {
      alert("❌ Gagal mengembalikan buku.");
    }
  } catch (err) {
    console.error("Error kembalikan:", err);
    alert("❌ Gagal menghubungi server.");
  }
}

// ======================
//  UPDATE STATUS (TERLAMBAT)
// ======================
async function updateStatus(id, status) {
  try {
    await fetch("../back-end/peminjaman.php", {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id, status }),
    });
  } catch (err) {
    console.error("Gagal update status:", err);
  }
}

// ======================
//  SANKSI USER
// ======================
function tampilkanSanksi() {
  if (!waktuHukum) return;

  sanksiBanner.classList.remove("hidden");
  const now = new Date();
  const selisih = Math.floor((now - waktuHukum) / (1000 * 60 * 60 * 24));
  const sisa = Math.max(0, 3 - selisih);
  sisaHariSpan.textContent = sisa;

  if (sisa <= 0) {
    sanksiBanner.classList.add("hidden");
    sedangDihukum = false;
    waktuHukum = null;
  } else {
    // update per jam
    setTimeout(tampilkanSanksi, 1000 * 60 * 60);
  }
}

async function cekSanksiUser() {
  if (!CURRENT_USER_ID) return;

  try {
    // BACKEND: cek status sanksi user
    const res = await fetch("../back-end/user_sanksi.php?user=" + encodeURIComponent(CURRENT_USER_ID));
    const data = await res.json();

    if (data && Number(data.sanksi_aktif) === 1) {
      sedangDihukum = true;
      waktuHukum = new Date(data.sanksi_mulai);
      tampilkanSanksi();
    }
  } catch (err) {
    console.error("Gagal cek sanksi:", err);
  }
}

// ======================
//  SEARCH
// ======================
searchInput?.addEventListener("input", (e) => {
  const keyword = e.target.value.toLowerCase();
  const filtered = semuaBuku.filter((b) =>
    (b.nama || "").toLowerCase().includes(keyword)
  );
  renderBooks(filtered);
});

// ======================
//  INIT
// ======================
document.addEventListener("DOMContentLoaded", () => {
  cekSanksiUser();
  loadBooks();
  loadPeminjaman();
});
