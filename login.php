<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['Admin'];
  $password = $_POST['Password'];

  // Cek data di database
  $sql = "SELECT * FROM admin WHERE Admin='$username' AND Password='$password'";
  $result = mysqli_query($koneksi, $sql);

  if (mysqli_num_rows($result) > 0) {
    // Jika berhasil login
    header("Location: dashboard.php"); // akan diarahkan ke halaman lain
    exit;
  } else {
    echo "<script>alert('Username atau password salah!');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script> -->
    <link rel="stylesheet" href="login.css" />
    <title>Document</title>
  </head>
  <body>
    <div class="circle"></div>
    <div class="background"></div>
    <div
      class="container d-flex justify-content-center align-items-center vh-100"
    >
      <div class="card shadow p-3 rounded" style="width: 22rem">
        <div class="card-body">
          <h3>login</h3>
          <form method="POST" action="">
  <div class="mb-3">
    <label for="Admin" class="form-label">Username:</label>
    <input
      type="text"
      class="form-control"
      id="Admin"
      placeholder="Enter Username"
      name="Admin"
    />
  </div>
  <div class="mb-3">
    <label for="Password" class="form-label">Password:</label>
    <input
      type="password"
      class="form-control"
      id="Password"
      placeholder="Enter password"
      name="Password"
    />
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

        </div>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script>
      // Animasi Card Zoom Out
      anime({
        targets: ".card",
        opacity: [0, 1],
        scale: [1.3, 1],
        filter: ["blur(10px)", "blur(0px)"],
        easing: "easeOutExpo",
        duration: 1200,
        delay: 400,
      });

      // 🌠 Background Circle Bergerak
      anime({
        targets: ".circle",
        translateX: () => anime.random(-300, 300),
        translateY: () => anime.random(-200, 200),
        scale: () => anime.random(0.5, 1.5),
        duration: 4000,
        direction: "alternate",
        easing: "easeInOutSine",
        loop: true,
      });

      // 🌌 Geometri Background
      const bg = document.querySelector(".background");
      for (let i = 0; i < 25; i++) {
        const s = document.createElement("div");
        s.classList.add("shape");
        s.style.left = Math.random() * 100 + "%";
        s.style.top = Math.random() * 100 + "%";
        s.style.animationDuration = 8 + Math.random() * 10 + "s";
        s.style.animationDelay = Math.random() * 5 + "s";
        s.style.width = s.style.height = 30 + Math.random() * 60 + "px";
        bg.appendChild(s);
      }
    </script>
    <script src="logic.js"></script>
  </body>
</html>
