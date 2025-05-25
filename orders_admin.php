<?php
include 'connect.php';
session_start();

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['new_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['success_message'] = "✅ Order status updated successfully!";
    
    header("Location: orders_admin.php");
    exit();
}

$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
if (!empty($statusFilter)) {
    $stmt = $conn->prepare("SELECT * FROM orders WHERE status = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $statusFilter);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    $query = "SELECT * FROM orders ORDER BY created_at DESC";
    $result = $conn->query($query);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Blissful Bites Admin - Order Management</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
<style>
  /* === Sidebar & Topbar styles from Users page === */
  * {
    box-sizing: border-box;
    margin: 0; padding: 0;
  }
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #fffefe;
    color:  #7a294e;
  }

   /* Sidebar */
    .sidebar {
      position: fixed;
      left: 0; top: 0; bottom: 0;
      width: 230px;
      background: #f8cddc; /* soft pink */
      color: #7a294e;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 30px;
      box-shadow: 2px 0 8px rgba(0,0,0,0.05);
    }

    .sidebar h2 {
      color: #7a294e;
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
    }

    .sidebar a:hover,
    .sidebar a.active {
      background: #f49ac2; /* mid pink */
      border-left: 5px solid #e75480;
      color: white;
    }

    /* Topbar */
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
    }

    /* Main content */
    .main-content {
      margin-left: 230px;
      padding: 40px 30px;
    }

  h1 {
    color: #d24280;
    margin-bottom: 30px;
  }

  /* Table styles */
  table {
    width: 100%;
    border-collapse: collapse;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }
  th, td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
    font-size: 14px;
  }
  th {
    background-color: #d24280;
    color: #fff;
  }
  tr:nth-child(even) {
    background-color: #f9f4f7;
  }
  tr:hover {
    background-color: #f1e7ef;
  }

  /* Notification styles */
  .notification {
    max-width: 600px;
    margin: 20px auto;
    padding: 15px 25px;
    border-radius: 8px;
    font-size: 14px;
    text-align: center;
  }
  .notification.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
  }
  .notification.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
  }

  /* Status badge styles */
  .status-pending {
    background-color: #fce8b2;
    color: #856404;
    padding: 4px 8px;
    border-radius: 15px;
    font-weight: 600;
  }
  .status-processing {
    background-color: #d1ecf1;
    color: #0c5460;
    padding: 4px 8px;
    border-radius: 15px;
    font-weight: 600;
  }
  .status-ontheway {
    background-color: #d4edda;
    color: #155724;
    padding: 4px 8px;
    border-radius: 15px;
    font-weight: 600;
  }
  .status-delivered {
    background-color: #c3e6cb;
    color: #155724;
    padding: 4px 8px;
    border-radius: 15px;
    font-weight: 600;
  }

  /* Status update form */
  form.status-update-form {
    display: inline-block;
  }
  select.status-select {
    padding: 6px 12px;
    border-radius: 20px;
    border: 1px solid #ccc;
    font-size: 14px;
    cursor: pointer;
  }
  button.update-btn {
    background-color: #d24280;
    border: none;
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    cursor: pointer;
    font-weight: 600;
    margin-left: 6px;
    transition: background-color 0.3s ease;
  }
  button.update-btn:hover {
    background-color: #da326d;
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
</style>
</head>
<body>

  <div class="sidebar">
    <h2>Blissful Bites</h2>
    <a href="admin.php">Dashboard</a>
    <a href="users.php">Users</a>
    <a href="orders_admin.php" class="active">Orders</a>
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
    <br/>
    <br/>
    <a href="admin_logout.php" id="logout-link">Logout</a>
  </div>

  <div class="topbar">
    <div></div>
    <div>Welcome, Admin 👤</div>
  </div>

  <div class="main-content">
    <h1>Blissful Bites Admin - Orders Management</h1>

    <?php if (isset($_SESSION['success_message'])): ?>
      <div class="notification success">
        <?= htmlspecialchars($_SESSION['success_message']) ?>
      </div>
      <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>


    <form method="get" style="margin-bottom: 20px;">
  <label for="status">Filter by Status:</label>
  <select name="status" id="status" onchange="this.form.submit()">
    <option value="">All</option>
    <option value="Pending" <?= isset($_GET['status']) && $_GET['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
    <option value="Processing" <?= isset($_GET['status']) && $_GET['status'] == 'Processing' ? 'selected' : '' ?>>Processing</option>
    <option value="On the way" <?= isset($_GET['status']) && $_GET['status'] == 'On the way' ? 'selected' : '' ?>>On the way</option>
    <option value="Delivered" <?= isset($_GET['status']) && $_GET['status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
  </select>
</form>


<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Customer</th>
      <th>Items</th>
      <th>Total (₱)</th>
      <th>Payment</th>
      <th>Status</th>
      <th>Date</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Address</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()) : ?>
      <tr class="status-<?= strtolower(str_replace(' ', '', $row['status'])) ?>" data-status="<?= htmlspecialchars($row['status']) ?>">
        <td data-label="ID"><?= $row['id'] ?></td>
        <td data-label="Customer"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
        <td data-label="Items"><?= htmlspecialchars($row['cart_data']) ?></td>
        <td data-label="Total"><?= number_format($row['total'], 2) ?></td>
        <td data-label="Payment"><?= htmlspecialchars($row['payment_method']) ?></td>
        <td data-label="Status">
          <form method="post" class="status-form">
            <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
            <select name="new_status" class="status-select" onchange="updateSelectColor(this)">
                <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Processing" <?= $row['status'] == 'Processing' ? 'selected' : '' ?>>Processing</option>
                <option value="On the way" <?= $row['status'] == 'On the way' ? 'selected' : '' ?>>On the way</option>
                <option value="Delivered" <?= $row['status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
            </select>
            <button type="submit">Update</button>
          </form>
        </td>
        <td data-label="Date"><?= date("Y-m-d H:i", strtotime($row['created_at'])) ?></td>
        <td data-label="Email"><?= htmlspecialchars($row['email']) ?></td>
        <td data-label="Phone"><?= htmlspecialchars($row['phone']) ?></td>
        <td data-label="Address"><?= htmlspecialchars($row['street']) ?>, <?= htmlspecialchars($row['city']) ?>, <?= htmlspecialchars($row['province']) ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
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
function filterStatus() {
  const selected = document.getElementById("statusFilter").value;
  const rows = document.querySelectorAll("#ordersTable tbody tr");

  rows.forEach(row => {
    const status = row.getAttribute("data-status");
    row.style.display = (selected === "All" || status === selected) ? "" : "none";
  });
}

function updateSelectColor(select) {
  select.classList.remove('status-pending', 'status-processing', 'status-ontheway', 'status-delivered');

  switch (select.value) {
    case 'Pending':
      select.classList.add('status-pending');
      break;
    case 'Processing':
      select.classList.add('status-processing');
      break;
    case 'On the way':
      select.classList.add('status-ontheway');
      break;
    case 'Delivered':
      select.classList.add('status-delivered');
      break;
  }
}

// Initialize colors on page load
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.status-select').forEach(select => {
    updateSelectColor(select);
  });
});

 // Auto-hide notification after 3 seconds
  window.addEventListener('DOMContentLoaded', () => {
    const notification = document.getElementById('notification');
    if (notification) {
      setTimeout(() => {
        notification.style.display = 'none';
      }, 3000); // 3 seconds
    }
  });
</script>

</body>
</html>
