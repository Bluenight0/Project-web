<?php
include "../back-end/koneksi.php";
header("Content-Type: application/json");

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {

    // Ambil semua buku
    $q = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku DESC");
    $data = [];

    while ($row = mysqli_fetch_assoc($q)) {
        $data[] = [
            "id_buku" => $row["id_buku"],
            "nama" => $row["nama"],
            "jenis" => $row["jenis"],
            "tanggal" => $row["tanggal"],
            "gambar" => $row["gambar"],
            "status" => $row["status"]
        ];
    }

    echo json_encode($data);
    exit;
}


elseif ($method === "POST") {

    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input["nama"], $input["jenis"], $input["tanggal"])) {
        echo json_encode(["status" => "invalid"]);
        exit;
    }

    $nama = mysqli_real_escape_string($koneksi, $input["nama"]);
    $jenis = mysqli_real_escape_string($koneksi, $input["jenis"]);
    $tanggal = mysqli_real_escape_string($koneksi, $input["tanggal"]);
    $gambar = mysqli_real_escape_string($koneksi, $input["gambar"] ?? "");
    $status = mysqli_real_escape_string($koneksi, $input["status"] ?? "Tersedia");

    $sql = "INSERT INTO buku (nama, jenis, tanggal, gambar, status) 
            VALUES ('$nama', '$jenis', '$tanggal', '$gambar', '$status')";

    echo json_encode([
        "status" => mysqli_query($koneksi, $sql) ? "success" : "error"
    ]);
    exit;
}


elseif ($method === "PUT") {

    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input["id_buku"])) {
        echo json_encode(["status" => "invalid"]);
        exit;
    }

    $id = intval($input["id_buku"]);
    $nama = mysqli_real_escape_string($koneksi, $input["nama"]);
    $jenis = mysqli_real_escape_string($koneksi, $input["jenis"]);
    $tanggal = mysqli_real_escape_string($koneksi, $input["tanggal"]);
    $gambar = mysqli_real_escape_string($koneksi, $input["gambar"] ?? "");
    $status = mysqli_real_escape_string($koneksi, $input["status"] ?? "Tersedia");

    $sql = "UPDATE buku 
            SET nama='$nama', jenis='$jenis', tanggal='$tanggal', gambar='$gambar', status='$status'
            WHERE id_buku=$id";

    echo json_encode([
        "status" => mysqli_query($koneksi, $sql) ? "success" : "error"
    ]);
    exit;
}


elseif ($method === "DELETE") {

    $input = json_decode(file_get_contents("php://input"), true);
    $id = intval($input["id_buku"] ?? 0);

    if ($id === 0) {
        echo json_encode(["status" => "invalid"]);
        exit;
    }

    $sql = "DELETE FROM buku WHERE id_buku=$id";

    echo json_encode([
        "status" => mysqli_query($koneksi, $sql) ? "success" : "error"
    ]);
    exit;
}


echo json_encode(["status" => "method_not_allowed"]);
