<?php
include 'config/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $email = $conn->real_escape_string($_POST['email']);
  $password = $_POST['password'];
  $role = $_POST['role']; // USER or ADMIN

  $res = $conn->query("SELECT * FROM users WHERE email='$email'");
  $user = $res->fetch_assoc();

  if ($user && password_verify($password, $user['password'])) {

    // ROLE CHECK (IMPORTANT)
    if ($user['role'] !== $role) {
      $error = "You are not authorized to login as $role";
    } else {

      // Session
      $_SESSION['uid'] = $user['id'];
      $_SESSION['user'] = $user['name'];
      $_SESSION['role'] = $user['role'];

      // Redirect based on role
      if ($role === 'ADMIN') {
        header("Location: admin/dashboard.php");
      } else {
        header("Location: index.php");
      }
      exit;
    }

  } else {
    $error = "Invalid email or password";
  }
}
?>

<?php include 'header.php'; ?>

<div class="login-page">
  <div class="login-box">

    <h2>Welcome Back</h2>
    <p class="subtitle">Login to Smart AI Clothing</p>

    <?php if ($error): ?>
      <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="post">

      <div class="input-group">
        <label>Email</label>
        <input type="email" name="email" required>
      </div>

      <div class="input-group">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>

      <div class="input-group">
        <label>Login As</label>
        <select name="role" required>
          <option value="USER">User</option>
          <option value="ADMIN">Admin</option>
        </select>
      </div>

      <button class="login-btn">Login</button>

    </form>

    <p class="signup-text">
      Don’t have an account?
      <a href="signup.php">Signup</a>
    </p>

  </div>
</div>


<?php include 'footer.php'; ?>