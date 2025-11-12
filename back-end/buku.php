<?php
// koneksi ke database
include 'koneksi.php'; // pastikan file ini berisi koneksi MySQL kamu

// menerima data JSON
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['nama']) && isset($data['jenis']) && isset($data['tanggal'])) {
    $nama = mysqli_real_escape_string($conn, $data['nama']);
    $jenis = mysqli_real_escape_string($conn, $data['jenis']);
    $tanggal = mysqli_real_escape_string($conn, $data['tanggal']);

    $query = "INSERT INTO buku (nama, jenis, tanggal) VALUES ('$nama', '$jenis', '$tanggal')";
    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
} else {
    echo json_encode(["status" => "invalid_data"]);
}
?>
