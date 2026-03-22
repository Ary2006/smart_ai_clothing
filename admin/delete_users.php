<?php
include '../config/db.php';
include '../config/auth.php';
include '../config/helpers.php';

adminOnly();

$id = (int)$_GET['id'];

$stmt->execute();

toast("User deleted successfully.", "success");

header("Location: users.php");
exit;