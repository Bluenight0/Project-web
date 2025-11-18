<?php
header("Content-Type: application/json");
session_start();
include "../back-end/koneksi.php";

// Pastikan user login
$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

// Ambil semua event
$result = $conn->query("SELECT * FROM events ORDER BY tanggal ASC");
$events = [];

while($row = $result->fetch_assoc()){
    $event_id = $row['id'];
    
    // Cek apakah user sudah ikut event ini
    $ikut = false;
    if($user_id){
        $cek = $conn->query("SELECT id FROM peserta_event WHERE event_id=$event_id AND user_id=$user_id");
        if($cek && $cek->num_rows > 0){
            $ikut = true;
        }
    }

    $row['ikut'] = $ikut; // tambahkan field 'ikut'
    $events[] = $row;
}

echo json_encode($events);
?>
