<?php
// You can add PHP logic here if needed, or leave empty
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - Blissful Bites</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body, html {
      margin: 0;
      padding: 0;
      font-family: 'Montserrat', sans-serif;
      background: linear-gradient(to bottom right, #fff0f3, #fce4ec);
      scroll-behavior: smooth;
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
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(210, 161, 159, 0.3);
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

    #searchInput {
      display: none;
      padding: 6px 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
      outline: none;
      transition: all 0.3s ease;
    }

    .shopping-bag-count {
      position: relative;
      top: -8px;
      right: 10px;
      background-color: red;
      color: white;
      font-size: 12px;
      padding: 2px 6px;
      border-radius: 50%;
    }

    .contact-section {
      display: flex;
      flex-wrap: wrap;
      padding: 80px 5%;
      gap: 60px;
      justify-content: center;
      align-items: center;
      background-color: #fffdfd;
      background-image: url("bg-pattern.png");
      background-size: cover;
    }

    .contact-image {
      flex: 1 1 480px;
      max-width: 550px;
      animation: float 5s ease-in-out infinite;
    }

    .contact-image img {
      width: 100%;
      border-radius: 18px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0px); }
    }

    .contact-form-container {
      flex: 1 1 400px;
      background-color: #ffffff;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 12px 30px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }

    .contact-form-container h2 {
      font-size: 34px;
      color: #9f4262;
      margin-bottom: 25px;
      text-align: center;
    }

    .contact-form label {
      font-weight: 600;
      display: block;
      margin-top: 18px;
      color: #4e4b4b;
    }

    .contact-form input,
    .contact-form textarea {
      width: 100%;
      padding: 12px 14px;
      margin-top: 8px;
      border-radius: 10px;
      border: 1px solid #ccc;
      font-size: 15px;
      font-family: 'Montserrat', sans-serif;
      background: #fff8f8;
    }

    .contact-form textarea {
      resize: vertical;
      height: 130px;
    }

    .contact-form button {
      margin-top: 25px;
      width: 100%;
      padding: 16px;
      background-color: #9f4262;
      color: white;
      border: none;
      border-radius: 12px;
      font-weight: bold;
      font-size: 17px;
      cursor: pointer;
      box-shadow: 0 4px 14px rgba(159, 66, 98, 0.4);
      transition: all 0.3s ease;
    }

    .contact-form button:hover {
      background-color: #7a2c49;
      transform: scale(1.02);
    }

    .location-wrapper {
      background-color: #fdf9f5;
      padding: 80px 20px;
      margin-top: 80px;
      font-family: 'Poppins', sans-serif;
    }

    .location-content {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      align-items: flex-start;
      max-width: 1300px;
      margin: 0 auto;
      gap: 40px;
    }

    .location-map {
      flex: 1 1 600px;
      min-width: 600px;
      max-width: 100%;
    }

    .location-info {
      flex: 1 1 400px;
      max-width: 500px;
      color: #1e1e1e;
    }

    .location-info h2 {
      font-size: 2.2rem;
      font-weight: bold;
      margin-bottom: 20px;
      color: #a56b69;
    }

    .location-info p {
      font-size: 1rem;
      line-height: 1.8;
      margin-bottom: 12px;
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

    @media (max-width: 900px) {
      .contact-section {
        flex-direction: column;
      }

      .contact-image, .contact-form-container {
        max-width: 100%;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo">
      <img src="logo.jpg" alt="Blissful Bites Logo">
    </div>
    <nav>
      <a href="home.php">HOME</a>
      <a href="aboutus.php">ABOUT US</a>
      <a href="menu.php">MENU</a>
      <a href="contactus.php">CONTACT US</a>
      <a href="menu.php">ORDER NOW</a>
    </nav>
    <div class="icons">
      <input type="text" id="searchInput" placeholder="Search product...">
      <i class='bx bx-search' onclick="toggleSearch()"></i>
      <a href="cart.html">
        <i class='bx bx-shopping-bag'></i>
        <span class="shopping-bag-count" id="cart-count">0</span>
      </a>
    </div>
  </header>

  <!-- Contact Form Section -->
  <section class="contact-section">
    <div class="contact-image">
      <img src="cafe with pipols.png" alt="Cafe with People">
    </div>
    <div class="contact-image">
      <img src="cafe interior.png" alt="Cafe with People">
    </div>
    
  </section>

  <section class="location-wrapper" id="location">
    <div class="location-content">
      <div class="location-info">
        <h2>📍 Visit Blissful Bites</h2>
        <p>
          Come experience the warm and cozy ambiance at Blissful Bites, located in the heart of BGC.
          Perfect for a relaxing coffee break, casual dining, or catching up with friends.
        </p>
        <p><strong>Address:</strong> 4th Avenue corner 28th Street, BGC, Taguig</p>
        <p><strong>Opening Hours:</strong> 8:00 AM – 10:00 PM daily</p>
      </div>
      <div class="location-map">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15448.787360697784!2d121.04214765!3d14.55184065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c9a84c2597c7%3A0xd23a4f6a65f1c4f6!2s4th%20Ave%20%26%2028th%20St%2C%20Taguig%2C%201634%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1712634544327!5m2!1sen!2sph"
          width="100%" height="350" style="border:0;" allowfullscreen=""
          loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="footer-section">
      <h3>Contact Information</h3>
      <p>Location: 4th Avenue corner 28th Street, BGC, Taguig</p>
      <p>Mobile: 0976 675 2231</p>
      <p>Email: orders.blissfullbites@gmail.com</p>
      <p>Pick up time: 11AM to 9PM</p>
    </div>

    <div class="footer-section">
      <h3>Customer Service</h3>
      <a href="#">My Account</a>
      <a href="aboutus.html">About Us</a>
      <a href="contactus.html">Contact Us</a>
    </div>

    <div class="footer-section">
      <h3>Follow Us</h3>
      <div class="social-icons">
        <a href="#"><i class='bx bxl-facebook'></i></a>
        <a href="#"><i class='bx bxl-instagram'></i></a>
        <a href="#"><i class='bx bxl-twitter'></i></a>
      </div>
    </div>

    <div class="footer-bottom">
      &copy; 2025 Blissful Bites. All rights reserved.
    </div>
  </footer>

  <!-- JavaScript -->
  <script>
    function toggleSearch() {
      const searchInput = document.getElementById("searchInput");
      searchInput.style.display = (searchInput.style.display === "inline-block") ? "none" : "inline-block";
      if (searchInput.style.display === "inline-block") searchInput.focus();
    }

    function updateCartCount() {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      let totalItems = cart.reduce((acc, item) => acc + item.quantity, 0);
      document.getElementById("cart-count").textContent = totalItems;
    }

    window.onload = updateCartCount;
  </script>

</body>
</html>
