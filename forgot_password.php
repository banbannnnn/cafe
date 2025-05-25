<?php
include 'connect.php';
session_start();

$notification = "";
$notificationType = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $notification = "❌ Passwords do not match.";
        $notificationType = "error";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $reset_code = rand(100000, 999999);

            $update = $conn->prepare("UPDATE users SET verification_code = ? WHERE email = ?");
            $update->bind_param("ss", $reset_code, $email);
            $update->execute();

            require 'phpmailer/src/Exception.php';
            require 'phpmailer/src/PHPMailer.php';
            require 'phpmailer/src/SMTP.php';

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
            $mail->Subject = 'Blissful Bites Password Reset Code';
            $mail->Body = "Your password reset code is: $reset_code";

            if ($mail->send()) {
                $_SESSION['email_for_reset'] = $email;
                $_SESSION['new_password'] = password_hash($new_password, PASSWORD_DEFAULT); // Securely hash password
                header("Location: verify_reset_code.php");
                exit();
            } else {
                $notification = "❌ Failed to send reset email.";
                $notificationType = "error";
            }
        } else {
            $notification = "❌ Email not found.";
            $notificationType = "error";
        }

        $stmt->close();
        $conn->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password - Blissful Bites</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body {
      
        
      font-family: 'Poppins', sans-serif;
      background-color: #fffefc;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
    background-image: url('llogo.png');
    background-size: cover; /* Ensures the image covers the entire container */
    background-position: center; /* Centers the image */
    padding: 100px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    width: 450px;
    text-align: center;
}

    h2 {
      color:rgb(251, 251, 251);
      margin-bottom: 20px;
    }
    input[type="email"] {
      width: 100%;
      padding: 12px;
      margin: 15px 0;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 14px;
    }
    button {
      background-color: #d24280;
      color: white;
      padding: 12px 25px;
      border: none;
      border-radius: 20px;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    button:hover {
      background-color: #da326d;
    }
    .notification {
      padding: 12px;
      margin-bottom: 15px;
      border-radius: 8px;
      font-size: 14px;
    }
    .success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }
    .error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
    .back-link {
      margin-top: 20px;
      display: block;
      font-size: 13px;
      color: #d24280;
      text-decoration: none;
    }
    .back-link:hover {
      text-decoration: underline;
    }

    input[type="email"],
    input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 15px 0;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 14px;
    }

  </style>
</head>
<body>

<div class="container">
  <h2>Forgot Password</h2>
  
  <?php if (!empty($notification)): ?>
    <div class="notification <?= $notificationType ?>"><?= $notification ?></div>
  <?php endif; ?>

  <form action="forgot_password.php" method="POST">
  <input type="email" name="email" placeholder="Enter your email" required>
  <input type="password" name="new_password" placeholder="Enter new password" required>
  <input type="password" name="confirm_password" placeholder="Confirm new password" required>
  <button type="submit">Send Reset Code</button>
</form>

  <a href="register.php" class="back-link">← Back to Login</a>
</div>

</body>
</html>
