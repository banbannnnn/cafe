<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'connect.php';

$notification = "";
$notificationType = "";

$email = $_SESSION['email_to_verify'] ?? null;
if (!$email) {
    die("❌ No email found in session. Please register again.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verification_code'])) {
    $verificationCode = $_POST['verification_code'];

    $query = $conn->prepare("SELECT id FROM users WHERE email = ? AND verification_code = ?");
    if (!$query) die("Prepare failed: " . $conn->error);
    $query->bind_param("ss", $email, $verificationCode);
    if (!$query->execute()) die("Execute failed: " . $query->error);

    $result = $query->get_result();
    if ($result->num_rows > 0) {
        $updateQuery = $conn->prepare("UPDATE users SET email_verified = 1 WHERE email = ?");
        if (!$updateQuery) die("Prepare failed (update): " . $conn->error);
        $updateQuery->bind_param("s", $email);
        if ($updateQuery->execute()) {
            unset($_SESSION['email_to_verify']);
            header("Location: welcome.php");
            exit();
        } else {
            $notification = "❌ Error updating user verification status: " . $updateQuery->error;
            $notificationType = "error";
        }
    } else {
        $notification = "❌ Invalid verification code.";
        $notificationType = "error";
    }

    $query->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email - Blissful Bites</title>
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
    <h2>Verify Your Email</h2>
    <?php if (!empty($notification)): ?>
        <div class="notification <?= $notificationType ?>"><?= $notification ?></div>
    <?php endif; ?>

    <form action="verify.php" method="POST" onsubmit="return combineCode()">
        <div class="code-inputs">
            <input type="text" maxlength="1" oninput="moveToNext(this, 0)" required>
            <input type="text" maxlength="1" oninput="moveToNext(this, 1)" required>
            <input type="text" maxlength="1" oninput="moveToNext(this, 2)" required>
            <input type="text" maxlength="1" oninput="moveToNext(this, 3)" required>
            <input type="text" maxlength="1" oninput="moveToNext(this, 4)" required>
            <input type="text" maxlength="1" oninput="moveToNext(this, 5)" required>
        </div>
        <input type="hidden" name="verification_code" id="verification_code">
        <button type="submit">Verify</button>
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
