<?php
require 'koneksi.php';

$aksi = $_POST['aksi'] ?? '';
$id   = $_POST['id'] ?? '';
$nama = $_POST['nama'] ?? '';
$jenis = $_POST['jenis'] ?? '';
$tanggal = $_POST['tanggal'] ?? '';

if ($aksi == "tambah") {
    $sql = "INSERT INTO buku (nama, jenis, tanggal) VALUES ('$nama','$jenis','$tanggal')";
    mysqli_query($koneksi, $sql);
} elseif ($aksi == "edit" && $id) {
    $sql = "UPDATE buku SET nama='$nama', jenis='$jenis', tanggal='$tanggal' WHERE id=$id";
    mysqli_query($koneksi, $sql);
} elseif ($aksi == "hapus" && $id) {
    $sql = "DELETE FROM buku WHERE id=$id";
    mysqli_query($koneksi, $sql);
}

// setelah aksi selesai, kembali ke index.php
header("Location: index.php");
exit;
?>
