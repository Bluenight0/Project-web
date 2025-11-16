<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $alamat  = trim($_POST['alamat']);
    $email= trim($_POST['email']);
    $nohp = trim($_POST['no_hp']);
    $password = $_POST['password'];
    $tgl_daftar = date('Y-m-d');

    // Validasi password minimal 6 karakter
    if (strlen($password) < 6) {
        $error = "Password minimal 6 karakter.";
    } else {
        // Ambil ID terakhir
        $sqlLast = "SELECT id_anggota FROM anggota_perpus ORDER BY id_anggota DESC LIMIT 1";
        $result = mysqli_query($koneksi, $sqlLast);
        $lastID = mysqli_fetch_assoc($result);

        if ($lastID) {
            $num = (int) substr($lastID['id_anggota'], 2) + 1;
        } else {
            $num = 1;
        }
        $idAnggota = "PA" . str_pad($num, 4, "0", STR_PAD_LEFT);

        // 🔹 Upload foto jika ada
        $foto = null;
        if (!empty($_FILES['foto']['name'])) {
            $folder = "uploads/foto_anggota/";
            if (!is_dir($folder)) mkdir($folder, 0777, true);
            
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $foto = $idAnggota . "." . strtolower($ext);
            $targetFile = $folder . $foto;

            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
                $error = "Gagal upload foto.";
            }
        }

        // Simpan ke database
        $sql = "INSERT INTO anggota_perpus 
                (id_anggota, nama, alamat, email, no_hp, password, tanggal_daftar, foto, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'aktif')";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssss", 
            $idAnggota, $nama, $alamat, $email, $nohp, $password, $tgl_daftar, $foto
        );
        $ok = mysqli_stmt_execute($stmt);

        if ($ok) {
            echo "<script>
                    if (confirm('Pendaftaran berhasil! ID Anggota Anda adalah: $idAnggota. 
                      
                        window.location.href='user.php';
                    }
                  </script>";
            exit;
        } else {
            $error = "Gagal registrasi: " . mysqli_error($koneksi);
        }
    }
}
?>

<!-- HTML form -->
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Daftar Anggota</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Daftar Anggota Perpustakaan</h2>
  <?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Nama</label>
      <input name="nama" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Alamat</label>
      <input name="alamat" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input name="email" type="email" class="form-control">
    </div>

    <div class="mb-3">
      <label>No HP</label>
      <input name="no_hp" class="form-control">
    </div>

    <div class="mb-3">
      <label>Password</label>
      <input name="password" type="password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Upload Foto</label>
      <input name="foto" type="file" class="form-control" accept="image/*">
    </div>

    <button class="btn btn-primary">Daftar</button>
  </form>
</div>
</body>
</html>
