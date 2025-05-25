<?php
// Load XML menu data
$xml = simplexml_load_file('menu.xml');
$products = [];

if ($xml !== false) {
    foreach ($xml->pastry as $pastry) {
        $products[] = [
            'name' => (string)$pastry->name,
            'category' => (string)$pastry->type,
            'price' => (string)$pastry->price,
            'image' => (string)$pastry->image
        ];
    }

    // Sort products by category alphabetically
    usort($products, function($a, $b) {
        return strcmp($a['category'], $b['category']);
    });

    // Group products by category
    $groupedProducts = [];
    foreach ($products as $product) {
        $groupedProducts[$product['category']][] = $product;
    }
} else {
    // Handle error loading XML
    $groupedProducts = [];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Menu - Blissful Bites</title>
  <link rel="icon" href="logo1.png" type="image/png">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      padding: 0;
      background: #fff;
      color: black;
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

    #searchInput {
      display: none;
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .menu {
      padding: 2rem;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 2rem;
      flex-grow: 1;
      transition: all 0.3s ease;
      min-height: 500px;
    }

    .item {
  border: 1px solid #eee;
  border-radius: 8px;
  padding: 1rem;
  width: 200px;
  text-align: center;
  background: white;
  height: 340px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-sizing: border-box;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Add hover effect on entire item */
.item:hover {
  transform: scale(1.05); /* Slight zoom effect */
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); /* Soft shadow */
}

/* Optional: Add zoom effect to image itself for better feel */
.item img {
  width: 100%;
  height: 160px;
  object-fit: cover;
  border-radius: 8px;
  transition: transform 0.3s ease;
}

.item:hover img {
  transform: scale(1.1);
}


    .item h3 {
      font-size: 16px;
      margin: 10px 0 5px;
    }

    .item p {
      font-weight: bold;
      margin: 5px 0 10px;
    }

    .item button {
      background: #D2A19F;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 5px;
      cursor: pointer;
    }

    .sidebar {
      width: 200px;
      padding: 1rem;
      border-right: 1px solid #eee;
    }

    .main-container {
      display: flex;
    }

    .category-title {
      font-weight: bold;
      margin-bottom: 10px;
    }

    .checkbox-list label {
      display: block;
      margin-bottom: 8px;
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

    #cart-message {
  display: none;
  font-size: 14px;
  color: #2d2d4a;
  text-align: left;  /* Align the text to the left */
  padding: 5px;
  background-color: #f2f2f2;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-top: 10px;
}

.item button:hover {
  background-color: #9e706f; /* Darker or contrasting color for hover */
  transform: scale(1.05);    /* Slight zoom-in effect */
  transition: all 0.3s ease; /* Smooth transition */
}

#cart-message {
  display: none;
  position: fixed;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 16px;
  color: white;
  background-color: #9f4262;
  padding: 12px 20px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  z-index: 999;
  animation: fadein 0.5s;
}

@keyframes fadein {
  from {opacity: 0;}
  to {opacity: 1;}
}

#toast {
  display: none;
  position: fixed;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 16px;
  color: white;
  background-color: #9f4262;
  padding: 12px 20px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  z-index: 999;
  transition: opacity 0.5s ease-in-out;
}

.menu-button {
    background: #D2A19F;
    color: white;
    padding: 10px;
    width: 100%;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
  }

  .menu-button:hover {
    background: #b88684; /* slightly darker shade for hover effect */
  }


  </style>
</head>
<body>

  <!-- Header -->
<header>
  <div class="logo">
    <img src="logo.jpg" alt="Blissful Bites Logo" />
  </div>
  <nav>
    <a href="home.php">HOME</a>
    <a href="aboutus.php">ABOUT US</a>
    <a href="menu.php">MENU</a>
    <a href="contactus.php">CONTACT US</a>
    <a href="menu.php" style="background: #D2A19F; color: white; padding: 8px 12px; border-radius: 5px;">ORDER NOW</a>
  </nav>
  <div class="icons">
    <input type="text" id="searchInput" placeholder="Search product..." />
    <i class='bx bx-search' onclick="toggleSearch()"></i>
    <a href="cart.php">
      <i class='bx bx-shopping-bag'></i>
      <span class="shopping-bag-count" id="cart-count">0</span>
    </a>
    <div id="cart-message" style="display:none;">
      <p id="added-product-name"></p>
    </div>
  </div>
</header>

<!-- Main Content -->
<div class="main-container">
  <!-- Sidebar -->
  <aside class="sidebar">
    <button class="menu-button" onclick="resetFilters()">Full List of Menu</button>
    <br /><br /><br />
    <div class="category-title">Filter by Categories</div>
    <div class="checkbox-list" id="filterCheckboxes">
      <label><input type="checkbox" value="BAKED GOODS" /> BAKED GOODS </label>
      <label><input type="checkbox" value="CAKES" /> CAKES </label>
      <label><input type="checkbox" value="COOKIES & BARS" /> COOKIES & BARS </label>
      <label><input type="checkbox" value="PIES & WAFFLES" /> PIES & WAFFLES </label>
      <label><input type="checkbox" value="DOUGHNUTS" /> DOUGHNUTS </label>
      <label><input type="checkbox" value="PASTA" /> PASTA </label>
      <label><input type="checkbox" value="MAINS" /> MAINS </label>
      <label><input type="checkbox" value="DRINKS" /> DRINKS </label>
    </div>
  </aside>

  <!-- Menu Section -->
  <section class="menu" id="productWrapper">
    <?php if (!empty($groupedProducts)): ?>
      <?php foreach ($groupedProducts as $category => $items): ?>
        <h2 style="grid-column: span 5; margin-top: 2rem; color:#9f4262;"><?= htmlspecialchars($category) ?></h2>
        <div style="display: contents;">
          <?php foreach ($items as $product): ?>
            <div class="item" data-category="<?= htmlspecialchars($product['category']) ?>">
              <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
              <h3><?= htmlspecialchars($product['name']) ?></h3>
              <p>₱<?= htmlspecialchars($product['price']) ?></p>
              <button onclick="addToCart('<?= addslashes(htmlspecialchars($product['name'])) ?>')">Add to Cart</button>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No menu items available.</p>
    <?php endif; ?>
  </section>
</div>

<div id="toast" class="toast">Added to cart!</div>


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
    &copy; <?= date('Y') ?> Blissful Bites. All rights reserved.
  </div>
</footer>

<script>
  const checkboxes = document.querySelectorAll('#filterCheckboxes input[type="checkbox"]');
  const productWrapper = document.getElementById('productWrapper');
  const noItemMessage = document.getElementById('noItemMessage');
  const searchInput = document.getElementById('searchInput');

  // Toggle search input visibility on search icon click
  function toggleSearch() {
    if (searchInput.style.display === 'inline-block') {
      searchInput.style.display = 'none';
      searchInput.value = '';
      filterProducts();
    } else {
      searchInput.style.display = 'inline-block';
      searchInput.focus();
    }
  }

  function showToast(message) {
  const toast = document.getElementById('toast');
  toast.textContent = message;
  toast.style.display = 'block';
  toast.style.opacity = 1;

  setTimeout(() => {
    toast.style.opacity = 0;
    setTimeout(() => {
      toast.style.display = 'none';
    }, 500);
  }, 3000); // Toast stays visible for 3 seconds
}

  function addToCart(name, price, image) {
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  const existingIndex = cart.findIndex(item => item.name === name);
  if (existingIndex > -1) {
    cart[existingIndex].quantity += 1;
  } else {
    cart.push({ name, price, image, quantity: 1 });
  }
  localStorage.setItem('cart', JSON.stringify(cart));
  updateCartCount();
  showToast(`${name} added to cart!`);
}

updateCartCount();

function updateCartCount() {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
  const cartCountElem = document.getElementById("cart-count");
  if (cartCountElem) {
    cartCountElem.textContent = cartCount;
  }
}
// Run on page load
updateCartCount();


// Your notification function
function showNotification(message) {
  const notification = document.querySelector('.notification');
  if (!notification) return; // if no notification div, skip

  notification.textContent = message;
  notification.style.display = 'block';

  // Hide after 3 seconds
  setTimeout(() => {
    notification.style.display = 'none';
  }, 3000);
}

// Initialize cart count on page load
updateCartCount();



  // Reset filters and show full list
  function resetFilters() {
    checkboxes.forEach(cb => cb.checked = false);
    searchInput.value = '';
    filterProducts();
  }

  // Listen to checkboxes and search input changes
  checkboxes.forEach(cb => cb.addEventListener('change', filterProducts));
  searchInput.addEventListener('input', filterProducts);

  function filterProducts() {
    const checkedCategories = Array.from(checkboxes)
                                  .filter(cb => cb.checked)
                                  .map(cb => cb.value.toLowerCase());
    const searchTerm = searchInput.value.trim().toLowerCase();

    // All product items
    const items = productWrapper.querySelectorAll('.item');
    let anyVisible = false;

    // Hide all category titles initially
    const categoryTitles = productWrapper.querySelectorAll('h2');
    categoryTitles.forEach(title => title.style.display = 'none');

    items.forEach(item => {
      const category = item.getAttribute('data-category').toLowerCase();
      const name = item.querySelector('h3').textContent.toLowerCase();

      // Check if matches filters
      const categoryMatch = checkedCategories.length === 0 || checkedCategories.includes(category);
      const searchMatch = name.includes(searchTerm);

      if (categoryMatch && searchMatch) {
        item.style.display = 'flex';
        anyVisible = true;
      } else {
        item.style.display = 'none';
      }
    });

    if (!anyVisible) {
      noItemMessage.style.display = 'block';
    } else {
      noItemMessage.style.display = 'none';
    }

    // If no filters active, show all and category titles again
    if (checkedCategories.length === 0 && searchTerm === '') {
      categoryTitles.forEach(title => title.style.display = 'block');
      items.forEach(item => item.style.display = 'flex');
      noItemMessage.style.display = 'none';
    }
  }

  // Initial call to show all properly
  filterProducts();
</script>

</body>
</html>
