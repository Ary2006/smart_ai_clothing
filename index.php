<?php
include 'header.php';
include 'config/db.php';
?>

<div class="container">
  <h2>Top Rated Products</h2>

  <div class="products-container">
  <?php
  $res = $conn->query("SELECT * FROM products ORDER BY rating DESC LIMIT 6");
  while ($p = $res->fetch_assoc()):
  ?>

<div class="product-card">

  <a href="product.php?id=<?= $p['id'] ?>" class="product-image">
    <img src="uploads/products/<?= $p['image'] ?>" alt="<?= $p['name'] ?>">
  </a>

  <div class="product-info">
    <h3>
      <a href="product.php?id=<?= $p['id'] ?>">
        <?= $p['name'] ?>
      </a>
    </h3>

    <p class="price">₹<?= $p['price'] ?></p>
    <p class="rating">⭐ <?= $p['rating'] ?></p>
  </div>

</div>

  <?php endwhile; ?>

  </div>
</div>

<?php include 'footer.php'; ?>
