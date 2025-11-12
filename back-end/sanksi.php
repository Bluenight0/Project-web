<?php
include 'koneksi.php';
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
  $result = mysqli_query($conn, "SELECT * FROM peminjaman ORDER BY id DESC");
  $data = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }
  echo json_encode($data);
}

elseif ($method === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);
  if (isset($data['nama_buku'], $data['nama_peminjam'])) {
    $nama_buku = mysqli_real_escape_string($conn, $data['nama_buku']);
    $nama_peminjam = mysqli_real_escape_string($conn, $data['nama_peminjam']);
    $tgl_pinjam = date("Y-m-d");
    $batas_waktu = 3;

    $query = "INSERT INTO peminjaman (nama_buku, nama_peminjam, tgl_pinjam, batas_waktu, status)
              VALUES ('$nama_buku', '$nama_peminjam', '$tgl_pinjam', $batas_waktu, 'Dipinjam')";
    mysqli_query($conn, $query);

    echo json_encode(["status" => "success"]);
  } else {
    echo json_encode(["status" => "invalid_data"]);
  }
}

elseif ($method === 'PUT') {
  $data = json_decode(file_get_contents("php://input"), true);
  if (isset($data['id'], $data['status'])) {
    $id = intval($data['id']);
    $status = mysqli_real_escape_string($conn, $data['status']);

    mysqli_query($conn, "UPDATE peminjaman SET status='$status' WHERE id=$id");

    // Jika status 'Terlambat' -> aktifkan sanksi user
    if ($status === 'Terlambat') {
      $res = mysqli_query($conn, "SELECT nama_peminjam FROM peminjaman WHERE id=$id");
      $row = mysqli_fetch_assoc($res);
      $user = $row['nama_peminjam'];
      mysqli_query($conn, "UPDATE users SET sanksi_aktif=1, sanksi_mulai=NOW() WHERE username='$user'");
    }

    // Jika status 'Dikembalikan' -> cek apakah sanksi masih aktif dan waktunya habis
    if ($status === 'Dikembalikan') {
      $res = mysqli_query($conn, "SELECT nama_peminjam FROM peminjaman WHERE id=$id");
      $row = mysqli_fetch_assoc($res);
      $user = $row['nama_peminjam'];

      $check = mysqli_query($conn, "SELECT sanksi_mulai FROM users WHERE username='$user' AND sanksi_aktif=1");
      if (mysqli_num_rows($check) > 0) {
        $s = mysqli_fetch_assoc($check);
        $mulai = strtotime($s['sanksi_mulai']);
        $now = time();
        $selisih = floor(($now - $mulai) / (60 * 60 * 24));
        if ($selisih >= 3) {
          mysqli_query($conn, "UPDATE users SET sanksi_aktif=0, sanksi_mulai=NULL WHERE username='$user'");
        }
      }
    }

    echo json_encode(["status" => "success"]);
  } else {
    echo json_encode(["status" => "invalid_data"]);
  }
}
?>
