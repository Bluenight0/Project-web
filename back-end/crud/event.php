<?php
header("Content-Type: application/json");
session_start();
include "../back-end/koneksi.php";

// Ambil user login (jika ada)
$user_id = $_SESSION['id_anggota'] ?? null;

// Ambil semua event
$sql = "SELECT * FROM event_perpus ORDER BY tanggal_mulai ASC";
$result = mysqli_query($koneksi, $sql);

$events = [];

while ($row = mysqli_fetch_assoc($result)) {

    // Cek apakah user sudah ikut event
    $ikut = false;
    if ($user_id) {
        $cek = mysqli_query($koneksi, "
            SELECT id_peserta FROM peserta_event 
            WHERE id_event = '{$row['id_event']}' 
              AND id_anggota = '$user_id'
        ");

        if (mysqli_num_rows($cek) > 0) {
            $ikut = true;
        }
    }

    $row['ikut'] = $ikut;
    $events[] = $row;
}

echo json_encode($events);
