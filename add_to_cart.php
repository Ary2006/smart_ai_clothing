<?php
include 'config/helpers.php';
session_start();

$id = (int)$_POST['product_id'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]++;
} else {
    $_SESSION['cart'][$id] = 1;
}

toast("Added to cart", "success");

header("Location: cart.php");
exit;