<?php
include 'header.php';
include 'config/db.php';

$cart = $_SESSION['cart'] ?? [];

$total = 0;
?>

<div class="container">
  <h2 style="margin:30px 0;">🛒 Your Cart</h2>

  <?php if (empty($cart)): ?>
    <p>Your cart is empty</p>
  <?php else: ?>

    <div class="cart-layout">

      <!-- ITEMS -->
      <div class="cart-items">

        <?php foreach ($cart as $id => $qty):

          $product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
          $subtotal = $product['price'] * $qty;
          $total += $subtotal;
          ?>

          <div class="cart-item">

            <div class="cart-img-box">
              <img src="uploads/products/<?= $product['image'] ?>">
            </div>

            <div class="cart-info">
              <h4><?= $product['name'] ?></h4>
              <p>₹<?= $product['price'] ?></p>
            </div>

            <div class="cart-qty">
              <form action="update_cart.php" method="post">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="number" name="qty" value="<?= $qty ?>" min="1">
                <button>Update</button>
              </form>
            </div>

            <div class="cart-subtotal">
              ₹<?= $subtotal ?>
            </div>

            <a href="remove_cart.php?id=<?= $id ?>" class="remove-btn">✖</a>

          </div>

        <?php endforeach; ?>

      </div>

      <!-- SUMMARY -->
      <div class="cart-summary">

        <h3>Order Summary</h3>

        <p>Total: <b>₹<?= $total ?></b></p>

        <button class="checkout-btn">Proceed to Checkout</button>

      </div>

    </div>

  <?php endif; ?>

</div>

<?php include 'footer.php'; ?>