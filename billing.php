<?php
include 'connect.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: register.php");
    exit();
}

// Get user id from session
$user_id = $_SESSION['user_id'];

// Fetch user data from DB
$stmt = $conn->prepare("SELECT first_name, last_name, company_name, street, city, province, phone, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    // If user not found, redirect or handle error
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Billing - Blissful Bites</title>
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

    input, textarea, select {
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 15px;
      box-sizing: border-box;
      border-radius: 5px;
      border: 1px solid #ccc;
      width: 100%; /* Set to 100% width to make them align */
    }

    label {
      font-weight: bold;
    }

    .name-container {
      display: flex;
      gap: 20px;
    }

    .name-container input {
      width: 48%; /* Each input takes up almost half of the width */
    }

    /* Align the address fields */
    .address-container {
      display: flex;
      flex-direction: column;
    }

    .address-container input {
      width: 100%; /* Full width for address fields */
      margin-bottom: 10px;
    }

    .total {
      font-size: 20px;
      font-weight: bold;
      margin-top: 20px;
      text-align: right;
      color: #9f4262;
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

    .info-box {
      background-color: #fff6f6;
      padding: 10px;
      margin-top: 20px;
      color: rgb(67, 67, 67);
    }

    .create-account {
      display: block;
      text-align: center;
      margin-top: 20px;
      font-size: 16px;
    }

    .create-account a {
      color: #9f4262;
      text-decoration: none;
      font-weight: bold;
      padding: 10px 20px;
      border: 1px solid #9f4262;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .create-account a:hover {
      background-color: #9f4262;
      color: white;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      text-align: center;
      width: 300px;
    }

    .modal button {
      background-color: #b18584;
      color: white;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      border-radius: 5px;
      margin-top: 20px;
    }

    .modal button:hover {
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
    <h2>Billing & Shipping</h2>
    <div class="form-box">
      <form action="process_billing.php" method="POST">
        <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" readonly>
        <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" readonly>
        <input type="text" name="company_name" value="<?= htmlspecialchars($user['company_name']) ?>" readonly>
        <input type="text" name="street" value="<?= htmlspecialchars($user['street']) ?>" readonly>
        <input type="text" name="city" value="<?= htmlspecialchars($user['city']) ?>" readonly>
        <input type="text" name="province" value="<?= htmlspecialchars($user['province']) ?>" readonly>
        <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" readonly>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>

        <!-- Add fields for billing-specific info -->
        <input type="text" name="billing_notes" placeholder="Notes or details">
        <button type="submit" class="place-order">Place Order</button>
      </form>

      <div class="create-account">
        <p>Don't have an account? <a href="signup.html">Create Account</a></p>
      </div>
    </div>
  </div>
</div>

  <!-- Modal for Thank You message (JS triggered on successful order if needed) -->
  <div id="orderModal" class="modal">
    <div class="modal-content">
      <h3>Thank You for Your Order!</h3>
      <p>Your order has been successfully placed.</p>
      <button onclick="closeModal()">Okay</button>
    </div>
  </div>

  <script>
    function closeModal() {
      document.getElementById('orderModal').style.display = 'none';
      window.location.href = 'menu.html';
    }

    // Optional: Trigger modal if redirected with success status (if added by place_order.php)
    window.addEventListener('DOMContentLoaded', function () {
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.get('success') === 'true') {
        document.getElementById('orderModal').style.display = 'flex';
        localStorage.removeItem('cart');
      }
    });
  </script>
  
</body>
</html>