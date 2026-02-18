<?php
include 'header.php';
include 'config/db.php';
?>

<div class="container">
  <h2>Top Rated Products</h2>

  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px">

  <?php
  $res = $conn->query("SELECT * FROM products ORDER BY rating DESC LIMIT 6");
  while ($p = $res->fetch_assoc()):
  ?>

    <div class="card">

      <!-- CLICKABLE IMAGE -->
      <a href="product.php?id=<?= $p['id'] ?>">
        <img 
          src="uploads/products/<?= $p['image'] ?>" 
          style="width:100%;height:200px;object-fit:cover"
        >
      </a>

      <!-- CLICKABLE NAME -->
      <h4>
        <a href="product.php?id=<?= $p['id'] ?>" style="text-decoration:none;color:black">
          <?= $p['name'] ?>
        </a>
      </h4>

      <p>₹<?= $p['price'] ?></p>
      <p><?= $p['rating'] ?></p>

    </div>

  <?php endwhile; ?>

  </div>
</div>

<?php include 'footer.php'; ?>
