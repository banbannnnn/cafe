<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "Unauthorized";
    exit();
}

$user_id = $_SESSION['user_id'];

$cart_data = $_POST['cart_data'] ?? '';
$total = $_POST['total'] ?? 0;
$payment_method = $_POST['payment_method'] ?? 'Unknown';

// Sanitize and get the inputs
$company = $_POST['company_name'] ?? '';
$street = $_POST['street'] ?? '';
$city = $_POST['city'] ?? '';

// Update the user's billing info
$update = $conn->prepare("UPDATE users SET company_name = ?, street = ?, city = ? WHERE id = ?");
$update->bind_param("sssi", $company, $street, $city, $userId);
$update->execute();

// Get user info again to insert full billing info into orders table
$query = "SELECT first_name, last_name, company_name, province, phone, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}

$first_name = $user['first_name'];
$last_name = $user['last_name'];
$company_name = $user['company_name'];
$province = $user['province'];
$phone = $user['phone'];
$email = $user['email'];
$status = 'Pending';

// Insert order
$orderSql = "INSERT INTO orders 
(cart_data, total, payment_method, created_at, status, user_id, first_name, last_name, company_name, street, city, province, phone, email) 
VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($orderSql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param(
    "sdsssssssssss",
    $cart_data,
    $total,
    $payment_method,
    $status,
    $user_id,
    $first_name,
    $last_name,
    $company_name,
    $street,
    $city,
    $province,
    $phone,
    $email
);

if ($stmt->execute()) {
    // Redirect to home page
    header("Location: home.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
