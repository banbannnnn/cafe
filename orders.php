<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user orders
$query = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Orders - Blissful Bites</title>
  <link rel="icon" href="logo1.png" type="image/png">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
       background: #fff0ee;
      padding: 2rem;
      color: #3e3e3e;
    }
    h1 {
      color: #a35c6f;
      text-align: center;
      margin-bottom: 2rem;
    }
    .order-container {
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
      margin-bottom: 2rem;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }
    .order-header {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      margin-bottom: 1rem;
    }
    .order-header > div {
      margin-bottom: 0.5rem;
    }
    .status {
      font-weight: bold;
      padding: 6px 14px;
      border-radius: 20px;
      background-color: #f0d7dd;
      color: #a35c6f;
      text-transform: capitalize;
      white-space: nowrap;
    }
    .status.Pending { background-color: #fff3cd; color: #856404; }
    .status.Completed { background-color: #d4edda; color: #155724; }
    .status.Cancelled { background-color: #f8d7da; color: #721c24; }

    .order-details {
      margin-bottom: 1rem;
      line-height: 1.5;
    }

    .order-items {
      padding-left: 1rem;
    }
    .order-items ul {
      list-style-type: square;
      margin: 0;
      padding-left: 1.5rem;
    }
    .order-items li {
      margin-bottom: 0.5rem;
    }

    /* Address styling */
    .address {
      background-color: #f7e5e3;
      border-radius: 8px;
      padding: 1rem 1.5rem;
      margin-top: 1rem;
      font-size: 0.95rem;
      color: #5a3a3f;
      max-width: 400px;
    }

    .back-home {
  background-color: #a35c6f;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 10px;
  font-weight: 600;
  font-family: 'Montserrat', sans-serif;
  cursor: pointer;
  box-shadow: 0 4px 8px rgba(163, 92, 111, 0.4);
  transition: background-color 0.3s ease;
  margin: 0 auto 2rem auto;  /* Center horizontally + margin bottom */
  display: block;            /* Makes margin auto work */
  width: max-content;        /* Button width fits content */
}


    /* Responsive */
    @media (max-width: 600px) {
      .order-header {
        flex-direction: column;
      }
      .order-container {
        padding: 1rem;
      }
      .address {
        max-width: 100%;
      }
    }
  </style>
</head>
<body>
  <h1>My Orders</h1>

  <button class="back-home" onclick="window.location.href='home.php'">← Back to Home</button>

  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="order-container">
        <div class="order-header">
          <div>
            <strong>Order ID:</strong> <?= htmlspecialchars($row['id']) ?><br>
            <strong>Date:</strong> <?= date("F j, Y, g:i a", strtotime($row['created_at'])) ?>
          </div>
          <div class="status <?= htmlspecialchars($row['status']) ?>">
            <?= htmlspecialchars(ucfirst($row['status'])) ?>
          </div>
        </div>

        <div class="order-details">
          <strong>Total:</strong> ₱<?= number_format($row['total'], 2) ?><br>
          <strong>Payment Method:</strong> <?= htmlspecialchars($row['payment_method']) ?>
        </div>

        <div class="order-items">
          <strong>Items:</strong>
          <ul>
            <?php
              $items = json_decode($row['cart_data'], true);
              if ($items && is_array($items)) {
                  foreach ($items as $item) {
                      echo "<li>" . htmlspecialchars($item['name']) . " × " . intval($item['quantity']) . "</li>";
                  }
              } else {
                  echo "<li>No items found</li>";
              }
            ?>
          </ul>
        </div>

        <div class="address">
          <strong>Billing Address:</strong><br>
          <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?><br>
          <?php if (!empty($row['company_name'])): ?>
            <?= htmlspecialchars($row['company_name']) ?><br>
          <?php endif; ?>
          <?= htmlspecialchars($row['street']) ?><br>
          <?= htmlspecialchars($row['city'] . ', ' . $row['province']) ?><br>
          <strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?><br>
          <strong>Email:</strong> <?= htmlspecialchars($row['email']) ?>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="text-align:center; color:#a35c6f;">You haven't placed any orders yet.</p>
  <?php endif; ?>

</body>
</html>
