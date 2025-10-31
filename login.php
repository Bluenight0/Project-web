<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['Admin'];
  $password = $_POST['Password'];

  $sql = "SELECT * FROM admin WHERE Admin='$username' AND Password='$password'";
  $result = mysqli_query($koneksi, $sql);

  if (mysqli_num_rows($result) > 0) {
    echo json_encode(["success" => true]);
  } else {
    echo json_encode(["success" => false]);
  }
  exit;
}
?>