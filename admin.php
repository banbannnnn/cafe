<?php
include 'connect.php';

// Existing daily orders query
$orderData = [];
$sql = "SELECT DATE(created_at) as order_date, COUNT(*) as total_orders 
        FROM orders 
        GROUP BY DATE(created_at) ORDER BY order_date ASC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
  $date = date("F j, Y", strtotime($row['order_date']));
  $orderData[] = [
    'order_date' => $date,
    'total_orders' => $row['total_orders']
  ];
}

// New monthly orders query
$monthlyOrderData = [];
$sql_monthly = "SELECT DATE_FORMAT(created_at, '%Y-%m') as order_month, COUNT(*) as total_orders 
                FROM orders 
                GROUP BY order_month ORDER BY order_month ASC";
$result_monthly = $conn->query($sql_monthly);

while ($row = $result_monthly->fetch_assoc()) {
  $date = date("F Y", strtotime($row['order_month'] . "-01"));
  $monthlyOrderData[] = [
    'order_month' => $date,
    'total_orders' => $row['total_orders']
  ];
}

// Orders per city query
$cityOrderData = [];
$sql_city = "SELECT city, COUNT(*) as total_orders 
             FROM orders 
             WHERE city IS NOT NULL AND city != '' 
             GROUP BY city ORDER BY total_orders DESC";
$result_city = $conn->query($sql_city);

while ($row = $result_city->fetch_assoc()) {
  $cityOrderData[] = [
    'city' => $row['city'],
    'total_orders' => (int)$row['total_orders']
  ];
}

// Total sales by payment method (GCash and COD)
$totalSalesByPayment = [];
$sql_sales = "
  SELECT payment_method, SUM(total) as total_sales
  FROM orders
  WHERE payment_method IN ('GCash', 'COD')
  GROUP BY payment_method
";
$result_sales = $conn->query($sql_sales);

while ($row = $result_sales->fetch_assoc()) {
  $totalSalesByPayment[$row['payment_method']] = $row['total_sales'];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Blissful Bites Admin Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #fff5f9;
      color: #7a294e;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .sidebar {
      position: fixed;
      left: 0; top: 0; bottom: 0;
      width: 230px;
      background: #f8cddc;
      color: #7a294e;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 30px;
      box-shadow: 2px 0 8px rgba(0,0,0,0.05);
      z-index: 100;
    }

    .sidebar h2 {
      font-size: 1.8rem;
      margin-bottom: 40px;
      font-weight: 700;
    }

    .sidebar a {
      width: 150px;
      padding: 15px 30px;
      color: #7a294e;
      text-decoration: none;
      font-weight: 500;
      font-size: 1rem;
      transition: all 0.3s ease;
      border-left: 5px solid transparent;
      margin-bottom: 8px;
      text-align: center;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background: #f49ac2;
      border-left: 5px solid #e75480;
      color: white;
    }

    .topbar {
      margin-left: 230px;
      height: 60px;
      background: #fff0f5;
      border-bottom: 1px solid #f5d0e1;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 30px;
      font-size: 1.1rem;
      font-weight: 600;
      position: sticky;
      top: 0;
      z-index: 50;
    }

    .main-content {
      margin-left: 230px;
      padding: 40px 30px 60px 30px;
      flex-grow: 1;
      background: #fff5f9;
      min-height: calc(100vh - 60px);
    }

    .dashboard-container {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: flex-start;
    }

    .dashboard-square {
      margin-top: 30px;
      background: #ffe4ec;
      color: #7a294e;
      width: 260px;
      height: 160px;
      border-radius: 16px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-size: 1.4rem;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, background 0.3s ease;
      user-select: none;
    }

    .dashboard-square:hover {
      background: #f49ac2;
      color: white;
      transform: translateY(-6px);
    }

    .dashboard-icon {
      font-size: 3rem;
      margin-bottom: 12px;
    }

    /* Chart Container */
    .chart-container {
      margin-top: 60px;
      display: flex;
      gap: 40px;
      justify-content: space-between;
      max-width: 1500px;
      flex-wrap: wrap;
    }

    .single-chart {
      background-color: transparent;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      flex: 1 1 320px;
      max-width: 350px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .single-chart h3 {
      color: #7a294e;
      margin-bottom: 20px;
      text-align: center;
      font-weight: 700;
      font-size: 1.2rem;
    }

    canvas {
      max-width: 100% !important;
      height: auto !important;
    }
    .single-chart canvas {
  transition: transform 0.3s ease;
}

.single-chart:hover canvas {
  transform: scale(1.08);
  z-index: 1;
}
/* Modal overlay background */
.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(253, 231, 241, 0.8); /* your purple-ish color with transparency */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

/* Modal box */
.modal-content {
  background: #ffe4ec; /* soft pink */
  border-radius: 16px;
  padding: 30px 40px;
  max-width: 400px;
  width: 90%;
  text-align: center;
  color: #7a294e;
  box-shadow: 0 4px 20px rgba(0,0,0,0.25);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Modal heading */
.modal-content h2 {
  margin-bottom: 15px;
  font-weight: 700;
}

/* Modal buttons container */
.modal-buttons {
  margin-top: 25px;
  display: flex;
  justify-content: center;
  gap: 20px;
}

/* Buttons base style */
.modal-buttons .btn {
  padding: 10px 25px;
  font-weight: 600;
  font-size: 1rem;
  border-radius: 12px;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
  user-select: none;
}

/* Confirm button */
.btn-confirm {
  background-color: #e75480;
  color: white;
}

.btn-confirm:hover {
  background-color: #f49ac2;
}

/* Cancel button */
.btn-cancel {
  background-color: #fff0f5;
  color: #7a294e;
  border: 1.5px solid #7a294e;
}

.btn-cancel:hover {
  background-color: #f8cddc;
}



    /* Responsive adjustments */
    @media (max-width: 1150px) {
      .chart-container {
        justify-content: center;
        gap: 30px;
      }
    }

    @media (max-width: 760px) {
      .dashboard-container {
        justify-content: center;
      }
      .dashboard-square {
        width: 100%;
        max-width: 320px;
      }
      .chart-container {
        flex-direction: column;
        align-items: center;
      }
      .single-chart {
        max-width: 90vw;
        margin-bottom: 30px;
      }
      .topbar {
        margin-left: 0;
        padding: 0 15px;
      }
      .main-content {
        margin-left: 0;
        padding: 20px 15px 40px 15px;
      }
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        flex-direction: row;
        padding: 10px 15px;
        justify-content: space-around;
        box-shadow: none;
      }
      .sidebar h2 {
        font-size: 1.5rem;
        margin-bottom: 0;
      }
      .sidebar a {
        width: auto;
        padding: 10px 15px;
        border-left: none;
        font-size: 0.9rem;
      }
      .sidebar a:hover,
      .sidebar a.active {
        border-left: none;
      }
    }

     .totalsales {
    background: linear-gradient(135deg,rgb(247, 185, 214) 0%,rgb(251, 147, 196) 100%);
    color: white;
    border-radius: 15px;
    padding: 5px 10px;
    width: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    user-select: none;
  }

  .totalsales h3 {
    color:  #7a294e;
    font-size: 1.6rem;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 700;
  }

  .totalsales ul {
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 1.2rem;
  }

  .totalsales li {
    background: rgba(255, 255, 255, 0.15);
    padding: 12px 15px;
    margin-bottom: 12px;
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    font-weight: 600;
    transition: background 0.3s ease;
    cursor: default;
  }

  .totalsales li:hover {
    background: rgba(255, 255, 255, 0.3);
  }

  .totalsales li strong {
    font-weight: 700;
  }
  </style>
</head>
<body>

  <div class="sidebar">
    <h2>Blissful Bites</h2>
    <a href="admin.php" class="active">Dashboard</a>
    <a href="users.php">Users</a>
    <a href="orders_admin.php">Orders</a>
    <a href="admin_menu.php">Products</a>
    <a href="generate_report.php">Report</a>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <a href="admin_logout.php" id="logout-link">Logout</a>

  </div>

  <div class="topbar">
    <div>Admin Dashboard</div>
    <div>Welcome, Admin 👤</div>
  </div>

  <div class="main-content">
    <div class="dashboard-container">
      <div class="dashboard-square" onclick="location.href='users.php'">
        <div class="dashboard-icon">👤</div>
        Users
      </div>
      <div class="dashboard-square" onclick="location.href='orders_admin.php'">
        <div class="dashboard-icon">📦</div>
        Orders
      </div>
      <div class="dashboard-square" onclick="location.href='admin_menu.php'">
        <div class="dashboard-icon">🛒</div>
        Products
      </div>

      <div class="dashboard-square" onclick="window.open('generate_report.php', '_blank')">
  <div class="dashboard-icon">📄</div>
  Reports
</div>

    </div>

    <!-- Charts side by side and stacked on smaller screens -->
    <div class="chart-container">

    <div class="totalsales">
  <h3>💰 Total Sales</h3>
  <ul style="list-style:none; padding:0; margin:0; width:100%; font-size:1.1rem;">
    <li style="padding: 10px 0; border-bottom: 1px solid #f8cddc;">
      <strong>GCash:</strong> ₱<?= number_format($totalSalesByPayment['GCash'] ?? 0, 2) ?>
    </li>
    <li style="padding: 10px 0;">
      <strong>COD:</strong> ₱<?= number_format($totalSalesByPayment['COD'] ?? 0, 2) ?>
    </li>
  </ul>
</div>

      <div class="single-chart">
        <h3>📊 Orders Per Day</h3>
        <canvas id="ordersChart" width="400" height="300"></canvas>
      </div>

      <div class="single-chart">
        <h3>📊 Orders Per Month</h3>
        <canvas id="monthlyOrdersChart" width="400" height="300"></canvas>
      </div>

      <div class="single-chart">
        <h3>📊 Orders Per City (Bulacan)</h3>
        <canvas id="cityOrdersChart" width="400" height="300"></canvas>
      </div>
    </div>


  </div>


  <!-- Logout Confirmation Modal -->
<div id="logout-modal" class="modal-overlay" style="display:none;">
  <div class="modal-content">
    <h2>Confirm Logout</h2>
    <p>Are you sure you want to logout?</p>
    <div class="modal-buttons">
      <button id="confirm-logout" class="btn btn-confirm">Yes, Logout</button>
      <button id="cancel-logout" class="btn btn-cancel">Cancel</button>
    </div>
  </div>
</div>


<script>

  const logoutLink = document.getElementById('logout-link');
  const logoutModal = document.getElementById('logout-modal');
  const confirmLogoutBtn = document.getElementById('confirm-logout');
  const cancelLogoutBtn = document.getElementById('cancel-logout');

  logoutLink.addEventListener('click', function(e) {
    e.preventDefault();
    logoutModal.style.display = 'flex';
  });

  cancelLogoutBtn.addEventListener('click', function() {
    logoutModal.style.display = 'none';
  });

  confirmLogoutBtn.addEventListener('click', function() {
    // redirect to your logout page
    window.location.href = 'admin_logout.php';
  });

  // Optional: close modal if clicking outside the modal-content
  logoutModal.addEventListener('click', function(e) {
    if (e.target === logoutModal) {
      logoutModal.style.display = 'none';
    }
  });
  
  // Orders per Day Chart
  const ctx = document.getElementById('ordersChart').getContext('2d');

  const ordersChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?php echo json_encode(array_column($orderData, 'order_date')); ?>,
      datasets: [{
        label: 'Orders Per Day',
        data: <?php echo json_encode(array_column($orderData, 'total_orders')); ?>,
        backgroundColor: 'rgba(244, 154, 194, 0.2)',
        borderColor: '#e75480',
        borderWidth: 2,
        tension: 0.4,
        fill: true,
        pointBackgroundColor: '#7a294e'
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          ticks: { color: '#7a294e' }
        },
        x: {
          ticks: { color: '#7a294e' }
        }
      },
      plugins: {
        legend: { labels: { color: '#7a294e' } }
      }
    }
  });

  // Orders per Month Chart
  const ctxMonthly = document.getElementById('monthlyOrdersChart').getContext('2d');

  const monthlyOrdersChart = new Chart(ctxMonthly, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode(array_column($monthlyOrderData, 'order_month')); ?>,
      datasets: [{
        label: 'Orders Per Month',
        data: <?php echo json_encode(array_column($monthlyOrderData, 'total_orders')); ?>,
        backgroundColor: 'rgba(231, 84, 128, 0.6)',
        borderColor: '#e75480',
        borderWidth: 1,
        borderRadius: 4
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          ticks: { color: '#7a294e' }
        },
        x: {
          ticks: { color: '#7a294e' }
        }
      },
      plugins: {
        legend: { labels: { color: '#7a294e' } }
      }
    }
  });

  // Orders per City Chart
  const ctxCity = document.getElementById('cityOrdersChart').getContext('2d');

  const cityOrdersChart = new Chart(ctxCity, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode(array_column($cityOrderData, 'city')); ?>,
      datasets: [{
        label: 'Orders Per City',
        data: <?php echo json_encode(array_column($cityOrderData, 'total_orders')); ?>,
        backgroundColor: 'rgba(244, 154, 194, 0.7)',
        borderColor: '#e75480',
        borderWidth: 1,
        borderRadius: 4
      }]
    },
    options: {
      indexAxis: 'y', // horizontal bar chart
      scales: {
        x: {
          beginAtZero: true,
          ticks: { color: '#7a294e' }
        },
        y: {
          ticks: { color: '#7a294e' }
        }
      },
      plugins: {
        legend: { labels: { color: '#7a294e' } },
        tooltip: { enabled: true }
      }
    }
  });
</script>

</body>
</html>
