// =========================
// ELEMENT DOM
// =========================
const bookList      = document.getElementById("bookList");
const loadingBooks  = document.getElementById("loadingBooks");
const searchInput   = document.getElementById("searchInput");
const loanTable     = document.getElementById("loanTable");
const sanksiBanner  = document.getElementById("sanksiBanner");
const sisaHariSpan  = document.getElementById("sisaHari");

// modal detail
const modalDetail   = document.getElementById("modalDetail");
const modalImage    = document.getElementById("modalImage");
const modalNama     = document.getElementById("modalNama");
const modalJenis    = document.getElementById("modalJenis");
const modalTanggal  = document.getElementById("modalTanggal");
const modalStatus   = document.getElementById("modalStatus");
const modalDeskripsi= document.getElementById("modalDeskripsi");
const modalPinjamBtn= document.getElementById("modalPinjamBtn");

// USER dari PHP
const CURRENT_USER_ID   = window.CURRENT_USER_ID;
const CURRENT_USER_NAME = window.CURRENT_USER_NAME;

let semuaBuku   = [];
let peminjaman  = [];

// =======================
// FORMAT TANGGAL
// =======================
function formatTanggal(dateStr) {
  const d = new Date(dateStr);
  if (isNaN(d)) return "-";

  return d.toLocaleDateString("id-ID", {
    day: "2-digit",
    month: "short",
    year: "numeric"
  });
}

// =======================
// LOAD BUKU
// =======================
async function loadBooks() {
  try {
    const res = await fetch("../back-end/crud/buku.php");
    const data = await res.json();

    semuaBuku = Array.isArray(data) ? data : [];
    renderBooks(semuaBuku);

    loadingBooks.style.display = "none";
  } catch (err) {
    loadingBooks.textContent = "Gagal memuat buku.";
  }
}

function renderBooks(books) {
  bookList.innerHTML = "";

  if (!books.length) {
    bookList.innerHTML = `<p class='text-center text-gray-300 col-span-full'>Tidak ada buku ditemukan.</p>`;
    return;
  }

  books.forEach((book, i) => {
    const tersedia = (book.status || "").toLowerCase() === "tersedia";

    const card = document.createElement("div");
    card.style.animation = `fadeInUp .3s ease ${i * 0.05}s both`;
    card.className = "bg-gray-700/40 p-4 rounded-2xl shadow-xl border border-white/10";

    card.innerHTML = `
      <div class="relative mb-3">
        <img src="${book.gambar || '../assets/default-book.jpg'}"
             class="w-full h-48 object-cover rounded-xl ${tersedia ? '' : 'grayscale opacity-60'}">

        ${
          tersedia
            ? `<span class="absolute top-2 right-2 bg-green-600/90 text-xs px-2 py-1 rounded-lg">Tersedia</span>`
            : `<span class="absolute top-2 right-2 bg-red-600/90 text-xs px-2 py-1 rounded-lg">Dipinjam</span>`
        }
      </div>

      <h2 class="font-bold text-lg">${book.nama}</h2>
      <p class="text-sm text-blue-200">${book.jenis}</p>
      <p class="text-xs text-gray-300">Tanggal input: ${book.tanggal}</p>

      <div class="mt-3 flex gap-2">
        <button class="flex-1 bg-blue-600 py-2 rounded-xl hover:bg-blue-700 text-sm"
                data-detail="${book.id_buku}">
          Detail
        </button>

        <button class="flex-1 ${tersedia ? 'bg-emerald-500 hover:bg-emerald-600' : 'bg-gray-500 cursor-not-allowed'} py-2 rounded-xl text-sm"
                ${tersedia ? '' : 'disabled'}
                data-pinjam="${book.id_buku}">
          Pinjam
        </button>
      </div>
    `;

    // event tombol
    card.querySelector("[data-detail]").onclick = () =>
      bukaDetail(book);
    if (tersedia)
      card.querySelector("[data-pinjam]").onclick = () =>
        pinjamBuku(book);

    bookList.appendChild(card);
  });
}

// =======================
// MODAL DETAIL
// =======================
function bukaDetail(book) {
  modalNama.textContent = book.nama;
  modalJenis.textContent = book.jenis;
  modalTanggal.textContent = book.tanggal;
  modalImage.src = book.gambar;

  modalDeskripsi.textContent = "Belum ada deskripsi";
  modalStatus.textContent = book.status;

  modalPinjamBtn.onclick = () => pinjamBuku(book);

  modalDetail.classList.remove("hidden");
}

window.closeDetailModal = function () {
  modalDetail.classList.add("hidden");
};
modalDetail.addEventListener("click", (e) => {
  if (e.target === modalDetail) closeDetailModal();
});

// =======================
// PINJAM BUKU
// =======================
async function pinjamBuku(book) {
  if (!CURRENT_USER_ID) {
    alert("Anda harus login untuk meminjam.");
    return;
  }

  if (!confirm(`Yakin ingin meminjam "${book.nama}"?`)) return;

  try {
    const res = await fetch("../back-end/peminjaman.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        id_buku: book.id_buku,
        nama_buku: book.nama,
        id_anggota: CURRENT_USER_ID,
        nama_peminjam: CURRENT_USER_NAME
      })
    });

    const result = await res.json();
    if (result.status === "success") {
      alert("Berhasil meminjam!");
      loadBooks();
      loadPeminjaman();
    } else {
      alert("Gagal meminjam.");
    }
  } catch (err) {
    alert("Server error.");
  }
}

// =======================
// LOAD PEMINJAMAN
// =======================
async function loadPeminjaman() {
  try {
    const res = await fetch("../back-end/peminjaman.php");
    const data = await res.json();

    peminjaman = data.filter(
      (p) => Number(p.id_anggota) === Number(CURRENT_USER_ID)
    );

    renderTable();
  } catch (err) {
    console.error(err);
  }
}

// =======================
// RENDER TABLE + QR CODE
// =======================
function renderTable() {
  loanTable.innerHTML = "";

  if (!peminjaman.length) {
    loanTable.innerHTML = `
      <tr><td colspan="6" class="text-center py-4">Belum ada peminjaman</td></tr>
    `;
    return;
  }

  peminjaman.forEach((p) => {
    const tglPinjam = p.tgl_pinjam;
    const batas = new Date(tglPinjam);
    batas.setDate(batas.getDate() + Number(p.batas_waktu));

    const tr = document.createElement("tr");

    tr.innerHTML = `
      <td class="px-3 py-2">${p.nama_buku}</td>
      <td class="px-3 py-2">${formatTanggal(tglPinjam)}</td>
      <td class="px-3 py-2">${formatTanggal(batas)}</td>
      <td class="px-3 py-2 font-semibold ${
        p.status === "Dikembalikan"
          ? "text-green-400"
          : p.status === "Dipinjam"
          ? "text-yellow-300"
          : "text-red-400"
      }">
        ${p.status}
      </td>

      <td class="px-3 py-2">
        ${
          p.status === "Dipinjam"
            ? `<button class="bg-emerald-500 px-3 py-1 rounded-xl text-white text-xs hover:bg-emerald-600"
                       onclick="kembalikan(${p.id})">
                 Kembalikan
               </button>`
            : "-"
        }
      </td>

      <td class="px-3 py-2">
        <div id="qr-${p.id}" class="bg-white rounded p-1 inline-block"></div>
      </td>
    `;

    loanTable.appendChild(tr);

    // === QR CODE ===
    const qrData = `
ID=${p.id}
BUKU=${p.nama_buku}
USER=${p.nama_peminjam}
PINJAM=${p.tgl_pinjam}
BATAS=${formatTanggal(batas)}
STATUS=${p.status}
`.trim();

    new QRCode(document.getElementById(`qr-${p.id}`), {
      text: qrData,
      width: 90,
      height: 90
    });
  });
}

// =======================
// KEMBALIKAN BUKU
// =======================
async function kembalikan(id) {
  if (!confirm("Kembalikan buku ini?")) return;

  await fetch("../back-end/peminjaman.php", {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id, status: "Dikembalikan" })
  });

  loadBooks();
  loadPeminjaman();
}

// =======================
// INITIAL LOAD
// =======================
document.addEventListener("DOMContentLoaded", () => {
  loadBooks();
  loadPeminjaman();
});
