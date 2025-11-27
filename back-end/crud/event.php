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

    // admin ID sementara (karena wajib NOT NULL)
    $id_admin = 1;

    // ==========================
    // DELETE
    // ==========================
    if (isset($_POST["delete"]) && isset($_POST["id_event"])) {
        $id = intval($_POST["id_event"]);

        mysqli_query($koneksi, "DELETE FROM event_perpus WHERE id_event = $id");

        echo json_encode(["status" => mysqli_affected_rows($koneksi) > 0 ? "deleted" : "failed"]);
        exit;
    }

    // ==========================
    // DATA UTAMA
    // ==========================
    $id_event        = $_POST["id_event"] ?? "";
    $judul           = mysqli_real_escape_string($koneksi, $_POST["judul"]);
    $deskripsi       = mysqli_real_escape_string($koneksi, $_POST["deskripsi"]);
    $tanggal_mulai   = mysqli_real_escape_string($koneksi, $_POST["tanggal_mulai"]);
    $tanggal_selesai = mysqli_real_escape_string($koneksi, $_POST["tanggal_selesai"]);
    $lokasi          = mysqli_real_escape_string($koneksi, $_POST["lokasi"]);
    $link_event      = mysqli_real_escape_string($koneksi, $_POST["link_event"]);

    // ==========================
    // PROSES UPLOAD GAMBAR
    // ==========================
    $gambarPath = null;

    if (!empty($_FILES["gambar"]["name"])) {
        $dir = "../../uploads/event_img/";
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $filename = time() . "_" . basename($_FILES["gambar"]["name"]);
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $dir . $filename);

        $gambarPath = "uploads/event_img/" . $filename;
    }

    // ==========================
    // INSERT EVENT BARU
    // ==========================
    if ($id_event === "") {

        $sql = "
            INSERT INTO event_perpus 
            (id_admin, judul, deskripsi, tanggal_mulai, tanggal_selesai, lokasi, link_event, gambar)
            VALUES
            ($id_admin, '$judul', '$deskripsi', '$tanggal_mulai', '$tanggal_selesai', '$lokasi', '$link_event', " . 
            ($gambarPath ? "'$gambarPath'" : "NULL") . ")
        ";

        mysqli_query($koneksi, $sql);

        echo json_encode(["status" => mysqli_affected_rows($koneksi) > 0 ? "inserted" : "failed"]);
        exit;
    }

    // ==========================
    // UPDATE EVENT
    // ==========================
    $sql = "
        UPDATE event_perpus SET
            judul='$judul',
            deskripsi='$deskripsi',
            tanggal_mulai='$tanggal_mulai',
            tanggal_selesai='$tanggal_selesai',
            lokasi='$lokasi',
            link_event='$link_event'
    ";

    // Tambahkan update gambar jika admin upload gambar baru
    if ($gambarPath) {
        $sql .= ", gambar='$gambarPath'";
    }

    $sql .= " WHERE id_event=$id_event";

    mysqli_query($koneksi, $sql);

    echo json_encode(["status" => mysqli_affected_rows($koneksi) > 0 ? "updated" : "failed"]);
    exit;
}

echo json_encode(["status" => "invalid"]);
?>
