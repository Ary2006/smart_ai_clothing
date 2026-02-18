<?php
function adminOnly() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'ADMIN') {
        header("Location: ../login.php");
        exit;
    }
}
