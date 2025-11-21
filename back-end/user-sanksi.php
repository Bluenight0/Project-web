<?php
include 'koneksi.php';
header("Content-Type: application/json");

if (isset($_GET['user'])) {
  $user = mysqli_real_escape_string($conn, $_GET['user']);
  $result = mysqli_query($conn, "SELECT sanksi_aktif, sanksi_mulai FROM users WHERE username='$user'");
  if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode($row);
  } else {
    echo json_encode(["sanksi_aktif" => 0]);
  }
}
?>
