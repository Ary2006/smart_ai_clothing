<?php
include '../config/db.php';
include '../config/auth.php';
include '../config/helpers.php';
adminOnly();

$id = (int) $_POST['id'];
$role = $_POST['role'];

session_start();

// Prevent self-demotion
if ($_SESSION['uid'] == $id) {
    toast("You cannot change your own role.", "success");

    header("Location: users.php");
    exit;
}

// Update FIRST
$stmt = $conn->prepare("UPDATE users SET role='$role' WHERE id=$id");

// THEN toast
toast("User role updated.", "success");

header("Location: users.php");
exit;