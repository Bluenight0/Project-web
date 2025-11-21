<?php
session_start();
header("Content-Type: application/json");
include "koneksi.php";

// Cek apakah request POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "msg" => "Invalid request"]);
    exit;
}

// Ambil input
$username = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";

// DEBUG
file_put_contents("TES_LOGIN.txt", "USERNAME=$username\nPASSWORD=$password\n", FILE_APPEND);

// ======================================
// LOGIN ADMIN SEDERHANA DULU
// ======================================

// Cek admin
$q = mysqli_query(
    $koneksi,
    "SELECT * FROM admin_perpus WHERE nama_admin='$username' LIMIT 1"
);

if ($q && mysqli_num_rows($q) === 1) {

    $admin = mysqli_fetch_assoc($q);

    // TANPA HASH DULU
    if ($password === "123456") {

        $_SESSION["role"] = "admin";
        $_SESSION["admin_id"] = $admin["id_admin"];
        $_SESSION["admin_name"] = $admin["nama_admin"];

        echo json_encode([
            "success" => true,
            "role" => "admin",
            "redirect" => "/project/admin/index.php"
        ]);
        exit;
    }
}

// Kalau gagal:
echo json_encode(["success" => false, "msg" => "Login gagal"]);
