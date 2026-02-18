<?php
include 'header.php';
include 'config/db.php';

if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<div class="container">
  <h2 style="margin-top:30px">🛒 Your Cart</h2>

<?php if (empty($cart)): ?>
  <div class="card" style="text-align:center;margin-top:30px">
    <p>Your cart is empty.</p>
  </div>
<?php else: ?>

  <?php foreach ($cart as $id => $qty):
    $p = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
    $sub = $p['price'] * $qty;
    $total += $sub;
  ?>

  <!-- CART ITEM -->
  <div class="card" style="display:flex;gap:20px;align-items:center;margin-bottom:15px">

    <!-- IMAGE -->
    <a href="product.php?id=<?= $p['id'] ?>">
      <img src="uploads/products/<?= $p['image'] ?>"
           style="width:120px;height:120px;object-fit:cover;border-radius:8px">
    </a>

    <!-- DETAILS -->
    <div style="flex:1">
      <h4 style="margin:0">
        <a href="product.php?id=<?= $p['id'] ?>" style="text-decoration:none;color:black">
          <?= $p['name'] ?>
        </a>
      </h4>
      <p style="margin:5px 0;color:#555">Color: <?= $p['color'] ?></p>
      <p style="margin:5px 0">Price: ₹<?= $p['price'] ?></p>
      <p style="margin:5px 0">Quantity: <?= $qty ?></p>
    </div>

    <!-- SUBTOTAL -->
    <div style="text-align:right">
      <p style="font-weight:bold">₹<?= $sub ?></p>
      <a href="remove_from_cart.php?id=<?= $p['id'] ?>" style="color:red;font-size:14px">
        Remove
      </a>
    </div>

  </div>

  <?php endforeach; ?>

  <!-- TOTAL + ACTIONS -->
  <div class="card" style="display:flex;justify-content:space-between;align-items:center;margin-top:20px">
    <h3>Total: ₹<?= $total ?></h3>
<a href="checkout.php"><button class="btn">Checkout</button></a>

    <div style="display:flex;gap:10px">
      <a href="download_bill.php">
        <button class="btn">Download Bill</button>
      </a>
    </div>
  </div>

<?php endif; ?>
</div>

<?php include 'footer.php'; ?>
