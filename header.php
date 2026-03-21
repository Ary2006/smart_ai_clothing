<?php
// Only start session if one isn't active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// This logic ensures links work from BOTH the main folder and the admin folder
$base_url = "http://localhost/smart_ai_clothing/";
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="<?= $base_url ?>css/common.css">
    <link rel="stylesheet" href="<?= $base_url ?>css/home.css">
    <link rel="stylesheet" href="<?= $base_url ?>css/auth.css">
    <link rel="stylesheet" href="<?= $base_url ?>css/admin.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart AI Clothing</title>
</head>

<body>

    <nav class="navbar">
        <div class="logo">
            <a href="<?php echo $base_url; ?>index.php"
                style="color:white; font-size:24px; font-weight:bold; text-decoration:none;">
                Smart<span style="color:#0d6efd">AI</span>Clothing
            </a>
        </div>

        <div class="nav-links">
            <a href="<?php echo $base_url; ?>index.php">Home</a>
            <a href="<?php echo $base_url; ?>category.php?g=Men">Men</a>
            <a href="<?php echo $base_url; ?>category.php?g=Women">Women</a>

            <a href="<?php echo $base_url; ?>image_search.php" class="ai-btn">📷 AI Search</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'ADMIN'): ?>
                    <a href="<?php echo $base_url; ?>admin/dashboard.php" style="color:#ffc107;">Admin Panel</a>
                <?php endif; ?>
                <a href="<?php echo $base_url; ?>logout.php">Logout</a>
            <?php else: ?>
                <a href="<?php echo $base_url; ?>login.php">Login</a>
            <?php endif; ?>
        </div>
    </nav>

    <?php if (isset($_SESSION['toast'])):
        $toast = $_SESSION['toast'];
        $type = $toast['type'] ?? 'info';
        ?>

        <div class="toast <?= $type ?>" id="toast">
            <span class="toast-icon">
                <?php
                if ($type == 'success') {
                    echo "✔";
                } elseif ($type == 'error') {
                    echo "✖";
                } elseif ($type == 'warning') {
                    echo "⚠";
                } else {
                    echo "ℹ";
                }
                ?>
            </span>

            <span class="toast-message">
                <?= $toast['message']; ?>
            </span>
        </div>

        <?php unset($_SESSION['toast']); endif; ?>
</body>