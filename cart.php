<?php
// Load menu data
$xml = simplexml_load_file('menu.xml');
$products = [];
if ($xml !== false) {
    foreach ($xml->pastry as $pastry) {
        $products[(string)$pastry->name] = [
            'price' => (float)$pastry->price,
            'image' => (string)$pastry->image
        ];
    }
} else {
    $products = [];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cart - Blissful Bites</title>
  <link rel="icon" href="logo1.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      padding: 0;
      background: #fff;
      color: #333;
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

    .container {
      padding: 6rem 2rem 2rem;
      max-width: 1100px;
      margin: auto;
      display: flex;
      gap: 2rem;
    }

    .product-list {
      flex: 2;
    }

    .total-summary {
      width: 300px;
      height: 330px;
      flex-shrink: 0;
      background: #ebe8e8ea;
      padding: 1.5rem;
      border-radius: 12px;
      font-size: 16px;
    }

    .cart-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1rem;
    }

    .cart-table th,
    .cart-table td {
      padding: 12px 10px;
      text-align: left;
      border-bottom: 1px solid #eee;
      vertical-align: middle;
    }

    .cart-table img {
      width: 80px;
      height: 80px;
      border-radius: 8px;
      object-fit: cover;
      margin-right: 10px;
    }

    .cart-table input[type="number"] {
      width: 50px;
      padding: 6px;
      border-radius: 6px;
      border: 1px solid #ebd1d1;
      text-align: center;
    }

    .remove-item {
      font-size: 20px;
      cursor: pointer;
      color: rgb(171, 115, 115);
    }

    .payment-option {
      margin: 8px 0;
    }

    .payment-option input[type="radio"] {
      margin-right: 8px;
    }

    .total-summary h3 {
      margin-top: 1rem;
      font-size: 18px;
    }

    .total-summary button {
      margin-top: 1.5rem;
      background: #b18584;
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
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

  <div class="container">
    <div class="product-list">
      <!-- Cart items will be rendered here -->
    </div>
    <div class="total-summary">
      <!-- Summary & Payment Options -->
    </div>
  </div>

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
      
  function loadCart() {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const productList = document.querySelector('.product-list');
  const totalSummary = document.querySelector('.total-summary');

  let subtotal = 0;
  let html = `
    <table class="cart-table">
      <thead>
        <tr>
          <th></th>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
  `;

  cart.forEach((item, index) => {
    // Use fresh price and image from productsData if available
    const productInfo = productsData[item.name] || {};
    const price = productInfo.price || item.price || 0;
    const image = productInfo.image || item.image || "default-image.png";

    const itemSubtotal = item.quantity * price;
    subtotal += itemSubtotal;

    html += `
      <tr>
        <td><span class="remove-item" onclick="removeItem(${index})" style="cursor:pointer;">×</span></td>
        <td><img src="${image}" alt="${item.name}" style="width:50px; height:auto; vertical-align:middle; margin-right:10px;">${item.name}</td>
        <td>₱${price.toFixed(2)}</td>
        <td><input type="number" class="quantity-input" value="${item.quantity}" min="1" onchange="updateQuantity(${index}, this.value)"></td>
        <td><strong>₱${itemSubtotal.toFixed(2)}</strong></td>
      </tr>
    `;
  });

  html += `
      </tbody>
    </table>
  `;

  productList.innerHTML = html;

  const shippingFee = 75;
  const grandTotal = subtotal + shippingFee;

  totalSummary.innerHTML = `
    <p><strong>Subtotal</strong><span style="float:right;">₱${subtotal.toFixed(2)}</span></p>
    <p><strong>Shipping Fee</strong><span style="float:right;">₱${shippingFee.toFixed(2)}</span></p>
    <p><strong>Payment Method</strong></p>
    <div class="payment-option">
      <label>
        <input type="radio" name="payment" value="Gcash" checked> GCash
      </label>
    </div>
    <div class="payment-option">
      <label>
        <input type="radio" name="payment" value="COD"> Cash on Delivery
      </label>
    </div>
    <h3>Total <span id="total-display" style="float:right;">₱${grandTotal.toFixed(2)}</span></h3>
   <button onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
  `;
}


  // Remove item at index from cart and update display
  function removeItem(index) {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    loadCart();
    updateCartCount();
  }

  // Update quantity of cart item at index
  function updateQuantity(index, quantity) {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    quantity = parseInt(quantity);
    if (quantity < 1 || isNaN(quantity)) return;
    cart[index].quantity = quantity;
    localStorage.setItem("cart", JSON.stringify(cart));
    loadCart();
    updateCartCount();
  }

  // Save payment method and redirect to checkout page
  function checkout() {
    const paymentMethodInput = document.querySelector('input[name="payment"]:checked');
    if (!paymentMethodInput) {
      alert("Please select a payment method.");
      return;
    }
    const paymentMethod = paymentMethodInput.value;
    localStorage.setItem('paymentMethod', paymentMethod);
    window.location.href = 'checkout.php';
  }

  // Update cart count in the menu
  function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
    const cartCountElem = document.getElementById("cart-count");
    if (cartCountElem) {
      cartCountElem.textContent = cartCount;
    }
  }

  

  // Initialize on page load
  window.onload = function() {
    loadCart();
    updateCartCount();
  };
</script>


</body>
</html>
