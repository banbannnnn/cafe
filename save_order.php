<?php
session_start();
include 'connect.php';

// Read raw POST data (JSON)
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

// Validate required fields
$required = ['cart', 'total', 'payment_method', 'first_name', 'last_name', 'street', 'city', 'province', 'phone', 'email'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        echo json_encode(['success' => false, 'message' => "Missing $field"]);
        exit;
    }
}

// Prepare variables
$cart = $data['cart'];
$total = $data['total'];
$payment_method = $data['payment_method'];
$first_name = $data['first_name'];
$last_name = $data['last_name'];
$company_name = $data['company_name'] ?? '';
$street = $data['street'];
$city = $data['city'];
$province = $data['province'];
$phone = $data['phone'];
$email = $data['email'];

// Convert cart array to JSON string for DB storage
$cart_json = json_encode($cart);

// Insert order into DB
$stmt = $connection->prepare("INSERT INTO orders (cart, total, payment_method, first_name, last_name, company_name, street, city, province, phone, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sdsssssssss", $cart_json, $total, $payment_method, $first_name, $last_name, $company_name, $street, $city, $province, $phone, $email);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();
$connection->close();
?>
