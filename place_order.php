<?php
session_start();
include 'config/db.php';
include 'config/helpers.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$user_id = $_SESSION['uid'] ?? 0;

foreach ($_SESSION['cart'] as $id => $qty) {
    $conn->query("INSERT INTO orders (user_id, product_id, quantity) VALUES ($user_id, $id, $qty)");
}

unset($_SESSION['cart']);

toast("Payment Successful! Order Placed.", "success");

header("Location: orders.php");
exit;