<?php
include "../back-end/koneksi.php";
header("Content-Type: application/json");

$method = $_SERVER["REQUEST_METHOD"];
$input = json_decode(file_get_contents("php://input"), true);

switch ($method) {

    // =====================================
    // GET — ambil semua data sanksi
    // =====================================
    case "GET":
        $sql = "
            SELECT 
                s.id,
                s.id_anggota,
                a.nama AS nama_anggota,
                s.mulai,
                s.selesai,
                s.denda
            FROM sanksi s
            LEFT JOIN anggota_perpus a
                ON s.id_anggota = a.id_anggota
            ORDER BY s.id DESC
        ";

        $result = mysqli_query($koneksi, $sql);
        $rows = [];

        while ($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }

        echo json_encode($rows);
        break;


    // =====================================
    // POST — buat sanksi baru
    // =====================================
    case "POST":
        $anggota = $input['id_anggota'];
        $mulai   = $input['mulai'];
        $selesai = $input['selesai'];
        $denda   = $input['denda'];

        $insert = mysqli_query($koneksi,
            "INSERT INTO sanksi (id_anggota, mulai, selesai, denda)
             VALUES ('$anggota', '$mulai', '$selesai', '$denda')"
        );

        echo json_encode(["status" => $insert ? "success" : "error"]);
        break;


    // =====================================
    // DELETE — hapus sanksi
    // =====================================
    case "DELETE":
        $id = intval($input['id']);

        $delete = mysqli_query($koneksi,
            "DELETE FROM sanksi WHERE id=$id"
        );

        echo json_encode(["status" => $delete ? "success" : "error"]);
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method tidak diizinkan"]);
}
