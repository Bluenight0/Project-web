<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $nim  = trim($_POST['nim']);
    $email= trim($_POST['email']);
    $nohp = trim($_POST['no_hp']);
    $password = $_POST['password'];
    $tgl_daftar = date('Y-m-d');

    if (strlen($password) < 6) {
        $error = "Password minimal 6 karakter.";
    }
        // Ambil ID terakhir
        $sqlLast = "SELECT id_anggota FROM anggota_perpus ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($koneksi, $sqlLast);
        $lastID = mysqli_fetch_assoc($result);

        if ($lastID) {
            $num = (int) substr($lastID['id_anggota'], 2) + 1;
        } else {
            $num = 1;
        }
        $idAnggota = "PA" . str_pad($num, 4, "0", STR_PAD_LEFT);

        // Simpan ke database
        $sql = "INSERT INTO anggota_perpus (id_anggota, nama, nim, email, no_hp, password, tgl_daftar, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'aktif')";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $idAnggota, $nama, $nim, $email, $nohp, $password, $tgl_daftar);
        $ok = mysqli_stmt_execute($stmt);

        if ($ok) {
            // Tampilkan ID anggota ke user
            echo "<script>
                    alert('Pendaftaran berhasil! ID Anggota Anda adalah: $idAnggota' );
                    window.location.href='user.php';
                  </script>";
            exit;
        } else {
            $error = "Gagal registrasi: " . mysqli_error($koneksi);
        }
    }

?>

<!-- HTML form sederhana -->
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Daftar Anggota</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Daftar Anggota Perpustakaan</h2>
  <?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="post">
    <div class="mb-3"><label>Nama</label><input name="nama" class="form-control" required></div>
    <div class="mb-3"><label>NIM</label><input name="nim" class="form-control" required></div>
    <div class="mb-3"><label>Email</label><input name="email" type="email" class="form-control"></div>
    <div class="mb-3"><label>No HP</label><input name="no_hp" class="form-control"></div>
    <div class="mb-3"><label>Password</label><input name="password" type="password" class="form-control" required></div>
    <button class="btn btn-primary">Daftar</button>
  </form>
</div>
</body>
</html>
