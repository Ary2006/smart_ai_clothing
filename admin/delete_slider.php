<?php
include '../config/db.php';
include '../config/auth.php';
adminOnly();

$id = (int)$_GET['id'];
$conn->query("DELETE FROM sliders WHERE id=$id");

header("Location: dashboard.php");
exit;
