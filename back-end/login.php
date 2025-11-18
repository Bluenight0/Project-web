<?php
header("Content-Type: application/json");
include "koneksi.php";

// ambil input dari JS
$username = $_POST['nama_admin'] ?? '';
$password = $_POST['password'] ?? '';

// query tabel admin
$query = "SELECT * FROM admin_perpus WHERE nama_admin = '$username' AND password = '$password'";
$result = mysqli_query($koneksi, $query);

$response = [];

if (mysqli_num_rows($result) > 0) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

echo json_encode($response);
exit;
