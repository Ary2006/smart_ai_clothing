<?php
include 'header.php';
include 'config/db.php';

$q = $_GET['q'] ?? '';
$q = $conn->real_escape_string($q);
?>

<div class="container">
  <h3>Search Results for "<?= htmlspecialchars($q) ?>"</h3>

  <div class="products-container">

    <?php
    $res = $conn->query("SELECT * FROM products WHERE name LIKE '%$q%'");
    while ($p = $res->fetch_assoc()):
      ?>

      <div class="product-card">

        <a href="product.php?id=<?= $p['id'] ?>">
          <div class="product-image">
            <img src="uploads/products/<?= $p['image'] ?>">
          </div>
        </a>

        <h4>
          <a href="product.php?id=<?= $p['id'] ?>" style="text-decoration:none;color:black">
            <?= $p['name'] ?>
          </a>
        </h4>

        <p>₹<?= $p['price'] ?></p>

      </div>

    <?php endwhile; ?>

  </div>
</div>

<?php include 'footer.php'; ?>