 // ============================
    // 1. STATE & ELEMEN DOM
    // ============================
    let allBooks = []; // menyimpan semua data buku dari backend
    let currentFilter = "all";

    const grid = document.getElementById("bookGrid");
    const loading = document.getElementById("loading");
    const searchInput = document.getElementById("searchInput");

    const statTotal = document.getElementById("statTotal");
    const statAvailable = document.getElementById("statAvailable");
    const statBorrowed = document.getElementById("statBorrowed");

    // Modal
    const detailModal = document.getElementById("detailModal");
    const closeModalBtn = document.getElementById("closeModal");
    const modalImage = document.getElementById("modalImage");
    const modalTitle = document.getElementById("modalTitle");
    const modalCategory = document.getElementById("modalCategory");
    const modalDate = document.getElementById("modalDate");
    const modalStatusBadge = document.getElementById("modalStatusBadge");

    // ============================
    // 2. LOAD DATA DARI BACKEND
    // ============================
    async function loadBooks() {
      try {
        // TERHUBUNG KE BACKEND: ambil data dari ../back-end/crud/buku.php
        const response = await fetch("../back-end/crud/buku.php");
        const data = await response.json();

        allBooks = Array.isArray(data) ? data : [];

        loading.style.display = "none";
        updateStats();
        renderBooks();
      } catch (err) {
        console.error(err);
        loading.textContent = "Gagal memuat data buku 😢";
      }
    }

    // ============================
    // 3. HITUNG STATISTIK
    // ============================
    function updateStats() {
      const total = allBooks.length;
      const available = allBooks.filter(b => b.status && b.status.toLowerCase() === "tersedia").length;
      const borrowed = total - available;

      statTotal.textContent = total;
      statAvailable.textContent = available;
      statBorrowed.textContent = borrowed;
    }

    // ============================
    // 4. RENDER BUKU SESUAI FILTER & SEARCH
    // ============================
    function renderBooks() {
      grid.innerHTML = "";

      const keyword = searchInput.value.toLowerCase();

      const filtered = allBooks.filter((book) => {
        const nama = (book.nama || "").toLowerCase();
        const jenis = (book.jenis || "").toLowerCase();

        const matchText = nama.includes(keyword) || jenis.includes(keyword);
        const matchFilter = currentFilter === "all"
          ? true
          : (book.jenis && book.jenis.toLowerCase() === currentFilter.toLowerCase());

        return matchText && matchFilter;
      });

      if (filtered.length === 0) {
        grid.innerHTML =
          `<p class='col-span-full text-center text-gray-300'>Buku tidak ditemukan. Coba kata kunci lain.</p>`;
        return;
      }

      filtered.forEach((book, i) => {
        const available = book.status && book.status.toLowerCase() === "tersedia";

        const card = document.createElement("div");
        card.style.animation = `fadeInUp .4s ease ${i * 0.06}s both`;

        card.className =
          "bg-gray-700/40 backdrop-blur-lg border border-white/10 rounded-2xl p-4 shadow-xl flex flex-col transition transform hover:scale-[1.04] hover:bg-gray-700/60";

        const coverSrc = book.gambar && book.gambar.trim() !== ""
          ? book.gambar
          : "../assets/default-book.jpg";

        card.innerHTML = `
          <div class="relative mb-3">
            <img src="${coverSrc}"
                 alt="${book.nama || 'Buku'}"
                 class="rounded-xl w-full h-48 object-cover shadow-md ${available ? '' : 'grayscale opacity-60'}">

            ${available
              ? `<span class="absolute top-2 right-2 bg-emerald-600/90 px-2 py-1 text-[11px] rounded-xl shadow">Tersedia</span>`
              : `<span class="absolute top-2 right-2 bg-red-600/90 px-2 py-1 text-[11px] rounded-xl shadow">Dipinjam</span>`
            }
          </div>

          <h2 class="text-lg font-semibold line-clamp-2">${book.nama || 'Tanpa Judul'}</h2>
          <p class="text-sm text-blue-200/90 mt-1">${book.jenis || 'Tanpa Kategori'}</p>
          <p class="text-xs text-gray-300 mt-1">
            Tanggal: ${book.tanggal || '-'}
          </p>

          <button class="mt-4 bg-blue-600 hover:bg-blue-700 py-2 rounded-xl text-sm shadow w-full detail-btn">
            Lihat Detail
          </button>
        `;

        // Tambahkan event untuk tombol "Lihat Detail"
        const detailBtn = card.querySelector(".detail-btn");
        detailBtn.addEventListener("click", () => openDetailModal(book));

        grid.appendChild(card);
      });
    }

    // ============================
    // 5. MODAL DETAIL BUKU
    // ============================
    function openDetailModal(book) {
      const available = book.status && book.status.toLowerCase() === "tersedia";
      const coverSrc = book.gambar && book.gambar.trim() !== ""
        ? book.gambar
        : "../assets/default-book.jpg";

      modalImage.src = coverSrc;
      modalTitle.textContent = book.nama || "Tanpa Judul";
      modalCategory.textContent = book.jenis ? `Kategori: ${book.jenis}` : "Kategori: -";
      modalDate.textContent = book.tanggal ? `Tanggal rilis: ${book.tanggal}` : "";
      modalStatusBadge.textContent = available ? "Tersedia" : "Sedang Dipinjam";
      modalStatusBadge.className =
        "inline-block mt-2 px-3 py-1 rounded-full text-xs font-semibold " +
        (available ? "bg-emerald-600/90" : "bg-red-600/90");

      detailModal.classList.remove("hidden");
    }

    function closeDetailModal() {
      detailModal.classList.add("hidden");
    }

    closeModalBtn.addEventListener("click", closeDetailModal);
    detailModal.addEventListener("click", (e) => {
      if (e.target === detailModal) closeDetailModal();
    });

    // ============================
    // 6. EVENT: SEARCH & FILTER
    // ============================
    searchInput.addEventListener("input", () => {
      renderBooks();
    });

    document.querySelectorAll(".filter-pill").forEach((btn) => {
      btn.addEventListener("click", () => {
        document.querySelectorAll(".filter-pill").forEach(b => {
          b.classList.remove("bg-blue-500/80", "text-white");
          b.classList.add("bg-white/10", "border", "border-white/10");
        });

        btn.classList.remove("bg-white/10", "border", "border-white/10");
        btn.classList.add("bg-blue-500/80", "text-white");

        currentFilter = btn.getAttribute("data-filter");
        renderBooks();
      });
    });

    // ============================
    // 7. INIT
    // ============================
    loadBooks();