<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connect.php';
$notification = "";
$notificationType = "";

session_start();

if (!isset($_SESSION['verification_passed']) || !isset($_SESSION['email_for_reset'])) {
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_password'], $_POST['confirm_password'])) {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $email = $_SESSION['email_for_reset'];

    if ($newPassword !== $confirmPassword) {
        $notification = "❌ Passwords do not match.";
        $notificationType = "error";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET user_password = ?, verification_code = NULL WHERE email = ?");
        if ($stmt === false) {
            die('Error preparing the SQL query: ' . $conn->error);
        }

        $stmt->bind_param("ss", $hashedPassword, $email);

        if ($stmt->execute()) {
            unset($_SESSION['email_for_reset']);
            unset($_SESSION['verification_passed']);
            header("Location: login.php?reset=success"); // More appropriate than register
            exit();
        } else {
            $notification = "❌ Failed to reset password. Please try again.";
            $notificationType = "error";
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password | Echoed Pages</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; padding: 0; margin: 0; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fce4ec, #f8bbd0);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .reset-container {
            background-color: #fff;
            padding: 30px 25px;
            width: 100%;
            max-width: 420px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .reset-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #d24280;
        }
        form { display: flex; flex-direction: column; }
        input[type="password"] {
            background-color: #f3f3f3;
            border: 1px solid #ccc;
            padding: 12px 14px;
            margin: 10px 0;
            border-radius: 8px;
            font-size: 14px;
        }
        button {
            background-color: #d24280;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #b32c68;
        }
        .notification {
            text-align: center;
            padding: 12px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 15px;
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
    </style>
</head>
<body>

<div class="reset-container">
    <h2>Reset Your Password</h2>

    <?php if (!empty($notification)): ?>
        <div class="notification <?= $notificationType ?>"><?= $notification ?></div>
    <?php endif; ?>

    <form action="reset_password.php" method="POST">
        <input type="password" name="new_password" placeholder="New Password" required autocomplete="new-password" />
        <input type="password" name="confirm_password" placeholder="Confirm Password" required autocomplete="new-password" />
        <button type="submit">Reset Password</button>
    </form>
</div>

</body>
</html>
