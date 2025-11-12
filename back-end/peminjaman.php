<?php
header("Content-Type: application/json");
include "koneksi.php";

$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
  case "GET":
    $result = mysqli_query($conn, "SELECT * FROM peminjaman ORDER BY tgl_pinjam DESC");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $rows[] = $row;
    }
    echo json_encode($rows);
    break;

  case "POST":
    $data = json_decode(file_get_contents("php://input"), true);
    $namaBuku = mysqli_real_escape_string($conn, $data["nama_buku"]);
    $namaPeminjam = mysqli_real_escape_string($conn, $data["nama_peminjam"]);
    $tglPinjam = date("Y-m-d");
    $batasWaktu = 3;

    $query = "INSERT INTO peminjaman (nama_buku, nama_peminjam, tgl_pinjam, batas_waktu, status)
              VALUES ('$namaBuku', '$namaPeminjam', '$tglPinjam', $batasWaktu, 'Dipinjam')";
    $ok = mysqli_query($conn, $query);

    echo json_encode(["status" => $ok ? "success" : "error"]);
    break;

  case "PUT":
    $data = json_decode(file_get_contents("php://input"), true);
    $id = intval($data["id"]);
    $status = mysqli_real_escape_string($conn, $data["status"]);
    $tglKembali = $status === "Dikembalikan" ? date("Y-m-d") : null;

    $query = "UPDATE peminjaman SET status='$status', tgl_kembali='$tglKembali' WHERE id=$id";
    $ok = mysqli_query($conn, $query);

    echo json_encode(["status" => $ok ? "success" : "error"]);
    break;

  default:
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);
    break;
}
?>
