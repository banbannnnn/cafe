<?php
session_start();

// Generate CAPTCHA image
if (!isset($_SESSION['captcha_code'])) {
    $_SESSION['captcha_code'] = rand(100000, 999999);  // Only generate if it's not set already
}

// Handle CAPTCHA verification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get CAPTCHA input from user
    $captcha = $_POST['captcha'];

    // Compare CAPTCHA input with session value (ensure both are strings)
    if (strval($captcha) === strval($_SESSION['captcha_code'])) {
        // CAPTCHA is correct, redirect to menu
        header("Location: menu.php");
        exit();
    } else {
        $error_message = "❌ Incorrect CAPTCHA. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CAPTCHA Verification - Blissful Bites</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
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
            color:rgb(255, 255, 255);
            margin-bottom: 20px;
        }
        input[type="text"] {
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
        .captcha-image img {
            width: 100%;
            max-width: 250px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>CAPTCHA Verification</h2>

    <?php if (isset($error_message)): ?>
        <div class="notification error"><?= $error_message ?></div>
    <?php endif; ?>

    <form action="captcha_verification.php" method="POST">
        <div class="captcha-image">
            <img src="captcha.php" alt="CAPTCHA" />
        </div>
        <input type="text" name="captcha" placeholder="Enter CAPTCHA" required />
        <button type="submit">Verify</button>
    </form>

</div>

</body>
</html>
