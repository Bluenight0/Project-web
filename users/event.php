<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <title>Event | Perpustakaan</title>
</head>
<body class="bg-gradient-to-b from-gray-700 via-gray-600 to-gray-500 min-h-screen font-sans">

 <?php
  include '../layout/header_user.html';
  ?>

  <!-- Main -->
  <main class="pt-28 px-6 sm:px-12">
    <h1 class="text-3xl sm:text-4xl font-bold text-white mb-8 text-center sm:text-left drop-shadow-lg">
      Event Perpustakaan
    </h1>

    <div id="event-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"></div>
  </main>

  <script>
    const eventList = document.getElementById("event-list");

    async function loadEvents() {
      try {
        const res = await fetch("../back-end/event.php");
        const events = await res.json();

        eventList.innerHTML = "";

        if (!Array.isArray(events) || events.length === 0) {
          eventList.innerHTML =
            "<p class='text-white text-center col-span-full'>Belum ada event tersedia.</p>";
          return;
        }

        events.forEach(event => {
          const div = document.createElement("div");
          div.className =
            "bg-white/10 backdrop-blur-md rounded-2xl p-6 text-white shadow-lg flex flex-col justify-between transition transform hover:scale-105 hover:shadow-2xl";

          let ikutButton = event.ikut ? 
            `<button class="bg-gray-500 cursor-not-allowed text-white px-4 py-2 rounded-xl shadow mt-4" disabled>Sudah Ikut</button>` :
            `<button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl shadow mt-4" onclick="verifikasiIkut(${event.id})">Ikuti</button>`;

          div.innerHTML = `
            <div>
              <h2 class="text-xl font-semibold mb-1">${event.nama}</h2>
              <p class="text-sm text-white/70 mb-1"><strong>Lokasi:</strong> ${event.lokasi}</p>
              <p class="text-sm text-white/70"><strong>Tanggal:</strong> ${event.tanggal}</p>
            </div>
            ${ikutButton}
          `;
          eventList.appendChild(div);
        });
      } catch (err) {
        console.error("Gagal mengambil event:", err);
        eventList.innerHTML =
          "<p class='text-red-400 col-span-full text-center'>Gagal memuat data event.</p>";
      }
    }

    async function verifikasiIkut(eventId) {
      const konfirmasi = prompt("Ketik 'ikut' untuk konfirmasi mengikuti event ini:");
      if (!konfirmasi) return;
      if (konfirmasi.toLowerCase() !== "ikut") {
        alert("❌ Konfirmasi salah. Ketik 'ikut' untuk lanjut.");
        return;
      }

      try {
        const res = await fetch("../back-end/peserta_event.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ event_id: eventId })
        });
        const result = await res.json();

        if (result.status === "success") {
          alert("✅ Kamu berhasil mengikuti event!");
          loadEvents(); // refresh tombol
        } else if (result.status === "exists") {
          alert("⚠️ Kamu sudah mengikuti event ini sebelumnya.");
        } else {
          alert("❌ Terjadi kesalahan: " + (result.message || "Gagal."));
        }
      } catch (err) {
        console.error("Error:", err);
        alert("❌ Gagal mengirim data ke server.");
      }
    }

    loadEvents();
  </script>

</body>
</html>
