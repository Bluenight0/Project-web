const eventList = document.getElementById("event-list");

    const totalEvt = document.getElementById("totalEvt");
    const upcomingEvt = document.getElementById("upcomingEvt");
    const activeEvt = document.getElementById("activeEvt");

    const eventModal = document.getElementById("eventModal");
    const closeModal = document.getElementById("closeModal");

    let eventData = [];

    // LOAD EVENT
    async function loadEvents() {
      try {
        const res = await fetch("../back-end/crud/event.php");
        const events = await res.json();

        eventData = events;
        eventList.innerHTML = "";

        if (!Array.isArray(events) || events.length === 0) {
          eventList.innerHTML = "<p class='text-gray-200 col-span-full text-center'>Belum ada event.</p>";
          return;
        }

        updateStats(events);

        events.forEach((event, index) => {
          const now = new Date();
          const tanggal = new Date(event.tanggal);
          const hari = Math.ceil((tanggal - now) / (1000 * 60 * 60 * 24));

          let badge = `
            <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-semibold
              ${hari < 0 ? 'bg-red-600/90' :
                hari === 0 ? 'bg-yellow-500/90' : 'bg-blue-600/90'}">
              ${hari < 0 ? 'Selesai' : hari === 0 ? 'Hari Ini' : hari + ' hari lagi'}
            </span>`;

          const div = document.createElement("div");
          div.style.animation = `fadeInUp .5s ease ${index * 0.08}s both`;
          div.className =
            "bg-gray-700/40 backdrop-blur-lg border border-white/10 rounded-2xl p-5 shadow-xl relative flex flex-col justify-between hover:scale-[1.04] transition";

          div.innerHTML = `
            ${badge}
            <h2 class="text-xl font-semibold mb-2">${event.nama}</h2>

            <p class="text-sm text-gray-200/80 mb-1">
              <span class="font-semibold text-gray-100">Tanggal:</span> ${event.tanggal}
            </p>

            <p class="text-sm text-gray-200/80">
              <span class="font-semibold text-gray-100">Lokasi:</span> ${event.lokasi}
            </p>

            <button class="mt-4 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl shadow detail-btn"
              onclick="openModal(${event.id})">
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

    // UPDATE STATISTIK
    function updateStats(events) {
      totalEvt.textContent = events.length;

      const now = new Date();
      let upcoming = 0;
      let active = 0;

      events.forEach(e => {
        const tgl = new Date(e.tanggal);
        if (tgl > now) upcoming++;
        if (tgl.toDateString() === now.toDateString()) active++;
      });

      upcomingEvt.textContent = upcoming;
      activeEvt.textContent = active;
    }

    // MODAL DETAIL
    function openModal(id) {
      const event = eventData.find(e => e.id == id);
      document.getElementById("modalNama").textContent = event.nama;
      document.getElementById("modalTanggal").textContent = "Tanggal: " + event.tanggal;
      document.getElementById("modalLokasi").textContent = "Lokasi: " + event.lokasi;

      document.getElementById("modalIkut").onclick = () => verifikasiIkut(event.id);

      eventModal.classList.remove("hidden");
    }

    function closeModalFunc() {
      eventModal.classList.add("hidden");
    }

    closeModal.addEventListener("click", closeModalFunc);
    eventModal.addEventListener("click", (e) => {
      if (e.target === eventModal) closeModalFunc();
    });

    // IKUTI EVENT
    async function verifikasiIkut(eventId) {
      const confirmText = prompt("Ketik 'ikut' untuk konfirmasi:");
      if (!confirmText) return;
      if (confirmText.toLowerCase() !== "ikut") {
        alert("Konfirmasi salah.");
        return;
      }

      try {
        const res = await fetch("../back-end/peserta_event.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ event_id: eventId }),
        });

        const result = await res.json();

        if (result.status === "success") {
          alert("Kamu berhasil mengikuti event!");
          loadEvents();
        } else if (result.status === "exists") {
          alert("Kamu sudah mengikuti event ini.");
        } else {
          alert("Terjadi kesalahan.");
        }
      } catch (err) {
        alert("Gagal mengirim data.");
      }
    }

    loadEvents();