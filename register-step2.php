<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $_SESSION['register'] = $_POST;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    * {
  box-sizing: border-box;
}

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
  justify-content: center;
  align-items: center;
}

.form-container {
  width: 100%;
  padding: 50px;
}

form {
  background-color: #fff;
  display: flex;
  flex-direction: column;
  width: 100%;
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
  margin-top: 10px;
}

form button:hover {
  background-color: #da326d;
}

button:active {
  transform: scale(0.95);
}

h1, h2 {
  margin-bottom: 20px;
}

p {
  font-size: 14px;
  margin-top: 10px;
}

a {
  color: #d24280;
  text-decoration: underline;
}

.forgot-link {
  margin-top: 10px;
  font-size: 13px;
  color: #d24280;
  text-decoration: underline;
  cursor: pointer;
}

.social-icons {
  margin-top: 10px;
}

.social-icons i {
  font-size: 20px;
  margin: 0 10px;
  color: #d24280;
  cursor: pointer;
}

#error, .error-msg, #passwordMismatch {
  color: red;
  font-size: 14px;
  display: none;
  margin-top: 10px;
}

  </style>
 
  
</head>
<body>
  <div class="container">
    <div class="form-container">
      <form action="register-submit.php" method="POST">
        <h2>Step 2: Account Setup</h2>
        <input type="email" value="<?php echo htmlspecialchars($_SESSION['register']['email'] ?? ''); ?>" readonly />
        <input type="password" name="passwords" placeholder="Password" required />
        <input type="password" name="confirmPassword" placeholder="Confirm Password" required />
        <p id="passwordMismatch" class="error-msg">❌ Passwords do not match. Please try again.</p>
        <button type="submit">Register</button>
        <a href="register.php">← Back to Step 1</a>
      </form>
    </div>
  </div>

  <script>
    document.querySelector("
