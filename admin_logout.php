<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Goodbye!</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

    body, html {
      margin: 0; padding: 0;
      height: 100%;
      background: linear-gradient(135deg, #f9e6f2, #fce7f0);
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #7a294e;
      text-align: center;
    }

    .container {
      background: #fff0f5;
      border-radius: 20px;
      padding: 40px 60px;
      box-shadow: 0 8px 30px rgba(122, 41, 78, 0.25);
      max-width: 400px;
      width: 90%;
      animation: fadeIn 1s ease forwards;
    }

    h1 {
      font-size: 2.8rem;
      margin-bottom: 15px;
    }

    p {
      font-size: 1.25rem;
      margin-bottom: 30px;
      font-weight: 500;
    }

    .emoji {
      font-size: 4rem;
      margin-bottom: 20px;
    }

    /* cute wave animation */
    .wave {
      display: inline-block;
      animation-name: wave-animation;
      animation-duration: 2.5s;
      animation-iteration-count: infinite;
      transform-origin: 70% 70%;
      animation-timing-function: ease-in-out;
    }

    @keyframes wave-animation {
      0% { transform: rotate(0deg); }
      15% { transform: rotate(15deg); }
      30% { transform: rotate(-10deg); }
      45% { transform: rotate(15deg); }
      60% { transform: rotate(-10deg); }
      75% { transform: rotate(15deg); }
      100% { transform: rotate(0deg); }
    }

    /* fade in */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="emoji wave">👋</div>
    <h1>Goodbye, Admin!</h1>
    <p>Thank you for all your hard work and dedication. See you soon! 💖</p>
  </div>

  <script>
    // Redirect after 5 seconds (adjust if you want)
    setTimeout(() => {
      window.location.href = 'register.php'; // change to your login page URL
    }, 5000);
  </script>
</body>
</html>
