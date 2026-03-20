<?php
include '../config/db.php';
include '../config/auth.php';
adminOnly();
?>

<?php include '../header.php'; ?>

<div class="admin-layout">

    <!-- Sidebar -->
    <div class="admin-sidebar">
        <h3 class="logo">Admin</h3>

        <a href="dashboard.php" class="active">📊 Dashboard</a>
        <a href="add_product.php">➕ Add Product</a>
        <a href="bulk_upload.php">📄 Bulk Upload</a>
        <a href="regenerate_vectors.php">🧠 AI Update</a>
        <a href="../index.php">🏠 Go to Shop</a>
    </div>

    <!-- Main Content -->
    <div class="admin-main">

        <div class="admin-header">
            <h2>🛠 Admin Dashboard</h2>
        </div>

        <div class="admin-card">

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