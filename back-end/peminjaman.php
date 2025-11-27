<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

header("Content-Type: application/json");
include "koneksi.php";

$method = $_SERVER["REQUEST_METHOD"];

function generateToken($len = 16) {
    return bin2hex(random_bytes($len));
}

switch ($method) {

    case "GET":
        $q = mysqli_query($koneksi,
            "SELECT * FROM peminjaman ORDER BY tgl_pinjam DESC"
        );
        $rows = [];
        while ($r = mysqli_fetch_assoc($q)) $rows[] = $r;
        echo json_encode($rows);
        break;

    case "POST":
        $input = json_decode(file_get_contents("php://input"), true);

        $id_buku    = intval($input["id_buku"]);
        $id_anggota = intval($input["id_anggota"]);
        $tglPinjam  = date("Y-m-d");
        $batasWaktu = 3;
        $qr_token   = generateToken(8);

        $sql = "INSERT INTO peminjaman 
                (id_buku, id_anggota, qr_token, tgl_pinjam, batas_waktu, status)
                VALUES 
                ($id_buku, $id_anggota, '$qr_token', '$tglPinjam', $batasWaktu, 'Menunggu')";

        $ok = mysqli_query($koneksi, $sql);

        echo json_encode([
            "status" => $ok ? "success" : "error",
            "qr_token" => $qr_token,
            "sql_error" => mysqli_error($koneksi)
        ]);
        break;

    case "PUT":
        $input = json_decode(file_get_contents("php://input"), true);

        $id     = intval($input["id"]);
        $status = mysqli_real_escape_string($koneksi, $input["status"]);
        $tgl    = $status === "Dikembalikan" ? "'" . date("Y-m-d") . "'" : "NULL";

        $sql = "UPDATE peminjaman 
                SET status='$status', tgl_kembali=$tgl 
                WHERE id=$id";

        $ok = mysqli_query($koneksi, $sql);

        echo json_encode(["status" => $ok ? "success" : "error"]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed"]);
}
