<?php
session_start();
include "../back-end/koneksi.php";

if (!isset($_SESSION['id_anggota'])) {
    header("Location: ../login/user.php");
    exit;
}

$id = $_SESSION['id_anggota'];

$folder = "../back-end/uploads/foto_anggota/";
if (!is_dir($folder)) mkdir($folder, 0777, true);

if (!empty($_FILES['foto']['name'])) {

    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $fileName = $id . "." . $ext;
    $target = $folder . $fileName;

    // Hapus foto lama (jika ada)
    foreach (['jpg','jpeg','png','webp'] as $oldExt) {
        $oldFile = $folder . $id . "." . $oldExt;
        if (file_exists($oldFile)) unlink($oldFile);
    }

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
        // Simpan nama foto ke database
        $sql = "UPDATE anggota_perpus SET foto='$fileName' WHERE id_anggota='$id'";
        mysqli_query($koneksi, $sql);

        echo "<script>alert('Foto berhasil diperbarui!'); window.location='profil.php';</script>";
        exit;
    } else {
        echo "<script>alert('Upload gagal!'); window.location='profil.php';</script>";
        exit;
    }
}
?>
