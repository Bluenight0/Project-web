<?php
session_start();
include "../back-end/koneksi.php";

if (!isset($_SESSION['id_anggota'])) {
    header("Location: ../login/user.php");
    exit;
}

$id = $_SESSION['id_anggota'];
 
// Ambil input dari form
$nama = $_POST['nama'];
$email = $_POST['email'];
$telepon = $_POST['no_hp'];
$alamat = $_POST['alamat'];
$query = "UPDATE anggota_perpus 
          SET nama='$nama', alamat='$alamat', no_hp='$telepon', email='$email' 
          WHERE id_anggota='$id'";

if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Profil berhasil diperbarui'); window.location='profil.php';</script>";
} else {
    echo "<script>alert('Gagal update profil'); window.location='profil.php';</script>";
}
?>
