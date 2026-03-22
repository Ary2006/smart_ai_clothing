<?php
include 'header.php';
include 'config/db.php';

$user_id = $_SESSION['uid'] ?? 0;

$res = $conn->query("
  SELECT o.*, p.name, p.image 
  FROM orders o
  JOIN products p ON o.product_id = p.id
  WHERE o.user_id = $user_id
  ORDER BY o.id DESC
");
?>

<div class="container">
  <h2>📦 Your Orders</h2>

  <?php while($o = $res->fetch_assoc()): ?>
    <div class="order-item">
      <img src="uploads/products/<?= $o['image'] ?>">
      <div>
        <h4><?= $o['name'] ?></h4>
        <p>Qty: <?= $o['quantity'] ?></p>
        <small><?= $o['created_at'] ?></small>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<?php include 'footer.php'; ?>