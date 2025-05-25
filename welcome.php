<?php
// You can add PHP logic here if needed, or leave empty
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome | Blissful Bites</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(-45deg, #fff0f5, #ffe0e9, #ffe8f0, #fff5f8);
      background-size: 400% 400%;
      animation: gradientBG 10s ease infinite;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
      position: relative;
    }

    @keyframes gradientBG {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }

    .container {
      text-align: center;
      animation: fadeIn 1s ease-in-out;
      z-index: 2;
    }

    .cake {
      width: 250px;
      height: 250px;
      margin: 0 auto 20px;
      background: url('cupcake2.png') no-repeat center/contain;
      animation: bounce 2s infinite;
    }

    @keyframes bounce {
      0%, 100% {transform: translateY(0);}
      50% {transform: translateY(-10px);}
    }

    h1 {
      color: #d94f70;
      margin-bottom: 10px;
      font-size: 32px;
      animation: glow 2s ease-in-out infinite alternate;
    }

    @keyframes glow {
      from { text-shadow: 0 0 5px #ffafcc; }
      to { text-shadow: 0 0 20px #ffafcc, 0 0 30px #ffafcc; }
    }

    p {
      font-size: 18px;
      color: #444;
      white-space: nowrap;
      overflow: hidden;
      border-right: 3px solid #d94f70;
      width: 0;
      animation: typing 2s steps(30, end) 1s forwards, blink .7s step-end infinite;
    }

    @keyframes typing {
      from { width: 0 }
      to { width: 100% }
    }

    @keyframes blink {
      50% { border-color: transparent; }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .confetti {
      position: absolute;
      width: 10px;
      height: 10px;
      background-color: #ffccd5;
      border-radius: 50%;
      animation: fall 3s linear infinite;
      opacity: 0.7;
      z-index: 1;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    @keyframes fall {
      0% {
        transform: translateY(-100px) rotate(0deg);
        opacity: 0.9;
      }
      100% {
        transform: translateY(100vh) rotate(360deg);
        opacity: 0;
      }
    }
  </style>
  <script>
    // Redirect after 3.5 seconds
    setTimeout(() => {
      window.location.href = "home.php";
    }, 3500);

    // Generate confetti
    document.addEventListener("DOMContentLoaded", function () {
      for (let i = 0; i < 70; i++) {
        let confetti = document.createElement("div");
        confetti.classList.add("confetti");
        confetti.style.left = Math.random() * 100 + "vw";
        confetti.style.top = Math.random() * -100 + "px";
        confetti.style.backgroundColor = getRandomColor();
        confetti.style.animationDuration = (2 + Math.random() * 2) + "s";
        confetti.style.animationDelay = (Math.random() * 2) + "s";
        document.body.appendChild(confetti);
      }
    });

    function getRandomColor() {
      const colors = ["#fcd5ce", "#ffafcc", "#ffc8dd", "#bde0fe", "#caffbf"];
      return colors[Math.floor(Math.random() * colors.length)];
    }
  </script>
</head>
<body>
  <div class="container">
    <div class="cake"></div>
    <h1>Welcome to Blissful Bites!</h1>
    <p>Whipping up something sweet for you...</p>
  </div>
</body>
</html>
