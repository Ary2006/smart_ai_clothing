<?php
include 'header.php';
include 'config/db.php';

if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['uid'];
$res = $conn->query("SELECT * FROM orders WHERE user_id=$uid ORDER BY id DESC");
?>

<div class="container">
<h2>📦 My Orders</h2>

<?php while ($o = $res->fetch_assoc()): ?>
<div class="card" style="margin-bottom:15px">
  <p><b>Order ID:</b> <?= $o['id'] ?></p>
  <p><b>Total:</b> ₹<?= $o['total_amount'] ?></p>
  <p><b>Status:</b> <?= $o['status'] ?></p>
  <p><b>Date:</b> <?= $o['order_date'] ?></p>
</div>
<?php endwhile; ?>
</div>

<?php include 'footer.php'; ?>
