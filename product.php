<?php
include 'header.php';
include 'config/db.php';

if (!isset($_GET['id'])) {
  echo "Invalid product";
  exit;
}

$id = (int) $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if (!$product) {
  echo "Product not found";
  exit;
}
?>

<div class="container">
  <div class="card product-detail">
    <!-- IMAGE -->
    <div style="flex:1">
      <div class="product-image">
        <img src="uploads/products/<?= $product['image'] ?>">
      </div>
    </div>

    <!-- DETAILS -->
    <div style="flex:1">
      <h2><?= $product['name'] ?></h2>
      <p><?= $product['description'] ?></p>
      <p><b>Price:</b> ₹<?= $product['price'] ?></p>
      <p><b>Color:</b> <?= $product['color'] ?></p>
      <p><b>Size:</b> <?= $product['size'] ?></p>

      <form action="add_to_cart.php" method="post">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <button class="btn">Add to Cart</button>
      </form>
    </div>

  </div>
</div>

<?php include 'footer.php'; ?>