<?php
include '../config/db.php';
include '../config/auth.php';
adminOnly();
?>

<?php include '../header.php'; ?>

<div class="container" style="padding: 40px;">
    
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 30px;">
        <h2 style="margin:0;">🛠 Admin Dashboard</h2>
        
        <a href="../index.php" style="background:#444; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;">
            🏠 Go to Shop Homepage
        </a>
    </div>

    <div class="card" style="background:#222; padding:20px; border-radius:10px; margin-bottom:30px;">
        <h3 style="border-bottom:1px solid #444; padding-bottom:10px;">📦 Product Management</h3>

        <div style="display:flex; gap:10px; margin:20px 0;">
            <a href="add_product.php"><button class="btn" style="padding:10px; cursor:pointer;">➕ Add Product</button></a>
            <a href="bulk_upload.php"><button class="btn" style="padding:10px; cursor:pointer;">📄 Bulk Upload CSV</button></a>
            
            <a href="regenerate_vectors.php">
                <button class="btn" style="padding:10px; cursor:pointer; background-color: #6f42c1; color: white; border: none;">
                    🧠 Update AI
                </button>
            </a>
        </div>

        <table border="1" cellpadding="10" width="100%" style="border-collapse: collapse; border-color:#444;">
            <tr style="background:#333;">
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php
            $res = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 10");
            while ($p = $res->fetch_assoc()):
            ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><img src="../uploads/products/<?= $p['image'] ?>" style="width:50px; height:50px; object-fit:cover;"></td>
                <td><?= $p['name'] ?></td>
                <td>₹<?= $p['price'] ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $p['id'] ?>" style="color:#0d6efd;">Edit</a> | 
                    <a href="delete_product.php?id=<?= $p['id'] ?>" style="color:#dc3545;" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>