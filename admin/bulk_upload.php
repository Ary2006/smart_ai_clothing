<?php
include '../config/db.php';
include '../config/auth.php';
adminOnly();

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if ($_FILES['csv']['error'] !== 0) {
        $msg = "File upload error";
    } else {

        $file = fopen($_FILES['csv']['tmp_name'], "r");

        // Read header
        $header = fgetcsv($file);
        $expected = ['name','description','price','rating','image','gender','age_group','color','size','on_offer'];

        if ($header !== $expected) {
            die("CSV header format is incorrect");
        }

        while (($row = fgetcsv($file)) !== false) {

            [
              $name, $desc, $price, $rating, $image,
              $gender, $age_group, $color, $size, $offer
            ] = $row;

            // Sanitize
            $name  = $conn->real_escape_string($name);
            $desc  = $conn->real_escape_string($desc);
            $image = $conn->real_escape_string($image);
            $gender = strtoupper($gender);
            $color = $conn->real_escape_string($color);

            $sql = "
            INSERT INTO products
            (name, description, price, rating, image, gender, age_group, color, size, on_offer)
            VALUES
            ('$name','$desc',$price,$rating,'$image','$gender','$age_group','$color','$size',$offer)
            ON DUPLICATE KEY UPDATE
              price=VALUES(price),
              rating=VALUES(rating),
              color=VALUES(color),
              image=VALUES(image),
              on_offer=VALUES(on_offer)
            ";

            $conn->query($sql);
        }

        fclose($file);
        $msg = "CSV upload successful";
    }
}
?>

<?php include '../header.php'; ?>

<div class="container">
  <div class="card" style="max-width:500px;margin:40px auto">
    <h3>Bulk Upload Products (CSV)</h3>

    <?php if($msg): ?>
      <p style="color:green"><?= $msg ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <input type="file" name="csv" accept=".csv" required><br><br>
      <button class="btn">Upload CSV</button>
    </form>

    <p style="font-size:13px;color:#555;margin-top:10px">
      Images must already exist in <b>uploads/products/</b>
    </p>
  </div>
</div>

<?php include '../footer.php'; ?>
