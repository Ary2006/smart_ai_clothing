<?php
include 'config/db.php';

if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}

$cart = $_SESSION['cart'];
$user_id = $_SESSION['uid'];
$total = 0;

// Calculate total
foreach ($cart as $pid => $qty) {
    $p = $conn->query("SELECT price FROM products WHERE id=$pid")->fetch_assoc();
    $total += $p['price'] * $qty;
}

// Insert order
$conn->query("INSERT INTO orders (user_id, total_amount) VALUES ($user_id, $total)");
$order_id = $conn->insert_id;

// Insert order items
foreach ($cart as $pid => $qty) {
    $p = $conn->query("SELECT price FROM products WHERE id=$pid")->fetch_assoc();
    $price = $p['price'];

    $conn->query("
      INSERT INTO order_items (order_id, product_id, price, quantity)
      VALUES ($order_id, $pid, $price, $qty)
    ");
}

// Clear cart
unset($_SESSION['cart']);

header("Location: orders.php");
exit;
