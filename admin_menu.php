<?php
// Enable detailed error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$xmlFile = 'menu.xml';

// Load XML file
if (!file_exists($xmlFile)) {
    die("XML file not found.");
}

$xml = simplexml_load_file($xmlFile);
if (!$xml) {
    die("Failed to load XML file. Check if it's well-formed.");
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        // Add new product
        if (
    isset($_FILES['image'], $_POST['name'], $_POST['type'], $_POST['price']) &&
    $_FILES['image']['error'] === UPLOAD_ERR_OK &&
    $_POST['name'] !== '' && $_POST['type'] !== '' && $_POST['price'] !== ''
) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // create upload directory if it doesn't exist
    }

    $imageName = basename($_FILES['image']['name']);
    $targetFile = $uploadDir . $imageName;

    // Move uploaded file
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $newPastry = $xml->addChild('pastry');
        $newPastry->addChild('image', htmlspecialchars($targetFile)); // save path instead of filename
        $newPastry->addChild('name', htmlspecialchars($_POST['name']));
        $newPastry->addChild('type', htmlspecialchars($_POST['type']));
        $newPastry->addChild('price', htmlspecialchars($_POST['price']));

        $xml->asXML($xmlFile);
        echo "<p style='color:green; text-align:center;'>New product added successfully.</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>Failed to upload image.</p>";
    }
} else {
    echo "<p style='color:red; text-align:center;'>Please fill in all fields and upload an image.</p>";
}
    } else {
        if (!isset($_POST['index'])) {
            die("Missing index.");
        }

        $index = (int)$_POST['index'];

        if (!isset($xml->pastry[$index])) {
            die("Invalid index: $index");
        }

        if (isset($_POST['update'])) {
            // Update product
            if (isset($_POST['image'], $_POST['name'], $_POST['type'], $_POST['price'])) {
                $xml->pastry[$index]->image = htmlspecialchars($_POST['image']);
                $xml->pastry[$index]->name = htmlspecialchars($_POST['name']);
                $xml->pastry[$index]->type = htmlspecialchars($_POST['type']);
                $xml->pastry[$index]->price = htmlspecialchars($_POST['price']);

                $xml->asXML($xmlFile);
                echo "<p style='color:green; text-align:center;'>Product updated successfully.</p>";
            } else {
                die("Missing one or more fields.");
            }
        } 
        
        elseif (isset($_POST['delete'])) {
            // Delete product
            unset($xml->pastry[$index]);
            $xml->asXML($xmlFile);
            echo "<p style='color:red; text-align:center;'>Product deleted successfully.</p>";
        }
    }

    // Reload XML after changes
    $xml = simplexml_load_file($xmlFile);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Blissful Bites Admin - Menu Management</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
<style>
  /* === Sidebar & Topbar styles from users.php === */
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
  }
  th {
    background-color: #d24280;
    color: #fff;
  }
  tr:nth-child(even) {
    background-color: #f9f4f7;
  }

  /* Buttons */
  button {
    background-color: #d24280;
    border: none;
    color: #fff;
    padding: 8px 14px;
    border-radius: 20px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.3s ease;
    margin-right: 5px;
  }
  button:hover {
    background-color: #da326d;
  }

  /* Inputs */
  input[type=text], input[type=number] {
    width: 100%;
    padding: 6px 8px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-family: inherit;
    font-size: 1rem;
    box-sizing: border-box;
  }

  /* Add product form styles */
  .add-product-form {
    margin-top: 40px;
    padding: 20px;
    background: #fff0f5;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(210, 66, 128, 0.1);
    max-width: 800px;
  }
  .add-product-form h2 {
    color: #d24280;
    margin-bottom: 20px;
  }
  .add-product-form .form-row {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
  }
  .add-product-form .form-row > div {
    flex: 1;
  }
  .add-product-form button {
    margin-top: 10px;
    width: 100%;
  }

  select {
  width: 100%;
  padding: 6px 8px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-family: inherit;
  font-size: 1rem;
  box-sizing: border-box;
  background-color: white;
  color: #7a294e;
}

</style>
</head>
<body>

<div class="sidebar">
  <h2>Blissful Bites</h2>
  <a href="admin.php">Dashboard</a>
  <a href="users.php">Users</a>
  <a href="orders_admin.php">Orders</a>
  <a href="admin_menu.php" class="active">Products</a>
  <a href="generate_report.php">Report</a>
  <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
  <a href="admin_logout.php" id="logout-link">Logout</a>
</div>

<div class="topbar">
    <div></div>
    <div>Welcome, Admin 👤</div>
  </div>

<div class="main-content">
  <h1>Manage Menu Products</h1>

  <table>

  <div class="add-product-form">
    <h2>Add New Product</h2>
    <form method="post" action="admin_menu.php" enctype="multipart/form-data">
      <div class="form-row">
        <div>
          <label for="image">Upload Image</label>
          <input type="file" id="image" name="image" accept="image/*" required>
        </div>
        <div>
          <label for="name">Name</label>
          <input type="text" id="name" name="name" placeholder="Product name" required>
        </div>
      </div>
      <div class="form-row">
        <div>
          <label for="type">Type</label>
          <select id="type" name="type" required>
  <option value="">-- Select Type --</option>
  <option value="BAKED GOODS">BAKED GOODS</option>
  <option value="CAKES">CAKES</option>
  <option value="COOKIES & BARS">COOKIES & BARS</option>
  <option value="PIES & WAFFLES">PIES & WAFFLES</option>
  <option value="DOUGHNUTS">DOUGHNUTS</option>
  <option value="PASTA">PASTA</option>
  <option value="MAINS">MAINS</option>
  <option value="DRINKS">DRINKS</option>
</select>
        </div>
        <div>
          <label for="price">Price</label>
          <input type="number" id="price" name="price" step="0.01" min="0" placeholder="0.00" required>
        </div>
      </div>
      <button type="submit" name="add">Add Product</button>
    </form>
  </div>
</div>


<br/>
<br/>
<br/>

    <thead>
      <tr>
    <th>Image</th>
    <th>Name</th>
    <th>Type</th>
    <th>Price</th>
    <th>Actions</th>
  </tr>
  <?php foreach ($xml->pastry as $i => $item): ?>
  <tr>
    <form method="post" action="admin_menu.php">
      <td><input type="text" name="image" value="<?= htmlspecialchars($item->image) ?>" required></td>
      <td><input type="text" name="name" value="<?= htmlspecialchars($item->name) ?>" required></td>
      <td>
        <select name="type" required>
          <option value="BAKED GOODS" <?= $item->type == "BAKED GOODS" ? "selected" : "" ?>>BAKED GOODS</option>
          <option value="CAKES" <?= $item->type == "CAKES" ? "selected" : "" ?>>CAKES</option>
          <option value="COOKIES & BARS" <?= $item->type == "COOKIES & BARS" ? "selected" : "" ?>>COOKIES & BARS</option>
          <option value="PIES & WAFFLES" <?= $item->type == "PIES & WAFFLES" ? "selected" : "" ?>>PIES & WAFFLES</option>
          <option value="DOUGHNUTS" <?= $item->type == "DOUGHNUTS" ? "selected" : "" ?>>DOUGHNUTS</option>
          <option value="PASTA" <?= $item->type == "PASTA" ? "selected" : "" ?>>PASTA</option>
          <option value="MAINS" <?= $item->type == "MAINS" ? "selected" : "" ?>>MAINS</option>
          <option value="DRINKS" <?= $item->type == "DRINKS" ? "selected" : "" ?>>DRINKS</option>
        </select>
      </td>
      <td><input type="number" name="price" value="<?= htmlspecialchars($item->price) ?>" step="0.01" min="0" required></td>
      <td>
        <input type="hidden" name="index" value="<?= $i ?>">
        <button type="submit" name="update">Update</button>
        <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
      </td>
    </form>
  </tr>
  <?php endforeach; ?>

    </tbody>
  </table>
</body>
</html>
