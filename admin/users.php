<?php
include '../config/db.php';
include '../config/auth.php';
adminOnly();
?>

<?php include '../header.php'; ?>

<div class="admin-layout">

    <div class="admin-sidebar">
        <h3 class="logo">Admin</h3>

        <a href="dashboard.php">📊 Dashboard</a>
        <a href="add_product.php">➕ Add Product</a>
        <a href="bulk_upload.php">📄 Bulk Upload</a>
        <a href="regenerate_vectors.php">🧠 AI Update</a>
        <a href="users.php" class="active">👤 Users</a>
        <a href="../index.php">🏠 Go to Shop</a>
    </div>

    <div class="admin-main">

        <div class="admin-header">
            <h2>👤 Users</h2>
        </div>

        <div class="admin-card">

            <form method="GET" style="margin-bottom:15px;">
                <input type="text" name="search" placeholder="Search users..."
                    value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>"
                    style="padding:8px; width:250px; border-radius:6px; border:none;">

                <button class="action-btn">Search</button>
            </form>

            <?php

            $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

            // Pagination
            $limit = 5;
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
            $offset = ($page - 1) * $limit;

            // Query
            $sql = "SELECT * FROM users";

            if ($search) {
                $sql .= " WHERE name LIKE '%$search%' OR email LIKE '%$search%'";
            }

            $sql .= " ORDER BY id DESC LIMIT $limit OFFSET $offset";

            $res = $conn->query($sql);

            ?>

            <table class="admin-table">
                <thead>
                    <th>Actions</th>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($u = $res->fetch_assoc()): ?>
                        <tr>
                            <td><?= $u['id'] ?></td>
                            <td><?= $u['name'] ?></td>
                            <td><?= $u['email'] ?></td>
                            <td><?= $u['role'] ?></td>
                            <td>
                                <a href="delete_user.php?id=<?= $u['id'] ?>" class="delete-btn"
                                    onclick="return confirm('Delete this user?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>

            <div style="margin-top:15px;">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>&search=<?= $search ?>" class="action-btn">Prev</a>
                <?php endif; ?>

                <a href="?page=<?= $page + 1 ?>&search=<?= $search ?>" class="action-btn">Next</a>
            </div>

        </div>

    </div>

</div>

<?php include '../footer.php'; ?>