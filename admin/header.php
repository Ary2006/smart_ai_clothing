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

