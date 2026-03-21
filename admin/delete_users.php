<?php
include '../config/db.php';
include '../config/auth.php';
adminOnly();

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: users.php");
exit;