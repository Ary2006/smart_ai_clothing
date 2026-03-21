<?php
include 'header.php';
include 'config/db.php';

$gender = $_GET['g'] ?? '';
$gender = $conn->real_escape_string($gender);
?>

<div class="container">
  <h2><?= $gender ?> Collection</h2>

  <div class="products-container">

    <?php
    $res = $conn->query("SELECT * FROM products WHERE gender='$gender'");
    while ($p = $res->fetch_assoc()):
      ?>

      <div class="product-card">

        <!-- IMAGE CLICK -->
        <a href="product.php?id=<?= $p['id'] ?>">
          <div class="product-image">
            <img src="uploads/products/<?= $p['image'] ?>">
          </div>
        </a>

        <!-- NAME CLICK -->
        <h4>
          <a href="product.php?id=<?= $p['id'] ?>" style="text-decoration:none;color:black">
            <?= $p['name'] ?>
          </a>
        </h4>

        <p>₹<?= $p['price'] ?></p>
        <p>Color: <?= $p['color'] ?></p>

      </div>

    <?php endwhile; ?>

  </div>
</div>

<?php include 'footer.php'; ?>