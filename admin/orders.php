<?php
include '../config/db.php';
include '../config/auth.php';
adminOnly();
?>

<?php include '../header.php'; ?>

<div class="container">
<h2>📦 All Orders</h2>

<table border="1" cellpadding="10" width="100%">
<tr>
  <th>Order ID</th>
  <th>User ID</th>
  <th>Total</th>
  <th>Status</th>
  <th>Date</th>
</tr>

<?php
$res = $conn->query("SELECT * FROM orders ORDER BY id DESC");
while ($o = $res->fetch_assoc()):
?>
<tr>
  <td><?= $o['id'] ?></td>
  <td><?= $o['user_id'] ?></td>
  <td>₹<?= $o['total_amount'] ?></td>
  <td><?= $o['status'] ?></td>
  <td><?= $o['order_date'] ?></td>
</tr>
<?php endwhile; ?>
</table>
</div>

<?php include '../footer.php'; ?>
