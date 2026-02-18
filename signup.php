<?php
include 'config/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Gmail-only validation
    if (!str_ends_with($_POST['email'], '@gmail.com')) {
        $error = "Only Gmail addresses are allowed";
    } else {

        $name   = $conn->real_escape_string($_POST['name']);
        $email  = $conn->real_escape_string($_POST['email']);
        $age    = (int)$_POST['age'];
        $gender = $conn->real_escape_string($_POST['gender']);
        $pass   = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name,email,password,age,gender)
                VALUES ('$name','$email','$pass',$age,'$gender')";

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
  <div class="card" style="max-width:400px;margin:40px auto">
    <h3>Signup</h3>

    <?php if($error): ?>
      <p style="color:red"><?= $error ?></p>
    <?php endif; ?>

    <form method="post">
      <input name="name" placeholder="Name" required><br><br>
      <input name="email" placeholder="Gmail address" required><br><br>
      <input type="password" name="password" placeholder="Password" required><br><br>
      <input type="number" name="age" placeholder="Age"><br><br>

      <select name="gender">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select><br><br>

      <button class="btn">Create Account</button>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>
