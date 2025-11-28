<?php
include 'back-end/koneksi.php';

$tanggalHariIni = date("Y-m-d");

// Ambil event aktif berdasarkan tanggal hari ini
$query = "SELECT * FROM event_perpus 
          WHERE '$tanggalHariIni' BETWEEN tanggal_mulai AND tanggal_selesai";
$result = mysqli_query($koneksi, $query);
$event = mysqli_fetch_assoc($result);
?>




<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Perpustakaan PEKANBARU</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- AOS CSS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
  <style>
    .service-card {
      border-radius: 1.5rem;
      background: #ffffff;
      transition: 0.3s ease;
    }

    .service-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 18px 35px rgba(0, 0, 0, 0.08);
    }

    .icon-circle {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background: #f1f5f9;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #0d6efd;
    }
  </style>


</head>

<body>
  <!-- 🌐 Navbar -->
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">

    <!-- Brand (menjorok ke tengah sedikit) -->
    <a class="navbar-brand" href="#" style="padding-left: 100px; font-weight: 600;">
      PERPUSTAKAAN PEKANBARU
    </a>

    <!-- Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

      <!-- MENU UTAMA (juga menjorok ke tengah) -->
      <ul class="navbar-nav ms-auto fs-7 fw-semibold" style="padding-left: 600px;">
        <li class="nav-item"><a class="nav-link" href="#koleksi-buku">Koleksi Buku</a></li>
        <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
        <li class="nav-item"><a class="nav-link" href="#sejarah">Sejarah</a></li>
        <li class="nav-item"><a class="nav-link" href="#berita">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="#footerq">Tentang Kami</a></li>
      </ul>

      <!-- LOGIN (selalu di kanan) -->
      <ul class="navbar-nav ms-auto me-3">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            Login
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown">
            <li><a class="dropdown-item" href="back-end/user.php">Login User</a></li>
            <li><a class="dropdown-item" href="back-end/auth.php">Login Admin</a></li>
          </ul>
        </li>
      </ul>

    </div>
  </div>
</nav>



  <!-- Hero Section -->
  <section id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">

      <!-- Slide 1 -->
      <div class="carousel-item active" style="background: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), 
             url('https://i.pinimg.com/1200x/5e/73/e0/5e73e0dc7a90bb11a7fd05f9f6e608c8.jpg') 
             center/cover no-repeat; 
             height: 100vh;">
        <div
          class="container text-center text-white d-flex flex-column justify-content-center align-items-center h-100">
          <h1 class="fw-bold mb-3">Selamat Datang di Perpustakaan Pekanbaru</h1>
          <p class="lead mb-4">Akses ribuan koleksi buku digital berupa e-resource kapan saja dan di mana saja.</p>

        </div>
      </div>

      <!-- Slide 2 -->
      <div class="carousel-item" style="background: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), 
             url('https://dipersip.riau.go.id/wp-content/uploads/2022/09/IMG20220114090203-600x300.jpg') 
             center/cover no-repeat; 
             height: 100vh;">
        <div
          class="container text-center text-white d-flex flex-column justify-content-center align-items-center h-100">
          <h1 class="fw-bold mb-3">Temukan Inspirasi Baru Lewat Buku</h1>
          <p class="lead mb-4">Kunjungi koleksi buku terbaru kami setiap minggu.</p>

        </div>
      </div>

      <!-- Slide 3 -->
      <div class="carousel-item" style="background: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)),
              url('https://mediacenter.riau.go.id/foto_berita/medium/hut-ke-17-tahun-perpustakaan-soeman.jpg') 
              center/cover no-repeat; height: 100vh;">
        <div
          class="container text-center text-white d-flex flex-column justify-content-center align-items-center h-100">
          <h1 class="fw-bold mb-3" data-aos="fade-down">Ikuti Kegiatan Literasi Digital 2025</h1>
          <p class="lead mb-4" data-aos="fade-up">Bergabunglah dalam seminar dan lomba literasi di kampusmu.</p>

        </div>
      </div>

    </div>

    <!-- button kiri kanan -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Sebelumnya</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Selanjutnya</span>
    </button>


  </section>

  <!-- sejarah -->
  <section id="sejarah" class="mt-5">
    <h2 class="text-center mb-4">📖 Sejarah Perpustakaan</h2>

    <div class="book-container">
      <div id="book">
        <div class="page cover front-cover">
          <h2>📘 Sejarah Perpustakaan</h2>
          <p>Selamat datang di buku digital kami.</p>
          <button id="openBook" class="btn btn-primary">Buka Buku</button>
        </div>
        <div class="page">
          📘 <b>Halaman 1 – Sejarah Awal</b><br><br>
          Perpustakaan Soeman H.S merupakan perpustakaan provinsi terbesar di Riau.
          Pembangunannya dimulai pada awal tahun 2000-an sebagai upaya Pemerintah
          Provinsi Riau untuk menyediakan pusat literasi modern bagi masyarakat.
          <br><br>
          Nama <b>Soeman H.S</b> dipilih sebagai penghormatan kepada seorang sastrawan besar
          dari Riau yang berperan dalam perkembangan dunia literasi dan pendidikan di Indonesia.
          <br><br>
          Bangunan perpustakaan ini memiliki arsitektur yang unik karena terinspirasi dari
          bentuk <b>rehal</b> – tempat meletakkan Al-Qur’an – sebagai simbol kebudayaan Melayu.
        </div>

        <div class="page">
          📖 <b>Halaman 2 – Perkembangan Perpustakaan</b><br><br>
          Perpustakaan ini diresmikan pada tahun <b>2008</b> sebagai pusat literasi dan budaya
          terbesar di Sumatera. Memiliki enam lantai dengan berbagai fasilitas modern seperti:
          <br><br>
          • Ruang baca umum<br>
          • Ruang koleksi langka dan referensi<br>
          • Ruang multimedia<br>
          • Ruang anak & remaja<br>
          • Auditorium<br>
          • Meeting room & ruang diskusi<br><br>
          Perpustakaan Soeman H.S tidak hanya melayani peminjaman buku, tetapi juga menjadi
          tempat pelaksanaan seminar, pameran, lokakarya, serta kegiatan literasi digital.
        </div>

        <div class="page">
          📚 <b>Halaman 3 – Transformasi Digital</b><br><br>
          Seiring perkembangan teknologi, perpustakaan ini mulai bertransformasi menjadi
          pusat informasi digital. Kini pengunjung dapat menikmati:
          <br><br>
          • Akses e-book dan e-journal<br>
          • Digital catalog (OPAC)<br>
          • Layanan literasi digital<br>
          • Pelatihan komputer dan seminar teknologi<br><br>
          Perpustakaan Soeman H.S terus berkembang menjadi ruang belajar terbuka bagi
          mahasiswa, pelajar, peneliti, dan masyarakat umum. Dengan desain megah
          dan fasilitas lengkap, perpustakaan ini menjadi salah satu ikon kota Pekanbaru.
        </div>

      </div>
  </section>



  <!-- 📰 Berita & Kegiatan -->
  <section class="berita py-5 bg-light" data-aos="fade-up" id="berita">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold" id="berita">🗞️ Berita & Kegiatan</h2>
        <p class="text-muted">
          Simak informasi terbaru dari Perpustakaan Pekanbaru
        </p>
      </div>

      <div class="row g-4">
        <!-- Kegiatan 1 -->
        <div class="col-md-4" data-aos="fade-up">
          <div class="card h-100 shadow-sm border-0">
            <!-- Gambar tidak memiliki link -->
            <img src="assets/pekanliterasi.jpeg" class="card-img-top" alt="Pekan Literasi Digital" />


            <div class="card-body">
              <h5 class="card-title">Literasi Digital UNRI 2025</h5>
              <p class="card-text text-muted">
                Ayo ikut serta dalam kegiatan literasi digital yang diadakan oleh
                Perpustakaan Pekanbaru untuk meningkatkan minat baca mahasiswa! dan Dorong Mahasiswa Jadi Kreator Cerdas
                di Era Digital
              </p>
            </div>

            <!-- Tombol ini yang menuju link berita -->
            <div class="card-footer bg-white border-0 text-end" id="buku">
              <a href="https://https://unri.ac.id/unri-dan-indosat-ooredoo-hutchison-gelar-seminar-literasi-digital-dorong-mahasiswa-jadi-kreator-cerdas-di-era-digital//berita-pekan-literasi"
                class="btn btn-outline-primary btn-sm">
                Selengkapnya
              </a>
            </div>

          </div>
        </div>


        <!-- Kegiatan 2 -->
        <div class="col-md-4" data-aos="fade-up">
          <div class="card h-100 shadow-sm border-0">
            <img src="assets/karyailmuah.jpg" class="card-img-top" alt="Pelatihan Penulisan Karya Ilmiah" />
            <div class="card-body">
              <h5 class="card-title">Pelatihan Penulisan Karya Ilmiah</h5>
              <p class="card-text text-muted">
                Dapatkan tips dan teknik menulis karya ilmiah dari dosen dan
                pustakawan berpengalaman.
              </p>
            </div>

            <div class="card-footer bg-white border-0 text-end">
              <a href="https://manajemen.unimus.ac.id/pelatihan-penulisan-karya-tulis-ilmiah/"
                class="btn btn-outline-primary btn-sm">Selengkapnya</a>
            </div>
          </div>
        </div>

        <!-- Kegiatan 3 -->
        <div class="col-md-4" data-aos="fade-up">
          <div class="card h-100 shadow-sm border-0">
            <img src="assets/rivew.jpeg" class="card-img-top" alt="Lomba Review Buku" />
            <div class="card-body">
              <h5 class="card-title">Lomba Review Buku 2025</h5>
              <p class="card-text text-muted">
                Tunjukkan kemampuanmu dalam menulis ulasan menarik tentang buku
                favoritmu dan menangkan hadiah menarik!
              </p>
            </div>
            <div class="card-footer bg-white border-0 text-end">
              <a href="https://lib.unri.ac.id/lomba-resensi-buku-unri-library-art-and-books-fest-2025/"
                class="btn btn-outline-primary btn-sm">Selengkapnya</a>
            </div>
          </div>
        </div>

        <!-- Kegiatan 4 -->
        <div class="col-md-4" data-aos="fade-up">
          <div class="card h-100 shadow-sm border-0">
            <img src="assets/download.jpeg" class="card-img-top" alt="Pekan Literasi Digital" />
            <div class="card-body">
              <h5 class="card-title">Unri menjajaki kolaborasi penelitian dengan University of Waterloo</h5>
              <p class="card-text text-muted">
                Universitas Riau (Unri) di kota Pekanbaru, provinsi Riau, sedang menjajaki
                kerja sama penelitian dengan Universitas Waterloo, Kanada, menurut seorang pejabat universitas tersebut,
                Rabu.
              </p>
            </div>
            <div class="card-footer bg-white border-0 text-end">
              <a href="https://en.antaranews.com/news/292434/unri-explores-research-collaboration-with-university-of-waterloo"
                class="btn btn-outline-primary btn-sm">Selengkapnya</a>
            </div>
          </div>
        </div>

        <!-- Kegiatan 5 -->
        <div class="col-md-4" data-aos="fade-up">
          <div class="card h-100 shadow-sm border-0">
            <img src="assets/bantuanadb.jpeg" class="card-img-top" alt="Pekan Literasi Digital" />
            <div class="card-body">
              <h5 class="card-title">Unri mulai Fungsikan Gedung-gedung Bantuan ADB</h5>
              <p class="card-text text-muted">
                Universitas Riau (Unri) mulai memfungsikan gedung-gedung baru yang dikerjakan
                melalui Proyek AKSI (Advanced Knowledge for Sustainable Growth in Indonesia)
                bantuan Asian Development Bank (ADB) l, yang kini telah selesai dibangun.
              </p>
            </div>
            <div class="card-footer bg-white border-0 text-end">
              <a href="https://unri.ac.id/unri-mulai-fungsikan-gedung-gedung-bantuan-adb/"
                class="btn btn-outline-primary btn-sm">Selengkapnya</a>
            </div>
          </div>
        </div>
        <!-- Kegiatan 6 -->
        <div class="col-md-4" data-aos="fade-up">
          <div class="card h-100 shadow-sm border-0">
            <img src="assets/sistemsatu.jpg" class="card-img-top" alt="">
            <div class="card-body">
              <h5 class="card-title">Sistem informasi "Satu UNRI" digaungkan</h5>
              <p class="card-text text-muted">Dalam rangka integrasi aplikasi di
                lingkungan Universitas Riau, pihak kampus sosialisasi Sistem Informasi
                Akademik terpadu Universitas Riau (Satu UNRI) di Gedung Senangin
                Fakultas Perikanan dan Kelautan (FPK) Universitas Riau, Kamis (25/1)..</p>
            </div>
            <div class="card-footer bg-white border-0 text-end">
              <a href="https://riau.antaranews.com/berita/360585/sistem-informasi-satu-unri-digaungkan"
                class="btn btn-outline-primary btn-sm">Selengkapnya</a>
            </div>
          </div>
        </div>


  </section>
  <!-- layanan -->
  <div class="container py-5">
    <h3 class="mb-4 fw-bold text-center" id="layanan">Layanan Kami</h3>

    <div class="d-flex justify-content-between gap-4 flex-wrap">

      <!-- CARD 1 -->
      <div class="card border-0 shadow-sm service-card p-2" style="width: 22rem;">
        <div class="card-body text-center">
          <div class="icon-circle mb-3">
            <i class="bi bi-person-plus fs-3"></i>
          </div>
          <h5 class="card-title fw-semibold">Pendaftaran Anggota</h5>
        </div>
      </div>

      <!-- CARD 2 -->
      <div class="card border-0 shadow-sm service-card p-2" style="width: 22rem;">
        <div class="card-body text-center">
          <div class="icon-circle mb-3">
            <i class="bi bi-book fs-3"></i>
          </div>
          <h5 class="card-title fw-semibold">Peminjaman Buku</h5>
        </div>
      </div>

      <!-- CARD 3 -->
      <div class="card border-0 shadow-sm service-card p-2" style="width: 22rem;">
        <div class="card-body text-center">
          <div class="icon-circle mb-3">
            <i class="bi bi-calendar-event fs-3"></i>
          </div>
          <h5 class="card-title fw-semibold">Pendaftaran Event</h5>
        </div>
      </div>

    </div>
  </div>

  <!-- ==================== KOLEKSI BUKU ==================== -->
  <section id="koleksi-buku" class="py-5">
    <div class="container">

      <h2 class="fw-bold text-center mb-4"> Koleksi Buku </h2>

      <div class="book-slider">

        <!-- Buku 1 -->
        <div class="book">
          <img src="https://images-na.ssl-images-amazon.com/images/I/81af+MCATTL.jpg" alt="Book 1">
          <h5>Harry Potter</h5>
        </div>

        <!-- Buku 2 -->
        <div class="book">
          <img src="https://images-na.ssl-images-amazon.com/images/I/71KilybDOoL.jpg" alt="Book 2">
          <h5>The Hobbit</h5>
        </div>

        <!-- Buku 3 -->
        <div class="book">
          <img src="https://images-na.ssl-images-amazon.com/images/I/81a4kCNuH+L.jpg" alt="Book 3">
          <h5>Percy Jackson</h5>
        </div>

        <!-- Buku 4 -->
        <div class="book">
          <img src="https://ebooks.gramedia.com/ebook-covers/40151/big_covers/ID_GPU2017MTH09TLOTRSPCFOTRUCB_B.jpg"
            alt="Book 4">
          <h5>Lord of The Rings</h5>
        </div>

        <!-- Buku 5 -->
        <div class="book">
          <img src="https://images-na.ssl-images-amazon.com/images/I/81WcnNQ-TBL.jpg" alt="Book 5">
          <h5>The Great Gatsby</h5>
        </div>

        <!-- Buku 6 -->
        <div class="book">
          <img src="https://images-na.ssl-images-amazon.com/images/I/71g2ednj0JL.jpg" alt="Book 6">
          <h5>To Kill a Mockingbird</h5>
        </div>

        <!-- Buku 7 -->
        <div class="book">
          <img src="https://images-na.ssl-images-amazon.com/images/I/81iqZ2HHD-L.jpg" alt="Book 7">
          <h5>1984 - George Orwell</h5>
        </div>

        <!-- Buku 8 -->
        <div class="book">
          <img src="https://images-na.ssl-images-amazon.com/images/I/91uwocAMtSL.jpg" alt="Book 8">
          <h5>The Alchemist</h5>
        </div>

      </div>

    </div>
  </section>




  <!-- 📢 Popup Event Modal -->
  <?php if ($event): ?>
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="eventModalLabel">
              🎉 EVENT TERBARU
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p><?php echo htmlspecialchars($event['judul']); ?></p>
            <p><?php echo nl2br(htmlspecialchars($event['deskripsi'])); ?></p>
            <ul>
              <li>🗓️
                <?php echo date("d", strtotime($event['tanggal_mulai'])); ?>–
                <?php echo date("d F Y", strtotime($event['tanggal_selesai'])); ?>
              </li>
              <li>📍 <?php echo htmlspecialchars($event['lokasi']); ?></li>
            </ul>
          </div>
          <div class="modal-footer">
            <a href="<?php echo htmlspecialchars($event['link_event']); ?>" class="btn btn-primary" target="_blank">
              🔗 Lihat Detail
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>



  <!-- ===== Footer Section ===== -->
  <footer class="bg-dark text-light pt-5 pb-3 mt-5" id="footerq">
    <div class="container">
      <div class="row g-4">

        <!-- 📍 Lokasi -->
        <div class="col-md-4">
          <h5 class="mb-3">📍 Lokasi Kami</h5>
          <div class="ratio ratio-16x9 rounded shadow">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4031.215687303451!2d101.44387307496473!3d0.5156158994793396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5ac1d5ea23b79%3A0x406ac240e5fb26c4!2sPerpustakaan%20Soeman%20HS%20Provinsi%20Riau!5e1!3m2!1sid!2sid!4v1761869892480!5m2!1sid!2sid"
              width="600" height="450" style="border:0;" allowfullscreen loading="lazy">
            </iframe>
          </div>
        </div>

        <!-- 📊 Statistik -->
        <div class="col-md-4">
          <h5 class="mb-3">📊 Statistik Pengunjung</h5>

          <div class="bg-secondary bg-opacity-25 p-3 rounded text-center shadow-sm mb-3">
            <?php
            $file = "counter.txt";
            if (!file_exists($file)) {
              file_put_contents($file, 0);
            }
            $count = (int) file_get_contents($file);
            $count++;
            file_put_contents($file, $count);
            ?>
            <h3 class="fw-bold text-light"><?= $count; ?></h3>
            <p>Total Pengunjung Website</p>
          </div>

          <div class="bg-secondary bg-opacity-25 p-3 rounded text-center shadow-sm">
            <?php
            include 'back-end/koneksi.php';
            $sql = "SELECT COUNT(*) AS total_anggota FROM anggota_perpus WHERE status = 'aktif'";
            $result = mysqli_query($koneksi, $sql);
            $data = mysqli_fetch_assoc($result);
            $totalAnggota = $data['total_anggota'];
            ?>
            <h3 class="fw-bold text-light"><?= $totalAnggota; ?></h3>
            <p>Anggota Terdaftar</p>
          </div>
        </div>

        <!-- 🔗 Quick Links -->
        <div class="col-md-2">
          <h5 class="mb-3">🔗 Link Cepat</h5>
          <ul class="list-unstyled">
            <li><a href="#heroCarousel" class="text-light text-decoration-none">Beranda</a></li>
            <li><a href="#layanan" class="text-light text-decoration-none">Layanan</a></li>
            <li><a href="#koleksi-buku" class="text-light text-decoration-none">Koleksi</a></li>
            <li><a href="#sejarah" class="text-light text-decoration-none">Sejarah</a></li>
          </ul>
        </div>

        <!-- 📞 Kontak + Sosmed -->
        <div class="col-md-2">
          <h5 class="mb-3">📞 Kontak</h5>
          <ul class="list-unstyled small">
            <li><i class="bi bi-geo-alt-fill me-2"></i> UNRI, Pekanbaru</li>
            <li><i class="bi bi-telephone-fill me-2"></i> (0761) 123456</li>
            <li><i class="bi bi-envelope-fill me-2"></i> perpus@unri.ac.id</li>
          </ul>

          <h5 class="mt-4 mb-2">🌐 Sosial Media</h5>
          <div class="d-flex gap-3">
            <a href="#" class="text-light fs-4"><i class="bi bi-instagram"></i></a>
            <a href="#" class="text-light fs-4"><i class="bi bi-facebook"></i></a>
            <a href="#" class="text-light fs-4"><i class="bi bi-youtube"></i></a>
            <a href="#" class="text-light fs-4"><i class="bi bi-tiktok"></i></a>
          </div>
        </div>

      </div>

      <!-- Copyright -->
      <div class="text-center mt-4 pt-3 border-top border-secondary">
        <p class="mb-0">
          © <?= date("Y") ?> Perpustakaan Pekanbaru — All Rights Reserved.
        </p>
      </div>

    </div>
  </footer>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const heroCarousel = document.querySelector('#heroCarousel');
    const carousel = new bootstrap.Carousel(heroCarousel, {
      interval: 3000,
      ride: 'carousel'
    });
  </script>
  <!-- aos src -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000, // durasi animasi (ms)
      once: false,     // animasi muncul
      mirror: true, //animasi tetap mucul
    });
  </script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Turn.js  -->
  <script src="library/turn.js-master/turn.js"></script>

  <script>
    $(document).ready(function () {
      $("#book").turn({
        width: 1000,
        height: 700,
        autoCenter: true,
        elevation: 60,
        gradients: true
      });

      document.getElementById("openBook").addEventListener("click", function () {
        $("#book").turn("page", 2);
      });
    });
  </script>
  <!-- 🎬 Script agar popup muncul otomatis -->
  <?php if ($event): // Tambahkan kondisi PHP di SINI ?>
    <script>
      // Tampilkan modal otomatis hanya kalau ada event #
      //  var myModal = new bootstrap.Modal(document.getElementById('eventModal'));
      window.addEventListener('load', () => {
        myModal.show();
      });
    </script>
  <?php endif; ?>
</body>

</html>