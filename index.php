<?php
include 'koneksi.php';

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
<link rel="stylesheet" href="asset/style.css">

  
</head>

<body>
  <!-- 🌐 Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <!-- 🔹 Kiri (Brand) -->
      <a class="navbar-brand ms-3" href="#"> Perpustakaan PEKANBARU</a>

      <!-- 🔹 Tombol toggle (buat tampilan HP) -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- 🔹 Kanan (Menu) -->
      <div class="collapse navbar-collapse justify-content-end me-3" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="#">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Koleksi Buku</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Layanan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Tentang Kami</a>
          </li>

          <!-- 🔽 Dropdown Login -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Login
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown">
              <li><a class="dropdown-item" href="user.php">Login User</a></li>
              <li><a class="dropdown-item" href="admin.php">Login Admin</a></li>
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
          <p class="lead mb-4">Akses ribuan koleksi buku, jurnal, dan e-resource kapan saja dan di mana saja.</p>
          <a href="koleksi.php" class="btn btn-light btn-lg rounded-pill">📚 Jelajahi Koleksi</a>
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
          <a href="berita.php" class="btn btn-primary btn-lg rounded-pill">📰 Baca Berita</a>
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
          <a href="event.php" class="btn btn-success btn-lg rounded-pill" data-aos="zoom-in">🎉 Lihat Event</a>
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
        <div class="page">📘 <b>Halaman 1:</b><br> Sejarah awal berdirinya perpustakaan kami dimulai dari tahun 1990...
        </div>
        <div class="page">📖 <b>Halaman 2:</b><br> Pada tahun 2000, perpustakaan ini berkembang dengan koleksi lebih
          dari 5000 buku...</div>
        <div class="page">📚 <b>Halaman 3:</b><br> Sekarang, perpustakaan kami telah bertransformasi menjadi digital dan
          modern.</div>
      </div>
  </section>



  <!-- 📰 Berita & Kegiatan -->
  <section class="berita py-5 bg-light" data-aos="fade-up">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">🗞️ Berita & Kegiatan</h2>
        <p class="text-muted">
          Simak informasi terbaru dari Perpustakaan Pekanbaru
        </p>
      </div>

      <div class="row g-4">
        <!-- Kegiatan 1 -->
        <div class="col-md-4" data-aos="fade-up">
          <div class="card h-100 shadow-sm border-0">
            <img src="https://i.pinimg.com/736x/30/f3/1f/30f31fba55d05fa5e9e7273b6d543d8d.jpg" class="card-img-top"
              alt="Pekan Literasi Digital" />
            <div class="card-body">
              <h5 class="card-title">Pekan Literasi Digital UNRI 2025</h5>
              <p class="card-text text-muted">
                Ayo ikut serta dalam kegiatan literasi digital yang diadakan oleh
                Perpustakaan Pekanbaru untuk meningkatkan minat baca mahasiswa!
              </p>
            </div>
            <div class="card-footer bg-white border-0 text-end">
              <a href="#" class="btn btn-outline-primary btn-sm">Selengkapnya</a>
            </div>
          </div>
        </div>

        <!-- Kegiatan 2 -->
        <div class="col-md-4" data-aos="fade-up">
          <div class="card h-100 shadow-sm border-0">
            <img src="https://i.pinimg.com/736x/60/62/10/606210fb476ad26fc2e8884d6d5108b0.jpg" class="card-img-top"
              alt="Pelatihan Penulisan Karya Ilmiah" />
            <div class="card-body">
              <h5 class="card-title">Pelatihan Penulisan Karya Ilmiah</h5>
              <p class="card-text text-muted">
                Dapatkan tips dan teknik menulis karya ilmiah dari dosen dan
                pustakawan berpengalaman.
              </p>
            </div>
            <div class="card-footer bg-white border-0 text-end">
              <a href="#" class="btn btn-outline-primary btn-sm">Selengkapnya</a>
            </div>
          </div>
        </div>

        <!-- Kegiatan 3 -->
        <div class="col-md-4" data-aos="fade-up">
          <div class="card h-100 shadow-sm border-0">
            <img src="https://i.pinimg.com/736x/03/91/b5/0391b58fc5c031b8b3a4e7f5193f3f85.jpg" class="card-img-top"
              alt="Lomba Review Buku" />
            <div class="card-body">
              <h5 class="card-title">Lomba Review Buku 2025</h5>
              <p class="card-text text-muted">
                Tunjukkan kemampuanmu dalam menulis ulasan menarik tentang buku
                favoritmu dan menangkan hadiah menarik!
              </p>
            </div>
            <div class="card-footer bg-white border-0 text-end">
              <a href="#" class="btn btn-outline-primary btn-sm">Selengkapnya</a>
            </div>
          </div>
        </div>

        <!-- Kegiatan 4 -->
        <div class="col-md-4" data-aos="fade-up">
          <div class="card h-100 shadow-sm border-0">
            <img src="https://i.pinimg.com/736x/30/f3/1f/30f31fba55d05fa5e9e7273b6d543d8d.jpg" class="card-img-top"
              alt="Pekan Literasi Digital" />
            <div class="card-body">
              <h5 class="card-title">Pekan Literasi Digital UNRI 2025</h5>
              <p class="card-text text-muted">
                Ayo ikut serta dalam kegiatan literasi digital yang diadakan oleh
                Perpustakaan Pekanbaru untuk meningkatkan minat baca mahasiswa!
              </p>
            </div>
            <div class="card-footer bg-white border-0 text-end">
              <a href="#" class="btn btn-outline-primary btn-sm">Selengkapnya</a>
            </div>
          </div>
        </div>

        <!-- Kegiatan 5 -->
        <div class="col-md-4" data-aos="fade-up">
          <div class="card h-100 shadow-sm border-0">
            <img src="https://i.pinimg.com/736x/30/f3/1f/30f31fba55d05fa5e9e7273b6d543d8d.jpg" class="card-img-top"
              alt="Pekan Literasi Digital" />
            <div class="card-body">
              <h5 class="card-title">Pekan Literasi Digital UNRI 2025</h5>
              <p class="card-text text-muted">
                Ayo ikut serta dalam kegiatan literasi digital yang diadakan oleh
                Perpustakaan Pekanbaru untuk meningkatkan minat baca mahasiswa!
              </p>
            </div>
            <div class="card-footer bg-white border-0 text-end">
              <a href="#" class="btn btn-outline-primary btn-sm">Selengkapnya</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Koleksi Buku -->
  <section id="koleksi" class="container mt-5">
    <h2 class="text-center mb-4">📚 Koleksi Buku Unggulan</h2>

    <div class="book-slider">
      <div class="book">
        <img src="https://images-na.ssl-images-amazon.com/images/I/81af+MCATTL.jpg" alt="Book 1">
        <h5>Harry Potter</h5>
      </div>
      <div class="book">
        <img src="https://images-na.ssl-images-amazon.com/images/I/71KilybDOoL.jpg" alt="Book 2">
        <h5>The Hobbit</h5>
      </div>
      <div class="book">
        <img src="https://images-na.ssl-images-amazon.com/images/I/81a4kCNuH+L.jpg" alt="Book 3">
        <h5>Percy Jackson</h5>
      </div>
      <div class="book">
        <img src="https://ebooks.gramedia.com/ebook-covers/40151/big_covers/ID_GPU2017MTH09TLOTRSPCFOTRUCB_B.jpg"
          alt="Book 4">
        <h5>Lord of The Rings</h5>
      </div>
    </div>
  </section>



  <!-- 📢 Popup Event Modal -->
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
          <p> <?php echo htmlspecialchars($event['judul']); ?></p>
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



  <!-- ===== Footer Section ===== -->
  <footer class="bg-dark text-light pt-5 pb-3 mt-5">
    <div class="container">
      <div class="row g-4">

        <!-- 📍 Google Map -->
        <div class="col-md-4">
          <h5 class="mb-3">📍 Lokasi Kami</h5>
          <div class="ratio ratio-16x9 rounded shadow">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4031.215687303451!2d101.44387307496473!3d0.5156158994793396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5ac1d5ea23b79%3A0x406ac240e5fb26c4!2sPerpustakaan%20Soeman%20HS%20Provinsi%20Riau!5e1!3m2!1sid!2sid!4v1761869892480!5m2!1sid!2sid"
              width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>

        <!-- 👥 Statistik -->
        <div class="col-md-4">
          <h5 class="mb-3">📊 Statistik Pengunjung</h5>

          <div class="bg-secondary bg-opacity-25 p-3 rounded text-center shadow-sm mb-3">
            <?php
            // Total kunjungan (disimpan di file)
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
          <!-- Total anggota terdaftar dari database -->
          <div class="bg-secondary bg-opacity-25 p-3 rounded text-center shadow-sm">
            <?php

            include 'koneksi.php';
            $sql = "SELECT COUNT(*) AS total_anggota FROM anggota_perpus WHERE status = 'aktif'";
            $result = mysqli_query($koneksi, $sql);
            $data = mysqli_fetch_assoc($result);
            $totalAnggota = $data['total_anggota'];
            ?>
            <h3 class="fw-bold text-light"><?= $totalAnggota; ?></h3>
            <p>Anggota Terdaftar </p>
          </div>
        </div>

        <!-- 📞 Kontak -->
        <div class="col-md-4">
          <h5 class="mb-3">📞 Kontak Kami</h5>
          <ul class="list-unstyled">
            <li><i class="bi bi-geo-alt-fill me-2"></i> Perpustakaan Pusat UNRI, Pekanbaru</li>
            <li><i class="bi bi-telephone-fill me-2"></i> (0761) 123456</li>
            <li><i class="bi bi-envelope-fill me-2"></i> perpus@unri.ac.id</li>
            <li><i class="bi bi-instagram me-2"></i> <a href="https://www.instagram.com/dipersipprovriau/"
                class="text-light text-decoration-none">@perpusunri</a></li>
          </ul>
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