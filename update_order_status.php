<?php
include 'connect.php';
session_start();

// Check if admin is logged in (optional security)
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];

    $valid_statuses = ['Pending', 'Preparing', 'On the Way to Deliver', 'Delivered'];
    if (!in_array($status, $valid_statuses)) {
        die("Invalid status selected.");
    }

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: orders_admin.php");
exit();
?>
