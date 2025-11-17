<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script> -->
  <link rel="stylesheet" href="assets/login.css" />
  <title>Document</title>

<style>
    
body {
  margin: 0;
  height: 100vh;
  background: #0b132b;
  overflow: hidden;
  font-family: "Poppins", sans-serif;
}

/* 🌌 Background Geometri */
.background {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
  overflow: hidden;
}

.shape {
  position: absolute;
  background: rgba(255, 255, 255, 0.08);
  clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
  animation: float 10s infinite ease-in-out;
}

@keyframes float {
  0% {
    transform: translateY(0) rotate(0deg);
    opacity: 0.7;
  }
  50% {
    transform: translateY(-40px) rotate(180deg);
    opacity: 1;
  }
  100% {
    transform: translateY(0) rotate(360deg);
    opacity: 0.7;
  }
}

/* 🔵 Circle Animasi */
.circle {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 40px;
  height: 40px;
  background: rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  transform: translate(-50%, -50%);
  z-index: 1;
}

/* 🩵 Card Transparan (Glass Effect) */
.card {
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  color: white;
  box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
  opacity: 0;              /* awal animasi */
  transform: scale(1.3);   /* awal zoom besar */
  z-index: 10;             /* di atas background */
}

/* 🔘 Input dan Tombol */
input {
  display: block;
  margin: 10px auto;
  padding: 10px;
  width: 200px;
  border: none;
  border-radius: 5px;
  outline: none;
}

button {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  background: #1c7ed6;
  color: white;
  cursor: pointer;
  transition: background 0.3s;
}

button:hover {
  background: #4dabf7;
}


</style>
</head>
<body>
  <div class="circle"></div>
  <div class="background"></div>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-3 rounded" style="width: 22rem">
      <div class="card-body">
        <h3>login</h3>
        <form method="POST" action="">
          <div class="mb-3">
            <label for="Admin" class="form-label">Username:</label>
            <input type="text" class="form-control" id="Admin" placeholder="Enter Username" name="Admin" />
          </div>
          <div class="mb-3">
            <label for="Password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="Password" placeholder="Enter password" name="Password" />
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

const form = document.querySelector("form");

form.addEventListener("submit", async (event) => {
  event.preventDefault();

  const formData = new FormData(form);

  // kirim ke PHP
  const response = await fetch("login.php", {
    method: "POST",
    body: formData,
  });

  const result = await response.json();

  if (result.success) {
    // login benar, jalankan animasi keluar
    anime({
      targets: ".card",
      opacity: [1, 0],
      scale: [1, 1.3],
      filter: ["blur(0px)", "blur(10px)"],
      easing: "easeInBack",
      duration: 700,
      complete: () => {
        window.location.href = "./admin/dashbboard.html";
      },
    });
  } else {
    alert("Username atau password salah!");
  }
});
</script>
</body>

</html>