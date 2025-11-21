<?php
session_start();
include "../back-end/koneksi.php";
header("Content-Type: application/json");

if (!isset($_SESSION['id_anggota'])) {
    echo json_encode(["status" => "error", "message" => "Belum login"]);
    exit;
}

$user = $_SESSION['id_anggota'];

$result = mysqli_query($koneksi,
    "SELECT * FROM sanksi 
     WHERE id_anggota='$user'
     ORDER BY id DESC"
);

$rows = [];
while ($r = mysqli_fetch_assoc($result)) {
    $rows[] = $r;
}

echo json_encode($rows);
