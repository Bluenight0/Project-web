<?php
include "../koneksi.php";
header("Content-Type: application/json");

// Ambil data status peminjaman
$q = mysqli_query($koneksi, "
    SELECT 
        p.id,
        a.nama AS nama_peminjam,
        b.nama AS judul,
        p.tgl_pinjam,
        p.batas_waktu AS jatuh_tempo,
        p.status
    FROM peminjaman p
    JOIN anggota_perpus a ON a.id_anggota = p.id_anggota
    JOIN buku b ON b.id_buku = p.id_buku
    ORDER BY p.id DESC
");

$data = [];
while ($row = mysqli_fetch_assoc($q)) {
    $data[] = $row;
}

echo json_encode($data);
