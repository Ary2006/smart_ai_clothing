<?php
include 'header.php';
include 'config/db.php';

$gender = $_GET['g'] ?? '';
$gender = $conn->real_escape_string($gender);
?>

<div class="container">
  <h2><?= $gender ?> Collection</h2>

  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px">

  <?php
  $res = $conn->query("SELECT * FROM products WHERE gender='$gender'");
  while ($p = $res->fetch_assoc()):
  ?>

    <div class="card">

      <!-- IMAGE CLICK -->
      <a href="product.php?id=<?= $p['id'] ?>">
        <img 
          src="uploads/products/<?= $p['image'] ?>" 
          style="width:100%;height:200px;object-fit:cover"
        >
      </a>

      <!-- NAME CLICK -->
      <h4>
        <a href="product.php?id=<?= $p['id'] ?>" style="text-decoration:none;color:black">
          <?= $p['name'] ?>
        </a>
      </h4>

      <p>₹<?= $p['price'] ?></p>
      <p>Color: <?= $p['color'] ?></p>

    </div>

  <?php endwhile; ?>

  </div>
</div>

<?php include 'footer.php'; ?>
