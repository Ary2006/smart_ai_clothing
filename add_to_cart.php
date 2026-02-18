<?php
include 'config/db.php';

if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}

$id = (int)$_POST['product_id'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]++;
} else {
    $_SESSION['cart'][$id] = 1;
}

header("Location: cart.php");
exit;
