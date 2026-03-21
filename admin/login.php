<?php
include '../config/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $email = $conn->real_escape_string($_POST['email']);
  $password = $_POST['password'];

  $res = $conn->query("SELECT * FROM users WHERE email='$email' AND role='ADMIN'");
  $admin = $res->fetch_assoc();

  if ($admin && password_verify($password, $admin['password'])) {

    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_name'] = $admin['name'];
    $_SESSION['role'] = 'ADMIN';

    $_SESSION['toast'] = "Welcome back!";

    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Invalid admin credentials";
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Admin Login</title>
  <link rel="stylesheet" href="../css/common.css">
</head>

<body>

  <div class="container">
    <div class="card" style="max-width:400px;margin:80px auto;">
      <h2 style="text-align:center">🔐 Admin Login</h2>

      <?php if ($error): ?>
        <p style="color:red;text-align:center"><?= $error ?></p>
      <?php endif; ?>

      <form method="post">

        <label>Email</label>
        <input type="email" name="email" required>

        <br><br>

        <label>Password</label>
        <input type="password" name="password" required>

        <br><br>

        <button class="btn" style="width:100%">Login</button>
      </form>
    </div>
  </div>

</body>

</html>