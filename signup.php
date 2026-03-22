<?php
include 'config/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // Get values
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $phone = $conn->real_escape_string($_POST['phone']);
  $age = $_POST['age'];
  $gender = $_POST['gender'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  // Hash password
  $pass = password_hash($password, PASSWORD_DEFAULT);

  // ================= VALIDATION =================

  if (empty($name) || empty($email) || empty($password) || empty($phone) || empty($age) || empty($gender)) {
      $error = "All fields are required";
  } elseif (!str_ends_with($email, '@gmail.com')) {
      $error = "Only Gmail addresses are allowed";
  } elseif ($password !== $confirm_password) {
      $error = "Passwords do not match";
  } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
      $error = "Phone number must be exactly 10 digits";
  } elseif ($age < 1 || $age > 120) {
      $error = "Enter a valid age";
  } elseif (!in_array($gender, ['Male', 'Female', 'Other'])) {
      $error = "Invalid gender selected";
  }

  // ================= INSERT =================

  if (empty($error)) {

      $query = "INSERT INTO users 
      (name, email, password, phone, age, gender, role) 
      VALUES 
      ('$name', '$email', '$pass', '$phone', '$age', '$gender', 'USER')";

      if ($conn->query($query)) {
          header("Location: login.php");
          exit;
      } else {
          $error = "Email already exists";
      }
  }
}
?>

<?php include 'header.php'; ?>

<div class="container">
  <div style="max-width:400px;margin:40px auto">
    <h3>Signup</h3>

    <?php if ($error): ?>
      <p style="color:red"><?= $error ?></p>
    <?php endif; ?>

    <div class="login-page">
      <div class="login-box">

        <h2>Create Account</h2>
        <p class="subtitle">Join Smart AI Clothing</p>

        <form method="post">

          <div class="input-group">
            <label>Name</label>
            <input name="name" required>
          </div>

          <div class="input-group">
            <label>Email (Gmail only)</label>
            <input type="email" name="email" required>
          </div>

          <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" required>
          </div>

          <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>
          </div>

          <div class="input-group">
            <label>Phone</label>
            <input type="text" name="phone" maxlength="10" pattern="[0-9]{10}" required>
          </div>

          <div class="input-group">
            <label>Age</label>
            <input type="number" name="age" min="1" max="120" required>
          </div>

          <div class="input-group">
            <label>Gender</label>
            <select name="gender" required>
              <option value="">Select Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <button class="login-btn">Create Account</button>

        </form>

        <p class="signup-text">
          Already have an account?
          <a href="login.php">Login</a>
        </p>

      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>