<?php
include 'config/db.php';

if (!isset($_SESSION['uid'])) {
    exit;
}

$cart = $_SESSION['cart'] ?? [];

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=SmartAI_Clothing_Bill.html");

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Invoice</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    h2 { text-align:center; }
    table { width:100%; border-collapse: collapse; margin-top:20px; }
    th, td { border:1px solid #ccc; padding:10px; text-align:left; }
    th { background:#f1f1f1; }
  </style>
</head>
<body>

<h2>Smart AI Clothing Store</h2>
<p><b>Customer:</b> <?= $_SESSION['user'] ?></p>
<p><b>Date:</b> <?= date("d-m-Y") ?></p>

<table>
<tr>
  <th>Product</th>
  <th>Price</th>
  <th>Qty</th>
  <th>Subtotal</th>
</tr>

<?php foreach ($cart as $id => $qty):
  $p = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
  $sub = $p['price'] * $qty;
  $total += $sub;
?>
<tr>
  <td><?= $p['name'] ?></td>
  <td>₹<?= $p['price'] ?></td>
  <td><?= $qty ?></td>
  <td>₹<?= $sub ?></td>
</tr>
<?php endforeach; ?>

<tr>
  <td colspan="3"><b>Total</b></td>
  <td><b>₹<?= $total ?></b></td>
</tr>

</table>

<p style="margin-top:30px;text-align:center">
  Thank you for shopping with Smart AI Clothing!
</p>

</body>
</html>
