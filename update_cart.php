<?php
session_start();

$id = (int)$_POST['id'];
$qty = (int)$_POST['qty'];

if ($qty <= 0) {
    unset($_SESSION['cart'][$id]);
} else {
    $_SESSION['cart'][$id] = $qty;
}

header("Location: cart.php");
exit;