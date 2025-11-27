const bookGrid = document.getElementById("bookGrid");
const loading = document.getElementById("loading");

const searchInput = document.getElementById("searchInput");
const filterButtons = document.querySelectorAll(".filter-pill");

// modal
const detailModal = document.getElementById("detailModal");
const modalImage = document.getElementById("modalImage");
const modalTitle = document.getElementById("modalTitle");
const modalCategory = document.getElementById("modalCategory");
const modalDate = document.getElementById("modalDate");
const modalStatusBadge = document.getElementById("modalStatusBadge");
const modalDescription = document.getElementById("modalDescription");
const readNowBtn = document.getElementById("readNowBtn");

let books = [];
let activeFilter = "all";

// =============================
// Ambil data dari database
// =============================
async function loadBooks() {
    const res = await fetch("../back-end/crud/buku.php");
    books = await res.json();

    loading.classList.add("hidden");
    renderBooks();
    updateStats();
}

// =============================
// Render Buku
// =============================
function renderBooks() {
    let filtered = books;

    // FILTER CATEGORY
    if (activeFilter !== "all") {
        filtered = filtered.filter(b => b.jenis === activeFilter);
    }

    // SEARCH
    const q = searchInput.value.toLowerCase();
    if (q) {
        filtered = filtered.filter(b => b.nama.toLowerCase().includes(q));
    }

    // Render card grid
    bookGrid.innerHTML = filtered.map(b => `
        <div class="bg-gray-800/70 border border-white/10 rounded-xl p-4 shadow-lg hover:shadow-xl transition cursor-pointer"
             onclick='openDetail(${JSON.stringify(b)})'
             style="animation: fadeInUp .3s ease">
             
            <img src="${b.gambar || '../assets/default-book.jpg'}"
                 class="w-full h-48 object-cover rounded-lg shadow mb-3">

            <h3 class="font-semibold text-lg text-white truncate">${b.nama}</h3>
            <p class="text-blue-300 text-sm">${b.jenis}</p>
            <p class="text-gray-400 text-xs">${b.tanggal}</p>

            <span class="inline-block mt-2 px-3 py-1 text-xs rounded-full
                         ${b.status === 'Tersedia' ? 'bg-emerald-600' : 'bg-red-600'}">
                ${b.status}
            </span>

        </div>
    `).join("");
}

// =============================
// Open Modal Detail
// =============================
function openDetail(b) {

    modalTitle.textContent = b.nama;
    modalCategory.textContent = b.jenis;
    modalDate.textContent = b.tanggal;
    modalDescription.textContent = "Buku elektronik tersedia untuk dibaca.";

    modalImage.src = b.gambar || "../assets/default-book.jpg";

    modalStatusBadge.textContent = b.status;
    modalStatusBadge.className =
        `inline-block px-3 py-1 rounded-full text-xs font-semibold 
         ${b.status === 'Tersedia' ? 'bg-emerald-600/90' : 'bg-red-600/90'}`;

    detailModal.classList.remove("hidden");

    // TOMBOL BACA SEKARANG
    if (b.file_pdf) {
        readNowBtn.onclick = () => {
            window.open("../" + b.file_pdf, "_blank");
        };
        readNowBtn.disabled = false;
    } else {
        readNowBtn.onclick = null;
        readNowBtn.disabled = true;
    }
}

// Close modal
document.getElementById("closeModal").onclick = () => {
    detailModal.classList.add("hidden");
};

// =============================
// Update Statistik
// =============================
function updateStats() {
    document.getElementById("statTotal").textContent = books.length;
    document.getElementById("statAvailable").textContent =
        books.filter(b => b.status === "Tersedia").length;

    // ❗ Ebook tidak punya sedang dipinjam → hapus statBorrowed
}

// =============================
// Filter Buttons
// =============================
filterButtons.forEach(btn => {
    btn.onclick = () => {
        filterButtons.forEach(b => b.classList.remove("bg-blue-500"));
        btn.classList.add("bg-blue-500");
        activeFilter = btn.dataset.filter;
        renderBooks();
    };
});

// Search
searchInput.addEventListener("input", renderBooks);

// Load awal
loadBooks();
