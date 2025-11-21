<?php
header("Content-Type: application/json");
session_start();
include "koneksi.php";

// User harus login
if (!isset($_SESSION['id_anggota'])) {
    echo json_encode(["status" => "error", "message" => "Belum login"]);
    exit;
}

$user_id = $_SESSION['id_anggota'];
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);

switch ($method) {

    // ============================
    // IKUT EVENT (POST)
    // ============================
    case "POST":
        $event = intval($input['id_event']);

        // Cek apakah sudah ikut
        $check = mysqli_query($koneksi,
            "SELECT id_peserta FROM peserta_event 
             WHERE id_event=$event AND id_anggota='$user_id'"
        );

        if (mysqli_num_rows($check) > 0) {
            echo json_encode(["status" => "error", "message" => "Sudah ikut"]);
            exit;
        }

        // Simpan
        $insert = mysqli_query($koneksi,
            "INSERT INTO peserta_event (id_event, id_anggota, tgl_daftar) 
             VALUES ($event, '$user_id', NOW())"
        );

        echo json_encode(["status" => $insert ? "success" : "error"]);
        break;

    // ============================
    // BATAL IKUT (DELETE)
    // ============================
    case "DELETE":
        $event = intval($input['id_event']);
        
        $delete = mysqli_query($koneksi,
            "DELETE FROM peserta_event 
             WHERE id_event=$event AND id_anggota='$user_id'"
        );

        echo json_encode(["status" => $delete ? "success" : "error"]);
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method tidak diizinkan"]);
}
