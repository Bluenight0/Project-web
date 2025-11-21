<?php
include "koneksi.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_anggota'];
    $password = $_POST['password']; 
    $nama = $_POST['nama_anggota'];

    $query = "SELECT * FROM anggota_perpus WHERE id_anggota='$id' AND password='$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['id_anggota'] = $id;
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Username atau password salah!'); window.location='user.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.55),
                    rgba(0, 0, 0, 0.55)),
                url("https://i.pinimg.com/1200x/5e/73/e0/5e73e0dc7a90bb11a7fd05f9f6e608c8.jpg") no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            font-family: "Poppins", sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 15px;
            padding: 40px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.8s ease;
        }

        .login-box h2 {
            font-weight: 700;
            text-align: center;
            margin-bottom: 25px;
            color: #212529;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-primary {
            border-radius: 8px;
            font-weight: 500;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0d6efd;
            transform: translateY(-2px);
            transition: all 0.2s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .footer-text {
            text-align: center;
            font-size: 0.9rem;
            color: #555;
            margin-top: 15px;
        }

        .footer-text a {
            color: #0d6efd;
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Login User</h2>
        <form action="user.php" method="POST">
            <div class="mb-3">
                <label for="id_anggota" class="form-label">ID Anggota</label>
                <input type="text" class="form-control" name="id_anggota" id="id_anggota"
                    placeholder="Masukkan id_anggota" required />
            </div>
            <div class="mb-3">
                <label for="nama_anggota" class="form-label">Username</label>
                <input type="text" class="form-control" name="nama_anggota" id="nama_anggota"
                    placeholder="Masukkan nama anggota" required />

            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password"
                    placeholder="Masukkan password" required />
            </div>
            <button type="submit" class="btn btn-primary mt-3">Login</button>
        </form>

        <div class="footer-text">
            Belum punya akun?
            <a href="register.php">Daftar Sekarang</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>