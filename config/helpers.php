<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function toast($msg, $type = 'info') {
    $_SESSION['toast'] = [
        'message' => $msg,
        'type' => $type
    ];
}