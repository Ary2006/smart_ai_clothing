<?php
include '../config/db.php';
include '../config/auth.php';
adminOnly();

$id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$_SESSION['toast'] = "User deleted successfully";

header("Location: users.php");
exit;