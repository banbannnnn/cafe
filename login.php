<?php
session_start();
include 'connect.php';

$notification = "";
$notificationType = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password']) && !isset($_POST['confirmPassword'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Get user record from database by username
    $stmt = $conn->prepare("SELECT id, username, user_password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // If user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['user_password'])) {
            // Password matched — set session and redirect
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $notification = "✅ Login successful!";
            $notificationType = "success";
            header("Location: menu.html");
            exit();
        } else {
            $notification = "❌ Incorrect password.";
            $notificationType = "error";
        }
    } else {
        $notification = "❌ Username not found. Please register first.";
        $notificationType = "error";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login/Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fffefe;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .container {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
      position: relative;
      overflow: hidden;
      width: 1000px;
      max-width: 100%;
      min-height: 650px;
      display: flex;
    }
    .form-container {
      position: absolute;
      top: 0;
      height: 100%;
      transition: all 0.6s ease-in-out;
    }
    .sign-in-container {
      left: 0;
      width: 50%;
      z-index: 2;
    }
    .sign-up-container {
      left: 0;
      width: 50%;
      opacity: 0;
      z-index: 1;
    }
    .container.right-panel-active .sign-in-container {
      transform: translateX(100%);
    }
    .container.right-panel-active .sign-up-container {
      transform: translateX(100%);
      opacity: 1;
      z-index: 5;
      animation: show 0.6s;
    }
    @keyframes show {
      0% { opacity: 0; transform: translateX(0%); }
      100% { opacity: 1; transform: translateX(100%); }
    }
    form {
      background-color: #fff;
      display: flex;
      flex-direction: column;
      padding: 50px;
      height: 100%;
      justify-content: center;
      align-items: center;
      text-align: center;
    }
    input {
      background-color: #eee;
      border: none;
      padding: 12px 15px;
      margin: 10px 0;
      width: 300px;
      border-radius: 8px;
    }
    button {
      border: none;
      padding: 12px 45px;
      border-radius: 20px;
      background-color: #d24280;
      color: #fff;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      transition: transform 80ms ease-in;
    }
    form button:hover {
      background-color: #da326d;
    }
    button:active {
      transform: scale(0.95);
    }
    .overlay-container {
      position: absolute;
      top: 0;
      left: 50%;
      width: 50%;
      height: 100%;
      overflow: hidden;
      transition: transform 0.6s ease-in-out;
      z-index: 100;
    }
    .container.right-panel-active .overlay-container {
      transform: translateX(-100%);
    }
    .overlay {
      background: url('llogo.png') center/cover no-repeat;
      height: 100%;
      width: 200%;
      position: relative;
      left: -100%;
      transition: transform 0.6s ease-in-out;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .container.right-panel-active .overlay {
      transform: translateX(50%);
    }
    .overlay-panel {
      position: absolute;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 0 40px;
      text-align: center;
      color: #fff;
      height: 100%;
      width: 50%;
      top: 0;
    }
    .overlay-left { left: 0; }
    .overlay-right { right: 0; }

    .overlay h1 { font-size: 2rem; font-weight: bold; }
    .overlay p { font-size: 0.9rem; margin: 15px 0 30px; }
    .social-icons {
      margin-top: 10px;
    }
    .social-icons i {
      font-size: 20px;
      margin: 0 10px;
      color: white;
      cursor: pointer;
    }
    #step2 { display: none; margin-top: 20px; }
    #passwordMismatch {
      color: red;
      display: none;
      font-size: 14px;
      margin-top: -5px;
    }
    .forgot-link {
      margin-top: 10px;
      font-size: 13px;
      color: #d24280;
      text-decoration: underline;
      cursor: pointer;
    }

    .notification {
      background-color: #d24280;
      color: #fff;
      padding: 10px;
      border-radius: 5px;
      margin-top: 10px;
      text-align: center;
      font-weight: bold;
      display: none;
    }
    .notification.success {
      background-color: #28a745;
    }
    .notification.error {
      background-color: #dc3545;
    }
  </style>
</head>
<body>

<div class="container" id="container">
  <!-- Sign Up Form -->
  <div class="form-container sign-up-container">
    <form id="registerForm" action="register.php" method="POST">
      <div id="step1">
        <h2>Step 1: Personal Info</h2>
        <input type="text" name="first_name" placeholder="First Name" required />
        <input type="text" name="last_name" placeholder="Last Name" required />
        <input type="text" name="company_name" placeholder="Company Name (optional)" />
        <input type="text" name="street" placeholder="Street Name" required />
        <input type="text" name="city" placeholder="City" required />
        <input type="text" value="Bulacan" disabled />
        <input type="tel" name="phone" placeholder="Phone" required />
        <input type="email" id="emailStep1" name="email" placeholder="Email" required />
        <button type="button" onclick="goToStep2()">Next</button>
      </div>

      <div id="step2">
        <h2>Step 2: Account Setup</h2>
        <input type="email" id="emailStep2" readonly />
        <input type="password" id="password" name="password" placeholder="Password" required />
        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required />
        <p id="passwordMismatch">❌ Passwords do not match. Please try again.</p>
        <button type="submit" onclick="return validatePassword()">Register</button>
        <button type="button" onclick="goBackToStep1()">Back</button>
      </div>
    </form>
  </div>

  <!-- Sign In Form -->
  <div class="form-container sign-in-container">
    <form action="login.php" method="POST">
      <h1>Login</h1>
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Login</button>
      <p class="forgot-link">Forgot Password?</p>
      <div class="social-icons">
        <i class="fab fa-facebook"></i>
        <i class="fab fa-google"></i>
        <i class="fab fa-linkedin"></i>
      </div>
    </form>

    <!-- Display notification if there's any -->
    <?php if (!empty($notification)): ?>
      <div class="notification <?php echo $notificationType; ?>">
        <?php echo $notification; ?>
      </div>
    <?php endif; ?>
  </div>

  <!-- Overlay -->
  <div class="overlay-container">
    <div class="overlay">
      <div class="overlay-panel overlay-left">
        <h1>Hello!</h1>
        <button class="ghost" id="signIn">Login</button>
      </div>
      <div class="overlay-panel overlay-right">
        <h1>Welcome Back!</h1>
        <button class="ghost" id="signUp">Register</button>
      </div>
    </div>
  </div>
</div>

<script>
  const container = document.getElementById('container');

  document.getElementById('signUp').addEventListener('click', () => {
    container.classList.add("right-panel-active");
  });

  document.getElementById('signIn').addEventListener('click', () => {
    container.classList.remove("right-panel-active");
  });

  function goToStep2() {
    const email = document.getElementById("emailStep1").value;
    document.getElementById("emailStep2").value = email;
    document.getElementById("step1").style.display = "none";
    document.getElementById("step2").style.display = "block";
  }

  function goBackToStep1() {
    document.getElementById("step2").style.display = "none";
    document.getElementById("step1").style.display = "block";
  }

  function validatePassword() {
    const pw = document.getElementById("password").value;
    const confirmPw = document.getElementById("confirmPassword").value;
    const mismatchText = document.getElementById("passwordMismatch");

    if (pw !== confirmPw) {
      mismatchText.style.display = "block";
      return false;
    }
    mismatchText.style.display = "none";
    return true;
  }
</script>

</body>
</html>
