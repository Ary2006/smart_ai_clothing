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
                    $res = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 10");
                    while ($p = $res->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= $p['id'] ?></td>

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

        </div>

    </div>

</div>