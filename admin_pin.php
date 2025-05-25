<?php
session_start();

$notification = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pin = implode('', $_POST['pin']); // Combine the 5 digits into a single PIN

    if ($pin === "12345") {
        $_SESSION['admin_logged_in'] = true;
        header("Location: welcome_admin.php");
        exit();
    } else {
        $notification = "❌ Incorrect PIN. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Blissful Bites</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #ffdde1, #fcb7bf);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .admin-pin-container {
            background-color: #fff0f5;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(255, 182, 193, 0.4);
            text-align: center;
            width: 360px;
        }

        .admin-pin-container h2 {
            color: #d63384;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .pin-inputs {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 20px;
        }

        .pin-inputs input {
            width: 50px;
            height: 55px;
            font-size: 24px;
            text-align: center;
            border: 1px solid #ffb6c1;
            border-radius: 10px;
            background-color: white;
            outline: none;
            transition: border 0.3s ease;
        }

        .pin-inputs input:focus {
            border: 2px solid #d63384;
            box-shadow: 0 0 8px rgba(214, 51, 132, 0.3);
        }

        button {
            background-color: #d63384;
            color: white;
            padding: 12px 28px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c2186a;
        }

        .notification {
            background-color: #ffe6ea;
            color: #d63333;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-size: 14px;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            color: #b76e79;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="admin-pin-container">
        <h2>Admin PIN Login</h2>
        <?php if ($notification): ?>
            <div class="notification"><?= $notification ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="pin-inputs">
                <?php for ($i = 0; $i < 5; $i++): ?>
                    <input type="password" name="pin[]" maxlength="1" pattern="\d*" inputmode="numeric" required>
                <?php endfor; ?>
            </div>
            <button type="submit">Login</button>
        </form>
        <a class="back-link" href="register.php">← Back to main login</a>
    </div>

    <script>
        const inputs = document.querySelectorAll('.pin-inputs input');

        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === "Backspace" && input.value === "" && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    </script>
</body>
</html>
