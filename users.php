<?php
session_start();
include 'connect.php';

$notification = "";
$notificationType = "";

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user_id']) && isset($_POST['admin_password'])) {
    $adminPassword = trim($_POST['admin_password']);
    $userIdToDelete = intval($_POST['delete_user_id']);

    if ($adminPassword === 'admin1234') {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userIdToDelete);
        if ($stmt->execute()) {
            $notification = "✅ User deleted successfully.";
            $notificationType = "success";
        } else {
            $notification = "❌ Error deleting user: " . $stmt->error;
            $notificationType = "error";
        }
        $stmt->close();
    } else {
        $notification = "❌ Incorrect admin password.";
        $notificationType = "error";
    }
}

// Fetch all users
$result = $conn->query("SELECT id, first_name, last_name, email, company_name, city, province, phone FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Blissful Bites Admin - User Management</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
<style>
  /* === Sidebar & Topbar styles from dashboard === */
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

  table {
    width: 100%;
    border-collapse: collapse;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }
  th, td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
  }
  th {
    background-color: #d24280;
    color: #fff;
  }
  tr:nth-child(even) {
    background-color: #f9f4f7;
  }
  button.delete-btn {
    background-color: #d24280;
    border: none;
    color: #fff;
    padding: 8px 14px;
    border-radius: 20px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.3s ease;
  }
  button.delete-btn:hover {
    background-color: #da326d;
  }
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

  /* Modal overlay background */
.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(253, 231, 241, 0.8); 
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

<script>
document.addEventListener('DOMContentLoaded', function() {
  const deleteModal = document.getElementById('delete-modal');
  const deleteUserName = document.getElementById('delete-user-name');
  const deleteUserIdInput = document.getElementById('delete_user_id');
  const cancelDeleteBtn = document.getElementById('cancel-delete');

  window.confirmDelete = function(userId, userName) {
    // Safely escape quotes in userName for display
    deleteUserName.textContent = `Are you sure you want to delete user: ${userName}?`;
    deleteUserIdInput.value = userId;
    document.getElementById('admin_password').value = '';  // clear previous password
    deleteModal.style.display = 'flex';
  };

  if (cancelDeleteBtn) {
    cancelDeleteBtn.addEventListener('click', function() {
      deleteModal.style.display = 'none';
    });
  }

  if (deleteModal) {
    // Close modal if clicking outside the modal-content
    deleteModal.addEventListener('click', function(e) {
      if (e.target === deleteModal) {
        deleteModal.style.display = 'none';
      }
    });
  }

  const logoutLink = document.getElementById('logout-link');
  const logoutModal = document.getElementById('logout-modal');
  const confirmLogoutBtn = document.getElementById('confirm-logout');
  const cancelLogoutBtn = document.getElementById('cancel-logout');

  if (logoutLink && logoutModal && confirmLogoutBtn && cancelLogoutBtn) {
    logoutLink.addEventListener('click', function(e) {
      e.preventDefault();
      logoutModal.style.display = 'flex';
    });

    cancelLogoutBtn.addEventListener('click', function() {
      logoutModal.style.display = 'none';
    });

    confirmLogoutBtn.addEventListener('click', function() {
      window.location.href = 'admin_logout.php';
    });

    logoutModal.addEventListener('click', function(e) {
      if (e.target === logoutModal) {
        logoutModal.style.display = 'none';
      }
    });
  }
});
</script>
</head>
<body>

   <div class="sidebar">
    <h2>Blissful Bites</h2>
    <a href="admin.php">Dashboard</a>
    <a href="users.php" class="active">Users</a>
    <a href="orders_admin.php">Orders</a>
    <a href="admin_menu.php">Products</a>
    <a href="generate_report.php">Report</a>
    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
    <a href="admin_logout.php" id="logout-link">Logout</a>
  </div>

  <div class="topbar">
    <div></div>
    <div>Welcome, Admin 👤</div>
  </div>

  <div class="main-content">
    <h1>Blissful Bites Admin - Registered Users</h1>

    <?php if ($notification): ?>
      <div class="notification <?= htmlspecialchars($notificationType, ENT_QUOTES) ?>">
        <?= htmlspecialchars($notification) ?>
      </div>
    <?php endif; ?>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Company</th>
          <th>City</th>
          <th>Province</th>
          <th>Phone</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($user = $result->fetch_assoc()): ?>
            <?php
              $fullName = htmlspecialchars($user['first_name'] . ' ' . $user['last_name'], ENT_QUOTES);
            ?>
            <tr>
              <td><?= $user['id'] ?></td>
              <td><?= $fullName ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td><?= htmlspecialchars($user['company_name']) ?></td>
              <td><?= htmlspecialchars($user['city']) ?></td>
              <td><?= htmlspecialchars($user['province']) ?></td>
              <td><?= htmlspecialchars($user['phone']) ?></td>
              <td>
                <button class="delete-btn" 
                        onclick="confirmDelete(<?= $user['id'] ?>, '<?= $fullName ?>')">Delete</button>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="8" style="text-align:center;">No users found.</td></tr>
        <?php endif; ?>
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

<!-- Delete confirmation modal -->
<div id="delete-modal" class="modal-overlay" style="display:none;">
  <div class="modal-content">
    <h2>Confirm Delete User</h2>
    <p id="delete-user-name"></p>
    <form id="delete-form" method="POST" action="">
      <input type="hidden" name="delete_user_id" id="delete_user_id" />
      <label for="admin_password">Enter Admin Password:</label>
      <input type="password" id="admin_password" name="admin_password" required
             style="width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 15px; border-radius: 8px; border: 1px solid #7a294e; font-size: 1rem;"/>
      <div class="modal-buttons">
        <button type="submit" class="btn btn-confirm">Delete</button>
        <button type="button" id="cancel-delete" class="btn btn-cancel">Cancel</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
