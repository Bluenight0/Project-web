const eventList = document.getElementById("event-list");

const totalEvt = document.getElementById("totalEvt");
const upcomingEvt = document.getElementById("upcomingEvt");
const activeEvt = document.getElementById("activeEvt");

const eventModal = document.getElementById("eventModal");
const closeModal = document.getElementById("closeModal");

let eventData = [];

// ========================
// LOAD EVENT
// ========================
async function loadEvents() {
  eventList.innerHTML =
    "<p class='text-gray-300 col-span-full text-center'>Memuat event...</p>";
  try {
    const res = await fetch("../back-end/crud/event.php");
    if (!res.ok) throw new Error("Server error");

    let events;
    try {
      events = await res.json();
    } catch {
      throw new Error("Response bukan JSON");
    }

    eventData = events;
    eventList.innerHTML = "";

    if (!Array.isArray(events) || events.length === 0) {
      eventList.innerHTML =
        "<p class='text-gray-200 col-span-full text-center'>Belum ada event.</p>";
      return;
    }

    updateStats(events);

    events.forEach((ev, i) => {
      const now = new Date();
      const mulai = new Date(ev.tanggal_mulai);
      const diffDays = Math.ceil((mulai - now) / (1000 * 60 * 60 * 24));

      let badge =
        `<span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-semibold ${
          diffDays < 0
            ? "bg-red-600/90"
            : diffDays === 0
            ? "bg-yellow-500/90"
            : "bg-blue-600/90"
        }">` +
        (diffDays < 0
          ? "Selesai"
          : diffDays === 0
          ? "Hari Ini"
          : diffDays + " hari lagi") +
        "</span>";

      const div = document.createElement("div");
      div.style.animation = `fadeInUp .5s ease ${i * 0.06}s both`;
      div.className =
        "bg-gray-700/40 backdrop-blur-lg border border-white/10 rounded-2xl p-5 shadow-xl relative hover:scale-[1.04] transition";

      div.innerHTML = `
        ${badge}
        ${
          ev.gambar
            ? `
            <img src="../back-end/uploads/${ev.gambar}" 
                class="w-full h-40 object-cover rounded-xl mb-3">
            `
            : ""
        }

        <h2 class="text-xl font-semibold mb-2 mt-5">${ev.judul}</h2>

        <p class="text-sm text-gray-200/80 mb-1">
          <span class="font-semibold text-gray-100">Tanggal:</span> 
          ${ev.tanggal_mulai} – ${ev.tanggal_selesai}
        </p>

        <p class="text-sm text-gray-200/80">
          <span class="font-semibold text-gray-100">Lokasi:</span> ${ev.lokasi}
        </p>

        <button 
          onclick="openModal(${ev.id_event})"
          class="mt-4 bg-blue-600 hover:bg-blue-700 px-4 py-2 w-full rounded-xl shadow">
          Lihat Detail
        </button>
      `;

      eventList.appendChild(div);
    });
  } catch (err) {
    console.error(err);
    eventList.innerHTML =
      "<p class='text-red-400 col-span-full text-center'>Gagal memuat data event.</p>";
  }
}

// ========================
// UPDATE STATISTIK
// ========================
function updateStats(events) {
  totalEvt.textContent = events.length;

  const now = new Date();
  let upcoming = 0;
  let active = 0;

  events.forEach((e) => {
    const mulai = new Date(e.tanggal_mulai);
    const selesai = new Date(e.tanggal_selesai);

    if (mulai > now) upcoming++;
    if (mulai <= now && selesai >= now) active++;
  });

  upcomingEvt.textContent = upcoming;
  activeEvt.textContent = active;
}

// ========================
// MODAL DETAIL
// ========================
function openModal(id_event) {
  const ev = eventData.find((e) => e.id_event == id_event);
  if (!ev) {
    alert("Event tidak ditemukan.");
    return;
  }

  document.getElementById("modalNama").textContent = ev.judul;

  document.getElementById("modalGambar").src =
    "../back-end/uploads/" + ev.gambar;

  document.getElementById("modalTanggal").textContent =
    "Tanggal: " + ev.tanggal_mulai + " – " + ev.tanggal_selesai;
  document.getElementById("modalLokasi").textContent = "Lokasi: " + ev.lokasi;

  document.getElementById("modalIkut").onclick = () =>
    verifikasiIkut(ev.id_event);

  eventModal.classList.remove("hidden");
}

closeModal.onclick = () => eventModal.classList.add("hidden");
eventModal.onclick = (e) => {
  if (e.target === eventModal) eventModal.classList.add("hidden");
};

// ========================
// IKUTI EVENT
// ========================
async function verifikasiIkut(id_event) {
  const confirmText = prompt("Ketik 'ikut' untuk mengkonfirmasi:");
  if (!confirmText || confirmText.toLowerCase() !== "ikut") return;

  try {
    const res = await fetch("../back-end/peserta-event.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ event_id: id_event }),
    });
    if (!res.ok) throw new Error("Gagal mengirim request");
    const result = await res.json();

    if (result.status === "success") {
      alert("Berhasil mengikuti event!");
      loadEvents();
    } else if (result.status === "exists") {
      alert("Kamu sudah mengikuti event ini.");
    } else {
      alert("Terjadi kesalahan: " + (result.message || "unknown error"));
    }
  } catch (err) {
    alert("Gagal mengirim data.");
  }
}

loadEvents();
