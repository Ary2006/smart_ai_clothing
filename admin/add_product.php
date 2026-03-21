<?php
include '../config/db.php';
include '../config/auth.php';

// 1. Security Check
adminOnly();

include 'header.php';

$msg = "";
$error = "";

// 2. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Get data from form
  $name = $_POST['name'];
  $price = $_POST['price'];
  $color = $_POST['color'];
  $gender = $_POST['gender']; // 'MEN', 'WOMEN', 'KIDS'

  // Set Default Values for missing database fields
  $description = "New arrival: " . $name;
  $rating = 4.5;
  $age_group = "Adult"; // Default
  $size = "M";          // Default
  $on_offer = 0;

  // Handle Image Upload
  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $targetDir = "../uploads/products/";

    // Create folder if missing
    if (!file_exists($targetDir)) {
      mkdir($targetDir, 0777, true);
    }

    $fileName = time() . "_" . basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow only images
    $allowTypes = array('jpg', 'png', 'jpeg', 'webp');
    if (in_array(strtolower($fileType), $allowTypes)) {
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {

        // 3. Insert into Database
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, rating, image, gender, age_group, color, size, on_offer, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

        // Bind params (s=string, d=double, i=integer)
        $stmt->bind_param("ssddsssssi", $name, $description, $price, $rating, $fileName, $gender, $age_group, $color, $size, $on_offer);

        if ($stmt->execute()) {
          $_SESSION['toast'] = [
            "message" => "Product added successfully",
            "type" => "success"
          ];
          header("Location: dashboard.php");
          exit;
        } else {
          $error = "Database Error: " . $stmt->error;
        }
      } else {
        $error = "Failed to upload image.";
      }
    } else {
      $error = "Only JPG, JPEG, PNG, & WEBP files are allowed.";
    }
  } else {
    $error = "Please select an image.";
  }
}
?>

<style>
  .container {
    max-width: 600px;
    margin: 40px auto;
  }

  .admin-title {
    text-align: center;
    margin-bottom: 20px;
    color: #fff;
  }

  .card.admin-form {
    background: #222;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
    color: #fff;
    border: 1px solid #333;
  }

  .form-group {
    margin-bottom: 15px;
  }

  .form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    color: #ccc;
  }

  .form-group input,
  .form-group select {
    width: 100%;
    padding: 10px 12px;
    border-radius: 6px;
    border: 1px solid #444;
    background: #333;
    color: #fff;
    font-size: 14px;
  }

  .form-group input[type="file"] {
    padding: 6px;
    background: none;
    border: none;
  }

  .btn-primary {
    width: 100%;
    padding: 12px;
    background: #0d6efd;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 10px;
  }

  .btn-primary:hover {
    background: #0b5ed7;
  }

  .alert {
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
    text-align: center;
  }

  .alert-success {
    background: #d1e7dd;
    color: #0f5132;
  }

  .alert-danger {
    background: #f8d7da;
    color: #842029;
  }
</style>

<div class="container">
  <h2 class="admin-title">➕ Add Product</h2>

  <?php if ($msg): ?>
    <div class="alert alert-success"><?php echo $msg; ?></div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
  <?php endif; ?>

  <div class="card admin-form">
    <form method="post" enctype="multipart/form-data">

      <div class="form-group">
        <label>Product Name</label>
        <input type="text" name="name" required placeholder="e.g. Red Summer Dress">
      </div>

      <div class="form-group">
        <label>Price (₹)</label>
        <input type="number" step="0.01" name="price" required placeholder="e.g. 800">
      </div>

      <div class="form-group">
        <label>Color</label>
        <input type="text" name="color" placeholder="e.g. Red">
      </div>

      <div class="form-group">
        <label>Gender</label>
        <select name="gender">
          <option value="Male">Men</option>
          <option value="Female">Women</option>
          <option value="Kids">Kids</option>
        </select>
      </div>

      <div class="form-group">
        <label>Product Image</label>
        <input type="file" name="image" required>
      </div>

      <button type="submit" class="btn-primary">Add Product</button>
      <a href="dashboard.php"
        style="display:block; text-align:center; margin-top:15px; color:#aaa; text-decoration:none;">Cancel</a>

    </form>
  </div>
</div>