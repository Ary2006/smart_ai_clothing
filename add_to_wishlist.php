<?php
include 'config/helpers.php';
session_start();

$id = (int)$_GET['id'];

if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

$_SESSION['wishlist'][$id] = true;

toast("Added to wishlist", "success");

header("Location: wishlist.php");
exit;