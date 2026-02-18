<?php
include '../config/db.php';
include '../config/auth.php';
adminOnly();

$id = (int)$_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if (!$product) {
    echo "Product not found";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name   = $_POST['name'];
    $price  = $_POST['price'];
    $color  = $_POST['color'];
    $gender = $_POST['gender'];

    if (!empty($_FILES['image']['name'])) {
        $img = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/products/$img");

        $conn->query("
          UPDATE products 
          SET name='$name', price=$price, color='$color', gender='$gender', image='$img'
          WHERE id=$id
        ");
    } else {
        $conn->query("
          UPDATE products 
          SET name='$name', price=$price, color='$color', gender='$gender'
          WHERE id=$id
        ");
    }

    header("Location: products.php");
    exit;
}
?>

<?php include '../header.php'; ?>

<div class="container">
  <h2>✏️ Edit Product</h2>

  <div class="card" style="max-width:500px">
    <form method="post" enctype="multipart/form-data">

      <label>Name</label>
      <input type="text" name="name" value="<?= $product['name'] ?>" required>

      <br><br>

      <label>Price</label>
      <input type="number" name="price" value="<?= $product['price'] ?>" required>

      <br><br>

      <label>Color</label>
      <input type="text" name="color" value="<?= $product['color'] ?>">

      <br><br>

      <label>Gender</label>
      <select name="gender">
        <option <?= $product['gender']=='MEN'?'selected':'' ?>>MEN</option>
        <option <?= $product['gender']=='WOMEN'?'selected':'' ?>>WOMEN</option>
        <option <?= $product['gender']=='KIDS'?'selected':'' ?>>KIDS</option>
      </select>

      <br><br>

      <label>Change Image (optional)</label>
      <input type="file" name="image">

      <br><br>

      <button class="btn">Update Product</button>
    </form>
  </div>
</div>

<?php include '../footer.php'; ?>
