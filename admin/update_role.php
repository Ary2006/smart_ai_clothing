<?php
include '../config/db.php';
include '../config/auth.php';
adminOnly();

$id = (int)$_POST['id'];
$role = $_POST['role'];

session_start();

// Prevent self-demotion
if ($_SESSION['uid'] == $id) {
    $_SESSION['toast'] = "You cannot change your own role";
    header("Location: users.php");
    exit;
}

// Update FIRST
$stmt = $conn->prepare("UPDATE users SET role=? WHERE id=?");
$stmt->bind_param("si", $role, $id);
$stmt->execute();

// THEN toast
$_SESSION['toast'] = "User role updated";

header("Location: users.php");
exit;