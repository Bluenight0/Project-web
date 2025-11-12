<?php
$conn = mysqli_connect("localhost", "aditya", "kolot123", "perpustakaan", 3307);

// Check connection
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit;
}
?>
