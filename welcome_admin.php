<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Welcome Admin - Blissful Bites</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@400;700&display=swap');

    * {
      box-sizing: border-box;
    }

    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #fff0f6, #ffd6de);
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      flex-direction: column;
    }

    .welcome-box {
      text-align: center;
      color: #8c2f52;
      animation: popIn 1.2s ease-out;
    }

    h1 {
      font-family: 'Pacifico', cursive;
      font-size: 3rem;
      margin: 0;
      color: #d95b8d;
      text-shadow: 2px 2px 5px rgba(217, 91, 141, 0.3);
    }

    .subtext {
      font-size: 1.2rem;
      margin-top: 10px;
      color: #7a2f4a;
      animation: fadeInUp 2s ease-in-out;
    }

    .pastry-loader {
      display: flex;
      justify-content: center;
      margin-top: 40px;
      gap: 25px;
    }

    .pastry {
      font-size: 2.8rem;
      animation: float 2s ease-in-out infinite;
    }

    .pastry:nth-child(1)::before {
      content: '🍩'; /* Donut */
      animation-delay: 0s;
    }

    .pastry:nth-child(2)::before {
      content: '🧁'; /* Cupcake */
      animation-delay: 0.3s;
    }

    .pastry:nth-child(3)::before {
      content: '🍬'; /* Candy */
      animation-delay: 0.6s;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-15px); }
    }

    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes popIn {
      0% { transform: scale(0.7); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }

    .fade-out {
      animation: fadeOut 1s forwards;
    }

    @keyframes fadeOut {
      to {
        opacity: 0;
        visibility: hidden;
      }
    }

    .sprinkle {
      position: absolute;
      width: 8px;
      height: 8px;
      background-color: #f28ab1;
      border-radius: 50%;
      animation: sprinkle-fall 5s linear infinite;
      opacity: 0.7;
    }

    @keyframes sprinkle-fall {
      0% {
        transform: translateY(-10%);
        opacity: 0.7;
      }
      100% {
        transform: translateY(110vh);
        opacity: 0;
      }
    }
  </style>
</head>
<body>
  <div id="loading-screen" class="welcome-box">
    <h1>Welcome Back, Admin!</h1>
    <div class="subtext">Loading your Blissful Bites dashboard...</div>
    <div class="pastry-loader">
      <div class="pastry"></div>
      <div class="pastry"></div>
      <div class="pastry"></div>
    </div>
  </div>

  <script>
    // Sprinkle animation
    for (let i = 0; i < 30; i++) {
      const sprinkle = document.createElement('div');
      sprinkle.className = 'sprinkle';
      sprinkle.style.left = Math.random() * 100 + 'vw';
      sprinkle.style.top = Math.random() * -100 + 'vh';
      sprinkle.style.backgroundColor = ['#f28ab1', '#fbb7c3', '#ffe4ec'][Math.floor(Math.random() * 3)];
      sprinkle.style.animationDuration = (3 + Math.random() * 2) + 's';
      document.body.appendChild(sprinkle);
    }

    // Auto-redirect
    setTimeout(() => {
      const loadingScreen = document.getElementById('loading-screen');
      loadingScreen.classList.add('fade-out');

      setTimeout(() => {
        window.location.href = 'admin.php';
      }, 1000);
    }, 5000);
  </script>
</body>
</html>
