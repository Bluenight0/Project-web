<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// POSISI BENAR → dari folder /crud ke /back-end
include "../koneksi.php";

$method = $_SERVER["REQUEST_METHOD"];

function getInput() {
    $json = json_decode(file_get_contents("php://input"), true);
    return $json !== null ? $json : $_POST;
}

if ($method === "GET") {
    $q = mysqli_query($GLOBALS['koneksi'], "SELECT * FROM buku ORDER BY id_buku DESC");
    $data = [];
    while ($row = mysqli_fetch_assoc($q)) $data[] = $row;
    echo json_encode($data);
    exit;
}

if ($method === "POST") {
    $i = getInput();

    if (empty($i["nama"]) || empty($i["jenis"]) || empty($i["tanggal"])) {
        echo json_encode(["status" => "invalid"]); exit;
    }

    $nama    = mysqli_real_escape_string($koneksi, $i["nama"]);
    $jenis   = mysqli_real_escape_string($koneksi, $i["jenis"]);
    $tanggal = mysqli_real_escape_string($koneksi, $i["tanggal"]);
    $gambar  = mysqli_real_escape_string($koneksi, $i["gambar"] ?? "");
    $status  = mysqli_real_escape_string($koneksi, $i["status"] ?? "Tersedia");

    $sql = "INSERT INTO buku (nama, jenis, tanggal, gambar, status)
            VALUES ('$nama', '$jenis', '$tanggal', '$gambar', '$status')";

    $ok = mysqli_query($koneksi, $sql);

    echo json_encode(["status" => $ok ? "success" : "error",
                      "sql_error" => mysqli_error($koneksi)]);
    exit;
}

if ($method === "DELETE") {
    $i = getInput();
    $id = intval($i["id_buku"] ?? 0);

    if ($id == 0) {
        echo json_encode(["status" => "invalid"]); exit;
    }

    $ok = mysqli_query($koneksi, "DELETE FROM buku WHERE id_buku=$id");

    echo json_encode(["status" => $ok ? "success" : "error"]);
    exit;
}

echo json_encode(["status" => "method_not_allowed"]);
