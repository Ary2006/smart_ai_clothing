<?php
include 'header.php';
include 'config/db.php';

if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    echo "<p style='text-align:center'>Cart is empty</p>";
    exit;
}

$total = 0;
?>

<div class="container">
<h2>🧾 Checkout</h2>

<table border="1" cellpadding="10" width="100%">
<tr>
  <th>Product</th>
  <th>Qty</th>
  <th>Price</th>
  <th>Subtotal</th>
</tr>

<?php foreach ($cart as $id => $qty):
  $p = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
  $sub = $p['price'] * $qty;
  $total += $sub;
?>
<tr>
  <td><?= $p['name'] ?></td>
  <td><?= $qty ?></td>
  <td>₹<?= $p['price'] ?></td>
  <td>₹<?= $sub ?></td>
</tr>
<?php endforeach; ?>

<tr>
  <td colspan="3"><b>Total</b></td>
  <td><b>₹<?= $total ?></b></td>
</tr>
</table>

<form method="post" action="place_order.php" style="margin-top:20px">
  <button class="btn">Place Order</button>
</form>
</div>

<?php include 'footer.php'; ?>
