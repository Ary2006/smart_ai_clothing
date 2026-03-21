<?php
include '../config/db.php';
include '../config/auth.php';
adminOnly();

$id = (int)$_GET['id'];

$stmt->execute();

$_SESSION['toast'] = [
    "message" => "User deleted successfully",
    "type" => "success"
];
header("Location: users.php");
exit;