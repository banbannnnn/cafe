<?php
session_start();

if (!isset($_SESSION['user_info'])) {
    header("Location: register.php");
    exit();
}

$user = $_SESSION['user_info'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method']; // Get payment method
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Billing Confirmation - Blissful Bites</title>
    <link rel="icon" href="logo1.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #fafafa;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            border-bottom: 1px solid #eee;
            background-color: #fff;
        }

        .logo img {
            height: 100px;
            width: 100px;
        }

        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #9f4262;
            font-weight: 600;
        }

        .icons {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .icons i {
            font-size: 24px;
            color: #422d4a;
            cursor: pointer;
        }

        /* WRAPPER to center page content */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px;
            max-width: 1200px;
            gap: 40px;
            margin-left: 400px;
        }

        .form-section {
            width: 100%;
        }

        .form-box {
            width: 600px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            padding: 40px;
            background-color: #ffe0dd;
            align-items: center;
            border-radius: 10px;
            margin-bottom: 100px;
        }

        h2 {
            color: #9f4262;
            margin-bottom: 20px;
        }

        .info-box {
            background-color: #fff6f6;
            padding: 10px;
            margin-top: 20px;
            color: rgb(67, 67, 67);
            text-align: center;
        }

        .thank-you-message {
            background-color: #9f4262;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .thank-you-message h3 {
            margin: 0;
        }

        .redirect-message {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }

        .place-order {
            background-color: #b18584;
            color: white;
            padding: 12px;
            border: none;
            width: 300px;
            font-size: 16px;
            cursor: pointer;
            align-items: center;
            margin-left: 115px;
            border-radius: 10px;
        }

        .place-order:hover {
            background-color: #9a6f6f;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
      <img src="logo.jpg" alt="Blissful Bites Logo">
    </div>
    <nav>
      <a href="home.html">HOME</a>
      <a href="#">ABOUT US</a>
      <a href="menu.html">MENU</a>
      <a href="#">CONTACT US</a>
      <a href="#" style="background: #D2A19F; color: white; padding: 8px 12px; border-radius: 5px;">ORDER NOW</a>
    </nav>
    <div class="icons">
      <a href="cart.html"><i class='bx bx-shopping-bag'></i></a>
    </div>
</header>

<div class="container">
    <div class="form-section">
        <div class="form-box">
            <h2>Payment Confirmation</h2>
            
            <?php if ($payment_method == 'gcash'): ?>
                <div class="redirect-message">
                    <p>You have chosen GCash. Please proceed to the GCash app to complete your payment.</p>
                    <button class="place-order" onclick="window.location.href='https://www.gcash.com/'">Go to GCash</button>
                </div>
            <?php elseif ($payment_method == 'card'): ?>
                <div class="redirect-message">
                    <p>You have chosen Credit/Debit Card. You will be redirected to a payment gateway.</p>
                    <button class="place-order" onclick="window.location.href='https://www.paymentgateway.com'">Proceed to Payment</button>
                </div>
            <?php elseif ($payment_method == 'cod'): ?>
                <div class="thank-you-message">
                    <h3>Thank you for choosing Cash on Delivery (COD)!</h3>
                    <p>Your order will be delivered soon. Please have the exact amount ready.</p>
                </div>
            <?php else: ?>
                <div class="info-box">
                    <p>Invalid payment method selected.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

</body>
</html>
