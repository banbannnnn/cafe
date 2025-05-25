<?php
session_start();

// Check if the logout is confirmed (cookie accepted)
if (isset($_GET['confirmed']) && $_GET['confirmed'] == 'true') {
    // User accepted cookies, now destroy the session
    session_unset();
    session_destroy();
    $loggedOut = true;
} else {
    $loggedOut = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Thank You | Blissful Bites</title>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet" />
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Quicksand', sans-serif;
      background: linear-gradient(-45deg, #fff0f5, #ffe0e9, #ffe8f0, #fff5f8);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      overflow: hidden;
      position: relative;
    }

    canvas.confetti-canvas {
      position: absolute;
      top: 0;
      left: 0;
      z-index: 0;
      pointer-events: none;
    }

    .logout-container {
      background-color: white;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      text-align: center;
      animation: slideFade 1s ease forwards;
      max-width: 400px;
      z-index: 1;
    }

    .logout-container h1 {
      font-size: 2rem;
      color: #d76d77;
      margin-bottom: 15px;
    }

    .logout-container p {
      font-size: 1.1rem;
      color: #444;
      margin-bottom: 30px;
    }

    .logout-container img {
      width: 120px;
      animation: wave 2s infinite ease-in-out;
      transform-origin: bottom center;
    }

    .btn-home {
      background-color:rgb(255, 182, 205);
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 30px;
      font-size: 1rem;
      cursor: pointer;
      text-decoration: none;
      transition: background-color 0.3s ease;
      display: inline-block;
    }

    .btn-home:hover {
      background-color:rgb(255, 140, 188);
    }

    @keyframes slideFade {
      from {
        opacity: 0;
        transform: translateY(40px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes wave {
      0% { transform: rotate(0deg); }
      20% { transform: rotate(15deg); }
      40% { transform: rotate(-10deg); }
      60% { transform: rotate(10deg); }
      80% { transform: rotate(-5deg); }
      100% { transform: rotate(0deg); }
    }

    #cookie-consent {
      position: fixed;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      background: white;
      border-radius: 10px;
      padding: 20px 30px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      font-family: 'Quicksand', sans-serif;
      max-width: 400px;
      display: none;
      z-index: 1000;
      text-align: center;
    }

    #cookie-consent button {
      background-color: rgb(255, 182, 205);
      border: none;
      border-radius: 25px;
      padding: 10px 20px;
      font-weight: 700;
      cursor: pointer;
      color: white;
      margin-top: 15px;
    }

    #cookie-consent button:hover {
      background-color: rgb(255, 140, 188);
    }
  </style>
</head>
<body>
  <?php if ($loggedOut): ?>
    <!-- Show your thank you message after logout -->
    <canvas class="confetti-canvas"></canvas>

    <div class="logout-container">
      <img src="cupcake2.png" alt="Thank You" />
      <h1>Thank You for Your Time!</h1>
      <p>We truly appreciate you for choosing <strong>Blissful Bites</strong> today. Come back soon for more delicious moments.</p>
      <a href="register.php" class="btn-home">Okay</a>
    </div>

    <script>
      const canvas = document.querySelector('.confetti-canvas');
      const ctx = canvas.getContext('2d');
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;

      const confetti = Array.from({ length: 150 }, () => ({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height - canvas.height,
        r: Math.random() * 6 + 2,
        d: Math.random() * 0.5 + 0.5,
        color: `hsl(${Math.random() * 360}, 70%, 70%)`,
        tilt: Math.random() * 10 - 5
      }));

      function drawConfetti() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        confetti.forEach(p => {
          ctx.beginPath();
          ctx.fillStyle = p.color;
          ctx.ellipse(p.x + p.tilt, p.y, p.r, p.r * 0.6, 0, 0, Math.PI * 2);
          ctx.fill();
        });
        updateConfetti();
      }

      function updateConfetti() {
        confetti.forEach(p => {
          p.y += p.d * 4;
          p.x += Math.sin(p.y * 0.01);
          if (p.y > canvas.height) {
            p.y = -10;
            p.x = Math.random() * canvas.width;
          }
        });
      }

      function animate() {
        drawConfetti();
        requestAnimationFrame(animate);
      }

      animate();
      window.addEventListener('resize', () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
      });
    </script>

  <?php else: ?>
    <!-- Show cookie consent prompt before logout -->
    <div id="cookie-consent">
      <p>We use cookies to improve your experience. Please accept cookies to proceed with logout.</p>
      <button id="accept-cookies">Accept Cookies & Logout</button>
    </div>

    <script>
      // Check if user already accepted cookies for this session
      const consent = sessionStorage.getItem('cookieAccepted');
      const consentBox = document.getElementById('cookie-consent');
      const acceptBtn = document.getElementById('accept-cookies');

      if (consent === 'true') {
        // Already accepted in this session, redirect
        window.location.href = 'logout.php?confirmed=true';
      } else {
        // Show consent box
        consentBox.style.display = 'block';
      }

      acceptBtn.addEventListener('click', () => {
        sessionStorage.setItem('cookieAccepted', 'true');
        window.location.href = 'logout.php?confirmed=true';
      });
    </script>
  <?php endif; ?>
</body>
</html>
