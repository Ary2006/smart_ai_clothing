<?php
include '../config/db.php';
include '../config/auth.php';
adminOnly();

$totalProducts = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$totalUsers = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$avgPrice = $conn->query("SELECT AVG(price) as avg FROM products")->fetch_assoc()['avg'];
?>

<?php include '../header.php'; ?>

<div class="admin-layout">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="admin-main">

        <div class="admin-header">
            <h2>🛠 Admin Dashboard</h2>
        </div>

        <!-- STATS GO HERE -->
        <div class="stats-grid">

            <div class="stat-card">
                <h4>Total Products : <?= $totalProducts ?></h4>
            </div>

            <div class="stat-card">
                <h4>Total Users : <?= $totalUsers ?></h4>
            </div>

        </div>

        <div class="admin-card" id="products">

            <h3>📦 Product Management</h3>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                    $limit = 5;

                    // Current page
                    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                    if ($page < 1)
                        $page = 1;

                    $offset = ($page - 1) * $limit;

                    // Base query
                    $baseQuery = "FROM products";

                    // Total count
                    $totalRes = $conn->query("SELECT COUNT(*) as total $baseQuery");
                    $totalRow = $totalRes->fetch_assoc();
                    $totalProductsCount = $totalRow['total'];

                    $totalPages = ceil($totalProductsCount / $limit);

                    // Final data query
                    $res = $conn->query("SELECT * $baseQuery ORDER BY id ASC LIMIT $limit OFFSET $offset");

                    // Numbering
                    $i = $offset + 1;
                    while ($p = $res->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>

                            <td>
                                <img src="../uploads/products/<?= $p['image'] ?>" class="product-thumb">
                            </td>

                            <td><?= $p['name'] ?></td>

                            <td class="price">₹<?= $p['price'] ?></td>

                            <td>
                                <a href="edit_product.php?id=<?= $p['id'] ?>" class="edit-btn">Edit</a>
                                <a href="delete_product.php?id=<?= $p['id'] ?>" class="delete-btn"
                                    onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>

            <div style="margin-top:20px; text-align:center;">

                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>" class="btn">← Prev</a>
                <?php endif; ?>

                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                    <a href="?page=<?= $p ?>" style="margin:0 5px;
                        padding:6px 12px;
                        background:<?= $p == $page ? '#00d4ff' : '#222' ?>;
                        color:<?= $p == $page ? 'black' : 'white' ?>;
                        border-radius:6px;">
                        <?= $p ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>" class="btn">Next →</a>
                <?php endif; ?>

            </div>

        </div>

    </div>

</div>