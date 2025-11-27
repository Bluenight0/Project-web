<?php
session_start();
header("Content-Type: application/json");
include "koneksi.php";

// Pastikan POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "msg" => "Invalid request"]);
    exit;
}

// Ambil input
$username = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";

// Query cek admin
$q = mysqli_query(
    $koneksi,
    "SELECT * FROM admin_perpus WHERE nama_admin='$username' LIMIT 1"
);

if ($q && mysqli_num_rows($q) === 1) {

    $admin = mysqli_fetch_assoc($q);

    // cocok password (tanpa hash)
    if ($password === $admin["password"]) {

        $_SESSION["role"] = "admin";
        $_SESSION["id_admin"] = $admin["id_admin"];
        $_SESSION["admin_name"] = $admin["nama_admin"];

        echo json_encode([
            "success" => true,
            "role" => "admin",
            "redirect" => "admin/index.php"
        ]);
        exit;
    }
}

// kalau gagal
echo json_encode(["success" => false, "msg" => "Login gagal"]);
