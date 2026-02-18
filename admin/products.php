<?php
include '../config/db.php';
include '../config/auth.php';
adminOnly();
?>

<?php include '../header.php'; ?>

<div class="container">
  <h2>📦 Product Management</h2>

  <div style="margin-bottom:20px">
    <a href="add_product.php"><button class="btn">➕ Add Product</button></a>
    <a href="bulk_upload.php"><button class="btn">📄 Bulk Upload</button></a>
  </div>

  <table border="1" cellpadding="10" width="100%">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Price</th>
      <th>Gender</th>
      <th>Action</th>
    </tr>

    <?php
    $res = $conn->query("SELECT * FROM products ORDER BY id DESC");
    while ($p = $res->fetch_assoc()):
    ?>
    <tr>
      <td><?= $p['id'] ?></td>
      <td><?= $p['name'] ?></td>
      <td>₹<?= $p['price'] ?></td>
      <td><?= $p['gender'] ?></td>
      <td>
  <a href="edit_product.php?id=<?= $p['id'] ?>">Edit</a> |
  <a href="delete_product.php?id=<?= $p['id'] ?>" style="color:red">Delete</a>
</td>

    </tr>
    <?php endwhile; ?>
  </table>
</div>

<?php include '../footer.php'; ?>
