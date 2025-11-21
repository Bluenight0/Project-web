<?php
include "../koneksi.php";
header("Content-Type: application/json");

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {

    $q = mysqli_query($koneksi, "SELECT * FROM event_perpus ORDER BY id_event DESC");

    $data = [];
    while ($row = mysqli_fetch_assoc($q)) {
        $data[] = $row;
    }

    echo json_encode($data);
    exit;
}

if ($method === "POST") {

    // FIX: event selalu butuh id_admin (NOT NULL)
    $id_admin = 1;

    // Jika ada parameter delete → jalankan DELETE
    if (isset($_POST["delete"]) && isset($_POST["id_event"])) {
        $id = intval($_POST["id_event"]);

        mysqli_query($koneksi, "DELETE FROM event_perpus WHERE id_event = $id");

        echo json_encode(["status" => mysqli_affected_rows($koneksi) > 0 ? "deleted" : "failed"]);
        exit;
    }

    // Normal INSERT / UPDATE
    $id_event        = $_POST["id_event"] ?? "";
    $judul           = $_POST["judul"];
    $deskripsi       = $_POST["deskripsi"];
    $tanggal_mulai   = $_POST["tanggal_mulai"];
    $tanggal_selesai = $_POST["tanggal_selesai"];
    $lokasi          = $_POST["lokasi"];
    $link_event      = $_POST["link_event"];

    if ($id_event === "") {

        mysqli_query($koneksi, "
            INSERT INTO event_perpus 
            (id_admin, judul, deskripsi, tanggal_mulai, tanggal_selesai, lokasi, link_event)
            VALUES
            ($id_admin, '$judul', '$deskripsi', '$tanggal_mulai', '$tanggal_selesai', '$lokasi', '$link_event')
        ");

        echo json_encode(["status" => mysqli_affected_rows($koneksi) > 0 ? "inserted" : "failed"]);
        exit;

    } else {

        mysqli_query($koneksi, "
            UPDATE event_perpus SET
                judul='$judul',
                deskripsi='$deskripsi',
                tanggal_mulai='$tanggal_mulai',
                tanggal_selesai='$tanggal_selesai',
                lokasi='$lokasi',
                link_event='$link_event'
            WHERE id_event=$id_event
        ");

        echo json_encode(["status" => mysqli_affected_rows($koneksi) > 0 ? "updated" : "failed"]);
        exit;
    }
}

echo json_encode(["status" => "invalid"]);
?>
