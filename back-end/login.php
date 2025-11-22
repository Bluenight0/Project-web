<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="../assets/login.css" />
  <title>Login</title>

<style>
/* —— SEMUA STYLE SENPAI TETAP —— */
body {
  margin: 0;
  height: 100vh;
  background: #0b132b;
  overflow: hidden;
  font-family: "Poppins", sans-serif;
}
.background { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; overflow: hidden; }
.shape { position: absolute; background: rgba(255,255,255,0.08); clip-path: polygon(50% 0%,0% 100%,100% 100%); animation: float 10s infinite ease-in-out; }

@keyframes float {
  0% { transform: translateY(0) rotate(0deg); opacity: 0.7; }
  50% { transform: translateY(-40px) rotate(180deg); opacity: 1; }
  100% { transform: translateY(0) rotate(360deg); opacity: 0.7; }
}

.circle { position: absolute; top: 50%; left: 50%; width: 40px; height: 40px; background: rgba(255,255,255,0.3); border-radius: 50%; transform: translate(-50%, -50%); z-index: 1; }

.card {
  background: rgba(255,255,255,0.15);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255,255,255,0.2);
  color: white;
  box-shadow: 0 0 20px rgba(255,255,255,0.1);
  opacity: 0;
  transform: scale(1.3);
  z-index: 10;
}

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

button:hover { background: #4dabf7; }
</style>

</head>

<body>
  <div class="circle"></div>
  <div class="background"></div>

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-3 rounded" style="width: 22rem">
      <div class="card-body">
        <h3>Login</h3>

        <!-- ⚠️ FORM DIBENERKAN UNTUK UNIFIED LOGIN -->
        <form id="loginForm" method="POST" action="auth.php">
          <div class="mb-3">
            <label class="form-label">Username:</label>
            <input type="text" class="form-control" name="username" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Password:</label>
            <input type="password" class="form-control" name="password" required />
          </div>

          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

      </div>
    </div>
  </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

<script>
// ANIMASI MASUK
anime({
  targets: ".card",
  opacity: [0, 1],
  scale: [1.3, 1],
  easing: "easeOutExpo",
  duration: 1200,
  delay: 400,
});

// BACKGROUND ANIMASI
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

// GEOMETRI BACKGROUND
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

// =============================
//   LOGIN AJAX (AMEND)
// =============================


document.getElementById("loginForm").addEventListener("submit", async (e) => {
  e.preventDefault();
  
  const formData = new FormData(e.target);
  console.log("FETCH START");

  const response = await fetch("auth.php", {
    method: "POST",
    body: new FormData(document.getElementById("loginForm")),
});
console.log("FETCH DONE");

const result = await response.json();
console.log("RESULT:", result);



  if (result.success) {

    anime({
      targets: ".card",
      opacity: [1, 0],
      scale: [1, 1.3],
      easing: "easeInBack",
      duration: 700,
      complete: () => {
        window.location.href = result.redirect;
      },
    });

  } else {
    alert("Username atau password salah!");
  }
});
</script>

</body>
</html>
