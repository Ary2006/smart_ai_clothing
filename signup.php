<?php
include 'config/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!str_ends_with($_POST['email'], '@gmail.com')) {
        $error = "Only Gmail addresses are allowed";
    }

    elseif ($_POST['password'] !== $_POST['confirm_password']) {
        $error = "Passwords do not match";
    }

    else {
        $name  = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name,email,password,phone)
                VALUES ('$name','$email','$pass','$phone')";

        if ($conn->query($sql)) {
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

        <?php if ($error): ?>
          <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form method="post">

          <div class="input-group">
            <label>Full Name</label>
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
            <label>Phone (optional)</label>
            <input type="text" name="phone">
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