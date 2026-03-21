<?php
include '../config/db.php';
include '../config/auth.php';
adminOnly();

$id = $_GET['id'];

$conn->query("DELETE FROM users WHERE id=$id");

header("Location: users.php");
exit;