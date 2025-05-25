<?php
include 'connect.php';

$notification = "";
$notificationType = "";

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Registration logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['first_name'])) {
    // Collect and sanitize user inputs
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $companyName = $_POST['company_name'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $province = 'Bulacan'; // Default value
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if email already exists
    $emailCheckQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $notification = "❌ Email is already registered. Please use a different email.";
        $notificationType = "error";
    } else {
        // Check if passwords match
        if ($password !== $confirmPassword) {
            $notification = "❌ Passwords do not match.";
            $notificationType = "error";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Generate a random verification code
            $verificationCode = rand(100000, 999999);

            // Insert new user with verification code
            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, company_name, street, city, province, phone, email, user_password, verification_code)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssss", $firstName, $lastName, $companyName, $street, $city, $province, $phone, $email, $hashedPassword, $verificationCode);

            if ($stmt->execute()) {
                // Send verification email
                $mail = new PHPMailer\PHPMailer\PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';  
                $mail->SMTPAuth = true;
                $mail->Username = 'maria2001marie@gmail.com';  
                $mail->Password = 'phvq cicx yabs cmaj';  
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('no-reply@blissfulbites.com', 'Blissful Bites');
                $mail->addAddress($email);  

                $mail->Subject = 'Email Verification for Blissful Bites';
                $mail->Body = "Hello $firstName, \n\nPlease verify your email by entering the following verification code: $verificationCode \n\nThank you,\nEchoed Pages";

                if ($mail->send()) {
                   session_start();
                    $_SESSION['email_to_verify'] = $email;
                    header("Location: verify.php");
                    exit();
                } else {
                    $notification = "❌ Error sending email: " . $mail->ErrorInfo;
                    $notificationType = "error";
                }

                $stmt->close();
            } else {
                $notification = "❌ Error: " . $stmt->error;
                $notificationType = "error";
            }
        }
    }

    $conn->close();
}

// Login logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // CAPTCHA check
    if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        $notification = "❌ Please complete the CAPTCHA.";
        $notificationType = "error";
    } else {
        $recaptchaSecret = '6Lf6zTwrAAAAAKYA-hxLiRBRa-LD9fInaw2w-iNY';
        $recaptchaResponse = $_POST['g-recaptcha-response'];
        $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}");
        $responseData = json_decode($verifyResponse);

        if (!$responseData->success) {
            $notification = "❌ CAPTCHA verification failed. Please try again.";
            $notificationType = "error";
        } else {
            // Proceed with login
            $loginQuery = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($loginQuery);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['user_password'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    header("Location: welcome.php");
                    exit();
                } else {
                    $notification = "❌ Email or Password is incorrect.";
                    $notificationType = "error";
                }
            } else {
                $notification = "❌ Email or Password is incorrect.";
                $notificationType = "error";
            }
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['password']) && !isset($_POST['first_name'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // reCAPTCHA check first
    if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        $notification = "❌ Please complete the CAPTCHA.";
        $notificationType = "error";
    } else {
        $recaptchaSecret = '6Lf6zTwrAAAAAKYA-hxLiRBRa-LD9fInaw2w-iNY';
        $recaptchaResponse = $_POST['g-recaptcha-response'];
        $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}");
        $responseData = json_decode($verifyResponse);

        if (!$responseData->success) {
            $notification = "❌ CAPTCHA verification failed. Please try again.";
            $notificationType = "error";
        } else {
            // Proceed with user authentication
            $loginQuery = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($loginQuery);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['user_password'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    header("Location: welcome.php");
                    exit();
                } else {
                    $notification = "❌ Email or Password is incorrect.";
                    $notificationType = "error";
                }
            } else {
                $notification = "❌ Email or Password is incorrect.";
                $notificationType = "error";
            }

            $stmt->close();
        }
    }

    $conn->close();
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Double Slider Login/Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
    .sign-in-container { left: 0; width: 50%; z-index: 2; }
    .sign-up-container { left: 0; width: 50%; opacity: 0; z-index: 1; }

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
      margin: 20px auto;
      padding: 15px 25px;
      width: 80%;
      border-radius: 8px;
      font-size: 14px;
      text-align: center;
    }

    .notification.success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .notification.error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
    .notification {
  transition: opacity 0.5s ease;
}

a:hover {
    background-color: #da326d;
    color: white !important;
  }
  </style>
</head>
<body>

<div class="container" id="container">

  <div class="form-container sign-up-container">
    <form id="registerForm" action="register.php" method="POST">
      <?php if (!empty($notification)): ?>
        <div class="notification <?= $notificationType ?>"><?= $notification ?></div>
      <?php endif; ?>

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
        <input type="email" id="emailStep2" placeholder="Email" readonly />
        <input type="password" id="password" name="password" placeholder="Password" required />
        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required />
        <p id="passwordMismatch">Passwords do not match.</p>
        <button type="submit">Register</button>
      </div>
    </form>
  </div>

  <div class="form-container sign-in-container">
    <form id="loginForm" action="register.php" method="POST">
      <h1>Login</h1>

      <?php if (!empty($notification)): ?>
        <div class="notification <?= $notificationType ?>"><?= $notification ?></div>
      <?php endif; ?>

      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <p id="passwordMismatch">Email or Password is incorrect.</p>

      <br/>
      <div class="g-recaptcha" data-sitekey="6Lf6zTwrAAAAAK4_s6F777fWW00_k0f6g0fHn8Uf"></div>

      <br/>
      <button type="submit">Login</button>
     <p class="forgot-link"><a href="forgot_password.php">Forgot Password?</a></p>

     <br/>
     <br/>
     <a href="admin_pin.php" style="
  margin-top: 10px;
  display: inline-block;
  color: #da326d;
  text-decoration: none;
  padding: 5px 10px;
  border: 1px solid  #da326d;
  border-radius: 8px;
  transition: background-color 0.3s, color 0.3s;
  font-weight: bold;
">
  Log in as Admin
</a>


    </form>
  </div>

  <div class="overlay-container">
    <div class="overlay">
      <div class="overlay-panel overlay-left">
      <h1>Hello, Friend!</h1>
      <p>Enter your personal details and start your journey with us</p>
        <button class="ghost" id="signIn">Sign In</button>
      </div>
      <div class="overlay-panel overlay-right">
      <h1>Welcome Back!</h1>
      <p>To keep connected with us please login with your personal info</p>
        <button class="ghost" id="signUp">Sign Up</button>
      </div>
    </div>
  </div>

</div>

<script>
   setTimeout(() => {
    const notification = document.querySelector('.notification');
    if (notification) {
      notification.style.opacity = '0';
      setTimeout(() => {
        notification.style.display = 'none';
      }, 500); // Wait for fade out
    }
  }, 5000);

  // Remove ?registered=1 from URL without reloading
  if (window.location.search.includes('registered=1')) {
    const url = new URL(window.location);
    url.searchParams.delete('registered');
    window.history.replaceState({}, document.title, url.pathname);
  }

  const container = document.getElementById('container');
  const signUpButton = document.getElementById('signUp');
  const signInButton = document.getElementById('signIn');
  const passwordMismatchMessage = document.getElementById('passwordMismatch');
  
  signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
  });

  signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
  });

  function goToStep2() {
    const email = document.getElementById("emailStep1").value;
    document.getElementById("emailStep2").value = email;
    document.getElementById("step1").style.display = "none";
    document.getElementById("step2").style.display = "block";
  }

  document.getElementById("confirmPassword").addEventListener("input", () => {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    if (password !== confirmPassword) {
      passwordMismatchMessage.style.display = "block";
    } else {
      passwordMismatchMessage.style.display = "none";
    }
  });
</script>

</body>
</html>