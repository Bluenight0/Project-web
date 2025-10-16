<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Perpustakaan Digital</title>

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <style>
      body {
        background-color: #f8f9fa;
      }
      .navbar-brand {
        font-weight: 600;
      }
      .hero {
        background: linear-gradient(135deg, #0052d4, #4364f7, #6fb1fc);
        color: white;
        padding: 100px 0;
        text-align: center;
      }
      .hero h1 {
        font-size: 3rem;
        font-weight: bold;
      }
      .hero p {
        font-size: 1.2rem;
        margin-top: 10px;
      }
      .footer {
        background: #343a40;
        color: white;
        text-align: center;
        padding: 15px;
        margin-top: 50px;
      }
    </style>
  </head>

  <body>
    <!-- 🌐 Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">📚 Perpustakaan UNRI</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div
          class="collapse navbar-collapse justify-content-end"
          id="navbarNav"
        >
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" href="#">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Koleksi Buku</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Tentang Kami</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login Admin</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- 🎨 Hero Section -->
    <section class="hero">
      <div class="container">
        <h1>Selamat Datang di Perpustakaan Digital UNRI</h1>
        <p>
          Akses ribuan koleksi buku, jurnal, dan e-resource kapan saja dan di
          mana saja.
        </p>
        <a href="#" class="btn btn-light mt-3">Jelajahi Koleksi</a>
      </div>
    </section>

    <!-- 📢 Popup Event Modal -->
    <div
      class="modal fade"
      id="eventModal"
      tabindex="-1"
      aria-labelledby="eventModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="eventModalLabel">
              🎉 Event Spesial Perpustakaan
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <p>
              Hai pembaca setia! 📖<br />
              Minggu ini kami mengadakan
              <strong>“Pekan Literasi Digital UNRI 2025”</strong> dengan berbagai
              lomba, seminar, dan pameran buku baru!  
              <br /><br />
              🗓️ Tanggal: 20–25 Oktober 2025<br />
              📍 Lokasi: Perpustakaan Pusat UNRI
            </p>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Tutup
            </button>
            <a href="#" class="btn btn-primary">Lihat Detail</a>
          </div>
        </div>
      </div>
    </div>

    <!-- 🧩 Footer -->
    <div class="footer">
      <p>© 2025 Perpustakaan Digital Universitas Riau</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- 🎬 Script agar popup muncul otomatis -->
    <script>
      window.addEventListener("load", function () {
        const eventModal = new bootstrap.Modal(
          document.getElementById("eventModal")
        );
        setTimeout(() => {
          eventModal.show();
        }, 800); // muncul setelah 0.8 detik
      });
    </script>
  </body>
</html>
