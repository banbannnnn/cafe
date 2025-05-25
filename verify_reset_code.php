<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'connect.php';
session_start();

$notification = "";
$notificationType = "";

if (!isset($_SESSION['email_for_reset']) || !isset($_SESSION['new_password'])) {
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verification_code'])) {
    $email = $_SESSION['email_for_reset'];
    $new_password_hash = $_SESSION['new_password'];
    $verificationCode = $_POST['verification_code'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND verification_code = ?");
    $stmt->bind_param("ss", $email, $verificationCode);  // FIXED HERE
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
       $update = $conn->prepare("UPDATE users SET user_password = ?, verification_code = NULL WHERE email = ?");
        $update->bind_param("ss", $new_password_hash, $email);
        $update->execute();

        unset($_SESSION['email_for_reset']);
        unset($_SESSION['new_password']);

        // Redirect to register.php to login
        header("Location: register.php");
        exit();
    } else {
        $notification = "❌ Invalid verification code.";
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
    <title>Reset Code Verification - Blissful Bites</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&family=Pacifico&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(to right, #fff0f5, #ffe5d9);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fffaf5;
            padding: 30px 50px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            font-family: 'Pacifico', cursive;
            color: #d27d5f;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .code-inputs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .code-inputs input {
            width: 45px;
            height: 50px;
            text-align: center;
            font-size: 20px;
            border: 1px solid #f0c4b4;
            border-radius: 6px;
            outline: none;
        }

        button {
            background-color: #d24280;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
            transition: background-color 0.3s ease;
            width: 180px;
        }

        button:hover {
            background-color: #da326d;
        }

        .notification {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .error {
            background-color: #fbeaea;
            color: #c62828;
        }

        .success {
            background-color: #eafaf1;
            color: #2e7d32;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Verify Reset Code</h2>
    <?php if (!empty($notification)): ?>
        <div class="notification <?= $notificationType ?>"><?= $notification ?></div>
    <?php endif; ?>

    <form action="verify_reset_code.php" method="POST" onsubmit="return combineCode()">
        <div class="code-inputs">
            <input type="text" maxlength="1" oninput="moveToNext(this, 0)" required>
            <input type="text" maxlength="1" oninput="moveToNext(this, 1)" required>
            <input type="text" maxlength="1" oninput="moveToNext(this, 2)" required>
            <input type="text" maxlength="1" oninput="moveToNext(this, 3)" required>
            <input type="text" maxlength="1" oninput="moveToNext(this, 4)" required>
            <input type="text" maxlength="1" oninput="moveToNext(this, 5)" required>
        </div>
        <input type="hidden" name="verification_code" id="verification_code">
        <button type="submit">Verify Code</button>
    </form>
</div>

<script>
    const inputs = document.querySelectorAll('.code-inputs input');

    function moveToNext(current, index) {
        if (current.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    }

    function combineCode() {
        let code = '';
        for (let input of inputs) {
            if (!input.value.match(/[0-9]/)) {
                alert("❌ Only numeric digits allowed.");
                return false;
            }
            code += input.value;
        }
        document.getElementById('verification_code').value = code;
        return true;
    }

    // Auto focus on first input
    window.onload = () => inputs[0].focus();
</script>
</body>
</html>
