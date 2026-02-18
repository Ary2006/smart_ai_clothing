<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../config/config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/common.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
</head>
<body>

<div class="admin-navbar">
    <a href="dashboard.php">Dashboard</a>

    <!-- PUBLIC SITE PREVIEW -->
    <a href="<?= BASE_URL ?>index.php">Home</a>
    <a href="<?= BASE_URL ?>men.php">Men</a>
    <a href="<?= BASE_URL ?>women.php">Women</a>
    <a href="<?= BASE_URL ?>kids.php">Kids</a>
    <a href="<?= BASE_URL ?>offers.php">Offers</a>

    <!-- OPTIONAL (REMOVE IF NOT NEEDED) -->
    <a href="<?= BASE_URL ?>about.php">About</a>

    <!-- DO NOT SHOW THESE TO ADMIN -->
    <!-- cart, profile, search should be hidden -->

    <a href="<?= BASE_URL ?>logout.php">Logout</a>
</div>
