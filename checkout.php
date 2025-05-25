<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit();
}

$userId = $_SESSION['user_id'];

$query = "SELECT first_name, last_name, company_name, street, city, province, phone, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$xml = simplexml_load_file('menu.xml');
$products = [];

if ($xml !== false) {
    foreach ($xml->pastry as $pastry) {
        $products[(string)$pastry->name] = [
            'price' => (float)$pastry->price,
            'image' => (string)$pastry->image
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - Blissful Bites</title>
  <link rel="icon" href="logo1.png" type="image/png">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #fef5f7;
      margin: 0;
      padding: 0 ;
      color: #333;
     
    }

    h1, h2, h3 {
      color: #a35c6f;
    }

    .checkout-container {
      max-width: 1000px;
      margin: auto;
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
    }

    .flex-row {
      display: flex;
      gap: 2rem;
      flex-wrap: wrap;
    }

    .billing-info, .order-summary {
      flex: 1;
      min-width: 320px;
    }

    .billing-info {
      background-color: #fff0f5;
      border: 1px solid #e3c6cc;
      padding: 20px;
      border-radius: 12px;
    }

    .billing-info p {
      margin: 12px 0;
      font-size: 14px;
      color: #333;
    }

    .billing-info input[type="text"] {
      width: 400px;
      padding: 8px 12px;
      margin-top: 4px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
      background-color: #fff;
    }

    .order-summary {
      background-color: #fff8fa;
      padding: 20px;
      border-radius: 12px;
      border: 1px solid #e9d1d7;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: left;
      vertical-align: middle;
    }

    img {
      width: 50px;
      height: 50px;
      border-radius: 8px;
      object-fit: cover;
      margin-right: 10px;
    }

    .summary {
      margin-top: 2rem;
      font-size: 16px;
    }

    .summary p {
      display: flex;
      justify-content: space-between;
      margin: 8px 0;
    }

    .summary strong {
      color: #444;
    }

    button {
      margin-top: 1rem;
      background: #a35c6f;
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #8c4b5d;
    }

    #payment-details img {
      margin-top: 1rem;
      width: 200px;
      height: 200px;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 8px;
    }

    input[type="radio"] {
      margin-right: 8px;
    }

    @media (max-width: 768px) {
      .flex-row {
        flex-direction: column;
      }
    }

    header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.2rem 2rem;
  background: #fff;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  position: sticky;
  top: 0;
  z-index: 1000;
}

    .logo img {
  height: 80px;
  width: auto;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(210, 161, 159, 0.3);
}

 footer {
      background-color: #d5d5dd;
      color: #a76973;
      padding: 60px 40px;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 40px;
      font-family: 'Montserrat', sans-serif;
    }

    .footer-section {
      flex: 1;
      min-width: 200px;
    }

    .footer-section h3 {
      color: #b96363;
      margin-bottom: 15px;
      font-size: 20px;
      font-weight: 600;
    }

    .footer-section p,
    .footer-section a {
      color: #4e4b4b;
      font-size: 14px;
      margin-bottom: 10px;
      text-decoration: none;
      display: block;
    }

    .footer-section a:hover {
      color: #5c5656;
    }

    .social-icons {
      display: flex;
      gap: 15px;
      margin-top: 10px;
    }

    .social-icons i {
      font-size: 22px;
      color: #b96363;
      transition: 0.3s;
    }

    .social-icons i:hover {
      color: #534e4e;
    }

    .footer-bottom {
      width: 100%;
      text-align: center;
      margin-top: 30px;
      font-size: 13px;
      color: #aaa;
      border-top: 1px solid #444;
      padding-top: 20px;
    }

    nav {
  display: flex;
  gap: 20px;
  align-items: center;
}

nav a {
  font-weight: 600;
  color: #9f4262;
  text-decoration: none;
  padding: 8px 14px;
  border-radius: 6px;
  transition: background 0.3s ease, color 0.3s ease;
}

nav a:hover {
  background: #f7e7e6;
  color: #2d2d4a;
}

nav a:last-child {
  background: #D2A19F;
  color: white;
  font-weight: bold;
  padding: 10px 16px;
  border-radius: 8px;
  transition: background 0.3s ease;
}

nav a:last-child:hover {
  background: #b97e7c;
}

.icons {
  display: flex;
  align-items: center;
  gap: 14px;
}

.icons i {
  font-size: 22px;
  color: #2d2d4a;
  cursor: pointer;
  transition: color 0.3s ease;
}

.icons i:hover {
  color: #9f4262;
}

  </style>
</head>
<body>

<header>
    <div class="logo">
      <img src="logo.jpg" alt="Blissful Bites Logo">
    </div>
    <nav>
      <a href="home.php">HOME</a>
      <a href="aboutus.php">ABOUT US</a>
      <a href="menu.php">MENU</a>
      <a href="contactus.php">CONTACT US</a>
      <a href="menu.php" style="background: #D2A19F; color: white; padding: 8px 12px; border-radius: 5px;">ORDER NOW</a>
    </nav>
    <div class="icons">
      <a href="cart.php">
        <i class='bx bx-shopping-bag'></i>
       
      </a>
    </div>
  </header>

<form method="POST" action="submit_order.php" onsubmit="return sendOrderToServer();">
  <input type="hidden" name="cart_data" id="cart_data">
  <input type="hidden" name="total" id="total">
  <input type="hidden" name="payment_method" id="payment_method">

  <div class="checkout-container">
    <div class="flex-row">
      <div class="billing-info">
        <h3>Billing Information</h3>
        <p><strong>Name:</strong> <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></p>
        <p><strong>Company:</strong><br>
  <input type="text" name="company_name" value="<?= htmlspecialchars($user['company_name']) ?>" >
</p>

        <p><strong>Street:</strong><br>
          <input type="text" name="street" value="<?= htmlspecialchars($user['street']) ?>" required>
        </p>
        <p><strong>City:</strong><br>
          <input type="text" name="city" value="<?= htmlspecialchars($user['city']) ?>" required>
        </p>
        <p><strong>Province:</strong> <?= htmlspecialchars($user['province']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
      </div>

      <div class="order-summary">
        <h1>Order Summary</h1>
        <div id="checkout-items"></div>
        <div class="summary" id="summary-box"></div>

        <div style="margin-top: 2rem;">
          <h2>Select Payment Method</h2>
          <label><input type="radio" name="payment" value="GCash" onchange="showPaymentDetails()" checked> GCash</label><br>
          <label><input type="radio" name="payment" value="COD" onchange="showPaymentDetails()"> Cash on Delivery</label>
        </div>

        <button type="submit">Confirm Order</button>
        <div id="confirmation-message" style="margin-top:1rem; font-weight:600;"></div>
        <div id="payment-details" style="margin-top: 2rem;"></div>
      </div>
    </div>
  </div>
</form>

 <!-- Footer Section -->
  <footer>
    <div class="footer-section">
      <h3>Contact Information</h3>
      <p>Location:  4th Avenue corner 28th Street, BGC, Taguig</p>
      <p>Mobile: 0976 675 2231</p>
      <p>Email: orders.blissfullbites@gmail.com</p>
      <p>Pick up time: 11AM to 9PM</p>
    </div>

    <div class="footer-section">
      <h3>Customer Service</h3>
      <a href="#">My Account</a>
      <a href="#">About Us</a>
      <a href="#">Contact Us</a>
    </div>

    <div class="footer-section">
      <h3>Follow Us</h3>
      <div class="social-icons">
        <a href="#"><i class='bx bxl-facebook'></i></a>
        <a href="#"><i class='bx bxl-instagram'></i></a>
        <a href="#"><i class='bx bxl-twitter'></i></a>
        <a href="#"><i class='bx bxl-tiktok'></i></a>
      </div>
    </div>

    <div class="footer-bottom">
      &copy; 2025 Blissful Bites. All rights reserved.
    </div>
  </footer>

<script>
  const productsData = <?php echo json_encode($products); ?>;
  let subtotal = 0;
  const shipping = 75;

  function loadCheckout() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const checkoutItems = document.getElementById("checkout-items");
    const summaryBox = document.getElementById("summary-box");

    subtotal = 0;

    let tableHTML = `
      <table>
        <thead>
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
    `;

    cart.forEach(item => {
      const product = productsData[item.name] || {};
      const price = product.price || item.price || 0;
      const image = product.image || item.image || "default-image.png";
      const itemSubtotal = price * item.quantity;
      subtotal += itemSubtotal;

      tableHTML += `
        <tr>
          <td><img src="${image}" alt="${item.name}"> ${item.name}</td>
          <td>₱${price.toFixed(2)}</td>
          <td>${item.quantity}</td>
          <td>₱${itemSubtotal.toFixed(2)}</td>
        </tr>
      `;
    });

    tableHTML += `</tbody></table>`;
    checkoutItems.innerHTML = tableHTML;

    const grandTotal = subtotal + shipping;

    summaryBox.innerHTML = `
      <p><strong>Subtotal:</strong> <span>₱${subtotal.toFixed(2)}</span></p>
      <p><strong>Shipping Fee:</strong> <span>₱${shipping.toFixed(2)}</span></p>
      <p><strong>Total:</strong> <span id="grand-total">₱${grandTotal.toFixed(2)}</span></p>
    `;

    showPaymentDetails();
  }

  function showPaymentDetails() {
    const method = document.querySelector('input[name="payment"]:checked').value;
    const grandTotal = subtotal + shipping;
    const container = document.getElementById("payment-details");

    if (method === "GCash") {
      container.innerHTML = `
        <h3>Pay via GCash</h3>
        <p>Please scan the QR code below and pay <strong>₱${grandTotal.toFixed(2)}</strong>.</p>
        <img src="gcash_qr.jpg" alt="GCash QR Code">
      `;
    } else {
      container.innerHTML = `
        <h3>Cash on Delivery</h3>
        <p>Prepare <strong>₱${grandTotal.toFixed(2)}</strong> for payment upon delivery. Thank you!</p>
      `;
    }

    localStorage.setItem("paymentMethod", method);
  }

  function updateCartCount() {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
  const cartCountElem = document.getElementById("cart-count");
  if (cartCountElem) {
    cartCountElem.textContent = cartCount;
  }
}


  function sendOrderToServer() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const method = document.querySelector('input[name="payment"]:checked').value;
    const grandTotal = subtotal + shipping;

    document.getElementById("cart_data").value = JSON.stringify(cart);
    document.getElementById("total").value = grandTotal.toFixed(2);
    document.getElementById("payment_method").value = method;

    localStorage.removeItem('cart'); // clear cart after checkout
    updateCartCount();

    return true;
  }

  window.onload = loadCheckout;
</script>
</body>
</html>
