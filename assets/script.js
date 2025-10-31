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
        window.location.href = "dashboard.php";
      },
    });
  } else {
    alert("Username atau password salah!");
  }
});
