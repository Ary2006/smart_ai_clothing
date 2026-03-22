<?php
include 'header.php';
include 'config/db.php';

$wishlist = $_SESSION['wishlist'] ?? [];
?>

<div class="container">
    <h2>❤️ Wishlist</h2>

    <div class="grid">

        <?php foreach ($wishlist as $id => $v):
            $p = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
            ?>

            <div class="card">
                <img src="uploads/products/<?= $p['image'] ?>">
                <h4><?= $p['name'] ?></h4>
                <p>₹<?= $p['price'] ?></p>
            </div>

        <?php endforeach; ?>

    </div>
</div>

<?php include 'footer.php'; ?>