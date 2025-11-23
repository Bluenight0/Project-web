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

    // ==========================
    // 1. UPDATE MODE (PUT override)
    // ==========================
    if (isset($_POST["_method"]) && $_POST["_method"] === "PUT") {

        $id_buku = intval($_POST["id_buku"]);
        $nama    = mysqli_real_escape_string($koneksi, $_POST["nama"]);
        $jenis   = mysqli_real_escape_string($koneksi, $_POST["jenis"]);
        $tanggal = mysqli_real_escape_string($koneksi, $_POST["tanggal"]);
        $gambar  = mysqli_real_escape_string($koneksi, $_POST["gambar"]);
        $status  = mysqli_real_escape_string($koneksi, $_POST["status"]);

        $file_pdf = null;

        // upload PDF jika ada
        if (!empty($_FILES["file_pdf"]["name"])) {

            $dir = "../../uploads/pdf_buku/";
            if (!is_dir($dir)) mkdir($dir, 0777, true);

            $filename = time() . "_" . basename($_FILES["file_pdf"]["name"]);
            move_uploaded_file($_FILES["file_pdf"]["tmp_name"], $dir . $filename);

            $file_pdf = "uploads/pdf_buku/" . $filename;
        }

        // query update
        $sql = "UPDATE buku SET 
                nama='$nama',
                jenis='$jenis',
                tanggal='$tanggal',
                gambar='$gambar',
                status='$status'";

        if ($file_pdf) {
            $sql .= ", file_pdf='$file_pdf'";
        }

        $sql .= " WHERE id_buku=$id_buku";

        $ok = mysqli_query($koneksi, $sql);

        echo json_encode(["status" => $ok ? "success" : "error"]);
        exit;
    }

    // ==========================
    // 2. ADD MODE (TAMBAH BUKU)
    // ==========================
    $nama    = mysqli_real_escape_string($koneksi, $_POST["nama"]);
    $jenis   = mysqli_real_escape_string($koneksi, $_POST["jenis"]);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST["tanggal"]);
    $gambar  = mysqli_real_escape_string($koneksi, $_POST["gambar"]);
    $status  = mysqli_real_escape_string($koneksi, $_POST["status"]);

    $file_pdf = null;

    // upload file PDF
    if (!empty($_FILES["file_pdf"]["name"])) {

        $dir = "../../uploads/pdf_buku/";
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $filename = time() . "_" . basename($_FILES["file_pdf"]["name"]);
        move_uploaded_file($_FILES["file_pdf"]["tmp_name"], $dir . $filename);

        $file_pdf = "uploads/pdf_buku/" . $filename;
    }

    // query insert
    $sql = "INSERT INTO buku (nama, jenis, tanggal, gambar, status, file_pdf)
            VALUES ('$nama', '$jenis', '$tanggal', '$gambar', '$status', '$file_pdf')";

    $ok = mysqli_query($koneksi, $sql);

    echo json_encode([
        "status" => $ok ? "success" : "error",
        "sql_error" => mysqli_error($koneksi)
    ]);
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
