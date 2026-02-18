<?php
include 'header.php';
include 'config/db.php';

$q = $_GET['q'] ?? '';
$q = $conn->real_escape_string($q);
?>

<div class="container">
  <h3>Search Results for "<?= htmlspecialchars($q) ?>"</h3>

  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px">

  <?php
  $res = $conn->query("SELECT * FROM products WHERE name LIKE '%$q%'");
  while ($p = $res->fetch_assoc()):
  ?>

    <div class="card">

      <a href="product.php?id=<?= $p['id'] ?>">
        <img 
          src="uploads/products/<?= $p['image'] ?>" 
          style="width:100%;height:200px;object-fit:cover"
        >
      </a>

      <h4>
        <a href="product.php?id=<?= $p['id'] ?>" style="text-decoration:none;color:black">
          <?= $p['name'] ?>
        </a>
      </h4>

      <p>₹<?= $p['price'] ?></p>

    </div>

  <?php endwhile; ?>

  </div>
</div>

<?php include 'footer.php'; ?>
