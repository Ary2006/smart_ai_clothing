<?php
include 'header.php';
include 'config/db.php';

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<p style='padding:20px'>Cart is empty</p>";
    exit;
}

$total = 0;
foreach ($cart as $id => $qty) {
    $p = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
    $total += $p['price'] * $qty;
}
?>

<div class="container">
  <h2>🧾 Checkout</h2>

  <div class="checkout-box">
    <h3>Total Amount</h3>
    <p class="amount">₹<?= $total ?></p>

    <form action="place_order.php" method="post">
      <button class="checkout-btn">Pay Now</button>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>