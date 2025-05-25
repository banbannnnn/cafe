<?php
session_start();
include 'connect.php'; // your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get cart data from session
    $cart_data = isset($_SESSION['cart']) ? json_encode($_SESSION['cart']) : '';
    $total = $_POST['total'];  // Make sure this is securely passed from frontend
    $payment_method = $_POST['payment_method'];

    // User ID (optional — if not logged in, set to null or 0)
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    // Billing info from POST
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $company_name = htmlspecialchars($_POST['company_name']);
    $street = htmlspecialchars($_POST['street']);
    $city = htmlspecialchars($_POST['city']);
    $province = htmlspecialchars($_POST['province']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);

    // Set order status
    $status = 'Pending';

    // Insert order into database
    $stmt = $conn->prepare("INSERT INTO orders 
        (cart_data, total, payment_method, status, user_id, first_name, last_name, company_name, street, city, province, phone, email) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sdssissssssss", 
        $cart_data, $total, $payment_method, $status, $user_id, 
        $first_name, $last_name, $company_name, $street, $city, $province, $phone, $email);

    if ($stmt->execute()) {
        // Success - you can clear the cart session or redirect
        unset($_SESSION['cart']);
        echo "Order placed successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "Invalid request.";
}
?>
