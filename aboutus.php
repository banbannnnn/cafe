<?php
// You can add PHP logic here if needed, or leave empty
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us - Blissfull Bites</title>
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

#searchInput {
  display: none;
  padding: 6px 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
  outline: none;
  transition: all 0.3s ease;
}


    .container {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-wrap: wrap;
      gap: 50px;
      padding: 50px 10%;
      background-color: #fdf9f5;
    }

    .text-section {
      flex: 1 1 500px;
      max-width: 600px;
    }

    .text-section h1 {
      font-size: 3rem;
      color: #bb817f;
      margin-bottom: 20px;
    }

    .text-section p {
      font-size: 1.1rem;
      line-height: 1.8;
      color: #555;
    }

    .text-section button {
      margin-top: 25px;
      padding: 12px 30px;
      font-size: 1rem;
      background-color: #bb817f;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .text-section button:hover {
      background-color: #b42a6f;
    }

    .image-section {
      flex: 1 1 500px;
      display: flex;
      justify-content: center;
    }

    .image-section img {
      width: 100%;
      max-width: 550px;
      border-radius: 20px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
      transition: transform 0.4s ease;
    }

    .image-section img:hover {
      transform: scale(1.03);
    }

    @media (max-width: 900px) {
      .container {
        flex-direction: column;
        text-align: center;
        padding: 30px 5%;
      }
      .text-section h1 {
        font-size: 2.5rem;
      }
      .text-section button {
        margin-top: 20px;
      }
    }

    .highlight-section {
      padding: 60px 20px;
      background-color: #fff8f8;
    }

    .highlight-container {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 60px;
      flex-wrap: wrap;
      max-width: 1200px;
      margin: auto;
    }

    .image-overlap-section {
      padding: 40px 20px;
      background-color: #fffafc;
    }

    .image-overlap-container {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-wrap: wrap;
      gap: 40px;
      max-width: 1200px;
      margin: auto;
    }

    .cafe-section {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 30px;
      padding: 40px;
      flex-wrap: wrap;
      font-size: 2rem;
      color: #bb817f;
      margin-bottom: 20px;
    }

    .overlap-images {
      position: relative;
      width: 400px;
      height: 400px;
    }

    .overlap-images img {
      border-radius: 25px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
      width: 270px;
      height: auto;
      position: absolute;
      object-fit: cover;
    }

    .img-1 {
      top: 0;
      left: 0;
      z-index: 2;
    }

    .img-2 {
      top: 120px;
      left: 110px;
      z-index: 1;
    }

    .text-section h1 {
      font-size: 3rem;
      color: #bb817f;
      margin-bottom: 15px;
    }

    .text-section p {
      font-size: 1.1rem;
      line-height: 1.8;
      color: #555;
    }

    .image-gallery {
  display: flex;
  gap: 30px;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.image-card {
  position: relative;
  max-width: 500px;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
  transition: transform 0.4s ease;
}

.image-card:hover {
  transform: scale(1.02);
}

.image-card img {
  width: 100%;
  height: auto;
  display: block;
  border-radius: 20px;
}

.caption {
  text-align: center;
  margin-top: 12px;
  font-size: 1rem;
  color: #a56b69;
  font-weight: 600;
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
      <a href="cart.html">
        <i class='bx bx-shopping-bag'></i>
      </a>
    </div>
  </header>

  <div class="container">
    <div class="text-section">
      <h1>Welcome to Blissful Bites</h1>
      <p>
        At Blissful Bites, we bring you the charm of freshly baked pastries, sweet treats, and a warm ambiance wrapped in a palette of pink and gray. Whether you’re here to catch up with friends, work on your next big idea, or simply indulge in delicious desserts, our café is your cozy sanctuary.
        <br><br>
        Our café interior is thoughtfully designed to make you feel at home—with cushy chairs, charming décor, and an aroma of coffee and sugar that invites you to relax. Every detail reflects our passion for creating joyful moments with every bite and sip.
      </p>
      <button onclick="document.getElementById('location').scrollIntoView({ behavior: 'smooth' });">Visit Us</button>
    </div>

    <div class="image-gallery">
      <div class="image-card">
        <img src="exterior.png" alt="Blissful Bites Exterior">
        <p class="caption">Charming Exterior View</p>
      </div>
      <div class="image-card">
        <img src="cafe interior.png" alt="Blissful Bites Interior">
        <p class="caption">Our Cozy Interior</p>
      </div>
    </div>
  </div>
  
    
  

  <div class="cafe-section">
    <div class="overlap-images">
      <img src="croissant yummy.jpg" alt="Croissant" class="img-1" />
      <img src="strawberry yummy.jpg" alt="Strawberry" class="img-2" />
    </div>

    <div class="text-section">
      <h2>About Blissful Bites</h2>
      <p>
        Dining in a coffee shop offers a delightful array of options beyond just drinks.
        Many coffee shops serve light meals such as sandwiches, salads, and pastries.
        The food is often made with fresh, local ingredients, emphasizing quality and taste.
        The menu might include unique and seasonal offerings, providing something new for
        regular visitors to look forward to. The experience is enhanced by the personal
        touch of friendly baristas and staff who know their regulars by name and remember
        their favorite orders.
      </p>
    </div>
  </div>

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
</html>: