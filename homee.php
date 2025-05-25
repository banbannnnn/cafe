
<?php
// You can add PHP logic here if needed, or leave empty
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Blissful Bites</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
    body, html {
      margin: 0;
      padding: 0;
      font-family: 'Montserrat', sans-serif;
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
  width: auto;
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

.order-button {
  background-color: #9f4262;
  color: white;
  padding: 14px 28px;
  border: none;
  border-radius: 10px;
  font-size: 16px;
  text-decoration: none; /* ← removes underline */
  display: inline-block;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.order-button:hover {
  background-color: #7a2c49;
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

    /* Hero Section with Image Background */
    .hero {
  position: relative;
  height: 100vh;
  background-image: url('cover.jpg');
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  color: white;
  padding-left: 60px;
}



.hero .stars {
  color: gold;
  font-size: 20px;
  margin-bottom: 10px;
}

.hero .subtext {
  font-style: italic;
  font-size: 18px;
  color: #fff;
  margin-bottom: 15px;
}

.hero h1 {
  font-size: 72px;
  font-weight: bold;
  letter-spacing: 2px;
  line-height: 1.1;
  text-transform: uppercase;
  margin: 0;
}

.hero .tagline {
  font-size: 24px;
  color: white;
  margin: 20px 0;
}

.hero .order-button {
  font-size: 16px;
  padding: 12px 25px;
  border: 2px solid white;
  background: transparent;
  color: white;
  text-transform: uppercase;
  font-weight: bold;
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

.hero .order-button:hover {
  background: white;
  color: black;
}


    /* Product Slider Section */
    .product-slider {
      padding: 40px 20px;
      background: #fff;
      text-align: center;
    }

    .slider-heading {
      font-size: 30px;
      color: #2E1A47;
      margin-bottom: 25px;
    }

    .slider-wrapper {
      position: relative;
      overflow: hidden;
      max-width: 100%;
    }

    .slider {
      display: flex;
      gap: 30px;
      padding: 20px 0;
      transition: transform 0.5s ease;
      scroll-behavior: smooth;
      overflow-x: auto;
      scrollbar-width: none;
    }

    .slider::-webkit-scrollbar {
      display: none;
    }

    .card {
  background: #fff0f3;
  padding: 20px;
  border-radius: 20px;
  box-shadow: 0 6px 20px rgba(235, 143, 157, 0.2);
  text-align: center;
  transition: transform 0.3s ease;
}



.card img {
  width: 180px;
  height: 180px;
  border-radius: 50%; /* Makes it a perfect circle */
  padding: 8px; /* Space between image and border */
  background-color: white; /* Border color effect */
  box-shadow: 0 4px 15px rgba(235, 143, 157, 0.3); /* Pink shadow like in image */
  object-fit: cover;
  border: 2px solid #fff;
  display: block;
  margin: 0 auto; /* Centers the image */
}


    .card p {
      margin-top: 12px;
      font-weight: 600;
      color: #9f4262;
    }

    .card:hover {
      transform: scale(1.05);
    }

    .slider-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: #9f4262;
      color: white;
      border: none;
      font-size: 24px;
      border-radius: 50%;
      padding: 10px;
      cursor: pointer;
      z-index: 10;
    }

    .slider-btn:hover {
      background-color: #7a2c49;
    }

    .prev {
      left: 10px;
    }

    .next {
      right: 10px;
    }

    .video-section {
  background-color: #ecd1d3; /* Same dark background as screenshot */
  color: #64595e;
  padding: 60px 20px;
}

.video-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 40px;
  flex-wrap: wrap;
}

.video-text {
  flex: 1;
  min-width: 300px;
}

.video-text h2 {
  font-size: 32px;
  font-weight: bold;
  margin-bottom: 15px;
}

.video-text p {
  font-size: 16px;
  margin-bottom: 15px;
  line-height: 1.6;
}

.learn-btn {
  display: inline-block;
  background-color: #8d4e66;
  color: white;
  padding: 12px 24px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: bold;
  transition: background 0.3s ease;
}

.learn-btn:hover {
  background-color: #8d4e66;
}

.video-box {
  flex: 1;
  min-width: 300px;
}

.video-box video {
  width: 100%;
  max-width: 100%;
  border-radius: 12px;
}


.signature-section {
  background-color:  #c49fac; /* Deep navy for elegance */
  color: #fff;
  padding: 60px 40px;
  font-family: 'Segoe UI', sans-serif;
}

.signature-container {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 40px;
  flex-wrap: wrap;
}

.signature-images {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 12px; /* Was 20px, made tighter */
}


.dish-img {
  width: 100%;
  height: 120px; /* Smaller height */
  object-fit: cover;
  border-radius: 10px;
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  box-shadow: 0 8px 20px rgba(0,0,0,0.25);
}


.dish-img:hover {
  transform: scale(1.03);
  box-shadow: 0 12px 30px rgba(255,255,255,0.2);
}

.signature-text {
  flex: 1;
}

.signature-title {
  font-size: 32px;
  margin-bottom: 20px;
  color: #8d4e66;
  font-weight: 700;
}

.signature-desc {
  font-size: 17px;
  margin-bottom: 15px;
  line-height: 1.6;
}

.signature-button {
  display: inline-block;
  background-color: #8d4e66;
  color: #ffffff;
  padding: 12px 24px;
  text-decoration: none;
  font-weight: bold;
  border-radius: 8px;
  transition: background-color 0.3s ease;
}

.signature-button:hover {
  background-color: #ffbd59;
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



  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo">
      <img src="logo.jpg" alt="Blissful Bites Logo">
    </div>
    <nav>
      <a href="homee.php">HOME</a>
      <a href="aboutus.php">ABOUT US</a>
      <a href="register.php">MENU</a>
      <a href="contactus.php">CONTACT US</a>
      <a href="register.php" style="background: #D2A19F; color: white; padding: 8px 12px; border-radius: 5px;">LOG IN</a>
    </nav>
    <div class="icons">
      <input type="text" id="searchInput" placeholder="Search product...">
     
      <a href="cart.html">
        
      </a>
    </div>
  </header>

  <!-- Hero Section with Image Background -->
  <div class="hero">
    <div class="hero-content">
      <div class="stars">★★★★★</div>
      <p>Delicious food, cozy<br> ambiance, great service</p>
      <h1>BLISSFUL<br>BITES</h1>
      <p style="font-size: 22px;">Brewing Your Happiness</p>
      <a href="menu.html" class="order-button">ORDER NOW</a>

    </div>
  </div> 
  

  <!-- Product Slider Section -->
  <section class="product-slider">
    <h2 class="slider-heading">Discover Blissful Picks</h2>
    <div class="slider-wrapper">
      <button class="slider-btn prev" onclick="slideCarousel(-1)">&#10094;</button>
      <div class="slider" id="slider">
        <div class="card"><img src="straw.jpg" alt="Straw"><p>Strawberry Cheesecake</p></div>
        <div class="card"><img src="grilled.jpg" alt="Grilled"><p>Grilled Chicken Breast</p></div>
        <div class="card"><img src="brownies.jpg" alt="Brownies"><p>Brownies</p></div>
        <div class="card"><img src="lemonjuice.jpg" alt="Lemon Juice"><p>Lemon Juice</p></div>
        <div class="card"><img src="macaroni.jpg" alt="Macaroni"><p>Baked Macaroni</p></div>
        <div class="card"><img src="strawberrydonut.jpg" alt="Donut"><p>Strawberry Donut</p></div>
        <div class="card"><img src="croissant.jpg" alt="Croissant"><p>Buttery Croissant</p></div>
        <div class="card"><img src="pesto.jpg" alt="Pesto"><p>Pesto Pasta</p></div>
        <div class="card"><img src="matcha.jpg" alt="Matcha"><p>Iced Matcha</p></div>
        <div class="card"><img src="applepie.jpg" alt="Apple Pie"><p>Apple Pie</p></div>
      </div>
      <button class="slider-btn next" onclick="slideCarousel(1)">&#10095;</button>
    </div>
  </section>

  <!-- JavaScript -->
  <script>
    function toggleSearch() {
      const searchInput = document.getElementById("searchInput");
      if (searchInput.style.display === "none" || searchInput.style.display === "") {
        searchInput.style.display = "inline-block";
        searchInput.focus();
      } else {
        searchInput.style.display = "none";
        searchInput.value = '';
      }
    }

    function updateCartCount() {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      let totalItems = cart.reduce((acc, item) => acc + item.quantity, 0);
      document.getElementById("cart-count").textContent = totalItems;
    }

    window.onload = updateCartCount;

    function slideCarousel(direction) {
      const slider = document.getElementById("slider");
      const scrollAmount = 300;
      slider.scrollLeft += direction * scrollAmount;
    }
  </script>

<section class="video-section">
  <div class="video-container">
    <!-- Left side: text -->
    <div class="video-text">
      <h2>Our Story</h2>
      <p>Our Cafe is all about the perfect blend of ambiance, affordability, and flavor. Hangout goals achieved!</p>
      <p>Our journey began with a simple dream—to create a place where coffee lovers can gather, connect, and enjoy the perfect cup of coffee.</p>
      <a href="aboutus.html" class="learn-btn">Learn More</a>
    </div>

     <!-- Right side: Video -->
  <div class="video-box" style="flex: 1;">
    <video autoplay loop muted playsinline style="width: 100%; border-radius: 10px;">
      <source src="blissfulbites_ads.mp4" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </div>

</section>

  <!-- Signature Dishes Section -->
<section class="signature-section">
    <div class="signature-container">
      <div class="signature-images">
        <img src="pesto.jpg" alt="Pesto Pasta" class="dish-img">
        <img src="shrimp.jpg" alt="Shrimp Dish" class="dish-img">
        <img src="grilled.jpg" alt="Grilled Plate" class="dish-img">
      </div>
      <div class="signature-text">
        <h2 class="signature-title">Our Signature Dishes</h2>
        <p class="signature-desc">
          Savor the flavors of our chef's best creations — from zesty pesto pasta, succulent garlic butter shrimp, to perfectly grilled chicken breast.
        </p>
        <p class="signature-desc">
          Every dish is made with love and fresh ingredients, promising a dining experience you won't forget.
        </p>
        <a href="menu.html" class="signature-button">Explore Our Menu</a>
      </div>
    </div>
  </section>
  
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
  
  

</body>
</html>
