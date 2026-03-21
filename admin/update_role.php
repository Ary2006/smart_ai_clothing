<?php
include '../config/db.php';
include '../config/auth.php';
adminOnly();

$id = (int)$_POST['id'];
$role = $_POST['role'];

// Prevent admin from removing their own access (optional safety)
session_start();
if ($_SESSION['uid'] == $id) {
    header("Location: users.php");
    exit;
}

$conn->query("UPDATE users SET role='$role' WHERE id=$id");

header("Location: users.php");
exit;