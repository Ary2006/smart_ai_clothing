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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart AI Clothing</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #111;
            color: #fff;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #000;
            padding: 15px 30px;
            border-bottom: 1px solid #333;
        }

        .nav-links a {
            color: #ccc;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
        }

        .nav-links a:hover {
            color: #fff;
        }

        /* The Magic AI Button Style */
        .ai-btn {
            background: linear-gradient(45deg, #6f42c1, #d63384);
            color: white !important;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
        }

        .search-container input {
            padding: 8px;
            border-radius: 5px;
            border: none;
        }

        /* Container */
        .products-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }

        /* Card */
        .product-card {
            background: #111;
            border-radius: 16px;
            overflow: hidden;
            transition: 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6);
        }

        /* Image */
        .product-image {
            display: block;
            width: 100%;
            height: 260px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Info */
        .product-info {
            padding: 15px;
        }

        .product-info h3 {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .product-info a {
            text-decoration: none;
            color: white;
        }

        .product-info a:hover {
            color: #00d4ff;
        }

        .price {
            font-size: 16px;
            font-weight: bold;
            color: #00d4ff;
        }

        .rating {
            font-size: 14px;
            color: #aaa;
        }

        body {
            background: #0d0d0d;
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            padding: 20px 40px;
        }
    </style>
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